require('./bootstrap')

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

// Import Marketier UI
import MarketierUI from 'marketier-ui'
import 'marketier-ui/dist/style.css'

// Import i18n for Vue
import { createI18n } from 'vue-i18n/index'
import translations from '@/Lang/translations'



/////////////////////////
// Prepare Vue         //
/////////////////////////
const i18n = createI18n({
    locale: 'de',
    fallbackLocale: 'en',
    messages: translations,
})



/////////////////////////
// Initialize App      //
/////////////////////////
createInertiaApp({
    title(title)
    {
        return `FDBS – ${title}`
    },

    resolve(name)
    {
        return require(`./Pages/${name}.vue`)
    },

    setup({ el, app, props, plugin })
    {
        const application = createApp({ render: () => h(app, props) })

        application.use(plugin)
        application.use(MarketierUI)
        application.use(i18n)
        application.mixin({ methods: { route } })

        application.mount(el)
    },
})

InertiaProgress.init({ color: '#4B5563' })
