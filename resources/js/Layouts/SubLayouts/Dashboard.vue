<template>
    <AuthenticatedLayout>
        <main>
            <section id="hero-section">
                <div class="limiter">
                    <div class="inner-wrapper">
                        <h1>{{title}}</h1>
                    </div>
                </div>
            </section>
            <section id="content-section">
                <div class="limiter">
                    <div class="main-card">
                        <div class="dashboard-nav-bar" v-if="$slots.head">
                            <slot name="head"/>
                        </div>
                        <slot />
                    </div>
                </div>
            </section>
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
    import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'

    defineProps({
        title: String,
    })

    const isActive = (url) => {
        return usePage().url.value.startsWith(new URL(url).pathname)
    }
</script>

<style lang="sass" scoped>
    #hero-section
        display: flex
        margin-top: calc(var(--height-header) + 1rem)
        margin-bottom: 1rem

        .inner-wrapper
            display: flex
            align-items: center
            justify-content: center
            height: 250px
            padding: 0 1rem
            border-radius: var(--radius-xl)
            background: var(--color-primary)

        h1
            color: var(--color-background)
            margin: 0
            text-align: center

    #content-section
        .limiter
            padding-bottom: 4rem

        .main-card
            background: var(--color-background)
            display: flex
            flex-direction: column
            
            --mui-background: var(--color-background-soft)

            .checkbox
                --mui-background: var(--color-background)

            .dashboard-nav-bar
                display: flex
                flex-wrap: wrap
                align-items: center
                gap: 1rem
                padding: 1rem
                border-radius: var(--radius-m)
                background: var(--color-background-soft)
                --mui-background: var(--color-background)
                position: relative

                > a
                    height: 2.5rem
                    font-size: .8rem
                    letter-spacing: .05rem
                    font-weight: 600
                    text-transform: uppercase
                    color: var(--color-text)
                    border-radius: calc(var(--su) * .5)
                    padding-inline: 1rem
                    display: flex
                    align-items: center
                    cursor: pointer
                    user-select: none

                    &:hover,
                    &:focus
                        background: var(--color-background-soft)
                        color: var(--color-heading)

                    &.active
                        background: var(--color-primary)
                        color: var(--color-background)


    @media only screen and (max-width: 700px)
        #hero-section
            .inner-wrapper
                height: auto
                aspect-ratio: 2/1
</style>