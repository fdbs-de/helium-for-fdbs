<template>
    <AdminLayout title="Admin-Übersicht" no-header>
        <div class="card welcome-card">
            <h2>{{ greeting }}</h2>
            <div class="bottom-bar">
                <small><Link :href="route('dashboard.profile')">{{ user.name }}</Link></small>
                <div class="spacer"></div>
                <small>{{ day }} der {{ date }}</small>
                <b>{{ time }}</b>
            </div>
        </div>
        <div class="layout margin-bottom-4">
            <div class="card main spec">
                <div class="data-wrapper">
                    <div class="data-section" style="color: #1028FF">
                        <p>Accounts</p>
                        <h2><AnimatedNumber :number="users.total"/></h2>
                    </div>
                    <hr class="vertical">
                    <div class="data-section" style="color: #0051FE">
                        <p>Kunden</p>
                        <h2><AnimatedNumber :number="users.customers"/></h2>
                    </div>
                    <div class="data-section" style="color: #0066FE">
                        <p>Personal</p>
                        <h2><AnimatedNumber :number="users.employees"/></h2>
                    </div>
                    <div class="data-section" style="color: #008FFC">
                        <p>Ausstehend</p>
                        <h2><AnimatedNumber :number="users.disabled"/></h2>
                    </div>
                </div>
                <div class="card-footer">
                    <IodButton is="a" :href="route('admin.users')" size="small" label="Account Verwaltung" style="--local-color-background: #1028FF"/>
                </div>
            </div>
        </div>
        
        <div class="layout margin-bottom-2">
            <div class="card main spec">
                <div class="data-wrapper">
                    <div class="data-section" style="color: #EA2027">
                        <p>Posts</p>
                        <h2><AnimatedNumber :number="posts.total"/></h2>
                    </div>
                    <hr class="vertical">
                    <div class="data-section" style="color: #EE5A24">
                        <p>Blog</p>
                        <h2><AnimatedNumber :number="posts.blog"/></h2>
                    </div>
                    <div class="data-section" style="color: #F79F1F">
                        <p>Jobs</p>
                        <h2><AnimatedNumber :number="posts.jobs"/></h2>
                    </div>
                    <div class="data-section" style="color: #FFC312">
                        <p>Wiki</p>
                        <h2><AnimatedNumber :number="posts.wiki"/></h2>
                    </div>
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
    import AnimatedNumber from '@/Components/AnimatedNumber.vue'



    const props = defineProps({
        posts: Object,
        users: Object,
    })



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
            border-radius: var(--radius-l)

            .data-wrapper
                padding: 1.5rem
                gap: 1.5rem
                display: flex
                align-items: stretch
                border-bottom: 1px solid var(--color-border)

                &:last-child
                    border-bottom: none

                .data-section
                    flex: 1
                    display: flex
                    flex-direction: column
                    align-items: center
                    text-align: center
                    color: var(--color-primary)

                p
                    margin: 0
                    font-size: 1.2rem
                    font-family: var(--font-heading)
                    color: var(--color-text)

                h2
                    font-size: clamp(2rem, 5vw, 4rem)
                    margin: 0
                    font-weight: 600
                    font-family: var(--font-mono)
                    color: inherit

            .card-footer
                display: flex
                align-items: center
                padding: 1.5rem



    .welcome-card
        aspect-ratio: 2.8
        min-height: 12rem
        background: url('/images/app/versions/sunrise_2023.webp')
        background-size: cover
        background-position: center
        background-repeat: no-repeat
        position: relative
        overflow: hidden
        color: white
        margin-bottom: 4rem
        padding: 2rem
        box-shadow: var(--shadow-elevation-medium)
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
            padding: 3rem 2rem 1rem
            border-radius: inherit
            background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 100%)
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