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
            <small><b>{{IPM.pagination.total}}</b> Einträge</small>
        
            <div class="spacer"></div>
        </div>
    </AdminLayout>

    <Popup title="Kategorien löschen" ref="deletePopup">
        <form class="flex vertical" @submit.prevent="deleteItems()">
            <div class="flex vertical gap-1 padding-1 padding-block-2">
                <span>
                    Es werden <b>{{items.length}}</b> Kategorien gelöscht.<br>
                    <b>Was soll mit Posts geschehen, die diese Kategorien verwenden? </b>
                </span>
                <div>
                    <select v-model="replacement">
                        <option :value="null">Kategorien aus Posts entfernen</option>
                        <option v-for="option in replacementOptions" :value="option.id">Ersetzen durch: {{ option.name }}</option>
                    </select>
                </div>
            </div>

            <div class="flex v-center gap-1 padding-1 background-soft" style="border-radius: 0 0 var(--radius-m) var(--radius-m)">
                <div class="spacer"></div>
                <mui-button label="Endgültig löschen" color="error" variant="filled" :disabled="!items.length"/>
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { ref, computed } from 'vue'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Table from '@/Components/Form/Table/Table.vue'
    import Popup from '@/Components/Form/Popup.vue'



    const props = defineProps({
        categoriesAvailableAsReplacement: Array,
        app: String,
    })



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Kategorien verwalten',
        scope: 'admin.post-categories.index',
        routes: {
            fetch: `admin.${props.app}.categories.search`,
            editor: `admin.${props.app}.categories.editor`,
            duplicate: `admin.${props.app}.categories.duplicate`,
            delete: `admin.${props.app}.categories.delete`,
        }
    }))

    IPM.value.fetch()



    const tableColumns = [
        {type: 'tags', name: 'name', label: 'Name', valuePath: 'name', sortable: true, width: 300, resizeable: true, hideable: true, transform: (value, item) => {
            return [{icon: item.icon || 'category', text: value, color: item.color || 'var(--color-text-soft)', variant: item.color ? 'filled' : 'contained', shape: 'pill'}]
        }},
        // {type: 'text', name: 'name', label: 'Name', valuePath: 'name', sortable: true, width: 300, resizeable: true, hideable: true},
        {type: 'text', name: 'slug', label: 'Slug', valuePath: 'slug', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'text', name: 'post_count', label: 'Verwendungen', valuePath: 'post_count', sortable: false, width: 200, resizeable: true, hideable: true},
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
            run: (items) => openDeletePopup(items),
        },
    ]



    // START: handle category deletion
    const deletePopup = ref(null)
    const items = ref([])
    const replacement = ref(null)
    const replacementOptions = ref([])

    const openDeletePopup = (ids) => {
        items.value = ids
        replacement.value = null
        replacementOptions.value = props.categoriesAvailableAsReplacement.filter(item =>  !items.value.includes(item.id))
        deletePopup.value.open()
    }

    const deleteItems = () => {
        IPM.value.delete(items.value, 'Sollen {{count}} Einträge gelöscht werden?', {needsConfirmation: false, replacement: replacement.value})
        deletePopup.value.close()
    }
    // END: handle category deletion
</script>

<style lang="sass" scoped>
</style>