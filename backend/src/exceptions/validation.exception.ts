import { BadRequestException, HttpStatus } from '@nestjs/common';

export class ValidationException extends BadRequestException {
    constructor(public readonly errors: Record<string, string>) {
        super({ message: 'Validation failed', errors }, 'Validation failed');
    }

    getStatus(): number {
        return HttpStatus.UNPROCESSABLE_ENTITY; // 422
    }
}
