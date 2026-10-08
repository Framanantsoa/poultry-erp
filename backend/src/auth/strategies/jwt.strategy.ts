import { ExtractJwt, Strategy } from 'passport-jwt';
import { PassportStrategy } from '@nestjs/passport';
import { Injectable } from '@nestjs/common';

export interface JwtPayload {
    sub: string;         // user_id (bigint as string)
    employeeId: string;
}

@Injectable()
export class JwtStrategy extends PassportStrategy(Strategy) 
{
    constructor() {
        super({
            jwtFromRequest: ExtractJwt.fromAuthHeaderAsBearerToken(),
            ignoreExpiration: false,
            secretOrKey: process.env.JWT_SECRET!,
        });
    }

    async validate(payload: JwtPayload) {
        // payload is already verified by passport-jwt
        return { userId: payload.sub, employeeId: payload.employeeId };
    }
}
