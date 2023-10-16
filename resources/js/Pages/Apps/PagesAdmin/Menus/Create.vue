<template>
    <AdminLayout :title="form.id ? 'Menü bearbeiten' : 'Menü erstellen'" sticky>
        <template #header-left>
            <IodButton label="Zurück" variant="contained" size="small" :loading="form.processing" is="a" :href="route('admin.pages.menus')" v-tooltip="'Zurück zur Übersicht'"/>
        </template>

        <template #header-right>
            <div class="flex gap-1 v-center">
                <IodButton :label="form.id ? 'Speichern' : 'Erstellen'" variant="filled" size="small" :loading="form.processing" @click="saveItem()" v-tooltip.bottom="'(STRG+S zum speichern)'"/>
            </div>
        </template>

        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <div class="limiter text-limiter">
                <div class="flex vertical gap-1">
                    <ValidationErrors />

                    <IodInput label="Name" v-model="form.name"/>

                    <div class="flex v-center gap-1">
                        <IodSelect class="flex-1" label="Standard für" v-model="form.default_for" :options="[
                            { value: null, text: 'Keinen Standard' },
                            { value: 'main', text: 'Hauptmenü' },
                            { value: 'legal', text: 'Rechliches' },
                        ]"/>
                        <IodIcon icon="double_arrow"/>
                        <IodSelect class="flex-1" label="Status" v-model="form.status" :options="[
                            { value: 'published', text: 'Veröffentlicht' },
                            { value: 'hidden', text: 'Versteckt' },
                        ]"/>
                    </div>

                    <hr class="margin-block-1">

                    <div class="flex vertical radius-m background-soft">
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



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); saveItem() })



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

    const saveItem = () => {
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