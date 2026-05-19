<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Creating/Resetting Super Admin ===\n";

$email = 'admin@elevatech.com';
$password = '12345678';

$user = User::where('email', $email)->first();

if ($user) {
    $user->update([
        'password' => Hash::make($password),
        'role' => 'admin',
        'is_admin' => true,
    ]);
    echo "Existing admin updated.\n";
} else {
    $user = User::create([
        'name' => 'Admin',
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin',
        'is_admin' => true,
    ]);
    echo "New admin created.\n";
}

echo "Admin Account Ready:\n";
echo "Email: $email\n";
echo "Password: $password\n";
