@extends('layouts.app')
@section('title', (app()->getLocale()==='ar' ? ($post->title_ar ?? $post->title) : $post->title) . ' | Blog')
@section('content')

<article style="min-height:100vh;padding:100px 20px 80px;background:#03040e;">
<div style="max-width:780px;margin:0 auto;">

    {{-- Back --}}
    <a href="{{ route('blog') }}" style="display:inline-flex;align-items:center;gap:7px;color:#64748b;font-size:13px;text-decoration:none;margin-bottom:32px;transition:color .2s;" onmouseenter="this.style.color='#1a56f0'" onmouseleave="this.style.color='#64748b'">
        <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'right':'left' }}"></i>
        {{ app()->getLocale()==='ar' ? 'العودة للمدونة' : 'Back to Blog' }}
    </a>

    {{-- Meta --}}
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;flex-wrap:wrap;">
        @if($post->category)
        <span style="background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.25);color:#3b82f6;font-size:12px;font-weight:600;padding:4px 12px;border-radius:100px;">
            {{ $post->category }}
        </span>
        @endif
        <span style="color:#475569;font-size:13px;">
            <i class="fas fa-calendar" style="color:#1a56f0;margin-inline-end:5px;"></i>
            {{ optional($post->published_at)->format('d M Y') }}
        </span>
    </div>

    {{-- Title --}}
    <h1 class="et-heading" style="font-size:clamp(1.8rem,5vw,2.8rem);margin-bottom:24px;line-height:1.2;" data-aos="fade-up">
        {{ app()->getLocale()==='ar' ? ($post->title_ar ?? $post->title) : $post->title }}
    </h1>

    {{-- Featured Image --}}
    @if($post->featured_image)
    <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}"
         style="width:100%;border-radius:20px;margin-bottom:36px;border:1px solid rgba(26,86,240,0.1);"
         data-aos="fade-up" data-aos-delay="100">
    @endif

    {{-- Content --}}
    <div data-aos="fade-up" data-aos-delay="150"
         style="color:#94a3b8;font-size:15px;line-height:1.9;">
        {!! app()->getLocale()==='ar' ? ($post->content_ar ?? $post->content) : $post->content !!}
    </div>

    {{-- Related --}}
    @if($related->count())
    <div style="margin-top:64px;padding-top:40px;border-top:1px solid rgba(26,86,240,0.1);">
        <h3 style="color:#fff;font-weight:700;font-size:18px;margin-bottom:24px;">
            {{ app()->getLocale()==='ar' ? 'مقالات ذات صلة' : 'Related Articles' }}
        </h3>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            @foreach($related as $rel)
            <a href="{{ route('blog.post', $rel) }}" class="glass"
               style="border-radius:16px;padding:18px;border:1px solid rgba(26,86,240,0.1);text-decoration:none;display:block;transition:all .2s;"
               onmouseenter="this.style.borderColor='rgba(26,86,240,0.3)'" onmouseleave="this.style.borderColor='rgba(26,86,240,0.1)'">
                <p style="color:#fff;font-weight:600;font-size:13px;line-height:1.5;margin-bottom:8px;">
                    {{ Str::limit(app()->getLocale()==='ar'?($rel->title_ar??$rel->title):$rel->title, 60) }}
                </p>
                <span style="color:#1a56f0;font-size:11px;">
                    {{ optional($rel->published_at)->format('d M Y') }}
                </span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
</article>
@endsection
