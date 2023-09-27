<template>
    <AuthenticatedLayout title="Übersicht">
        <div class="limiter">
            <div class="flex vertical gap-2 padding-bottom-6">
                <Slider class="slider"/>

                <StatefulAccordion title="Relevant für Sie" scope="auth.overview.relevant">
                    <div class="grid padding-bottom-4">
                        <div class="icon-card highlight" v-if="user.access.customer">
                            <IodIcon icon="sell" />
                            <h3>Angebote</h3>
                            <p>Finden Sie unsere aktuellen Angebote ganz einfach zum Download.</p>
                            <IodButton is="a" label="Zu den Angeboten" href="/dashboard/kunden/angebote"/>
                        </div>
        
                        <div class="icon-card" v-if="user.access.employee">
                            <IodIcon icon="local_library" />
                            <h3>Firmenwiki</h3>
                            <p>Hier finden Sie alle Informationen rund um den FDBS.</p>
                            <IodButton is="a" label="Zum Wiki" href="/wiki"/>
                        </div>
        
                        <div class="icon-card" v-if="user.access.employee">
                            <IodIcon icon="download" />
                            <h3>Dokumente</h3>
                            <p>Hier finden Sie alle Dokumente, die Sie für Ihre Arbeit benötigen.</p>
                            <IodButton is="a" label="Zu den Dokumenten" href="/dashboard/intranet/dokumente"/>
                        </div>
        
                        <div class="icon-card" v-if="user.access.customer && !user.access.employee">
                            <IodIcon icon="cloud_done" />
                            <h3>Spezifikationen</h3>
                            <p>Hier finden Sie alle Spezifikationen zu unseren Produkten.</p>
                            <IodButton is="a" label="Zu den Spezifikationen" href="/dashboard/kunden/spezifikationen"/>
                        </div>
                    </div>
                </StatefulAccordion>
    
                <!-- <StatefulAccordion title="News" scope="auth.overview.news">
                    <template #head-right>
                        <IodButton is="a" label="Alle News ansehen" size="small" variant="text" href="/dashboard/intranet/news" />
                    </template>

                    <div class="flex padding-bottom-4"></div>
                </StatefulAccordion> -->
        
                <StatefulAccordion title="Links" scope="auth.overview.links" v-if="user.access.employee || can('system.access.admin.panel')">
                    <div class="grid">
                        <a class="link-card" target="_blank" href="https://fleischer-dienst.uweb2000.de" v-if="user.access.employee">
                            <IodIcon icon="school"/>
                            <p>UWEB Schulungen</p>
                            <IodIcon icon="open_in_new" class="open-in-new"/>
                        </a>
                        <a class="link-card" target="_blank" href="https://fleischer-dienst.mitarbeiterangebote.de/login" v-if="user.access.employee">
                            <IodIcon icon="percent"/>
                            <p>Mitarbeiterangebote</p>
                            <IodIcon icon="open_in_new" class="open-in-new"/>
                        </a>
                        <a class="link-card" target="_blank" href="https://www.dienstradtool.eurorad.de/register/step1/de45f84422f17ec3961693afaa2844101e4a8c47a2789adeb449f966672656ba" v-if="user.access.employee">
                            <IodIcon icon="pedal_bike"/>
                            <p>Dienstfahrrad-Leasing</p>
                            <IodIcon icon="open_in_new" class="open-in-new"/>
                        </a>
                        <a class="link-card" target="_blank" href="/ci" v-if="user.access.employee">
                            <IodIcon icon="format_paint"/>
                            <p>CI / Styleguide</p>
                            <IodIcon icon="open_in_new" class="open-in-new"/>
                        </a>
                        <a class="link-card" target="_blank" href="/admin" v-if="can('system.access.admin.panel')">
                            <IodIcon icon="shield"/>
                            <p>Adminbereich</p>
                            <IodIcon icon="open_in_new" class="open-in-new"/>
                        </a>
                    </div>
                </StatefulAccordion>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import { usePage } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'
    import { can } from '@/Utils/Permissions'
    
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import StatefulAccordion from '@/Components/Form/StatefulAccordion.vue'
    import Slider from '@/Pages/Apps/Pages/Partials/Slider.vue'



    const user = computed(() =>{
        return usePage().props.value.auth.user
    })
</script>

<style lang="sass" scoped>
    .slider
        margin-bottom: 4rem
        margin-top: 1rem
            


    .grid
        display: grid
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr))
        gap: 4rem

    .icon-card
        display: flex
        flex-direction: column
        align-items: stretch
        gap: 2rem
        padding: 2rem
        border-radius: var(--radius-l)
        border: 1px solid var(--color-border)
        text-align: center

        &.highlight
            border-color: var(--color-primary)
            box-shadow: var(--shadow-elevation-medium)
            background: var(--color-primary)
            color: var(--color-on-primary)

            .iod-icon
                color: inherit
                filter: drop-shadow(4px 4px 0 #ffffff40)

            h3
                color: inherit

            .iod-button
                --local-color-background: var(--color-on-primary)
                --local-color-text: var(--color-primary)

        .iod-icon
            font-size: 4rem
            color: var(--color-primary)
            margin: 1rem auto
            filter: drop-shadow(4px 4px 0 #e0004730)
        
        h3
            margin: 0
            font-weight: 600
            color: var(--color-primary)

        p
            margin: 0
            flex: 1

    

    .link-card
        display: flex
        align-items: center
        gap: 1rem
        padding: 1rem
        border-radius: var(--radius-l)
        border: 1px solid var(--color-border)
        color: var(--color-text)
        transition: all 100ms ease-in-out
        outline: none

        &:hover,
        &:focus
            border-color: transparent
            box-shadow: var(--shadow-elevation-medium)

        .iod-icon
            margin: .5rem

            &:not(.open-in-new)
                font-size: 2rem
                color: var(--color-primary)
                filter: drop-shadow(2px 2px 0 #e0004730)

            &.open-in-new
                opacity: .7

        p
            margin: 0
            flex: 1
            font-family: var(--font-heading)
</style>