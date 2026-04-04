<template>
  <AppLayout>
    <section class="cart-section">
      <div class="cart-inner">
        <h1 class="cart-title">Mon <em>Panier</em></h1>

        <div v-if="items.length === 0" class="cart-empty">
          <div class="cart-empty-icon">🛒</div>
          <p class="cart-empty-text">Votre panier est vide.</p>
          <Link :href="route('shop')" class="cart-btn-primary">Explorer les programmes</Link>
        </div>

        <div v-else class="cart-list">
          <!-- Program items -->
          <div v-for="item in items" :key="item.type === 'consultation' ? item.key : item.program.id"
            class="cart-item">
            <div class="cart-item-icon">
              <template v-if="item.type === 'consultation'">🩺</template>
              <template v-else>{{ item.program.emoji || '✨' }}</template>
            </div>
            <div class="cart-item-info">
              <h3 class="cart-item-title">
                <template v-if="item.type === 'consultation'">{{ item.consult.name }}</template>
                <template v-else>{{ item.program.title }}</template>
              </h3>
              <p class="cart-item-sub">
                <template v-if="item.type === 'consultation'">
                  {{ item.consult.sessions }} séance{{ item.consult.sessions > 1 ? 's' : '' }} · Protocole livré sous 8h
                </template>
                <template v-else>
                  {{ item.program.session_duration ? item.program.session_duration + ' min/séance' : '' }}
                  {{ item.program.cure_duration ? '· ' + item.program.cure_duration + '-jours de cure' : '' }}
                </template>
              </p>
            </div>
            <div class="cart-item-right">
              <span class="cart-item-price">
                €{{ item.type === 'consultation' ? item.consult.price : item.program.price }}
              </span>
              <Link :href="route('cart.remove')" method="post" as="button"
                :data="item.type === 'consultation' ? { cart_key: item.key } : { cart_key: item.program.id }"
                class="cart-remove">✕</Link>
            </div>
          </div>

          <!-- Summary -->
          <div class="cart-summary">
            <div class="cart-summary-row">
              <span>Total</span>
              <span class="cart-total">€{{ total }}</span>
            </div>
            <Link :href="route('checkout')" class="cart-btn-primary">Procéder au paiement</Link>
            <Link :href="route('shop')" class="cart-btn-outline">Continuer mes achats</Link>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ items: Array, total: [Number, String] })
</script>

<style scoped>
.cart-section { padding: 120px 24px 80px; min-height: 100vh; }
.cart-inner { max-width: 720px; margin: 0 auto; }
.cart-title { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; font-weight: 300; color: #fff; margin-bottom: 40px; }
.cart-title em { color: #c8a96e; font-style: italic; }
.cart-empty { text-align: center; padding: 60px 24px; background: rgba(13,31,58,.6); border: 1px solid rgba(200,169,110,.15); border-radius: 20px; }
.cart-empty-icon { font-size: 3rem; margin-bottom: 16px; }
.cart-empty-text { color: rgba(200,220,255,.5); font-size: .95rem; margin-bottom: 24px; }
.cart-list { display: flex; flex-direction: column; gap: 12px; }
.cart-item { display: flex; align-items: center; gap: 16px; background: rgba(13,31,58,.6); border: 1px solid rgba(200,169,110,.15); border-radius: 14px; padding: 18px 20px; }
.cart-item-icon { width: 44px; height: 44px; border-radius: 10px; background: rgba(13,115,119,.15); border: 1px solid rgba(13,115,119,.2); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-title { color: #fff; font-size: .9rem; font-weight: 600; margin-bottom: 3px; }
.cart-item-sub { color: rgba(200,220,255,.4); font-size: .75rem; }
.cart-item-right { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
.cart-item-price { color: #c8a96e; font-size: 1.1rem; font-weight: 600; }
.cart-remove { width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(255,255,255,.1); background: transparent; color: rgba(200,220,255,.4); cursor: pointer; font-size: .75rem; display: flex; align-items: center; justify-content: center; transition: all .2s; }
.cart-remove:hover { border-color: rgba(248,113,113,.4); color: #f87171; }
.cart-summary { background: rgba(13,31,58,.8); border: 1px solid rgba(200,169,110,.2); border-radius: 16px; padding: 24px; margin-top: 8px; display: flex; flex-direction: column; gap: 14px; }
.cart-summary-row { display: flex; align-items: center; justify-content: space-between; color: rgba(200,220,255,.6); font-size: .9rem; }
.cart-total { color: #c8a96e; font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 300; }
.cart-btn-primary { display: block; text-align: center; background: linear-gradient(135deg,#0d7377,#14a8a0); color: #fff; border: none; padding: 14px; border-radius: 8px; font-size: .9rem; font-weight: 600; text-decoration: none; cursor: pointer; transition: all .2s; }
.cart-btn-primary:hover { box-shadow: 0 8px 32px rgba(13,115,119,.4); transform: translateY(-1px); }
.cart-btn-outline { display: block; text-align: center; background: transparent; color: rgba(200,220,255,.6); border: 1px solid rgba(255,255,255,.1); padding: 12px; border-radius: 8px; font-size: .85rem; text-decoration: none; transition: all .2s; }
.cart-btn-outline:hover { border-color: rgba(200,169,110,.3); color: #e8d5a3; }
</style>
