<template>
  <AppLayout>
    <div class="pro-page">

      <!-- ═══ SIDEBAR ═══ -->
      <aside class="pro-aside">
        <div class="aside-logo">
          <div class="aside-logo-emblem">V</div>
          <div>
            <p class="aside-logo-title">Vitality<em>Inside</em></p>
            <p class="aside-logo-sub">Espace Pro</p>
          </div>
        </div>

        <nav class="aside-nav">
          <span class="aside-section-label">Principal</span>
          <button :class="{ active: tab === 'dashboard' }" @click="tab = 'dashboard'">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-4a1 1 0 00-1 1v3H7a1 1 0 000 2h3v3a1 1 0 002 0v-3h3a1 1 0 000-2h-3V7a1 1 0 00-1-1z" clip-rule="evenodd" fill-rule="evenodd"/></svg>
            Tableau de bord
          </button>
          <button :class="{ active: tab === 'programs' }" @click="tab = 'programs'">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg>
            Mes Programmes
            <span v-if="myPrograms.length" class="aside-count">{{ myPrograms.length }}</span>
          </button>
          <button :class="{ active: tab === 'orders' }" @click="tab = 'orders'">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
            Mes Commandes
            <span v-if="myOrders.length" class="aside-count">{{ myOrders.length }}</span>
          </button>
          <button :class="{ active: tab === 'consultations' }" @click="tab = 'consultations'">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
            Consultations
          </button>
          <button :class="{ active: tab === 'subscription' }" @click="tab = 'subscription'">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            Abonnement
            <span v-if="subscription" class="aside-badge-active">Actif</span>
          </button>

          <span class="aside-section-label" style="margin-top:12px">Compte</span>
          <button :class="{ active: tab === 'profile' }" @click="tab = 'profile'">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
            Mon Profil
          </button>
          <button :class="{ active: tab === 'cart' }" @click="tab = 'cart'">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/><path d="M16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/></svg>
            Panier
            <span v-if="cartCount" class="aside-badge">{{ cartCount }}</span>
          </button>

          <div class="aside-divider"></div>
          <Link :href="route('shop')" class="aside-ext-link">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"/></svg>
            Boutique
          </Link>
          <Link :href="route('consultation')" class="aside-ext-link">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/></svg>
            Consultation
          </Link>
          <Link v-if="user?.is_pro" :href="route('pro.dashboard')" class="aside-ext-link aside-ext-pro">
            <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
            Espace Praticien
          </Link>
        </nav>

        <div style="flex:1"></div>

        <div v-if="user" class="aside-user-box">
          <div class="aside-user-avatar">{{ userInitial }}</div>
          <div class="aside-user-info">
            <p class="aside-user-name">{{ user.name }}</p>
            <p class="aside-user-role">{{ user.is_pro ? 'Praticien PRO' : 'Membre' }}</p>
          </div>
        </div>
        <Link v-if="user" :href="route('logout')" method="post" as="button" class="aside-logout">
          <svg class="aside-svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/></svg>
          Déconnexion
        </Link>
      </aside>

      <!-- ═══ MAIN CONTENT ═══ -->
      <main class="pro-main">

        <!-- TOP BAR -->
        <header class="pro-topbar">
          <div class="topbar-left">
            <h2 class="topbar-title">{{ tabTitles[tab] }}</h2>
            <div class="topbar-breadcrumb">
              <span>Vitality Inside</span>
              <span class="bc-sep">›</span>
              <span class="bc-active">{{ tabTitles[tab] }}</span>
            </div>
          </div>
          <div class="topbar-right">
            <Link :href="route('home')" class="topbar-link">← Retour au site</Link>
            <Link :href="route('shop')" class="topbar-btn-cyan">Boutique</Link>
          </div>
        </header>

        <!-- Flash -->
        <div v-if="$page.props.flash?.success" class="flash-success">
          <svg viewBox="0 0 20 20" fill="currentColor" class="flash-icon"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
          {{ $page.props.flash.success }}
        </div>

        <!-- ══ NOT AUTH ══ -->
        <div v-if="!user" class="unauth-wrap">
          <div class="unauth-card">
            <div class="unauth-emblem">VI</div>
            <h2 class="unauth-title">Vitality Inside <em>Pro</em></h2>
            <p class="unauth-sub">Connectez-vous pour accéder à votre espace personnel — programmes, commandes, consultations et abonnement.</p>
            <form @submit.prevent="submitLogin" class="unauth-form">
              <div v-if="loginForm.errors.email" class="field-error">{{ loginForm.errors.email }}</div>
              <div class="field-group">
                <label>Adresse email</label>
                <input v-model="loginForm.email" type="email" required placeholder="vous@exemple.com" autocomplete="email" />
              </div>
              <div class="field-group">
                <label>Mot de passe</label>
                <input v-model="loginForm.password" type="password" required placeholder="••••••••" autocomplete="current-password" />
              </div>
              <button type="submit" class="unauth-btn" :disabled="loginForm.processing">
                {{ loginForm.processing ? 'Connexion…' : 'Se connecter' }}
              </button>
            </form>
            <div class="unauth-links">
              <Link :href="route('password.request')" class="unauth-link">Mot de passe oublié ?</Link>
              <span class="sep">·</span>
              <Link :href="route('register')" class="unauth-link">Créer un compte</Link>
            </div>
          </div>
          <!-- Feature previews -->
          <div class="unauth-features">
            <div v-for="f in proFeatures" :key="f.title" class="uf-card">
              <span class="uf-icon">{{ f.icon }}</span>
              <div><p class="uf-title">{{ f.title }}</p><p class="uf-desc">{{ f.desc }}</p></div>
            </div>
          </div>
        </div>

        <!-- ══ DASHBOARD ══ -->
        <div v-else-if="tab === 'dashboard'" class="tab-content">
          <div class="welcome-row">
            <div>
              <h1 class="welcome-h1">Bonjour, <em class="gold-em">{{ firstName }}</em> 👋</h1>
              <p class="welcome-p">{{ fmtDate(new Date()) }} · Vitality Inside Pro</p>
            </div>
            <Link :href="route('shop')" class="btn-teal">Explorer les programmes →</Link>
          </div>

          <div class="kpi-row">
            <div class="kpi-card" @click="tab='programs'" style="cursor:pointer">
              <div class="kpi-icon" style="background:rgba(20,168,160,.15);color:#14a8a0">
                <svg viewBox="0 0 20 20" fill="currentColor"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg>
              </div>
              <div><p class="kpi-val">{{ myPrograms.length }}</p><p class="kpi-lbl">Programmes</p></div>
            </div>
            <div class="kpi-card" @click="tab='orders'" style="cursor:pointer">
              <div class="kpi-icon" style="background:rgba(200,169,110,.12);color:#c8a96e">
                <svg viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
              </div>
              <div><p class="kpi-val">{{ myOrders.length }}</p><p class="kpi-lbl">Commandes</p></div>
            </div>
            <div class="kpi-card" @click="tab='consultations'" style="cursor:pointer">
              <div class="kpi-icon" style="background:rgba(125,211,252,.1);color:#7dd3fc">
                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
              </div>
              <div><p class="kpi-val">{{ myConsultations.length }}</p><p class="kpi-lbl">Consultations</p></div>
            </div>
            <div class="kpi-card" :class="{ 'kpi-card--active': subscription }" @click="tab='subscription'" style="cursor:pointer">
              <div class="kpi-icon" :style="subscription ? 'background:rgba(134,239,172,.1);color:#86efac' : 'background:rgba(255,255,255,.05);color:rgba(255,255,255,.3)'">
                <svg viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              </div>
              <div>
                <p class="kpi-val">{{ subscription ? subscription.type === 'monthly' ? 'Mensuel' : 'Annuel' : '—' }}</p>
                <p class="kpi-lbl">Abonnement</p>
              </div>
            </div>
          </div>

          <!-- Recent items grid -->
          <div class="dash-grid">
            <!-- Recent programs -->
            <div class="dash-panel">
              <div class="panel-head">
                <h3 class="panel-title">Mes derniers programmes</h3>
                <button class="panel-link" @click="tab='programs'">Voir tout →</button>
              </div>
              <div v-if="myPrograms.length" class="prog-list">
                <div v-for="up in myPrograms.slice(0,4)" :key="up.id" class="prog-item">
                  <div class="prog-emoji">{{ up.program?.emoji || '🎧' }}</div>
                  <div class="prog-info">
                    <p class="prog-name">{{ up.program?.title }}</p>
                    <p class="prog-meta">{{ up.program?.category?.name || 'Programme' }} · {{ up.program?.session_duration || '30 min' }}</p>
                  </div>
                  <a v-if="up.access_link" :href="up.access_link" class="prog-play-btn">▶</a>
                </div>
              </div>
              <div v-else class="panel-empty">
                <p>Aucun programme acheté.</p>
                <Link :href="route('shop')" class="panel-cta">Explorer la boutique →</Link>
              </div>
            </div>

            <!-- Recent orders -->
            <div class="dash-panel">
              <div class="panel-head">
                <h3 class="panel-title">Commandes récentes</h3>
                <button class="panel-link" @click="tab='orders'">Voir tout →</button>
              </div>
              <div v-if="myOrders.length">
                <div v-for="o in myOrders.slice(0,4)" :key="o.id" class="order-item-sm">
                  <div class="ois-left">
                    <p class="ois-num">{{ o.order_number }}</p>
                    <p class="ois-date">{{ fmtDate(o.created_at) }}</p>
                  </div>
                  <div class="ois-right">
                    <span class="ois-status" :class="o.status === 'completed' ? 'ok' : 'pending'">
                      {{ o.status === 'completed' ? 'Complétée' : 'En cours' }}
                    </span>
                    <span class="ois-total">€{{ o.total }}</span>
                  </div>
                </div>
              </div>
              <div v-else class="panel-empty">
                <p>Aucune commande.</p>
                <Link :href="route('shop')" class="panel-cta">Découvrir les programmes →</Link>
              </div>
            </div>
          </div>

          <!-- Subscription CTA if no sub -->
          <div v-if="!subscription" class="sub-cta-banner">
            <div class="scb-left">
              <p class="scb-label">Abonnement Premium</p>
              <h3 class="scb-title">Accès illimité à 37+ protocoles</h3>
              <p class="scb-sub">À partir de €29/mois · Sans engagement · Annulation en un clic</p>
            </div>
            <Link :href="route('subscribe')" class="scb-btn">S'abonner maintenant →</Link>
          </div>
        </div>

        <!-- ══ PROGRAMS ══ -->
        <div v-else-if="tab === 'programs'" class="tab-content">
          <div class="tab-header">
            <h2 class="tab-h2">Mes Programmes</h2>
            <Link :href="route('shop')" class="btn-teal-sm">+ Ajouter un programme</Link>
          </div>
          <div v-if="myPrograms.length" class="progs-grid">
            <div v-for="up in myPrograms" :key="up.id" class="prog-card">
              <div class="pc-top">
                <div class="pc-emoji">{{ up.program?.emoji || '🎧' }}</div>
                <div class="pc-category">{{ up.program?.category?.name || 'Programme' }}</div>
              </div>
              <h4 class="pc-title">{{ up.program?.title }}</h4>
              <div class="pc-metas">
                <span>⏱ {{ up.program?.session_duration || '30 min' }}</span>
                <span>🔄 {{ up.program?.cure_duration || '21 jours' }}</span>
              </div>
              <a v-if="up.access_link" :href="up.access_link" class="pc-btn">🎧 Écouter</a>
              <button v-else class="pc-btn pc-btn--muted">🎧 Écouter</button>
            </div>
          </div>
          <div v-else class="empty-box">
            <div class="empty-icon">🎧</div>
            <h3>Aucun programme pour l'instant</h3>
            <p>Parcourez notre catalogue de 37+ protocoles audio et commencez votre cure.</p>
            <Link :href="route('shop')" class="btn-teal">Explorer la boutique</Link>
          </div>
        </div>

        <!-- ══ ORDERS ══ -->
        <div v-else-if="tab === 'orders'" class="tab-content">
          <div class="tab-header">
            <h2 class="tab-h2">Mes Commandes</h2>
          </div>
          <div v-if="myOrders.length" class="orders-table-wrap">
            <table class="orders-table">
              <thead><tr><th>Commande</th><th>Date</th><th>Programmes</th><th>Total</th><th>Statut</th></tr></thead>
              <tbody>
                <tr v-for="o in myOrders" :key="o.id">
                  <td class="ord-num">{{ o.order_number }}</td>
                  <td class="ord-muted">{{ fmtDate(o.created_at) }}</td>
                  <td class="ord-muted">{{ o.items?.map(i => i.program_title || i.program?.title).join(', ') || '—' }}</td>
                  <td class="ord-price">€{{ o.total }}</td>
                  <td><span class="ord-badge" :class="o.status === 'completed' ? 'ok' : 'pending'">{{ o.status === 'completed' ? 'Complétée' : 'En cours' }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else class="empty-box">
            <div class="empty-icon">📦</div>
            <h3>Aucune commande</h3>
            <p>Vous n'avez pas encore passé de commande.</p>
            <Link :href="route('shop')" class="btn-teal">Découvrir les programmes</Link>
          </div>
        </div>

        <!-- ══ CONSULTATIONS ══ -->
        <div v-else-if="tab === 'consultations'" class="tab-content">
          <div class="tab-header">
            <h2 class="tab-h2">Consultations</h2>
            <Link :href="route('consultation')" class="btn-teal-sm">+ Réserver</Link>
          </div>
          <div v-if="myConsultations.length" class="consult-list">
            <div v-for="c in myConsultations" :key="c.id" class="consult-card">
              <div class="cc-head">
                <div class="cc-avatar">Dr</div>
                <div>
                  <p class="cc-title">Consultation Dr. Éric Rosati · #{{ c.id }}</p>
                  <p class="cc-date">{{ fmtDate(c.created_at) }}</p>
                </div>
                <span class="cc-status" :class="c.status === 'delivered' ? 'ok' : c.status === 'in_progress' ? 'active' : 'pending'">
                  {{ c.status === 'delivered' ? 'Livré' : c.status === 'in_progress' ? 'En cours' : 'En attente' }}
                </span>
              </div>
              <div class="cc-body">
                <div class="cc-meta"><span>Formule</span><strong>{{ c.package_type === 'single' ? 'Essentiel' : c.package_type === 'progress' ? 'Évolution' : 'Transformation' }}</strong></div>
                <div class="cc-meta"><span>Séances</span><strong>{{ c.sessions_count ?? 1 }}</strong></div>
                <div class="cc-meta"><span>Montant</span><strong>€{{ c.amount }}</strong></div>
              </div>
              <div v-if="c.protocol_notes" class="cc-notes">
                <p class="cc-notes-label">Notes du Dr. Rosati :</p>
                <p class="cc-notes-text">{{ c.protocol_notes }}</p>
              </div>
            </div>
          </div>
          <div v-else class="empty-box">
            <div class="empty-icon">🩺</div>
            <h3>Aucune consultation</h3>
            <p>Réservez une consultation personnalisée avec le Dr. Éric Rosati pour un protocole sur mesure.</p>
            <Link :href="route('consultation')" class="btn-teal">Réserver — €58</Link>
          </div>
        </div>

        <!-- ══ SUBSCRIPTION ══ -->
        <div v-else-if="tab === 'subscription'" class="tab-content">
          <div class="tab-header">
            <h2 class="tab-h2">Mon Abonnement</h2>
          </div>
          <!-- Active -->
          <div v-if="subscription" class="sub-active-card">
            <div class="sac-badge">✓ Abonnement actif</div>
            <div class="sac-body">
              <div class="sac-info">
                <p class="sac-type">Plan {{ subscription.type === 'monthly' ? 'Mensuel' : 'Annuel' }}</p>
                <p class="sac-price">€{{ subscription.price }}<span>/{{ subscription.type === 'monthly' ? 'mois' : 'an' }}</span></p>
              </div>
              <div class="sac-dates">
                <div class="sac-date-item"><span>Début</span><strong>{{ fmtDate(subscription.starts_at) }}</strong></div>
                <div class="sac-date-item"><span>Expire</span><strong>{{ fmtDate(subscription.ends_at) }}</strong></div>
              </div>
            </div>
            <div class="sac-perks">
              <div class="sac-perk"><span>✓</span> Accès illimité à 37+ protocoles audio</div>
              <div class="sac-perk"><span>✓</span> Nouveaux programmes chaque mois</div>
              <div class="sac-perk"><span>✓</span> Support prioritaire</div>
              <div class="sac-perk"><span>✓</span> Téléchargement offline</div>
            </div>
            <form @submit.prevent="cancelSubForm.post(route('subscribe.cancel'))" class="sac-cancel">
              <button type="submit" class="sac-cancel-btn" :disabled="cancelSubForm.processing">
                {{ cancelSubForm.processing ? 'Annulation…' : 'Annuler l\'abonnement' }}
              </button>
            </form>
          </div>
          <!-- No sub -->
          <div v-else class="sub-upsell">
            <div class="supsell-hero">
              <p class="supsell-label">Premium</p>
              <h3 class="supsell-title">Passez à l'abonnement <em>illimité</em></h3>
              <p class="supsell-sub">Accédez à l'intégralité de notre bibliothèque de 37+ protocoles audio thérapeutiques, conçus par le Dr. Éric Rosati.</p>
            </div>
            <div class="supsell-plans">
              <div class="sp-card">
                <p class="sp-name">Mensuel</p>
                <p class="sp-price">€29 <span>/mois</span></p>
                <Link :href="route('subscribe')" class="sp-btn">Choisir</Link>
              </div>
              <div class="sp-card sp-card--featured">
                <div class="sp-featured-badge">Meilleur choix</div>
                <p class="sp-name">Annuel</p>
                <p class="sp-price">€199 <span>/an</span></p>
                <p class="sp-save">Économisez 40%</p>
                <Link :href="route('subscribe')" class="sp-btn sp-btn--gold">Choisir</Link>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ PROFILE ══ -->
        <div v-else-if="tab === 'profile'" class="tab-content">
          <div class="tab-header">
            <h2 class="tab-h2">Mon Profil</h2>
          </div>
          <div class="profile-layout">
            <div class="profile-left">
              <div class="profile-avatar-xl">{{ userInitial }}</div>
              <p class="profile-name">{{ user?.name }}</p>
              <p class="profile-email">{{ user?.email }}</p>
              <span class="profile-role-badge">{{ user?.is_pro ? '★ Praticien PRO' : 'Membre' }}</span>
              <p class="profile-since">Membre depuis<br><strong>{{ fmtMonthYear(user?.created_at) }}</strong></p>
            </div>
            <div class="profile-right">
              <div class="profile-section">
                <h3 class="ps-title">Informations personnelles</h3>
                <form @submit.prevent="submitProfile" class="pform">
                  <div class="pform-row">
                    <div class="pform-group">
                      <label>Nom complet</label>
                      <input v-model="profileForm.name" type="text" required />
                    </div>
                    <div class="pform-group">
                      <label>Email</label>
                      <input :value="user?.email" type="email" disabled class="pf-disabled" />
                    </div>
                  </div>
                  <div class="pform-group">
                    <label>Téléphone</label>
                    <input v-model="profileForm.phone" type="tel" placeholder="+33 6 00 00 00 00" />
                  </div>
                  <button type="submit" class="btn-teal" :disabled="profileForm.processing">
                    {{ profileForm.processing ? 'Sauvegarde…' : 'Sauvegarder' }}
                  </button>
                </form>
              </div>
              <div class="profile-section profile-security">
                <h3 class="ps-title">Sécurité & Confidentialité</h3>
                <div class="sec-grid">
                  <div class="sec-item"><div class="sec-icon">🔒</div><div><p class="sec-t">AES-256</p><p class="sec-s">Données chiffrées</p></div></div>
                  <div class="sec-item"><div class="sec-icon">🇪🇺</div><div><p class="sec-t">RGPD</p><p class="sec-s">Données en Europe</p></div></div>
                  <div class="sec-item"><div class="sec-icon">💳</div><div><p class="sec-t">Stripe / PayPal</p><p class="sec-s">Paiements sécurisés</p></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ══ CART ══ -->
        <div v-else-if="tab === 'cart'" class="tab-content">
          <div class="tab-header">
            <h2 class="tab-h2">Mon Panier</h2>
          </div>
          <div v-if="cartItems.length" class="cart-layout">
            <div class="cart-items-col">
              <div v-for="item in cartItems" :key="item.program.id" class="cart-row">
                <div class="cr-emoji">{{ item.program.emoji || '🎧' }}</div>
                <div class="cr-info">
                  <p class="cr-name">{{ item.program.title }}</p>
                  <p class="cr-meta">{{ item.program.session_duration }} · {{ item.program.cure_duration }}</p>
                </div>
                <p class="cr-price">€{{ item.program.price }}</p>
                <Link :href="route('cart.remove')" method="post" as="button" :data="{ program_id: item.program.id }" class="cr-remove">✕</Link>
              </div>
            </div>
            <div class="cart-summary-col">
              <h4 class="cs-title">Récapitulatif</h4>
              <div class="cs-row"><span>Sous-total</span><span>€{{ cartTotal }}</span></div>
              <div class="cs-row cs-row--free"><span>Livraison</span><span class="cs-free">Gratuite</span></div>
              <div class="cs-row cs-row--total"><span>Total</span><span class="cs-big">€{{ cartTotal }}</span></div>
              <Link :href="route('checkout')" class="btn-teal cs-checkout">Passer à la caisse</Link>
              <Link :href="route('shop')" class="btn-outline-sm cs-more">Continuer les achats</Link>
            </div>
          </div>
          <div v-else class="empty-box">
            <div class="empty-icon">🛒</div>
            <h3>Panier vide</h3>
            <p>Explorez nos programmes de bio-résonance thérapeutique.</p>
            <Link :href="route('shop')" class="btn-teal">Découvrir les programmes</Link>
          </div>
        </div>

      </main>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth?.user)
