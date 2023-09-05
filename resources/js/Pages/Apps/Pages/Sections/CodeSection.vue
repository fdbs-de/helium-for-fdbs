<template>
    <section class="he-section he-code-section" :style="{padding, backgroundColor}" v-html="content">
    </section>
</template>

<script setup>
    defineProps({
        content: String,
        padding: String,
        backgroundColor: String,
    })
</script>

<style lang="sass" scoped>
</style>