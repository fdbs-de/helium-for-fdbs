<template>
    <Head :title="form.name || 'Kategorie Name'" />

    <AdminLayout :title="form.name || 'Kategorie Name'" :backlink="route('admin.categories')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <div class="limiter text-limiter" v-if="hasErrors">
                <h3><b>Fehler!</b></h3>
                <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
            </div>

            <div class="flex v-center gap-1">
                <Switcher class="header-switcher" v-model="form.scope" :options="[
                    { value: 'blog', icon: 'public', tooltip: 'Blog' },
                    { value: 'intranet', icon: 'policy', tooltip: 'Intranet' },
                    { value: 'wiki', icon: 'travel_explore', tooltip: 'Wiki' },
                    { value: 'jobs', icon: 'work', tooltip: 'Jobs' },
                ]"/>

                <div class="spacer"></div>

                <select class="header-select" v-model="form.status">
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>
                
                <mui-button v-if="form.id" label="Kategorie Speichern" size="large" :loading="form.processing" @click="saveItem()"/>
                <mui-button v-else label="Kategorie erstellen" size="large" :loading="form.processing" @click="saveItem()"/>
            </div>

            <div class="limiter text-limiter flex vertical gap-1">
                <mui-input type="text" label="Name *" required v-model="form.name"/>
                
                <mui-input type="text" label="Slug *" required v-model="form.slug">
                    <template #right>
                        <button type="button" class="input-button" v-tooltip.right="'Aus Titel generieren'" @click="generateSlug">auto_awesome</button>
                    </template>
                </mui-input>

                
                
                <div class="flex gap-1 v-center">
                    <mui-input class="flex-1" type="text" label="Farbe" v-model="form.color" />
                    <mui-input class="flex-1" type="text" label="Icon" v-model="form.icon" />
                </div>
                
                <div class="margin-top-3">
                    <TextEditor class="content-input flex-1" v-model="form.description" />
                </div>
            </div>

        </form>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { slugify } from '@/Utils/String'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'

    const props = defineProps({
        item: Object,
    })



    // START: Item Form
    const form = useForm({
        id: null,
        name: '',
        slug: '',
        color: '',
        icon: '',
        scope: 'blog',
        description: '',
        status: 'draft',
    })

    const generateSlug = () => {
        form.slug = slugify(form.name)
    }

    const openItem = (item = null) => {
        form.id = item?.id ?? null
        form.name = item?.name ?? ''
        form.slug = item?.slug ?? ''
        form.color = item?.color ?? ''
        form.icon = item?.icon ?? ''
        form.scope = item?.scope ?? 'blog'
        form.description = item?.description ?? ''
        form.status = item?.status ?? 'published'
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
        form.post(route('admin.categories.store'), {
            onSuccess: (data) => {
                console.log(data?.props?.item)
                openItem(data?.props?.item)
            },
        })
    }

    const updateItem = () => {
        form.put(route('admin.categories.update', form.id), {
            onSuccess: (data) => {
                openItem(data?.props?.item)
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

    .header-switcher
        height: 3rem
        box-shadow: none
        background: var(--color-background-soft)
        border-radius: var(--radius-s)

    .header-select
        height: 3rem
        color: var(--color-text)
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