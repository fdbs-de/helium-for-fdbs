<template>
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
            <small><b>{{ IPM.pagination.total }}</b> Roles</small>
    
            <div class="spacer"></div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { ref } from 'vue'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Rollen verwalten',
        scope: 'admin.roles.index',
        routes: {
            fetch: 'admin.roles.search',
            editor: 'admin.roles.editor',
            duplicate: 'admin.roles.duplicate',
            delete: 'admin.roles.delete',
        }
    }))

    IPM.value.fetch()



    const tableColumns = [
        {type: 'text', name: 'name', label: 'Name', valuePath: 'name', sortable: true, width: 300, resizeable: true, hideable: true},
        {type: 'tags', name: 'color', label: 'Farbe', valuePath: 'color', sortable: true, width: 200, resizeable: true, hideable: true, transform: (value, item) => {
            return [{icon: null, text: value || 'Keine Farbe', color: item.color || 'var(--color-text-soft)', variant: item.color ? 'filled' : 'contained', shape: 'pill'}]
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
            multiple: false,
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
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Rollen gelöscht werden?'),
        },
    ]
</script>

<style lang="sass" scoped>
</style>