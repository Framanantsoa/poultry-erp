import { BeforeInsert, BeforeUpdate, Column, Entity, PrimaryGeneratedColumn } from "typeorm";
import { SoftDeletableEntity } from "../common/deletable.entity.js";
import * as bcrypt from "bcrypt";

@Entity('users')
export class User extends SoftDeletableEntity
{
    @PrimaryGeneratedColumn({type:'bigint', name:'user_id'})
    id: string;

    @Column({type:'varchar', length:50})
    last_name: string;

    @Column({type:'varchar', length:50})
    first_name: string;

    @Column({type:'varchar', length:50, nullable:true, unique:true})
    email: string | null;

    @Column({type:'varchar', length:20, nullable:true})
    phone: string | null;

    @Column({type:'varchar', length:10, unique:true})
    employee_id: string;

    @Column({type:'varchar', length:250})
    hashed_password: string;

    // not persisted
    password?: string;


    @BeforeInsert()
    @BeforeUpdate()
    async hashPassword() {
        if (this.password) {
            this.hashed_password = await bcrypt.hash(this.password, 10);
            this.password = undefined;
        }
    }
}
