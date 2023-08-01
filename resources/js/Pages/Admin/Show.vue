<template>
    <AdminLayout title="Admin-Übersicht">
        <div class="card welcome-card">
            <h2>{{ greeting }}</h2>
            <div class="bottom-bar">
                <small><Link :href="route('dashboard.profile')">{{ user.name }}</Link></small>
                <!-- <small>Sunrise 2023 Update</small> -->
                <div class="spacer"></div>
                <small>{{ day }} der {{ date }}</small>
                <b>{{ time }}</b>
            </div>
        </div>
        <div class="layout">
            <div class="card main spec">
                <div class="card-data">
                    <p>Registrierte Nutzer</p>
                    <h2>
                        <span>{{getFiller(users.total, 4)}}</span>{{users.total}}
                    </h2>
                </div>
                <div class="card-footer">
                    <div class="spacer"></div>
                    <mui-button as="a" :href="route('admin.users')" size="large" label="Zur Nutzerverwaltung"/>
                </div>
            </div>

            <div class="card spec">
                <div class="card-data">
                    <p>Noch nicht freigegebene Nutzer</p>
                    <h2>
                        <span>{{getFiller(users.disabled, 3)}}</span>{{users.disabled}}
                    </h2>
                </div>
            </div>

            <div class="card spec">
                <div class="card-data">
                    <p>Kunden</p>
                    <h2>
                        <span>{{getFiller(users.customers, 3)}}</span>{{users.customers}}
                    </h2>
                </div>
            </div>

            <div class="card spec">
                <div class="card-data">
                    <p>Mitarbeiter</p>
                    <h2>
                        <span>{{getFiller(users.employees, 3)}}</span>{{users.employees}}
                    </h2>
                </div>
            </div>
        </div>

        <hr class="margin-block-2">
        
        <div class="layout">
            <div class="card main spec purple">
                <div class="card-data">
                    <p>Angelegte Posts</p>
                    <h2>
                        <span>{{getFiller(posts.total, 4)}}</span>{{posts.total}}
                    </h2>
                </div>
                <div class="card-footer">
                    <div class="spacer"></div>
                    <!-- <mui-button as="a" :href="route('admin.posts')" size="large" label="Zur Post Übersicht"/> -->
                </div>
            </div>

            <div class="card spec purple">
                <div class="card-data">
                    <p>Blog Beiträge</p>
                    <h2>
                        <span>{{getFiller(posts.blog, 3)}}</span>{{posts.blog}}
                    </h2>
                </div>
            </div>
            
            <div class="card spec purple">
                <div class="card-data">
                    <p>Jobangebote</p>
                    <h2>
                        <span>{{getFiller(posts.jobs, 3)}}</span>{{posts.jobs}}
                    </h2>
                </div>
            </div>
            
            <div class="card spec purple">
                <div class="card-data">
                    <p>Wiki Beiträge</p>
                    <h2>
                        <span>{{getFiller(posts.wiki, 3)}}</span>{{posts.wiki}}
                    </h2>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, usePage, Link } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import dayjs from 'dayjs'

    import AdminLayout from '@/Layouts/Admin.vue'



    const props = defineProps({
        user_count: Number,
        unverified_user_count: Number,
        post_count: Number,
        spec_count: Number,
        posts: Object,
        users: Object,
    })



    const getFiller = (text, targetLength, fillerChar = '0') => fillerChar.repeat(targetLength - text.toString().length)



    const greetings = {
        "morning": [
            "Guten Morgen",
            "Schönen Start in den Tag",
            "Starten wir durch"
        ],
        "afternoon": [
            "Guten Tag",
        ],
        "evening": [
            "Guten Abend",
            "Gut gemacht heute",
        ],
        "night": [
            "Gute Nacht",
            "Erhol' Dich gut für morgen",
        ]
    }

    const greeting = computed(() => {
        const hour = new Date().getHours()

        if (hour >= 5 && hour < 12) {
            return greetings.morning[Math.floor(Math.random() * greetings.morning.length)]
        } else if (hour >= 12 && hour < 18) {
            return greetings.afternoon[Math.floor(Math.random() * greetings.afternoon.length)]
        } else if (hour >= 18 && hour < 22) {
            return greetings.evening[Math.floor(Math.random() * greetings.evening.length)]
        } else {
            return greetings.night[Math.floor(Math.random() * greetings.night.length)]
        }
    })



    const date = computed(() => dayjs().format('D. MMMM'))
    const time = computed(() => dayjs().format('HH:mm'))
    const day = computed(() => dayjs().format('dddd'))
    const user = computed(() => usePage().props?.value?.auth?.user)
</script>

<style lang="sass" scoped>
    .layout
        display: grid
        grid-template-columns: 1fr 1fr 1fr
        gap: 2rem

    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

        &.main
            grid-column: span 3

        &.spec
            display: flex
            flex-direction: column
            border-radius: var(--radius-m)
            --color-local-primary: var(--color-primary)
            --primary: var(--color-local-primary)

            &.orange
                --color-local-primary: #ff6348

            &.purple
                --color-local-primary: #079992

            .card-data
                background: var(--color-background-soft)
                border-radius: var(--radius-s)
                padding: 1.5rem
                display: flex
                flex-direction: column
                margin: .5rem

                p
                    margin: 0
                    font-size: 1.2rem
                    font-family: var(--font-heading)
                    color: var(--color-heading)

                h2
                    font-size: clamp(2rem, 5vw, 4rem)
                    margin: 0
                    font-weight: 600
                    font-family: monospace
                    color: var(--color-local-primary)

                    span
                        opacity: .3

            .card-footer
                display: flex
                align-items: center
                padding: 1rem
                padding-top: .5rem



    .welcome-card
        aspect-ratio: 2.5
        min-height: 15rem
        background: url('/images/app/versions/sunrise_2023.webp')
        background-size: cover
        background-position: center
        background-repeat: no-repeat
        position: relative
        overflow: hidden
        color: white
        margin-bottom: 4rem
        padding: 2rem
        box-shadow: var(--shadow-elevation-high)
        border-radius: var(--radius-l)
        
        &::before
            content: ''
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            pointer-events: none
            border-radius: inherit
            border: 1px solid #ffffff60

        .bottom-bar
            position: absolute
            bottom: 0
            left: 0
            width: 100%
            padding: 1rem 2rem
            border-radius: inherit
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.3) 100%)
            display: flex
            flex-wrap: wrap
            align-items: center
            gap: .5rem 2rem

            small
                opacity: .9

            a
                color: inherit
                text-decoration: none
                
                &:hover
                    text-decoration: underline

        h1, h2, h3
            color: inherit
            position: relative
            z-index: 1
            font-size: clamp(2rem, 5vw, 4rem)
            font-weight: 600
            text-align: center
            margin: 0
            text-shadow: 0 3px 10px #00000030



    @media only screen and (max-width: 1200px)
        .layout
            grid-template-columns: 1fr 1fr

        .card
            &.main
                grid-column: span 2

    @media only screen and (max-width: 900px)
        .layout
            grid-template-columns: 1fr

        .card
            &.main
                grid-column: span 1
</style>