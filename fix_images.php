<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// High-quality Unsplash images for missing portfolio projects
$imageUpdates = [
    6 => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=85',  // Education/learning platform
    7 => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&q=85',  // Healthcare/medical
    8 => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&q=85',     // SaaS analytics dashboard
];

echo "=== Updating project images ===\n";
foreach ($imageUpdates as $id => $url) {
    DB::table('projects')->where('id', $id)->update(['image' => $url]);
    $p = DB::table('projects')->find($id);
    echo "✅ ID:{$id} | {$p->title} → image updated\n";
}

echo "\n✨ Done!\n";
