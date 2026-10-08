import {
    BaseEntity as TypeOrmBaseEntity, CreateDateColumn, UpdateDateColumn
} from 'typeorm';


export abstract class BaseEntity extends TypeOrmBaseEntity 
{
    @CreateDateColumn({ type: 'timestamp' })
    created_at: Date;

    @UpdateDateColumn({ type: 'timestamp' })
    updated_at: Date;
}
