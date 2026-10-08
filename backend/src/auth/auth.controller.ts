import { Body, Controller, Get, Post, Req, UseGuards } from '@nestjs/common';
import { AuthService } from './auth.service.js';
import { AuthGuard } from '@nestjs/passport';
import { LoginDTO } from './dto/login.dto.js';

@Controller('auth')
export class AuthController 
{
    constructor(private readonly authService: AuthService) {}

    @Post('login')
    async login(@Body() dto: LoginDTO) {
        const user = await this.authService.validateUser(dto.employeeId, dto.password);
        return await this.authService.login(user);
    }


    @UseGuards(AuthGuard('jwt'))
    @Get('me')
    getCurrentUser(@Req() req: any) {
        return req.user;
    }
}
