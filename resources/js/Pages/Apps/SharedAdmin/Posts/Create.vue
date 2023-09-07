<template>
    <Head :title="form.title || 'Post Titel'" />

    <AdminLayout :title="form.title || 'Post Titel'" :backlink="route('admin.'+app+'.posts')" backlink-text="Zurück zur Übersicht">
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="save()">
            <div class="flex v-center gap-1">
                <select class="header-select" v-model="form.status">
                    <option :value="null" disabled>Status auswählen</option>
                    <option value="draft">Entwurf</option>
                    <option value="pending">Zur Freigabe</option>
                    <option value="published">Veröffentlicht</option>
                    <option value="hidden">Versteckt</option>
                </select>

                <div class="spacer"></div>

                <mui-toggle type="switch" prepend-label="Auto-Save" v-model="autosave" v-if="form.id"/>

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

            <ValidationErrors />

            <div class="flex border-bottom padding-bottom-1">
                <div class="limiter text-limiter">
                    <Tabs v-model="tab" indicator-style="box" :tabs="[
                        { label: 'Allgemein', value: 'general' },
                        { label: 'Veröffentlichung', value: 'publishing'},
                        { label: 'Berechtigungen', value: 'permissions'},
                    ]" />
                </div>
            </div>

            <div class="tab-container" v-show="tab === 'general'">
                <div class="limiter text-limiter">
                    <div class="flex gap-1 vertical">
                        <select class="header-select" v-model="form.post_category_id">
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
                        <hr class="margin-block-1">
                        <TextEditor class="content-input flex-1" v-model="form.content" />
                    </div>
                </div>
            </div>

            <div class="tab-container" v-show="tab === 'publishing'">
                <div class="limiter text-limiter">
                    <div class="flex gap-1 vertical">
                        <fieldset class="flex vertical gap-1 margin-bottom-1">
                            <mui-input type="text" icon-left="tag" placeholder="Tags (Enter zum Hinzufügen)" v-model="tagString" @keydown.enter.stop.prevent="addTag(tagString); tagString = ''">
                                <template #right>
                                    <IconButton icon="add" class="input-button" @click="addTag(tagString); tagString = ''"  v-show="!!tagString" v-tooltip.right="'Tag Hinzufügen'"/>
                                </template>
                            </mui-input>
    
                            <div class="flex gap-1 wrap" v-show="form.tags.length">
                                <Tag icon="tag" v-for="tag in form.tags" :label="tag" @click="removeTag(tag)"/>
                            </div>
    
                            <small class="flex h-center padding-inline-1" v-show="!form.tags.length">
                                Keine Tags eingetragen
                            </small>
                        </fieldset>
        
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
                </div>
            </div>

            <div class="tab-container" v-show="tab === 'permissions'">
                <div class="limiter text-limiter">
                    <div class="flex gap-1 vertical">
                        <div class="flex vertical background-soft radius-m margin-top-0">
                            <div class="flex vertical padding-1">
                                <mui-toggle type="switch" label="Kategorie-Berechtigungen ignorieren" v-model="form.override_category_roles"/>
                            </div>
                            <div class="flex vertical padding-1 gap-1 border-top">
                                <div class="user flex v-center gap-1" v-for="role in form.roles">
                                    <b class="flex-1">{{ role.name }}</b>
                                    <IconButton icon="close" class="input-button" v-tooltip.right="'Benutzer entfernen'" @click="removeRole(role)"/>
                                </div>
                                <mui-button type="button" label="Rolle hinzufügen" variant="contained" size="small" @click="roleSearchPopup.open((item) => addRole(item), {exclude: form.roles.map(e => e.id), scope: 'all'})"/>
                            </div>
                            <div class="flex vertical padding-1 gap-1 border-top">
                                <div class="user flex v-center gap-1" v-for="user in form.users">
                                    <img :src="user.image" :alt="user.name" class="h-2 profile-image">
                                    <b class="flex-1">{{ user.name }}</b>
                                    <select class="h-2" v-model="user.pivot_role">
                                        <option value="owner">Ersteller</option>
                                        <option value="editor">Editor</option>
                                        <option value="viewer">Leser</option>
                                    </select>
                                    <IconButton icon="close" class="input-button" v-tooltip.right="'Benutzer entfernen'" @click="removeUser(user)"/>
                                </div>
                                <mui-button type="button" label="Benutzer hinzufügen" variant="contained" size="small" @click="userSearchPopup.open((item) => addUser(item), {exclude: form.users.map(e => e.id)})"/>
                            </div>
                            <div class="flex padding-1 gap-1 wrap border-top">
                                <span><b>Ansehen / verwenden</b><br>{{ whoCanView }}</span>
                                <span><b>Bearbeiten</b><br>{{ whoCanEdit }}</span>
                            </div>
                        </div>
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
    import TextEditor from '@/Components/Form/TextEditor.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import Tabs from '@/Components/Form/Tabs.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import UserSearchPopup from '@/Components/Form/UserSearchPopup.vue'
    import RoleSearchPopup from '@/Components/Form/RoleSearchPopup.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); save() })



    const props = defineProps({
        item: Object,
        categories: Array,
        app: String,
    })

    const userSearchPopup = ref(null)
    const roleSearchPopup = ref(null)



    const tab = ref('general')
    
    
    
    // START: Post Form
    const form = useForm({
        id: null,
        title: '',
        slug: '',
        post_category_id: null,
        tags: '',
        roles: [],
        image: '',
        content: '',
        pinned: false,
        status: 'draft',
        users: [],
        override_category_roles: false,
        available_from: null,
        available_to: null,
    })
    const formDelta = ref(form.data())

    const submitRoute = computed(() => form.id ? route(`admin.${props.app}.posts.update`, form.id) : route(`admin.${props.app}.posts.store`))
    const submitMethod = computed(() => form.id ? 'put' : 'post')

    const open = (item = null) => {
        form.id = item?.id ?? null
        form.title = item?.title ?? ''
        form.slug = item?.slug ?? ''
        form.post_category_id = item?.post_category?.id ?? null
        form.tags = item?.tags ?? []
        form.roles = item?.roles ?? []
        form.image = item?.image ?? ''
        form.content = item?.content ?? ''
        form.pinned = item?.pinned ?? false
        form.status = item?.status ?? 'draft'
        form.users = item?.users ?? []
        form.override_category_roles = item?.override_category_roles ?? false
        form.available_from = item?.available_from ? dayjs(item?.available_from).format('YYYY-MM-DD') : null
        form.available_to = item?.available_to ? dayjs(item?.available_to).format('YYYY-MM-DD') : null

        formDelta.value = form.data()
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
    // END: Post Form



    // START: Track Form Changes
    const hasUnsavedChanges = computed(() => {
        return JSON.stringify(formDelta.value) !== JSON.stringify(form.data())
    })
    // END: Track Form Changes



    // START: Auto-save
    const autosave = ref(LocalSetting.get('posts.editor', 'autosave', false))

    watch(autosave, (value) => {
        LocalSetting.set('posts.editor', 'autosave', value)
    })
    
    watch(hasUnsavedChanges, () => {
        if (autosave.value && !!form.id) saveThrottled()
    })

    const saveThrottled = _.debounce(save, 5000)
    // END: Auto-save



    // START: Tag Handling
    const tagString = ref('')

    const addTag = (tag) => {
        form.tags = [ ...form.tags, tag ]
    }

    const removeTag = (tag) => {
        form.tags = form.tags.filter(e => e !== tag)
    }
    // END: Tag Handling



    // START: Miscelaneous
    const generateSlug = () => {
        form.slug = slugify(form.title)
    }
    // END: Miscelaneous



    // START: Role Handling
    const addRole = (role) => {
        form.roles = [
            ...form.roles,
            role
        ]
    }

    const removeRole = (role) => {
        form.roles = form.roles.filter(e => e.id !== role.id)
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



    // START: Permission calculation texts
    const whoCanView = computed(() => {
        let text = ''
        let usersWithoutOwner = form.users.filter(e => e.pivot_role !== 'owner')
        let roles = form.roles.filter(e => e.name !== 'owner')
        let users = form.users

        if (roles.length === 0 && users.length === 0)
        {
            text = 'Nur Seitenadministratoren können diesen Post ansehen'
        }
        else if (roles.length > 0 && users.length > 0)
        {
            text = users.map(e => e.name).join(', ')+', Nutzer mit den Rollen ' + roles.map(e => e.name).join(', ')+' und Seitenadministratoren können diesen Post ansehen'
        }
        else if (roles.length > 0)
        {
            text = 'Nutzer mit den Rollen ' + roles.map(e => e.name).join(', ')+' und Seitenadministratoren können diesen Post ansehen'
        }
        else if (users.length > 0 && usersWithoutOwner.length === 0)
        {
            text = 'Jeder kann diesen Post ansehen'
        }
        else
        {
            text = users.map(e => e.name).join(', ')+' und Seitenadministratoren können diesen Post ansehen'
        }

        return text
    })

    const whoCanEdit = computed(() => {
        let text = 'Nur Seitenadministratoren können diesen Post bearbeiten'
        let users = form.users.filter(e => ['owner', 'editor'].includes(e.pivot_role))

        if (form.users.length > 0)
        {
            text = users.map(e => e.name).join(', ')+' und Seitenadministratoren können diesen Post bearbeiten'
        }

        return text
    })
    // END: Permission calculation texts
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
    
    .tabs-wrapper
        --tab-height: 2rem
        font-size: .8rem

    .tab-container
        display: flex
        flex-direction: column
        gap: 1rem
        min-height: 35rem
        padding-block: 1rem

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


    .user-search
        display: flex
        flex-direction: column
        gap: 1rem
        position: relative

        .dropdown
            display: flex
            flex-direction: column
            gap: .5rem
            padding: .5rem
            position: absolute
            left: 0
            top: 100%
            width: 100%
            background: var(--color-background)
            border-radius: var(--radius-m)
            box-shadow: var(--shadow-elevation-low)
            z-index: 1000
</style>