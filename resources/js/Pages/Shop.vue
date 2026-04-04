<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="shop-hero">
      <div class="hero-content">
        <div class="hero-badge"><span class="badge-dot"></span>{{ t('shop.hero_badge') }}</div>
        <h1>{{ t('shop.hero_title') }}<br><em>{{ t('shop.hero_title_em') }}</em></h1>
        <p class="hero-desc">{{ t('shop.hero_sub') }}</p>
        <div class="hero-prereqs">
          <div class="prereq">🎧 {{ t('shop.hero_prereq1') }}</div>
          <div class="prereq">⏱ {{ t('shop.hero_prereq2') }}</div>
          <div class="prereq">📱 {{ t('shop.hero_prereq3') }}</div>
        </div>
        <div class="hero-btns">
          <a href="#catalogue" class="btn-primary">{{ t('shop.hero_cta1') }}</a>
          <a href="#subscription" class="btn-outline">{{ t('shop.hero_cta2') }}</a>
        </div>
      </div>
    </section>

    <!-- ═══ PLANS D'ACCÈS ═══ -->
    <section class="sub-section" id="subscription">
      <div class="section-header" style="text-align:center">
        <p class="section-label">{{ t('shop.plan_label') }}</p>
        <h2 class="section-title">{{ t('shop.plan_title') }} <em class="gold-italic">{{ t('shop.plan_title_em') }}</em></h2>
        <p class="section-sub" style="margin:0 auto">{{ t('shop.plan_sub') }}</p>
      </div>
      <div class="plans-grid">
        <div class="plan-card">
          <p class="plan-name">Programme Unique</p>
          <p class="plan-desc">Un protocole ciblé, à vous pour toujours</p>
          <div class="plan-price"><span class="plan-currency">€</span><span class="plan-amount">11</span><span class="plan-period">/ programme</span></div>
          <ul class="plan-features">
            <li><span class="check">✦</span>1 programme de fréquences au choix</li>
            <li><span class="check">✦</span>Accès permanent via lien sécurisé</li>
            <li><span class="check">✦</span>Disponible sur tous les appareils</li>
            <li><span class="check">✦</span>Livré par email sous 24h</li>
          </ul>
          <a href="#catalogue" class="plan-btn plan-btn-outline">Parcourir</a>
        </div>
        <div class="plan-card featured">
          <div class="plan-badge">Le plus populaire</div>
          <p class="plan-name">Mensuel Illimité</p>
          <p class="plan-desc">Accès complet, renouvelé chaque mois</p>
          <div class="plan-price"><span class="plan-currency">€</span><span class="plan-amount">29.90</span><span class="plan-period">/ mois</span></div>
          <ul class="plan-features">
            <li><span class="check">✦</span>Accès à toute la bibliothèque de programmes</li>
            <li><span class="check">✦</span>Nouveaux protocoles ajoutés chaque mois</li>
            <li><span class="check">✦</span>Combinez et alternez librement</li>
            <li><span class="check">✦</span>Support email prioritaire</li>
            <li><span class="check">✦</span>Annulez à tout moment</li>
          </ul>
          <Link :href="route('shop')" class="plan-btn plan-btn-primary">À partir de €29.90 / mois</Link>
        </div>
        <div class="plan-card">
          <p class="plan-name">Annuel Illimité</p>
          <p class="plan-desc">Meilleure valeur — 2 mois gratuits</p>
          <div class="plan-price"><span class="plan-currency">€</span><span class="plan-amount">249</span><span class="plan-period">/ an</span></div>
          <ul class="plan-features">
            <li><span class="check">✦</span>Tout du mensuel inclus</li>
            <li><span class="check">✦</span>Économisez €109 vs facturation mensuelle</li>
            <li><span class="check">✦</span>1 consultation personnalisée incluse</li>
            <li><span class="check">✦</span>Accès anticipé aux nouveaux programmes</li>
            <li><span class="check">✦</span>Support email VIP</li>
          </ul>
          <Link :href="route('shop')" class="plan-btn plan-btn-outline">Accès Annuel</Link>
        </div>
      </div>
    </section>

    <!-- ═══ CATALOGUE ═══ -->
    <section class="catalogue-section" id="catalogue">
      <div class="section-header">
        <p class="section-label">{{ t('shop.catalogue_label') }}</p>
        <h2 class="section-title">{{ t('shop.catalogue_title') }} <em class="gold-italic">{{ t('shop.catalogue_title_em') }}</em></h2>
        <p class="section-sub">{{ t('shop.catalogue_sub') }}</p>
      </div>

      <!-- Filtres -->
      <div class="filters">
        <button class="filter-btn" :class="{ active: !activeCategory }" @click="activeCategory = null">{{ t('shop.all_programs') }}</button>
        <button v-for="cat in displayCategories" :key="cat.slug"
          class="filter-btn" :class="{ active: activeCategory === cat.slug }"
          @click="activeCategory = activeCategory === cat.slug ? null : cat.slug">
          {{ cat.emoji }} {{ cat.name }}
        </button>
      </div>

      <!-- Programmes par catégorie -->
      <template v-if="!activeCategory">
        <div v-for="cat in groupedCategories" :key="cat.slug" class="category-block">
          <div class="category-header">
            <span class="category-icon">{{ cat.emoji }}</span>
            <span class="category-name">{{ cat.name }}</span>
            <span class="category-count">{{ cat.programs.length }} programme{{ cat.programs.length > 1 ? 's' : '' }}</span>
          </div>
          <div class="programmes-grid">
            <div v-for="p in cat.programs" :key="p.id" class="program-card" @click="openDetail(p)">
              <span v-if="p.is_bestseller" class="prog-tag">⭐ Bestseller</span>
              <p class="prog-name">{{ p.title }}</p>
              <p class="prog-desc">{{ p.short_desc }}</p>
              <div class="prog-meta">
                <span v-if="p.session_duration || p.duration" class="prog-meta-item">⏱ {{ p.session_duration || p.duration }} min/séance</span>
                <span v-if="p.cure_duration || p.cure_days" class="prog-meta-item">🔄 {{ p.cure_duration || p.cure_days }}-jours de cure</span>
              </div>
              <div class="prog-footer">
                <span class="prog-price">€{{ p.price ?? 11 }}</span>
                <div class="prog-actions">
                  <button class="prog-details" @click.stop="openDetail(p)">{{ t('shop.details') }}</button>
                  <button class="prog-play" :class="{ playing: playingId === p.id && isPlaying }" @click.stop="playPreview(p, $event)">
                    <svg v-if="playingId === p.id && isPlaying" width="10" height="10" viewBox="0 0 12 12" fill="currentColor"><rect x="1" y="0" width="3.5" height="12"/><rect x="7.5" y="0" width="3.5" height="12"/></svg>
                    <svg v-else width="10" height="10" viewBox="0 0 12 12" fill="currentColor"><polygon points="2,0 12,6 2,12"/></svg>
                    {{ playingId === p.id && isPlaying ? t('shop.pause') : t('shop.listen') }}
                  </button>
                  <Link :href="route('cart.add')" method="post" as="button" :data="{ program_id: p.id }" class="prog-add" @click.stop>{{ t('shop.add_cart') }}</Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- Filtered view -->
      <template v-else>
        <div class="programmes-grid" style="margin-top:32px">
          <div v-for="p in filtered" :key="p.id" class="program-card" @click="openDetail(p)">
            <span v-if="p.is_bestseller" class="prog-tag">⭐ Bestseller</span>
            <p class="prog-name">{{ p.title }}</p>
            <p class="prog-desc">{{ p.short_desc }}</p>
            <div class="prog-meta">
              <span v-if="p.session_duration || p.duration" class="prog-meta-item">⏱ {{ p.session_duration || p.duration }} min/séance</span>
              <span v-if="p.cure_duration || p.cure_days" class="prog-meta-item">🔄 {{ p.cure_duration || p.cure_days }}-jours de cure</span>
            </div>
            <div class="prog-footer">
              <span class="prog-price">€{{ p.price ?? 11 }}</span>
              <div class="prog-actions">
                <button class="prog-details" @click.stop="openDetail(p)">{{ t('shop.details') }}</button>
                <button class="prog-play" :class="{ playing: playingId === p.id && isPlaying }" @click.stop="playPreview(p, $event)">
                  <svg v-if="playingId === p.id && isPlaying" width="10" height="10" viewBox="0 0 12 12" fill="currentColor"><rect x="1" y="0" width="3.5" height="12"/><rect x="7.5" y="0" width="3.5" height="12"/></svg>
                  <svg v-else width="10" height="10" viewBox="0 0 12 12" fill="currentColor"><polygon points="2,0 12,6 2,12"/></svg>
                  {{ playingId === p.id && isPlaying ? t('shop.pause') : t('shop.listen') }}
                </button>
                <Link :href="route('cart.add')" method="post" as="button" :data="{ program_id: p.id }" class="prog-add" @click.stop>{{ t('shop.add_cart') }}</Link>
              </div>
            </div>
          </div>
        </div>
        <div v-if="!filtered.length" class="text-center py-20" style="color:rgba(200,220,255,.4)">
          <p style="font-size:2.5rem;margin-bottom:12px">🔍</p>
          <p>Aucun programme dans cette catégorie.</p>
          <button @click="activeCategory=null" class="reset-btn">Voir tous les programmes</button>
        </div>
      </template>
    </section>

    <!-- ═══ COMMENT ÇA FONCTIONNE ═══ -->
    <section class="how-section">
      <div class="section-inner">
        <div class="section-header" style="text-align:center">
          <p class="section-label">{{ t('shop.how_label') }}</p>
          <h2 class="section-title">{{ t('shop.how_title') }} <em class="gold-italic">{{ t('shop.how_title_em') }}</em></h2>
        </div>
        <div class="steps-grid">
          <div v-for="(step, i) in howSteps" :key="i" class="step">
            <div class="step-num">{{ i + 1 }}</div>
            <h4>{{ step.title }}</h4>
            <p>{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ TESTIMONIALS ═══ -->
    <section class="testimonials-section">
      <div class="section-inner">
        <div class="section-header" style="text-align:center">
          <p class="section-label">{{ t('shop.community_label') }}</p>
          <h2 class="section-title">{{ t('shop.community_title') }} <em class="gold-italic">{{ t('shop.community_title_em') }}</em></h2>
        </div>
        <div class="testimonials-grid">
          <div v-for="t in displayTestimonials" :key="t.id || t.name" class="testimonial">
            <div class="stars">★★★★★</div>
            <q>{{ t.content }}</q>
            <div class="testimonial-author">{{ t.name }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ CTA ═══ -->
    <section class="cta-section">
      <p class="section-label" style="text-align:center">{{ t('shop.cta_now') }}</p>
      <h2 class="section-title" style="text-align:center">{{ t('shop.cta_freq_title') }} <em class="gold-italic">{{ t('shop.cta_freq_em') }}</em></h2>
      <p class="section-sub" style="text-align:center;margin:0 auto 40px">Parcourez nos programmes, abonnez-vous pour un accès illimité, ou réservez une consultation personnalisée avec le Dr. Éric Rosati.</p>
      <div class="cta-btns">
        <a href="#catalogue" class="btn-primary">Explorer tous les programmes</a>
        <Link :href="route('consultation')" class="btn-outline">Réserver une consultation — €58</Link>
      </div>
    </section>

    <!-- ═══ FLOATING AUDIO PLAYER ═══ -->
    <Teleport to="body">
      <transition name="audio-slide">
        <div v-if="playingId" class="audio-player-bar">
          <button class="apb-play" @click="toggleAudio">
            <svg v-if="isPlaying" width="14" height="14" viewBox="0 0 12 12" fill="currentColor"><rect x="1" y="0" width="3.5" height="12"/><rect x="7.5" y="0" width="3.5" height="12"/></svg>
            <svg v-else width="14" height="14" viewBox="0 0 12 12" fill="currentColor"><polygon points="2,0 12,6 2,12"/></svg>
          </button>
          <div class="apb-info">
            <p class="apb-title">{{ playingTitle }}</p>
            <div class="apb-progress-bar" @click="seekAudio">
              <div class="apb-progress-fill" :style="{ width: audioProgress + '%' }"></div>
            </div>
            <p class="apb-time">{{ formatTime(audioCurrent) }} / {{ formatTime(audioDuration) }}</p>
          </div>
          <button class="apb-close" @click="stopAudio">✕</button>
        </div>
      </transition>
    </Teleport>

    <!-- ═══ DETAIL POPUP ═══ -->
    <Teleport to="body">
    <div class="detail-overlay" :class="{ open: !!selectedProgram }" @click.self="closeDetail">
      <div v-if="selectedProgram" class="detail-modal">
        <div class="detail-modal-top"></div>
        <button class="detail-close" @click="closeDetail">✕</button>

        <div class="detail-header">
          <div class="detail-category">
            <span>{{ selectedProgram.category?.emoji || '✨' }}</span>
            {{ selectedProgram.category?.name || 'Programme' }}
          </div>
          <h2 class="detail-title">{{ selectedProgram.title || selectedProgram.title_fr }}</h2>
          <p class="detail-tagline">{{ selectedProgram.short_desc || selectedProgram.short_desc_fr }}</p>
          <div class="detail-metas">
            <span class="detail-pill">⏱ {{ selectedProgram.session_duration || selectedProgram.duration || '30' }} min/séance</span>
            <span class="detail-pill">🔄 {{ selectedProgram.cure_duration || selectedProgram.cure_days || '21' }}-jours de cure</span>
            <span class="detail-pill">🎧 Écouteurs requis</span>
          </div>
        </div>

        <div class="detail-body">
          <div class="detail-desc-block">
            <p class="detail-block-label">📋 Description</p>
            <div v-if="selectedProgram.long_desc" v-html="selectedProgram.long_desc" class="detail-desc-text"></div>
            <p v-else class="detail-desc-text">{{ selectedProgram.short_desc || selectedProgram.short_desc_fr }}</p>
          </div>

          <div class="detail-proto-block">
            <p class="detail-block-label">🧬 Protocole</p>
            <div class="proto-steps">
              <div class="proto-step"><div class="proto-dot"></div><p><strong>Séance quotidienne</strong> — Écoutez avec des écouteurs à conduction osseuse.</p></div>
              <div class="proto-step"><div class="proto-dot"></div><p><strong>Cure complète</strong> — Suivez le programme pendant {{ selectedProgram.cure_duration || selectedProgram.cure_days || '21' }} jours.</p></div>
              <div class="proto-step"><div class="proto-dot"></div><p><strong>Environnement calme</strong> — Installez-vous confortablement, yeux fermés.</p></div>
            </div>
          </div>

          <div v-if="selectedProgram.benefits?.length" class="detail-benefits">
            <p class="detail-block-label">✦ Bénéfices</p>
            <div class="benefits-list">
              <span v-for="(b, i) in selectedProgram.benefits" :key="i" class="benefit-tag">✓ {{ b }}</span>
            </div>
          </div>
        </div>

        <div class="detail-footer">
          <div class="detail-price-row">
            <span class="detail-price">€{{ selectedProgram.price ?? 11 }}</span>
            <span class="detail-price-note">/ programme · Accès permanent</span>
          </div>
          <div class="detail-actions">
            <Link :href="route('cart.add')" method="post" as="button"
              :data="{ program_id: selectedProgram.id }" class="btn-primary" @click="closeDetail">
              + Ajouter au panier — €{{ selectedProgram.price ?? 11 }}
            </Link>
            <button class="btn-outline" @click="closeDetail">Fermer</button>
          </div>
        </div>
      </div>
    </div>
    </Teleport>

  </AppLayout>
</template>

<script setup>
import { ref, computed, onUnmounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { useI18n } from '@/composables/useI18n'
const { t } = useI18n()

const props = defineProps({ programs: Array, categories: Array, testimonials: Array })

const activeCategory = ref(null)

const displayCategories = computed(() => {
  if (props.categories?.length) return props.categories
  return fallbackCategories
})

const groupedCategories = computed(() => {
  const cats = displayCategories.value
  const progs = props.programs?.length ? props.programs : fallbackPrograms
  return cats.map(cat => ({
    ...cat,
    programs: progs.filter(p => p.category?.slug === cat.slug || p.category_slug === cat.slug),
  })).filter(c => c.programs.length)
})

const filtered = computed(() => {
  const progs = props.programs?.length ? props.programs : fallbackPrograms
  if (!activeCategory.value) return progs
  return progs.filter(p => p.category?.slug === activeCategory.value || p.category_slug === activeCategory.value)
})

const displayTestimonials = computed(() => {
  const list = props.testimonials || []
  return list.length >= 3 ? list.slice(0, 3) : fallbackTestimonials
})

const selectedProgram = ref(null)
function openDetail(p) { selectedProgram.value = p }
function closeDetail() { selectedProgram.value = null }
function goToProgram(p) { openDetail(p) }

/* ── AUDIO PLAYER ── */
const audioEl       = ref(null)
const playingId     = ref(null)
const isPlaying     = ref(false)
const audioProgress = ref(0)
const audioCurrent  = ref(0)
const audioDuration = ref(0)
const playingTitle  = ref('')

function playPreview(p, e) {
  if (e) e.stopPropagation()
  if (!p.audio_url) { openDetail(p); return }
  if (playingId.value === p.id) {
    toggleAudio(); return
  }
  stopAudio()
  const el = new Audio(p.audio_url)
  audioEl.value = el
  playingId.value = p.id
  playingTitle.value = p.title
  el.addEventListener('timeupdate', () => {
    audioCurrent.value  = el.currentTime
    audioDuration.value = el.duration || 0
    audioProgress.value = el.duration ? (el.currentTime / el.duration) * 100 : 0
  })
  el.addEventListener('ended', () => { isPlaying.value = false; audioProgress.value = 0 })
  el.play().then(() => { isPlaying.value = true }).catch(() => { openDetail(p) })
}

function toggleAudio() {
  if (!audioEl.value) return
  if (isPlaying.value) { audioEl.value.pause(); isPlaying.value = false }
  else { audioEl.value.play(); isPlaying.value = true }
}

function stopAudio() {
  if (audioEl.value) { audioEl.value.pause(); audioEl.value = null }
  playingId.value = null; isPlaying.value = false; audioProgress.value = 0
}

function seekAudio(e) {
  if (!audioEl.value || !audioDuration.value) return
  const rect = e.currentTarget.getBoundingClientRect()
  const pct  = (e.clientX - rect.left) / rect.width
  audioEl.value.currentTime = pct * audioDuration.value
}

function formatTime(s) {
  if (!s || isNaN(s)) return '0:00'
  return `${Math.floor(s/60)}:${String(Math.floor(s%60)).padStart(2,'0')}`
}

onUnmounted(stopAudio)

const howSteps = [
  { title: 'Choisissez votre programme', desc: 'Parcourez notre bibliothèque et sélectionnez le protocole adapté à votre situation.' },
  { title: 'Écoutez avec des écouteurs', desc: 'Utilisez des écouteurs à conduction osseuse pour une transmission optimale des fréquences.' },
  { title: 'Laissez votre corps se recalibrer', desc: 'Suivez votre cure de 14 à 30 jours, 18–35 minutes par séance, à votre rythme.' },
  { title: 'Suivez vos progrès', desc: 'Constatez les changements progressifs et ajustez avec une consultation si besoin.' },
]

const fallbackCategories = [
  { slug: 'stress-emotions', name: 'Stress et Émotions', emoji: '🧘' },
  { slug: 'sommeil',         name: 'Sommeil',            emoji: '🌙' },
  { slug: 'douleur',         name: 'Douleur et Articulations', emoji: '🦴' },
  { slug: 'immunite',        name: 'Immunité',           emoji: '🛡️' },
  { slug: 'hormonal',        name: 'Hormonal',           emoji: '⚖️' },
  { slug: 'cognitif',        name: 'Cognitif',           emoji: '🧠' },
]

const fallbackPrograms = [
  { id: 1, title: 'Anti-Stress',         short_desc: 'Calme profondément le système nerveux et restaure l\'équilibre intérieur.', category_slug: 'stress-emotions', duration: 25, cure_days: 21, price: 11, is_bestseller: true },
  { id: 2, title: 'Anxiété & Angoisse',  short_desc: 'Soulage l\'oppression thoracique, la panique et les sensations de peur.',  category_slug: 'stress-emotions', duration: 30, cure_days: 28, price: 11 },
  { id: 3, title: 'Burn-Out',            short_desc: 'Reconstruit le système nerveux après épuisement total.',                   category_slug: 'stress-emotions', duration: 35, cure_days: 30, price: 11 },
  { id: 4, title: 'Troubles du Sommeil', short_desc: 'Restaure des cycles de sommeil sains et un repos profond.',                category_slug: 'sommeil',         duration: 30, cure_days: 21, price: 11, is_bestseller: true },
  { id: 5, title: 'Fatigue Chronique',   short_desc: 'Cible l\'épuisement cellulaire profond et reconstruit les réserves d\'énergie.', category_slug: 'sommeil',    duration: 35, cure_days: 28, price: 11 },
  { id: 6, title: 'Douleur Articulaire — Arthrose', short_desc: 'Réduit l\'inflammation et la raideur articulaire.',             category_slug: 'douleur',         duration: 30, cure_days: 28, price: 11 },
  { id: 7, title: 'Céphalées & Migraine',short_desc: 'Soulage les céphalées de tension et les migraines vasculaires.',           category_slug: 'douleur',         duration: 25, cure_days: 21, price: 11 },
  { id: 8, title: 'Sciatique',           short_desc: 'Cible l\'inflammation du nerf sciatique.',                                 category_slug: 'douleur',         duration: 30, cure_days: 28, price: 11 },
  { id: 9, title: 'Renforcement de l\'Immunité', short_desc: 'Renforce les défenses naturelles contre les infections.',          category_slug: 'immunite',        duration: 25, cure_days: 21, price: 11 },
  { id: 10, title: 'Ménopause',          short_desc: 'Régule les bouffées de chaleur, les sautes d\'humeur et les troubles du sommeil.', category_slug: 'hormonal', duration: 30, cure_days: 30, price: 11 },
]

const fallbackTestimonials = [
  { name: 'Fabienne R.', content: 'Une solution complète — et sans médicaments. Je n\'arrive pas à croire à quel point c\'est efficace.' },
  { name: 'Caroline M.', content: 'Plus d\'allergie après 1 mois de fréquences. Tellement heureuse des résultats.' },
  { name: 'Karine T.',   content: 'Mon insomnie et mes bouffées de chaleur ont complètement disparu. Je ne peux plus vivre sans Vitality Inside.' },
]
</script>

<style scoped>
/* HERO */
.shop-hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  padding: 120px 48px 80px;
  background: radial-gradient(ellipse 80% 60% at 60% 40%, rgba(13,115,119,.18) 0%, transparent 70%),
              radial-gradient(ellipse 50% 50% at 20% 80%, rgba(200,169,110,.08) 0%, transparent 60%),
              #0a1628;
  position: relative;
  overflow: hidden;
}
.hero-content { max-width: 680px; position: relative; z-index: 2; }
.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(13,115,119,.2); border: 1px solid rgba(13,115,119,.4);
  padding: 6px 16px; border-radius: 100px;
  font-size: .75rem; letter-spacing: .1em; text-transform: uppercase; color: #14a8a0;
  margin-bottom: 28px;
}
.badge-dot {
  width: 6px; height: 6px; border-radius: 50%; background: #14a8a0;
  animation: blink 2s infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
.hero-content h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.8rem, 5vw, 4.5rem);
  font-weight: 300; line-height: 1.1; margin-bottom: 20px; color: #fff;
}
.hero-content h1 em { color: #c8a96e; font-style: italic; }
.hero-desc { font-size: 1.05rem; color: rgba(255,255,255,.65); line-height: 1.7; margin-bottom: 32px; max-width: 520px; }
.hero-prereqs { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 36px; }
.prereq {
  display: flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.04); border: 1px solid rgba(200,169,110,.2);
  border-radius: 8px; padding: 10px 16px; font-size: .82rem; color: rgba(255,255,255,.75);
}
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

