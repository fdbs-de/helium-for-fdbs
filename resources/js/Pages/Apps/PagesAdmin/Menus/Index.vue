<template>
    <Head :title="IPM.options.pageTitle" />

    <AdminLayout :title="IPM.options.pageTitle" :loading="IPM.processing">
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
            @request:create="IPM.open()"
        />

        <div class="flex v-center gap-1 wrap border-top padding-top-1 margin-top-2">
            <small><b>{{IPM.pagination.total}}</b> Einträge</small>
        
            <div class="spacer"></div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Menüs verwalten',
        scope: 'admin.pages.menus',
        routes: {
            fetch: `admin.pages.menus.search`,
            editor: `admin.pages.menus.editor`,
            duplicate: `admin.pages.menus.duplicate`,
            delete: `admin.pages.menus.delete`,
        }
    }))

    IPM.value.fetch()



    const tableColumns = [
        {type: 'text', name: 'name', label: 'Name', valuePath: 'name', sortable: true, width: 300, resizeable: true, hideable: true},
        {type: 'text', name: 'default_for', label: 'Standard für', valuePath: 'default_for', sortable: false, width: 200, resizeable: true, hideable: true, transform: (value, item) => value ?? '---'},
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
        {type: 'date', name: 'created_at', label: 'Erstellt am', valuePath: 'created_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'date', name: 'updated_at', label: 'Geändert am', valuePath: 'updated_at', sortable: true, width: 200, resizeable: true, hideable: true},
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
            run: (items) => IPM.value.open(items[0]),
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
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Menüs gelöscht werden?'),
        },
    ]
</script>

<style lang="sass" scoped>
</style>