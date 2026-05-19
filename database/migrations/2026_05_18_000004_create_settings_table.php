<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, boolean, json, image
            $table->string('group')->default('general'); // general, seo, whatsapp, social
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'whatsapp_number',   'value' => '966500000000', 'type' => 'text',    'group' => 'whatsapp', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'whatsapp_enabled',  'value' => '1',            'type' => 'boolean', 'group' => 'whatsapp', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_name',         'value' => 'ELEVA TECH',   'type' => 'text',    'group' => 'general',  'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_name_ar',      'value' => 'إليفا تك',     'type' => 'text',    'group' => 'general',  'created_at' => now(), 'updated_at' => now()],
            ['key' => 'contact_email',     'value' => 'Elevatech2027@gmail.com', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'meta_title_ar',     'value' => 'إليفا تك - حلول رقمية احترافية', 'type' => 'text', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'meta_title_en',     'value' => 'ELEVA TECH - Professional Digital Solutions', 'type' => 'text', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'meta_desc_ar',      'value' => 'نقدم أفضل الحلول الرقمية والتقنية', 'type' => 'text', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'meta_desc_en',      'value' => 'We provide the best digital and tech solutions', 'type' => 'text', 'group' => 'seo', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'instagram_url',     'value' => 'https://instagram.com/elevatech', 'type' => 'text', 'group' => 'social', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'twitter_url',       'value' => '', 'type' => 'text', 'group' => 'social', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'linkedin_url',      'value' => '', 'type' => 'text', 'group' => 'social', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
