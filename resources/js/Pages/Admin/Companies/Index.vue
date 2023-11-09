<template>
    <AdminLayout :title="IPM.options.pageTitle">
        <Table
            show-create
            :columns="tableColumns"
            :actions="tableActions"
            :filter-settings="tableFilters"
            :items="IPM.items"
            :scope="IPM.tableScope"
            :loading="IPM.processing"
            v-model:selection="IPM.selection"
            v-model:filter="IPM.modelFilter"
            v-model:sort="IPM.modelSort"
            v-model:pagination="IPM.modelPagination"
            @request:refresh="IPM.fetch()"
            @request:create="IPM.open()"
        />

        <div class="flex v-center gap-1 wrap border-top padding-top-1 margin-top-2">
            <div class="spacer"></div>
            <IodButton is="a" target="_blank" variant="text" size="small" label="Exportieren" :href="route('admin.companies.export', {items: IPM.itemIds})"/>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { ref } from 'vue'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    const props = defineProps({
        roles: {
            type: Array,
            default: () => [],
        },
    })



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Firmen verwalten',
        scope: 'admin.companies.index',
        routes: {
            fetch: 'admin.companies.search',
            editor: 'admin.companies.editor',
            duplicate: 'admin.companies.duplicate',
            delete: 'admin.companies.delete',
        }
    }))

    IPM.value.fetch()



    const tableColumns = [
        {type: 'text', name: 'name', label: 'Name', valuePath: 'name', sortable: true, width: 300, resizeable: true, hideable: true},
        {type: 'text', name: 'legal_form', label: 'Rechtsform', valuePath: 'legal_form', sortable: true, width: 150, resizeable: true, hideable: true, transform: (value) => value || '-'},
        {type: 'text', name: 'description', label: 'Beschreibung', valuePath: 'description', sortable: true, width: 300, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'text', name: 'notes', label: 'Notizen', valuePath: 'notes', sortable: true, width: 300, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'date', name: 'created_at', label: 'Erstellt am', valuePath: 'created_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'date', name: 'updated_at', label: 'Aktualisiert am', valuePath: 'updated_at', sortable: true, width: 200, resizeable: true, hideable: true},
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
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Firmen gelöscht werden?'),
        },
    ]

    const tableFilters = [
        {
            type: 'select',
            multiple: true,
            name: 'legal_form',
            label: 'Rechtsform',
            values: [
                { value: 'gmbh', text: 'GmbH' },
                { value: 'gbr', text: 'GbR' },
                { value: 'ohg', text: 'OHG' },
                { value: 'kg', text: 'KG' },
                { value: 'ug', text: 'UG' },
                { value: 'ag', text: 'AG' },
                { value: 'eg', text: 'eG' },
                { value: 'ev', text: 'e.V.' },
                { value: 'sole-proprietor', text: 'Einzelunternehmen' },
                { value: 'freelancer', text: 'Freiberufler' },
                { value: 'other', text: 'Anders' },
            ],
        },
    ]
</script>

<style lang="sass" scoped>
</style>