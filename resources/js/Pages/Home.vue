<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="hero">
      <div class="hero-grid"></div>
      <div class="hero-glow-1"></div>
      <div class="hero-glow-2"></div>
      <div class="hero-glow-3"></div>
      <div class="orbit-container">
        <div class="orbit orbit-1"><div class="orbit-dot"></div></div>
        <div class="orbit orbit-2"><div class="orbit-dot orbit-dot-gold"></div></div>
        <div class="orbit orbit-3"><div class="orbit-dot"></div></div>
      </div>
      <div class="scan-line"></div>

      <div class="hero-content">
        <div class="hero-badge">
          <span class="hero-badge-dot"></span>
          Bio-Energy Frequency Therapy · Est. 25 years
        </div>
        <h1 style="font-family:'Cormorant Garamond',serif; font-size:clamp(3rem,6vw,5.5rem); font-weight:300; line-height:1.05; margin-bottom:24px; color:#ffffff;">
          Your body speaks<br>in <em style="color:#c8a96e; font-style:italic;">frequencies.</em><br>We listen.
        </h1>
        <p class="hero-sub">
          Vibrational cell rebalancing through bio-resonance — a science-backed approach that turns your brain into a natural medicine box. Over 60 targeted programs, delivered to your device.
        </p>
        <div class="hero-stats">
          <div class="hstat"><span class="hstat-val">21,000+</span><span class="hstat-lbl">Active users</span></div>
          <div class="hstat"><span class="hstat-val">60+</span><span class="hstat-lbl">Programs</span></div>
          <div class="hstat"><span class="hstat-val">25 yrs</span><span class="hstat-lbl">Clinical experience</span></div>
          <div class="hstat"><span class="hstat-val">&lt; 8h</span><span class="hstat-lbl">Protocol delivery</span></div>
        </div>
        <div class="hero-btns">
          <Link :href="route('shop')" class="btn-primary">Explore Programs</Link>
          <Link :href="route('consultation')" class="btn-outline">Book a Consultation</Link>
        </div>
      </div>

      <div class="scroll-hint">
        <span>Discover</span>
        <div class="scroll-arrow"></div>
      </div>
    </section>

    <!-- ═══ HOW IT WORKS ═══ -->
    <section class="how-section" id="how">
      <div style="text-align:center; margin-bottom:56px;">
        <p class="section-label">Simple &amp; Accessible</p>
        <h2 class="section-title">Your protocol in <span class="gold-em">4 steps</span></h2>
      </div>
      <div class="how-grid">
        <div v-for="(step, i) in steps" :key="i" class="how-step">
          <div class="how-num">{{ i + 1 }}</div>
          <h4 class="how-title">{{ step.title }}</h4>
          <p class="how-text">{{ step.desc }}</p>
          <span class="how-tag">{{ step.icon }} {{ step.badge }}</span>
        </div>
      </div>
    </section>

    <!-- ═══ PATHOLOGY MAP ═══ -->
    <section class="pathology-section">
      <div class="pathology-intro">
        <div>
          <p class="section-label">Areas of Action</p>
          <h2 class="section-title">Your body's<br><span class="gold-em">complete system</span></h2>
          <p class="body-text" style="margin-bottom:20px;">This method — turning your brain into a natural medicine box — addresses the full spectrum of frequently encountered health challenges, from structural to emotional to hormonal.</p>
          <p class="body-text">Each program targets a specific bio-energetic disruption identified through decades of clinical practice by Dr. Éric Rosati.</p>
          <div style="margin-top:32px;">
            <Link :href="route('shop')" class="btn-primary">Browse All 60+ Programs</Link>
          </div>
        </div>
        <div class="pathology-systems">
          <div v-for="area in areas" :key="area.name" class="sys-card">
            <span class="sys-icon">{{ area.icon }}</span>
            <p class="sys-name">{{ area.name }}</p>
            <p class="sys-examples">{{ area.examples }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ FEATURED PROGRAMS ═══ -->
    <section class="programs-section">
      <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px; flex-wrap:wrap; gap:16px;">
        <div>
          <p class="section-label">Most Popular</p>
          <h2 class="section-title" style="margin-bottom:0;">Featured <span class="gold-em">programs</span></h2>
        </div>
        <Link :href="route('shop')" class="btn-outline" style="padding:12px 28px; font-size:.82rem;">View all 60+ programs →</Link>
      </div>
      <div class="prog-carousel">
        <template v-if="featuredPrograms && featuredPrograms.length">
          <div v-for="program in featuredPrograms.slice(0,4)" :key="program.id" class="prog-feat-card">
            <span class="pfc-badge">⭐ Bestseller</span>
            <p class="pfc-cat">{{ program.category?.emoji }} {{ program.category?.name }}</p>
            <h4 class="pfc-name">{{ program.title }}</h4>
            <p class="pfc-desc">{{ program.short_desc }}</p>
            <div class="pfc-footer">
              <span class="pfc-price">€{{ program.price }}</span>
              <Link :href="route('shop')" class="pfc-btn">+ Cart</Link>
            </div>
          </div>
        </template>
        <template v-else>
          <div v-for="prog in fallbackPrograms" :key="prog.name" class="prog-feat-card">
            <span class="pfc-badge">⭐ Bestseller</span>
            <p class="pfc-cat">{{ prog.cat }}</p>
            <h4 class="pfc-name">{{ prog.name }}</h4>
            <p class="pfc-desc">{{ prog.desc }}</p>
            <div class="pfc-footer">
              <span class="pfc-price">€11</span>
              <Link :href="route('shop')" class="pfc-btn">+ Cart</Link>
            </div>
          </div>
        </template>
      </div>
    </section>

    <!-- ═══ SUBSCRIPTION BANNER ═══ -->
    <div class="sub-banner" style="margin:0 48px;">
      <div class="sub-banner-glow"></div>
      <div class="sub-left">
        <p class="sub-tag">Unlimited Access</p>
        <h3 class="sub-title">Access every program.<br>Every month. One price.</h3>
        <p class="sub-desc">Subscribe for unlimited access to the full Vitality Inside library — 60+ programs, new protocols monthly, and priority support. Cancel anytime.</p>
      </div>
      <div class="sub-right">
        <div class="sub-price-display">
          <div class="sub-price">€29.90</div>
          <div class="sub-price-lbl">per month · cancel anytime</div>
        </div>
        <Link :href="route('shop')" class="btn-primary">Start Unlimited Access</Link>
      </div>
    </div>

    <!-- ═══ TESTIMONIALS TICKER ═══ -->
    <section class="testimonials-section">
      <div style="text-align:center; margin-bottom:0;">
        <p class="section-label">21,000+ users</p>
        <h2 class="section-title">What our community <span class="gold-em">experiences</span></h2>
      </div>
      <div class="ticker-wrapper" style="margin-top:48px;">
        <div class="ticker-track">
          <template v-for="pass in 2" :key="pass">
            <template v-if="allTestimonials.length">
              <div v-for="t in allTestimonials" :key="pass + '-' + t.id" class="review-card">
                <div class="review-stars">★★★★★</div>
                <p class="review-text">"{{ t.content }}"</p>
                <p class="review-meta">{{ t.name }} · {{ t.program }}</p>
              </div>
            </template>
            <template v-else>
              <div v-for="t in fallbackTestimonials" :key="pass + '-' + t.name" class="review-card">
                <div class="review-stars">★★★★★</div>
                <p class="review-text">"{{ t.content }}"</p>
                <p class="review-meta">{{ t.name }} · {{ t.program }}</p>
              </div>
            </template>
          </template>
        </div>
      </div>
    </section>

    <!-- ═══ DR ROSATI ═══ -->
    <section class="doctor-section">
      <div class="doctor-grid">
        <div class="doctor-avatar">
          <img src="/images/dr-rosati.jpg" alt="Dr. Éric Rosati" onerror="this.style.display='none'">
        </div>
        <div>
          <h3 class="doctor-name">Dr. Éric Rosati</h3>
          <p class="doctor-title">Osteopath · Doctor of Quantum Medicine · Founder of Vitality Inside</p>
          <p class="doctor-bio">With over 25 years of clinical practice and more than a decade of research in frequency medicine, Dr. Rosati founded Vitality Inside around a single conviction: the body's deepest intelligence speaks in energetic frequencies. Every protocol in the Vitality library is the product of his personal clinical experience and scientific rigor.</p>
          <div class="doctor-tags">
            <span class="dtag">Osteopathy</span>
            <span class="dtag">Chinese Medicine</span>
            <span class="dtag">Quantum Medicine</span>
            <span class="dtag">Isoposturale Method</span>
            <span class="dtag">Bio-Resonance</span>
            <span class="dtag">Homeopathy</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ COMMUNITY ═══ -->
    <section class="community-section">
      <div>
        <div class="community-number">21,000+</div>
        <p class="community-label">People using our programs regularly to feel better</p>
      </div>
      <div class="community-grid">
        <div v-for="n in 7" :key="n" class="comm-img">
          <img :src="`/images/community-img-${n}.png`" :alt="`Community ${n}`" onerror="this.parentElement.style.opacity='.3'">
        </div>
      </div>
      <div>
        <a href="mailto:rosati.eric@gmail.com?subject=Rejoindre+la+Communaute+Vitality+Inside" target="_blank" rel="noopener" class="btn-primary">
          Join the Community
        </a>
      </div>
    </section>

    <!-- ═══ CTA FINAL ═══ -->
    <section class="cta-section">
      <div class="cta-bg"></div>
      <div class="cta-grid-bg"></div>
      <div class="cta-content">
        <p class="section-label">Begin today</p>
        <h2 class="section-title" style="font-size:clamp(2.2rem,4vw,3.5rem);">A better life starts with<br><span class="gold-em">one frequency.</span></h2>
        <p style="color:rgba(200,220,255,.5); max-width:500px; margin:0 auto;">Browse our programs, subscribe for unlimited access, or book a personalized consultation with Dr. Éric Rosati.</p>
        <div class="cta-btns">
          <Link :href="route('shop')" class="btn-primary">Explore All Programs</Link>
          <Link :href="route('consultation')" class="btn-outline">Book a Consultation — €58</Link>
        </div>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue'

const props = defineProps({
  featuredPrograms: { type: Array, default: () => [] },
  categories:       { type: Array, default: () => [] },
  testimonials:     { type: Array, default: () => [] },
})

onMounted(() => {
  const io = new IntersectionObserver(
    entries => entries.forEach(e => e.isIntersecting && e.target.classList.add('visible')),
    { threshold: 0.1 }
  )
  document.querySelectorAll('.reveal').forEach(el => io.observe(el))
})

const allTestimonials = computed(() => props.testimonials || [])

const steps = [
  { icon: '🛒', badge: 'Instant access',  title: 'Choose your program',    desc: 'Browse 60+ protocols organized by health category. Each card shows full description, protocol details, and client reviews.' },
  { icon: '📩', badge: 'Within minutes',  title: 'Receive your link',      desc: 'After checkout, your secure program link arrives by email. Accessible immediately on any connected device — mobile or desktop.' },
  { icon: '🎧', badge: '18–35 min/day',   title: 'Put on your headphones', desc: 'Bone-conduction headphones required. Schedule a quiet 18–35 minute session daily. The Vitality wave is not audible — it works below perception.' },
  { icon: '📈', badge: '21–30 day cure',  title: 'Track your progress',    desc: 'Follow your 21–30 day protocol and observe the cumulative effect. Book a consultation for a fully personalized approach to complex conditions.' },
]

const areas = [
  { icon: '🦴', name: 'Locomotor',      examples: 'Lumbago · Osteoarthritis · Tendinitis · Joint pain' },
  { icon: '🌿', name: 'Digestive',      examples: 'Constipation · Gastric acidity · Liver drainage' },
  { icon: '😮‍💨', name: 'Emotional',      examples: 'Anxiety · Burn-out · Self-confidence · Depression' },
  { icon: '🛡', name: 'ENT & Immunity', examples: 'Sleep apnea · Immune defence · Allergy · Tinnitus' },
  { icon: '🌸', name: 'Hormonal',       examples: 'Menstrual cycles · Menopause · Libido · Weight' },
  { icon: '🧠', name: 'Neurological',   examples: 'Memory · Concentration · Migraine · Sleep' },
]

const fallbackPrograms = [
  { cat: '😮‍💨 Stress',    name: 'Anti-Stress',            desc: 'Deeply calms the nervous system and restores inner equilibrium through parasympathetic reactivation.' },
  { cat: '🌙 Sleep',    name: 'Sleeping Troubles',       desc: 'Restores healthy sleep cycles and deep restorative rest through delta wave entrainment.' },
  { cat: '🌸 Hormonal', name: 'Menopause — Hot Flushes', desc: 'Frequency rebalancing for hormonal transition, vasomotor symptoms, and night sweats.' },
  { cat: '🛡 Immunity', name: 'Allergy',                  desc: 'Desensitization frequencies to reduce histamine cascade severity for pollen, dust, and skin allergies.' },
]

const fallbackTestimonials = [
  { name: 'Fabienne',      program: 'Anti-Stress',      content: "An all-in-one solution — and without medication. I can't believe how effective this is." },
  { name: 'Caroline',      program: 'Allergy',          content: 'No more allergy after 1 month of frequencies. So happy with the results.' },
  { name: 'Karine',        program: 'Sleep + Menopause',content: "My insomnia and hot flashes are completely gone. I can't live without Vitality Inside." },
  { name: 'Marie-Hélène',  program: 'Depression',       content: 'I had low morale for months. Vitality Inside stabilized me with incredible efficiency.' },
  { name: 'Natacha',       program: 'Anti-Stress',      content: 'So easy to use — a genuine moment of relaxation while actually taking care of myself.' },
  { name: 'Sonia',         program: 'Menopause',        content: 'A real innovation. I live this new stage of my life so much more serenely.' },
  { name: 'Gérard',        program: 'Joint Pain',       content: 'My knee pain went from 8/10 to 2/10 after 3 weeks. I\'m back to gardening.' },
  { name: 'Pierre',        program: 'Burn-Out',         content: 'I went from not being able to get out of bed to feeling genuinely enthusiastic again.' },
]
</script>

<style scoped>
/* ─── HERO ─── */
.hero {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 120px 48px 80px;
  position: relative;
  overflow: hidden;
  background: #0a1628;
}
.hero-grid {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(13,115,119,.06) 1px, transparent 1px),
    linear-gradient(90deg, rgba(13,115,119,.06) 1px, transparent 1px);
  background-size: 60px 60px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
  -webkit-mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
}
.hero-glow-1 { position:absolute; width:800px; height:800px; border-radius:50%; background:radial-gradient(circle,rgba(13,115,119,.12) 0%,transparent 65%); top:50%; left:50%; transform:translate(-50%,-50%); animation:breathe 7s ease-in-out infinite; }
.hero-glow-2 { position:absolute; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle,rgba(200,169,110,.07) 0%,transparent 65%); top:30%; right:15%; animation:breathe 9s ease-in-out infinite 2s; }
.hero-glow-3 { position:absolute; width:300px; height:300px; border-radius:50%; background:radial-gradient(circle,rgba(13,115,119,.08) 0%,transparent 65%); bottom:20%; left:10%; animation:breathe 11s ease-in-out infinite 4s; }
@keyframes breathe { 0%,100%{ transform:translate(-50%,-50%) scale(1); } 50%{ transform:translate(-50%,-50%) scale(1.15); } }

