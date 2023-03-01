<template>
    <AdminLayout title="Admin-Übersicht">
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
                    <p>Noch nicht freigegebe Nutzer</p>
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

        <hr class="margin-block-4">
        
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
        
        <hr class="margin-block-4">
        
        <div class="layout">
            <div class="card main spec orange">
                <div class="card-data">
                    <p>Spezifikationen</p>
                    <h2>
                        <span>{{getFiller(spec_count, 4)}}</span>{{spec_count}}
                    </h2>
                </div>
                <div class="card-footer">
                    <div class="spacer"></div>
                    <mui-button as="a" :href="route('admin.specs')" size="large" label="Zur Speziverwaltung"/>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

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
            --color-local-primary: var(--color-primary)
            --primary: var(--color-local-primary)

            &.orange
                --color-local-primary: #ff6348

            &.purple
                --color-local-primary: #079992

            .card-data
                background: var(--color-background-soft)
                border-radius: var(--radius-m)
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