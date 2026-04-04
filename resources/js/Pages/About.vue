<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="about-hero">
      <div class="hero-inner">
        <div class="hero-badge"><span class="badge-dot"></span>Notre Histoire</div>
        <h1>Une science enracinée dans<br><em>25 ans de guérison</em></h1>
        <p class="hero-sub">Vitality Inside est né de décennies de recherche clinique sur l'intelligence fréquentielle naturelle du corps — combinant ostéopathie, médecine chinoise et biophysique quantique.</p>
        <div class="hero-stats">
          <div class="stat">
            <span class="stat-num">25+</span>
            <span class="stat-label">Années d'expérience</span>
          </div>
          <div class="stat-sep"></div>
          <div class="stat">
            <span class="stat-num">60+</span>
            <span class="stat-label">Protocoles</span>
          </div>
          <div class="stat-sep"></div>
          <div class="stat">
            <span class="stat-num">21k+</span>
            <span class="stat-label">Utilisateurs</span>
          </div>
          <div class="stat-sep"></div>
          <div class="stat">
            <span class="stat-num">8h</span>
            <span class="stat-label">Délai de livraison</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ DR. ÉRIC ROSATI ═══ -->
    <section class="rosati-section">
      <div class="rosati-inner">

        <!-- Portrait card -->
        <div class="portrait-card">
          <div class="portrait-avatar">ÉR</div>
          <h2 class="portrait-name">Dr. Éric Rosati</h2>
          <p class="portrait-title">Ostéopathe · Docteur en Médecine Quantique</p>
          <p class="portrait-role">Fondateur de Vitality Inside</p>
          <div class="portrait-credentials">
            <div class="cred"><span class="cred-icon">🎓</span>Ostéopathie D.O.</div>
            <div class="cred"><span class="cred-icon">⚕️</span>Médecine Quantique</div>
            <div class="cred"><span class="cred-icon">🌿</span>Médecine Chinoise</div>
            <div class="cred"><span class="cred-icon">⚛️</span>Biophysique Quantique</div>
            <div class="cred"><span class="cred-icon">🌱</span>Phytothérapie</div>
            <div class="cred"><span class="cred-icon">💊</span>Homéopathie</div>
          </div>
          <blockquote class="portrait-quote">
            "Le corps humain n'est pas que chimie — il est électricité, vibration et résonance. Quand nous parlons son langage, la guérison devient naturelle."
          </blockquote>
        </div>

        <!-- Bio text -->
        <div class="bio-content">
          <p class="section-label">Le Fondateur</p>
          <h2 class="section-title">Dr. Éric Rosati</h2>
          <p class="bio-text">Éric Rosati est diplômé en ostéopathie, médecine chinoise, médecine énergétique et est le fondateur de la méthode Isoposturale. Avec plus de 25 ans d'expérience professionnelle, il a passé plus d'une décennie à chercher un moyen d'apporter à ses patients un soulagement plus efficace et durable.</p>
          <p class="bio-text">Depuis lors, son enthousiasme pour cette approche énergétique a grandi et l'a conduit à se former à d'autres techniques telles que l'homéopathie, la phytothérapie, la médecine chinoise et la biophysique quantique. Cette vision vibratoire de la maladie lui a permis de mieux comprendre les mécanismes des pathologies et surtout d'apporter des soins plus efficaces et durables.</p>

          <div class="mission-block">
            <p class="section-label">Notre Mission</p>
            <p class="bio-text">Les applications de thérapie par fréquences ont été développées sur des décennies de recherche par des thérapeutes et des scientifiques. De nombreuses études ont démontré l'efficacité de la thérapie par fréquences dans la gestion de la douleur, l'amélioration du bien-être et le traitement de diverses pathologies.</p>
            <p class="bio-text">Chez Vitality Inside, nous avons synthétisé cette recherche en plus de 60 protocoles précis, chacun ciblant des mécanismes physiologiques spécifiques à travers des fréquences bio-énergétiques soigneusement calibrées.</p>
          </div>

          <!-- Timeline -->
          <div class="timeline">
            <div v-for="event in timeline" :key="event.year" class="tl-item">
              <div class="tl-year">{{ event.year }}</div>
              <div class="tl-dot"></div>
              <div class="tl-content">
                <p class="tl-title">{{ event.title }}</p>
                <p class="tl-desc">{{ event.desc }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ LA SCIENCE ═══ -->
    <section class="science-section">
      <div class="section-inner">
        <div class="section-header" style="text-align:center">
          <p class="section-label">La Méthode</p>
          <h2 class="section-title">La science derrière <em class="gold-italic">la méthode</em></h2>
          <p class="section-sub" style="margin:0 auto">Trois piliers de la guérison bio-énergétique</p>
        </div>
        <div class="pillars-grid">
          <div v-for="pillar in pillars" :key="pillar.title" class="pillar">
            <div class="pillar-icon">{{ pillar.icon }}</div>
            <h3 class="pillar-title">{{ pillar.title }}</h3>
            <p class="pillar-desc">{{ pillar.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ COMMENT ÇA FONCTIONNE ═══ -->
    <section class="process-section">
      <div class="section-inner">
        <div class="section-header" style="text-align:center">
          <p class="section-label">Le Processus</p>
          <h2 class="section-title">Comment fonctionne la <em class="gold-italic">thérapie fréquentielle</em></h2>
        </div>
        <div class="process-grid">
          <div v-for="(step, i) in processSteps" :key="i" class="process-step">
            <div class="ps-num">{{ i + 1 }}</div>
            <h4 class="ps-title">{{ step.title }}</h4>
            <p class="ps-desc">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ CTA ═══ -->
    <section class="cta-section">
      <p class="section-label" style="text-align:center">Commencez votre parcours</p>
      <h2 class="section-title" style="text-align:center">Commencez votre <em class="gold-italic">parcours de guérison</em></h2>
      <p class="section-sub" style="text-align:center;margin:0 auto 40px">Choisissez un protocole. Écoutez avec des écouteurs à conduction osseuse. Laissez votre corps se recalibrer.</p>
      <div class="cta-btns">
        <Link :href="route('shop')" class="btn-primary">Explorer les programmes</Link>
        <Link :href="route('consultation')" class="btn-outline">Réserver une consultation</Link>
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
    title: 'Communication Bio-Électrique',
    desc: 'Chaque cellule de votre corps maintient un potentiel électrique précis. La maladie perturbe ces signaux bioélectriques. Nos fréquences restaurent la cohérence cellulaire au niveau le plus fondamental.',
  },
  {
    icon: '🌀',
    title: 'Résonance Quantique',
    desc: 'La matière vibre à des fréquences spécifiques. Par résonance, des fréquences externes peuvent moduler les systèmes biologiques, influençant tout, des schémas de décharge neuronale à la sécrétion hormonale.',
  },
  {
    icon: '🧠',
    title: 'Activation Neuroplastique',
    desc: 'Des plages de fréquences spécifiques (alpha, thêta, delta, gamma) entraînent des états d\'ondes cérébrales associés à la guérison, la récupération et au changement neuroplastique — mesurable par EEG.',
  },
]

const timeline = [
  { year: '1995', title: 'Diplôme d\'Ostéopathie', desc: 'Éric Rosati commence sa carrière clinique, spécialisé dans les pathologies musculo-squelettiques.' },
  { year: '2003', title: 'Découverte des Fréquences', desc: 'Premiers essais cliniques avec la thérapie par fréquences bio-énergétiques — résultats remarquables sur la douleur chronique.' },
  { year: '2010', title: 'Méthode Isoposturale', desc: 'Fondation de la méthode Isoposturale, intégrant ostéopathie, médecine chinoise et biophysique quantique.' },
  { year: '2018', title: 'Vitality Inside', desc: 'Lancement de la plateforme Vitality Inside pour rendre la thérapie fréquentielle accessible à tous.' },
  { year: '2024', title: '21 000+ Utilisateurs', desc: 'Plus de 21 000 personnes dans le monde utilisent les protocoles de fréquences Vitality Inside.' },
]

const processSteps = [
  { title: 'Les fréquences pénètrent le corps', desc: 'Via les écouteurs à conduction osseuse, les fréquences se propagent directement à travers les os jusqu\'aux tissus et organes.' },
  { title: 'Résonnance cellulaire', desc: 'Les cellules malades ou déséquilibrées résonnent avec les fréquences thérapeutiques ciblées, restaurant leur potentiel électrique naturel.' },
  { title: 'Régulation du système nerveux', desc: 'Le système nerveux autonome se recalibre, réduisant l\'inflammation, modulant la douleur et améliorant les cycles de récupération.' },
  { title: 'Guérison progressive', desc: 'Sur la durée de la cure (14–30 jours), l\'organisme consolide les changements et restaure son équilibre homéostatique naturel.' },
]
</script>

<style scoped>
/* HERO */
.about-hero {
  min-height: 80vh; display: flex; align-items: center;
  padding: 120px 48px 80px; text-align: center;
  background: radial-gradient(ellipse 80% 60% at 50% 30%, rgba(13,115,119,.18) 0%, transparent 70%),
              radial-gradient(ellipse 40% 40% at 20% 80%, rgba(200,169,110,.08) 0%, transparent 60%),
              #0a1628;
  position: relative; overflow: hidden;
}
.hero-inner { max-width: 760px; margin: 0 auto; position: relative; z-index: 2; }
.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(13,115,119,.2); border: 1px solid rgba(13,115,119,.4);
  padding: 6px 16px; border-radius: 100px;
  font-size: .75rem; letter-spacing: .1em; text-transform: uppercase; color: #14a8a0; margin-bottom: 28px;
}
.badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #14a8a0; animation: blink 2s infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
.hero-inner h1 {
  font-family: 'Cormorant Garamond', serif; font-size: clamp(2.8rem, 5vw, 4.5rem);
  font-weight: 300; line-height: 1.1; margin-bottom: 24px; color: #fff;
}
.hero-inner h1 em { color: #c8a96e; font-style: italic; }
.hero-sub { font-size: 1.05rem; color: rgba(255,255,255,.65); line-height: 1.7; margin-bottom: 48px; max-width: 580px; margin-left: auto; margin-right: auto; }
.hero-stats { display: flex; align-items: center; justify-content: center; gap: 24px; flex-wrap: wrap; }
.stat { text-align: center; }
.stat-num { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; font-weight: 300; color: #c8a96e; display: block; line-height: 1; }
.stat-label { font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; color: rgba(200,220,255,.4); display: block; margin-top: 4px; }
.stat-sep { width: 1px; height: 40px; background: rgba(200,169,110,.2); }

/* ROSATI */
.rosati-section { background: #0a1628; border-top: 1px solid rgba(200,169,110,.2); padding: 100px 48px; }
.rosati-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 420px 1fr; gap: 64px; align-items: start; }
.portrait-card {
  background: rgba(13,31,58,.6); border: 1px solid rgba(200,169,110,.2);
  border-radius: 20px; padding: 44px 36px; text-align: center; position: sticky; top: 100px;
}
.portrait-avatar {
  width: 96px; height: 96px; border-radius: 50%;
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 300; color: #fff;
  margin: 0 auto 20px;
}
.portrait-name { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 300; color: #fff; margin-bottom: 6px; }
.portrait-title { font-size: .82rem; color: #14a8a0; margin-bottom: 4px; }
.portrait-role { font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; color: rgba(200,220,255,.35); margin-bottom: 28px; }
.portrait-credentials { display: flex; flex-direction: column; gap: 8px; margin-bottom: 28px; text-align: left; }
.cred { display: flex; align-items: center; gap: 10px; font-size: .82rem; color: rgba(255,255,255,.6); padding: 8px 12px; background: rgba(255,255,255,.03); border-radius: 8px; }
.cred-icon { font-size: 1rem; flex-shrink: 0; }
.portrait-quote {
  font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-style: italic;
  font-weight: 300; color: #c8a96e; line-height: 1.55;
  border-left: 2px solid #c8a96e; padding-left: 16px; text-align: left; margin: 0;
}

/* BIO */
.bio-content { padding-top: 4px; }
.bio-text { font-size: .92rem; color: rgba(200,220,255,.55); line-height: 1.75; margin-bottom: 16px; }
.mission-block { margin-top: 32px; margin-bottom: 32px; padding: 28px; background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.15); border-radius: 14px; }

/* TIMELINE */
.timeline { display: flex; flex-direction: column; gap: 0; }
.tl-item { display: grid; grid-template-columns: 60px 20px 1fr; gap: 0 20px; align-items: start; padding-bottom: 28px; position: relative; }
.tl-item:last-child { padding-bottom: 0; }
.tl-item:not(:last-child) .tl-dot::after { content: ''; position: absolute; left: 89px; top: 22px; width: 1px; height: calc(100% - 14px); background: rgba(200,169,110,.2); }
.tl-year { font-family: 'Cormorant Garamond', serif; font-size: .95rem; color: #c8a96e; text-align: right; padding-top: 2px; line-height: 1; white-space: nowrap; }
.tl-dot { width: 10px; height: 10px; border-radius: 50%; background: #0d7377; border: 2px solid #14a8a0; margin-top: 4px; flex-shrink: 0; position: relative; }
.tl-title { font-size: .88rem; font-weight: 600; color: rgba(255,255,255,.85); margin-bottom: 4px; }
.tl-desc { font-size: .78rem; color: rgba(200,220,255,.45); line-height: 1.55; }

/* SCIENCE */
.science-section {
  background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(13,115,119,.1) 0%, transparent 70%), rgba(255,255,255,.015);
  border-top: 1px solid rgba(200,169,110,.2); padding: 100px 48px;
}
.section-inner { max-width: 1100px; margin: 0 auto; }
.pillars-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.pillar {
  background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.2);
  border-radius: 16px; padding: 36px 28px; transition: border-color .3s, transform .3s;
}
.pillar:hover { border-color: rgba(13,115,119,.5); transform: translateY(-4px); }
.pillar-icon {
  width: 52px; height: 52px; border-radius: 14px;
  background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.3);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; margin-bottom: 22px;
}
.pillar-title { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 400; color: #fff; margin-bottom: 12px; }
.pillar-desc { font-size: .83rem; color: rgba(200,220,255,.5); line-height: 1.65; }

/* PROCESS */
.process-section { background: #0a1628; padding: 100px 48px; }
.process-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.process-step {
  text-align: center; padding: 32px 20px;
  border: 1px solid rgba(200,169,110,.2); border-radius: 12px; background: rgba(255,255,255,.02);
}
.ps-num {
  width: 48px; height: 48px; border-radius: 50%;
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: #fff; margin: 0 auto 20px;
}
.ps-title { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 400; margin-bottom: 10px; color: #fff; }
.ps-desc { font-size: .8rem; color: rgba(255,255,255,.4); line-height: 1.6; }

/* CTA */
.cta-section {
  text-align: center;
  background: radial-gradient(ellipse 60% 80% at 50% 50%, rgba(13,115,119,.2) 0%, transparent 70%);
  border-top: 1px solid rgba(200,169,110,.2); padding: 120px 48px;
}
.cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
.btn-primary {
  background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff; border: none;
  padding: 16px 36px; border-radius: 6px; font-size: .9rem; font-weight: 500;
  letter-spacing: .04em; cursor: pointer; text-decoration: none; transition: transform .2s, box-shadow .2s;
  box-shadow: 0 8px 32px rgba(13,115,119,.35); display: inline-block;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(13,115,119,.5); }
.btn-outline {
  background: transparent; border: 1px solid rgba(200,169,110,.3); color: #e8d5a3;
  padding: 16px 36px; border-radius: 6px; font-size: .9rem; cursor: pointer;
  text-decoration: none; transition: border-color .2s, background .2s; display: inline-block;
}
.btn-outline:hover { border-color: #c8a96e; background: rgba(200,169,110,.07); }

/* SHARED */
.section-header { margin-bottom: 60px; }
.section-label { font-size: .72rem; letter-spacing: .18em; text-transform: uppercase; color: #14a8a0; margin-bottom: 14px; display: block; }
.section-title {
  font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 3.5vw, 3rem);
  font-weight: 300; line-height: 1.2; margin-bottom: 16px; color: #fff;
}
.section-sub { color: rgba(255,255,255,.55); font-size: 1rem; max-width: 520px; line-height: 1.6; display: block; }
.gold-italic { color: #c8a96e; font-style: italic; font-family: 'Cormorant Garamond', serif; }

@media (max-width: 1024px) {
  .rosati-inner { grid-template-columns: 1fr; }
  .portrait-card { position: static; }
}
@media (max-width: 900px) {
  .about-hero, .rosati-section, .science-section, .process-section, .cta-section { padding: 72px 24px; }
  .pillars-grid { grid-template-columns: 1fr; }
  .process-grid { grid-template-columns: 1fr 1fr; }
  .hero-stats { gap: 16px; }
}
@media (max-width: 560px) {
  .process-grid { grid-template-columns: 1fr; }
  .tl-item { grid-template-columns: 48px 16px 1fr; }
}
</style>
