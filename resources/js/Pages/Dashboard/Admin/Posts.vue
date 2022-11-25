<template>
    <Head title="Posts verwalten" />

    <DashboardSubLayout title="Posts verwalten" area="Adminbereich">
        <template #head>
            <div class="spacer"></div>
            <mui-button icon-left="add" label="Neuer Post" size="small" @click="openItem()"/>
        </template>

        <div class="grid">
            <div class="row">
                <b>Titel</b>
                <b>Inhalt</b>
                <b>Sichtbarkeit</b>
                <b>Angepinnt</b>
            </div>
            
            <button class="row" v-for="post in posts" :key="post.id" @click="openItem(post)">
                <span v-if="post.title">{{post.title}}</span>
                <i v-else>Kein Titel angegeben</i>

                <span v-if="post.content">{{post.content}}</span>
                <i v-else>Kein Inhalt angegeben</i>

                <span>{{post.scope}}</span>

                <span>{{post.pinned ? 'Ja' : 'Nein'}}</span>
            </button>
        </div>
    </DashboardSubLayout>



    <Popup ref="managePopup" class="manage-popup" :title="form.id ? 'Post bearbeiten' : 'Post erstellen'">
        <form @submit.prevent="saveItem()" class="layout-wrapper">
            <div class="editor-content">
                <div class="popup-block popup-error" v-if="hasErrors">
                    <h3><b>Fehler!</b></h3>
                    <p v-for="(error, key) in errors" :key="key">{{ error }}</p>
                </div>
                
                <mui-input type="text" label="Titel" border v-model="form.title"/>

                <BlogInput class="content-input" v-model="form.content" />
            </div>

            <div class="sidebar">
                <div class="group">
                    <div class="flex gap-1 v-center">
                        <b class="flex-1">Post anpinnen</b>
                        <mui-toggle type="switch" v-model="form.pinned" />
                    </div>
                </div>

                <div class="group">
                    <b>Sichtbarkeit</b>
                    <select v-model="form.scope">
                        <option value="public">Öffentlich</option>
                        <option value="intranet">Intranet</option>
                    </select>
                </div>

                <!-- <div class="group">
                    <b>Kategorie</b>
                    <select>
                        <option value="public">Öffentlich</option>
                        <option value="intranet">Intranet</option>
                    </select>
                </div> -->

                <div class="group">
                    <div class="flex gap-1 v-center">
                        <b class="flex-1">Veröffentlichungsdatum</b>
                        <button type="button" class="icon-button" title="Veröffentlichungsdatum hinzufügen" v-if="form.available_from === null" @click="form.available_from = new Date().toISOString().split('T')[0]">add</button>
                        <button type="button" class="icon-button" title="Veröffentlichungsdatum zurücksetzen" v-else @click="form.available_from = null">replay</button>
                    </div>
                    <input type="date" class="date-input" v-model="form.available_from" v-show="form.available_from">
                </div>

                <div class="group">
                    <div class="flex gap-1 v-center">
                        <b class="flex-1">Gültigkeitsdatum</b>
                        <button type="button" class="icon-button" title="Gültigkeitsdatum hinzufügen" v-if="form.available_to === null" @click="form.available_to = new Date().toISOString().split('T')[0]">add</button>
                        <button type="button" class="icon-button" title="Gültigkeitsdatum zurücksetzen" v-else @click="form.available_to = null">replay</button>
                    </div>
                    <input type="date" class="date-input" v-model="form.available_to" v-show="form.available_to">
                </div>
                
                <div class="spacer"></div>

                <div class="group no-border">
                    <mui-button type="button" v-if="form.id" label="löschen" color="error" variant="contained" @click="$refs.deletePopup.open()"/>
                    <mui-button v-if="form.id" label="Speichern" :loading="form.processing"/>
                    <mui-button v-else label="Post erstellen" :loading="form.processing"/>
                </div>
            </div>
        </form>
    </Popup>
    


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
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import Popup from '@/Components/Form/Popup.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import BlogInput from '@/Components/Form/BlogInput.vue'
    import { ref, computed } from 'vue'
    import dayjs from 'dayjs'

    const props = defineProps({
        posts: Array,
    })



    const managePopup = ref(null)
    const deletePopup = ref(null)

    const form = useForm({
        id: null,
        title: '',
        content: '',
        scope: 'public',
        pinned: false,
        available_from: null,
        available_to: null,
    })

    const openItem = (item = null) => {
        managePopup.value.open()

        form.id = item?.id ?? null
        form.title = item?.title ?? ''
        form.content = item?.content ?? ''
        form.scope = item?.scope ?? 'public'
        form.pinned = item?.pinned ?? false
        form.available_from = item?.available_from ? dayjs(item?.available_from).format('YYYY-MM-DD') : null
        form.available_to = item?.available_to ? dayjs(item?.available_to).format('YYYY-MM-DD') : null
    }

    const saveItem = () => {
        form.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        form.post(route('dashboard.admin.posts.store'), {
            onSuccess: () => {
                managePopup.value.close()
            },
        })
    }

    const updateItem = () => {
        form.put(route('dashboard.admin.posts.update', form.id), {
            onSuccess: () => {
                managePopup.value.close()
            },
        })
    }

    const deleteItem = () => {
        form.delete(route('dashboard.admin.posts.delete', form.id), {
            onSuccess: () => {
                managePopup.value.close()
                deletePopup.value.close()
            },
        })
    }

    
    
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
</script>

<style lang="sass" scoped>
    .grid
        display: grid
        align-items: center
        grid-template-columns: minmax(170px, 2fr) minmax(200px, 3fr) minmax(200px, 3fr) 150px
        grid-auto-rows: 2.5rem
        gap: 0 var(--su)
        width: 100%
        padding: 1rem
        overflow-x: auto

        .row
            display: contents
            cursor: pointer
            text-align: inherit
            font-family: inherit
            font-size: inherit
            color: inherit

            > span
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap

            .icon
                font-family: var(--font-icon)
                font-size: 1.5rem
                line-height: 1
                color: var(--color-text)
                user-select: none

                &.notified
                    color: var(--color-warning)

                &.active
                    color: var(--color-primary)

            &:hover
                background: var(--color-background-soft)

    .manage-popup
        --max-width: 1100px

        .layout-wrapper
            display: flex

            .sidebar
                width: 300px
                background: var(--color-background-soft)
                display: flex
                flex-direction: column
                border-radius: 0 var(--radius-m) var(--radius-m) 0

                .group
                    display: flex
                    flex-direction: column
                    padding: 1rem
                    gap: 1rem
                    border-bottom: 1px solid var(--color-border)

                    &.no-border
                        border: none

                select
                    border: 1px solid var(--color-border)

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
                    border-radius: var(--radius-s)
                    border: 1px solid var(--color-border)

            .editor-content
                flex: 1
                padding: 1rem
                display: flex
                flex-direction: column
                gap: 1rem

                .content-input
                    height: 35rem
</style>