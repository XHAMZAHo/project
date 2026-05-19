<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== Projects Table Columns ===\n";
$cols = Schema::getColumnListing('projects');
echo implode(', ', $cols) . "\n\n";

echo "=== Sample Projects ===\n";
DB::table('projects')->select('id','title','status','image','is_featured')->get()->each(function($p){
    echo "ID:{$p->id} | {$p->title} | status:{$p->status} | image:{$p->image}\n";
});
