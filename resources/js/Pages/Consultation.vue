<template>
  <AppLayout>
    <!-- Hero -->
    <section class="pt-32 pb-16 px-6 relative text-center">
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(17,199,201,0.05) 0%, transparent 70%);"></div>
      <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Dr. Éric Rosati</p>
      <h1 class="font-serif font-light text-white mb-5" style="font-size: clamp(2.2rem, 5vw, 3.5rem); line-height: 1.1;">
        Personalized<br><em style="color: #D5B67A; font-style: italic;">Consultation</em>
      </h1>
      <p class="text-[#9DAAC0] text-lg max-w-2xl mx-auto leading-relaxed">
        Submit your health history and symptoms — Dr. Rosati personally designs your custom bio-energy frequency protocol within 8 hours.
      </p>
    </section>

    <!-- Packages -->
    <section class="px-6 pb-16 max-w-4xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div v-for="pkg in packages" :key="pkg.id"
          @click="form.package_type = pkg.id"
          class="rounded-2xl p-6 cursor-pointer transition-all"
          :style="form.package_type === pkg.id
            ? 'background: rgba(10,39,69,0.7); border: 2px solid #11C7C9;'
            : 'background: rgba(10,39,69,0.5); border: 2px solid rgba(255,255,255,0.07);'">
          <div v-if="pkg.popular"
            class="inline-flex items-center gap-1 text-xs rounded-full px-3 py-1 mb-3"
            style="background: rgba(17,199,201,0.1); color: #11C7C9;">⭐ Most Popular</div>
          <h3 class="text-white font-semibold text-lg mb-1">{{ pkg.name }}</h3>
          <p class="font-serif font-light text-3xl mb-2" style="color: #D5B67A;">€{{ pkg.price }}</p>
          <p class="text-sm mb-4" style="color: #9DAAC0;">{{ pkg.sessions }} session{{ pkg.sessions > 1 ? 's' : '' }} · {{ pkg.duration }}</p>
          <ul class="space-y-2">
            <li v-for="f in pkg.features" :key="f" class="flex items-start gap-2 text-xs" style="color: #9DAAC0;">
              <span class="flex-shrink-0 mt-0.5" style="color: #11C7C9;">✓</span>{{ f }}
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- How it works -->
    <section class="px-6 pb-16 max-w-4xl mx-auto">
      <div class="rounded-3xl p-8 md:p-12" style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
        <h2 class="font-serif text-2xl text-white mb-8 text-center font-light">How the consultation works</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div v-for="(step, i) in consultSteps" :key="i" class="text-center">
            <div class="w-11 h-11 rounded-full mx-auto mb-3 flex items-center justify-center text-lg"
              style="background: #11C7C9; color: #03142A; font-weight: 700;">{{ i + 1 }}</div>
            <h4 class="text-white font-semibold text-sm mb-1">{{ step.title }}</h4>
            <p class="text-xs leading-relaxed" style="color: #9DAAC0;">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Form -->
    <section class="px-6 pb-24 max-w-2xl mx-auto">
      <div class="rounded-3xl p-8 md:p-10" style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
        <h2 class="font-serif text-2xl text-white mb-8 font-light">Book your consultation</h2>

        <div v-if="$page.props.flash?.success"
          class="rounded-xl p-4 mb-6 text-sm"
          style="background: rgba(17,199,201,0.1); border: 1px solid rgba(17,199,201,0.3); color: #11C7C9;">
          {{ $page.props.flash.success }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-xs mb-1.5 block" style="color: #9DAAC0;">Full Name *</label>
              <input v-model="form.name" type="text" required placeholder="Your name"
                class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors"
                style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"/>
            </div>
            <div>
              <label class="text-xs mb-1.5 block" style="color: #9DAAC0;">Email *</label>
              <input v-model="form.email" type="email" required placeholder="your@email.com"
                class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors"
                style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"/>
            </div>
          </div>
          <div>
            <label class="text-xs mb-1.5 block" style="color: #9DAAC0;">Phone</label>
            <input v-model="form.phone" type="tel" placeholder="+33 6 00 00 00 00"
              class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors"
              style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"/>
          </div>
          <div>
            <label class="text-xs mb-1.5 block" style="color: #9DAAC0;">Your symptoms &amp; health goals *</label>
            <textarea v-model="form.symptoms" required rows="4"
              placeholder="Describe your main health concerns, symptoms, duration, and what you've already tried…"
              class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors resize-none"
              style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"></textarea>
          </div>
          <div>
            <label class="text-xs mb-1.5 block" style="color: #9DAAC0;">Medical history (optional)</label>
            <textarea v-model="form.medical_history" rows="3"
              placeholder="Relevant past diagnoses, medications, surgeries…"
              class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors resize-none"
              style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"></textarea>
          </div>

          <!-- Summary -->
          <div class="rounded-xl p-4 flex items-center justify-between"
            style="background: rgba(3,20,42,0.5); border: 1px solid rgba(255,255,255,0.08);">
            <div>
              <p class="text-white text-sm font-semibold">{{ selectedPkg.name }}</p>
              <p class="text-xs" style="color: #9DAAC0;">{{ selectedPkg.sessions }} session{{ selectedPkg.sessions > 1 ? 's' : '' }} · Protocol delivered within 8 hours</p>
            </div>
            <span class="font-serif font-light text-xl" style="color: #D5B67A;">€{{ selectedPkg.price }}</span>
          </div>

          <button type="submit" :disabled="form.processing"
            class="w-full bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase py-3.5 rounded transition-all disabled:opacity-50">
            {{ form.processing ? 'Sending…' : `Book Consultation — €${selectedPkg.price}` }}
          </button>
          <p class="text-center text-xs" style="color: rgba(157,170,192,0.5);">🔒 Your information is confidential. Protocol delivered within 8 hours.</p>
        </form>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const packages = [
  { id: 'single',    name: 'Single Session',    price: 58,  sessions: 1, duration: 'One protocol', popular: false,
    features: ['Complete health assessment', 'Custom frequency protocol', 'PDF protocol delivered < 8h', 'Email support'] },
  { id: 'progress',  name: 'Progress Pack',     price: 149, sessions: 3, duration: '3 months', popular: true,
    features: ['3 personalized consultations', 'Progressive protocol adjustment', 'Priority email support', 'Monthly progress review'] },
  { id: 'transform', name: 'Transform Program', price: 239, sessions: 5, duration: '5 months', popular: false,
    features: ['5 consultations over 5 months', 'Full health transformation plan', 'WhatsApp direct access', 'Unlimited email support', 'Access to all programs'] },
]

const consultSteps = [
  { icon: '📝', title: 'Fill the form', desc: 'Share your symptoms, history, and objectives in detail.' },
  { icon: '🔬', title: 'Dr. Rosati analyses', desc: 'Personal review of your case using 25+ years of clinical expertise.' },
  { icon: '📋', title: 'Protocol delivered', desc: 'Receive your custom frequency protocol by email within 8 hours.' },
  { icon: '🎧', title: 'Start your cure', desc: 'Follow your 21-30 day protocol with headphones and feel the difference.' },
]

const form = useForm({ name: '', email: '', phone: '', package_type: 'single', symptoms: '', medical_history: '' })
const selectedPkg = computed(() => packages.find(p => p.id === form.package_type) || packages[0])
const submit = () => form.post(route('consultation.store'))
</script>
