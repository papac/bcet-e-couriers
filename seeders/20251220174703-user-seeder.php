<?php

use App\Models\User;
use Faker\Factory as FakerFactory;

class UserSeeder20251220174703
{
    public function run()
    {
        $admin = User::where('email', 'admin@bcet.ci')->first();

        if (!$admin) {
            User::create([
                'name' => 'Administrateur',
                'email' => 'admin@bcet.ci',
                'phone' => '+225 0000000000',
                'password' => app_hash('password123'),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $faker = FakerFactory::create();

        foreach (range(1, 5) as $value) {
            $user = [
                'name' => $faker->name,
                'description' => $faker->text(100),
                'email' => $faker->email,
                'password' => app_hash('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            User::create($user);
        }
    }
}
