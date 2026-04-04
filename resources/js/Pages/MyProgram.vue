<template>
  <AppLayout>
    <section class="pt-32 pb-24 px-4 text-center">
      <div class="max-w-2xl mx-auto">
        <div class="text-6xl mb-6">🎧</div>
        <h1 class="section-title text-white mb-4">{{ t('my_program.title') }} <em class="text-gradient-gold not-italic">{{ t('my_program.title_em') }}</em></h1>
        <p class="text-vitality-text mb-10">{{ t('my_program.sub') }}</p>
        <div class="glass-card rounded-2xl p-8 border-glow">
          <input type="text" :placeholder="t('my_program.input_placeholder')"
            class="w-full bg-vitality-blue/40 border border-white/10 rounded-xl px-4 py-3 text-white text-sm text-center focus:outline-none focus:border-vitality-cyan/50 mb-4 placeholder-vitality-text/40"/>
          <button class="btn-cyan w-full py-3">{{ t('my_program.access_btn') }}</button>
          <p class="text-vitality-text/50 text-xs mt-4">
            {{ t('my_program.no_code') }} <Link :href="route('login')" class="text-vitality-cyan hover:underline">{{ t('my_program.login_text') }}</Link> {{ t('my_program.no_code_suffix') }}
          </p>
        </div>
        <p class="text-vitality-text/50 text-sm mt-8">
          {{ t('my_program.not_ordered') }} <Link :href="route('shop')" class="text-vitality-cyan hover:underline">{{ t('my_program.browse') }}</Link>
        </p>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from '@/composables/useI18n'
const { t } = useI18n()
</script>
