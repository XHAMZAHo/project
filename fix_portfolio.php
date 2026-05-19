<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

echo "=== Adding 'category' column to projects ===\n";

// Add category column if it doesn't exist
if (!Schema::hasColumn('projects', 'category')) {
    Schema::table('projects', function (Blueprint $table) {
        $table->string('category')->default('web')->after('status');
    });
    echo "✅ Column 'category' added\n";
} else {
    echo "⏭️  Column 'category' already exists\n";
}

// Update existing projects with appropriate categories
$updates = [
    1 => 'web',     // متجر إلكتروني متكامل
    2 => 'app',     // تطبيق لياقة بدنية
    3 => 'web',     // منصة عقارات ذكية
    4 => 'app',     // نظام توصيل المطاعم
    5 => 'system',  // نظام إدارة الموارد البشرية
    6 => 'web',     // منصة تعليم إلكتروني
    7 => 'system',  // نظام إدارة العيادات
    8 => 'system',  // منصة SaaS للتحليلات
];

echo "\n=== Updating project categories ===\n";
foreach ($updates as $id => $cat) {
    DB::table('projects')->where('id', $id)->update(['category' => $cat]);
    $p = DB::table('projects')->find($id);
    echo "✅ ID:{$id} | {$p->title} → category:{$cat}\n";
}

echo "\n✨ Done!\n";
