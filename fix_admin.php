<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "=== Fixing Admin User ===\n\n";

// Update admin@elevatech.com
$updated = DB::table('users')
    ->where('email', 'admin@elevatech.com')
    ->update([
        'password' => Hash::make('Admin@2026!'),
        'role'     => 'admin',
        'is_admin' => true,
        'email_verified_at' => now(),
        'updated_at' => now(),
    ]);

if ($updated) {
    echo "admin@elevatech.com updated:\n";
    echo "  Password: Admin@2026!\n";
    echo "  Role: admin\n";
    echo "  is_admin: 1\n";
    echo "  email_verified_at: now\n";
} else {
    echo "User not found! Creating admin...\n";
    DB::table('users')->insert([
        'name'              => 'ELEVA Admin',
        'email'             => 'admin@elevatech.com',
        'password'          => Hash::make('Admin@2026!'),
        'role'              => 'admin',
        'is_admin'          => true,
        'email_verified_at' => now(),
        'created_at'        => now(),
        'updated_at'        => now(),
    ]);
    echo "New admin created.\n";
}

// Show all users
echo "\nAll users:\n";
$users = DB::table('users')->get(['id','name','email','role','is_admin','email_verified_at']);
foreach($users as $u) {
    echo "  [{$u->id}] {$u->email} | role:{$u->role} | is_admin:{$u->is_admin} | verified:".($u->email_verified_at ? 'yes' : 'NO')."\n";
}

echo "\nDone! Login at: http://127.0.0.1:8000/login\n";
echo "Email: admin@elevatech.com\nPassword: Admin@2026!\n";