.orbit-container { position:absolute; width:700px; height:700px; top:50%; left:50%; transform:translate(-50%,-50%); pointer-events:none; }
.orbit { position:absolute; border-radius:50%; border:1px solid transparent; top:50%; left:50%; transform:translate(-50%,-50%); }
.orbit-1 { width:280px; height:280px; border-color:rgba(13,115,119,.2); animation:orbit1 15s linear infinite; }
.orbit-2 { width:460px; height:460px; border-color:rgba(200,169,110,.1); animation:orbit1 28s linear infinite reverse; }
.orbit-3 { width:640px; height:640px; border-color:rgba(13,115,119,.07); animation:orbit1 45s linear infinite; }
@keyframes orbit1 { from{ transform:translate(-50%,-50%) rotate(0deg); } to{ transform:translate(-50%,-50%) rotate(360deg); } }
.orbit-dot { position:absolute; width:6px; height:6px; border-radius:50%; background:#14a8a0; top:-3px; left:50%; transform:translateX(-50%); box-shadow:0 0 10px rgba(20,168,160,.8); }
.orbit-dot-gold { background:#c8a96e; box-shadow:0 0 10px rgba(200,169,110,.8); }

.scan-line { position:absolute; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(13,115,119,.4),rgba(20,168,160,.6),rgba(13,115,119,.4),transparent); animation:scan 6s ease-in-out infinite; opacity:.6; }
@keyframes scan { 0%{ top:-2%; opacity:0; } 10%{ opacity:.6; } 90%{ opacity:.6; } 100%{ top:102%; opacity:0; } }

.hero-content { position:relative; z-index:2; max-width:820px; }
.hero-badge { display:inline-flex; align-items:center; gap:10px; background:rgba(13,115,119,.15); border:1px solid rgba(13,115,119,.4); padding:7px 20px; border-radius:100px; font-size:.72rem; letter-spacing:.14em; text-transform:uppercase; color:#14a8a0; margin-bottom:32px; backdrop-filter:blur(8px); }
.hero-badge-dot { width:6px; height:6px; border-radius:50%; background:#14a8a0; animation:blink 2s infinite; box-shadow:0 0 8px rgba(20,168,160,.8); }
@keyframes blink { 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:.3; transform:scale(.7); } }
.hero-sub { font-size:1.1rem; color:rgba(200,220,255,.65); line-height:1.75; max-width:620px; margin:0 auto 48px; }

.hero-stats { display:flex; justify-content:center; gap:48px; margin-bottom:48px; flex-wrap:wrap; }
.hstat { text-align:center; padding:20px 28px; background:rgba(13,115,119,.08); border:1px solid rgba(13,115,119,.2); border-radius:12px; backdrop-filter:blur(8px); position:relative; overflow:hidden; }
.hstat::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,#14a8a0,transparent); }
.hstat-val { font-family:'Cormorant Garamond',serif; font-size:2.4rem; color:#c8a96e; line-height:1; display:block; }
.hstat-lbl { font-size:.72rem; color:rgba(200,220,255,.4); text-transform:uppercase; letter-spacing:.1em; margin-top:4px; }

.hero-btns { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; }
.btn-primary { background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; border:none; padding:16px 40px; border-radius:6px; font-size:.9rem; font-weight:500; letter-spacing:.04em; cursor:pointer; text-decoration:none; transition:transform .2s,box-shadow .2s; box-shadow:0 8px 32px rgba(13,115,119,.4); display:inline-block; }
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 14px 44px rgba(13,115,119,.6); }
.btn-outline { background:transparent; border:1px solid rgba(200,169,110,.2); color:#e8d5a3; padding:16px 40px; border-radius:6px; font-size:.9rem; cursor:pointer; text-decoration:none; transition:all .2s; display:inline-block; }
.btn-outline:hover { border-color:#c8a96e; background:rgba(200,169,110,.07); }

.scroll-hint { position:absolute; bottom:36px; left:50%; transform:translateX(-50%); display:flex; flex-direction:column; align-items:center; gap:8px; z-index:2; }
.scroll-hint span { font-size:.68rem; letter-spacing:.12em; color:rgba(255,255,255,.25); text-transform:uppercase; }
.scroll-arrow { width:1px; height:40px; background:linear-gradient(to bottom,rgba(13,115,119,.6),transparent); animation:scrollArrow 2s ease-in-out infinite; }
@keyframes scrollArrow { 0%,100%{ opacity:.3; transform:scaleY(.8); } 50%{ opacity:1; transform:scaleY(1); } }

/* ─── SECTIONS ─── */
.section-label { font-size:.72rem; letter-spacing:.18em; text-transform:uppercase; margin-bottom:14px; color:#14a8a0; }
.section-title { font-family:'Cormorant Garamond',serif; font-size:clamp(2rem,3.5vw,3rem); font-weight:300; line-height:1.2; margin-bottom:20px; color:#ffffff; }
.gold-em { color:#c8a96e; font-style:italic; font-family:'Cormorant Garamond',serif; }
.body-text { color:rgba(200,220,255,.65); }

/* ─── HOW IT WORKS ─── */
.how-section { background:#0d1f3a; border-top:1px solid rgba(200,169,110,.2); border-bottom:1px solid rgba(200,169,110,.2); padding:100px 48px; position:relative; overflow:hidden; }
.how-section::before { content:''; position:absolute; inset:0; background-image:linear-gradient(rgba(13,115,119,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(13,115,119,.04) 1px,transparent 1px); background-size:40px 40px; pointer-events:none; }
.how-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; position:relative; z-index:1; max-width:1200px; margin:0 auto; }
.how-step { background:#0a1628; border:1px solid rgba(200,169,110,.2); border-radius:16px; padding:32px 24px; text-align:center; position:relative; overflow:hidden; transition:border-color .3s,transform .3s; }
.how-step:hover { border-color:rgba(13,115,119,.5); transform:translateY(-5px); }
.how-num { width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg,#0d7377,#14a8a0); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.5rem; margin:0 auto 20px; color:#fff; box-shadow:0 0 24px rgba(13,115,119,.5),0 0 48px rgba(13,115,119,.2); }
.how-title { font-family:'Cormorant Garamond',serif; font-size:1.2rem; margin-bottom:10px; color:#ffffff; }
.how-text { font-size:.82rem; color:rgba(200,220,255,.55); line-height:1.65; }
.how-tag { display:inline-block; margin-top:14px; background:rgba(13,115,119,.15); border:1px solid rgba(13,115,119,.25); color:#14a8a0; font-size:.68rem; padding:3px 12px; border-radius:100px; letter-spacing:.06em; text-transform:uppercase; }

/* ─── PATHOLOGY MAP ─── */
.pathology-section { background:#0a1628; padding:100px 48px; }
.pathology-intro { display:grid; grid-template-columns:1fr 1fr; gap:80px; align-items:center; max-width:1200px; margin:0 auto; }
.pathology-systems { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
.sys-card { background:#0d1f3a; border:1px solid rgba(200,169,110,.2); border-radius:14px; padding:22px; transition:all .3s; cursor:default; position:relative; overflow:hidden; }
.sys-card:hover { border-color:rgba(13,115,119,.5); transform:translateY(-3px); }
.sys-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#0d7377,#14a8a0); transform:scaleX(0); transition:transform .3s; transform-origin:left; }
.sys-card:hover::before { transform:scaleX(1); }
.sys-icon { font-size:1.6rem; display:block; margin-bottom:12px; }
.sys-name { font-family:'Cormorant Garamond',serif; font-size:1.1rem; color:#ffffff; margin-bottom:6px; }
.sys-examples { font-size:.75rem; color:rgba(200,220,255,.4); line-height:1.5; }

/* ─── FEATURED PROGRAMS ─── */
.programs-section { background:#0d1f3a; border-top:1px solid rgba(200,169,110,.2); padding:100px 48px; max-width:100%; }
.prog-carousel { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:40px; max-width:1200px; margin-left:auto; margin-right:auto; }
.prog-feat-card { background:#0a1628; border:1px solid rgba(200,169,110,.2); border-radius:14px; padding:24px; transition:all .3s; position:relative; overflow:hidden; cursor:pointer; }
.prog-feat-card:hover { border-color:rgba(13,115,119,.5); transform:translateY(-4px); }
.prog-feat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#0d7377,#14a8a0); transform:scaleX(0); transition:transform .35s; transform-origin:left; }
.prog-feat-card:hover::before { transform:scaleX(1); }
.pfc-cat { font-size:.68rem; letter-spacing:.12em; text-transform:uppercase; color:#14a8a0; margin-bottom:10px; }
.pfc-name { font-family:'Cormorant Garamond',serif; font-size:1.2rem; color:#ffffff; margin-bottom:8px; }
.pfc-desc { font-size:.78rem; color:rgba(200,220,255,.45); line-height:1.5; margin-bottom:16px; }
.pfc-footer { display:flex; align-items:center; justify-content:space-between; }
.pfc-price { color:#c8a96e; font-size:1.1rem; font-weight:500; }
.pfc-btn { background:rgba(13,115,119,.2); border:1px solid rgba(13,115,119,.35); color:#14a8a0; font-size:.72rem; padding:5px 12px; border-radius:5px; cursor:pointer; transition:all .2s; text-decoration:none; }
.pfc-btn:hover { background:rgba(13,115,119,.4); color:#fff; }
.pfc-badge { position:absolute; top:14px; right:14px; background:rgba(200,169,110,.15); border:1px solid rgba(200,169,110,.3); color:#e8d5a3; font-size:.62rem; padding:2px 10px; border-radius:100px; }

/* ─── SUBSCRIPTION BANNER ─── */
.sub-banner { background:linear-gradient(135deg,rgba(13,115,119,.25),rgba(10,22,40,.9)); border:1px solid #0d7377; border-radius:20px; padding:48px 56px; display:flex; align-items:center; justify-content:space-between; gap:40px; position:relative; overflow:hidden; margin:0 48px 100px; }
.sub-banner::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,transparent,#14a8a0,#c8a96e,#14a8a0,transparent); }
.sub-banner-glow { position:absolute; right:-100px; top:-100px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle,rgba(13,115,119,.12) 0%,transparent 65%); pointer-events:none; }
.sub-left { position:relative; z-index:1; }
.sub-tag { font-size:.7rem; letter-spacing:.14em; text-transform:uppercase; color:#14a8a0; margin-bottom:12px; }
.sub-title { font-family:'Cormorant Garamond',serif; font-size:2rem; color:#ffffff; margin-bottom:8px; }
.sub-desc { font-size:.88rem; color:rgba(200,220,255,.55); max-width:420px; }
.sub-right { display:flex; flex-direction:column; align-items:flex-end; gap:16px; position:relative; z-index:1; flex-shrink:0; }
.sub-price-display { text-align:right; }
.sub-price { font-family:'Cormorant Garamond',serif; font-size:3rem; color:#c8a96e; line-height:1; }
.sub-price-lbl { font-size:.78rem; color:rgba(200,220,255,.35); }

/* ─── TESTIMONIALS TICKER ─── */
.testimonials-section { background:#0a1628; border-top:1px solid rgba(200,169,110,.2); overflow:hidden; padding:100px 48px; }
.ticker-wrapper { overflow:hidden; position:relative; }
.ticker-wrapper::before,.ticker-wrapper::after { content:''; position:absolute; top:0; bottom:0; width:120px; z-index:2; pointer-events:none; }
.ticker-wrapper::before { left:0; background:linear-gradient(90deg,#0a1628,transparent); }
.ticker-wrapper::after { right:0; background:linear-gradient(270deg,#0a1628,transparent); }
.ticker-track { display:flex; gap:20px; animation:ticker 40s linear infinite; width:max-content; }
.ticker-track:hover { animation-play-state:paused; }
.review-card { background:#0d1f3a; border:1px solid rgba(200,169,110,.2); border-radius:12px; padding:24px; min-width:300px; max-width:300px; flex-shrink:0; border-left:2px solid #0d7377; }
.review-stars { color:#c8a96e; font-size:.8rem; margin-bottom:10px; }
.review-text { font-family:'Cormorant Garamond',serif; font-size:1rem; font-style:italic; line-height:1.55; color:rgba(255,255,255,.82); margin-bottom:12px; }
.review-meta { font-size:.75rem; color:rgba(200,220,255,.4); display:flex; align-items:center; gap:8px; }
.review-meta::before { content:''; width:16px; height:1px; background:#0d7377; flex-shrink:0; }
@keyframes ticker { 0%{ transform:translateX(0); } 100%{ transform:translateX(-50%); } }

/* ─── DR ROSATI ─── */
.doctor-section { background:#0d1f3a; border-top:1px solid rgba(200,169,110,.2); border-bottom:1px solid rgba(200,169,110,.2); padding:100px 48px; }
.doctor-grid { display:grid; grid-template-columns:auto 1fr; gap:60px; align-items:center; max-width:900px; margin:0 auto; }
.doctor-avatar { width:160px; height:160px; border-radius:50%; background:linear-gradient(145deg,rgba(13,115,119,.3),rgba(10,22,40,.8)); border:2px solid #0d7377; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0; position:relative; }
.doctor-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.doctor-avatar::after { content:''; position:absolute; inset:-2px; border-radius:50%; border:1px solid rgba(13,115,119,.3); animation:ringPulse 3s ease-in-out infinite; }
@keyframes ringPulse { 0%,100%{ transform:scale(1); opacity:.5; } 50%{ transform:scale(1.06); opacity:1; } }
.doctor-name { font-family:'Cormorant Garamond',serif; font-size:1.8rem; color:#ffffff; margin-bottom:4px; }
.doctor-title { font-size:.78rem; color:#14a8a0; letter-spacing:.08em; text-transform:uppercase; margin-bottom:16px; }
.doctor-bio { font-size:.9rem; color:rgba(200,220,255,.6); line-height:1.7; margin-bottom:20px; }
.doctor-tags { display:flex; flex-wrap:wrap; gap:8px; }
.dtag { background:rgba(13,115,119,.12); border:1px solid rgba(13,115,119,.2); color:#14a8a0; font-size:.72rem; padding:4px 14px; border-radius:100px; }

/* ─── COMMUNITY ─── */
.community-section { background:#0a1628; text-align:center; padding:100px 48px; }
.community-number { font-family:'Cormorant Garamond',serif; font-size:clamp(3.5rem,7vw,6rem); color:#c8a96e; line-height:1; margin-bottom:8px; position:relative; display:inline-block; }
.community-number::after { content:''; position:absolute; bottom:-8px; left:50%; transform:translateX(-50%); width:60%; height:1px; background:linear-gradient(90deg,transparent,#0d7377,transparent); }
.community-label { font-size:.85rem; color:rgba(200,220,255,.45); letter-spacing:.08em; text-transform:uppercase; margin-bottom:48px; }
.community-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:12px; max-width:900px; margin:0 auto 48px; }
.comm-img { aspect-ratio:1; border-radius:12px; background:linear-gradient(145deg,rgba(13,115,119,.2),rgba(10,22,40,.8)); border:1px solid rgba(200,169,110,.2); overflow:hidden; }
.comm-img img { width:100%; height:100%; object-fit:cover; opacity:.7; transition:opacity .3s; }
.comm-img:hover img { opacity:1; }

/* ─── CTA FINAL ─── */
.cta-section { text-align:center; position:relative; overflow:hidden; padding:140px 48px; background:#0a1628; border-top:1px solid rgba(200,169,110,.2); }
.cta-bg { position:absolute; inset:0; background:radial-gradient(ellipse 70% 80% at 50% 50%,rgba(13,115,119,.15) 0%,transparent 70%); pointer-events:none; }
.cta-grid-bg { position:absolute; inset:0; background-image:linear-gradient(rgba(13,115,119,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(13,115,119,.04) 1px,transparent 1px); background-size:40px 40px; mask-image:radial-gradient(ellipse 70% 80% at 50% 50%,black,transparent); -webkit-mask-image:radial-gradient(ellipse 70% 80% at 50% 50%,black,transparent); pointer-events:none; }
.cta-content { position:relative; z-index:2; }
.cta-btns { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; margin-top:40px; }

/* ─── RESPONSIVE ─── */
@media (max-width:1000px) {
  .hero { padding:120px 24px 80px; }
  .how-section,.pathology-section,.programs-section,.testimonials-section,.doctor-section,.community-section,.cta-section { padding:72px 24px; }
  .sub-banner { flex-direction:column; align-items:flex-start; margin:0 24px 72px; padding:32px; }
  .sub-right { align-items:flex-start; }
  .how-grid { grid-template-columns:1fr 1fr; }
  .pathology-intro { grid-template-columns:1fr; gap:40px; }
  .pathology-systems { grid-template-columns:1fr 1fr; }
  .prog-carousel { grid-template-columns:1fr 1fr; }
  .doctor-grid { grid-template-columns:1fr; text-align:center; }
  .doctor-avatar { margin:0 auto; }
  .doctor-tags { justify-content:center; }
  .community-grid { grid-template-columns:repeat(4,1fr); }
  .hero-stats { gap:16px; }
}
@media (max-width:600px) {
  .how-grid,.prog-carousel,.pathology-systems { grid-template-columns:1fr; }
  .community-grid { grid-template-columns:repeat(3,1fr); }
  .hero-btns { flex-direction:column; align-items:center; }
}
</style>
