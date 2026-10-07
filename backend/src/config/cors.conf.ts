import 'dotenv/config';
import type { CorsOptions } from '@nestjs/common/interfaces/external/cors-options.interface';

export const corsConfig = (): CorsOptions => {
    const rawOrigins = process.env.CORS_ORIGIN ?? 'http://localhost:3000';
    const origins = rawOrigins.split(',').map((o) => o.trim()).filter(Boolean);

    return {
        origin: origins,
        methods: ['GET', 'HEAD', 'PUT', 'PATCH', 'POST', 'DELETE', 'OPTIONS'],
        allowedHeaders: ['Content-Type', 'Authorization', 'Accept'],
        credentials: true,
        maxAge: 86400,
    };
};
