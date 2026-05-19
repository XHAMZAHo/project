<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// First let's see all users and their current password hashes
echo "=== Current Users in DB ===\n";
User::all(['id','name','email','role','is_admin','password'])->each(function($u) {
    echo "ID:{$u->id} | {$u->email} | role:{$u->role} | is_admin:{$u->is_admin} | pass_start:".substr($u->password,0,10)."\n";
});

echo "\n=== Fixing Admin Password ===\n";

// Delete old admin if exists and recreate cleanly
$existing = User::where('email', 'admin@elevatech.com')->first();

if ($existing) {
    // Force update using DB directly to avoid any model hooks
    \Illuminate\Support\Facades\DB::table('users')
        ->where('email', 'admin@elevatech.com')
        ->update([
            'password'           => Hash::make('Admin2026'),
            'role'               => 'admin',
            'is_admin'           => 1,
            'email_verified_at'  => now(),
        ]);
    echo "✅ Password updated via DB query\n";
    
    // Verify
    $check = User::where('email', 'admin@elevatech.com')->first();
    $match = Hash::check('Admin2026', $check->password);
    echo "   Password match test: " . ($match ? "✅ PASS" : "❌ FAIL") . "\n";
    echo "   role: {$check->role}\n";
    echo "   is_admin: {$check->is_admin}\n";
} else {
    echo "User not found, creating...\n";
    $new = User::create([
        'name'               => 'ELEVA TECH Admin',
        'email'              => 'admin@elevatech.com',
        'password'           => Hash::make('Admin2026'),
        'role'               => 'admin',
        'is_admin'           => true,
        'email_verified_at'  => now(),
    ]);
    echo "✅ Created admin: {$new->email}\n";
}

echo "\n📌 Login credentials:\n";
echo "   Email:    admin@elevatech.com\n";
echo "   Password: Admin2026\n";
