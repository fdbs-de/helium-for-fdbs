<template>
    <AdminLayout :title="(form.name || 'Unbenannte Kategorie') + ' – Kategorie bearbeiten'" :backlink="route('admin.'+app+'.categories')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <ValidationErrors />

            <div class="flex v-center gap-1">
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
                
                <div class="flex gap-1 v-center margin-bottom-2">
                    <mui-input class="flex-1" type="text" label="Farbe" v-model="form.color">
                        <template #right>
                            <input type="color" v-model="form.color">
                        </template>
                    </mui-input>
                    <mui-input class="flex-1" type="text" label="Icon" v-model="form.icon" />
                </div>

                <!-- <TextEditor class="content-input flex-1" v-model="form.description" /> -->

                <div class="flex vertical background-soft radius-m margin-top-0">
                    <div class="flex padding-1 gap-1 wrap">
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
                    <div class="flex vertical padding-1 gap-1 border-top">
                        <div class="user flex v-center gap-1" v-for="user in form.users">
                            <img :src="user.image" :alt="user.name" class="h-2 profile-image">
                            <b class="flex-1">{{ user.name }}</b>
                            <select class="h-2" v-model="user.pivot_role">
                                <option value="owner" disabled>Ersteller</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Leser</option>
                            </select>
                            <IconButton icon="close" class="input-button" v-tooltip.right="'Benutzer entfernen'" @click="removeUser(user)"/>
                        </div>
                        <mui-button type="button" label="Benutzer hinzufügen" size="small" @click="userSearchPopup.open((item) => addUser(item), {exclude: form.users.map(e => e.id)})"/>
                    </div>
                    <div class="flex padding-1 gap-1 wrap h-center border-top">
                        <span v-if="form.roles.length > 0">Nur <b>ausgewählte Benutzer</b> können diese Kategorie aufrufen</span>
                        <span v-else><b>Jeder Benutzer</b> kann diese Kategorie aufrufen</span>
                    </div>
                </div>
            </div>

        </form>
    </AdminLayout>

    <UserSearchPopup ref="userSearchPopup"/>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { slugify } from '@/Utils/String'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import UserSearchPopup from '@/Components/Form/UserSearchPopup.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'

    const props = defineProps({
        item: Object,
        roles: Array,
        app: String,
    })

    const userSearchPopup = ref(null)



    // START: Item Form
    const form = useForm({
        id: null,
        name: '',
        slug: '',
        color: '',
        icon: '',
        roles: [],
        users: [],
        description: '',
        status: 'draft',
    })

    const openItem = (item = null) => {
        form.id = item?.id ?? null
        form.name = item?.name ?? ''
        form.slug = item?.slug ?? ''
        form.color = item?.color ?? ''
        form.icon = item?.icon ?? ''
        form.roles = item?.roles.map(e => e.id) ?? []
        form.users = item?.users ?? []
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
        form.post(route('admin.'+props.app+'.categories.store'), {
            onSuccess: (data) => {
                console.log(data?.props?.item)
                openItem(data?.props?.item)
            },
        })
    }

    const updateItem = () => {
        form.put(route('admin.'+props.app+'.categories.update', form.id), {
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



    // START: User Handling
    const addUser = (user) => {
        form.users = [
            ...form.users,
            { ...user, pivot_role: 'viewer' }
        ]
    }

    const removeUser = (user) => {
        form.users = form.users.filter(e => e.id !== user.id)
    }
    // END: User Handling
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
        
    .content-input
        min-height: 25rem
</style>