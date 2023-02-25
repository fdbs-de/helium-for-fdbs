<template>
    <Head :title="IPM.options.pageTitle" />

    <AdminLayout :title="IPM.options.pageTitle" :loading="IPM.processing">
        <Table
            :columns="tableColumns"
            :actions="tableActions"
            :items="IPM.items"
            :scope="IPM.tableScope"
            v-model:selection="IPM.selection"
            v-model:filter="IPM.modelFilter"
            v-model:sort="IPM.modelSort"
            v-model:pagination="IPM.modelPagination"
            @request:refresh="IPM.fetch()"
        />

        <div class="flex v-center gap-1 wrap border-top padding-top-1 margin-top-2">
            <small><b>{{IPM.pagination.total}}</b> Seiten</small>
        
            <div class="spacer"></div>
        </div>

        <template #fab>
            <button class="fab-button" aria-hidden="true" title="Neue Seite" @click="openStorePopup()">add</button>
        </template>
    </AdminLayout>



    <Popup title="Neue Seite erstellen" ref="storePopup">
        <form @submit.prevent="IPM.store(storeForm.data())">
            <mui-input v-model="storeForm.title" label="Titel" />
            <mui-input v-model="storeForm.slug" label="Slug" />
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.storePopup.close()" />
                <mui-button type="submit" variant="filled" label="Neu Erstellen" />
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
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
        {type: 'text', name: 'language', label: 'Sprache', valuePath: 'language', sortable: true, width: 100, resizeable: true, hideable: true},
        {type: 'date', name: 'created_at', label: 'Erstellt am', valuePath: 'created_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'date', name: 'updated_at', label: 'Geändert am', valuePath: 'updated_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'tags', name: 'status', label: 'Status', valuePath: 'status', sortable: false, width: 150, resizeable: true, hideable: true, transform: (value, item) => {
            switch (value)
            {
                case 'draft':
                    return [{icon: null, text: 'Entwurf', color: 'var(--color-text)', variant: 'filled', shape: 'pill'}]
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
            color: 'var(--color-heading)',
            individual: true,
            multiple: false,
            triggerOnRowClick: true,
            isAvailable: () => true,
            run: (items) => IPM.value.open(items[0]),
        },
        {
            icon: 'content_copy',
            text: 'Duplizieren',
            color: 'var(--color-heading)',
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
    })

    const openStorePopup = () => {
        storeForm.reset()
        storePopup.value.open()
    }
</script>

<style lang="sass" scoped>
</style>