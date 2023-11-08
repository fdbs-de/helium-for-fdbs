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
        {type: 'text', name: 'username', label: 'Nutzername', valuePath: 'username', sortable: true, width: 150, resizeable: true, hideable: true, transform: (value) => value || '-'},
        {type: 'text', name: 'email', label: 'Email', valuePath: 'email', sortable: true, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'text', name: 'roles', label: 'Rollen', valuePath: 'roles', sortable: false, width: 200, resizeable: true, hideable: true, transform: (value) => {
            return value.map(e => e.name).join(', ') || '-'
        }},
        {type: 'text', name: 'profiles', label: 'Profile', valuePath: 'profiles', sortable: false, width: 100, resizeable: true, hideable: true, transform: (value) => {
            let profiles = []
            if (value.customer) profiles.push('Kunde')
            if (value.employee) profiles.push('Personal')
            return profiles.join('; ') || '-'
        }},
        {type: 'date', name: 'created_at', label: 'Registriert am', valuePath: 'created_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'date', name: 'email_verified_at', label: 'Verifikation am', valuePath: 'email_verified_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'tags', name: 'status', label: 'Status', valuePath: 'status', sortable: false, width: 100, resizeable: true, hideable: true, transform: (value, item) => {
            if (item.is_enabled) return [{icon: null, text: 'Aktiv', color: 'var(--color-success)', variant: 'filled', shape: 'pill'}]
            return [{icon: null, text: 'Ausstehend', color: 'var(--color-warning)', variant: 'filled', shape: 'pill'}]
        }},
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
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Benutzer gelöscht werden?'),
        },
    ]

    const tableFilters = [
        {
            type: 'select',
            multiple: true,
            name: 'profiles',
            label: 'Profile',
            values: [
                {text: 'Kunde', value: 'customer'},
                {text: 'Personal', value: 'employee'},
            ],
        },
        {
            type: 'select',
            multiple: true,
            name: 'roles',
            label: 'Rollen',
            values: props.roles.map(e => ({text: e.name, value: e.name})),
        },
        {
            type: 'select',
            multiple: true,
            name: 'newsletter',
            label: 'Newsletter',
            values: [
                {text: 'Allgemein', value: 'generic'},
                {text: 'Kunden', value: 'customer'},
            ],
        },
    ]
</script>

<style lang="sass" scoped>
</style>