{{-- ELEVA TECH Smart Chatbot --}}
<button id="et-chatbot-btn" onclick="toggleChatbot()" title="Chat">
    <i id="chatbot-icon" class="fas fa-comment-dots"></i>
</button>

<div id="et-chatbot-panel">
    <div class="chatbot-header">
        <div style="width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-robot" style="color:#fff;font-size:16px;"></i>
        </div>
        <div style="flex:1;margin-inline-start:10px;">
            <div style="font-weight:800;font-size:13px;color:#fff;">ELEVA TECH Bot</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.7);">
                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;margin-inline-end:4px;"></span>
                {{ app()->getLocale()==='ar'?'متاح الآن':'Online now' }}
            </div>
        </div>
        <button onclick="toggleChatbot()" style="background:rgba(255,255,255,0.15);border:none;color:#fff;width:30px;height:30px;border-radius:50%;cursor:pointer;font-size:13px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="chatbot-messages" id="chatbot-messages"></div>
    <div class="chatbot-input">
        <input type="text" id="chatbot-input" placeholder="{{ app()->getLocale()==='ar'?'اكتب رسالتك...':'Type your message...' }}">
        <button onclick="sendMsg()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<style>
.typing-dot{width:7px;height:7px;border-radius:50%;background:rgba(26,86,240,0.6);animation:tdot 1.2s infinite;display:inline-block;margin:0 2px;}
.typing-dot:nth-child(2){animation-delay:.2s;}.typing-dot:nth-child(3){animation-delay:.4s;}
@keyframes tdot{0%,100%{transform:translateY(0);opacity:.5;}50%{transform:translateY(-4px);opacity:1;}}
</style>

<script>
var IS_AR = {{ app()->getLocale() === 'ar' ? 'true' : 'false' }};
var IS_LOGGED_IN = {{ auth()->check() ? 'true' : 'false' }};
var USER_NAME = @json(auth()->check() ? auth()->user()->name : "");

// ── Services & Keywords ──
var SERVICES = IS_AR
    ? ['تصميم وتطوير مواقع الويب','تطوير تطبيقات الجوال','تطوير الأنظمة','UX/UI Design','حلول الذكاء الاصطناعي','الاستضافة والسحابة']
    : ['Web Design & Development','Mobile App Development','System Development','UX/UI Design','AI Solutions','Cloud & Hosting'];

var ADVANCED_KEYWORDS = IS_AR
    ? ['سعر','تكلفة','عرض','مشروع','تنفيذ','استشارة','كم','ريال','تطوير','بناء','انشاء','أنشئ','ابغا','ابي','اريد','نظام','تطبيق','موقع','عرض سعر']
    : ['price','cost','quote','project','build','consult','how much','develop','create','need','want','system','app','website','proposal'];

var GENERAL_KEYWORDS = IS_AR
    ? ['خدمات','ماذا','تعملون','مدة','كم مدة','فرق','ما الفرق','تطبيقات','مواقع','ذكاء','استضافة']
    : ['services','what do','how long','difference','apps','websites','ai','cloud','hosting'];

// ── State ──
window.chatHistory = window.chatHistory || [];
window.awaitingLeadForm = window.awaitingLeadForm || false;
window.leadData = window.leadData || {};
window.leadStep = window.leadStep || 0;

// ── Core Functions ──
function t(ar, en){ return IS_AR ? ar : en; }

function addMsg(text, from='bot'){
    const c = document.getElementById('chatbot-messages');
    const d = document.createElement('div');
    d.className = `chat-msg ${from}`;
    d.style.whiteSpace = 'pre-line';
    d.textContent = text;
    c.appendChild(d);
    c.scrollTop = c.scrollHeight;
    if(from==='bot') window.chatHistory.push({role:'assistant', content:text});
    else window.chatHistory.push({role:'user', content:text});
}

function addHTML(html){
    const c = document.getElementById('chatbot-messages');
    const d = document.createElement('div');
    d.className = 'chat-msg bot';
    d.innerHTML = html;
    c.appendChild(d);
    c.scrollTop = c.scrollHeight;
}

