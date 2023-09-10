<template>
    <Head :title="form.name || 'Unbenanntes Menü'" />

    <AdminLayout :title="form.name || 'Unbenanntes Menü'" :backlink="route('admin.pages.menus')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="save()">
            <div class="flex v-center gap-1">
                <select class="header-select" v-model="form.status">
                    <option :value="null" disabled>Status auswählen</option>
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>

                <div class="spacer"></div>

                <IodButton :loading="form.processing" size="large">
                    {{ form.id ? 'Menü Speichern' : 'Menü erstellen' }}
                </IodButton>
            </div>

            <div class="limiter text-limiter">
                <div class="flex vertical gap-1">
                    <ValidationErrors />

                    <IodInput label="Name" v-model="form.name"/>

                    <select v-model="form.default_for">
                        <option :value="null">Keinen Standard</option>
                        <option value="main">Hauptmenü</option>
                    </select>

                    <div class="flex vertical radius-m border">
                        <div class="flex padding-1">
                            <IodButton type="button" label="Eintrag hinzufügen" variant="contained" size="small" @click="addItem()"/>
                        </div>
    
                        <CodeEditor language="json" :modelValue="JSON.stringify(form.content, undefined, 4)" @update:modelValue="form.content = JSON.parse($event)"/>
    
                        <small class="flex v-center gap-1 padding-1 user-select-none">
                            <IodIcon icon="build"/>
                            <span><b>Beta-Funktion:</b> ein Drag-n-Drop Editor folgt</span>
                        </small>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>

    <Picker ref="picker" accept="image/*"/>
    <UserSearchPopup ref="userSearchPopup"/>
    <RoleSearchPopup ref="roleSearchPopup"/>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { slugify } from '@/Utils/String'
    import { ref, computed, watch } from 'vue'
    import LocalSetting from '@/Classes/Managers/LocalSetting'
    import hotkeys from 'hotkeys-js'
    import dayjs from 'dayjs'

    import AdminLayout from '@/Layouts/Admin.vue'
    import CodeEditor from '@/Components/Form/CodeEditor.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import UserSearchPopup from '@/Components/Form/UserSearchPopup.vue'
    import RoleSearchPopup from '@/Components/Form/RoleSearchPopup.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); save() })



    const props = defineProps({
        item: Object,
    })

    const userSearchPopup = ref(null)
    const roleSearchPopup = ref(null)
    
    
    
    // START: Form
    const form = useForm({
        id: null,
        status: 'published',
        default_for: null,
        name: '',
        content: [],
    })

    const submitRoute = computed(() => form.id ? route(`admin.pages.menus.update`, form.id) : route(`admin.pages.menus.store`))
    const submitMethod = computed(() => form.id ? 'put' : 'post')

    const open = (item = null) => {
        form.id = item?.id ?? null
        form.status = item?.status ?? 'published'
        form.default_for = item?.default_for ?? null
        form.name = item?.name ?? ''
        form.content = item?.content ?? []
    }

    const save = () => {
        if (form.processing) return

        form.submit(submitMethod.value, submitRoute.value, {
            preserveScroll: true,
            onSuccess: (data) => {
                open(data?.props?.item)
            },
        })
    }

    open(props?.item)
    // END: Form



    // START: Items
    function addItem()
    {
        let item = {
            href: '/',
            title: 'Titel',
            target: '_self',
            children: [],
        }

        form.content.push(item)
    }
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .header-select
        height: 3rem
        cursor: pointer
</style>