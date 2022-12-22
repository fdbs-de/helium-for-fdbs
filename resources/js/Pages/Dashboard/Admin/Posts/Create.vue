<template>
    <Head :title="form.id ? 'Post bearbeiten' : 'Post erstellen'" />

    <AdminLayout :title="form.id ? 'Post bearbeiten' : 'Post erstellen'">
        <div class="card flex v-center gap-1 padding-1 margin-bottom-2">
            <Link :href="route('admin.posts')">Zurück</Link>
            <select v-model="form.scope">
                <option value="blog">Blog</option>
                <option value="intranet">Intranet</option>
                <option value="wiki">Wiki</option>
                <option value="jobs">Karriere</option>
            </select>
            
            <select v-model="form.status">
                <option value="draft">Entwurf</option>
                <!-- <option value="pending">Zur Freigabe</option> -->
                <option value="published">Veröffentlicht</option>
                <!-- <option value="hidden">Versteckt</option> -->
            </select>
            
            <div class="spacer"></div>
            
            <mui-button type="button" v-if="form.id" label="löschen" color="error" variant="contained" @click="$refs.deletePopup.open()"/>
            <mui-button v-if="form.id" label="Post Speichern" :loading="form.processing" @click="saveItem()"/>
            <mui-button v-else label="Post erstellen" :loading="form.processing" @click="saveItem()"/>
        </div>

        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <div class="limiter text-limiter" v-if="hasErrors">
                <h3><b>Fehler!</b></h3>
                <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
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

            <div class="limiter text-limiter flex vertical gap-1">
                <mui-input type="text" label="Titel *" required v-model="form.title">
                    <template #right>
                        <button type="button" class="input-button" :class="{'active': form.pinned}" title="Post anpinnen" @click="form.pinned = !form.pinned">push_pin</button>
                    </template>
                </mui-input>
                
                <mui-input type="text" label="Slug *" required v-model="form.slug">
                    <template #right>
                        <button type="button" class="input-button" title="Aus Titel generieren" @click="generateSlug">auto_awesome</button>
                    </template>
                </mui-input>
                
                <div class="flex gap-1 v-center">
                    <select v-model="form.category">
                        <option :value="null">Keine Kategorie</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                    </select>

                    <mui-input class="flex-1" type="text" label="Tags" v-model="form.tags" />
                </div>

                <BlogInput class="content-input flex-1" v-model="form.content" />

                <div class="flex gap-1">
                    <div class="group flex-1">
                        <div class="flex gap-1 v-center">
                            <b class="heading flex-1">Veröffentlichungsdatum</b>
                            <button type="button" class="icon-button" title="Veröffentlichungsdatum hinzufügen" v-if="form.available_from === null" @click="form.available_from = new Date().toISOString().split('T')[0]">add</button>
                            <button type="button" class="icon-button" title="Veröffentlichungsdatum zurücksetzen" v-else @click="form.available_from = null">replay</button>
                        </div>
                        <input type="date" class="date-input" v-model="form.available_from" v-show="form.available_from">
                    </div>
            
                    <div class="group flex-1">
                        <div class="flex gap-1 v-center">
                            <b class="heading flex-1">Gültigkeitsdatum</b>
                            <button type="button" class="icon-button" title="Gültigkeitsdatum hinzufügen" v-if="form.available_to === null" @click="form.available_to = new Date().toISOString().split('T')[0]">add</button>
                            <button type="button" class="icon-button" title="Gültigkeitsdatum zurücksetzen" v-else @click="form.available_to = null">replay</button>
                        </div>
                        <input type="date" class="date-input" v-model="form.available_to" v-show="form.available_to">
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
    


    <Popup ref="deletePopup" title="Post löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteItem()">
            <p>Möchten Sie den Post <b>"{{form.title}}"</b> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.deletePopup.close()"/>
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen"/>
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import AdminLayout from '@/Layouts/Admin.vue'
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import Popup from '@/Components/Form/Popup.vue'
    import BlogInput from '@/Components/Form/BlogInput.vue'
    import { slugify } from '@/Utils/String'
    import { ref, computed, watch } from 'vue'
    import dayjs from 'dayjs'
    import { Inertia } from '@inertiajs/inertia'

    const props = defineProps({
        post: Object,
        categories: Array,
    })



    const expanded = ref(false)



    // START: Post Form
    const deletePopup = ref(null)

    const form = useForm({
        id: null,
        title: '',
        slug: '',
        category: null,
        tags: '',
        scope: 'blog',
        image: '',
        content: '',
        pinned: false,
        status: 'draft',
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
        form.scope = item?.scope ?? 'blog'
        form.image = item?.image ?? ''
        form.content = item?.content ?? ''
        form.pinned = item?.pinned ?? false
        form.status = item?.status ?? 'draft'
        form.available_from = item?.available_from ? dayjs(item?.available_from).format('YYYY-MM-DD') : null
        form.available_to = item?.available_to ? dayjs(item?.available_to).format('YYYY-MM-DD') : null
    }

    watch((props) => props?.post, () => {
        openItem(props?.post)
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
            tags: data.tags.split(',').map(tag => tag.trim()),
        })).post(route('admin.posts.store'), {
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }

    const updateItem = () => {
        form.transform((data) => ({
            ...data,
            tags: data.tags.split(',').map(tag => tag.trim()),
        })).put(route('admin.posts.update', form.id), {
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }

    const deleteItem = () => {
        form.delete(route('admin.posts.delete', form.id), {
            onSuccess: () => {
                deletePopup.value.close()
            },
        })
    }
    // END: Post Form

    
    
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

    .icon-button
        height: 1.5rem
        width: 2.5rem
        display: flex
        align-items: center
        justify-content: center
        user-select: none
        font-size: 1.2rem
        font-family: var(--font-icon)
        color: var(--color-primary)
        background: #e0004730
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