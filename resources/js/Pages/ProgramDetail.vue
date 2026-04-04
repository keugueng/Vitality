<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="detail-hero">
      <div class="hero-inner">
        <!-- Left column -->
        <div class="hero-left">
          <nav class="breadcrumb">
            <Link :href="route('shop')" class="bc-link">Boutique</Link>
            <span class="bc-sep">/</span>
            <span class="bc-current">{{ program.title }}</span>
          </nav>

          <div class="hero-category">
            <span>{{ program.category?.emoji || '✨' }}</span>
            {{ program.category?.name || 'Programme' }}
          </div>

          <h1 class="hero-title">{{ program.title }}</h1>

          <p class="hero-tagline">{{ program.short_desc }}</p>

          <div class="hero-metas">
            <span class="meta-pill">⏱ {{ program.session_duration || '30 min' }}/séance</span>
            <span class="meta-pill">🔄 {{ program.cure_duration || '21-jours de cure' }}</span>
            <span class="meta-pill">🎧 Écouteurs requis</span>
          </div>

          <div class="hero-btns">
            <button class="btn-listen" @click="openPlayer">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor"><polygon points="2,0 12,6 2,12"/></svg>
              Écouter
            </button>
            <Link :href="route('cart.add')" method="post" as="button"
              :data="{ program_id: program.id }" class="btn-primary">
              + Panier — €{{ program.price }}
            </Link>
            <Link :href="route('shop')" class="btn-outline">Retour Boutique</Link>
          </div>
        </div>

        <!-- Right column: visual card -->
        <div class="hero-right">
          <div class="visual-card">
            <div class="visual-emoji">{{ program.emoji || '✨' }}</div>
            <span v-if="program.is_bestseller" class="visual-badge">⭐ Bestseller</span>
            <div class="visual-price">
              <span class="vp-currency">€</span>
              <span class="vp-amount">{{ program.price }}</span>
            </div>
            <div class="visual-access">Accès permanent · Tous appareils</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ DETAIL GRID ═══ -->
    <section class="detail-section">
      <div class="detail-grid">
        <!-- Description -->
        <div class="detail-box">
          <div class="detail-box-title"><span>📋</span> Description</div>
          <div class="detail-text" v-if="program.long_desc" v-html="program.long_desc"></div>
          <p class="detail-text" v-else>{{ program.short_desc }}</p>
        </div>

        <!-- Protocole -->
        <div class="detail-box">
          <div class="detail-box-title"><span>🧬</span> Protocole</div>
          <div class="protocole-steps">
            <div class="protocole-step">
              <div class="protocole-dot"></div>
              <p><strong>Séance quotidienne</strong> — Écoutez avec des écouteurs à conduction osseuse, {{ program.session_duration || '30 min' }} par jour.</p>
            </div>
            <div class="protocole-step">
              <div class="protocole-dot"></div>
              <p><strong>Cure complète</strong> — Suivez le programme pendant {{ program.cure_duration || '21 jours' }} pour des résultats optimaux.</p>
            </div>
            <div class="protocole-step">
              <div class="protocole-dot"></div>
              <p><strong>Environnement calme</strong> — Installez-vous confortablement, yeux fermés si possible.</p>
            </div>
          </div>
          <div class="protocole-bar">
            <div class="protocole-stat">
              <span class="protocole-stat-val">{{ extractMinutes(program.session_duration) || '30' }}</span>
              <span class="protocole-stat-lbl">min/séance</span>
            </div>
            <div class="protocole-stat">
              <span class="protocole-stat-val">{{ extractDays(program.cure_duration) || '21' }}</span>
              <span class="protocole-stat-lbl">jours de cure</span>
            </div>
            <div class="protocole-stat">
              <span class="protocole-stat-val">1x</span>
              <span class="protocole-stat-lbl">par jour</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Benefits full-width -->
      <div v-if="program.benefits?.length" class="detail-full">
        <div class="detail-box-title"><span>✦</span> Bénéfices</div>
        <div class="benefits-grid">
          <div v-for="(b, i) in program.benefits" :key="i" class="benefit-item">
            <span class="benefit-check">✓</span>
            <span>{{ b }}</span>
          </div>
        </div>
      </div>

      <!-- Tags -->
      <div v-if="program.tags?.length" class="tags-row">
        <span v-for="tag in program.tags" :key="tag" class="tag-pill">#{{ tag }}</span>
      </div>

      <!-- CTA -->
      <div class="detail-cta">
        <div class="cta-price-block">
          <div class="cta-price-display">
            <span class="cta-price-big">€{{ program.price }}</span>
            <span class="cta-price-sub">/ programme</span>
          </div>
          <div class="cta-price-note">Accès permanent · Livré par email</div>
        </div>
        <div class="cta-actions">
          <button class="btn-listen" @click="openPlayer">
            <svg width="11" height="11" viewBox="0 0 12 12" fill="currentColor"><polygon points="2,0 12,6 2,12"/></svg>
            Écouter
          </button>
          <Link :href="route('cart.add')" method="post" as="button"
            :data="{ program_id: program.id }" class="btn-primary">
            Ajouter au panier — €{{ program.price }}
          </Link>
        </div>
      </div>
    </section>

    <!-- ═══ RELATED PROGRAMS ═══ -->
    <section v-if="related?.length" class="related-section">
      <div class="section-header" style="text-align:center">
        <p class="section-label">Programmes similaires</p>
        <h2 class="section-title">Explorez d'autres <em class="gold-italic">protocoles</em></h2>
      </div>
      <div class="related-grid">
        <div v-for="p in related" :key="p.id" class="program-card" @click="goToProgram(p)">
          <span v-if="p.is_bestseller" class="prog-tag">⭐ Bestseller</span>
          <p class="prog-name">{{ p.title }}</p>
          <p class="prog-desc">{{ p.short_desc }}</p>
          <div class="prog-meta">
            <span v-if="p.session_duration" class="prog-meta-item">⏱ {{ p.session_duration }}/séance</span>
            <span v-if="p.cure_duration" class="prog-meta-item">🔄 {{ p.cure_duration }}</span>
          </div>
          <div class="prog-footer">
            <span class="prog-price">€{{ p.price ?? 11 }}</span>
            <div class="prog-actions">
              <button class="prog-details" @click.stop="goToProgram(p)">Détails</button>
              <button class="prog-play" @click.stop="openPlayerFor(p)">
                <svg width="10" height="10" viewBox="0 0 12 12" fill="currentColor"><polygon points="2,0 12,6 2,12"/></svg>
                Écouter
              </button>
              <Link :href="route('cart.add')" method="post" as="button"
                :data="{ program_id: p.id }" class="prog-add" @click.stop>+ Panier</Link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ CTA FINAL ═══ -->
    <section class="final-cta">
      <p class="section-label" style="text-align:center">Commencez maintenant</p>
      <h2 class="section-title" style="text-align:center">Votre fréquence de guérison <em class="gold-italic">vous attend</em></h2>
      <div class="final-cta-btns">
        <Link :href="route('shop')" class="btn-primary">Explorer tous les programmes</Link>
        <Link :href="route('consultation')" class="btn-outline">Réserver une consultation — €58</Link>
      </div>
    </section>

    <!-- ═══ PLAYER OVERLAY ═══ -->
    <div class="player-overlay" :class="{ open: playerOpen }" @click.self="closePlayer">
      <div class="player-card">
        <div class="player-card-top"></div>
        <div class="player-header">
          <div class="player-title-block">
            <div class="player-label">{{ playerProgram?.category?.name || 'Programme' }}</div>
            <div class="player-name">{{ playerProgram?.title }}</div>
          </div>
          <button class="player-close" @click="closePlayer">✕</button>
        </div>

        <!-- Access badge -->
        <div class="player-access subscribed">
          <span class="pa-icon">🎧</span>
          <div class="pa-info">
            <div class="pa-badge">Écoute disponible</div>
            <div class="pa-desc">Utilisez des écouteurs à conduction osseuse</div>
          </div>
        </div>

        <!-- Instructions -->
        <div class="player-instructions">
          <div class="pi-title">Instructions de séance</div>
          <div class="pi-items">
            <div class="pi-item"><span class="pi-dot">🎧</span> Portez vos écouteurs à conduction osseuse</div>
            <div class="pi-item"><span class="pi-dot">🧘</span> Installez-vous confortablement, yeux fermés</div>
            <div class="pi-item"><span class="pi-dot">⏱</span> Laissez jouer jusqu'à la fin de la séance</div>
          </div>
        </div>

        <!-- Timer -->
        <div class="player-timer-wrap">
          <div class="timer-ring">
            <svg width="52" height="52" viewBox="0 0 52 52">
              <defs><linearGradient id="timerGrad" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#0d7377"/><stop offset="100%" stop-color="#14a8a0"/></linearGradient></defs>
              <circle class="bg" cx="26" cy="26" r="23"/>
              <circle class="fg" cx="26" cy="26" r="23"
                :stroke-dasharray="circumference"
                :stroke-dashoffset="circumference - (circumference * playProgress / 100)"/>
            </svg>
            <div class="timer-center">{{ formatTime(playElapsed) }}</div>
          </div>
          <div class="timer-info">
            <div class="timer-label">Durée de la séance</div>
            <div class="timer-duration">{{ playerProgram?.session_duration || '30 min' }}</div>
          </div>
        </div>

        <!-- Waveform -->
        <div class="player-waveform" :class="{ playing: isPlaying }">
          <div v-for="i in 40" :key="i" class="wv-bar"
            :style="{ height: waveHeights[i-1] + 'px', '--d': (0.4 + Math.random()*0.4).toFixed(2) + 's' }"></div>
        </div>

        <!-- Controls -->
        <div class="player-controls">
          <button class="pc-btn" @click="seekBack">⏪</button>
          <button class="pc-play" @click="togglePlay">{{ isPlaying ? '⏸' : '▶' }}</button>
          <button class="pc-btn" @click="seekForward">⏩</button>
        </div>
        <div class="pc-note">Fichier audio hébergé de manière sécurisée</div>
      </div>
    </div>

  </AppLayout>