const userInitial = computed(() => user.value?.name?.charAt(0).toUpperCase() || '?')
const firstName = computed(() => user.value?.name?.split(' ')[0] || 'Utilisateur')

const tab = ref('dashboard')

const tabTitles = {
  dashboard:     'Tableau de bord',
  programs:      'Mes Programmes',
  orders:        'Mes Commandes',
  consultations: 'Consultations',
  subscription:  'Mon Abonnement',
  profile:       'Mon Profil',
  cart:          'Mon Panier',
}

const props = defineProps({
  programs:      { type: Array,          default: () => [] },
  orders:        { type: Array,          default: () => [] },
  consultations: { type: Array,          default: () => [] },
  subscription:  { type: Object,         default: null },
  cartItems:     { type: Array,          default: () => [] },
  cartTotal:     { type: [Number,String], default: 0 },
})

const myPrograms      = computed(() => props.programs || [])
const myOrders        = computed(() => props.orders || [])
const myConsultations = computed(() => props.consultations || [])
const cartItems       = computed(() => props.cartItems || [])
const cartTotal       = computed(() => props.cartTotal || 0)
const cartCount       = computed(() => cartItems.value.length)
const subscription    = computed(() => props.subscription)

const loginForm  = useForm({ email: '', password: '', remember: false })
const submitLogin = () => loginForm.post(route('login'))

