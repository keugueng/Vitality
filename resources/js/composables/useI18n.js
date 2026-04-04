import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useI18n() {
    const page = usePage()
    const locale = computed(() => page.props.locale || 'en')
    const translations = computed(() => page.props.translations || {})

    const t = (key) => {
        const keys = key.split('.')
        let value = translations.value
        for (const k of keys) {
            value = value?.[k]
            if (value === undefined) return key
        }
        return typeof value === 'string' ? value : key
    }

    return { t, locale }
}
