<template>
    <Head :title="title" />

    {{ content }}
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    defineProps({
        title: String,
        content: Array,
    })
</script>