const profileForm  = useForm({ name: user.value?.name || '', phone: user.value?.phone || '' })
const submitProfile = () => profileForm.put(route('dashboard.profile.update'))

const cancelSubForm = useForm({})

function fmtDate(d) {
  if (!d) return '—'
  return new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' })
}
function fmtMonthYear(d) {
  if (!d) return '—'
  return new Date(d).toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })
}

const proFeatures = [
  { icon: '🎧', title: '37+ Protocoles audio', desc: 'Programmes de bio-résonance thérapeutique pour chaque pathologie.' },
  { icon: '📦', title: 'Accès immédiat', desc: 'Vos programmes disponibles instantanément après commande.' },
  { icon: '🩺', title: 'Consultations', desc: 'Protocole personnalisé par le Dr. Éric Rosati.' },
  { icon: '⭐', title: 'Abonnement illimité', desc: 'Accédez à toute la bibliothèque pour €29/mois.' },
]
</script>

<style scoped>
/* ══ LAYOUT ══ */
.pro-page { display:flex; min-height:100vh; background:#07111f; }

/* ══ SIDEBAR ══ */
.pro-aside {
  width: 248px; flex-shrink: 0;
  background: #0c1a2e;
  border-right: 1px solid rgba(200,169,110,.1);
  display: flex; flex-direction: column;
  position: fixed; top: 0; left: 0; bottom: 0;
  z-index: 200; overflow-y: auto;
}

/* ── Sidebar inner ── */
.aside-logo { display:flex; align-items:center; gap:12px; padding:22px 18px 18px; border-bottom:1px solid rgba(200,169,110,.08); }
.aside-logo-emblem { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,#c8a96e,#e8d5a3); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:700; color:#0a1628; flex-shrink:0; }
.aside-logo-title { font-family:'Cormorant Garamond',serif; font-size:.95rem; font-weight:600; color:#fff; line-height:1.2; }
.aside-logo-title em { color:#c8a96e; font-style:normal; }
.aside-logo-sub { font-size:.65rem; color:rgba(200,220,255,.3); margin-top:2px; }

.aside-nav { display:flex; flex-direction:column; gap:1px; padding:10px 10px 4px; flex:1; }
.aside-section-label { font-size:.6rem; font-weight:700; letter-spacing:.18em; text-transform:uppercase; color:rgba(200,220,255,.22); padding:10px 8px 6px; display:block; }

.aside-nav button, .aside-ext-link {
  display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:9px;
  font-size:.8rem; font-weight:500; color:rgba(200,220,255,.48); background:none;
  border:none; cursor:pointer; transition:all .16s; width:100%; text-align:left; text-decoration:none; position:relative;
}
.aside-nav button:hover, .aside-ext-link:hover { background:rgba(255,255,255,.05); color:rgba(200,220,255,.85); }
.aside-nav button.active { background:rgba(200,169,110,.1); color:#c8a96e; }
.aside-ext-pro { color:rgba(20,168,160,.7) !important; }
.aside-ext-pro:hover { color:#14a8a0 !important; }

.aside-svg { width:15px; height:15px; flex-shrink:0; opacity:.7; }
.aside-nav button.active .aside-svg { opacity:1; }

.aside-count { margin-left:auto; background:rgba(20,168,160,.25); color:#14a8a0; font-size:.6rem; padding:2px 7px; border-radius:100px; font-weight:700; }
.aside-badge { margin-left:auto; background:#14a8a0; color:#fff; font-size:.6rem; padding:2px 7px; border-radius:100px; font-weight:700; }
.aside-badge-active { margin-left:auto; background:rgba(134,239,172,.2); color:#86efac; font-size:.6rem; padding:2px 7px; border-radius:100px; font-weight:700; }
.aside-divider { height:1px; background:rgba(255,255,255,.05); margin:8px 10px; }

.aside-user-box { display:flex; align-items:center; gap:10px; padding:14px 14px 8px; border-top:1px solid rgba(255,255,255,.05); }
.aside-user-avatar { width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg,#0d7377,#14a8a0); display:flex; align-items:center; justify-content:center; font-size:.85rem; font-weight:700; color:#fff; flex-shrink:0; }
.aside-user-info { min-width:0; }
.aside-user-name { font-size:.8rem; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.aside-user-role { font-size:.65rem; color:rgba(200,220,255,.3); margin-top:1px; }

.aside-logout { display:flex; align-items:center; gap:8px; padding:8px 14px 16px; font-size:.72rem; color:rgba(200,220,255,.24); background:none; border:none; cursor:pointer; text-decoration:none; transition:color .2s; width:100%; }
.aside-logout:hover { color:#ef4444; }

/* ══ MAIN ══ */
.pro-main { flex:1; margin-left:248px; display:flex; flex-direction:column; min-height:100vh; background:#07111f; }

/* ── Topbar ── */
.pro-topbar { display:flex; align-items:center; justify-content:space-between; padding:14px 28px; background:rgba(12,26,46,.85); border-bottom:1px solid rgba(255,255,255,.05); backdrop-filter:blur(12px); position:sticky; top:0; z-index:50; }
.topbar-left { min-width:0; }
.topbar-title { font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:300; color:#fff; line-height:1.2; }
.topbar-breadcrumb { display:flex; align-items:center; gap:6px; font-size:.72rem; color:rgba(200,220,255,.3); margin-top:2px; }
.bc-sep { opacity:.5; }
.bc-active { color:rgba(200,220,255,.6); }
.topbar-right { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.topbar-link { font-size:.75rem; color:rgba(200,220,255,.35); text-decoration:none; transition:color .2s; }
.topbar-link:hover { color:rgba(200,220,255,.7); }
.topbar-btn-cyan { display:inline-flex; align-items:center; padding:7px 14px; border-radius:8px; font-size:.75rem; font-weight:600; background:rgba(13,115,119,.18); border:1px solid rgba(20,168,160,.25); color:#14a8a0; text-decoration:none; transition:all .2s; }
.topbar-btn-cyan:hover { background:rgba(13,115,119,.32); }

/* ── Flash ── */
.flash-success { display:flex; align-items:center; gap:10px; margin:16px 28px 0; padding:12px 16px; background:rgba(20,168,160,.12); border:1px solid rgba(20,168,160,.25); border-radius:10px; font-size:.85rem; color:#14a8a0; }
.flash-icon { width:16px; height:16px; flex-shrink:0; }

/* ── Tab content ── */
.tab-content { flex:1; padding:28px; max-width:1100px; width:100%; }

/* ══ UNAUTHENTICATED ══ */
.unauth-wrap { display:flex; flex-direction:column; align-items:center; gap:32px; padding:60px 28px; }
.unauth-card { background:rgba(12,26,46,.95); border:1px solid rgba(200,169,110,.18); border-radius:20px; padding:40px; width:100%; max-width:420px; }
.unauth-emblem { width:52px; height:52px; border-radius:14px; background:linear-gradient(135deg,#c8a96e,#e8d5a3); display:flex; align-items:center; justify-content:center; font-family:'Cormorant Garamond',serif; font-size:1.3rem; font-weight:700; color:#0a1628; margin:0 auto 16px; }
.unauth-title { font-family:'Cormorant Garamond',serif; font-size:1.8rem; font-weight:300; color:#fff; text-align:center; margin-bottom:8px; }
.unauth-title em { color:#c8a96e; font-style:italic; }
.unauth-sub { font-size:.85rem; color:rgba(200,220,255,.45); text-align:center; line-height:1.6; margin-bottom:28px; }
.unauth-form { display:flex; flex-direction:column; gap:16px; }
.field-error { background:rgba(239,68,68,.12); border:1px solid rgba(239,68,68,.25); color:#f87171; border-radius:8px; padding:10px 14px; font-size:.82rem; }
.field-group { display:flex; flex-direction:column; gap:6px; }
.field-group label { font-size:.72rem; font-weight:600; color:rgba(200,220,255,.4); letter-spacing:.05em; }
.field-group input { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:9px; padding:11px 14px; color:#fff; font-size:.875rem; outline:none; transition:border-color .2s; }
.field-group input:focus { border-color:rgba(200,169,110,.4); }
.unauth-btn { padding:13px 24px; border-radius:9px; font-size:.875rem; font-weight:600; background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; border:none; cursor:pointer; transition:all .2s; }
.unauth-btn:hover:not(:disabled) { transform:translateY(-1px); box-shadow:0 8px 24px rgba(13,115,119,.4); }
.unauth-btn:disabled { opacity:.5; cursor:not-allowed; }
.unauth-links { display:flex; justify-content:center; align-items:center; gap:8px; margin-top:16px; font-size:.78rem; }
.unauth-link { color:rgba(200,220,255,.4); text-decoration:none; transition:color .2s; }
.unauth-link:hover { color:#14a8a0; }
.sep { color:rgba(200,220,255,.2); }

.unauth-features { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; max-width:560px; width:100%; }
.uf-card { display:flex; align-items:flex-start; gap:12px; background:rgba(12,26,46,.6); border:1px solid rgba(255,255,255,.06); border-radius:12px; padding:16px; }
.uf-icon { font-size:1.4rem; flex-shrink:0; }
.uf-title { font-size:.82rem; font-weight:600; color:#fff; margin-bottom:3px; }
.uf-desc { font-size:.74rem; color:rgba(200,220,255,.4); line-height:1.5; }

/* ══ DASHBOARD ══ */
.welcome-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px; }
.welcome-h1 { font-family:'Cormorant Garamond',serif; font-size:2.2rem; font-weight:300; color:#fff; line-height:1.15; }
.gold-em { color:#c8a96e; font-style:italic; }
.welcome-p { font-size:.82rem; color:rgba(200,220,255,.4); margin-top:4px; }

.kpi-row { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px; }
.kpi-card { display:flex; align-items:center; gap:14px; background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:18px 20px; transition:all .2s; }
.kpi-card:hover { border-color:rgba(200,169,110,.15); }
.kpi-card--active { border-color:rgba(134,239,172,.2); }
.kpi-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.kpi-icon svg { width:18px; height:18px; }
.kpi-val { font-family:'Cormorant Garamond',serif; font-size:1.6rem; font-weight:400; color:#fff; line-height:1; }
.kpi-lbl { font-size:.68rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.35); margin-top:3px; }

.dash-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }
.dash-panel { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:20px 22px; }
.panel-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
.panel-title { font-size:.9rem; font-weight:600; color:#fff; }
.panel-link { font-size:.75rem; color:#14a8a0; background:none; border:none; cursor:pointer; padding:0; }
.panel-link:hover { text-decoration:underline; }
.panel-empty { text-align:center; padding:24px; }
.panel-empty p { font-size:.82rem; color:rgba(200,220,255,.35); margin-bottom:10px; }
.panel-cta { font-size:.78rem; color:#14a8a0; text-decoration:none; }
.panel-cta:hover { text-decoration:underline; }

.prog-list { display:flex; flex-direction:column; gap:10px; }
.prog-item { display:flex; align-items:center; gap:12px; padding:10px 12px; background:rgba(255,255,255,.03); border-radius:9px; }
.prog-emoji { font-size:1.2rem; flex-shrink:0; }
.prog-info { flex:1; min-width:0; }
.prog-name { font-size:.82rem; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.prog-meta { font-size:.7rem; color:rgba(200,220,255,.38); margin-top:2px; }
.prog-play-btn { width:28px; height:28px; border-radius:50%; background:rgba(20,168,160,.18); color:#14a8a0; display:flex; align-items:center; justify-content:center; font-size:.7rem; text-decoration:none; flex-shrink:0; transition:all .2s; }
.prog-play-btn:hover { background:rgba(20,168,160,.35); }

.order-item-sm { display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,.04); }
.order-item-sm:last-child { border-bottom:none; }
.ois-left { min-width:0; }
.ois-num { font-size:.82rem; font-weight:600; color:#fff; }
.ois-date { font-size:.7rem; color:rgba(200,220,255,.35); margin-top:2px; }
.ois-right { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.ois-status { font-size:.65rem; font-weight:700; padding:3px 9px; border-radius:100px; text-transform:uppercase; letter-spacing:.06em; }
.ois-status.ok { background:rgba(20,168,160,.15); border:1px solid rgba(20,168,160,.25); color:#14a8a0; }
.ois-status.pending { background:rgba(251,191,36,.12); border:1px solid rgba(251,191,36,.25); color:#fbbf24; }
.ois-total { font-size:.85rem; font-weight:600; color:#c8a96e; }

.sub-cta-banner { display:flex; align-items:center; justify-content:space-between; gap:20px; padding:24px 28px; background:linear-gradient(135deg,rgba(200,169,110,.08),rgba(200,169,110,.04)); border:1px solid rgba(200,169,110,.2); border-radius:16px; flex-wrap:wrap; }
.scb-label { font-size:.68rem; text-transform:uppercase; letter-spacing:.12em; color:#c8a96e; margin-bottom:4px; }
.scb-title { font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:400; color:#fff; margin-bottom:4px; }
.scb-sub { font-size:.8rem; color:rgba(200,220,255,.4); }
.scb-btn { display:inline-flex; padding:11px 22px; border-radius:9px; font-size:.82rem; font-weight:600; background:linear-gradient(135deg,#c8a96e,#e8d5a3); color:#0a1628; text-decoration:none; white-space:nowrap; flex-shrink:0; transition:all .2s; }
.scb-btn:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(200,169,110,.3); }

/* ══ TAB HEADER ══ */
.tab-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
.tab-h2 { font-family:'Cormorant Garamond',serif; font-size:1.7rem; font-weight:300; color:#fff; }

/* ══ PROGRAMS ══ */
.progs-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:18px; }
.prog-card { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:22px; transition:all .22s; }
.prog-card:hover { border-color:rgba(200,169,110,.2); transform:translateY(-2px); }
.pc-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
.pc-emoji { font-size:2rem; }
.pc-category { font-size:.68rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.35); }
.pc-title { font-size:.95rem; font-weight:600; color:#fff; margin-bottom:12px; line-height:1.3; }
.pc-metas { display:flex; gap:12px; font-size:.73rem; color:rgba(200,220,255,.45); margin-bottom:16px; }
.pc-btn { display:block; text-align:center; padding:9px 16px; border-radius:8px; font-size:.8rem; font-weight:600; background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; text-decoration:none; border:none; cursor:pointer; transition:all .2s; }
.pc-btn:hover { opacity:.85; }
.pc-btn--muted { background:rgba(255,255,255,.06); color:rgba(200,220,255,.5); }

/* ══ ORDERS TABLE ══ */
.orders-table-wrap { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; overflow:hidden; }
.orders-table { width:100%; border-collapse:collapse; font-size:.82rem; }
.orders-table thead tr { border-bottom:1px solid rgba(255,255,255,.06); }
.orders-table th { padding:13px 16px; text-align:left; font-size:.65rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.35); font-weight:600; }
.orders-table tbody tr { border-bottom:1px solid rgba(255,255,255,.04); transition:background .16s; }
.orders-table tbody tr:last-child { border-bottom:none; }
.orders-table tbody tr:hover { background:rgba(255,255,255,.02); }
.orders-table td { padding:12px 16px; }
.ord-num { color:#fff; font-weight:600; font-size:.85rem; }
.ord-muted { color:rgba(200,220,255,.45); max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ord-price { color:#c8a96e; font-weight:600; }
.ord-badge { font-size:.65rem; font-weight:700; padding:3px 9px; border-radius:100px; text-transform:uppercase; letter-spacing:.06em; }
.ord-badge.ok { background:rgba(20,168,160,.15); border:1px solid rgba(20,168,160,.25); color:#14a8a0; }
.ord-badge.pending { background:rgba(251,191,36,.12); border:1px solid rgba(251,191,36,.25); color:#fbbf24; }

/* ══ CONSULTATIONS ══ */
.consult-list { display:flex; flex-direction:column; gap:16px; }
.consult-card { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:20px 22px; }
.cc-head { display:flex; align-items:center; gap:14px; margin-bottom:16px; flex-wrap:wrap; }
.cc-avatar { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#2e1545,#7c3aed); display:flex; align-items:center; justify-content:center; font-size:.7rem; font-weight:700; color:#fff; flex-shrink:0; }
.cc-title { font-size:.88rem; font-weight:600; color:#fff; }
.cc-date { font-size:.72rem; color:rgba(200,220,255,.35); margin-top:2px; }
.cc-status { margin-left:auto; font-size:.65rem; font-weight:700; padding:4px 10px; border-radius:100px; text-transform:uppercase; letter-spacing:.06em; flex-shrink:0; }
.cc-status.ok { background:rgba(20,168,160,.15); border:1px solid rgba(20,168,160,.25); color:#14a8a0; }
.cc-status.active { background:rgba(99,102,241,.15); border:1px solid rgba(99,102,241,.25); color:#818cf8; }
.cc-status.pending { background:rgba(251,191,36,.12); border:1px solid rgba(251,191,36,.25); color:#fbbf24; }
.cc-body { display:flex; gap:24px; flex-wrap:wrap; padding:12px 14px; background:rgba(255,255,255,.03); border-radius:8px; }
.cc-meta { display:flex; flex-direction:column; gap:3px; }
.cc-meta span { font-size:.68rem; text-transform:uppercase; letter-spacing:.08em; color:rgba(200,220,255,.3); }
.cc-meta strong { font-size:.85rem; color:#fff; }
.cc-notes { margin-top:14px; padding:12px 14px; background:rgba(99,102,241,.06); border-left:2px solid rgba(99,102,241,.3); border-radius:0 8px 8px 0; }
.cc-notes-label { font-size:.7rem; font-weight:700; color:rgba(130,140,240,.7); text-transform:uppercase; letter-spacing:.08em; margin-bottom:4px; }
.cc-notes-text { font-size:.82rem; color:rgba(200,220,255,.65); line-height:1.6; }

/* ══ SUBSCRIPTION ══ */
.sub-active-card { background:rgba(12,26,46,.7); border:1px solid rgba(134,239,172,.18); border-radius:16px; padding:28px; }
.sac-badge { display:inline-flex; padding:4px 14px; border-radius:100px; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; background:rgba(134,239,172,.12); border:1px solid rgba(134,239,172,.25); color:#86efac; margin-bottom:20px; }
.sac-body { display:flex; gap:32px; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; }
.sac-type { font-size:.8rem; text-transform:uppercase; letter-spacing:.1em; color:rgba(200,220,255,.45); margin-bottom:4px; }
.sac-price { font-family:'Cormorant Garamond',serif; font-size:2.5rem; font-weight:300; color:#fff; line-height:1; }
.sac-price span { font-size:1rem; color:rgba(200,220,255,.4); }
.sac-dates { display:flex; gap:28px; flex-wrap:wrap; }
.sac-date-item { display:flex; flex-direction:column; gap:3px; }
.sac-date-item span { font-size:.68rem; text-transform:uppercase; letter-spacing:.08em; color:rgba(200,220,255,.3); }
.sac-date-item strong { font-size:.88rem; color:#fff; }
.sac-perks { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; margin-bottom:24px; }
.sac-perk { display:flex; align-items:center; gap:8px; font-size:.82rem; color:rgba(200,220,255,.65); }
.sac-perk span { color:#86efac; font-weight:700; }
.sac-cancel { padding-top:20px; border-top:1px solid rgba(255,255,255,.05); }
.sac-cancel-btn { padding:8px 18px; border-radius:8px; font-size:.78rem; border:1px solid rgba(239,68,68,.25); color:rgba(239,68,68,.65); background:rgba(239,68,68,.07); cursor:pointer; transition:all .2s; }
.sac-cancel-btn:hover { background:rgba(239,68,68,.15); color:#ef4444; }

.sub-upsell { }
.supsell-hero { text-align:center; padding:40px 20px 32px; }
.supsell-label { font-size:.7rem; text-transform:uppercase; letter-spacing:.18em; color:#c8a96e; margin-bottom:10px; }
.supsell-title { font-family:'Cormorant Garamond',serif; font-size:2.2rem; font-weight:300; color:#fff; margin-bottom:12px; }
.supsell-title em { color:#c8a96e; font-style:italic; }
.supsell-sub { font-size:.88rem; color:rgba(200,220,255,.5); max-width:500px; margin:0 auto; line-height:1.7; }
.supsell-plans { display:grid; grid-template-columns:repeat(2,1fr); gap:20px; max-width:560px; margin:0 auto; }
.sp-card { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.07); border-radius:16px; padding:28px 24px; text-align:center; position:relative; transition:all .22s; }
.sp-card:hover { border-color:rgba(255,255,255,.14); }
.sp-card--featured { border-color:rgba(200,169,110,.25); background:rgba(200,169,110,.04); }
.sp-featured-badge { position:absolute; top:-11px; left:50%; transform:translateX(-50%); background:linear-gradient(135deg,#c8a96e,#e8d5a3); color:#0a1628; font-size:.65rem; font-weight:700; padding:3px 14px; border-radius:100px; letter-spacing:.06em; white-space:nowrap; }
.sp-name { font-size:.78rem; text-transform:uppercase; letter-spacing:.12em; color:rgba(200,220,255,.4); margin-bottom:10px; }
.sp-price { font-family:'Cormorant Garamond',serif; font-size:2.4rem; font-weight:300; color:#fff; line-height:1; margin-bottom:6px; }
.sp-price span { font-size:.9rem; color:rgba(200,220,255,.4); }
.sp-save { font-size:.72rem; color:#86efac; margin-bottom:20px; }
.sp-btn { display:block; padding:10px 20px; border-radius:8px; font-size:.82rem; font-weight:600; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); color:rgba(200,220,255,.8); text-decoration:none; transition:all .2s; margin-top:16px; }
.sp-btn:hover { background:rgba(255,255,255,.12); }
.sp-btn--gold { background:linear-gradient(135deg,#c8a96e,#e8d5a3); border-color:transparent; color:#0a1628; }
.sp-btn--gold:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(200,169,110,.3); }

/* ══ PROFILE ══ */
.profile-layout { display:grid; grid-template-columns:200px 1fr; gap:24px; align-items:start; }
.profile-left { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:28px 20px; text-align:center; }
.profile-avatar-xl { width:72px; height:72px; border-radius:18px; background:linear-gradient(135deg,#0d7377,#14a8a0); display:flex; align-items:center; justify-content:center; font-size:1.8rem; font-weight:700; color:#fff; margin:0 auto 14px; }
.profile-name { font-size:.95rem; font-weight:600; color:#fff; margin-bottom:4px; }
.profile-email { font-size:.72rem; color:rgba(200,220,255,.4); margin-bottom:12px; word-break:break-all; }
.profile-role-badge { display:inline-block; padding:3px 12px; border-radius:100px; font-size:.65rem; font-weight:700; background:rgba(200,169,110,.12); border:1px solid rgba(200,169,110,.2); color:#c8a96e; margin-bottom:16px; }
.profile-since { font-size:.72rem; color:rgba(200,220,255,.3); line-height:1.6; }
.profile-right { display:flex; flex-direction:column; gap:20px; }
.profile-section { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:24px; }
.ps-title { font-size:.9rem; font-weight:600; color:#fff; margin-bottom:18px; }
.pform { display:flex; flex-direction:column; gap:16px; }
.pform-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.pform-group { display:flex; flex-direction:column; gap:6px; }
.pform-group label { font-size:.72rem; font-weight:600; color:rgba(200,220,255,.4); letter-spacing:.04em; }
.pform-group input { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:9px; padding:10px 13px; color:#fff; font-size:.875rem; outline:none; transition:border-color .2s; }
.pform-group input:focus { border-color:rgba(200,169,110,.4); }
.pf-disabled { background:rgba(255,255,255,.02) !important; color:rgba(200,220,255,.25) !important; cursor:not-allowed; }
.sec-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
.sec-item { display:flex; align-items:center; gap:12px; background:rgba(255,255,255,.03); border-radius:10px; padding:14px; }
.sec-icon { font-size:1.3rem; flex-shrink:0; }
.sec-t { font-size:.82rem; font-weight:600; color:#fff; margin-bottom:2px; }
.sec-s { font-size:.7rem; color:rgba(200,220,255,.4); }

/* ══ CART ══ */
.cart-layout { display:grid; grid-template-columns:1fr 300px; gap:20px; align-items:start; }
.cart-items-col { display:flex; flex-direction:column; gap:10px; }
.cart-row { display:flex; align-items:center; gap:14px; background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:12px; padding:14px 18px; transition:background .18s; }
.cart-row:hover { background:rgba(12,26,46,.9); }
.cr-emoji { font-size:1.5rem; flex-shrink:0; }
.cr-info { flex:1; min-width:0; }
.cr-name { font-size:.88rem; font-weight:600; color:#fff; }
.cr-meta { font-size:.72rem; color:rgba(200,220,255,.38); margin-top:2px; }
.cr-price { font-family:'Cormorant Garamond',serif; font-size:1.2rem; color:#c8a96e; font-weight:600; flex-shrink:0; }
.cr-remove { width:26px; height:26px; border-radius:50%; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07); color:rgba(200,220,255,.4); display:flex; align-items:center; justify-content:center; font-size:.75rem; cursor:pointer; transition:all .18s; flex-shrink:0; }
.cr-remove:hover { background:rgba(239,68,68,.15); border-color:rgba(239,68,68,.3); color:#ef4444; }
.cart-summary-col { background:rgba(12,26,46,.7); border:1px solid rgba(255,255,255,.06); border-radius:14px; padding:22px; position:sticky; top:80px; }
.cs-title { font-size:.88rem; font-weight:600; color:#fff; margin-bottom:16px; }
.cs-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; font-size:.85rem; color:rgba(200,220,255,.55); border-bottom:1px solid rgba(255,255,255,.04); }
.cs-row:last-of-type { border-bottom:none; }
.cs-row--total { font-weight:700; color:#fff; }
.cs-row--free .cs-free { color:#86efac; font-size:.78rem; font-weight:600; }
.cs-big { font-family:'Cormorant Garamond',serif; font-size:1.6rem; color:#c8a96e; }
.cs-checkout { display:block; text-align:center; margin-top:16px; padding:12px; border-radius:9px; font-size:.85rem; font-weight:600; background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; text-decoration:none; transition:all .2s; }
.cs-checkout:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(13,115,119,.4); }
.cs-more { display:block; text-align:center; margin-top:8px; padding:10px; border-radius:9px; font-size:.8rem; border:1px solid rgba(255,255,255,.08); color:rgba(200,220,255,.5); text-decoration:none; transition:all .2s; }
.cs-more:hover { border-color:rgba(255,255,255,.18); color:rgba(200,220,255,.8); }

/* ══ EMPTY ══ */
.empty-box { display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:72px 32px; }
.empty-icon { font-size:3.5rem; margin-bottom:18px; opacity:.55; }
.empty-box h3 { font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:400; color:#fff; margin-bottom:8px; }
.empty-box p { font-size:.85rem; color:rgba(200,220,255,.45); max-width:300px; line-height:1.6; margin-bottom:24px; }

/* ══ SHARED BUTTONS ══ */
.btn-teal { display:inline-flex; align-items:center; padding:11px 22px; border-radius:9px; font-size:.82rem; font-weight:600; background:linear-gradient(135deg,#0d7377,#14a8a0); color:#fff; text-decoration:none; border:none; cursor:pointer; transition:all .2s; }
.btn-teal:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(13,115,119,.4); }
.btn-teal:disabled { opacity:.5; cursor:not-allowed; }
.btn-teal-sm { display:inline-flex; align-items:center; padding:7px 14px; border-radius:8px; font-size:.75rem; font-weight:600; background:rgba(13,115,119,.18); border:1px solid rgba(20,168,160,.25); color:#14a8a0; text-decoration:none; transition:all .2s; }
.btn-teal-sm:hover { background:rgba(13,115,119,.32); }
.btn-outline-sm { display:inline-flex; align-items:center; padding:9px 18px; border-radius:9px; font-size:.8rem; font-weight:500; border:1px solid rgba(255,255,255,.1); color:rgba(200,220,255,.6); background:none; text-decoration:none; cursor:pointer; transition:all .2s; }
.btn-outline-sm:hover { border-color:rgba(200,169,110,.3); color:#e8d5a3; }

/* ══ RESPONSIVE ══ */
@media (max-width:1024px) {
  .kpi-row { grid-template-columns:repeat(2,1fr); }
  .dash-grid { grid-template-columns:1fr; }
  .sec-grid { grid-template-columns:1fr; }
  .pform-row { grid-template-columns:1fr; }
  .profile-layout { grid-template-columns:1fr; }
  .supsell-plans { grid-template-columns:1fr; }
  .cart-layout { grid-template-columns:1fr; }
  .cart-summary-col { position:static; }
}
@media (max-width:768px) {
  .pro-aside { display:none; }
  .pro-main { margin-left:0; }
  .tab-content { padding:18px; }
  .kpi-row { grid-template-columns:1fr 1fr; }
  .sac-body { flex-direction:column; gap:16px; }
  .unauth-features { grid-template-columns:1fr; }
}
</style>
