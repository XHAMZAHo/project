<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::all(['id', 'name', 'email', 'role', 'is_admin']);
foreach ($users as $u) {
    echo "ID: {$u->id} | Name: {$u->name} | Email: {$u->email} | Role: {$u->role} | IsAdmin: {$u->is_admin}\n";
}
