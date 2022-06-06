<template>
    <Alert v-if="hasErrors" style="margin-bottom: var(--su)" type="error" title="Da lief etwas schief">
        <ul style="margin-top: 0; padding-left: 20px; color: var(--color-error)">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </Alert>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import Alert from '@/Components/Alert.vue'

const errors = computed(() => usePage().props.value.errors)

const hasErrors = computed(() => Object.keys(errors.value).length > 0)
</script>