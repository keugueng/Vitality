<template>
  <AppLayout>

    <!-- ─── HERO ─── -->
    <section class="hero">
      <div class="hero-bg"></div>
      <div class="hero-glow"></div>
      <div class="hero-left">
        <div class="hero-badge"><span class="hero-badge-dot"></span>{{ t('consultation.badge') }}</div>
        <h1>{{ t('consultation.hero_title') }}<br><em>{{ t('consultation.hero_title_em') }}</em></h1>
        <p class="hero-sub">{{ t('consultation.hero_sub') }}</p>
        <div class="hero-price-block">
          <span class="hero-price">€58</span>
          <span class="hero-price-label">{{ t('consultation.hero_price_label') }}</span>
        </div>
        <div class="hero-btns">
          <button v-if="isAuthenticated" class="btn-primary" @click="handleReserve('single')">{{ t('consultation.hero_reserve_btn') }}</button>
          <Link v-else :href="route('register')" class="btn-primary">{{ t('consultation.hero_reserve_btn') }}</Link>
          <a href="#packages" class="btn-outline">{{ t('consultation.packages_label') }} →</a>
        </div>
      </div>
      <div class="hero-right">
        <div class="consult-visual">
          <div class="consult-card">
            <p class="consult-card-label">{{ t('consultation.hero_card_label') }}</p>
            <h3 class="consult-card-title">{{ t('consultation.hero_card_title') }}</h3>
            <p class="consult-card-sub">{{ t('consultation.hero_card_sub') }}</p>
            <div class="consult-steps-mini">
              <div class="csm"><div class="csm-dot">1</div><span class="csm-text">{{ t('consultation.hero_card_step1') }}</span></div>
              <div class="csm"><div class="csm-dot">2</div><span class="csm-text">{{ t('consultation.hero_card_step2') }}</span></div>
              <div class="csm"><div class="csm-dot">3</div><span class="csm-text">{{ t('consultation.hero_card_step3') }}</span></div>
              <div class="csm"><div class="csm-dot">4</div><span class="csm-text">{{ t('consultation.hero_card_step4') }}</span></div>
            </div>
            <div class="consult-card-price">
              <span class="ccp-amount">€58</span>
              <span class="ccp-label">{{ t('consultation.hero_card_price_label') }}</span>
              <span class="ccp-badge">{{ t('consultation.hero_card_badge') }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ─── HOW IT WORKS ─── -->
    <section class="how-section" id="how">
      <div style="text-align:center;margin-bottom:60px">
        <p class="section-label">{{ t('consultation.how_label') }}</p>
        <h2 class="section-title">{{ t('consultation.how_title') }}<br><span class="gold-em">{{ t('consultation.how_title_em') }}</span></h2>
      </div>
      <div class="how-grid">
        <div v-for="(step, i) in consultSteps" :key="i" class="how-step">
          <div class="how-num">{{ i + 1 }}</div>
          <h4 class="step-title">{{ step.title }}</h4>
          <p class="step-text">{{ step.desc }}</p>
          <span class="step-time">{{ step.badge }}</span>
        </div>
      </div>
    </section>

    <!-- ─── PACKAGES ─── -->
    <section class="packages-section" id="packages">
      <div style="text-align:center;margin-bottom:60px">
        <p class="section-label">{{ t('consultation.packages_label') }}</p>
        <h2 class="section-title">{{ t('consultation.packages_title') }}<br><span class="gold-em">{{ t('consultation.packages_title_em') }}</span></h2>
        <p class="body-text" style="max-width:500px;margin:0 auto">{{ t('consultation.packages_desc') }}</p>
      </div>
      <div class="packages-grid">
        <div v-for="pkg in packages" :key="pkg.id"
          class="pkg-card" :class="{ featured: pkg.featured, selected: selectedPackageType === pkg.id }"
          @click="selectedPackageType = pkg.id">
          <div v-if="pkg.featured" class="pkg-featured-badge">{{ t('consultation.pkg_most_popular') }}</div>
          <p class="pkg-sessions">{{ pkg.sessionsLabel }}</p>
          <h3 class="pkg-name">{{ pkg.name }}</h3>
          <p class="pkg-desc">{{ pkg.tagline }}</p>
          <div class="pkg-price"><span class="pkg-currency">€</span><span class="pkg-amount">{{ pkg.amount }}</span></div>
          <p class="pkg-saving" :style="!pkg.saving ? 'color:rgba(200,220,255,0.35)' : ''">{{ pkg.saving || t('consultation.pkg_standard_price') }}</p>
          <ul class="pkg-features">
            <li v-for="f in pkg.features" :key="f"><span class="pkg-check">✦</span>{{ f }}</li>
          </ul>
          <button class="pkg-btn" :class="pkg.featured ? 'pkg-btn-primary' : 'pkg-btn-outline'"
            @click.stop="handleReserve(pkg.id)">
            {{ pkg.label }}
          </button>
        </div>
      </div>
    </section>

    <!-- ─── WHAT'S INCLUDED ─── -->
    <section class="included-section" id="book">
      <div class="included-grid">
        <div>
          <p class="section-label">{{ t('consultation.included2_label') }}</p>
          <h2 class="section-title">{{ t('consultation.included2_title') }}<br>pour <span class="gold-em">{{ t('consultation.included2_title_em') }}</span></h2>
          <div class="features-list">
            <div class="feat-item">
              <div class="feat-icon">🧬</div>
              <div>
                <h4 class="feat-title">{{ t('consultation.feat1_title') }}</h4>
                <p class="feat-text">{{ t('consultation.feat1_text') }}</p>
              </div>
            </div>
            <div class="feat-item">
              <div class="feat-icon">🎧</div>
              <div>
                <h4 class="feat-title">{{ t('consultation.feat2_title') }}</h4>
                <p class="feat-text">{{ t('consultation.feat2_text') }}</p>
              </div>
            </div>
            <div class="feat-item">
              <div class="feat-icon">📩</div>
              <div>
                <h4 class="feat-title">{{ t('consultation.feat3_title') }}</h4>
                <p class="feat-text">{{ t('consultation.feat3_text') }}</p>
              </div>
            </div>
            <div class="feat-item">
              <div class="feat-icon">📋</div>
              <div>
                <h4 class="feat-title">{{ t('consultation.feat4_title') }}</h4>
                <p class="feat-text">{{ t('consultation.feat4_text') }}</p>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="included-visual">
            <h3 class="iv-title">{{ t('consultation.privacy_title') }}</h3>
            <p class="iv-sub">{{ t('consultation.privacy_sub') }}</p>
            <div class="consent-block">
              <p class="consent-title">{{ t('consultation.consent1_title') }}</p>
              <p class="consent-text">{{ t('consultation.consent1_text') }}</p>
            </div>
            <div class="consent-block">
              <p class="consent-title">{{ t('consultation.consent2_title') }}</p>
              <p class="consent-text">{{ t('consultation.consent2_text') }}</p>
            </div>
            <div class="data-pills">
              <span class="data-pill">{{ t('consultation.pill1') }}</span>
              <span class="data-pill">{{ t('consultation.pill2') }}</span>
              <span class="data-pill">{{ t('consultation.pill3') }}</span>
              <span class="data-pill">{{ t('consultation.pill4') }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    
    <!-- ─── TESTIMONIALS ─── -->
    <section class="reviews-section">
      <div style="text-align:center;margin-bottom:60px">
        <p class="section-label">{{ t('consultation.testimonials_label') }}</p>
        <h2 class="section-title">{{ t('consultation.testimonials_title') }}<br><span class="gold-em">{{ t('consultation.testimonials_title_em') }}</span></h2>
      </div>
      <div class="reviews-grid">
        <div v-for="r in consultTestimonials" :key="r.name" class="review-card">
          <div class="review-stars">★★★★★</div>
          <p class="review-text">« {{ r.content }} »</p>
          <p class="review-author">{{ r.name }}</p>
          <p class="review-program">{{ r.program }}</p>
        </div>
      </div>
    </section>

    <!-- ─── FAQ ─── -->
    <section class="faq-section">
      <div style="text-align:center;margin-bottom:60px">
        <p class="section-label">FAQ</p>
        <h2 class="section-title">{{ t('consultation.faq_title') }} <span class="gold-em">{{ t('consultation.faq_title_em') }}</span></h2>
      </div>
      <div class="faq-list">
        <div v-for="q in faqs" :key="q.q" class="faq-item" :class="{ open: openFaq === q.q }">
          <div class="faq-question" @click="toggleFaq(q.q)">
            {{ q.q }}
            <span class="faq-icon">+</span>
          </div>
          <div class="faq-answer">{{ q.a }}</div>
        </div>
      </div>
    </section>

    <!-- ─── DISCLAIMER ─── -->
    <section class="disclaimer-section">
      <div class="disclaimer-box">
        <p class="disclaimer-title">{{ t('consultation.disclaimer_title') }}</p>
        <p class="disclaimer-text">{{ t('consultation.disclaimer_text') }}</p>
      </div>
    </section>

    <!-- ─── CTA ─── -->
    <section class="cta-section">
      <p class="section-label">{{ t('consultation.cta_label') }}</p>
      <h2 class="section-title">{{ t('consultation.cta_title') }}<br><span class="gold-em">{{ t('consultation.cta_title_em') }}</span></h2>
      <p class="cta-sub">{{ t('consultation.cta_sub') }}</p>
      <div class="cta-btns">
        <button v-if="isAuthenticated" class="btn-primary" @click="handleReserve('single')">{{ t('consultation.cta_reserve_btn') }}</button>
        <Link v-else :href="route('register')" class="btn-primary">{{ t('consultation.cta_reserve_btn') }}</Link>
        <Link :href="route('shop')" class="btn-outline">{{ t('consultation.cta_btn2') }}</Link>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm, usePage, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { useI18n } from '@/composables/useI18n'

const page = usePage()
const isAuthenticated = computed(() => !!page.props.auth?.user)
const { t } = useI18n()

function handleReserve(pkgId) {
  if (!isAuthenticated.value) {
    router.visit(route('register'))
    return
  }
  router.post(route('cart.add-consultation'), { package_type: pkgId })
}

const selectedPackageType = ref('single')

const openFaq = ref(null)
function toggleFaq(q) {
  openFaq.value = openFaq.value === q ? null : q
}

const packages = computed(() => [
  {
    id: 'single', name: t('consultation.pkg1_name'), price: 58, amount: '58', sessions: 1,
    sessionsLabel: t('consultation.pkg1_sessions_label'),
    label: t('consultation.pkg1_label'), tagline: t('consultation.pkg1_tagline'), saving: null,
    features: [t('consultation.pkg1_feat1'), t('consultation.pkg1_feat2'), t('consultation.pkg1_feat3'), t('consultation.pkg1_feat4')],
  },
  {
    id: 'progress', name: t('consultation.pkg2_name'), price: 149, amount: '149', sessions: 3,
    sessionsLabel: t('consultation.pkg2_sessions_label'),
    featured: true, label: t('consultation.pkg2_label'),
    tagline: t('consultation.pkg2_tagline'),
    saving: t('consultation.pkg2_saving'),
    features: [t('consultation.pkg2_feat1'), t('consultation.pkg2_feat2'), t('consultation.pkg2_feat3'), t('consultation.pkg2_feat4'), t('consultation.pkg2_feat5')],
  },
  {
    id: 'transform', name: t('consultation.pkg3_name'), price: 239, amount: '239', sessions: 5,
    sessionsLabel: t('consultation.pkg3_sessions_label'),
    label: t('consultation.pkg3_label'),
    tagline: t('consultation.pkg3_tagline'),
    saving: t('consultation.pkg3_saving'),
    features: [t('consultation.pkg3_feat1'), t('consultation.pkg3_feat2'), t('consultation.pkg3_feat3'), t('consultation.pkg3_feat4'), t('consultation.pkg3_feat5')],
  },
])

const consultSteps = computed(() => [
  { title: t('consultation.step1_title'), desc: t('consultation.step1_desc'), badge: t('consultation.step1_badge') },
  { title: t('consultation.step2_title'), desc: t('consultation.step2_desc'), badge: t('consultation.step2_badge') },
  { title: t('consultation.step3_title'), desc: t('consultation.step3_desc'), badge: t('consultation.step3_badge') },
  { title: t('consultation.step4_title'), desc: t('consultation.step4_desc'), badge: t('consultation.step4_badge') },
])

const consultTestimonials = [
  { content: 'J\'ai décrit mes symptômes de burn-out dans le formulaire et reçu un protocole incroyablement précis en 6 heures. Après 3 semaines je me sentais à nouveau moi-même — ce qu\'aucun médecin n\'avait réussi en 2 ans.', name: 'Marie-Hélène C.', program: 'Protocole Burn-Out' },
  { content: 'Le questionnaire était approfondi et l\'analyse clairement personnelle — pas une réponse générique. Mon protocole insomnie était parfaitement calibré à mon cas. Résultats en moins de 2 semaines.', name: 'Bernard T.', program: 'Protocole Troubles du Sommeil' },
  { content: 'J\'ai réservé la formule 3 séances pour mes douleurs articulaires chroniques. Chaque consultation a affiné le protocole selon mes progrès. À la 3e séance, j\'avais réduit mes anti-inflammatoires de 80%.', name: 'Gérard F.', program: 'Douleur Articulaire — formule 3 séances' },
  { content: 'Ce qui m\'a le plus impressionné c\'est la vitesse et la précision. Le Dr. Rosati a identifié un lien entre mon anxiété et mes problèmes digestifs que je n\'avais jamais envisagé. Le protocole combiné était remarquable.', name: 'Élise R.', program: 'Protocole Anxiété + Digestif' },
  { content: 'J\'étais sceptique face à une consultation en ligne, mais la profondeur du questionnaire et la personnalisation de la réponse ont changé mon avis immédiatement. Ma saison allergique cette année était tout à fait gérable.', name: 'Étienne M.', program: 'Protocole Allergie' },
  { content: 'J\'ai effectué 5 consultations sur 8 mois pour mes symptômes de ménopause. L\'évolution de chaque protocole montre un vrai suivi et une compréhension de mon cas. Bouffées de chaleur réduites de 90%.', name: 'Françoise D.', program: 'Ménopause — formule Transformation' },
]

const faqs = computed(() => [
  { q: t('consultation.faq1_q'), a: t('consultation.faq1_a') },
  { q: t('consultation.faq2_q'), a: t('consultation.faq2_a') },
  { q: t('consultation.faq3_q'), a: t('consultation.faq3_a') },
  { q: t('consultation.faq4_q'), a: t('consultation.faq4_a') },
  { q: t('consultation.faq5_q'), a: t('consultation.faq5_a') },
  { q: t('consultation.faq6_q'), a: t('consultation.faq6_a') },
])

</script>

<style scoped>
/* ─── HERO ─── */
.hero{min-height:100vh;display:grid;grid-template-columns:1fr 1fr;align-items:center;padding:120px 48px 80px;gap:80px;position:relative;overflow:hidden;background:#0a1628}
.hero-bg{position:absolute;inset:0;background:radial-gradient(ellipse 55% 70% at 65% 45%,rgba(13,115,119,.18) 0%,transparent 65%),radial-gradient(ellipse 35% 45% at 5% 85%,rgba(200,169,110,.07) 0%,transparent 55%);pointer-events:none}
.hero-glow{position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(13,115,119,.08) 0%,transparent 70%);right:-100px;top:50%;transform:translateY(-50%);animation:glowPulse 6s ease-in-out infinite;pointer-events:none}
@keyframes glowPulse{0%,100%{transform:translateY(-50%) scale(1);opacity:.7}50%{transform:translateY(-50%) scale(1.1);opacity:1}}
.hero-left{position:relative;z-index:2}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(13,115,119,.2);border:1px solid rgba(13,115,119,.4);padding:6px 16px;border-radius:100px;font-size:.75rem;letter-spacing:.1em;text-transform:uppercase;color:#14a8a0;margin-bottom:28px}
.hero-badge-dot{width:6px;height:6px;border-radius:50%;background:#14a8a0;animation:blink 2s infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}
.hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(2.8rem,4.5vw,5rem);font-weight:300;line-height:1.05;margin-bottom:24px;color:#ffffff}
.hero h1 em{color:#c8a96e;font-style:italic;display:block}
.hero-sub{font-size:1rem;color:rgba(200,220,255,0.65);line-height:1.75;margin-bottom:40px;max-width:480px}
.hero-price-block{display:flex;align-items:baseline;gap:12px;margin-bottom:36px}
.hero-price{font-family:'Cormorant Garamond',serif;font-size:3.5rem;color:#c8a96e;line-height:1}
.hero-price-label{font-size:.85rem;color:rgba(200,220,255,0.4)}
.hero-btns{display:flex;gap:16px;flex-wrap:wrap}
.btn-primary{background:linear-gradient(135deg,#0d7377,#14a8a0);color:#fff;border:none;padding:16px 36px;border-radius:6px;font-size:.9rem;font-weight:500;letter-spacing:.04em;cursor:pointer;text-decoration:none;transition:transform .2s,box-shadow .2s;box-shadow:0 8px 32px rgba(13,115,119,.35);display:inline-block}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 12px 40px rgba(13,115,119,.5)}
.btn-outline{background:transparent;border:1px solid rgba(200,169,110,.2);color:#e8d5a3;padding:16px 36px;border-radius:6px;font-size:.9rem;cursor:pointer;text-decoration:none;transition:border-color .2s,background .2s;display:inline-block}
.btn-outline:hover{border-color:#c8a96e;background:rgba(200,169,110,.07)}

/* HERO RIGHT — Visual card */
.hero-right{position:relative;z-index:2;display:flex;justify-content:center;align-items:center}
.consult-visual{width:380px;max-width:100%;position:relative}
.consult-card{background:#0d1f3a;border:1px solid rgba(200,169,110,.2);border-radius:20px;padding:36px;position:relative;overflow:hidden}
.consult-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#0d7377,#14a8a0)}
.consult-card-label{font-size:.7rem;letter-spacing:.14em;text-transform:uppercase;color:#14a8a0;margin-bottom:20px}
.consult-card-title{font-family:'Cormorant Garamond',serif;font-size:1.6rem;color:#ffffff;margin-bottom:8px;font-weight:300}
.consult-card-sub{font-size:.82rem;color:rgba(200,220,255,0.5);margin-bottom:28px}
.consult-steps-mini{display:flex;flex-direction:column;gap:14px;margin-bottom:28px}
.csm{display:flex;align-items:center;gap:12px}
.csm-dot{width:32px;height:32px;border-radius:50%;background:rgba(13,115,119,.2);border:1px solid rgba(13,115,119,.35);display:flex;align-items:center;justify-content:center;font-size:.75rem;color:#14a8a0;flex-shrink:0;font-family:'Cormorant Garamond',serif}
.csm-text{font-size:.82rem;color:rgba(200,220,255,0.7)}
.consult-card-price{display:flex;align-items:baseline;gap:8px;padding-top:20px;border-top:1px solid rgba(200,169,110,.2)}
.ccp-amount{font-family:'Cormorant Garamond',serif;font-size:2.2rem;color:#c8a96e}
.ccp-label{font-size:.78rem;color:rgba(200,220,255,0.35)}
.ccp-badge{margin-left:auto;background:rgba(13,115,119,.2);border:1px solid rgba(13,115,119,.3);color:#14a8a0;font-size:.68rem;padding:4px 12px;border-radius:100px;letter-spacing:.06em;text-transform:uppercase}

/* ─── SECTIONS ─── */
.section-label{font-size:.72rem;letter-spacing:.18em;text-transform:uppercase;margin-bottom:14px;color:#14a8a0}
.section-title{font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,3.5vw,3rem);font-weight:300;line-height:1.2;margin-bottom:20px;color:#ffffff}
.body-text{font-size:.95rem;line-height:1.8;color:rgba(200,220,255,0.65)}
.gold-em{color:#c8a96e;font-style:italic}

/* ─── HOW IT WORKS ─── */
.how-section{background:#0d1f3a;border-top:1px solid rgba(200,169,110,.2);border-bottom:1px solid rgba(200,169,110,.2);padding:100px 48px}
.how-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;position:relative;max-width:1100px;margin:0 auto}
.how-grid::before{content:'';position:absolute;top:36px;left:calc(12.5% + 20px);right:calc(12.5% + 20px);height:1px;background:linear-gradient(90deg,transparent,#0d7377,#14a8a0,#0d7377,transparent);z-index:0}
.how-step{background:#0a1628;border:1px solid rgba(200,169,110,.2);border-radius:14px;padding:28px 22px;text-align:center;position:relative;z-index:1;transition:border-color .3s,transform .3s}
.how-step:hover{border-color:rgba(13,115,119,.5);transform:translateY(-4px)}
.how-num{width:52px;height:52px;border-radius:50%;background:linear-gradient(135deg,#0d7377,#14a8a0);display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:1.4rem;margin:0 auto 20px;color:#fff;box-shadow:0 4px 20px rgba(13,115,119,.4)}
.step-title{font-family:'Cormorant Garamond',serif;font-size:1.15rem;margin-bottom:10px;color:#ffffff}
.step-text{font-size:.82rem;line-height:1.65;color:rgba(200,220,255,0.55)}
.step-time{display:inline-block;margin-top:12px;background:rgba(13,115,119,.15);border:1px solid rgba(13,115,119,.25);color:#14a8a0;font-size:.68rem;padding:3px 12px;border-radius:100px;letter-spacing:.06em;text-transform:uppercase}

/* ─── PACKAGES ─── */
.packages-section{background:#0a1628;padding:100px 48px}
.packages-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:1000px;margin:0 auto}
.pkg-card{background:#0d1f3a;border:1px solid rgba(200,169,110,.2);border-radius:16px;padding:32px;position:relative;transition:transform .3s,border-color .3s;cursor:pointer}
.pkg-card:hover{transform:translateY(-4px);border-color:rgba(200,169,110,.4)}
.pkg-card.featured{border-color:#0d7377;background:linear-gradient(145deg,rgba(13,115,119,.2),#0d1f3a)}
.pkg-card.selected{border-color:#14a8a0;box-shadow:0 0 30px rgba(13,115,119,.25)}
.pkg-featured-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,#0d7377,#14a8a0);padding:4px 18px;border-radius:100px;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;white-space:nowrap;color:#fff}
.pkg-sessions{font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;color:#14a8a0;margin-bottom:10px}
.pkg-name{font-family:'Cormorant Garamond',serif;font-size:1.6rem;margin-bottom:6px;color:#ffffff}
.pkg-desc{font-size:.82rem;margin-bottom:24px;color:rgba(200,220,255,0.55)}
.pkg-price{display:flex;align-items:baseline;gap:6px;margin-bottom:8px}
.pkg-amount{font-family:'Cormorant Garamond',serif;font-size:2.8rem;color:#c8a96e;line-height:1}
.pkg-currency{font-size:1.2rem;color:#c8a96e;align-self:flex-start;margin-top:6px}
.pkg-saving{font-size:.75rem;color:#14a8a0;margin-bottom:24px}
.pkg-features{list-style:none;padding:0;margin-bottom:28px;display:flex;flex-direction:column;gap:8px}
.pkg-features li{display:flex;align-items:flex-start;gap:10px;font-size:.83rem;color:rgba(200,220,255,0.75)}
.pkg-check{color:#14a8a0;flex-shrink:0}
.pkg-btn{width:100%;padding:13px;border-radius:8px;font-size:.85rem;font-weight:500;cursor:pointer;border:none;text-align:center;text-decoration:none;display:block;font-family:'DM Sans',sans-serif;transition:all .2s}
.pkg-btn-primary{background:linear-gradient(135deg,#0d7377,#14a8a0);color:#fff;box-shadow:0 6px 24px rgba(13,115,119,.4)}
.pkg-btn-primary:hover{box-shadow:0 10px 32px rgba(13,115,119,.6);transform:translateY(-1px)}
.pkg-btn-outline{background:transparent;color:rgba(200,220,255,0.7);border:1px solid rgba(200,169,110,.2)}
.pkg-btn-outline:hover{border-color:rgba(200,169,110,.5);color:#e8d5a3}

/* ─── WHAT'S INCLUDED ─── */
.included-section{background:#0d1f3a;border-top:1px solid rgba(200,169,110,.2);padding:100px 48px}
.included-grid{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;max-width:1100px;margin:0 auto}
.features-list{display:flex;flex-direction:column;gap:20px}
.feat-item{display:flex;gap:16px;align-items:flex-start;padding:20px;background:#0a1628;border:1px solid rgba(200,169,110,.2);border-radius:12px;transition:border-color .3s}
.feat-item:hover{border-color:rgba(13,115,119,.4)}
.feat-icon{width:44px;height:44px;border-radius:10px;background:rgba(13,115,119,.2);border:1px solid rgba(13,115,119,.3);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0}
.feat-title{font-family:'Cormorant Garamond',serif;font-size:1.1rem;margin-bottom:4px;color:#ffffff}
.feat-text{font-size:.82rem;line-height:1.6;color:rgba(200,220,255,0.55)}
.included-visual{background:#0a1628;border:1px solid rgba(200,169,110,.2);border-radius:20px;padding:36px;position:relative;overflow:hidden}
.included-visual::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#c8a96e,#14a8a0)}
.iv-title{font-family:'Cormorant Garamond',serif;font-size:1.4rem;color:#ffffff;margin-bottom:6px}
.iv-sub{font-size:.8rem;color:rgba(200,220,255,0.4);margin-bottom:28px}
.consent-block{background:#0d1f3a;border-radius:10px;padding:20px;margin-bottom:20px}
.consent-title{font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:#14a8a0;margin-bottom:10px}
.consent-text{font-size:.78rem;color:rgba(200,220,255,0.5);line-height:1.65}
.data-pills{display:flex;flex-wrap:wrap;gap:8px;margin-top:20px}
.data-pill{background:rgba(13,115,119,.12);border:1px solid rgba(13,115,119,.2);color:#14a8a0;font-size:.7rem;padding:5px 14px;border-radius:100px;letter-spacing:.04em}

/* ─── FORM ─── */
.form-section{background:#0a1628;border-top:1px solid rgba(200,169,110,.2);padding:100px 48px}
.form-card{max-width:680px;margin:0 auto;background:rgba(13,31,58,.6);border:1px solid rgba(200,169,110,.15);border-radius:20px;padding:48px}
.form-title{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:300;color:#fff;margin-bottom:8px}
.form-sub{font-size:.85rem;color:rgba(200,220,255,.45);margin-bottom:36px}
.flash-success{background:rgba(13,115,119,.15);border:1px solid rgba(13,115,119,.4);color:#14a8a0;border-radius:10px;padding:14px 18px;font-size:.85rem;margin-bottom:24px}
.c-form{display:flex;flex-direction:column;gap:20px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-group{display:flex;flex-direction:column;gap:6px}
.form-group label{font-size:.75rem;font-weight:600;color:rgba(200,220,255,.5);letter-spacing:.05em}
.form-group input,.form-group textarea{background:rgba(10,22,40,.7);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:12px 16px;color:#fff;font-size:.88rem;font-family:'DM Sans',sans-serif;transition:border-color .2s;resize:none;outline:none}
.form-group input::placeholder,.form-group textarea::placeholder{color:rgba(255,255,255,.2)}
.form-group input:focus,.form-group textarea:focus{border-color:rgba(13,115,119,.5)}
.form-error{font-size:.72rem;color:#f87171}
.form-summary{background:rgba(10,22,40,.5);border:1px solid rgba(200,169,110,.15);border-radius:12px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between}
.summary-name{font-size:.9rem;font-weight:600;color:#fff;margin-bottom:2px}
.summary-sub{font-size:.75rem;color:rgba(200,220,255,.4)}
.summary-price{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:300;color:#c8a96e}
.submit-btn{background:linear-gradient(135deg,#0d7377,#14a8a0);color:#fff;border:none;border-radius:8px;padding:16px;font-size:.9rem;font-weight:600;letter-spacing:.05em;cursor:pointer;transition:all .2s}
.submit-btn:hover{box-shadow:0 8px 32px rgba(13,115,119,.5);transform:translateY(-1px)}
.submit-btn:disabled{opacity:.5;cursor:not-allowed}
.form-notice{font-size:.72rem;color:rgba(200,220,255,.25);text-align:center}

/* ─── TESTIMONIALS ─── */
.reviews-section{background:#0a1628;border-top:1px solid rgba(200,169,110,.2);padding:100px 48px}
.reviews-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:1100px;margin:0 auto}
.review-card{background:#0d1f3a;border:1px solid rgba(200,169,110,.2);border-radius:12px;padding:28px;border-left:3px solid #0d7377;transition:border-color .3s}
.review-card:hover{border-color:rgba(200,169,110,.4)}
.review-stars{color:#c8a96e;font-size:.85rem;margin-bottom:14px}
.review-text{font-family:'Cormorant Garamond',serif;font-size:1.05rem;font-style:italic;line-height:1.6;margin-bottom:14px;color:rgba(255,255,255,.85)}
.review-author{font-size:.78rem;color:rgba(200,220,255,0.45);display:flex;align-items:center;gap:8px}
.review-author::before{content:'';display:block;width:20px;height:1px;background:#0d7377}
.review-program{font-size:.68rem;color:#14a8a0;margin-top:4px}

/* ─── FAQ ─── */
.faq-section{background:#0d1f3a;border-top:1px solid rgba(200,169,110,.2);padding:100px 48px}
.faq-list{max-width:760px;margin:0 auto;display:flex;flex-direction:column;gap:12px}
.faq-item{background:#0a1628;border:1px solid rgba(200,169,110,.2);border-radius:12px;overflow:hidden;transition:border-color .3s}
.faq-item.open{border-color:rgba(13,115,119,.4)}
.faq-question{padding:20px 24px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-family:'Cormorant Garamond',serif;font-size:1.1rem;user-select:none;color:#ffffff}
.faq-icon{color:#14a8a0;font-size:1.2rem;transition:transform .3s;flex-shrink:0}
.faq-item.open .faq-icon{transform:rotate(45deg)}
.faq-answer{max-height:0;overflow:hidden;transition:max-height .35s ease,padding .3s;font-size:.85rem;line-height:1.7;padding:0 24px;color:rgba(200,220,255,0.6)}
.faq-item.open .faq-answer{max-height:300px;padding:0 24px 20px}

/* ─── DISCLAIMER ─── */
.disclaimer-section{background:#0a1628;border-top:1px solid rgba(200,169,110,.2);padding:100px 48px}
.disclaimer-box{max-width:760px;margin:0 auto;background:#0d1f3a;border:1px solid rgba(200,169,110,.2);border-radius:12px;padding:32px}
.disclaimer-title{font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;margin-bottom:14px;color:#14a8a0}
.disclaimer-text{font-size:.82rem;line-height:1.75;color:rgba(200,220,255,0.45)}

/* ─── CTA ─── */
.cta-section{text-align:center;background:radial-gradient(ellipse 60% 80% at 50% 50%,rgba(13,115,119,.18) 0%,transparent 70%) #0a1628;border-top:1px solid rgba(200,169,110,.2);padding:120px 48px}
.cta-sub{color:rgba(200,220,255,0.5);max-width:460px;margin:0 auto;font-size:.95rem;line-height:1.7}
.cta-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;margin-top:40px}

/* ─── RESPONSIVE ─── */
@media(max-width:960px){
  .hero{grid-template-columns:1fr;padding:100px 24px 60px;gap:48px}
  .hero-right{display:none}
  .how-section,.packages-section,.included-section,.form-section,.reviews-section,.faq-section,.disclaimer-section,.cta-section{padding:72px 24px}
  .how-grid{grid-template-columns:1fr 1fr}
  .how-grid::before{display:none}
  .packages-grid,.included-grid,.reviews-grid{grid-template-columns:1fr}
  .form-card{padding:32px 24px}
  .form-row{grid-template-columns:1fr}
}
@media(max-width:600px){
  .how-grid{grid-template-columns:1fr}
}
</style>
