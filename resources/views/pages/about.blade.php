@extends('layouts.app')
@section('title', __('site.about'))
@section('content')

{{-- Hero --}}
<section class="relative pt-36 pb-20 overflow-hidden" style="background: #080d1e;">
    <div class="absolute inset-0 opacity-20"
         style="background: radial-gradient(ellipse at top center, #2563eb 0%, transparent 60%);"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <div class="section-badge mb-4" data-aos="fade-down">{{ __('site.about') }}</div>
        <h1 class="text-5xl md:text-6xl font-black text-white mb-5" data-aos="fade-up">
            {{ __('site.about_title') }}
        </h1>
        <p class="text-slate-400 text-lg max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            {{ __('site.about_subtitle') }}
        </p>
    </div>
</section>

{{-- About Content --}}
<section class="py-24" style="background: #03040e;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Text --}}
            <div data-aos="fade-right">
                <div class="section-badge mb-4">ET ELEVA TECH</div>
                <h2 class="text-4xl font-black text-white mb-6 leading-tight">
                    {{ app()->getLocale() === 'ar'
                        ? 'كيان تقني رائد وصناع المستقبل الرقمي'
                        : 'A Leading Tech Entity & Creators of the Digital Future' }}
                </h2>
                <p class="text-slate-400 leading-relaxed mb-6">{{ __('site.about_text') }}</p>
                <p class="text-slate-400 leading-relaxed mb-8">
                    {{ app()->getLocale() === 'ar'
                        ? 'يجمع كياننا نخبة من العقول الهندسية والمبدعة، نعمل بروح واحدة لابتكار حلول برمجية تتجاوز المألوف. نحن لا نصنع مجرد منصات وتطبيقات، بل نبني تجارب رقمية فاخرة تصنع الفارق وتترك بصمة لا تُنسى.'
                        : 'Our entity brings together elite engineering and creative minds, working synergistically to innovate software solutions that go beyond the ordinary. We don\'t just build platforms and apps; we craft premium digital experiences that make a difference.' }}
                </p>

                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['val'=>$completedProjects, 'suffix'=>'+', 'label'=> __('site.projects_done')],
                        ['val'=>$testimonials,       'suffix'=>'+', 'label'=> __('site.happy_clients')],
                        ['val'=>'5',                 'suffix'=>'+', 'label'=> __('site.years_exp')],
                        ['val'=>'98',                'suffix'=>'%', 'label'=> __('site.success_rate')],
                    ] as $s)
                    <div class="glass rounded-xl p-4" style="border: 1px solid rgba(26,86,240,0.12);">
                        <div class="stat-number text-3xl font-black"
                             data-counter data-target="{{ $s['val'] }}" data-suffix="{{ $s['suffix'] }}">
                            0{{ $s['suffix'] }}
                        </div>
                        <p class="text-slate-400 text-xs mt-1">{{ $s['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Visual --}}
            <div class="relative" data-aos="fade-left" data-aos-delay="200">
                <div class="animated-border rounded-2xl p-8 glass text-center"
                     style="background: rgba(26,86,240,0.03);">
                    <div class="text-8xl mb-6" style="filter: drop-shadow(0 0 30px rgba(26,86,240,0.5));">🚀</div>
                    <div class="text-6xl font-black mb-2" style="
                        background: linear-gradient(135deg, #2563eb, #3b82f6, #fff);
                        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        ET
                    </div>
                    <div class="text-white font-black text-2xl tracking-widest mb-2">ELEVA TECH</div>
                    <div class="text-sky-400 text-sm tracking-[0.2em] uppercase">Digital Excellence</div>

                    <div class="mt-8 grid grid-cols-3 gap-3">
                        @foreach(['Laravel','React','Flutter','Node.js','Python','MySQL'] as $tech)
                        <div class="py-2 px-3 rounded-lg text-xs font-semibold text-sky-300"
                             style="background: rgba(26,86,240,0.08); border: 1px solid rgba(26,86,240,0.15);">
                            {{ $tech }}
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Floating orb --}}
                <div class="absolute -top-10 -end-10 w-40 h-40 rounded-full blur-3xl opacity-20 pointer-events-none"
                     style="background: radial-gradient(circle, #2563eb, transparent);"></div>
            </div>
        </div>
    </div>
</section>

{{-- Vision & Mission --}}
<section class="py-20" style="background: #080d1e;">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['icon'=>'👁️', 'title'=>__('site.our_vision'),  'text'=>__('site.vision_text')],
                ['icon'=>'🎯', 'title'=>__('site.our_mission'), 'text'=>__('site.mission_text')],
                ['icon'=>'💎', 'title'=> app()->getLocale()==='ar' ? 'قيمنا' : 'Our Values',
                               'text' => app()->getLocale()==='ar'
                                    ? 'الجودة، الإبداع، الشفافية، والالتزام بأعلى المعايير في كل مشروع.'
                                    : 'Quality, creativity, transparency, and commitment to the highest standards in every project.'],
            ] as $i => $card)
            <div class="glass rounded-2xl p-8 text-center"
                 style="border: 1px solid rgba(26,86,240,0.12);"
                 data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5"
                     style="background: rgba(26,86,240,0.1); border: 1px solid rgba(26,86,240,0.25);">
                    {{ $card['icon'] }}
                </div>
                <h3 class="text-white font-black text-xl mb-3">{{ $card['title'] }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed">{{ $card['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team Technologies --}}
<section class="py-20" style="background: #03040e;">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="section-badge mb-4" data-aos="fade-down">
            {{ app()->getLocale() === 'ar' ? 'تقنياتنا' : 'Our Stack' }}
        </div>
        <h2 class="text-3xl font-black text-white mb-12" data-aos="fade-up">
            {{ app()->getLocale() === 'ar' ? 'التقنيات التي نتقنها' : 'Technologies We Master' }}
        </h2>
        <div class="flex flex-wrap gap-3 justify-center" data-aos="fade-up" data-aos-delay="100">
            @foreach(['Laravel','PHP','React.js','Vue.js','Next.js','Flutter','React Native',
                       'Node.js','Python','MySQL','PostgreSQL','MongoDB','Redis','AWS',
                       'Docker','Tailwind CSS','Figma','Git'] as $i => $tech)
            <span class="px-4 py-2 rounded-full text-sm font-semibold text-sky-300 transition-all duration-300"
                  style="background: rgba(26,86,240,0.08); border: 1px solid rgba(26,86,240,0.15);"
                  onmouseover="this.style.boxShadow='0 0 20px rgba(26,86,240,0.3)'; this.style.borderColor='rgba(26,86,240,0.5)'"
                  onmouseout="this.style.boxShadow='none'; this.style.borderColor='rgba(26,86,240,0.15)'">
                {{ $tech }}
            </span>
            @endforeach
        </div>
    </div>
</section>

@endsection
