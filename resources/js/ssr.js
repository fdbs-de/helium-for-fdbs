import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
import route from 'ziggy'

// Import Marketier UI
import MarketierUI from 'marketier-ui'

// Import i18n for Vue
import { createI18n } from 'vue-i18n/index'
import translations from '@/Lang/translations'

// Import permissions helper
import { can } from '@/Utils/Permissions'



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
createServer((page) => createInertiaApp({
    page,
    render: renderToString,
    
    title(title)
    {
        return `FDBS – ${title}`
    },

    resolve(name)
    {
        return require(`./Pages/${name}.vue`)
    },
    
    setup({ app, props, plugin })
    {
        const application = createSSRApp({ render: () => h(app, props) })

        application.use(plugin)
        application.use(MarketierUI)
        application.use(i18n)
        application.mixin({
            methods: {
                route: (name, params, absolute) => {
                    return route(name, params, absolute, {
                        ...page.props.ziggy,
                        location: new URL(page.props.ziggy.url),
                    })
                },

                can,
            },
        })

        return application
    },
}))
