import 'reflect-metadata';
import 'dotenv/config';
import * as bcrypt from 'bcrypt';
import { AppDataSource } from '../src/database/data-source.js';
import { User } from '../src/users/user.entity.js';

const FIRST_NAMES = ['Alice', 'Bob', 'Carol', 'David', 'Eve', 'Frank', 'Grace', 'Hugo', 'Iris', 'Jack'];
const LAST_NAMES = ['Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon'];

async function seed() {
    await AppDataSource.initialize();
    const repo = AppDataSource.getRepository(User);

    const hashedPassword = await bcrypt.hash('password123', 10);

    const users = FIRST_NAMES.map((firstName, i) => {
        const lastName = LAST_NAMES[i];
        const idx = String(i + 1).padStart(3, '0');
        return repo.create({
            employee_id: `EMP${idx}`,
            first_name: firstName,
            last_name: lastName,
            email: `${firstName.toLowerCase()}.${lastName.toLowerCase()}@example.com`,
            phone: null,
            hashed_password: hashedPassword,
        });
    });

    await repo.save(users);
    console.log(`Seeded ${users.length} users`);

    await AppDataSource.destroy();
}

seed().catch((err) => {
    console.error('Seed failed:', err);
    process.exit(1);
});
