<template>
    <Head :title="IPM.options.pageTitle" />

    <AdminLayout :title="IPM.options.pageTitle" :loading="IPM.processing">
        <div class="flex v-center margin-bottom-2">
            <div class="spacer"></div>
            <mui-button as="a" label="Editor Öffnen" :href="route('admin.pages.pages.editor')" target="_blank"/>
        </div>
        <Table
            show-create
            :columns="tableColumns"
            :actions="tableActions"
            :items="IPM.items"
            :scope="IPM.tableScope"
            v-model:selection="IPM.selection"
            v-model:filter="IPM.modelFilter"
            v-model:sort="IPM.modelSort"
            v-model:pagination="IPM.modelPagination"
            @request:refresh="IPM.fetch()"
            @request:create="openStorePopup()"
        />

        <div class="flex v-center gap-1 wrap border-top padding-top-1 margin-top-2">
            <small><b>{{IPM.pagination.total}}</b> Seiten</small>
        
            <div class="spacer"></div>
        </div>
    </AdminLayout>



    <Popup title="Neue Seite erstellen" ref="storePopup">
        <form class="flex vertical gap-1 padding-1" @submit.prevent="IPM.store(storeForm.data())">
            <IodInput v-model="storeForm.title" label="Titel" />
            <IodInput v-model="storeForm.slug" label="Slug">
                <template #right>
                    <IodIconButton type="button" icon="auto_awesome" variant="text" class="input-button" @click="generateSlug()" v-tooltip.right="'Aus Titel generieren'"/>
                </template>
            </IodInput>
            <div class="flex gap-1">
                <IodButton class="flex-1" type="button" variant="contained" label="Abbrechen" @click="$refs.storePopup.close()" />
                <IodButton class="flex-1" type="submit" variant="filled" label="Neu Erstellen" />
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'
    import { slugify } from '@/Utils/String'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Seiten verwalten',
        scope: 'admin.pages.pages.index',
        routes: {
            fetch: 'admin.pages.pages.search',
            store: 'admin.pages.pages.store',
            editor: 'admin.pages.pages.editor',
            duplicate: 'admin.pages.pages.duplicate',
            delete: 'admin.pages.pages.delete',
        }
    }))

    IPM.value.addEventListener('store', () => {
        storePopup.value.close()
    })

    IPM.value.fetch()



    const tableColumns = [
        {type: 'text', name: 'title', label: 'Titel', valuePath: 'title', sortable: true, width: 300, resizeable: true, hideable: true},
        {type: 'text', name: 'slug', label: 'Slug', valuePath: 'slug', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'text', name: 'renderer', label: 'Renderer', valuePath: 'renderer', sortable: false, width: 200, resizeable: true, hideable: true},
        {type: 'text', name: 'language', label: 'Sprache', valuePath: 'language', sortable: true, width: 100, resizeable: true, hideable: true},
        {type: 'date', name: 'created_at', label: 'Erstellt am', valuePath: 'created_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'date', name: 'updated_at', label: 'Geändert am', valuePath: 'updated_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'tags', name: 'status', label: 'Status', valuePath: 'status', sortable: false, width: 150, resizeable: true, hideable: true, transform: (value, item) => {
            switch (value)
            {
                case 'draft':
                    return [{icon: null, text: 'Entwurf', color: 'var(--color-text-soft)', variant: 'filled', shape: 'pill'}]
                case 'pending':
                    return [{icon: null, text: 'Zur Freigabe', color: 'var(--color-warning)', variant: 'filled', shape: 'pill'}]
                case 'published':
                    return [{icon: null, text: 'Veröffentlicht', color: 'var(--color-success)', variant: 'filled', shape: 'pill'}]
                case 'hidden':
                    return [{icon: null, text: 'Versteckt', color: 'var(--color-error)', variant: 'filled', shape: 'pill'}]
            }
        }},
    ]

    const tableActions = [
        {
            icon: 'edit',
            text: 'Bearbeiten',
            color: 'var(--color-text)',
            individual: true,
            multiple: true,
            triggerOnRowClick: true,
            isAvailable: () => true,
            run: (items) => IPM.value.openMultiple(items, 't', 'pages-'),
        },
        {
            icon: 'content_copy',
            text: 'Duplizieren',
            color: 'var(--color-text)',
            individual: true,
            multiple: false,
            triggerOnRowClick: false,
            isAvailable: () => true,
            run: (items) => IPM.value.duplicate(items[0]),
        },
        {
            icon: 'delete',
            text: 'Löschen',
            color: 'var(--color-error)',
            individual: true,
            multiple: true,
            triggerOnRowClick: false,
            isAvailable: () => true,
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Seiten gelöscht werden?'),
        },
    ]



    const storePopup = ref(null)

    const storeForm = useForm({
        title: '',
        slug: '',
        renderer: 'block-builder',
        is_component: false,
    })

    const openStorePopup = () => {
        storeForm.reset()
        storePopup.value.open()
    }



    // START: Miscelaneous
    const generateSlug = () => {
        storeForm.slug = slugify(storeForm.title)
    }
    // END: Miscelaneous
</script>

<style lang="sass" scoped>

</style>