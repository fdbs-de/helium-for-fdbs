<template>
    <AdminLayout :title="(form.name || 'Unbenannte Kategorie') + ' – Kategorie bearbeiten'" :backlink="route('admin.categories')" backlink-text="Zurück zur Übersicht">
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

                <select class="header-select" v-model="form.status">
                    <option :value="null" disabled>Status auswählen</option>
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>

                <div class="spacer"></div>
                
                <mui-button v-if="form.id" label="Kategorie Speichern" size="large" :loading="form.processing" @click="saveItem()"/>
                <mui-button v-else label="Kategorie erstellen" size="large" :loading="form.processing" @click="saveItem()"/>
            </div>

            <div class="limiter text-limiter flex vertical gap-1">
                <div class="flex gap-1 v-center">
                    <mui-input type="text" class="flex-1" label="Name *" required v-model="form.name"/>
                    <mui-input type="text" class="flex-1" label="Slug *" required v-model="form.slug">
                        <template #right>
                            <button type="button" class="input-button" v-tooltip.right="'Aus Titel generieren'" @click="generateSlug">auto_awesome</button>
                        </template>
                    </mui-input>
                </div>
                
                <div class="flex gap-1 v-center">
                    <mui-input class="flex-1" type="text" label="Farbe" v-model="form.color">
                        <template #right>
                            <input type="color" v-model="form.color">
                        </template>
                    </mui-input>
                    <mui-input class="flex-1" type="text" label="Icon" v-model="form.icon" />
                </div>

                <div class="flex vertical background-soft radius-m margin-block-2">
                    <div class="flex padding-1 gap-1 wrap h-center">
                        <span v-if="form.roles.length > 0">Nur <b>ausgewählte Benutzer</b> können diese Kategorie aufrufen</span>
                        <span v-else><b>Jeder Benutzer</b> kann diese Kategorie aufrufen</span>
                    </div>
                    <div class="flex padding-1 gap-1 wrap border-top">
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

                <TextEditor class="content-input flex-1" v-model="form.description" />
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
        roles: Array,
    })



    // START: Item Form
    const form = useForm({
        id: null,
        name: '',
        slug: '',
        color: '',
        icon: '',
        scope: 'blog',
        roles: [],
        description: '',
        status: 'draft',
    })

    const openItem = (item = null) => {
        form.id = item?.id ?? null
        form.name = item?.name ?? ''
        form.slug = item?.slug ?? ''
        form.color = item?.color ?? ''
        form.icon = item?.icon ?? ''
        form.scope = item?.scope ?? 'blog'
        form.roles = item?.roles.map(e => e.id) ?? []
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
    // END: Item Form



    // START: Slug Generator
    const generateSlug = () => {
        form.slug = slugify(form.name)
    }
    // END: Slug Generator



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

    input[type="color"]
        height: 2rem
        width: 3.5rem
        border: none
        padding: 0
        margin: 0
        -webkit-appearance: none

        &::-webkit-color-swatch-wrapper
            padding: 0

        &::-webkit-color-swatch
            border-radius: var(--radius-s)
            border: 1px solid white
        
    .content-input
        min-height: 25rem
</style>