</template>

<script setup>
import { ref, computed, onUnmounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({ program: Object, related: Array })

/* ── Player state ── */
const playerOpen = ref(false)
const playerProgram = ref(null)
const isPlaying = ref(false)
const playElapsed = ref(0)
const playProgress = ref(0)
let playInterval = null
const circumference = 2 * Math.PI * 23

const waveHeights = Array.from({ length: 40 }, () => 8 + Math.floor(Math.random() * 24))

function openPlayer() { openPlayerFor(props.program) }
function openPlayerFor(p) {
  playerProgram.value = p
  playerOpen.value = true
  isPlaying.value = false
  playElapsed.value = 0
  playProgress.value = 0
  clearInterval(playInterval)
}
function closePlayer() {
  playerOpen.value = false
  isPlaying.value = false
  clearInterval(playInterval)
}
function togglePlay() {
  isPlaying.value = !isPlaying.value
  if (isPlaying.value) {
    const totalSec = extractMinutes(playerProgram.value?.session_duration) * 60 || 1800
    playInterval = setInterval(() => {
      playElapsed.value++
      playProgress.value = Math.min((playElapsed.value / totalSec) * 100, 100)
      if (playProgress.value >= 100) { isPlaying.value = false; clearInterval(playInterval) }
    }, 1000)
  } else {
    clearInterval(playInterval)
  }
}
function seekBack() { playElapsed.value = Math.max(0, playElapsed.value - 30) }
function seekForward() { playElapsed.value = Math.min(playElapsed.value + 30, 3600) }
function formatTime(s) {
  const m = Math.floor(s / 60)
  const sec = s % 60
  return `${m}:${sec.toString().padStart(2, '0')}`
}
function extractMinutes(str) {
  if (!str) return 30
  const m = String(str).match(/(\d+)/)
  return m ? parseInt(m[1]) : 30
}
function extractDays(str) {
  if (!str) return 21
  const m = String(str).match(/(\d+)/)
  return m ? parseInt(m[1]) : 21
}
function goToProgram(p) {
  if (p.slug) router.visit(route('shop.show', p.slug))
}

onUnmounted(() => clearInterval(playInterval))
</script>

<style scoped>
/* ─── VARIABLES ─── */
:root {
  --deep: #0a1628;
  --teal: #0d7377;
  --teal-light: #14a8a0;
  --gold: #c8a96e;
  --gold-light: #e8d5a3;
  --border: rgba(200,169,110,0.2);
  --muted: #6b7a8d;
}

/* ─── HERO ─── */
.detail-hero {
  padding: 120px 48px 80px;
  background: radial-gradient(ellipse 80% 60% at 60% 40%, rgba(13,115,119,.18) 0%, transparent 70%),
              radial-gradient(ellipse 50% 50% at 20% 80%, rgba(200,169,110,.08) 0%, transparent 60%),
              #0a1628;
  position: relative; overflow: hidden;
}
.hero-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 380px; gap: 60px; align-items: center; }
.breadcrumb { display: flex; align-items: center; gap: 8px; font-size: .78rem; margin-bottom: 24px; }
.bc-link { color: rgba(255,255,255,.5); text-decoration: none; transition: color .2s; }
.bc-link:hover { color: #14a8a0; }
.bc-sep { color: rgba(255,255,255,.25); }
.bc-current { color: #14a8a0; }
.hero-category {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: .72rem; letter-spacing: .14em; text-transform: uppercase;
  color: #14a8a0; margin-bottom: 16px;
}
.hero-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.4rem, 4.5vw, 3.8rem);
  font-weight: 300; line-height: 1.1; color: #fff; margin-bottom: 16px;
}
.hero-tagline { font-size: 1.05rem; color: rgba(255,255,255,.6); line-height: 1.7; margin-bottom: 28px; max-width: 540px; }
.hero-metas { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 32px; }
.meta-pill {
  font-size: .75rem; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.25);
  color: #14a8a0; padding: 5px 14px; border-radius: 100px;
}
.hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }

/* ─── VISUAL CARD ─── */
.visual-card {
  background: linear-gradient(145deg, rgba(13,31,58,.9), rgba(8,18,34,.95));
  border: 1px solid rgba(200,169,110,.2); border-radius: 20px;
  padding: 40px 32px; text-align: center; position: relative;
}
.visual-emoji { font-size: 5rem; margin-bottom: 20px; }
.visual-badge {
  display: inline-block; background: rgba(200,169,110,.12); border: 1px solid rgba(200,169,110,.25);
  color: #e8d5a3; font-size: .7rem; padding: 4px 14px; border-radius: 100px; margin-bottom: 20px;
}
.visual-price { margin-bottom: 8px; }
.vp-currency { font-size: 1.4rem; color: #c8a96e; vertical-align: top; margin-top: 6px; display: inline-block; }
.vp-amount { font-family: 'Cormorant Garamond', serif; font-size: 3.8rem; font-weight: 300; color: #c8a96e; line-height: 1; }
.visual-access { font-size: .78rem; color: rgba(255,255,255,.4); }

/* ─── BUTTONS ─── */
.btn-primary {
  background: linear-gradient(135deg, #0d7377, #14a8a0); color: #fff; border: none;
  padding: 14px 28px; border-radius: 6px; font-size: .88rem; font-weight: 500;
  letter-spacing: .04em; cursor: pointer; text-decoration: none; transition: transform .2s, box-shadow .2s;
  box-shadow: 0 6px 24px rgba(13,115,119,.35); display: inline-block; font-family: 'DM Sans', sans-serif;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(13,115,119,.5); }
.btn-outline {
  background: transparent; border: 1px solid rgba(200,169,110,.3); color: #e8d5a3;
  padding: 14px 28px; border-radius: 6px; font-size: .88rem; cursor: pointer;
  text-decoration: none; transition: border-color .2s, background .2s; display: inline-block;
}
.btn-outline:hover { border-color: #c8a96e; background: rgba(200,169,110,.07); }
.btn-listen {
  background: linear-gradient(135deg, #0d7377, #14a8a0); border: none; color: #fff;
  font-size: .85rem; padding: 14px 24px; border-radius: 6px; cursor: pointer;
  transition: all .2s; font-family: 'DM Sans', sans-serif;
  display: inline-flex; align-items: center; gap: 8px;
  box-shadow: 0 4px 16px rgba(13,115,119,.4);
}
.btn-listen:hover { transform: scale(1.04); box-shadow: 0 6px 24px rgba(13,115,119,.6); }
.btn-listen svg { flex-shrink: 0; }

/* ─── DETAIL SECTION ─── */
.detail-section { padding: 80px 48px; background: #0a1628; max-width: 1100px; margin: 0 auto; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; }
.detail-box {
  background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.2);
  border-radius: 12px; padding: 24px;
}
.detail-box-title {
  font-size: .72rem; letter-spacing: .14em; text-transform: uppercase;
  color: #14a8a0; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
}
.detail-box-title span { font-size: 1rem; }
.detail-text { font-size: .87rem; color: rgba(255,255,255,.7); line-height: 1.7; }

/* Protocol steps */
.protocole-steps { display: flex; flex-direction: column; gap: 12px; }
.protocole-step { display: flex; align-items: flex-start; gap: 12px; }
.protocole-dot { width: 8px; height: 8px; border-radius: 50%; background: #14a8a0; flex-shrink: 0; margin-top: 6px; }
.protocole-step p { font-size: .85rem; color: rgba(255,255,255,.75); line-height: 1.5; }
.protocole-step strong { color: #fff; }
.protocole-bar { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 20px; }
.protocole-stat { text-align: center; background: rgba(13,115,119,.12); border: 1px solid rgba(13,115,119,.2); border-radius: 10px; padding: 14px 10px; }
.protocole-stat-val { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: #c8a96e; line-height: 1; display: block; margin-bottom: 4px; }
.protocole-stat-lbl { font-size: .68rem; color: rgba(255,255,255,.45); letter-spacing: .06em; text-transform: uppercase; }

/* Benefits */
.detail-full {
  background: rgba(255,255,255,.03); border: 1px solid rgba(200,169,110,.2);
  border-radius: 12px; padding: 24px; margin-bottom: 32px;
}
.benefits-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.benefit-item { display: flex; align-items: center; gap: 10px; font-size: .87rem; color: rgba(255,255,255,.75); }
.benefit-check { color: #14a8a0; font-weight: 700; flex-shrink: 0; }

/* Tags */
.tags-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 40px; }
.tag-pill {
  background: rgba(200,169,110,.08); border: 1px solid rgba(200,169,110,.15);
  color: rgba(255,255,255,.5); font-size: .75rem; padding: 4px 14px; border-radius: 100px;
}

/* Detail CTA */
.detail-cta {
  display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 24px;
  padding-top: 32px; border-top: 1px solid rgba(200,169,110,.2);
}
.cta-price-display { display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px; }
.cta-price-big { font-family: 'Cormorant Garamond', serif; font-size: 2.4rem; color: #c8a96e; font-weight: 300; }
.cta-price-sub { font-size: .82rem; color: rgba(255,255,255,.35); }
.cta-price-note { font-size: .75rem; color: rgba(255,255,255,.3); }
.cta-actions { display: flex; gap: 12px; flex-wrap: wrap; }

/* ─── RELATED ─── */
.related-section { padding: 100px 48px; background: rgba(255,255,255,.015); border-top: 1px solid rgba(200,169,110,.2); }
.related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; max-width: 1100px; margin: 0 auto; }

/* Program card (same as Shop) */
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
.prog-meta { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
.prog-meta-item { font-size: .7rem; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.2); color: #14a8a0; padding: 3px 10px; border-radius: 100px; }
.prog-footer { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.prog-price { color: #c8a96e; font-size: 1.1rem; font-weight: 500; flex-shrink: 0; }
.prog-actions { display: flex; gap: 8px; }
.prog-details {
  background: transparent; border: 1px solid rgba(255,255,255,.15); color: rgba(255,255,255,.6);
  font-size: .72rem; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: all .2s; font-family: 'DM Sans', sans-serif;
}
.prog-details:hover { border-color: #14a8a0; color: #14a8a0; }
.prog-play {
  background: linear-gradient(135deg, #0d7377, #14a8a0); border: none; color: #fff;
  font-size: .72rem; padding: 6px 13px; border-radius: 6px; cursor: pointer; transition: all .2s;
  font-family: 'DM Sans', sans-serif; display: flex; align-items: center; gap: 5px;
  box-shadow: 0 3px 12px rgba(13,115,119,.4);
}
.prog-play:hover { transform: scale(1.05); box-shadow: 0 5px 18px rgba(13,115,119,.6); }
.prog-play svg { flex-shrink: 0; }
.prog-add {
  background: rgba(13,115,119,.25); border: 1px solid rgba(13,115,119,.4); color: #14a8a0;
  font-size: .72rem; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: all .2s;
  text-decoration: none; display: inline-block; font-family: 'DM Sans', sans-serif;
}
.prog-add:hover { background: rgba(13,115,119,.5); color: #fff; }

/* ─── SHARED SECTION STYLES ─── */
.section-header { margin-bottom: 48px; }
.section-label { font-size: .72rem; letter-spacing: .18em; text-transform: uppercase; color: #14a8a0; margin-bottom: 14px; }
.section-title { font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 300; line-height: 1.2; margin-bottom: 16px; color: #fff; }
.gold-italic { color: #c8a96e; font-style: italic; font-family: 'Cormorant Garamond', serif; }

/* ─── FINAL CTA ─── */
.final-cta {
  text-align: center; padding: 100px 48px;
  background: radial-gradient(ellipse 60% 80% at 50% 50%, rgba(13,115,119,.2) 0%, transparent 70%);
  border-top: 1px solid rgba(200,169,110,.2);
}
.final-cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-top: 40px; }

/* ═══ PLAYER OVERLAY ═══ */
.player-overlay {
  position: fixed; inset: 0; background: rgba(5,12,24,.75); backdrop-filter: blur(14px);
  z-index: 600; display: flex; align-items: flex-end; justify-content: center;
  padding: 24px; opacity: 0; pointer-events: none; transition: opacity .3s;
}
.player-overlay.open { opacity: 1; pointer-events: all; }
.player-card {
  background: linear-gradient(145deg, #0d1f3a, #081222);
  border: 1px solid rgba(200,169,110,.2); border-radius: 24px;
  width: 100%; max-width: 480px; overflow: hidden;
  transform: translateY(40px); transition: transform .35s cubic-bezier(.34,1.56,.64,1);
}
.player-overlay.open .player-card { transform: translateY(0); }
.player-card-top { height: 3px; background: linear-gradient(90deg, #0d7377, #14a8a0, #c8a96e); }
.player-header { padding: 20px 22px 0; display: flex; align-items: flex-start; justify-content: space-between; }
.player-label { font-size: .65rem; letter-spacing: .14em; text-transform: uppercase; color: #14a8a0; margin-bottom: 5px; }
.player-name { font-family: 'Cormorant Garamond', serif; font-size: 1.35rem; font-weight: 300; color: #fff; line-height: 1.2; }
.player-close {
  background: rgba(255,255,255,.07); border: 1px solid rgba(200,169,110,.2);
  color: rgba(255,255,255,.6); width: 32px; height: 32px; border-radius: 50%;
  font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; transition: all .2s;
}
.player-close:hover { background: rgba(255,255,255,.15); color: #fff; }

/* Access badge */
.player-access { display: flex; align-items: center; gap: 10px; margin: 14px 22px 0; padding: 10px 14px; border-radius: 10px; }
.player-access.subscribed { background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.35); }
.pa-icon { font-size: 1.1rem; flex-shrink: 0; }
.pa-badge { font-size: .68rem; letter-spacing: .1em; text-transform: uppercase; font-weight: 500; color: #14a8a0; }
.pa-desc { font-size: .72rem; color: rgba(200,220,255,.5); margin-top: 2px; }

/* Instructions */
.player-instructions { margin: 14px 22px 0; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07); border-radius: 12px; padding: 12px 14px; }
.pi-title { font-size: .63rem; letter-spacing: .14em; text-transform: uppercase; color: rgba(200,220,255,.4); margin-bottom: 10px; }
.pi-items { display: flex; flex-direction: column; gap: 7px; }
.pi-item { display: flex; align-items: center; gap: 10px; font-size: .78rem; color: rgba(200,220,255,.7); }
.pi-dot { width: 22px; height: 22px; border-radius: 6px; background: rgba(13,115,119,.2); border: 1px solid rgba(13,115,119,.25); display: flex; align-items: center; justify-content: center; font-size: .8rem; flex-shrink: 0; }

/* Timer */
.player-timer-wrap { margin: 16px 22px 0; display: flex; align-items: center; gap: 14px; }
.timer-ring { position: relative; width: 52px; height: 52px; flex-shrink: 0; }
.timer-ring svg { position: absolute; inset: 0; transform: rotate(-90deg); }
.timer-ring circle { fill: none; stroke-width: 3; }
.timer-ring .bg { stroke: rgba(255,255,255,.08); }
.timer-ring .fg { stroke: url(#timerGrad); stroke-linecap: round; transition: stroke-dashoffset .5s linear; }
.timer-center { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-family: 'Cormorant Garamond', serif; font-size: .85rem; color: #fff; }
.timer-label { font-size: .68rem; color: rgba(200,220,255,.4); letter-spacing: .08em; text-transform: uppercase; }
.timer-duration { font-size: .9rem; color: rgba(200,220,255,.75); margin-top: 2px; }

/* Waveform */
.player-waveform { height: 40px; margin: 14px 22px 0; display: flex; align-items: center; gap: 2px; }
.wv-bar { width: 3px; border-radius: 2px; background: linear-gradient(180deg, #14a8a0, #0d7377); opacity: .3; transition: opacity .2s; }
.playing .wv-bar { animation: wvAnim var(--d, 0.6s) ease-in-out infinite alternate; }
@keyframes wvAnim { 0% { transform: scaleY(.3); opacity: .3; } 100% { transform: scaleY(1); opacity: .8; } }

/* Controls */
.player-controls { display: flex; align-items: center; justify-content: center; gap: 16px; padding: 16px 22px 10px; }
.pc-btn {
  background: rgba(255,255,255,.05); border: 1px solid rgba(200,169,110,.2);
  color: rgba(255,255,255,.6); width: 40px; height: 40px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center; cursor: pointer;
  font-size: .9rem; transition: all .2s;
}
.pc-btn:hover { background: rgba(255,255,255,.1); color: #fff; }
.pc-play {
  width: 56px; height: 56px; border-radius: 50%;
  background: linear-gradient(135deg, #0d7377, #14a8a0);
  border: none; color: #fff; font-size: 1.3rem;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: all .25s;
  box-shadow: 0 6px 24px rgba(13,115,119,.5);
}
.pc-play:hover { transform: scale(1.08); box-shadow: 0 8px 32px rgba(13,115,119,.7); }
.pc-note { font-size: .65rem; color: rgba(200,220,255,.25); text-align: center; padding: 0 22px 16px; }

/* ─── RESPONSIVE ─── */
@media (max-width: 900px) {
  .detail-hero { padding: 100px 24px 60px; }
  .hero-inner { grid-template-columns: 1fr; gap: 40px; }
  .hero-right { order: -1; }
  .detail-section { padding: 60px 24px; }
  .detail-grid { grid-template-columns: 1fr; }
  .benefits-grid { grid-template-columns: 1fr; }
  .related-section, .final-cta { padding: 72px 24px; }
  .related-grid { grid-template-columns: 1fr; }
  .detail-cta { flex-direction: column; align-items: flex-start; }
  .player-card { max-width: 100%; }
}
</style>
