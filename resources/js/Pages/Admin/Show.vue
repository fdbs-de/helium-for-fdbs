<template>
    <AdminLayout title="Admin-Übersicht" no-header>
        <div class="card welcome-card">
            <h2>{{ greeting }}</h2>
            <div class="bottom-bar">
                <small><Link :href="route('dashboard.profile')">{{ user.name }}</Link></small>
                <div class="spacer"></div>
                <small>{{ day }} der {{ date }}</small>
            </div>
        </div>

        <div class="layout margin-bottom-4">
            <div class="card spec span-4">
                <div class="card-heading">
                    <h2>Accounts</h2>
                    <IodButton is="a" :href="route('admin.users')" size="small" label="Accounts" icon-right="east"/>
                </div>
                <div class="data-wrapper horizontal">
                    <div class="number-stat" style="color: #1028FF">
                        <div class="label">Gesamt</div>
                        <h3 class="data"><AnimatedNumber :number="users.total"/></h3>
                    </div>
                    <div class="number-stat" style="color: #0051FE">
                        <div class="label" v-tooltip="'Diese Accounts haben ihre Email noch nicht bestätigt'">Unverifiziert</div>
                        <h3 class="data"><AnimatedNumber :number="users.unverified"/></h3>
                    </div>
                    <div class="number-stat" style="color: #0066FE">
                        <div class="label" v-tooltip="'Diese Accounts sind noch nicht manuell freigegeben'">Verifiziert</div>
                        <h3 class="data"><AnimatedNumber :number="users.verified"/></h3>
                    </div>
                    <div class="number-stat" style="color: #008FFC">
                        <div class="label" v-tooltip="'Diese Accounts sind gesperrt'">Gesperrt</div>
                        <h3 class="data"><AnimatedNumber :number="users.terminated"/></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="layout margin-bottom-4">
            <div class="card spec span-2">
                <div class="card-heading">
                    <h2>Rollen</h2>
                    <IodButton is="a" :href="route('admin.roles')" size="small" label="Rollen" icon-right="east" style="--local-color-background: #a55eea"/>
                </div>
                <div class="data-wrapper">
                    <div class="progress-stat" v-for="count, name in limitObjectKeys(roles.userCount)" :key="name">
                        <span class="text-align-right">{{ name }}</span>
                        <div class="data" v-tooltip="count + ' Verwendungen'">
                            <AnimatedProgressBar class="flex-1" color="#a55eea" :number="count" :max="users.total"/>
                        </div>
                        <span class="text-align-left font-mono">{{ count }}</span>
                    </div>
                </div>
            </div>

            <div class="card spec span-2">
                <div class="card-heading">
                    <h2>Medien</h2>
                    <IodButton is="a" :href="route('admin.media', ['public'])" size="small" label="Medien" icon-right="east" style="--local-color-background: #7158e2"/>
                </div>
                <div class="data-wrapper horizontal">
                    <div class="number-stat border-right" style="color: #7158e2">
                        <div class="label">Dateien</div>
                        <h3 class="data"><AnimatedNumber :number="media.total_files"/></h3>
                    </div>
                    <div class="number-stat" style="color: #7158e2">
                        <div class="label">Ordner</div>
                        <h3 class="data"><AnimatedNumber :number="media.total_folders"/></h3>
                    </div>
                </div>
                <div class="data-wrapper">
                    <div class="progress-stat">
                        <span class="text-align-right">{{ formatBytes(media.storage.used, 0) }}</span>
                        <div class="data">
                            <AnimatedProgressBar class="flex-1" color="#7158e2" :number="media.storage.used" :max="media.storage.total"/>
                        </div>
                        <span class="text-align-left font-mono">{{ formatBytes(media.storage.total, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="layout margin-bottom-2">
            <div class="card spec span-4">
                <div class="card-heading">
                    <h2>Posts</h2>
                </div>
                <div class="data-wrapper horizontal">
                    <div class="number-stat" style="color: #be2edd">
                        <div class="label">Gesamt</div>
                        <h3 class="data"><AnimatedNumber :number="posts.total"/></h3>
                    </div>
                    <div class="number-stat" style="color: #cd43ec">
                        <div class="label">Blog</div>
                        <h3 class="data"><AnimatedNumber :number="posts.blog"/></h3>
                    </div>
                    <div class="number-stat" style="color: #d858f5">
                        <div class="label">Jobs</div>
                        <h3 class="data"><AnimatedNumber :number="posts.jobs"/></h3>
                    </div>
                    <div class="number-stat" style="color: #e271fc">
                        <div class="label">Wiki</div>
                        <h3 class="data"><AnimatedNumber :number="posts.wiki"/></h3>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, usePage, Link } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { formatBytes } from '@/Utils/Number'
    import dayjs from 'dayjs'

    import AdminLayout from '@/Layouts/Admin.vue'
    import AnimatedNumber from '@/Components/AnimatedNumber.vue'
    import AnimatedProgressBar from '@/Components/AnimatedProgressBar.vue'



    const props = defineProps({
        posts: Object,
        users: Object,
        roles: Object,
        media: Object,
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
    const day = computed(() => dayjs().format('dddd'))
    const user = computed(() => usePage().props?.value?.auth?.user)



    function limitObjectKeys(object, limit = 5)
    {
        const keys = Object.keys(object)

        if (keys.length <= limit) return object

        const limited = {}

        for (let i = 0; i < limit; i++) {
            limited[keys[i]] = object[keys[i]]
        }

        return limited
    }
</script>

<style lang="sass" scoped>
    .layout
        display: grid
        grid-template-columns: 1fr 1fr 1fr 1fr
        gap: 2rem

    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

        &.span-4
            grid-column: span 4

        &.span-3
            grid-column: span 3

        &.span-2
            grid-column: span 2

        &.span-1
            grid-column: span 1

        &.spec
            display: flex
            flex-direction: column
            border-radius: var(--radius-l)

            .card-heading
                display: flex
                align-items: center
                padding: 1rem
                border-bottom: 1px solid var(--color-border)

                h2
                    flex: 1
                    font-size: 1.2rem
                    margin: 0
                    padding-left: .5rem
                    font-weight: 600

            .data-wrapper
                padding-block: 1rem
                display: flex
                align-items: stretch
                border-bottom: 1px solid var(--color-border)
                flex-direction: column

                &.horizontal
                    flex-direction: row
                    gap: 1.5rem

                &:last-child
                    border-bottom: none

                .progress-stat
                    display: grid
                    grid-template-columns: 1fr 2fr 1fr
                    gap: 1.5rem
                    align-items: center
                    height: 2.5rem

                .number-stat
                    flex: 1
                    display: flex
                    flex-direction: column
                    align-items: center
                    text-align: center
                    color: var(--color-primary)

                    > .label
                        padding-inline: 1rem
                        font-size: 1rem
                        color: var(--color-text-soft)
                        margin: 0

                    > .data
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
        height: 200px
        background-color: var(--color-primary)
        background-image: url('/images/app/versions/sunrise_2023.webp')
        background-size: cover
        background-position: center
        background-repeat: no-repeat
        background-blend-mode: luminosity
        position: relative
        overflow: hidden
        color: white
        margin-block: 2rem 4rem
        padding: 1.5rem
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-l)
        
        &::before
            content: ''
            position: absolute
            top: 0
            bottom: 0
            left: 0
            right: 0
            background: var(--color-primary)
            opacity: .8
            pointer-events: none
            border-radius: inherit

        .bottom-bar
            position: absolute
            bottom: 0
            left: 0
            width: 100%
            padding: 1rem 1.5rem
            border-radius: inherit
            display: flex
            flex-wrap: wrap
            align-items: center
            gap: .5rem 2rem

            small
                opacity: .8

            a
                color: inherit
                text-decoration: none
                
                &:hover
                    text-decoration: underline

        h1, h2, h3
            color: inherit
            position: relative
            z-index: 1
            font-size: clamp(1.2rem, 5vw, 2rem)
            font-weight: 600
            text-align: center
            margin: 0



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