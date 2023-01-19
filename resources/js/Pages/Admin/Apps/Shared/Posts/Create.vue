<template>
    <Head :title="form.title || 'Post Titel'" />

    <AdminLayout :title="form.title || 'Post Titel'" :backlink="route('admin.'+app+'.posts')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-3 padding-1" @submit.prevent="saveItem()">
            <div class="limiter text-limiter" v-if="hasErrors">
                <h3><b>Fehler!</b></h3>
                <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
            </div>

            <div class="flex v-center gap-1">
                <select class="header-select" v-model="form.category">
                    <option :value="null" disabled>Kategorie auswählen</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                </select>

                <select class="header-select" v-model="form.status">
                    <option :value="null" disabled>Status auswählen</option>
                    <option value="draft">Entwurf</option>
                    <option value="pending">Zur Freigabe</option>
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>
                
                <div class="spacer"></div>
                
                <mui-button v-if="form.id" label="Post Speichern" size="large" :loading="form.processing" @click="saveItem()"/>
                <mui-button v-else label="Post erstellen" size="large" :loading="form.processing" @click="saveItem()"/>
            </div>

            <div class="hero-image-wrapper" :class="{'expanded': expanded}">
                <img :src="form.image" :alt="form.title" class="hero-image" v-if="form.image">
                <div class="hero-image-overlay top">
                    <div class="flex h-center">
                        <mui-button type="button" label="Ansicht" variant="text" size="small" :icon-left="expanded ? 'expand_less' : 'expand_more'" @click="expanded = !expanded"/>
                    </div>
                </div>
                <div class="hero-image-overlay bottom">
                    <div class="limiter text-limiter">
                        <mui-input type="text" class="flex-1" label="Bild URL" clearable border v-model="form.image" />
                    </div>
                </div>
            </div>

            <div class="limiter text-limiter flex vertical gap-1 margin-block-2">
                <!-- <mui-button label="Bild auswählen" @click="$refs.picker.open((file) => {form.image = file})"/> -->

                <mui-input type="text" label="Titel *" required v-model="form.title">
                    <template #right>
                        <button type="button" class="input-button" :class="{'active': form.pinned}" v-tooltip.right="'Post anpinnen'" @click="form.pinned = !form.pinned">push_pin</button>
                    </template>
                </mui-input>
                
                <mui-input type="text" label="Slug *" required v-model="form.slug">
                    <template #right>
                        <button type="button" class="input-button" v-tooltip.right="'Aus Titel generieren'" @click="generateSlug">auto_awesome</button>
                    </template>
                </mui-input>
                
                <mui-input type="text" label="Tags" v-model="form.tags" />

                <div class="flex vertical background-soft radius-m">
                    <div class="flex padding-1 gap-1 wrap h-center">
                        <mui-toggle type="switch" label="Berechtigungen überschreiben" v-model="form.override_category_roles"/>
                    </div>
                    <div class="flex padding-1 gap-1 wrap h-center border-top" v-show="form.override_category_roles">
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

                <div class="group">
                    <div class="flex gap-1 v-center">
                        <b class="heading flex-1">Veröffentlichungsdatum</b>
                        <button type="button" class="icon-button pill" v-tooltip.bottom="'Veröffentlichungsdatum hinzufügen'" v-if="form.available_from === null" @click="form.available_from = new Date().toISOString().split('T')[0]">add</button>
                        <button type="button" class="icon-button pill" v-tooltip.bottom="'Veröffentlichungsdatum zurücksetzen'" v-else @click="form.available_from = null">replay</button>
                    </div>
                    <input type="date" class="date-input" v-model="form.available_from" v-show="form.available_from">
                </div>
        
                <div class="group">
                    <div class="flex gap-1 v-center">
                        <b class="heading flex-1">Gültigkeitsdatum</b>
                        <button type="button" class="icon-button pill" v-tooltip.bottom="'Gültigkeitsdatum hinzufügen'" v-if="form.available_to === null" @click="form.available_to = new Date().toISOString().split('T')[0]">add</button>
                        <button type="button" class="icon-button pill" v-tooltip.bottom="'Gültigkeitsdatum zurücksetzen'" v-else @click="form.available_to = null">replay</button>
                    </div>
                    <input type="date" class="date-input" v-model="form.available_to" v-show="form.available_to">
                </div>
            </div>
            
            <div class="limiter text-limiter flex vertical gap-1">
                <TextEditor class="content-input flex-1" v-model="form.content" />
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
    import dayjs from 'dayjs'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'

    const props = defineProps({
        item: Object,
        categories: Array,
        roles: Array,
        app: String,
    })



    const expanded = ref(false)



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
    }

    watch((props) => props?.item, () => {
        openItem(props?.item)
    },{
        immediate: true,
        deep: true
    })

    const saveItem = () => {
        form.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        form.transform((data) => ({
            ...data,
            tags: data.tags.split(',').map(tag => tag.trim()).filter(tag => !!tag),
        })).post(route('admin.'+props.app+'.posts.store'), {
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
            onSuccess: (data) => {
                openItem(data?.props?.item)
            },
        })
    }
    // END: Post Form



    // START: Role Handling
    const toggleRole = (role) => {
        form.roles = form.roles.includes(role) ? form.roles.filter(e => e !== role) : [ ...form.roles, role]
    }
    // END: Role Handling

    
    
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

    .header-switcher
        height: 3rem
        box-shadow: none
        background: var(--color-background-soft)
        border-radius: var(--radius-s)

    .header-select
        height: 3rem
        cursor: pointer

    .hero-image-wrapper
        border-radius: var(--radius-m)
        background: var(--color-background-soft)
        overflow: hidden
        position: relative
        width: 100%
        aspect-ratio: 5
        transition: all 100ms ease-out
        --mui-background: var(--color-background)

        &.expanded
            aspect-ratio: 2.5

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

            &.top
                top: 0
                padding-block: .5rem 1rem
                transform: translateY(-100%)
                background: linear-gradient(0deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 100%)

    .input-button
        height: 2rem
        width: 2rem
        display: flex
        align-items: center
        justify-content: center
        padding: 0
        margin: 0
        border: none
        background: none
        cursor: pointer
        user-select: none
        font-family: var(--font-icon)
        font-size: 1.35rem
        text-align: center
        color: var(--color-text)
        border-radius: .25rem
        flex: none

        &:hover,
        &:focus
            color: var(--mui-color__)
            background: var(--mui-background-secondary__)

        &.active
            color: var(--color-primary)

    .group
        display: flex
        flex-direction: column
        padding: 1rem
        gap: 1rem
        border-radius: var(--radius-s)
        background: var(--color-background-soft)

        .heading
            color: var(--color-heading)

    .icon-button.pill
        height: 1.5rem
        width: 2.5rem
        display: flex
        align-items: center
        justify-content: center
        user-select: none
        font-size: 1.2rem
        font-family: var(--font-icon)
        color: var(--color-primary)
        background: #00000020
        border-radius: var(--radius-xl)
        padding: 0
        border: none
        cursor: pointer

        &:hover,
        &:focus
            background: var(--color-primary)
            color: var(--color-background)

    .date-input
        display: flex
        align-items: center
        height: 3rem
        background: var(--color-background)
        border-radius: var(--radius-s)
        
    .content-input
        min-height: 25rem
</style>