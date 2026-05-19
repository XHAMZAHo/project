@extends('layouts.app')
@section('title', __('site.contact'))
@section('content')

{{-- Hero --}}
<section style="padding:140px 20px 80px;background:#080d1e;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at top center,rgba(26,86,240,0.18),transparent 65%);pointer-events:none;"></div>
    <div style="max-width:700px;margin:0 auto;text-align:center;position:relative;z-index:1;">
        <div class="section-badge" data-aos="fade-down" style="margin-bottom:16px;">{{ __('site.contact') }}</div>
        <h1 class="et-heading" style="font-size:clamp(2.2rem,6vw,3.5rem);margin-bottom:16px;" data-aos="fade-up">
            {{ app()->getLocale()==='ar' ? 'تواصل معنا' : 'Get In Touch' }}
        </h1>
        <p style="color:#64748b;font-size:16px;line-height:1.8;" data-aos="fade-up" data-aos-delay="100">
            {{ app()->getLocale()==='ar' ? 'نحن هنا لمساعدتك في تحقيق رؤيتك الرقمية. تواصل معنا اليوم!' : 'We\'re here to help you achieve your digital vision. Contact us today!' }}
        </p>
    </div>
</section>

{{-- Contact Cards + Form --}}
<section style="padding:80px 20px;background:#03040e;">
    <div style="max-width:1100px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:1fr 1.6fr;gap:40px;align-items:start;">

            {{-- Contact Methods --}}
            <div style="display:flex;flex-direction:column;gap:16px;" data-aos="fade-right">

                <a href="https://wa.me/966511946443" target="_blank"
                   style="display:flex;align-items:center;gap:16px;padding:20px 22px;border-radius:18px;
                          border:1px solid rgba(34,197,94,0.2);background:rgba(34,197,94,0.05);
                          text-decoration:none;transition:all .3s;"
                   onmouseover="this.style.borderColor='rgba(34,197,94,0.4)';this.style.background='rgba(34,197,94,0.1)';this.style.transform='translateY(-3px)'"
                   onmouseout="this.style.borderColor='rgba(34,197,94,0.2)';this.style.background='rgba(34,197,94,0.05)';this.style.transform=''">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fab fa-whatsapp" style="color:#22c55e;font-size:22px;"></i>
                    </div>
                    <div>
                        <div style="color:#fff;font-weight:700;font-size:14px;margin-bottom:3px;">WhatsApp</div>
                        <div style="color:#64748b;font-size:13px;" dir="ltr">+966 51 194 6443</div>
                    </div>
                    <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}" style="color:#22c55e;font-size:12px;margin-inline-start:auto;"></i>
                </a>

                <a href="https://www.instagram.com/elevatech___" target="_blank"
                   style="display:flex;align-items:center;gap:16px;padding:20px 22px;border-radius:18px;
                          border:1px solid rgba(236,72,153,0.2);background:rgba(236,72,153,0.05);
                          text-decoration:none;transition:all .3s;"
                   onmouseover="this.style.borderColor='rgba(236,72,153,0.4)';this.style.background='rgba(236,72,153,0.1)';this.style.transform='translateY(-3px)'"
                   onmouseout="this.style.borderColor='rgba(236,72,153,0.2)';this.style.background='rgba(236,72,153,0.05)';this.style.transform=''">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(236,72,153,0.12);border:1px solid rgba(236,72,153,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fab fa-instagram" style="color:#ec4899;font-size:22px;"></i>
                    </div>
                    <div>
                        <div style="color:#fff;font-weight:700;font-size:14px;margin-bottom:3px;">Instagram</div>
                        <div style="color:#64748b;font-size:13px;">@elevatech___</div>
                    </div>
                    <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}" style="color:#ec4899;font-size:12px;margin-inline-start:auto;"></i>
                </a>

                <a href="mailto:Elevatech2027@gmail.com"
                   style="display:flex;align-items:center;gap:16px;padding:20px 22px;border-radius:18px;
                          border:1px solid rgba(26,86,240,0.2);background:rgba(26,86,240,0.05);
                          text-decoration:none;transition:all .3s;"
                   onmouseover="this.style.borderColor='rgba(26,86,240,0.4)';this.style.background='rgba(26,86,240,0.1)';this.style.transform='translateY(-3px)'"
                   onmouseout="this.style.borderColor='rgba(26,86,240,0.2)';this.style.background='rgba(26,86,240,0.05)';this.style.transform=''">
                    <div style="width:52px;height:52px;border-radius:14px;background:rgba(26,86,240,0.12);border:1px solid rgba(26,86,240,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-envelope" style="color:#3b82f6;font-size:20px;"></i>
                    </div>
                    <div>
                        <div style="color:#fff;font-weight:700;font-size:14px;margin-bottom:3px;">{{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email' }}</div>
                        <div style="color:#64748b;font-size:12px;">Elevatech2027@gmail.com</div>
                    </div>
                    <i class="fas fa-arrow-{{ app()->getLocale()==='ar'?'left':'right' }}" style="color:#3b82f6;font-size:12px;margin-inline-start:auto;"></i>
                </a>

                {{-- Chatbot CTA --}}
                <div style="padding:22px;border-radius:18px;border:1px solid rgba(26,86,240,0.25);background:linear-gradient(135deg,rgba(26,86,240,0.1),rgba(18,65,192,0.05));text-align:center;margin-top:4px;">
                    <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#1241c0,#1a56f0);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:0 0 20px rgba(26,86,240,0.4);">
                        <i class="fas fa-robot" style="color:#fff;font-size:20px;"></i>
                    </div>
                    <p style="color:#fff;font-weight:700;font-size:14px;margin-bottom:6px;">
                        {{ app()->getLocale()==='ar'?'المساعد الذكي':'Smart Assistant' }}
                    </p>
                    <p style="color:#64748b;font-size:12.5px;margin-bottom:14px;line-height:1.6;">
                        {{ app()->getLocale()==='ar'?'تحدث مع مساعدنا الذكي لطلب خدمة فوراً':'Chat with our AI assistant to request a service instantly' }}
                    </p>
                    <button onclick="document.getElementById('et-chatbot-btn').click()" class="btn-primary" style="padding:9px 22px;font-size:13px;border-radius:10px;width:100%;justify-content:center;">
                        <i class="fas fa-comment-dots"></i>
                        {{ app()->getLocale()==='ar'?'ابدأ المحادثة':'Start Chat' }}
                    </button>
                </div>
            </div>

            {{-- Contact Form --}}
            <div data-aos="fade-left" data-aos-delay="100">
                <div class="glass" style="border-radius:24px;padding:36px;">
                    <h2 style="color:#fff;font-weight:800;font-size:20px;margin-bottom:24px;">
                        {{ app()->getLocale()==='ar'?'أرسل رسالة':'Send a Message' }}
                    </h2>

                    @if(session('success'))
                    <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);border-radius:12px;padding:14px 16px;color:#34d399;font-size:13px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-check-circle"></i>
                        {{ app()->getLocale()==='ar'?'تم إرسال رسالتك بنجاح!':'Your message was sent successfully!' }}
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" id="contact-form">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                            <div>
                                <label style="display:block;color:#94a3b8;font-size:12.5px;font-weight:600;margin-bottom:7px;">
                                    {{ app()->getLocale()==='ar'?'الاسم':'Your Name' }} *
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       placeholder="{{ app()->getLocale()==='ar'?'اسمك الكريم':'Your full name' }}"
                                       style="width:100%;background:rgba(26,86,240,0.06);border:1px solid rgba(26,86,240,0.2);border-radius:11px;padding:12px 15px;color:#e2e8f0;font-size:14px;outline:none;font-family:inherit;transition:border-color .25s;"
                                       onfocus="this.style.borderColor='rgba(26,86,240,0.5)'" onblur="this.style.borderColor='rgba(26,86,240,0.2)'">
                                @error('name')<p style="color:#f87171;font-size:11px;margin-top:5px;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label style="display:block;color:#94a3b8;font-size:12.5px;font-weight:600;margin-bottom:7px;">
                                    {{ app()->getLocale()==='ar'?'البريد الإلكتروني':'Email Address' }} *
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       placeholder="you@example.com" dir="ltr"
                                       style="width:100%;background:rgba(26,86,240,0.06);border:1px solid rgba(26,86,240,0.2);border-radius:11px;padding:12px 15px;color:#e2e8f0;font-size:14px;outline:none;font-family:inherit;transition:border-color .25s;"
                                       onfocus="this.style.borderColor='rgba(26,86,240,0.5)'" onblur="this.style.borderColor='rgba(26,86,240,0.2)'">
                                @error('email')<p style="color:#f87171;font-size:11px;margin-top:5px;">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div style="margin-bottom:16px;">
                            <label style="display:block;color:#94a3b8;font-size:12.5px;font-weight:600;margin-bottom:7px;">
                                {{ app()->getLocale()==='ar'?'الموضوع':'Subject' }}
                            </label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                   placeholder="{{ app()->getLocale()==='ar'?'موضوع رسالتك':'Message subject' }}"
                                   style="width:100%;background:rgba(26,86,240,0.06);border:1px solid rgba(26,86,240,0.2);border-radius:11px;padding:12px 15px;color:#e2e8f0;font-size:14px;outline:none;font-family:inherit;transition:border-color .25s;"
                                   onfocus="this.style.borderColor='rgba(26,86,240,0.5)'" onblur="this.style.borderColor='rgba(26,86,240,0.2)'">
                        </div>

                        <div style="margin-bottom:24px;">
                            <label style="display:block;color:#94a3b8;font-size:12.5px;font-weight:600;margin-bottom:7px;">
                                {{ app()->getLocale()==='ar'?'رسالتك':'Your Message' }} *
                            </label>
                            <textarea name="message" required rows="5"
                                      placeholder="{{ app()->getLocale()==='ar'?'اكتب رسالتك هنا...':'Write your message here...' }}"
                                      style="width:100%;background:rgba(26,86,240,0.06);border:1px solid rgba(26,86,240,0.2);border-radius:11px;padding:12px 15px;color:#e2e8f0;font-size:14px;outline:none;font-family:inherit;resize:vertical;transition:border-color .25s;min-height:140px;"
                                      onfocus="this.style.borderColor='rgba(26,86,240,0.5)'" onblur="this.style.borderColor='rgba(26,86,240,0.2)'">{{ old('message') }}</textarea>
                            @error('message')<p style="color:#f87171;font-size:11px;margin-top:5px;">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:13px;font-size:14px;border-radius:12px;">
                            <i class="fas fa-paper-plane"></i>
                            {{ app()->getLocale()==='ar'?'إرسال الرسالة':'Send Message' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
html.light section[style*="background:#03040e"],
html.light section[style*="background:#080d1e"] { background:#f0f4ff !important; }
html.light .glass { background:rgba(255,255,255,0.9) !important; }
html.light input, html.light textarea {
    background:rgba(26,86,240,0.04) !important;
    color:#1e293b !important;
}
@media(max-width:768px){
    section > div > div[style*="grid-template-columns:1fr 1.6fr"] { grid-template-columns:1fr !important; }
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns:1fr !important; }
}
</style>
@endsection
