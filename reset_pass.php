<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'wl@gmail.com')->first();
if ($user) {
    $user->password = bcrypt('12345678');
    $user->save();
    echo "User found! Password reset to: 12345678\n";
} else {
    echo "User not found in the database.\n";
}
