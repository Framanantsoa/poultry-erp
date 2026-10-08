import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module.js';
import { corsConfig } from './config/cors.conf.js';
import { ValidationPipe } from '@nestjs/common';
import { ResponseInterceptor } from './common/interceptors/response.interceptor.js';
import { AllExceptionsFilter } from './common/filters/exception.filter.js';
import { ValidationError } from 'class-validator';
import { ValidationException } from './exceptions/validation.exception.js';


function flattenErrors(
  errors: ValidationError[],
  parentPath = '',
): Record<string, string> {
  const result: Record<string, string> = {};

  for (const error of errors) {
    const path = parentPath ? `${parentPath}.${error.property}` : error.property;

    if (error.constraints) {
      // On prend le premier message de contrainte (souvent suffisant)
      const firstMessage = Object.values(error.constraints)[0];
      result[path] = firstMessage;
    }

    if (error.children && error.children.length > 0) {
      Object.assign(result, flattenErrors(error.children, path));
    }
  }

  return result;
}


async function bootstrap() {
  const app = await NestFactory.create(AppModule);

  app.enableCors(corsConfig());
  app.setGlobalPrefix('api'); // optional

  app.useGlobalPipes(new ValidationPipe({
    whitelist: true,   // Supprime les propriétés non déclarées dans le DTO
    forbidNonWhitelisted: true, // Rejette la requête si des propriétés inconnues sont envoyées
    transform: true,     // Transforme automatiquement le payload en instance du DTO
    exceptionFactory: (errors: ValidationError[]) => {
      return new ValidationException(flattenErrors(errors));
    },
  }));

  app.useGlobalInterceptors(new ResponseInterceptor());
  app.useGlobalFilters(new AllExceptionsFilter());

  const port = process.env.PORT ?? 3000;
  await app.listen(port);
  console.log(`Server listening on http://localhost:${port}`);
}
await bootstrap();
