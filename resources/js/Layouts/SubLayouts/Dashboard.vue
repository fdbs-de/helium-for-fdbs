<template>
    <GuestLayout>
        <main>
            <section id="hero-section">
                <h1>{{title}}</h1>
            </section>
            <section id="content-section">
                <div class="limiter main-card">
                    <nav>
                        <Link v-if="$page.props.auth.user.permissions.includes('access customer panel')" :href="route('dashboard.customer')">Kundenbereich</Link>
                        <Link v-if="$page.props.auth.user.permissions.includes('access employee panel')" :href="route('dashboard.employee')">Mitarbeiterbereich</Link>
                        <Link v-if="$page.props.auth.user.permissions.includes('access admin panel')" :href="route('dashboard.admin')">Adminbereich</Link>
                    </nav>
                    <slot />
                </div>
            </section>
        </main>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'

    defineProps({
        title: String,
    })
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
            padding: calc(var(--su) * 2)
            gap: calc(var(--su) * 2)
            background: var(--color-background)
            border-radius: calc(var(--su) * .75)
            box-shadow: var(--shadow-elevation-low)
            
            --mui-background: var(--color-background-soft)

            .checkbox
                --mui-background: var(--color-background)

    @media only screen and (max-width: 500px)
        #hero-section
            padding-bottom: 0
            height: 250px
</style>