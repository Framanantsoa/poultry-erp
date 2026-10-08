import { Strategy } from 'passport-local';
import { PassportStrategy } from '@nestjs/passport';
import { Injectable, UnauthorizedException } from '@nestjs/common';
import { AuthService } from '../auth.service.js';

@Injectable()
export class LocalStrategy extends PassportStrategy(Strategy) 
{
    constructor(private readonly authService: AuthService) {
        super({ usernameField: 'employeeId', passwordField: 'password' });
    }

    async validate(employeeId: string, password: string) {
        const user = await this.authService.validateUser(employeeId, password);
        if (!user) throw new UnauthorizedException('Invalid credentials');
        return user; // attached to req.user
    }
}
