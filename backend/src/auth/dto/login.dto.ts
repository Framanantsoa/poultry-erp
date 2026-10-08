import { IsNotEmpty, IsString } from "class-validator";

export class LoginDTO 
{
    @IsNotEmpty({ message: "L'identifiant employé est obligatoire" })
    @IsString({ message: "L'identifiant employé doit être une chaîne" })
    employeeId: string;

    @IsNotEmpty({ message: 'Le mot de passe est obligatoire' })
    @IsString({ message: 'Le mot de passe doit être une chaîne' })
    password: string;
}
