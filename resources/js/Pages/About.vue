<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="hero">
      <div class="hero-tag"><span>◆</span> {{ t('about.hero_tag') }}</div>
      <h1>{{ t('about.hero_title') }}<br><em>{{ t('about.hero_title_em') }}</em></h1>
      <p class="hero-p">{{ t('about.hero_sub') }}</p>
    </section>

    <!-- ═══ FOUNDER ═══ -->
    <section class="founder">
      <div class="founder-img">
        <div class="founder-photo">
          <div class="photo-inner">
            <img src="/images/dr-rosati.jpeg" alt="Dr. Éric Rosati" onerror="this.style.display='none'">
          </div>
        </div>
        <div class="founder-badge">
          <div class="years">25+</div>
          <div class="label">{{ t('about.years_research') }}</div>
        </div>
      </div>
      <div class="founder-text">
        <div class="ftag">{{ t('about.founder_role') }}</div>
        <h2>Dr. Eric Rosati</h2>
        <div class="sub">{{ t('about.founder_subtitle') }}</div>
        <p>{{ t('about.founder_p1') }}</p>
        <p>{{ t('about.founder_p2') }}</p>
        <p>{{ t('about.founder_p3') }}</p>
        <div class="creds">
          <span class="cred">{{ t('about.cred1') }}</span>
          <span class="cred">{{ t('about.cred2') }}</span>
          <span class="cred">{{ t('about.cred3') }}</span>
          <span class="cred">{{ t('about.cred4') }}</span>
          <span class="cred">{{ t('about.cred5') }}</span>
          <span class="cred">{{ t('about.cred6') }}</span>
        </div>
      </div>
    </section>

    <!-- ═══ MISSION ═══ -->
    <section class="mission">
      <div class="mission-inner">
        <h2>{{ t('about.mission_label') }}</h2>
        <p>{{ t('about.mission_p1') }}</p>
        <p>{{ t('about.mission_p2') }}</p>
        <blockquote>
          <p>{{ t('about.mission_quote') }}</p>
          <cite>{{ t('about.mission_cite') }}</cite>
        </blockquote>
      </div>
    </section>

    <!-- ═══ SCIENCE ═══ -->
    <section class="science">
      <h2>{{ t('about.science_title_main') }}</h2>
      <p class="sci-sub">{{ t('about.science_sub') }}</p>
      <div class="sci-grid">
        <div v-for="pillar in pillars" :key="pillar.title" class="sci-card">
          <div class="ic">{{ pillar.icon }}</div>
          <h3>{{ pillar.title }}</h3>
          <p>{{ pillar.desc }}</p>
        </div>
      </div>
    </section>

    <!-- ═══ STATS ═══ -->
    <div class="stats">
      <div v-for="s in stats" :key="s.val">
        <div class="stat-val">{{ s.val }}</div>
        <div class="stat-lbl">{{ s.lbl }}</div>
      </div>
    </div>

    <!-- ═══ CTA ═══ -->
    <section class="cta-section">
      <h2>{{ t('about.cta_title') }}</h2>
      <p>{{ t('about.cta_sub') }}</p>
      <div class="cta-btns">
        <Link :href="route('shop')" class="btn-primary">{{ t('about.cta_btn1') }}</Link>
        <Link :href="route('consultation')" class="btn-secondary">{{ t('about.cta_btn') }}</Link>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from '@/composables/useI18n'
const { t } = useI18n()

const pillars = computed(() => [
  { icon: t('about.pillar1_icon'), title: t('about.pillar1_title'), desc: t('about.pillar1_desc') },
  { icon: t('about.pillar2_icon'), title: t('about.pillar2_title'), desc: t('about.pillar2_desc') },
  { icon: t('about.pillar3_icon'), title: t('about.pillar3_title'), desc: t('about.pillar3_desc') },
])

const stats = computed(() => [
  { val: t('about.stat1_val'), lbl: t('about.stat1_lbl') },
  { val: t('about.stat2_val'), lbl: t('about.stat2_lbl') },
  { val: t('about.stat3_val'), lbl: t('about.stat3_lbl') },
  { val: t('about.stat4_val'), lbl: t('about.stat4_lbl') },
])
</script>

