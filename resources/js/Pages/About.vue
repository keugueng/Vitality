<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="hero">
      <div class="hero-tag"><span>◆</span> BIO-ENERGY FREQUENCY THERAPY · EST. 25 YEARS</div>
      <h1>A science rooted in<br><em>25 years of healing</em></h1>
      <p class="hero-p">Vitality Inside was born from decades of clinical research into the body's natural frequency intelligence — combining osteopathy, Chinese medicine and quantum biophysics.</p>
    </section>

    <!-- ═══ FOUNDER ═══ -->
    <section class="founder">
      <div class="founder-img">
        <div class="founder-photo">
          <div class="photo-inner">ER</div>
        </div>
        <div class="founder-badge">
          <div class="years">25+</div>
          <div class="label">Years of research</div>
        </div>
      </div>
      <div class="founder-text">
        <div class="ftag">FOUNDER &amp; CREATOR</div>
        <h2>Dr. Eric Rosati</h2>
        <div class="sub">Osteopath · Energy Medicine Expert</div>
        <p>Eric Rosati graduated in osteopathy, Chinese medicine, energy medicine and is the founder of the Isoposturale method. With more than 25 years of professional experience, he spent over a decade searching for a way to provide his patients with more effective and lasting relief.</p>
        <p>Since then, his enthusiasm for this energy approach has grown and led him to train in other techniques such as homeopathy, herbal medicine, Chinese medicine and quantum biophysics. This vibratory vision of disease has allowed him to better understand the mechanisms of pathologies and especially to provide more effective and sustainable care.</p>
        <p>The only motivation in developing this method is to provide patients with the best possible care — accessible from anywhere in the world, at any time.</p>
        <div class="creds">
          <span class="cred">Osteopathy</span>
          <span class="cred">Chinese Medicine</span>
          <span class="cred">Energy Medicine</span>
          <span class="cred">Homeopathy</span>
          <span class="cred">Isoposturale Method</span>
          <span class="cred">Quantum Biophysics</span>
        </div>
      </div>
    </section>

    <!-- ═══ MISSION ═══ -->
    <section class="mission">
      <div class="mission-inner">
        <h2>Our Mission</h2>
        <p>Frequency therapy applications have been developed over decades of research by therapists and scientists. Numerous studies have demonstrated the effectiveness of frequency therapy in managing pain, improving well-being and treating various pathologies.</p>
        <p>At Vitality Inside, we have synthesized this research into over 37 precise protocols, each targeting specific physiological mechanisms through carefully calibrated bio-energetic frequencies.</p>
        <blockquote>
          <p>"The human body is not just chemistry — it is electricity, vibration, and resonance. When we speak its language, healing becomes natural."</p>
          <cite>— Dr. Eric Rosati, Founder of Vitality Inside</cite>
        </blockquote>
      </div>
    </section>

    <!-- ═══ SCIENCE ═══ -->
    <section class="science">
      <h2>The Science Behind the Method</h2>
      <p class="sci-sub">Three pillars of bio-energetic healing</p>
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
      <h2>Begin Your Healing Journey</h2>
      <p>Choose a protocol. Listen with bone conduction headphones. Let your body recalibrate.</p>
      <div class="cta-btns">
        <Link :href="route('shop')" class="btn-primary">Explore Programs</Link>
        <Link :href="route('consultation')" class="btn-secondary">Book a Consultation</Link>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const pillars = [
  {
    icon: '⚡',
    title: 'Bio-Electric Communication',
    desc: 'Every cell in your body maintains a precise electrical potential. Disease disrupts these bioelectric signals. Our frequencies restore cellular coherence at the most fundamental level.',
  },
  {
    icon: '🌋',
    title: 'Quantum Resonance',
    desc: 'Matter vibrates at specific frequencies. Through resonance, external frequencies can modulate biological systems, influencing everything from neural firing patterns to hormonal secretion.',
  },
  {
    icon: '🧠',
    title: 'Neuroplasticity Activation',
    desc: 'Specific frequency ranges (alpha, theta, delta, gamma) entrain brainwave states associated with healing, recovery and neuroplastic change — measurable on EEG.',
  },
]

const stats = [
  { val: '21K+', lbl: 'People healed worldwide' },
  { val: '37',   lbl: 'Precision protocols' },
  { val: '25+',  lbl: 'Years of research' },
  { val: '98%',  lbl: 'Report improvement' },
]
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
