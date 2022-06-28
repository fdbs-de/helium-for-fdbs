<template>
    <TextSubLayout title="Maxi France" has-small-limiter>

        <Head>
            <title>Maxi France</title>
        </Head>

        <!-- <div class="logo-wrapper">
            <img src="/images/content/marken/eichenhof/eichenhof_logo.png" alt="Maxi France">
        </div> -->
        <!-- <Card new-window aspect-ratio="16/9" name="Eichenhof Broschüre (Download)" image="/images/content/marken/eichenhof/eichenhof_imagebroschure.jpg" link="/downloads/marken/eichenhof/eichenhof_imagebroschure.pdf"/> -->
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Card from '@/Components/Page/Card.vue'
</script>

<style lang="sass" scoped>
    .logo-wrapper
        display: flex
        justify-content: center
        padding-block: 3rem
        border-radius: .5rem
        margin-bottom: 4rem
        background-color: #EB190C

        img
            width: 100%
            max-width: 130px
</style>