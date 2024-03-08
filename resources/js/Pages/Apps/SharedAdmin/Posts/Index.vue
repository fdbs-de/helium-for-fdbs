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
    </AdminLayout>
</template>

<script setup>
    import { ref } from 'vue'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    const props = defineProps({
        app: String,
        categories: Array,
    })



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Posts verwalten',
        scope: 'admin.posts.index',
        routes: {
            fetch: `admin.${props.app}.posts.search`,
            editor: `admin.${props.app}.posts.editor`,
            duplicate: `admin.${props.app}.posts.duplicate`,
            delete: `admin.${props.app}.posts.delete`,
        }
    }))

    IPM.value.fetch()



    const tableColumns = [
        {type: 'text', name: 'title', label: 'Titel', valuePath: 'title', sortable: true, width: 300, resizeable: true, hideable: true},
        {type: 'text', name: 'slug', label: 'Slug', valuePath: 'slug', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'tags', name: 'post_category', label: 'Kategorie', valuePath: 'post_category', sortable: false, width: 200, resizeable: true, hideable: true, transform: (value, item) => {
            if (!value) return [{icon: null, text: 'Keine Kategorie', color: 'var(--color-text-soft)', variant: 'contained', shape: 'pill'}]

            return [{icon: value.icon, text: value.name, color: value.color, variant: 'contained', shape: 'pill'}]
        }},
        {type: 'tags', name: 'status', label: 'Status', valuePath: 'status', sortable: false, width: 150, resizeable: true, hideable: true, transform: (value, item) => {
            switch (value)
            {
                case 'draft':
                    return [{icon: null, text: 'Entwurf', color: 'var(--color-text-soft)', variant: 'contained', shape: 'pill'}]
                case 'pending':
                    return [{icon: null, text: 'Zur Freigabe', color: 'var(--color-warning)', variant: 'contained', shape: 'pill'}]
                case 'published':
                    return [{icon: null, text: 'Veröffentlicht', color: 'var(--color-success)', variant: 'contained', shape: 'pill'}]
                case 'hidden':
                    return [{icon: null, text: 'Versteckt', color: 'var(--color-error)', variant: 'contained', shape: 'pill'}]
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
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Einträge gelöscht werden?'),
        },
    ]

    const tableFilters = [
        {
            type: 'select',
            multiple: true,
            name: 'status',
            label: 'Status',
            values: [
                {text: 'Entwurf', value: 'draft'},
                {text: 'Zur Freigabe', value: 'pending'},
                {text: 'Veröffentlicht', value: 'published'},
                {text: 'Versteckt', value: 'hidden'},
            ]
        },
        {
            type: 'select',
            multiple: true,
            name: 'categories',
            label: 'Kategorien',
            values: props.categories.map(e => ({text: e.name, value: e.name})),
        },
    ]
</script>

<style lang="sass" scoped>
</style>