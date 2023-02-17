<template>
    <div class="pi-table-wrapper">
        <div class="table-fixture-wrapper">
            <mui-input
                type="search"
                class="table-search-input"
                icon-left="search"
                placeholder="Suchen"
                :modelValue="getSearch"
                @update:modelValue="setSearch($event)"
            />
            <template v-if="selection.length">
                <div class="flex v-center margin-inline-1 padding-inline-1 background-soft radius-m" style="height: 2.5rem">
                    <span>
                        <b>{{ selection.length }} {{ selection.length === 1 ? 'Element' : 'Elemente' }}</b> ausgewählt
                    </span>
                </div>
                <IconButton icon="deselect" style="color: var(--color-text)" @click="deselectAll()"/>
                <IconButton icon="delete" style="color: var(--color-error)" @click="$emit('selection:delete')"/>
            </template>

            <div class="spacer"></div>

            <select class="table-page-size-select" :value="getPagination.size" @change="setPagination({size: parseInt($event.target.value)})">
                <option :value="10">10</option>
                <option :value="20">20</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
                <option :value="250">250</option>
                <option :value="1000000">Alle</option>
            </select>
        </div>



        <div class="table-empty-wrapper" v-show="!items.length">
            <div class="table-empty-text">Keine Einträge gefunden</div>
        </div>

        <div class="table-inner-wrapper" v-show="items.length">
            <div class="table-head">
                <div class="table-row" :style="`grid-template-columns: ${cssGridColumns}`">
                    <div class="table-column centered">
                        <mui-toggle class="table-checkbox" :modelValue="items.length && items.every(item => selection.includes(item.id))" @update:modelValue="$event ? selectAll() : deselectAll()"/>
                    </div>
                    <div class="table-column" v-for="column in columns">
                        <div class="column-text">{{ column.label }}</div>
                        <!-- <div class="column-sort-button" v-show="column.sortable">arrow_drop_down</div> -->
                    </div>
                </div>
            </div>

            <div class="table-body">
                <div class="table-row" :style="`grid-template-columns: ${cssGridColumns}`" v-for="item in items">
                    <div class="table-column centered">
                        <mui-toggle class="table-checkbox" :modelValue="getSelection.includes(item.id)" @update:modelValue="setSelection(item, $event)"/>
                    </div>
                    <div class="table-column" v-for="column in columns">
                        <TableColumn :type="column.type" :value="getValue(item, column)" />
                    </div>
                </div>
            </div>
        </div>



        <div class="table-pagination-wrapper" v-show="items.length">
            <TablePagination :modelValue="getPagination.page" @update:modelValue="setPagination({page: $event})" :size="getPagination.size" :total="getPagination.total"/>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed, defineEmits } from 'vue'

    import TableColumn from '@/Components/Form/Table/TableColumn.vue'
    import TablePagination from '@/Components/Form/Table/TablePagination.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'



    const props = defineProps({
        columns: Array,
        items: Array,
        filters: Array,
        pagination: Object,
        sort: Object,
        search: String,
        selection: Array,
        storageKey: String,
    })

    const emits = defineEmits([
        'update:search',
        'update:selection',
        'update:filters',
        'update:pagination',
        'update:sort',
        'request:refetch'
    ])



    const getSelection = computed(() => {
        return props.selection ?? []
    })

    const setSelection = (item, value) => {
        let selection = getSelection.value

        if (value)
        {
            if (!selection.includes(item.id))
            {
                selection.push(item.id)
            }
        }
        else
        {
            selection = selection.filter((id) => id !== item.id)
        }

        emits('update:selection', selection)
    }

    const selectAll = () => {
        let selection = []

        for (const item of props.items)
        {
            selection.push(item.id)
        }

        emits('update:selection', selection)
    }

    const deselectAll = () => {
        emits('update:selection', [])
    }



    const getSearch = computed(() => {
        return props.search ?? ''
    })

    const setSearch = (value) => {
        emits('update:search', value)
        emits('request:refetch', true)
    }



    const getPagination = computed(() => {
        return {
            page: 1,
            size: 20,
            total: 0,
            ...props.pagination
        }
    })

    const setPagination = (value) => {
        emits('update:pagination', {
            ...getPagination.value,
            ...value,
        })
        emits('request:refetch', true)
    }

    const sort = ref({
        column: null,
        direction: 'asc'
    })



    const cssGridColumns = computed(() => {
        return [
            '3.5rem',
            ...props.columns.map((column) => {
                return column.defaultWidth ? `${column.defaultWidth}px` : '1fr'
            })
        ].join(' ')
    })



    const getValue = (item, column) => {
        let path = column?.valuePath?.split('.') ?? []
        let value = item

        for (const part of path)
        {
            if (!value.hasOwnProperty(part))
            {
                value = null
                break
            }

            value = value[part]
        }

        
        if (column.transform)
        {
            value = column.transform(value, item)
        }

        return value
    }
</script>

<style lang="sass" scoped>
    .pi-table-wrapper
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
        display: grid
        grid-template-rows: auto auto

        .table-fixture-wrapper
            padding: 1rem
            display: flex
            align-items: center
            border-bottom: 1px solid var(--color-border)

            .table-search-input
                height: 2.5rem
                width: 300px
                border-radius: var(--radius-m)

            .spacer
                flex: 1

            .table-page-size-select
                height: 2.5rem
                border-radius: var(--radius-m)

        .table-empty-wrapper
            display: flex
            justify-content: center
            align-items: center
            height: 15rem
            padding: 1rem

            .table-empty-text
                font-size: 1rem

        .table-inner-wrapper
            display: grid
            grid-template-rows: auto auto
            overflow: hidden
            overflow-x: auto

            &::-webkit-scrollbar
                width: 3px
                height: 3px

            &::-webkit-scrollbar-track
                background: var(--color-background)

            &::-webkit-scrollbar-thumb
                background: #00000050
                border-radius: 0
                background-clip: content-box
                border: 0

                &:hover
                    background: var(--color-text)
                    border: 0
                    border-radius: 0

            .table-head
                border-bottom: 1px solid var(--color-border)

                .table-row
                    min-height: 3rem

                    .table-column
                        .column-text
                            padding-inline: .5rem
                            font-weight: bold

            .table-body
                padding-block: .5rem

                .table-row
                    &:hover
                        background-color: var(--color-background-soft)

            .table-row
                display: grid
                grid-template-rows: auto
                align-items: center
                min-height: 2.5rem

            .table-column
                display: flex
                align-items: center
                justify-content: flex-start
                user-select: none

                &.centered
                    justify-content: center

                .table-checkbox
                    --mui-background: var(--color-background)

                .column-sort-button
                    font-family: var(--font-icon)
                    font-size: 1.5rem
                    cursor: pointer

                    &:hover
                        color: var(--color-primary)

        .table-pagination-wrapper
            padding: 1rem
            display: flex
            align-items: center
            justify-content: center
            border-top: 1px solid var(--color-border)
</style>