function addOpts(opts, cb){
    const c = document.getElementById('chatbot-messages');
    const w = document.createElement('div');
    w.className = 'chat-options';
    opts.forEach(o => {
        const b = document.createElement('button');
        b.className = 'chat-option-btn';
        b.textContent = o;
        b.onclick = () => { w.querySelectorAll('button').forEach(x=>x.disabled=true); w.style.opacity='.5'; cb(o); };
        w.appendChild(b);
    });
    c.appendChild(w);
    c.scrollTop = c.scrollHeight;
}

function showTyping(){
    const c = document.getElementById('chatbot-messages');
    const d = document.createElement('div');
    d.className = 'chat-msg bot'; d.id = 'bot-typing';
    d.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
    c.appendChild(d); c.scrollTop = c.scrollHeight;
}
function hideTyping(){ document.getElementById('bot-typing')?.remove(); }

function toggleChatbot(){
    var p = document.getElementById('et-chatbot-panel');
    var ic = document.getElementById('chatbot-icon');
    var open = p.classList.toggle('open');
    ic.className = open ? 'fas fa-times' : 'fas fa-comment-dots';
    if(open && window.chatHistory.length === 0) setTimeout(greetUser, 400);
}

// ── Greeting ──
function greetUser(){
    showTyping();
    setTimeout(() => {
        hideTyping();
        if(IS_LOGGED_IN){
            addMsg(t(
                `👋 أهلاً ${USER_NAME}!\nأنا مساعدك الذكي في ELEVA TECH 🚀\n\nكيف يمكنني مساعدتك اليوم؟`,
                `👋 Welcome back ${USER_NAME}!\nI'm ELEVA TECH's smart assistant 🚀\n\nHow can I help you today?`
            ));
            addOpts(
                IS_AR
                    ? ['💰 عرض سعر مشروع','🌐 تطوير موقع','📱 تطبيق جوال','🤖 ذكاء اصطناعي','💬 استفسار عام']
                    : ['💰 Project Quote','🌐 Website Dev','📱 Mobile App','🤖 AI Solutions','💬 General Question'],
                handleUserInput
            );
        } else {
            addMsg(t(
                `👋 مرحباً بك في ELEVA TECH!\nأنا مساعدك الذكي، يسعدني مساعدتك 😊\n\nيمكنني الإجابة على أسئلتك العامة حول خدماتنا.`,
                `👋 Welcome to ELEVA TECH!\nI'm your smart assistant 😊\n\nI can answer general questions about our services.`
            ));
            addOpts(
                IS_AR
                    ? ['🌐 ما هي خدماتكم؟','⏱️ كم مدة تطوير موقع؟','📱 هل تطورون تطبيقات؟','🤔 الفرق بين موقع وتطبيق؟']
                    : ['🌐 What are your services?','⏱️ How long for a website?','📱 Do you build apps?','🤔 Website vs App difference?'],
                handleUserInput
            );
        }
    }, 900);
}

// ── Detect Intent ──
function isAdvancedRequest(msg){
    const lower = msg.toLowerCase();
    return ADVANCED_KEYWORDS.some(kw => lower.includes(kw));
}

