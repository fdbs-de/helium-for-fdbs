<template>
    <AdminLayout :title="form.id ? 'Planner Post bearbeiten' : 'Planner Post erstellen'" sticky>
        <template #header-left>
            <IodButton label="Zurück" variant="contained" size="small" :loading="form.processing" is="a" :href="route('admin.pages.planner')" v-tooltip="'Zurück zur Übersicht'"/>
        </template>

        <template #header-right>
            <div class="flex gap-1 v-center">
                <IodButton :label="form.id ? 'Speichern' : 'Erstellen'" variant="filled" size="small" :loading="form.processing" @click="save()" v-tooltip.bottom="'(STRG+S zum speichern)'"/>
            </div>
        </template>

        <form class="card flex vertical gap-1 padding-1" @submit.prevent="save()">
            <div class="limiter text-limiter">
                <div class="flex vertical gap-1">
                    <ValidationErrors />

                    <div class="flex v-center gap-1">
                        <IodInput class="flex-1" label="Titel" v-model="form.title"/>
                        <IodInput class="flex-1" label="Slug" v-model="form.slug">
                            <template #right>
                                <IodIconButton type="button" icon="auto_awesome" @click="generateSlug()" variant="text" size="small" v-tooltip.right="'Slug generieren'"/>
                            </template>
                        </IodInput>
                    </div>
                    <div class="flex v-center gap-1">
                        <IodSelect class="flex-1" label="Status" v-model="form.status" :options="[
                            { value: 'published', text: 'Veröffentlicht' },
                            { value: 'hidden', text: 'Versteckt' },
                        ]"/>

                        <IodInput class="flex-1" label="Zugewiesen zu" v-model="form.owner_displayname" readonly>
                            <template #right>
                                <IodIconButton type="button" icon="person_add" @click="userSearchPopup.open((item) => setOwner(item))" variant="text" size="small" v-tooltip.right="'Post zuweisen'"/>
                            </template>
                        </IodInput>
                    </div>


                    <hr class="margin-block-1">

                    <!-- <CodeEditor language="json" :modelValue="JSON.stringify(form.content, undefined, 4)" @update:modelValue="form.content = JSON.parse($event)"/> -->
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
    import hotkeys from 'hotkeys-js'
    import dayjs from 'dayjs'

    import AdminLayout from '@/Layouts/Admin.vue'
    import CodeEditor from '@/Components/Form/CodeEditor.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import UserSearchPopup from '@/Components/Form/UserSearchPopup.vue'
    import RoleSearchPopup from '@/Components/Form/RoleSearchPopup.vue'



    // START: Props & refs
    const props = defineProps({ item: Object })
    const userSearchPopup = ref(null)
    const roleSearchPopup = ref(null)
    const picker = ref(null)
    // END: Props & refs
    
    
    
    // START: Hotkeys
    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); save() })
    // END: Hotkeys


    
    // START: Form
    const form = useForm({ ...props?.item, status: props?.item?.status ?? 'published' })

    function save()
    {
        if (form.processing) return
        if (form.id) return form.put(route('admin.pages.planner.update', form.id), onSave)
        return form.post(route('admin.pages.planner.store'), onSave)
    }

    const onSave = {
        preserveScroll: true,
        onSuccess(data) {
            form.defaults(data?.props?.item ?? {}).reset()
        },
    }
    // END: Form



    // START: Methods
    function generateSlug()
    {
        form.slug = slugify(form.title)
    }

    function setOwner(item)
    {
        console.log(item)
        form.owner_id = item.id
        form.owner_type = item.model_class
        form.owner_displayname = item.name
    }
    // END: Methods
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