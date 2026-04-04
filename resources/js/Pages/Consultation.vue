<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="pt-32 pb-16 px-6 relative text-center overflow-hidden">
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(17,199,201,0.06) 0%, transparent 70%);"></div>
      <div class="relative z-10 max-w-3xl mx-auto">
        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Dr. Éric Rosati</p>
        <h1 class="font-serif font-light text-white mb-5" style="font-size: clamp(2.2rem, 5vw, 3.5rem); line-height: 1.1;">
          Your health,<br><em style="color: #D5B67A; font-style: italic;">precisely decoded.</em>
        </h1>
        <p class="text-[#9DAAC0] text-lg max-w-2xl mx-auto leading-relaxed mb-8">
          Describe your symptoms. Dr. Éric Rosati analyzes your bio-energetic profile and delivers a tailor-made frequency protocol — straight to your inbox within 8 hours.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <a href="#booking"
            class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-8 py-3.5 rounded transition-all">
            Book Your Consultation
          </a>
          <a href="#packages" class="border border-white/30 text-white hover:border-white/60 text-sm font-semibold px-8 py-3.5 rounded transition-all">
            View Packages →
          </a>
        </div>
      </div>
    </section>

    <!-- ═══ WHAT YOU RECEIVE ═══ -->
    <section class="px-6 pb-16 max-w-5xl mx-auto">
      <div class="text-center mb-10">
        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">What you receive</p>
        <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
          From your symptoms<br>to your <em style="color: #D5B67A; font-style: italic;">personalized protocol</em>
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div v-for="(step, i) in consultSteps" :key="i"
          class="rounded-2xl p-6 text-center"
          style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
          <div class="w-11 h-11 rounded-full mx-auto mb-4 flex items-center justify-center font-bold text-base"
            style="background: #11C7C9; color: #03142A;">{{ i + 1 }}</div>
          <h4 class="text-white font-semibold text-sm mb-2">{{ step.title }}</h4>
          <p class="text-xs leading-relaxed" style="color: #9DAAC0;">{{ step.desc }}</p>
        </div>
      </div>
    </section>

    <!-- ═══ PACKAGES ═══ -->
    <section id="packages" class="py-20 px-6" style="background: rgba(4,27,51,0.4);">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
          <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Packages</p>
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
            Lock in savings with<br><em style="color: #D5B67A; font-style: italic;">multi-session packages</em>
          </h2>
          <p class="text-[#9DAAC0] mt-3 text-sm">Chronic conditions respond best to multiple consultation cycles. Our packages give you deeper care at reduced cost.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="pkg in packages" :key="pkg.id"
            @click="form.package_type = pkg.id"
            class="rounded-2xl p-7 cursor-pointer transition-all relative"
            :style="form.package_type === pkg.id
              ? 'background: rgba(10,39,69,0.9); border: 2px solid #11C7C9; box-shadow: 0 0 30px rgba(17,199,201,0.1);'
              : 'background: rgba(10,39,69,0.5); border: 2px solid rgba(255,255,255,0.07);'">
            <!-- Badge sessions -->
            <div class="text-xs font-semibold mb-4 uppercase tracking-wide" style="color: rgba(157,170,192,0.5);">{{ pkg.sessions }} session{{ pkg.sessions > 1 ? 's' : '' }}</div>
            <h3 class="font-serif text-white text-xl font-light mb-1">{{ pkg.name }}</h3>
            <p class="text-sm mb-4" style="color: #9DAAC0;">{{ pkg.tagline }}</p>
            <p class="font-serif font-light mb-1" style="color: #D5B67A; font-size: 2rem; line-height: 1;">€{{ pkg.price }}</p>
            <p v-if="pkg.saving" class="text-xs mb-5" style="color: #11C7C9;">{{ pkg.saving }}</p>
            <ul class="space-y-2 mb-7">
              <li v-for="f in pkg.features" :key="f" class="flex items-start gap-2 text-xs" style="color: #9DAAC0;">
                <span class="flex-shrink-0" style="color: #11C7C9;">✦</span>{{ f }}
              </li>
            </ul>
            <button @click.stop="form.package_type = pkg.id"
              class="w-full font-bold text-sm tracking-wide uppercase py-3 rounded transition-all"
              :class="form.package_type === pkg.id ? 'bg-[#11C7C9] text-[#03142A]' : 'border border-white/20 text-white hover:border-[#11C7C9] hover:text-[#11C7C9]'">
              {{ pkg.label }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ FORM ═══ -->
    <section id="booking" class="py-20 px-6">
      <div class="max-w-2xl mx-auto">
        <div class="rounded-3xl p-8 md:p-10" style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07);">
          <h2 class="font-serif text-2xl text-white mb-2 font-light">Book your consultation</h2>
          <p class="text-sm mb-8" style="color: #9DAAC0;">Fill in the form, let Dr. Éric Rosati decode your bio-energetic profile.</p>

          <div v-if="$page.props.flash?.success"
            class="rounded-xl p-4 mb-6 text-sm"
            style="background: rgba(17,199,201,0.1); border: 1px solid rgba(17,199,201,0.3); color: #11C7C9;">
            ✓ {{ $page.props.flash.success }}
          </div>

          <form @submit.prevent="submit" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="text-xs mb-1.5 block font-semibold" style="color: #9DAAC0;">Full Name *</label>
                <input v-model="form.name" type="text" required placeholder="Your name"
                  class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors placeholder-white/20"
                  style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"/>
                <p v-if="form.errors.name" class="text-xs mt-1 text-red-400">{{ form.errors.name }}</p>
              </div>
              <div>
                <label class="text-xs mb-1.5 block font-semibold" style="color: #9DAAC0;">Email *</label>
                <input v-model="form.email" type="email" required placeholder="your@email.com"
                  class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors placeholder-white/20"
                  style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"/>
                <p v-if="form.errors.email" class="text-xs mt-1 text-red-400">{{ form.errors.email }}</p>
              </div>
            </div>
            <div>
              <label class="text-xs mb-1.5 block font-semibold" style="color: #9DAAC0;">Phone</label>
              <input v-model="form.phone" type="tel" placeholder="+33 6 00 00 00 00"
                class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors placeholder-white/20"
                style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"/>
            </div>
            <div>
              <label class="text-xs mb-1.5 block font-semibold" style="color: #9DAAC0;">Your symptoms &amp; health goals *</label>
              <textarea v-model="form.symptoms" required rows="4"
                placeholder="Describe your main health concerns, symptoms, duration, and what you've already tried…"
                class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors resize-none placeholder-white/20"
                style="background: rgba(3,20,42,0.7); border: 1px solid rgba(255,255,255,0.1);"></textarea>
              <p v-if="form.errors.symptoms" class="text-xs mt-1 text-red-400">{{ form.errors.symptoms }}</p>
            </div>
            <div>
              <label class="text-xs mb-1.5 block font-semibold" style="color: #9DAAC0;">Medical history (optional)</label>
              <textarea v-model="form.medical_history" rows="3"
                placeholder="Relevant past diagnoses, medications, surgeries…"
                class="w-full rounded-xl px-4 py-3 text-white text-sm focus:outline-none transition-colors resize-none placeholder-white/20"
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
            <p class="text-center text-xs" style="color: rgba(157,170,192,0.4);">🔒 Your information is confidential and permanently deleted within 14 days of delivery.</p>
          </form>
        </div>
      </div>
    </section>

    <!-- ═══ TESTIMONIALS ═══ -->
    <section class="py-20 px-6" style="background: rgba(4,27,51,0.4);">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
          <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4" style="color: #11C7C9;">Patients</p>
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem);">
            What patients say about<br><em style="color: #D5B67A; font-style: italic;">their consultation</em>
          </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div v-for="t in consultTestimonials" :key="t.name"
            class="rounded-2xl p-6 border border-white/8"
            style="background: rgba(10,39,69,0.6);">
            <div class="text-sm mb-3" style="color: #D5B67A;">★★★★★</div>
            <p class="text-sm italic leading-relaxed mb-4" style="color: rgba(157,170,192,0.9);">"{{ t.content }}"</p>
            <p class="text-white font-semibold text-sm">{{ t.name }}</p>
            <p class="text-xs" style="color: #11C7C9;">{{ t.program }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══ FAQ ═══ -->
    <section class="py-20 px-6">
      <div class="max-w-3xl mx-auto">
        <div class="text-center mb-10">
          <h2 class="font-serif font-light text-white" style="font-size: clamp(1.6rem, 3vw, 2.2rem);">
            Frequently asked <em style="color: #D5B67A; font-style: italic;">questions</em>
          </h2>
        </div>
        <div class="rounded-2xl p-6 mb-6 text-sm leading-relaxed" style="background: rgba(10,39,69,0.5); border: 1px solid rgba(255,255,255,0.07); color: #9DAAC0;">
          <p class="font-semibold text-white mb-2">Important Information</p>
          Cellular Bio Energy programs are intended to promote well-being through the harmonization of the bio-energetic field. They are not medical applications and should not be used as a substitute for professional medical advice, diagnosis, or treatment. All personal and medical data submitted during consultation is used exclusively to prepare a personalized program and is permanently deleted within 14 days of delivery.
        </div>
      </div>
    </section>

    <!-- ═══ FINAL CTA ═══ -->
    <section class="py-20 px-6" style="background: linear-gradient(135deg, #041B33 0%, #051A2E 100%);">
      <div class="max-w-2xl mx-auto text-center">
        <h2 class="font-serif font-light text-white mb-4" style="font-size: clamp(1.8rem, 3vw, 2.4rem);">
          Your protocol is<br><em style="color: #D5B67A; font-style: italic;">8 hours away</em>
        </h2>
        <p class="text-[#9DAAC0] mb-8 leading-relaxed">
          Fill in the form, let Dr. Éric Rosati decode your bio-energetic profile, and receive a personalized frequency protocol designed exclusively for you.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="#booking"
            class="bg-[#11C7C9] hover:bg-[#0db5b7] text-[#03142A] font-bold text-sm tracking-wide uppercase px-8 py-3.5 rounded transition-all">
            Book Your Consultation — €58
          </a>
          <Link :href="route('shop')"
            class="border border-white/30 text-white hover:border-white/60 text-sm font-semibold px-8 py-3.5 rounded transition-all">
            Browse Shop Programs
          </Link>
        </div>
      </div>
    </section>

  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const packages = [
  {
    id: 'single', name: 'Essential', price: 58, sessions: 1, label: 'Book Single — €58',
    tagline: 'Perfect for targeted, one-off health concerns',
    saving: null,
    features: ['1 personalized consultation', 'Custom frequency protocol', 'Delivered within 8 hours', 'Secure access link'],
  },
  {
    id: 'progress', name: 'Progress', price: 149, sessions: 3, label: 'Book 3 Sessions — €149',
    tagline: 'For chronic conditions requiring phased treatment',
    saving: 'Save €25 vs individual sessions',
    features: ['3 personalized consultations', 'Protocol updated at each session', 'Progress tracking between sessions', 'Priority 8-hour response', 'Recommended for complex cases'],
  },
  {
    id: 'transform', name: 'Transform', price: 239, sessions: 5, label: 'Book 5 Sessions — €239',
    tagline: 'Complete transformation program with full monitoring',
    saving: 'Save €51 vs individual sessions',
    features: ['5 personalized consultations', 'Comprehensive bio-energy mapping', 'Full symptom evolution tracking', 'VIP priority response', 'Best for multi-system conditions'],
  },
]

const consultSteps = [
  { title: 'Fill in the form',   desc: 'Complete the detailed health questionnaire as accurately as possible — symptoms, duration, medical history, and lifestyle context.' },
  { title: 'Expert analysis',    desc: 'Dr. Éric Rosati — Osteopath & Doctor of Quantum Medicine — reviews your profile and identifies the precise energetic imbalances to address.' },
  { title: 'Protocol delivered', desc: 'Your custom bio-energy frequency program is assembled and sent to you via a secure link — within 8 hours of submission.' },
  { title: 'Listen & recover',   desc: 'Follow your protocol at home with headphones. Sessions of 18–35 minutes, over a personalized cure duration. Monitoring included.' },
]

const consultTestimonials = [
  { content: 'I described my burn-out symptoms in the form and received an incredibly precise protocol within 6 hours. After 3 weeks I felt like myself again — something no doctor had managed in 2 years.', name: 'Marie-Hélène C.', program: 'Burn-Out protocol' },
  { content: 'The questionnaire was thorough and the analysis clearly personal — not a generic response. My insomnia protocol was perfectly calibrated to my case. Results in less than 2 weeks.', name: 'Bernard T.', program: 'Sleeping Troubles protocol' },
  { content: 'I booked the 3-session package for my chronic joint pain. Each consultation refined the protocol based on my progress. By session 3, I had reduced my anti-inflammatory use by 80%.', name: 'Gérard F.', program: 'Joint Pain — 3-session package' },
  { content: 'What impressed me most was the speed and the precision. Dr. Rosati identified a connection between my anxiety and digestive issues that I had never considered. The combined protocol was remarkable.', name: 'Élise R.', program: 'Anxiety + Digestive protocol' },
  { content: 'I was sceptical of an online consultation but the depth of the questionnaire and the personalization changed my mind immediately. My allergy season this year was entirely manageable.', name: 'Étienne M.', program: 'Allergy protocol' },
  { content: 'I have done 5 consultations over 8 months for my menopause symptoms. The evolution in each protocol shows genuine follow-up. Hot flushes are 90% reduced.', name: 'Françoise D.', program: 'Menopause — Transform package' },
]

const form = useForm({ name: '', email: '', phone: '', package_type: 'single', symptoms: '', medical_history: '' })
const selectedPkg = computed(() => packages.find(p => p.id === form.package_type) || packages[0])
const submit = () => form.post(route('consultation.store'))
</script>
