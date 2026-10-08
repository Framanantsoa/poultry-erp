import {
  ExceptionFilter, Catch, ArgumentsHost,
  HttpException, HttpStatus, Logger,
} from '@nestjs/common';
import { Request, Response } from 'express';

@Catch()
export class AllExceptionsFilter implements ExceptionFilter {
    private readonly logger = new Logger(AllExceptionsFilter.name);

    catch(exception: unknown, host: ArgumentsHost) {
        const ctx = host.switchToHttp();
        const response = ctx.getResponse<Response>();
        const request = ctx.getRequest<Request>();

        let status = HttpStatus.INTERNAL_SERVER_ERROR;
        let errors: string[] = ['Internal server error'];

        if (exception instanceof HttpException) {
            status = exception.getStatus();
            const res = exception.getResponse();

            // Cas 1 : notre ValidationException personnalisée
            if (
                typeof res === 'object' &&
                res !== null &&
                'errors' in res &&
                typeof (res as any).errors === 'object' &&
                !Array.isArray((res as any).errors)
            ) {
                errors = (res as any).errors;
            }
            // Cas 2 : réponse standard NestJS (string ou { message })
            else if (typeof res === 'string') {
                errors = [res];
            } 
            else if (typeof res === 'object' && res !== null) {
                const msg = (res as any).message;
                errors = Array.isArray(msg) ? msg : [msg ?? exception.message];
            }
        }
        // Cas 3 : erreur non-HTTP
        else if (exception instanceof Error) {
            this.logger.error(exception.message, exception.stack);
            if (process.env.NODE_ENV !== 'production') {
                errors = [exception.message];
            }
        }

        response.status(status).json({
            success: false,
            data: null,
            errors: errors,
        });
    }
}
