<template>
  <AppLayout>
    <section class="pt-28 pb-24 px-4">
      <div class="max-w-3xl mx-auto">
        <h1 class="font-serif text-3xl text-white font-light mb-10">Legal Notice</h1>
        <div class="glass-card rounded-2xl p-8 space-y-8 text-vitality-text text-sm leading-relaxed">
          <div v-for="section in sections" :key="section.title">
            <h2 class="text-white font-semibold text-base mb-3">{{ section.title }}</h2>
            <p>{{ section.content }}</p>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
const sections = [
  { title: 'Company Information', content: 'Vitality Inside — Sole proprietorship. Publisher: Dr. Éric Rosati, Osteopath and Doctor of Quantum Medicine. Contact: rosati.eric@gmail.com' },
  { title: 'Hosting', content: 'This website is hosted on servers in France. The hosting provider complies with GDPR regulations.' },
  { title: 'Intellectual Property', content: 'All content on this website, including texts, images, audio programs, and protocols, are the exclusive property of Vitality Inside and Dr. Éric Rosati. Any reproduction without written consent is strictly prohibited.' },
  { title: 'Health Disclaimer', content: 'The programs and protocols offered by Vitality Inside are complementary approaches and do not constitute medical treatment. They are not intended to replace medical advice or treatment. Always consult a qualified healthcare professional for medical conditions.' },
  { title: 'Personal Data (GDPR)', content: 'Your personal data is processed in accordance with European Regulation 2016/679 (GDPR). You have the right to access, rectify, and delete your data. To exercise these rights, contact: rosati.eric@gmail.com' },
  { title: 'Cookies', content: 'This site uses only essential cookies required for its operation. No advertising or tracking cookies are used without your explicit consent.' },
  { title: 'Applicable Law', content: 'These legal notices are governed by French law. In the event of a dispute, the courts of Monaco shall have exclusive jurisdiction.' },
]
</script>
