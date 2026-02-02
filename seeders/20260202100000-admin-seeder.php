<?php

use Bow\Database\Database;

$table = 'users';

// Check if admin exists
$admin = Database::table($table)->where('email', 'admin@bcet.ci')->first();

if (!$admin) {
    Database::table($table)->insert([
        'name' => 'Administrateur',
        'email' => 'admin@bcet.ci',
        'phone' => '+225 0000000000',
        'password' => bow_hash('password123'),
        'role' => 'admin',
        'is_active' => true,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    
    echo "Admin user created successfully!\n";
    echo "Email: admin@bcet.ci\n";
    echo "Password: password123\n";
} else {
    echo "Admin user already exists.\n";
}
