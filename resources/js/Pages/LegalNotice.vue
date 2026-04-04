<template>
  <AppLayout>
    <section class="pt-28 pb-24 px-4">
      <div class="max-w-3xl mx-auto">
        <h1 class="font-serif text-3xl text-white font-light mb-10">{{ t('legal.title') }}</h1>
        <div class="glass-card rounded-2xl p-8 space-y-8 text-vitality-text text-sm leading-relaxed">
          <div v-for="section in sections" :key="section.titleKey">
            <h2 class="text-white font-semibold text-base mb-3">{{ t(section.titleKey) }}</h2>
            <p>{{ t(section.contentKey) }}</p>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useI18n } from '@/composables/useI18n'
const { t } = useI18n()
const sections = [
  { titleKey: 'legal.company_title', contentKey: 'legal.company_content' },
  { titleKey: 'legal.hosting_title', contentKey: 'legal.hosting_content' },
  { titleKey: 'legal.ip_title',      contentKey: 'legal.ip_content' },
  { titleKey: 'legal.health_title',  contentKey: 'legal.health_content' },
  { titleKey: 'legal.gdpr_title',    contentKey: 'legal.gdpr_content' },
  { titleKey: 'legal.cookies_title', contentKey: 'legal.cookies_content' },
  { titleKey: 'legal.law_title',     contentKey: 'legal.law_content' },
]
</script>
