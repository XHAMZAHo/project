<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \App\Models\User::select('id','name','email','role','is_admin')->get();
foreach($users as $u){
    echo $u->id.' | '.$u->email.' | role:'.$u->role.' | is_admin:'.(int)$u->is_admin.PHP_EOL;
}
echo 'Total: '.$users->count().PHP_EOL;
