<template>
    <!-- <AdminLayout title=""> -->
    <AdminLayout :title="IPM.options.pageTitle">
        <Table
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
            <IodButton is="a" target="_blank" variant="text" size="small" label="Exportieren" :href="route('admin.fairs.export', {items: IPM.itemIds, type: 'entries'})"/>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    const props = defineProps({
        scopes: {
            type: Array,
            default: () => [],
        },
        keys: {
            type: Array,
            default: () => [],
        },
    })



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Event Anmeldungen',
        scope: 'admin.fairs.index',
        routes: {
            fetch: 'admin.fairs.search',
            // editor: 'admin.users.editor',
            // duplicate: 'admin.users.duplicate',
            delete: 'admin.fairs.delete',
        }
    }))

    IPM.value.fetch()



    const tableColumns = [
        {type: 'text', name: 'scope', label: 'Event', valuePath: 'scope', sortable: true, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-'},
        {type: 'text', name: 'key', label: 'Anmeldungstyp', valuePath: 'key', sortable: true, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-'},
        {type: 'text', name: 'value.company', label: 'Firma', valuePath: 'value.company', sortable: false, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'text', name: 'value.name', label: 'Ansprechpartner', valuePath: 'value.name', sortable: false, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'text', name: 'value.email', label: 'Email', valuePath: 'value.email', sortable: false, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'text', name: 'value.phone', label: 'Telefonnummer', valuePath: 'value.phone', sortable: false, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'date', name: 'created_at', label: 'Eingegangen am', valuePath: 'created_at', sortable: true, width: 200, resizeable: true, hideable: true},
    ]

    const tableActions = [
        {
            icon: 'delete',
            text: 'Löschen',
            color: 'var(--color-error)',
            individual: true,
            multiple: true,
            triggerOnRowClick: false,
            isAvailable: () => true,
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Anmeldungen gelöscht werden?'),
        },
    ]

    const tableFilters = [
        {
            type: 'select',
            multiple: true,
            name: 'scope',
            label: 'Event',
            values: props.scopes.map(e => ({text: e, value: e})),
        },
        {
            type: 'select',
            multiple: true,
            name: 'key',
            label: 'Anmeldungstyp',
            values: props.keys.map(e => ({text: e, value: e})),
        },
    ]
</script>

<style lang="sass" scoped>
</style>