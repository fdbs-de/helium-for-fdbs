<template>
    <Head title="Posts verwalten" />

    <AdminLayout title="Posts verwalten">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()" @delete="openDeletePopup()"/>
            <Switcher v-show="selection.length <= 0" v-model="scope" :options="[
                { value: null, icon: 'apps', tooltip: 'Alle' },
                { value: 'blog', icon: 'public', tooltip: 'Blog' },
                { value: 'intranet', icon: 'policy', tooltip: 'Intranet' },
                { value: 'wiki', icon: 'travel_explore', tooltip: 'Wiki' },
                { value: 'jobs', icon: 'work', tooltip: 'Jobs' },
            ]"/>

            <div class="spacer"></div>

            <div class="flex v-center">
                <!-- <IconButton type="button" icon="search" v-tooltip="'Suchen'" /> -->
                <VDropdown placement="bottom-end">
                    <IconButton type="button" icon="settings" v-tooltip="'Ansichtseinstellungen'" />
                    <template #popper>
                        <div class="flex padding-1 vertical">
                            <mui-toggle type="switch" prepend-label="Bildvorschau" v-model="isPreview" />
                        </div>
                    </template>
                </VDropdown>
            </div>

            <Switcher v-model="layout" :options="[
                { value: 'list', icon: 'view_list', tooltip: 'Listenansicht' },
                { value: 'grid', icon: 'grid_view', tooltip: 'Kachelansicht' },
            ]"/>
        </div>

        <ListItemLayout class="w-100 margin-block-2" :layout="layout" v-show="posts.length >= 1">
            <ImageCard
                v-for="item in filteredPosts"
                :key="item.id"
                :item="item"
                :layout="layout"
                :enable-preview="isPreview"
                :selection="selection"
                @contextmenu.prevent.exact="setSelection(item)"
                @contextmenu.prevent.ctrl="toggleSelection(item)"
                @click.ctrl="toggleSelection(item)"
                @click.exact="openItem(item)"
                @open="openItem(item)"
                @duplicate="duplicateItem(item)"
                @delete="openDeletePopup(item)"
                />
        </ListItemLayout>
        <small v-show="posts.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Keine Posts angelegt</small>

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small>
                <b>{{filteredPosts.length}}</b> Posts
                <template v-if="scope !== null">für den <b>{{ scope }}-Bereich</b></template>
                <template v-if="scope === null">für alle Bereiche</template>
            </small>
        
            <div class="spacer"></div>
        </div>

        <template #fab>
            <button class="fab-button" aria-hidden="true" title="Neuer Post" @click="openItem()">add</button>
        </template>
    </AdminLayout>



    <Popup ref="deletePopup" title="Elemente löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteItems">
            <p>Möchten Sie wirklich <b>{{selection.length}} Elemente</b> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.deletePopup.close()" />
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen" />
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import PostInterface from '@/Interfaces/Post.js'
    
    import AdminLayout from '@/Layouts/Admin.vue'
    import ListItemLayout from '@/Components/Layout/ListItemLayout.vue'
    import ImageCard from '@/Components/Form/Card/ImageCard.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'

    const props = defineProps({
        posts: Array,
        categories: Array,
    })

    const posts_ = computed(() => props.posts)
    const posts = computed(() => posts_.value.map(post => new PostInterface(post)))



    // START: View Parameters
    const layout = ref('list')
    const isPreview = ref(false)
    // END: View Parameters



    // START: Filter
    const scope = ref(null)

    const filteredPosts = computed(() => {
        if (scope.value === null)
        {
            return posts.value
        }
        else
        {
            return posts.value.filter(p => p.scope === scope.value)
        }
    })
    // END: Filter



    // START: Selection
    const selection = ref([])

    const toggleSelection = (item) => {
        if (selection.value.includes(item.id))
        {
            selection.value = selection.value.filter(p => p !== item.id)
        }
        else
        {
            selection.value.push(item.id)
        }
    }

    const setSelection = (item) => {
        selection.value = [item.id]
    }

    const selectAll = () => {
        selection.value = itemObjects.map(i => i.id)
    }

    const deselectAll = () => {
        selection.value = []
    }
    // END: Selection



    // START: Editor
    const openItem = (item = null) => {
        Inertia.visit(route('admin.posts.editor', item?.id))
    }
    // END: Editor



    // START: Duplicate
    const duplicateItem = (item) => {
        useForm({returnTo: 'current'}).post(route('admin.posts.duplicate', item.id), {
            onSuccess: () => {
                deselectAll()
            },
        })
    }
    // END: Duplicate



    // START: Delete
    const deletePopup = ref(null)

    const openDeletePopup = (item = null) => {
        if (item) setSelection(item)
        deletePopup.value.open()
    }
    
    const deleteItems = () => {
        useForm({ids: selection.value}).delete(route('admin.posts.delete'), {
            onSuccess: () => {
                deletePopup.value.close()
                deselectAll()
            },
        })
    }
    // END: Delete
</script>

<style lang="sass" scoped>

    .icon-button
        display: flex
        align-items: center
        justify-content: center
        width: 3rem
        height: 2.5rem
        border-radius: 0
        cursor: pointer
        transition: all 100ms ease
        border: none
        outline: none
        background-color: transparent
        font-family: var(--font-icon)
        font-size: 1.3rem
        color: var(--color-text)
        padding: 0

        &:hover
            color: var(--color-heading)

        &.active
            color: black
            background-color: #0000000f
</style>