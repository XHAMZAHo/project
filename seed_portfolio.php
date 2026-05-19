<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\Technology;

echo "=== Seeding Portfolio Projects ===\n\n";

// Create technologies if they don't exist
$techs = [
    'Laravel'     => Technology::firstOrCreate(['name' => 'Laravel']),
    'Vue.js'      => Technology::firstOrCreate(['name' => 'Vue.js']),
    'React'       => Technology::firstOrCreate(['name' => 'React']),
    'Flutter'     => Technology::firstOrCreate(['name' => 'Flutter']),
    'MySQL'       => Technology::firstOrCreate(['name' => 'MySQL']),
    'Tailwind'    => Technology::firstOrCreate(['name' => 'Tailwind']),
    'Node.js'     => Technology::firstOrCreate(['name' => 'Node.js']),
    'Next.js'     => Technology::firstOrCreate(['name' => 'Next.js']),
    'Python'      => Technology::firstOrCreate(['name' => 'Python']),
    'React Native'=> Technology::firstOrCreate(['name' => 'React Native']),
    'PostgreSQL'  => Technology::firstOrCreate(['name' => 'PostgreSQL']),
    'AWS'         => Technology::firstOrCreate(['name' => 'AWS']),
];

$projects = [
    [
        'title'       => 'متجر إلكتروني متكامل',
        'client_name' => 'شركة الريادة للتجارة',
        'description' => 'منصة تجارة إلكترونية متكاملة مع نظام إدارة المخزون والمدفوعات الإلكترونية وتتبع الطلبات في الوقت الفعلي. يدعم أكثر من 10,000 منتج مع واجهة سلسة للمستخدم.',
        'image'       => 'portfolio/ecommerce.png',
        'url'         => '#',
        'status'      => 'completed',
        'is_featured' => true,
        'techs'       => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind'],
    ],
    [
        'title'       => 'تطبيق لياقة بدنية',
        'client_name' => 'FitLife Arabia',
        'description' => 'تطبيق جوال متكامل لتتبع اللياقة البدنية والتغذية مع خطط تمرين مخصصة بالذكاء الاصطناعي، ومتابعة يومية للأهداف الصحية.',
        'image'       => 'portfolio/mobile_app.png',
        'url'         => '#',
        'status'      => 'completed',
        'is_featured' => true,
        'techs'       => ['Flutter', 'Node.js', 'MySQL'],
    ],
    [
        'title'       => 'منصة عقارات ذكية',
        'client_name' => 'دار الخليج العقارية',
        'description' => 'منصة عقارية متطورة تتيح البحث والتصفية الذكية للعقارات مع خرائط تفاعلية وجولات افتراضية ثلاثية الأبعاد ونظام عروض الأسعار.',
        'image'       => 'portfolio/realestate.png',
        'url'         => '#',
        'status'      => 'completed',
        'is_featured' => true,
        'techs'       => ['React', 'Laravel', 'PostgreSQL'],
    ],
    [
        'title'       => 'نظام توصيل المطاعم',
        'client_name' => 'مجموعة مذاق السعودية',
        'description' => 'منظومة متكاملة لإدارة المطاعم والتوصيل تشمل تطبيق العميل ولوحة إدارة المطعم ونظام تتبع السائق في الوقت الفعلي.',
        'image'       => 'portfolio/restaurant.png',
        'url'         => '#',
        'status'      => 'completed',
        'is_featured' => false,
        'techs'       => ['React Native', 'Laravel', 'MySQL'],
    ],
    [
        'title'       => 'نظام إدارة الموارد البشرية',
        'client_name' => 'مجموعة الفيصل للاستثمار',
        'description' => 'نظام شامل لإدارة الموارد البشرية يغطي الرواتب والحضور والإجازات وتقييم الأداء والتوظيف مع تقارير تحليلية متقدمة.',
        'image'       => 'portfolio/hrm.png',
        'url'         => '#',
        'status'      => 'completed',
        'is_featured' => true,
        'techs'       => ['Laravel', 'Vue.js', 'MySQL', 'AWS'],
    ],
    [
        'title'       => 'منصة تعليم إلكتروني',
        'client_name' => 'أكاديمية المستقبل',
        'description' => 'منصة تعليمية متكاملة تدعم الفيديو المباشر وأدوات التعلم التفاعلية وشهادات البلوك تشين مع نظام ذكاء اصطناعي لتخصيص مسار التعلم.',
        'image'       => null,
        'url'         => '#',
        'status'      => 'completed',
        'is_featured' => false,
        'techs'       => ['Next.js', 'Python', 'PostgreSQL', 'AWS'],
    ],
    [
        'title'       => 'نظام إدارة العيادات',
        'client_name' => 'مستشفى الرعاية الحديثة',
        'description' => 'نظام متكامل لإدارة العيادات والمواعيد والسجلات الطبية الإلكترونية مع نظام فوترة ذكي ولوحة تحكم شاملة للأطباء والإداريين.',
        'image'       => null,
        'url'         => '#',
        'status'      => 'completed',
        'is_featured' => false,
        'techs'       => ['Laravel', 'React', 'MySQL'],
    ],
    [
        'title'       => 'منصة SaaS للتحليلات',
        'client_name' => 'DataFlow Solutions',
        'description' => 'منصة تحليلات بيانات SaaS توفر لوحات تحكم تفاعلية وتقارير آنية ونماذج تنبؤية بالذكاء الاصطناعي لمساعدة الشركات على اتخاذ قرارات مبنية على البيانات.',
        'image'       => null,
        'url'         => '#',
        'status'      => 'active',
        'is_featured' => false,
        'techs'       => ['Python', 'React', 'PostgreSQL', 'AWS'],
    ],
];

foreach ($projects as $data) {
    $techNames = $data['techs'];
    unset($data['techs']);

    // Check if project already exists
    $existing = Project::where('title', $data['title'])->first();
    if ($existing) {
        echo "⏭️  Skipping (exists): {$data['title']}\n";
        continue;
    }

    $project = Project::create($data);

    // Attach technologies
    $techIds = collect($techNames)->map(fn($name) => $techs[$name]->id ?? null)->filter()->values();
    $project->technologies()->sync($techIds);

    echo "✅ Created: {$project->title}\n";
}

echo "\n✨ Portfolio seeding complete!\n";
echo "Total projects: " . Project::count() . "\n";