// ── Handle User Input ──
function handleUserInput(msg){
    addMsg(msg, 'user');
    showTyping();

    // If waiting for lead form input
    if(window.awaitingLeadForm){
        setTimeout(() => { hideTyping(); handleLeadStep(msg); }, 700);
        return;
    }

    // Check if advanced (requires login)
    if(!IS_LOGGED_IN && isAdvancedRequest(msg)){
        setTimeout(() => {
            hideTyping();
            addMsg(t(
                `تمام 👍\nحتى نقدر نكمل معك ونجهز لك تفاصيل مشروعك، تحتاج تسجل دخول أو تنشئ حساباً أولاً.`,
                `Great 👍\nTo continue and prepare your project details, you need to log in or create an account first.`
            ));
            addHTML(`
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;">
                    <a href="/login" style="padding:8px 16px;background:rgba(26,86,240,0.2);border:1px solid rgba(26,86,240,0.4);border-radius:8px;color:#60a5fa;text-decoration:none;font-size:12px;font-weight:600;">
                        🔑 ${IS_AR?'تسجيل الدخول':'Login'}
                    </a>
                    <a href="/register" style="padding:8px 16px;background:linear-gradient(135deg,#1241c0,#1a56f0);border-radius:8px;color:#fff;text-decoration:none;font-size:12px;font-weight:600;">
                        ✨ ${IS_AR?'إنشاء حساب':'Create Account'}
                    </a>
                </div>
            `);
        }, 900);
        return;
    }

    // Smart responses
    setTimeout(() => {
        hideTyping();
        const lower = msg.toLowerCase();

        // Services question
        if(lower.includes(t('خدمات','service')) || lower.includes(t('تعملون','what do'))){
            addMsg(t(
                `نحن في ELEVA TECH نقدم:\n🌐 تصميم وتطوير مواقع الويب\n📱 تطوير تطبيقات الجوال\n⚙️ تطوير الأنظمة\n🎨 UX/UI Design\n🤖 حلول الذكاء الاصطناعي\n☁️ الاستضافة والسحابة`,
                `ELEVA TECH offers:\n🌐 Web Design & Development\n📱 Mobile App Development\n⚙️ System Development\n🎨 UX/UI Design\n🤖 AI Solutions\n☁️ Cloud & Hosting`
            ));
            if(!IS_LOGGED_IN){
                setTimeout(() => addMsg(t('هل تريد معرفة المزيد عن خدمة معينة؟','Want to know more about a specific service?')), 600);
            } else {
                setTimeout(() => {
                    addMsg(t('أي خدمة تهمك؟','Which service interests you?'));
                    addOpts(SERVICES, handleUserInput);
                }, 600);
            }
        }
        // Duration question
        else if(lower.includes(t('مدة','how long'))){
            addMsg(t(
                `⏱️ مدة تطوير الموقع:\n• موقع بسيط: 1-2 أسبوع\n• موقع متوسط: 3-6 أسابيع\n• نظام متكامل: 2-4 أشهر\n\nتختلف حسب متطلبات المشروع.`,
                `⏱️ Development timeline:\n• Simple site: 1-2 weeks\n• Mid-size: 3-6 weeks\n• Full system: 2-4 months\n\nDepends on project requirements.`
            ));
        }
        // Website vs App
        else if(lower.includes(t('فرق','difference')) || (lower.includes(t('موقع','website')) && lower.includes(t('تطبيق','app')))){
            addMsg(t(
                `🤔 الفرق:\n🌐 الموقع: متاح عبر المتصفح، مناسب للتسويق وعرض الخدمات\n📱 التطبيق: يُحمّل على الجوال، تجربة أفضل، إشعارات فورية\n\nكلاهما لهما مميزاتهما. يعتمد الاختيار على هدفك.`,
                `🤔 The difference:\n🌐 Website: browser-based, great for marketing & services\n📱 App: installed on phone, better UX, push notifications\n\nBoth have advantages. Depends on your goal.`
            ));
        }
        // Price request (logged in)
        else if(IS_LOGGED_IN && (lower.includes(t('سعر','price')) || lower.includes(t('كم','how much')) || lower.includes(t('تكلفة','cost')))){
            addMsg(t(
                `💰 السعر يعتمد على تفاصيل مشروعك والمتطلبات.\n\nللحصول على عرض سعر دقيق ومخصص، تواصل معنا مباشرة عبر واتساب وسيرد عليك فريقنا فوراً 👇`,
                `💰 Price depends on your project details and requirements.\n\nFor an accurate custom quote, contact us directly on WhatsApp and our team will respond immediately 👇`
            ));
            setTimeout(()=>addHTML(`<a href="https://wa.me/966511946443?text=${encodeURIComponent(IS_AR?'مرحباً، أود الاستفسار عن سعر خدمة':'Hello, I would like to inquire about pricing')}" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:linear-gradient(135deg,rgba(37,211,102,0.15),rgba(37,211,102,0.06));border:1px solid rgba(37,211,102,0.35);border-radius:10px;color:#25d366;text-decoration:none;font-weight:700;font-size:13px;"><i class="fab fa-whatsapp" style="font-size:16px;"></i>${IS_AR?'تواصل عبر واتساب':'Chat on WhatsApp'}</a>`), 500);
        }
        // Project request (logged in)
        else if(IS_LOGGED_IN && isAdvancedRequest(msg)){
            addMsg(t(
                `رائع! 🚀 يسعدنا خدمتك.\n\nتواصل معنا مباشرة عبر واتساب وسيقوم فريقنا بمساعدتك وإعداد عرض مخصص لمشروعك 👇`,
                `Great! 🚀 We'd love to help.\n\nContact us directly on WhatsApp and our team will assist you and prepare a custom proposal 👇`
            ));
            setTimeout(()=>addHTML(`<a href="https://wa.me/966511946443?text=${encodeURIComponent(IS_AR?'مرحباً، أود طلب خدمة جديدة':'Hello, I would like to request a new service')}" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:linear-gradient(135deg,rgba(37,211,102,0.15),rgba(37,211,102,0.06));border:1px solid rgba(37,211,102,0.35);border-radius:10px;color:#25d366;text-decoration:none;font-weight:700;font-size:13px;"><i class="fab fa-whatsapp" style="font-size:16px;"></i>${IS_AR?'تواصل عبر واتساب':'Chat on WhatsApp'}</a>`), 500);
        }
        // WhatsApp
        else if(lower.includes('whatsapp') || lower.includes('واتساب')){
            addMsg(t('يمكنك التواصل معنا مباشرة عبر واتساب 👇','You can reach us directly on WhatsApp 👇'));
            addHTML(`<a href="https://wa.me/966511946443" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;background:rgba(37,211,102,0.15);border:1px solid rgba(37,211,102,0.3);border-radius:10px;color:#25d366;text-decoration:none;font-weight:600;font-size:13px;">
                <i class="fab fa-whatsapp"></i> +966 51 194 6443
            </a>`);
        }
        // Default
        else {
            addMsg(t(
                `شكراً على سؤالك 😊\n\nيمكنني مساعدتك في:\n• معرفة خدماتنا\n• الاستفسار عن مشروعك\n• التواصل مع فريقنا`,
                `Thanks for your question 😊\n\nI can help you with:\n• Learning about our services\n• Inquiring about your project\n• Connecting with our team`
            ));
            if(!IS_LOGGED_IN){
                setTimeout(() => addOpts(
                    IS_AR
                        ? ['🌐 ما هي خدماتكم؟','📞 تواصل معنا','🔑 تسجيل الدخول']
                        : ['🌐 Your Services?','📞 Contact Us','🔑 Login'],
                    handleUserInput
                ), 500);
            }
        }
    }, 900 + Math.random()*300);
}

