import { Injectable, UnauthorizedException } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { User } from '../users/user.entity.js';
import * as bcrypt from 'bcrypt';

@Injectable()
export class AuthService 
{
    constructor(
        @InjectRepository(User)
        private readonly usersRepo: Repository<User>,
        private readonly jwtService: JwtService,
    ) {}


    async validateUser(employeeId: string, password: string): Promise<User> {
        const user = await this.usersRepo.findOne({
            where: { employee_id: employeeId },
            select: ['id', 'employee_id', 'hashed_password', 'first_name', 'last_name'],
        });

        if(!user) {
            throw new UnauthorizedException('Invalid ID or password');
        }

        const ok = await bcrypt.compare(password, user.hashed_password);
        if(!ok) {
            throw new UnauthorizedException('Invalid ID or password');
        }

        return user;
    }

    async login(user: User) {
        const payload = { sub: user.id, employeeId: user.employee_id };
        return {
            accessToken: await this.jwtService.signAsync(payload),
        };
    }
}
