import { DeleteDateColumn } from "typeorm";
import { BaseEntity } from "./base.entity.js";


export abstract class SoftDeletableEntity extends BaseEntity
{
    @DeleteDateColumn({ type: 'timestamp', nullable: true })
    deleted_at: Date | null;
}