// ── WhatsApp Redirect (replaces lead form) ──
function startLeadForm(){
    addMsg(t(
        '📲 سيتم تحويلك إلى واتساب لإكمال طلبك مع فريقنا مباشرةً 👇',
        '📲 You will be redirected to WhatsApp to complete your request with our team directly 👇'
    ));
    const waText = IS_AR ? 'مرحباً، أود تقديم طلب خدمة جديد' : 'Hello, I would like to submit a new service request';
    setTimeout(()=>addHTML(`
        <a href="https://wa.me/966511946443?text=${encodeURIComponent(waText)}"
           target="_blank"
           style="display:inline-flex;align-items:center;gap:8px;padding:11px 20px;
                  background:linear-gradient(135deg,rgba(37,211,102,0.18),rgba(37,211,102,0.06));
                  border:1px solid rgba(37,211,102,0.4);border-radius:10px;color:#25d366;
                  text-decoration:none;font-weight:700;font-size:13px;">
            <i class="fab fa-whatsapp" style="font-size:17px;"></i>
            ${IS_AR ? 'تواصل عبر واتساب' : 'Chat on WhatsApp'}
        </a>`
    ), 400);
}

// Dummy stubs (kept to avoid JS errors if called)
function handleLeadStep(val){ startLeadForm(); }
function nextLeadStep(){ startLeadForm(); }

// ── Input ──
function sendMsg(){
    const inp = document.getElementById('chatbot-input');
    const txt = inp.value.trim();
    if(!txt) return;
    inp.value = '';
    handleUserInput(txt);
}

document.getElementById('chatbot-input').addEventListener('keypress', e => { if(e.key==='Enter') sendMsg(); });
</script>
