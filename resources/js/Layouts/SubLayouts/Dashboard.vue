<template>
    <GuestLayout>
        <main>
            <section id="hero-section">
                <h1>{{title}}</h1>
            </section>
            <section id="content-section">
                <div class="limiter main-card">
                    <nav class="dashboard-nav-bar">
                        <Link v-if="$page.props.auth.user.permissions.includes('access customer panel')" :class="{'active': isActive(route('dashboard.customer'))}" :href="route('dashboard.customer')">Kundenbereich</Link>
                        <Link v-if="$page.props.auth.user.permissions.includes('access employee panel')" :class="{'active': isActive(route('dashboard.employee'))}" :href="route('dashboard.employee')">Mitarbeiterbereich</Link>
                        <Link v-if="$page.props.auth.user.permissions.includes('access admin panel')" :class="{'active': isActive(route('dashboard.admin'))}" :href="route('dashboard.admin')">Adminbereich</Link>
                    </nav>
                    <slot />
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link, usePage } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'

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
        align-items: center
        justify-content: center
        margin-top: var(--height-header)
        padding-bottom: var(--height-header)
        height: calc(350px + var(--height-header))
        background: var(--color-background-soft)

        h1
            color: var(--color-primary)

    #content-section
        .main-card
            transform: translateY(calc(-1 * var(--height-header)))
            padding: 0
            background: var(--color-background)
            border-radius: calc(var(--su) * .75)
            box-shadow: var(--shadow-elevation-low)
            
            --mui-background: var(--color-background-soft)

            .checkbox
                --mui-background: var(--color-background)

            .dashboard-nav-bar
                height: var(--height-header)
                display: flex
                align-items: center
                gap: var(--su)
                padding-inline: var(--su)
                border-bottom: 2px solid var(--color-background-soft)

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


    @media only screen and (max-width: 500px)
        #hero-section
            padding-bottom: 0
            height: 250px
</style>