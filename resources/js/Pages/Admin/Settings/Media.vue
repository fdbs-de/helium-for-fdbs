<template>
    <Head title="Globale Einstellungen" />

    <AdminLayout title="Globale Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <!-- <form class="limiter text-limiter flex vertical gap-1" @submit.prevent="updateSettings()">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>

                <div class="flex v-center gap-1">
                    <div class="spacer"></div>
                    <mui-button label="Einstellungen Speichern" size="large" :loading="form.processing"/>
                </div>
            </form> -->

            <form class="limiter text-limiter flex vertical gap-1" @submit.prevent="generateMediaCache()">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>

                <mui-toggle class="checkbox" v-model="disclaimer">
                    <template #label>
                        <span style="line-height: 1.75;">
                            Ich habe verstanden, dass das erneuern des Medien Cache Metadaten
                            wie die Beschreibung oder den Alt-Text einzelner Dateien zurücksetzen kann.
                        </span>
                    </template>
                </mui-toggle>

                <mui-button label="Medien Cache erneuern" size="large" :disabled="!disclaimer" :loading="form.processing"/>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'

    const props = defineProps({
        settings: Object,
    })



    const form = useForm({
    })



    const openItem = () => {
    }

    watch((props) => props?.settings, () => {
        openItem(props?.settings)
    },{
        immediate: true,
        deep: true
    })

    const updateSettings = () => {
        form.patch(route('admin.settings.update'), {
            onSuccess: (data) => {
                // openItem(data?.props?.post)
            },
        })
    }



    // START: Cache action
    const disclaimer = ref(false)

    const generateMediaCache = async () => {
        form.patch(route('admin.media.generate.cache'), {
            preserveScroll: true,
            onSuccess: () => {
                disclaimer.value = false
            },
        })
    }
    // END: Cache action


    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
</style>