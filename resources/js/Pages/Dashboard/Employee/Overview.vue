<template>
    <Head title="Intranet" />

    <DashboardSubLayout title="FDBS Intranet">
        <div class="grid">
            <!-- <Card new-window name="Dokumente" :link="route('dashboard.employee.documents')" />
            <Card new-window v-if="leitbild" :name="leitbild.name" :link="route('docs', leitbild.slug)" />
            <Card new-window v-if="organigramm" :name="organigramm.name" :link="route('docs', organigramm.slug)" />
            <Card new-window name="Uweb Schulungen" link="https://fleischer-dienst.uweb2000.de" /> -->

            <Link class="icon-button" :href="route('dashboard.employee.documents')">
                <div class="icon">draft</div>
                <div class="button-divider"></div>
                <div class="text">Dokumente</div>
            </Link>

            <a class="icon-button" v-if="leitbild" target="_blank" :href="route('docs', leitbild.slug)">
                <div class="icon">explore</div>
                <div class="button-divider"></div>
                <div class="text">{{leitbild.name}}</div>
            </a>

            <a class="icon-button" v-if="organigramm" target="_blank" :href="route('docs', organigramm.slug)">
                <div class="icon">lan</div>
                <div class="button-divider"></div>
                <div class="text">{{organigramm.name}}</div>
            </a>

            <a class="icon-button" target="_blank" href="https://fleischer-dienst.uweb2000.de">
                <div class="icon">school</div>
                <div class="button-divider"></div>
                <div class="text">Uweb Schulungen</div>
            </a>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Card from '@/Components/Page/Card.vue'

    defineProps({
        leitbild: Object,
        organigramm: Object,
    })
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        gap: 2rem
        padding: 2rem
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))

    .icon-button
        background: var(--color-background)
        display: flex
        padding: 1rem
        gap: 1rem
        align-items: center
        border-radius: var(--radius-m)
        border: 1px solid #00000020
        color: var(--color-heading)
        transition: all 200ms

        &:hover
            color: var(--color-primary)
            border-color: transparent
            box-shadow: var(--shadow-elevation-medium)

        .icon
            font-family: var(--font-icon)
            font-size: 2rem
            user-select: none
            aspect-ratio: 1
            line-height: 1.2
            height: 2.4rem
            display: flex
            align-items: center
            justify-content: center
            color: var(--color-primary)

        .button-divider
            height: 100%
            border-right: 1px solid currentColor
            opacity: .2

        .text
            font-family: var(--font-heading)
            font-size: 1.15rem

    @media only screen and (max-width: 500px)
        .grid
            padding: 3rem 1rem
            grid-template-columns: auto
</style>                    