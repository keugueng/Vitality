<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="consult-hero">
      <div class="hero-grid">
        <!-- Left -->
        <div class="hero-left">
          <div class="hero-badge"><span class="badge-dot"></span>Dr. Éric Rosati — Ostéopathe &amp; Médecine Quantique</div>
          <h1>Votre santé,<br><em>précisément décodée.</em></h1>
          <p class="hero-sub">Décrivez vos symptômes. Le Dr. Éric Rosati analyse votre profil bio-énergétique et vous remet un protocole de fréquences sur-mesure — directement dans votre boîte mail sous 8 heures.</p>
          <div class="hero-price-row">
            <span class="hero-from">À partir de</span>
            <span class="hero-price">€58</span>
            <span class="hero-price-sub">/ consultation</span>
          </div>
          <div class="hero-btns">
            <a href="#booking" class="btn-primary">Réserver ma consultation</a>
            <a href="#packages" class="btn-outline">Voir les formules →</a>
          </div>
          <div class="hero-trust">
            <span class="trust-item"><span class="trust-icon">✦</span> Livré sous 8 heures</span>
            <span class="trust-item"><span class="trust-icon">✦</span> 100% confidentiel</span>
            <span class="trust-item"><span class="trust-icon">✦</span> Protocole sur-mesure</span>
          </div>
        </div>
        <!-- Right: Visual Card -->
        <div class="hero-right">
          <div class="hero-card">
            <div class="hero-card-label">Ce que vous recevez</div>
            <ul class="hero-card-list">
              <li><span class="hc-check">✦</span><span>Analyse bio-énergétique complète de vos symptômes</span></li>
              <li><span class="hc-check">✦</span><span>Protocole de fréquences personnalisé</span></li>
              <li><span class="hc-check">✦</span><span>Lien d'accès sécurisé à vos séances audio</span></li>
              <li><span class="hc-check">✦</span><span>Guide d'utilisation et conseils de cure</span></li>
              <li><span class="hc-check">✦</span><span>Durée de cure et fréquence personnalisées</span></li>
            </ul>
            <div class="hero-card-footer">
              <div class="hero-card-stat">
                <span class="hcs-num">+21 000</span>
                <span class="hcs-label">Patients accompagnés</span>
              </div>
              <div class="hero-card-stat">
                <span class="hcs-num">8h</span>
                <span class="hcs-label">Délai de livraison</span>
              </div>
              <div class="hero-card-stat">
                <span class="hcs-num">25 ans</span>
                <span class="hcs-label">D'expertise clinique</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ COMMENT ÇA MARCHE ═══ -->
    <section class="steps-section">
      <div class="section-inner">
        <div class="section-header" style="text-align:center">
          <p class="section-label">Comment ça marche</p>
          <h2 class="section-title">De vos symptômes à votre <em class="gold-italic">protocole personnalisé</em></h2>
        </div>
        <div class="steps-grid">
          <div v-for="(step, i) in consultSteps" :key="i" class="step">
            <div class="step-num">{{ i + 1 }}</div>
            <h4>{{ step.title }}</h4>
            <p>{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ PACKAGES ═══ -->
    <section class="packages-section" id="packages">
      <div class="section-inner">
        <div class="section-header" style="text-align:center">
          <p class="section-label">Formules</p>
          <h2 class="section-title">Économisez avec nos <em class="gold-italic">formules multi-séances</em></h2>
          <p class="section-sub" style="margin:0 auto">Les pathologies chroniques répondent mieux à plusieurs cycles de consultation. Nos formules vous offrent un suivi plus approfondi à moindre coût.</p>
        </div>
        <div class="packages-grid">
          <div v-for="pkg in packages" :key="pkg.id"
            class="pkg-card" :class="{ selected: form.package_type === pkg.id, featured: pkg.featured }"
            @click="form.package_type = pkg.id">
            <div v-if="pkg.featured" class="pkg-badge">Plus populaire</div>
            <div class="pkg-sessions">{{ pkg.sessions }} séance{{ pkg.sessions > 1 ? 's' : '' }}</div>
            <h3 class="pkg-name">{{ pkg.name }}</h3>
            <p class="pkg-tagline">{{ pkg.tagline }}</p>
            <div class="pkg-price">€{{ pkg.price }}</div>
            <p v-if="pkg.saving" class="pkg-saving">{{ pkg.saving }}</p>
            <ul class="pkg-features">
              <li v-for="f in pkg.features" :key="f"><span class="check">✦</span>{{ f }}</li>
            </ul>
            <button class="pkg-btn" :class="form.package_type === pkg.id ? 'pkg-btn-active' : 'pkg-btn-outline'"
              @click.stop="form.package_type = pkg.id">
              {{ pkg.label }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ WHAT'S INCLUDED ═══ -->
    <section class="included-section">
      <div class="section-inner">
        <div class="included-grid">
          <div class="included-left">
            <p class="section-label">Ce qui est inclus</p>
            <h2 class="section-title">Tout ce dont vous avez besoin <em class="gold-italic">dans chaque consultation</em></h2>
            <ul class="included-list">
              <li><div class="inc-icon">✦</div><div><strong>Analyse bio-énergétique approfondie</strong><p>Le Dr. Rosati examine chaque symptôme à travers le prisme de la médecine quantique pour identifier les déséquilibres précis.</p></div></li>
              <li><div class="inc-icon">✦</div><div><strong>Protocole de fréquences sur-mesure</strong><p>Séquence audio personnalisée encodée avec les fréquences exactes correspondant à votre profil pathologique.</p></div></li>
              <li><div class="inc-icon">✦</div><div><strong>Guide de cure personnalisé</strong><p>Durée de cure, fréquence d'écoute, recommandations de mode de vie alignées avec votre protocole.</p></div></li>
              <li><div class="inc-icon">✦</div><div><strong>Accès sécurisé &amp; confidentiel</strong><p>Vos données personnelles et médicales sont supprimées définitivement dans les 14 jours suivant la livraison.</p></div></li>
            </ul>
          </div>
          <div class="included-right">
            <div class="privacy-card">
              <div class="privacy-icon">🔒</div>
              <h3>Confidentialité totale</h3>
              <p>Vos données médicales ne sont jamais partagées. Chaque consultation est traitée avec une discrétion absolue.</p>
              <ul class="privacy-list">
                <li>Suppression automatique sous 14 jours</li>
                <li>Lien d'accès sécurisé unique</li>
                <li>Aucun stockage de données sensibles</li>
                <li>Conformité RGPD complète</li>
              </ul>
              <div class="privacy-badge">Certifié confidentiel</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ FORMULAIRE ═══ -->
    <section class="form-section" id="booking">
      <div class="form-card">
        <h2 class="form-title">Réserver ma consultation</h2>
        <p class="form-sub">Remplissez le formulaire, laissez le Dr. Éric Rosati décoder votre profil bio-énergétique.</p>

        <div v-if="$page.props.flash?.success" class="flash-success">
          ✓ {{ $page.props.flash.success }}
        </div>

        <form @submit.prevent="submit" class="c-form">
          <div class="form-row">
            <div class="form-group">
              <label>Nom complet *</label>
              <input v-model="form.name" type="text" required placeholder="Votre nom" />
              <p v-if="form.errors.name" class="form-error">{{ form.errors.name }}</p>
            </div>
            <div class="form-group">
              <label>Email *</label>
              <input v-model="form.email" type="email" required placeholder="votre@email.com" />
              <p v-if="form.errors.email" class="form-error">{{ form.errors.email }}</p>
            </div>
          </div>
          <div class="form-group">
            <label>Téléphone</label>
            <input v-model="form.phone" type="tel" placeholder="+33 6 00 00 00 00" />
          </div>
          <div class="form-group">
            <label>Vos symptômes &amp; objectifs de santé *</label>
            <textarea v-model="form.symptoms" required rows="4"
              placeholder="Décrivez vos principales préoccupations de santé, symptômes, durée et ce que vous avez déjà essayé…"></textarea>
            <p v-if="form.errors.symptoms" class="form-error">{{ form.errors.symptoms }}</p>
          </div>
          <div class="form-group">
            <label>Antécédents médicaux (optionnel)</label>
            <textarea v-model="form.medical_history" rows="3"
              placeholder="Diagnostics passés pertinents, médicaments, chirurgies…"></textarea>
          </div>

          <div class="form-summary">
            <div>
              <p class="summary-name">{{ selectedPkg.name }}</p>
              <p class="summary-sub">{{ selectedPkg.sessions }} séance{{ selectedPkg.sessions > 1 ? 's' : '' }} · Protocole livré sous 8 heures</p>
            </div>
            <span class="summary-price">€{{ selectedPkg.price }}</span>
          </div>

          <button type="submit" :disabled="form.processing" class="submit-btn">
            {{ form.processing ? 'Envoi en cours…' : `Réserver — €${selectedPkg.price}` }}
          </button>
          <p class="form-notice">🔒 Vos informations sont confidentielles et définitivement supprimées dans les 14 jours suivant la livraison.</p>
        </form>
      </div>
    </section>

    <!-- ═══ TÉMOIGNAGES ═══ -->
    <section class="testimonials-section">
      <div class="section-inner">
        <div class="section-header" style="text-align:center">
          <p class="section-label">Patients</p>
          <h2 class="section-title">Ce que disent les patients de <em class="gold-italic">leur consultation</em></h2>
        </div>
        <div class="testimonials-grid">
          <div v-for="t in consultTestimonials" :key="t.name" class="testimonial">
            <div class="stars">★★★★★</div>
            <q>{{ t.content }}</q>
            <div class="t-author">
              <span class="t-name">{{ t.name }}</span>
              <span class="t-prog">{{ t.program }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ FAQ ═══ -->
    <section class="faq-section">
      <div class="faq-inner">
        <div class="section-header" style="text-align:center">
          <h2 class="section-title">Questions <em class="gold-italic">fréquentes</em></h2>
        </div>
        <div v-for="q in faqs" :key="q.q" class="faq-item" :class="{ open: openFaq === q.q }" @click="openFaq = openFaq === q.q ? null : q.q">
          <div class="faq-q">
            {{ q.q }}
            <span class="faq-arrow">{{ openFaq === q.q ? '−' : '+' }}</span>
          </div>
          <div v-show="openFaq === q.q" class="faq-a">{{ q.a }}</div>
        </div>
        <div class="faq-notice">
          <p class="faq-notice-title">Information importante</p>
          <p>Les programmes Cellular Bio Energy visent à promouvoir le bien-être par l'harmonisation du champ bio-énergétique. Ils ne constituent pas des applications médicales et ne doivent pas remplacer un avis médical professionnel. Toutes les données personnelles et médicales soumises lors d'une consultation sont utilisées exclusivement pour préparer un programme personnalisé et sont définitivement supprimées dans les 14 jours suivant la livraison.</p>
        </div>
      </div>
    </section>

    <!-- ═══ CTA FINALE ═══ -->
    <section class="cta-section">
      <p class="section-label" style="text-align:center">Votre protocole vous attend</p>
      <h2 class="section-title" style="text-align:center">Votre protocole est à <em class="gold-italic">8 heures</em></h2>
      <p class="section-sub" style="text-align:center;margin:0 auto 40px">Remplissez le formulaire, laissez le Dr. Éric Rosati décoder votre profil bio-énergétique et recevez un protocole de fréquences conçu exclusivement pour vous.</p>
      <div class="cta-btns">
        <a href="#booking" class="btn-primary">Réserver ma consultation — €58</a>
        <Link :href="route('shop')" class="btn-outline">Explorer les programmes</Link>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const openFaq = ref(null)

const packages = [
  {
    id: 'single', name: 'Essentiel', price: 58, sessions: 1, label: 'Réserver — €58',
    tagline: 'Idéal pour un problème de santé ciblé',
    saving: null,
    features: ['1 consultation personnalisée', 'Protocole de fréquences sur-mesure', 'Livré sous 8 heures', 'Lien d\'accès sécurisé'],
  },
  {
    id: 'progress', name: 'Évolution', price: 149, sessions: 3, featured: true, label: 'Réserver 3 séances — €149',
    tagline: 'Pour les pathologies chroniques nécessitant un traitement par phases',
    saving: 'Économisez €25 vs séances individuelles',
    features: ['3 consultations personnalisées', 'Protocole mis à jour à chaque séance', 'Suivi des progrès entre les séances', 'Réponse prioritaire sous 8h', 'Recommandé pour les cas complexes'],
  },
  {
    id: 'transform', name: 'Transformation', price: 239, sessions: 5, label: 'Réserver 5 séances — €239',
    tagline: 'Programme de transformation complet avec suivi intégral',
    saving: 'Économisez €51 vs séances individuelles',
    features: ['5 consultations personnalisées', 'Cartographie bio-énergétique complète', 'Suivi complet de l\'évolution des symptômes', 'Réponse VIP prioritaire', 'Idéal pour les pathologies multi-systèmes'],
  },
]

const consultSteps = [
  { title: 'Remplissez le formulaire', desc: 'Complétez le questionnaire de santé détaillé aussi précisément que possible — symptômes, durée, antécédents médicaux et contexte de vie.' },
  { title: 'Analyse experte',          desc: 'Le Dr. Éric Rosati — Ostéopathe & Docteur en Médecine Quantique — examine votre profil et identifie les déséquilibres énergétiques précis à traiter.' },
  { title: 'Protocole livré',          desc: 'Votre programme de bio-énergie personnalisé est assemblé et envoyé via un lien sécurisé — dans les 8 heures suivant la soumission.' },
  { title: 'Écoutez & récupérez',      desc: 'Suivez votre protocole chez vous avec des écouteurs. Séances de 18–35 minutes, sur une durée de cure personnalisée. Suivi inclus.' },
]

const consultTestimonials = [
  { content: 'J\'ai décrit mes symptômes de burn-out et reçu un protocole incroyablement précis en 6 heures. Après 3 semaines je me sentais à nouveau moi-même — ce qu\'aucun médecin n\'avait réussi en 2 ans.', name: 'Marie-Hélène C.', program: 'Protocole Burn-Out' },
  { content: 'Le questionnaire était approfondi et l\'analyse clairement personnelle. Mon protocole insomnie était parfaitement calibré à mon cas. Résultats en moins de 2 semaines.', name: 'Bernard T.', program: 'Protocole Troubles du Sommeil' },
  { content: 'J\'ai réservé la formule 3 séances pour mes douleurs articulaires chroniques. Chaque consultation a affiné le protocole. À la 3e séance, j\'avais réduit mes anti-inflammatoires de 80%.', name: 'Gérard F.', program: 'Douleur Articulaire — formule 3 séances' },
  { content: 'Ce qui m\'a le plus impressionné c\'est la vitesse et la précision. Dr. Rosati a identifié un lien entre mon anxiété et mes problèmes digestifs que je n\'avais jamais envisagé.', name: 'Élise R.', program: 'Protocole Anxiété + Digestif' },
  { content: 'J\'étais sceptique face à une consultation en ligne, mais la profondeur du questionnaire et la personnalisation ont changé mon avis immédiatement. Ma saison allergique cette année était tout à fait gérable.', name: 'Étienne M.', program: 'Protocole Allergie' },
  { content: 'J\'ai effectué 5 consultations sur 8 mois pour mes symptômes de ménopause. L\'évolution de chaque protocole montre un vrai suivi. Bouffées de chaleur réduites de 90%.', name: 'Françoise D.', program: 'Ménopause — formule Transformation' },
]

const faqs = [
  { q: 'Comment fonctionne la consultation en ligne ?', a: 'Vous remplissez un formulaire détaillé décrivant vos symptômes, antécédents médicaux et objectifs. Le Dr. Éric Rosati analyse votre profil et vous remet un protocole de fréquences personnalisé par email sous 8 heures.' },
  { q: 'Ai-je besoin d\'un équipement spécial ?', a: 'Des écouteurs à conduction osseuse sont recommandés pour une transmission optimale des fréquences. Des écouteurs classiques fonctionnent également, mais avec une efficacité légèrement moindre.' },
  { q: 'Combien de temps dure un programme ?', a: 'La durée dépend de votre protocole personnalisé. La plupart des cures durent entre 14 et 30 jours, avec des séances de 18 à 35 minutes par jour.' },
  { q: 'Puis-je combiner plusieurs programmes ?', a: 'Oui, avec un abonnement illimité. Pour les consultations personnalisées, le Dr. Rosati vous recommande l\'ordre et la combinaison optimale selon votre profil.' },
]

const form = useForm({ name: '', email: '', phone: '', package_type: 'single', symptoms: '', medical_history: '' })
const selectedPkg = computed(() => packages.find(p => p.id === form.package_type) || packages[0])
const submit = () => form.post(route('consultation.store'))
</script>

<style scoped>
/* HERO */
.consult-hero {
  min-height: 100vh; display: flex; align-items: center;
  padding: 120px 48px 80px;
  background: radial-gradient(ellipse 80% 60% at 70% 30%, rgba(13,115,119,.16) 0%, transparent 65%), #0a1628;
  position: relative; overflow: hidden;
}
.hero-grid {
  max-width: 1200px; margin: 0 auto; width: 100%;
  display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center;
  position: relative; z-index: 2;
}
.hero-left { display: flex; flex-direction: column; justify-content: center; }
.hero-right { display: flex; justify-content: flex-end; }
.hero-card {
  background: rgba(13,31,58,.8); border: 1px solid rgba(200,169,110,.25);
  border-radius: 20px; padding: 36px; width: 100%; max-width: 420px;
  backdrop-filter: blur(12px); box-shadow: 0 24px 64px rgba(0,0,0,.4);
}
.hero-card-label {
  font-size: .7rem; letter-spacing: .18em; text-transform: uppercase;
  color: #14a8a0; margin-bottom: 22px;
}
.hero-card-list {
  list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 14px;
}
.hero-card-list li { display: flex; align-items: flex-start; gap: 10px; font-size: .84rem; color: rgba(255,255,255,.75); line-height: 1.5; }
.hc-check { color: #14a8a0; font-size: .75rem; flex-shrink: 0; margin-top: 2px; }
.hero-card-footer {
  border-top: 1px solid rgba(255,255,255,.07); padding-top: 22px;
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; text-align: center;
}
.hero-card-stat { display: flex; flex-direction: column; gap: 3px; }
.hcs-num { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 300; color: #c8a96e; }
.hcs-label { font-size: .65rem; letter-spacing: .08em; color: rgba(200,220,255,.35); text-transform: uppercase; }
.hero-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 28px; }
.hero-from { font-size: .8rem; color: rgba(200,220,255,.45); }
.hero-price { font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; font-weight: 300; color: #c8a96e; line-height: 1; }
.hero-price-sub { font-size: .82rem; color: rgba(200,220,255,.35); }
.hero-trust { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 20px; }
.trust-item { font-size: .75rem; color: rgba(200,220,255,.4); display: flex; align-items: center; gap: 6px; }
.trust-icon { color: #14a8a0; font-size: .7rem; }
.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(13,115,119,.2); border: 1px solid rgba(13,115,119,.4);
  padding: 6px 16px; border-radius: 100px;
  font-size: .75rem; letter-spacing: .1em; text-transform: uppercase; color: #14a8a0; margin-bottom: 28px;
}
.badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #14a8a0; animation: blink 2s infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
.hero-left h1 {
  font-family: 'Cormorant Garamond', serif; font-size: clamp(2.8rem, 5vw, 4rem);
  font-weight: 300; line-height: 1.1; margin-bottom: 24px; color: #fff;
}
.hero-left h1 em { color: #c8a96e; font-style: italic; }
.hero-sub { font-size: 1.05rem; color: rgba(255,255,255,.65); line-height: 1.7; margin-bottom: 32px; max-width: 520px; }
.hero-btns { display: flex; gap: 16px; flex-wrap: wrap; }
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

/* STEPS */
.steps-section { background: rgba(255,255,255,.015); border-top: 1px solid rgba(200,169,110,.2); padding: 100px 48px; }
.section-inner { max-width: 1100px; margin: 0 auto; }
.steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.step {
  text-align: center; padding: 32px 20px;
  border: 1px solid rgba(200,169,110,.2); border-radius: 12px; background: rgba(255,255,255,.02);
}
.step-num {
  width: 48px; height: 48px; border-radius: 50%;
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: #fff; margin: 0 auto 20px;
}
.step h4 { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 400; margin-bottom: 10px; color: #fff; }
.step p { font-size: .82rem; color: rgba(255,255,255,.45); line-height: 1.6; }

/* PACKAGES */
.packages-section {
  background: radial-gradient(ellipse 70% 70% at 50% 50%, rgba(13,115,119,.1) 0%, transparent 70%), #0a1628;
  border-top: 1px solid rgba(200,169,110,.2); padding: 100px 48px;
}
.packages-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; align-items: start; }
.pkg-card {
  border-radius: 16px; padding: 32px 28px; border: 2px solid rgba(200,169,110,.15);
  background: rgba(255,255,255,.03); cursor: pointer; transition: all .3s; position: relative;
}
.pkg-card:hover { border-color: rgba(200,169,110,.35); transform: translateY(-4px); }
.pkg-card.featured { border-color: rgba(13,115,119,.4); background: rgba(13,115,119,.08); transform: translateY(-8px); }
.pkg-card.selected { background: rgba(13,115,119,.18); border-color: #0d7377; box-shadow: 0 0 30px rgba(13,115,119,.2); }
.pkg-badge {
  position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
  background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff;
  font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
  padding: 4px 14px; border-radius: 100px;
}
.pkg-sessions { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .12em; color: rgba(200,220,255,.4); margin-bottom: 12px; }
.pkg-name { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 400; color: #fff; margin-bottom: 6px; }
.pkg-tagline { font-size: .82rem; color: rgba(255,255,255,.5); margin-bottom: 20px; }
.pkg-price { font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; font-weight: 300; color: #c8a96e; line-height: 1; margin-bottom: 6px; }
.pkg-saving { font-size: .78rem; color: #14a8a0; margin-bottom: 20px; }
.pkg-features { list-style: none; padding: 0; margin-bottom: 28px; }
.pkg-features li { display: flex; align-items: flex-start; gap: 8px; font-size: .82rem; color: rgba(255,255,255,.65); padding: 7px 0; border-bottom: 1px solid rgba(255,255,255,.04); }
.pkg-features li:last-child { border-bottom: none; }
.check { color: #14a8a0; flex-shrink: 0; }
.pkg-btn {
  width: 100%; padding: 13px; border-radius: 8px; font-size: .85rem; font-weight: 500;
  letter-spacing: .04em; cursor: pointer; transition: all .2s; text-align: center; border: none;
}
.pkg-btn-active { background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff; }
.pkg-btn-outline { background: transparent; color: rgba(255,255,255,.7); border: 1px solid rgba(200,169,110,.2); }
.pkg-btn-outline:hover { border-color: rgba(200,169,110,.5); color: #e8d5a3; }

/* INCLUDED */
.included-section { background: rgba(255,255,255,.015); border-top: 1px solid rgba(200,169,110,.2); padding: 100px 48px; }
.included-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 64px; align-items: center; }
.included-list { list-style: none; padding: 0; margin: 32px 0 0; display: flex; flex-direction: column; gap: 24px; }
.included-list li { display: flex; align-items: flex-start; gap: 16px; }
.inc-icon { color: #14a8a0; font-size: .8rem; width: 32px; height: 32px; border-radius: 8px; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.25); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.included-list li div strong { font-size: .9rem; color: rgba(255,255,255,.85); font-weight: 500; display: block; margin-bottom: 4px; }
.included-list li div p { font-size: .8rem; color: rgba(200,220,255,.4); line-height: 1.6; margin: 0; }
.privacy-card {
  background: rgba(13,31,58,.7); border: 1px solid rgba(13,115,119,.3); border-radius: 20px; padding: 40px 36px;
  text-align: center; backdrop-filter: blur(12px);
}
.privacy-icon { font-size: 2.5rem; margin-bottom: 16px; }
.privacy-card h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 300; color: #fff; margin-bottom: 10px; }
.privacy-card p { font-size: .83rem; color: rgba(200,220,255,.45); line-height: 1.65; margin-bottom: 22px; }
.privacy-list { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 10px; text-align: left; }
.privacy-list li { font-size: .8rem; color: rgba(200,220,255,.55); padding: 8px 12px; background: rgba(255,255,255,.03); border-radius: 8px; border: 1px solid rgba(255,255,255,.05); }
.privacy-badge { display: inline-block; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.35); color: #14a8a0; font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; padding: 6px 16px; border-radius: 100px; }

/* FORM */
.form-section { background: #0a1628; padding: 100px 48px; }
.form-card {
  max-width: 680px; margin: 0 auto;
  background: rgba(13,31,58,.6); border: 1px solid rgba(200,169,110,.15);
  border-radius: 20px; padding: 48px;
}
.form-title { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 300; color: #fff; margin-bottom: 8px; }
.form-sub { font-size: .85rem; color: rgba(200,220,255,.45); margin-bottom: 36px; }
.flash-success {
  background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.4);
  color: #14a8a0; border-radius: 10px; padding: 14px 18px; font-size: .85rem; margin-bottom: 24px;
}
.c-form { display: flex; flex-direction: column; gap: 20px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group label { font-size: .75rem; font-weight: 600; color: rgba(200,220,255,.5); letter-spacing: .05em; }
.form-group input, .form-group textarea {
  background: rgba(10,22,40,.7); border: 1px solid rgba(255,255,255,.1);
  border-radius: 10px; padding: 12px 16px; color: #fff; font-size: .88rem;
  font-family: 'DM Sans', sans-serif; transition: border-color .2s; resize: none; outline: none;
}
.form-group input::placeholder, .form-group textarea::placeholder { color: rgba(255,255,255,.2); }
.form-group input:focus, .form-group textarea:focus { border-color: rgba(13,115,119,.5); }
.form-error { font-size: .72rem; color: #f87171; }
.form-summary {
  background: rgba(10,22,40,.5); border: 1px solid rgba(200,169,110,.15);
  border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;
}
.summary-name { font-size: .9rem; font-weight: 600; color: #fff; margin-bottom: 2px; }
.summary-sub { font-size: .75rem; color: rgba(200,220,255,.4); }
.summary-price { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 300; color: #c8a96e; }
.submit-btn {
  background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff;
  border: none; border-radius: 8px; padding: 16px; font-size: .9rem; font-weight: 600;
  letter-spacing: .05em; cursor: pointer; transition: all .2s;
}
.submit-btn:hover { box-shadow: 0 8px 32px rgba(13,115,119,.5); transform: translateY(-1px); }
.submit-btn:disabled { opacity: .5; cursor: not-allowed; }
.form-notice { font-size: .72rem; color: rgba(200,220,255,.25); text-align: center; }

/* TESTIMONIALS */
.testimonials-section { background: rgba(255,255,255,.015); border-top: 1px solid rgba(200,169,110,.2); padding: 100px 48px; }
.testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.testimonial { background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.2); border-radius: 12px; padding: 28px; }
.stars { color: #c8a96e; margin-bottom: 14px; font-size: .9rem; }
.testimonial q {
  font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; font-style: italic;
  font-weight: 300; line-height: 1.55; color: rgba(255,255,255,.85); quotes: "\201C" "\201D";
  display: block; margin-bottom: 16px;
}
.testimonial q::before { content: open-quote; }
.testimonial q::after  { content: close-quote; }
.t-author { display: flex; flex-direction: column; gap: 2px; }
.t-name { font-size: .82rem; color: #fff; font-weight: 500; }
.t-prog { font-size: .72rem; color: #14a8a0; }

/* FAQ */
.faq-section { background: #0a1628; padding: 100px 48px; }
.faq-inner { max-width: 720px; margin: 0 auto; }
.faq-item {
  border: 1px solid rgba(200,169,110,.15); border-radius: 10px; margin-bottom: 12px;
  background: rgba(255,255,255,.02); cursor: pointer; overflow: hidden; transition: border-color .2s;
}
.faq-item.open { border-color: rgba(13,115,119,.4); }
.faq-q {
  display: flex; align-items: center; justify-content: space-between;
  padding: 18px 22px; font-size: .9rem; color: rgba(255,255,255,.85); font-weight: 500;
}
.faq-arrow { color: #14a8a0; font-size: 1.1rem; flex-shrink: 0; }
.faq-a { padding: 0 22px 18px; font-size: .83rem; color: rgba(200,220,255,.5); line-height: 1.65; }
.faq-notice {
  margin-top: 32px; background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.15);
  border-radius: 12px; padding: 22px 26px; font-size: .83rem; color: rgba(200,220,255,.45); line-height: 1.65;
}
.faq-notice-title { font-weight: 600; color: rgba(255,255,255,.7); margin-bottom: 8px; font-size: .85rem; }

/* CTA */
.cta-section {
  text-align: center;
  background: radial-gradient(ellipse 60% 80% at 50% 50%, rgba(13,115,119,.2) 0%, transparent 70%);
  border-top: 1px solid rgba(200,169,110,.2); padding: 120px 48px;
}
.cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }

/* SHARED */
.section-header { margin-bottom: 60px; }
.section-label { font-size: .72rem; letter-spacing: .18em; text-transform: uppercase; color: #14a8a0; margin-bottom: 14px; }
.section-title {
  font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 3.5vw, 3rem);
  font-weight: 300; line-height: 1.2; margin-bottom: 16px; color: #fff;
}
.section-sub { color: rgba(255,255,255,.55); font-size: 1rem; max-width: 520px; line-height: 1.6; }
.gold-italic { color: #c8a96e; font-style: italic; font-family: 'Cormorant Garamond', serif; }

@media (max-width: 1024px) {
  .hero-grid { grid-template-columns: 1fr; gap: 40px; }
  .hero-right { justify-content: center; }
  .hero-card { max-width: 100%; }
  .included-grid { grid-template-columns: 1fr; gap: 40px; }
}
@media (max-width: 900px) {
  .consult-hero { padding: 100px 24px 60px; }
  .steps-section, .packages-section, .included-section, .form-section, .testimonials-section, .faq-section, .cta-section { padding: 72px 24px; }
  .steps-grid { grid-template-columns: 1fr 1fr; }
  .packages-grid { grid-template-columns: 1fr; }
  .pkg-card.featured { transform: none; }
  .testimonials-grid { grid-template-columns: 1fr; }
  .form-card { padding: 32px 24px; }
  .form-row { grid-template-columns: 1fr; }
}
@media (max-width: 560px) {
  .steps-grid { grid-template-columns: 1fr; }
  .hero-card-footer { grid-template-columns: 1fr; }
}
</style>
