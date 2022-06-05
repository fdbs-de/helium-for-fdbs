<template>
    <GuestLayout>
        <Head>
            <title>The competence in foodservice</title>
        </Head>

        <main>
            <div v-if="canLogin">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')">
                    Dashboard
                </Link>
    
                <template v-else>
                    <Link :href="route('login')">
                        Log in
                    </Link>
    
                    <Link v-if="canRegister" :href="route('register')">
                        Register
                    </Link>
                </template>
            </div>
        </main>
    </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import GuestLayout from '@/Layouts/Guest.vue'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})
</script>

<style lang="sass" scoped>
    main
        height: 100vh
</style>