<style scoped>
/* HERO */
.hero { padding: 80px 40px 60px; text-align: center; max-width: 800px; margin: 0 auto; }
.hero-tag {
  display: inline-flex; align-items: center; gap: 8px;
  border: 1px solid rgba(13,115,119,.5); border-radius: 20px;
  padding: 6px 16px; font-size: .72rem; letter-spacing: .12em;
  text-transform: uppercase; color: #14a8a0; margin-bottom: 24px;
}
.hero h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 5vw, 3rem); font-weight: 400; line-height: 1.2; margin-bottom: 20px; color: #fff; }
.hero h1 em { color: #c8a96e; font-style: italic; }
.hero-p { color: rgba(255,255,255,.6); font-size: 1rem; line-height: 1.7; max-width: 600px; margin: 0 auto; }

/* FOUNDER */
.founder {
  padding: 60px 40px; max-width: 1100px; margin: 0 auto;
  display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;
}
.founder-img { position: relative; }
.founder-photo {
  width: 100%; padding-bottom: 120%; border-radius: 12px; position: relative; overflow: hidden;
  background: linear-gradient(135deg, #0d2444, #0d3a5c);
  border: 1px solid rgba(200,169,110,.2);
}
.photo-inner {
  position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif; font-size: 5rem; font-weight: 300; color: rgba(200,169,110,.3);
  letter-spacing: .1em;
}
.founder-img::after {
  content: ''; position: absolute; inset: -8px;
  border: 1px solid rgba(200,169,110,.2); border-radius: 16px; pointer-events: none;
}
.founder-badge {
  position: absolute; bottom: 20px; left: 20px;
  background: rgba(10,22,40,.9); border: 1px solid rgba(200,169,110,.2);
  border-radius: 8px; padding: 12px 16px;
}
.founder-badge .years { font-size: 2rem; font-weight: 700; color: #c8a96e; line-height: 1; }
.founder-badge .label { font-size: .7rem; color: rgba(255,255,255,.5); letter-spacing: .08em; text-transform: uppercase; margin-top: 2px; }
.founder-text .ftag { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: #14a8a0; margin-bottom: 12px; }
.founder-text h2 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 400; margin-bottom: 6px; color: #fff; line-height: 1.3; }
.founder-text .sub { color: #c8a96e; font-size: 1rem; font-style: italic; margin-bottom: 24px; }
.founder-text p { color: rgba(255,255,255,.7); font-size: .92rem; line-height: 1.75; margin-bottom: 16px; }
.creds { padding: 8px 0; display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
.cred {
  background: rgba(13,115,119,.1); border: 1px solid rgba(13,115,119,.3);
  border-radius: 20px; padding: 6px 14px; font-size: .75rem; color: #14a8a0;
}

/* MISSION */
.mission {
  background: rgba(13,115,119,.05); border-top: 1px solid rgba(200,169,110,.2);
  border-bottom: 1px solid rgba(200,169,110,.2); padding: 70px 40px; text-align: center;
}
.mission-inner { max-width: 750px; margin: 0 auto; }
.mission h2 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 400; margin-bottom: 20px; color: #c8a96e; }
.mission p { color: rgba(255,255,255,.7); font-size: .95rem; line-height: 1.8; margin-bottom: 16px; }
blockquote {
  border-left: 3px solid #c8a96e; padding-left: 20px;
  margin: 32px auto; max-width: 600px; text-align: left;
}
blockquote p { color: rgba(255,255,255,.85); font-size: 1.05rem; font-style: italic; line-height: 1.7; margin-bottom: 0; }
blockquote cite { display: block; margin-top: 10px; font-size: .78rem; color: rgba(255,255,255,.4); font-style: normal; }

/* SCIENCE */
.science { padding: 70px 40px; max-width: 1100px; margin: 0 auto; }
.science h2 { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 400; color: #c8a96e; margin-bottom: 10px; text-align: center; }
.sci-sub { text-align: center; color: rgba(255,255,255,.5); font-size: .9rem; margin-bottom: 48px; }
.sci-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.sci-card {
  background: rgba(13,115,119,.06); border: 1px solid rgba(200,169,110,.2);
  border-radius: 12px; padding: 24px; transition: border-color .2s, transform .2s;
}
.sci-card:hover { border-color: rgba(13,115,119,.5); transform: translateY(-3px); }
.ic { font-size: 2rem; margin-bottom: 14px; }
.sci-card h3 { font-family: 'Cormorant Garamond', serif; font-size: .95rem; color: #c8a96e; margin-bottom: 10px; font-weight: 500; letter-spacing: .02em; }
.sci-card p { font-size: .82rem; color: rgba(255,255,255,.6); line-height: 1.65; margin: 0; }

/* STATS */
.stats {
  padding: 60px 40px; max-width: 900px; margin: 0 auto;
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;
}
.stat-val { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; font-weight: 700; color: #14a8a0; margin-bottom: 6px; }
.stat-lbl { font-size: .75rem; color: rgba(255,255,255,.45); letter-spacing: .08em; text-transform: uppercase; line-height: 1.4; }

/* CTA */
.cta-section {
  padding: 70px 40px; text-align: center;
  background: linear-gradient(135deg, rgba(13,115,119,.12), rgba(10,22,40,.5));
}
.cta-section h2 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 400; margin-bottom: 12px; color: #fff; }
.cta-section p { color: rgba(255,255,255,.55); font-size: .92rem; margin-bottom: 28px; line-height: 1.6; }
.cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
.btn-primary {
  background: #0d7377; color: #fff; padding: 14px 28px; border-radius: 8px;
  font-size: .88rem; text-decoration: none; letter-spacing: .05em; transition: background .2s; display: inline-block;
}
.btn-primary:hover { background: #14a8a0; }
.btn-secondary {
  border: 1px solid rgba(200,169,110,.2); color: rgba(255,255,255,.7);
  padding: 14px 28px; border-radius: 8px; font-size: .88rem;
  text-decoration: none; letter-spacing: .05em; transition: border-color .2s, color .2s; display: inline-block;
}
.btn-secondary:hover { border-color: #c8a96e; color: #c8a96e; }

@media (max-width: 768px) {
  .hero { padding: 50px 20px 40px; }
  .hero h1 { font-size: 2rem; }
  .founder { grid-template-columns: 1fr; padding: 40px 20px; gap: 32px; }
  .sci-grid { grid-template-columns: 1fr; }
  .stats { grid-template-columns: repeat(2, 1fr); }
  .mission, .science, .cta-section { padding: 50px 20px; }
}
</style>
