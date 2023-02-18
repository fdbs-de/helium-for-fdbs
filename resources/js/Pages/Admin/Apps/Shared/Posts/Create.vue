<template>
    <Head :title="form.title || 'Post Titel'" />

    <AdminLayout :title="form.title || 'Post Titel'" :backlink="route('admin.'+app+'.posts')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <div class="flex v-center gap-1">
                <select class="header-select" v-model="form.status">
                    <option :value="null" disabled>Status auswählen</option>
                    <option value="draft">Entwurf</option>
                    <option value="pending">Zur Freigabe</option>
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>

                <div class="spacer"></div>

                <mui-button class="header-button" :loading="form.processing" size="large" :disabled="!hasUnsavedChanges" v-tooltip.bottom="'(STRG+S zum speichern)'">
                    {{ form.id ? 'Post Speichern' : 'Post erstellen' }}
                </mui-button>
            </div>

            <div class="hero-image-wrapper">
                <img :src="form.image" :alt="form.title" class="hero-image" v-if="form.image">
                <div class="hero-image-overlay bottom">
                    <div class="limiter text-limiter">
                        <mui-input type="text" class="flex-1" placeholder="Bild URL" clearable v-model="form.image">
                            <template #right>
                                <IconButton icon="folder_open" class="input-button" @click="$refs.picker.open((file) => { form.image = file })"/>
                            </template>
                        </mui-input>
                    </div>
                </div>
            </div>

            <div class="limiter text-limiter" v-if="Object.keys($page.props.errors).length">
                <Alert type="error" title="Da lief etwas schief!">
                    <ul>
                        <li v-for="(error, key) in $page.props.errors" :key="key">{{ error }}</li>
                    </ul>
                </Alert>
            </div>

            <div class="flex border-bottom padding-bottom-1 margin-bottom-1">
                <Tabs v-model="tab" :tabs="[
                    { label: 'Allgemein', value: 'general' },
                    { label: 'Veröffentlichung', value: 'publishing'},
                    { label: 'Berechtigungen', value: 'permissions'},
                ]" />
            </div>

            <div class="limiter text-limiter">
                <div class="tab-container" v-show="tab === 'general'">
                    <select class="header-select" v-model="form.category">
                        <option :value="null" disabled>Kategorie auswählen</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                    </select>

                    <mui-input type="text" label="Titel" required v-model="form.title">
                        <template #right>
                            <IconButton icon="push_pin" class="input-button" :class="{'active': form.pinned}" @click="form.pinned = !form.pinned"  v-tooltip.right="'Post anpinnen'"/>
                        </template>
                    </mui-input>
                    
                    <mui-input type="text" label="Slug" required v-model="form.slug">
                        <template #right>
                            <IconButton icon="auto_awesome" class="input-button" @click="generateSlug()"  v-tooltip.right="'Aus Titel generieren'"/>
                        </template>
                    </mui-input>

                    <div></div>

                    <TextEditor class="content-input flex-1" v-model="form.content" />
                </div>

                <div class="tab-container" v-show="tab === 'publishing'">
                    <mui-input type="text" label="Tags" helper="Tags werden mit Komma getrennt" v-model="form.tags" />

                    <div class="flex vertical background-soft radius-m">
                        <div class="flex padding-1 gap-1 wrap">
                            <mui-toggle type="switch" label="Veröffentlichen am" :modelValue="!!form.available_from" @update:modelValue="form.available_from = $event ? new Date().toISOString().split('T')[0] : null"/>
                        </div>
                        <div class="flex padding-1 gap-1 wrap border-top" v-show="form.available_from">
                            <input type="date" class="date-input flex-1" v-model="form.available_from">
                        </div>
                    </div>

                    <div class="flex vertical background-soft radius-m">
                        <div class="flex padding-1 gap-1 wrap">
                            <mui-toggle type="switch" label="Veröffentlichen bis" :modelValue="!!form.available_to" @update:modelValue="form.available_to = $event ? new Date().toISOString().split('T')[0] : null"/>
                        </div>
                        <div class="flex padding-1 gap-1 wrap border-top" v-show="form.available_to">
                            <input type="date" class="date-input flex-1" v-model="form.available_to">
                        </div>
                    </div>
                </div>

                <div class="tab-container" v-show="tab === 'permissions'">
                    <div class="flex vertical background-soft radius-m">
                        <div class="flex padding-1 gap-1 wrap">
                            <mui-toggle type="switch" label="Berechtigungen überschreiben" v-model="form.override_category_roles"/>
                        </div>
                        <div class="flex padding-1 gap-1 wrap border-top" v-show="form.override_category_roles">
                            <span v-if="form.roles.length > 0">Nur <b>ausgewählte Benutzer</b> können diesen Eintrag aufrufen</span>
                            <span v-else><b>Jeder Benutzer</b> kann diesen Eintrag aufrufen</span>
                        </div>
                        <div class="flex padding-1 gap-1 wrap border-top" v-show="form.override_category_roles">
                            <mui-button
                                type="button"
                                v-for="role in roles"
                                :key="role.id"
                                :label="role.name"
                                :variant="form.roles.includes(role.id) ? 'solid' : 'contained'"
                                :icon-left="form.roles.includes(role.id) ? 'remove' : 'add'"
                                size="small"
                                @click="toggleRole(role.id)"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>

    <Picker ref="picker"/>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { slugify } from '@/Utils/String'
    import { ref, computed, watch } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import hotkeys from 'hotkeys-js'
    import dayjs from 'dayjs'

    import AdminLayout from '@/Layouts/Admin.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import Tabs from '@/Components/Form/Tabs.vue'
    import Alert from '@/Components/Alert.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); saveItem() })



    const props = defineProps({
        item: Object,
        categories: Array,
        roles: Array,
        app: String,
    })



    const tab = ref('general')



    
    
    
    // START: Post Form
    const form = useForm({
        id: null,
        title: '',
        slug: '',
        category: null,
        tags: '',
        roles: [],
        image: '',
        content: '',
        pinned: false,
        status: 'draft',
        override_category_roles: false,
        available_from: null,
        available_to: null,
    })
    
    const formDelta = ref(form.data())

    const formString = computed(() => {
        return JSON.stringify(form.data())
    })
    
    const hasUnsavedChanges = computed(() => {
        return JSON.stringify(formDelta.value) !== formString.value
    })



    const generateSlug = () => {
        form.slug = slugify(form.title)
    }



    const openItem = (item = null) => {
        form.id = item?.id ?? null
        form.title = item?.title ?? ''
        form.slug = item?.slug ?? ''
        form.category = item?.category ?? null
        form.tags = item?.tags ? item?.tags.join(', ') : ''
        form.roles = item?.roles.map(e => e.id) ?? []
        form.image = item?.image ?? ''
        form.content = item?.content ?? ''
        form.pinned = item?.pinned ?? false
        form.status = item?.status ?? 'draft'
        form.override_category_roles = item?.override_category_roles ?? false
        form.available_from = item?.available_from ? dayjs(item?.available_from).format('YYYY-MM-DD') : null
        form.available_to = item?.available_to ? dayjs(item?.available_to).format('YYYY-MM-DD') : null

        formDelta.value = form.data()
    }

    const saveItem = () => {
        if (form.processing) return
        if (!hasUnsavedChanges.value) return

        form.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        form.transform((data) => ({
            ...data,
            tags: data.tags.split(',').map(tag => tag.trim()).filter(tag => !!tag),
        })).post(route('admin.'+props.app+'.posts.store'), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.item)
            },
        })
    }

    const updateItem = () => {
        form.transform((data) => ({
            ...data,
            tags: data.tags.split(',').map(tag => tag.trim()).filter(tag => !!tag),
        })).put(route('admin.'+props.app+'.posts.update', form.id), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.item)
            },
        })
    }



    watch((props) => props?.item, () => {
        openItem(props?.item)
    },{
        immediate: true,
        deep: true
    })
    // END: Post Form



    // START: Role Handling
    const toggleRole = (role) => {
        form.roles = form.roles.includes(role) ? form.roles.filter(e => e !== role) : [ ...form.roles, role]
    }
    // END: Role Handling



    // START: Auto-save
    watch(formString, () => {
        saveItemThrottled()
    })

    const saveItemThrottled = _.debounce(saveItem, 5000)
    // END: Auto-save
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .header-select
        height: 3rem
        cursor: pointer
        border-radius: var(--radius-s)

    .header-button
        border-radius: var(--radius-s)

    .hero-image-wrapper
        border-radius: var(--radius-s)
        background: var(--color-background-soft)
        overflow: hidden
        position: relative
        width: 100%
        aspect-ratio: 2.5
        transition: all 100ms ease-out
        --mui-background: var(--color-background)

        &:hover .hero-image-overlay
            transform: translateY(0) !important

        .hero-image
            width: 100%
            height: 100%
            object-fit: cover
            position: absolute
            top: 0
            left: 0

        .hero-image-overlay
            position: absolute
            left: 0
            width: 100%
            transition: transform 100ms ease-out
            --primary: white

            &.bottom
                bottom: 0
                padding-block: 1rem .5rem
                transform: translateY(100%)
                background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%)

    .tab-container
        display: flex
        flex-direction: column
        gap: 1rem
        min-height: 35rem

    .input-button
        height: 2rem
        width: 2rem
        border-radius: var(--radius-s)
        flex: none

        &.active
            color: var(--color-primary)

    .date-input
        display: flex
        align-items: center
        height: 3rem
        background: var(--color-background)
        border-radius: var(--radius-s)
        
    .content-input
        min-height: 35rem
</style>