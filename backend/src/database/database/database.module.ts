import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { config } from 'dotenv';

config(); // Cargar variables de entorno desde .env
@Module({

    imports:[
        TypeOrmModule.forRoot({
            type: process.env.TYPE as any,
            host: process.env.HOST as any,
            port: process.env.PORT as any,
            username: process.env.USERNAME_PG as any,
            password: process.env.PASSWORD as any,
            database: process.env.DATABASE as any,
            entities: [__dirname + '../entities/**/*.entity{.ts,.js}'],
            logging: true, // Activar para ver las consultas SQL en la consola
            synchronize: false, // NUNCA activar en producción con una BD existente
        }),
    ]

})
export class DatabaseModule {}
