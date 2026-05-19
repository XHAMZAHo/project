@extends('layouts.app')
@section('title', app()->getLocale()==='ar' ? 'المدونة' : 'Blog')
@section('content')

<section style="padding:120px 20px 60px;background:#080d1e;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at top,rgba(26,86,240,0.1),transparent 60%);pointer-events:none;"></div>
    <div style="max-width:800px;margin:0 auto;text-align:center;position:relative;">
        <div class="section-badge" data-aos="fade-down" style="margin-bottom:16px;">
            <i class="fas fa-pen-nib" style="color:#1a56f0;"></i>
            {{ app()->getLocale()==='ar' ? 'المدونة' : 'Blog' }}
        </div>
        <h1 class="et-heading" style="font-size:clamp(2rem,6vw,3.5rem);margin-bottom:16px;" data-aos="fade-up">
            {{ app()->getLocale()==='ar' ? 'مقالات ومحتوى تقني' : 'Articles & Tech Content' }}
        </h1>
        <p style="color:#64748b;font-size:16px;" data-aos="fade-up" data-aos-delay="100">
            {{ app()->getLocale()==='ar'
                ? 'أحدث المقالات والنصائح في عالم التكنولوجيا والتطوير الرقمي'
                : 'Latest articles and tips in the world of technology and digital development' }}
        </p>
    </div>
</section>

<section style="padding:60px 20px 100px;background:#03040e;">
<div style="max-width:1200px;margin:0 auto;">

    @if($posts->isEmpty())
    <div style="text-align:center;padding:100px 20px;background:rgba(26,86,240,0.04);border:1px solid rgba(26,86,240,0.1);border-radius:24px;">
        <i class="fas fa-newspaper" style="font-size:56px;color:#1f2937;margin-bottom:20px;display:block;"></i>
        <h3 style="color:#fff;font-size:22px;font-weight:700;margin-bottom:10px;">
            {{ app()->getLocale()==='ar' ? 'لا توجد مقالات بعد' : 'No articles yet' }}
        </h3>
        <p style="color:#64748b;margin-bottom:28px;">
            {{ app()->getLocale()==='ar' ? 'سيتم نشر مقالات قريباً' : 'Articles will be published soon' }}
        </p>
        <a href="{{ route('home') }}" class="btn-primary" style="padding:12px 28px;border-radius:12px;">
            {{ app()->getLocale()==='ar' ? 'الصفحة الرئيسية' : 'Back to Home' }}
        </a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
        @foreach($posts as $i => $post)
        <article class="glass" style="border-radius:20px;overflow:hidden;border:1px solid rgba(26,86,240,0.1);transition:all .3s;"
                 data-aos="fade-up" data-aos-delay="{{ $i * 70 }}"
                 onmouseenter="this.style.transform='translateY(-4px)';this.style.borderColor='rgba(26,86,240,0.3)'"
                 onmouseleave="this.style.transform='';this.style.borderColor='rgba(26,86,240,0.1)'">

            @if($post->featured_image)
            <a href="{{ route('blog.post', $post) }}">
                <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}"
                     style="width:100%;height:200px;object-fit:cover;display:block;">
            </a>
            @else
            <div style="height:160px;background:linear-gradient(135deg,rgba(26,86,240,0.15),rgba(59,130,246,0.08));display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-newspaper" style="color:#1a56f0;font-size:36px;opacity:0.5;"></i>
            </div>
            @endif

            <div style="padding:22px;">
                @if($post->category)
                <span style="background:rgba(26,86,240,0.1);border:1px solid rgba(26,86,240,0.2);color:#3b82f6;font-size:11px;font-weight:600;padding:3px 10px;border-radius:100px;display:inline-block;margin-bottom:12px;">
                    {{ $post->category }}
                </span>
                @endif

                <h2 style="color:#fff;font-weight:700;font-size:16px;line-height:1.5;margin-bottom:10px;">
                    <a href="{{ route('blog.post', $post) }}" style="color:inherit;text-decoration:none;">
                        {{ app()->getLocale()==='ar' ? ($post->title_ar ?? $post->title) : $post->title }}
                    </a>
                </h2>

                @if($post->excerpt)
                <p style="color:#64748b;font-size:13px;line-height:1.7;margin-bottom:16px;">
                    {{ Str::limit(app()->getLocale()==='ar' ? ($post->excerpt_ar ?? $post->excerpt) : $post->excerpt, 110) }}
                </p>
                @endif

                <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                    <span style="color:#475569;font-size:12px;">
                        <i class="fas fa-calendar" style="color:#1a56f0;font-size:11px;margin-inline-end:4px;"></i>
                        {{ optional($post->published_at)->format('d M Y') }}
                    </span>
                    <a href="{{ route('blog.post', $post) }}" style="color:#1a56f0;font-size:12px;font-weight:600;text-decoration:none;">
                        {{ app()->getLocale()==='ar' ? 'اقرأ المزيد' : 'Read more' }}
                        <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}" style="font-size:10px;margin-inline-start:4px;"></i>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <div style="margin-top:48px;">
        {{ $posts->links() }}
    </div>
    @endif

</div>
</section>

@push('scripts')
<script>
const style=document.createElement('style');
style.textContent=`
@media(max-width:1024px){.blog-grid{grid-template-columns:repeat(2,1fr)!important;}}
@media(max-width:640px){.blog-grid{grid-template-columns:1fr!important;}}
`;
document.head.appendChild(style);
document.querySelector('section:last-of-type div[style*="grid-template-columns:repeat(3"]')
    ?.classList.add('blog-grid');
</script>
@endpush
@endsection