/* SUBSCRIPTION */
.sub-section {
  background: radial-gradient(ellipse 70% 70% at 50% 50%, rgba(13,115,119,.12) 0%, transparent 70%), #0a1628;
  border-top: 1px solid rgba(200,169,110,.2); border-bottom: 1px solid rgba(200,169,110,.2);
  padding: 100px 48px;
}
.plans-grid {
  display: grid; grid-template-columns: 1fr 1fr 1fr;
  gap: 24px; max-width: 1100px; margin: 0 auto;
}
.plan-card {
  border-radius: 16px; padding: 36px 32px; border: 1px solid rgba(200,169,110,.2);
  background: rgba(255,255,255,.03); position: relative; transition: transform .3s, border-color .3s;
}
.plan-card:hover { transform: translateY(-4px); border-color: rgba(200,169,110,.4); }
.plan-card.featured {
  background: linear-gradient(145deg, rgba(13,115,119,.25), rgba(10,22,40,.8));
  border-color: #0d7377; transform: scale(1.03);
}
.plan-card.featured:hover { transform: scale(1.03) translateY(-4px); }
.plan-badge {
  position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  padding: 4px 18px; border-radius: 100px;
  font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; white-space: nowrap; color: #fff;
}
.plan-name { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 400; margin-bottom: 6px; color: #fff; }
.plan-desc { font-size: .82rem; color: rgba(255,255,255,.5); margin-bottom: 28px; }
.plan-price { display: flex; align-items: baseline; gap: 4px; margin-bottom: 28px; }
.plan-amount { font-family: 'Cormorant Garamond', serif; font-size: 3.2rem; font-weight: 300; color: #c8a96e; line-height: 1; }
.plan-currency { font-size: 1.4rem; color: #c8a96e; align-self: flex-start; margin-top: 8px; }
.plan-period { color: rgba(255,255,255,.4); font-size: .85rem; }
.plan-features { list-style: none; padding: 0; margin-bottom: 32px; }
.plan-features li { display: flex; align-items: flex-start; gap: 10px; font-size: .875rem; color: rgba(255,255,255,.75); padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,.05); }
.plan-features li:last-child { border-bottom: none; }
.check { color: #14a8a0; flex-shrink: 0; }
.plan-btn {
  width: 100%; padding: 14px; border-radius: 8px; font-size: .88rem; font-weight: 500;
  letter-spacing: .04em; cursor: pointer; border: none; transition: all .2s;
  text-align: center; text-decoration: none; display: block;
}
.plan-btn-primary { background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff; box-shadow: 0 6px 24px rgba(13,115,119,.4); }
.plan-btn-primary:hover { box-shadow: 0 10px 32px rgba(13,115,119,.6); transform: translateY(-1px); }
.plan-btn-outline { background: transparent; color: rgba(255,255,255,.7); border: 1px solid rgba(200,169,110,.2); }
.plan-btn-outline:hover { border-color: rgba(200,169,110,.5); color: #e8d5a3; }

/* CATALOGUE */
.catalogue-section { background: #0a1628; padding: 100px 48px; }
.filters { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 48px; }
.filter-btn {
  padding: 9px 20px; border-radius: 100px; border: 1px solid rgba(200,169,110,.2);
  background: transparent; color: rgba(255,255,255,.6);
  font-size: .8rem; letter-spacing: .04em; cursor: pointer; transition: all .2s;
}
.filter-btn:hover, .filter-btn.active {
  background: rgba(13,115,119,.2); border-color: #0d7377; color: #fff;
}
.category-block { margin-bottom: 64px; }
.category-header {
  display: flex; align-items: center; gap: 16px;
  margin-bottom: 28px; padding-bottom: 16px; border-bottom: 1px solid rgba(200,169,110,.2);
}
.category-icon { font-size: 1.4rem; }
.category-name { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 300; color: #fff; }
.category-count {
  margin-left: auto; font-size: .78rem; color: #6b7a8d;
  background: rgba(255,255,255,.05); padding: 4px 12px; border-radius: 100px;
}
.programmes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
.program-card {
  background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.2);
  border-radius: 12px; padding: 22px; cursor: pointer; transition: all .25s; position: relative; overflow: hidden;
}
.program-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, #0d7377, #14a8a0);
  transform: scaleX(0); transition: transform .3s; transform-origin: left;
}
.program-card:hover { border-color: rgba(13,115,119,.5); transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,.3); }
.program-card:hover::before { transform: scaleX(1); }
.prog-tag {
  display: inline-block; background: rgba(200,169,110,.1); border: 1px solid rgba(200,169,110,.2);
  color: #e8d5a3; font-size: .7rem; padding: 2px 10px; border-radius: 100px; margin-bottom: 10px;
}
.prog-name { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 400; margin-bottom: 6px; color: #fff; }
.prog-desc { font-size: .78rem; color: rgba(255,255,255,.45); line-height: 1.5; margin-bottom: 16px; }
.prog-meta { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: nowrap; overflow: hidden; }
.prog-meta-item {
  font-size: .7rem; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.2);
  color: #14a8a0; padding: 3px 10px; border-radius: 100px;
}
.prog-footer { display: flex; flex-direction: column; gap: 10px; padding-top: 14px; border-top: 1px solid rgba(200,169,110,.1); }
.prog-price { color: #c8a96e; font-size: 1.1rem; font-weight: 500; }
.prog-actions { display: flex; gap: 6px; flex-wrap: wrap; }
.prog-details {
  background: transparent; border: 1px solid rgba(255,255,255,.15); color: rgba(255,255,255,.6);
  font-size: .72rem; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: all .2s;
}
.prog-details:hover { border-color: #14a8a0; color: #14a8a0; }
.prog-add {
  background: rgba(13,115,119,.25); border: 1px solid rgba(13,115,119,.4); color: #14a8a0;
  font-size: .72rem; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: all .2s;
  text-decoration: none; display: inline-block;
}
.prog-add:hover { background: rgba(13,115,119,.5); color: #fff; }
.prog-play {
  background: linear-gradient(135deg, #0d7377, #14a8a0); border: none; color: #fff;
  font-size: .72rem; padding: 6px 13px; border-radius: 6px; cursor: pointer; transition: all .2s;
  font-family: 'DM Sans', sans-serif; display: flex; align-items: center; gap: 5px;
  box-shadow: 0 3px 12px rgba(13,115,119,.4);
}
.prog-play:hover { transform: scale(1.05); box-shadow: 0 5px 18px rgba(13,115,119,.6); }
.prog-play svg { flex-shrink: 0; }
.reset-btn {
  margin-top: 16px; color: #14a8a0; background: none; border: none; cursor: pointer; font-size: .85rem;
}
.reset-btn:hover { text-decoration: underline; }

/* HOW IT WORKS */
.how-section {
  background: rgba(255,255,255,.015); border-top: 1px solid rgba(200,169,110,.2); padding: 100px 48px;
}
.section-inner { max-width: 1100px; margin: 0 auto; }
.steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; max-width: 1100px; margin: 0 auto; }
.step {
  text-align: center; padding: 32px 20px;
  border: 1px solid rgba(200,169,110,.2); border-radius: 12px; background: rgba(255,255,255,.02);
}
.step-num {
  width: 48px; height: 48px; border-radius: 50%;
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: #fff;
  margin: 0 auto 20px;
}
.step h4 { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 400; margin-bottom: 10px; color: #fff; }
.step p { font-size: .82rem; color: rgba(255,255,255,.45); line-height: 1.6; }

/* TESTIMONIALS */
.testimonials-section { background: #0a1628; padding: 100px 48px; }
.testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 1100px; margin: 0 auto; }
.testimonial {
  background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.2);
  border-radius: 12px; padding: 28px;
}
.stars { color: #c8a96e; margin-bottom: 14px; font-size: .9rem; }
.testimonial q {
  font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-style: italic;
  font-weight: 300; line-height: 1.5; color: rgba(255,255,255,.85);
  quotes: "\201C" "\201D";
}
.testimonial q::before { content: open-quote; }
.testimonial q::after  { content: close-quote; }
.testimonial-author {
  margin-top: 16px; font-size: .8rem; color: #6b7a8d;
  display: flex; align-items: center; gap: 8px;
}
.testimonial-author::before { content: ''; display: block; width: 24px; height: 1px; background: #0d7377; }

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

/* DETAIL POPUP */
/* FLOATING AUDIO PLAYER */
.audio-player-bar {
  position: fixed; bottom: 0; left: 0; right: 0; z-index: 9999;
  background: rgba(10,22,40,.97); border-top: 1px solid rgba(200,169,110,.25);
  backdrop-filter: blur(20px); display: flex; align-items: center; gap: 16px;
  padding: 12px 24px; box-shadow: 0 -4px 32px rgba(0,0,0,.5);
}
.apb-play {
  width: 40px; height: 40px; border-radius: 50%;
  background: linear-gradient(135deg,#0d7377,#14a8a0);
  border: none; cursor: pointer; flex-shrink:0; display:flex;
  align-items:center; justify-content:center; color:#fff;
  transition: transform .2s;
}
.apb-play:hover { transform: scale(1.08); }
.apb-info { flex: 1; min-width: 0; }
.apb-title { font-size:.8rem; font-weight:600; color:#fff; margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.apb-progress-bar {
  height: 4px; background: rgba(255,255,255,.12); border-radius:2px;
  cursor: pointer; position:relative; margin-bottom:4px;
}
.apb-progress-fill { height:100%; background:linear-gradient(90deg,#0d7377,#14a8a0); border-radius:2px; transition:width .1s linear; }
.apb-time { font-size:.65rem; color:rgba(200,220,255,.4); }
.apb-close {
  width:28px; height:28px; border-radius:50%; background:rgba(255,255,255,.07);
  border:1px solid rgba(255,255,255,.1); color:rgba(200,220,255,.5);
  cursor:pointer; font-size:.75rem; display:flex; align-items:center; justify-content:center;
  transition:all .2s;
}
.apb-close:hover { background:rgba(239,68,68,.2); color:#ef4444; }
.audio-slide-enter-active, .audio-slide-leave-active { transition: transform .3s ease, opacity .3s; }
.audio-slide-enter-from, .audio-slide-leave-to { transform: translateY(100%); opacity: 0; }
.prog-play.playing { background: rgba(13,115,119,.25); color:#14a8a0; border-color:rgba(13,115,119,.4); }

.detail-overlay {
  position: fixed; inset: 0; background: rgba(5,12,24,.8); backdrop-filter: blur(12px);
  z-index: 600; display: flex; align-items: center; justify-content: center;
  padding: 24px; opacity: 0; pointer-events: none; transition: opacity .3s;
}
.detail-overlay.open { opacity: 1; pointer-events: all; }
.detail-modal {
  background: linear-gradient(145deg, #0d1f3a, #081222);
  border: 1px solid rgba(200,169,110,.2); border-radius: 20px;
  width: 100%; max-width: 620px; max-height: 90vh; overflow-y: auto;
  position: relative; transform: translateY(30px); transition: transform .35s cubic-bezier(.34,1.56,.64,1);
}
.detail-overlay.open .detail-modal { transform: translateY(0); }
.detail-modal-top { height: 3px; background: linear-gradient(90deg, #0d7377, #14a8a0, #c8a96e); border-radius: 20px 20px 0 0; }
.detail-close {
  position: absolute; top: 16px; right: 16px; z-index: 2;
  background: rgba(255,255,255,.07); border: 1px solid rgba(200,169,110,.2);
  color: rgba(255,255,255,.6); width: 32px; height: 32px; border-radius: 50%;
  font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center;
  transition: all .2s;
}
.detail-close:hover { background: rgba(255,255,255,.15); color: #fff; }
.detail-header { padding: 28px 28px 0; }
.detail-category {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: .72rem; letter-spacing: .14em; text-transform: uppercase;
  color: #14a8a0; margin-bottom: 12px;
}
.detail-title {
  font-family: 'Cormorant Garamond', serif; font-size: 2rem;
  font-weight: 300; line-height: 1.15; color: #fff; margin-bottom: 10px;
}
.detail-tagline { font-size: .9rem; color: rgba(255,255,255,.55); line-height: 1.6; margin-bottom: 20px; }
.detail-metas { display: flex; flex-wrap: nowrap; gap: 8px; margin-bottom: 4px; overflow-x: auto; }
.detail-pill {
  font-size: .72rem; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.25);
  color: #14a8a0; padding: 4px 14px; border-radius: 100px;
}
.detail-body { padding: 20px 28px; display: flex; flex-direction: column; gap: 20px; }
.detail-block-label {
  font-size: .72rem; letter-spacing: .12em; text-transform: uppercase;
  color: #14a8a0; margin-bottom: 10px;
}
.detail-desc-block, .detail-proto-block, .detail-benefits {
  background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.15);
  border-radius: 12px; padding: 18px;
}
.detail-desc-text { font-size: .85rem; color: rgba(255,255,255,.65); line-height: 1.7; }
.proto-steps { display: flex; flex-direction: column; gap: 10px; }
.proto-step { display: flex; align-items: flex-start; gap: 10px; }
.proto-dot { width: 7px; height: 7px; border-radius: 50%; background: #14a8a0; flex-shrink: 0; margin-top: 6px; }
.proto-step p { font-size: .82rem; color: rgba(255,255,255,.7); line-height: 1.5; }
.proto-step strong { color: #fff; }
.benefits-list { display: flex; flex-wrap: wrap; gap: 8px; }
.benefit-tag {
  font-size: .78rem; background: rgba(13,115,119,.12); border: 1px solid rgba(13,115,119,.2);
  color: #14a8a0; padding: 4px 14px; border-radius: 100px;
}
.detail-footer {
  padding: 20px 28px 28px; border-top: 1px solid rgba(200,169,110,.15); margin-top: 4px;
}
.detail-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 16px; }
.detail-price { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; color: #c8a96e; font-weight: 300; }
.detail-price-note { font-size: .8rem; color: rgba(255,255,255,.35); }
.detail-actions { display: flex; gap: 12px; flex-wrap: wrap; }

@media (max-width: 900px) {
  .shop-hero { padding: 100px 24px 60px; }
  .sub-section, .catalogue-section, .how-section, .testimonials-section, .cta-section { padding: 72px 24px; }
  .plans-grid { grid-template-columns: 1fr; }
  .plan-card.featured { transform: none; }
  .steps-grid { grid-template-columns: 1fr 1fr; }
  .testimonials-grid { grid-template-columns: 1fr; }
  .detail-modal { max-width: 100%; }
}
@media (max-width: 560px) {
  .steps-grid { grid-template-columns: 1fr; }
}
</style>
