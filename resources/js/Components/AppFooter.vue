<template>
  <footer class="site-footer">
    <div class="footer-top-line"></div>
    <div class="footer-inner">

      <!-- 4 colonnes -->
      <div class="footer-cols">

        <!-- Col 1: Brand -->
        <div class="footer-brand">
          <Link :href="route('home')" class="footer-logo">Vitality Inside</Link>
          <p class="footer-tagline">
            Bio-energy frequency therapy designed by Dr. Éric Rosati. Science-backed protocols for complete wellness.
          </p>
          <div class="footer-socials">
            <a v-for="s in socials" :key="s.label" :href="s.href" target="_blank" rel="noopener"
              class="social-btn" :title="s.label" v-html="s.svg"></a>
          </div>
        </div>

        <!-- Col 2: Programs -->
        <div>
          <h5 class="footer-col-title">Programs</h5>
          <ul class="footer-links">
            <li v-for="link in programLinks" :key="link.label">
              <Link :href="route('shop')" class="footer-link">{{ link.label }}</Link>
            </li>
          </ul>
        </div>

        <!-- Col 3: Company -->
        <div>
          <h5 class="footer-col-title">Company</h5>
          <ul class="footer-links">
            <li><Link :href="route('about')"        class="footer-link">About Dr. Rosati</Link></li>
            <li><Link :href="route('consultation')" class="footer-link">Consultation</Link></li>
            <li><Link :href="route('blog')"         class="footer-link">Blog</Link></li>
            <li><Link :href="route('legal-notice')" class="footer-link">Legal Notice</Link></li>
          </ul>
        </div>

        <!-- Col 4: Account -->
        <div>
          <h5 class="footer-col-title">Account</h5>
          <ul class="footer-links">
            <li v-if="auth.user"><Link :href="route('dashboard')" class="footer-link">My Account</Link></li>
            <li v-if="auth.user && auth.user.has_program"><Link :href="route('my-program')" class="footer-link">My Programs</Link></li>
            <li><Link :href="route('pro')" class="footer-link">PRO Space</Link></li>
            <li v-if="!auth.user"><Link :href="route('login')" class="footer-link">Login</Link></li>
          </ul>
        </div>
      </div>

      <!-- Footer bottom -->
      <div class="footer-bottom">
        <p class="footer-copy">© {{ year }} Vitality Inside — All rights reserved.</p>
        <div class="footer-legal">
          <Link :href="route('legal-notice')" class="footer-legal-link">Legal Notice</Link>
          <span class="footer-sep">·</span>
          <a href="#" class="footer-legal-link">Privacy Policy</a>
          <span class="footer-sep">·</span>
          <a href="#" class="footer-legal-link">Terms of Use</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const year = new Date().getFullYear()
const page = usePage()
const auth = computed(() => page.props.auth)

const socials = [
  {
    label: 'Facebook', href: 'https://www.facebook.com/vitalityinside',
    svg: `<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>`
  },
  {
    label: 'YouTube', href: 'https://www.youtube.com/@vitalityinside',
    svg: `<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.96A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>`
  },
  {
    label: 'Instagram', href: 'https://www.instagram.com/health_vitalityinside/',
    svg: `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>`
  },
  {
    label: 'TikTok', href: 'https://www.tiktok.com/@vitalityinside',
    svg: `<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.87a8.18 8.18 0 004.78 1.52V7a4.85 4.85 0 01-1.01-.31z"/></svg>`
  },
]

const programLinks = [
  'All Programs',
  'Stress & Sleep',
  'Joint & Pain',
  'Hormonal Balance',
  'Immunity & ENT',
  'Unlimited Access',
].map(label => ({ label }))
</script>

<style scoped>
.site-footer {
  background: #0a1628;
  position: relative;
  border-top: 1px solid rgba(200,169,110,.2);
}
.footer-top-line {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(200,169,110,.5), rgba(20,168,160,.4), rgba(200,169,110,.5), transparent);
  margin-bottom: -1px;
}
.footer-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 80px 48px 40px;
}
.footer-cols {
  display: grid;
  grid-template-columns: 1.6fr 1fr 1fr 1fr;
  gap: 48px;
  margin-bottom: 56px;
}
.footer-logo {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.3rem;
  font-weight: 600;
  letter-spacing: .08em;
  color: #c8a96e;
  text-decoration: none;
  display: block;
  margin-bottom: 14px;
}
.footer-tagline {
  font-size: .83rem;
  color: rgba(200,220,255,.42);
  line-height: 1.65;
  max-width: 280px;
  margin-bottom: 24px;
}
.footer-socials {
  display: flex;
  gap: 10px;
}
.social-btn {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(13,115,119,.12);
  border: 1px solid rgba(13,115,119,.25);
  color: rgba(200,220,255,.55);
  transition: all .2s;
  text-decoration: none;
}
.social-btn:hover {
  background: rgba(13,115,119,.3);
  border-color: #0d7377;
  color: #fff;
  transform: translateY(-2px);
}
.footer-col-title {
  font-size: .7rem;
  font-weight: 700;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: #c8a96e;
  margin-bottom: 18px;
}
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.footer-link {
  font-size: .83rem;
  color: rgba(200,220,255,.48);
  text-decoration: none;
  transition: color .2s;
}
.footer-link:hover { color: #c8a96e; }
.footer-bottom {
  border-top: 1px solid rgba(255,255,255,.06);
  padding-top: 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}
.footer-copy {
  font-size: .76rem;
  color: rgba(200,220,255,.28);
}
.footer-legal {
  display: flex;
  align-items: center;
  gap: 8px;
}
.footer-legal-link {
  font-size: .76rem;
  color: rgba(200,220,255,.28);
  text-decoration: none;
  transition: color .2s;
}
.footer-legal-link:hover { color: #c8a96e; }
.footer-sep { color: rgba(200,220,255,.15); font-size: .76rem; }

@media (max-width: 900px) {
  .footer-inner { padding: 60px 24px 32px; }
  .footer-cols { grid-template-columns: 1fr 1fr; gap: 28px; }
}
@media (max-width: 540px) {
  .footer-cols { grid-template-columns: 1fr; }
  .footer-bottom { flex-direction: column; align-items: flex-start; }
}
</style>
