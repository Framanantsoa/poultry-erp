import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module.js';
import { corsConfig } from './config/cors.conf.js';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);

  app.enableCors(corsConfig());
  app.setGlobalPrefix('api'); // optional

  const port = process.env.PORT ?? 3000;
  await app.listen(port);
  console.log(`Server listening on http://localhost:${port}`);
}
await bootstrap();
