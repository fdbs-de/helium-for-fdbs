<template>
    <div class="pi-table-wrapper">
        <div class="table-fixture-wrapper">
            <mui-input
                type="search"
                class="table-search-input"
                icon-left="search"
                placeholder="Suchen"
                :modelValue="getFilter.search"
                @update:modelValue="setFilter($event)"
            >
                <template #right>
                    <!-- <IconButton icon="filter_list"/> -->
                </template>
            </mui-input>
            
            <template v-if="selection.length">
                <div class="flex v-center padding-inline-1 background-soft radius-m" style="height: 2.5rem">
                    <span>
                        <b>{{ selection.length }} {{ selection.length === 1 ? 'Element' : 'Elemente' }}</b> ausgewählt
                    </span>
                </div>
                <div class="flex v-center">
                    <IconButton icon="deselect" style="color: var(--color-text)" v-tooltip="'Alles abwählen'" @click="deselectAll()"/>
                    <IconButton v-for="action in multipleActions" :icon="action.icon" :style="'color: ' + action.color" v-tooltip="action.text" @click.stop="action.run(selection)"/>
                </div>
            </template>
            
            <div class="spacer"></div>

            <div class="flex v-center background-soft radius-m">
                <VDropdown placement="bottom">
                    <IconButton icon="discover_tune" v-tooltip="'Spalten ein- & ausblenden'"/>
                    <template #popper>
                        <div class="flex vertical padding-1">
                            <mui-toggle
                                style="--mui-background: var(--color-background)"
                                v-for="column in columns.filter(e => e.hideable)"
                                :label="column.label"
                                v-model="column.show" />
                        </div>
                    </template>
                </VDropdown>

                <select class="table-page-size-select" :value="getPagination.size" @change="setPagination({size: parseInt($event.target.value)})" v-tooltip="'Einträge pro Seite'">
                    <option :value="10">10</option>
                    <option :value="20">20</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                    <option :value="250">250</option>
                    <option :value="1000000">Alle</option>
                </select>
            </div>

            <VDropdown placement="bottom-end">
                <IconButton icon="more_vert" v-tooltip="'Mehr...'"/>
                <template #popper>
                    <div class="flex vertical padding-1">
                        <mui-button @click="$emit('request:refresh')" icon="refresh" label="Manuel aktualisieren"/>
                    </div>
                </template>
            </VDropdown>
        </div>



        <div class="table-empty-wrapper" v-show="!items.length">
            <div class="table-empty-text">Keine Einträge gefunden</div>
        </div>

        <div class="table-inner-wrapper" v-show="items.length">
            <div class="table-head">
                <div class="table-row">
                    <div class="table-column centered w-3">
                        <mui-toggle
                            class="table-checkbox"
                            :modelValue="items.length && items.every(item => selection.includes(item.id))"
                            @update:modelValue="$event ? selectAll() : deselectAll()"
                            v-tooltip="'Alle auswählen'"
                            />
                    </div>
                    <div class="table-column" v-for="column in columns.filter(e => e.show)" :class="{
                        'resizeable': column.resizeable,
                        'resizing': column.resizing,
                        'sortable': column.sortable,
                    }" :style="`width: ${column.width}px;`">
                        <!-- <div class="column-sort-indicator" v-show="column.sortable">arrow_drop_down</div> -->
                        <div class="column-label" v-tooltip="column.label">{{ column.label }}</div>
                        <div class="column-resize-handle" @mousedown="startResize($event, column)"></div>
                    </div>
                    <div class="table-column actions"></div>
                </div>
            </div>

            <div class="table-body">
                <div class="table-row" v-for="item in items" @click="rowClick(item)">
                    <div class="table-column centered w-3">
                        <mui-toggle class="table-checkbox" :modelValue="getSelection.includes(item.id)" @click.stop @update:modelValue="setSelection(item, $event)"/>
                    </div>
                    <div class="table-column" v-for="column in columns.filter(e => e.show)" :style="`width: ${column.width}px;`">
                        <TableColumn :type="column.type" :value="getValue(item, column)" />
                    </div>
                    <div class="table-column actions">
                        <div class="button-container">
                            <IconButton v-for="action in individualActions" :icon="action.icon" :style="'color: white; background: '+action.color" v-tooltip="action.text" @click.stop="action.run([item.id])"/>
                        </div>
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
    import { ref, computed, watch, defineEmits } from 'vue'
    import LocalSetting from '@/Classes/Managers/LocalSetting'

    import TableColumn from '@/Components/Form/Table/TableColumn.vue'
    import TablePagination from '@/Components/Form/Table/TablePagination.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'



    const props = defineProps({
        columns: Array,
        actions: Array,
        items: Array,
        filter: Object,
        pagination: Object,
        sort: Object,
        selection: Array,
        scope: String,
    })

    const emits = defineEmits([
        'update:selection',
        'update:filter',
        'update:pagination',
        'update:sort',
        'request:refresh'
    ])



    const individualActions = computed(() => {
        return props.actions.filter(action => action.individual)
    })

    const multipleActions = computed(() => {
        return props.actions.filter(action => action.multiple)
    })

    const rowClick = (item) => {
        for (const action of individualActions.value.filter(action => action.triggerOnRowClick))
        {
            action.run([item?.id])
        }
    }



    // START: Selection
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
    // END: Selection



    // START: Filter
    const getFilter = computed(() => {
        return {
            search: '',
            ...props.filter
        }
    })

    const setFilter = (value) => {
        emits('update:filter', {
            ...getFilter.value,
            ...value,
        })
    }
    // END: Filter



    // START: Sort
    const getSort = computed(() => {
        return {
            field: 'created_at',
            order: 'desc',
            ...props.sort
        }
    })

    const setSort = (value) => {
        emits('update:sort', {
            ...getSort.value,
            ...value,
        })
    }
    // END: Sort



    // START: Pagination
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
    }
    // END: Pagination



    const columns = ref([])

    watch(() => props.columns, () => {
        columns.value = props.columns.map(column => { return {
            ...column,
            resizing: false,
            show: LocalSetting.get(props.scope, 'show.'+column.name, true),
            width: LocalSetting.get(props.scope, 'width.'+column.name, column.width ?? 50),
        }})
    },{
        immediate: true,
        deep: true,
    })

    watch(() => columns.value, () => {
        for (const column of columns.value)
        {
            LocalSetting.set(props.scope, 'show.'+column.name, column.show)
            LocalSetting.set(props.scope, 'width.'+column.name, column.width)
        }
    },{
        deep: true,
    })



    const startResize = (event, column) => {
        let startX = event.clientX
        let startWidth = column.width ?? 100
        column.resizing = true
        
        const mouseMove = (event) => {
            let diff = event.clientX - startX
            let newWidth = startWidth + diff
            
            // Limit the width to 80px - 2000px
            column.width = Math.min(Math.max(newWidth, 80), 2000)
        }

        const mouseUp = () => {
            document.removeEventListener('mousemove', mouseMove)
            document.removeEventListener('mouseup', mouseUp)

            column.resizing = false
        }

        document.addEventListener('mousemove', mouseMove)
        document.addEventListener('mouseup', mouseUp)
    }



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

        .table-checkbox
            --mui-background: var(--color-background)

        .table-fixture-wrapper
            padding: 1rem
            display: flex
            align-items: center
            flex-wrap: wrap
            gap: 1rem
            border-bottom: 1px solid var(--color-border)

            .table-search-input
                height: 2.5rem
                width: 100%
                max-width: 300px
                min-width: 100px
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

            .table-row
                display: flex
                align-items: center
                min-height: 2.5rem
                position: relative

            .table-column
                display: flex
                align-items: center
                justify-content: flex-start
                user-select: none
                position: relative
                overflow: hidden

                &.resizeable
                    .column-resize-handle
                        display: block

                    &:hover
                        background: var(--color-background-soft)

                &.resizing
                    background: var(--color-background-soft)

                    .column-resize-handle
                        opacity: 1

                &.centered
                    justify-content: center

                &.actions
                    flex: 1
                    justify-content: flex-end
                    position: sticky
                    right: 0
                    z-index: 100
                    opacity: 0
                    overflow: hidden
                    transition: all 100ms

                    .button-container
                        display: flex
                        align-items: center
                        padding: .25rem
                        gap: .25rem
                        background: var(--color-background-soft)
                        transform-origin: right
                        transform: translateX(1rem)
                        transition: all 100ms
                        border-radius: var(--radius-m) 0 0 var(--radius-m)

                        > button
                            border-radius: var(--radius-s)
                            height: 2rem
                            width: 2rem

                .column-sort-indicator
                    font-family: var(--font-icon)
                    font-size: 1.5rem

                .column-label
                    padding-inline: .75rem
                    font-weight: bold
                    overflow: hidden
                    text-overflow: ellipsis
                    white-space: nowrap
                    font-size: .8rem
                    text-transform: uppercase
                    opacity: .8

                .column-resize-handle
                    width: .5rem
                    height: calc(100% - .5rem)
                    border-radius: 4rem
                    cursor: col-resize
                    position: absolute
                    right: .25rem
                    top: .25rem
                    background: var(--color-heading)
                    z-index: 10
                    display: none
                    opacity: 0

                    &:hover
                        opacity: 1

            .table-head
                border-bottom: 1px solid var(--color-border)

                .table-row
                    height: 3rem

                    .table-column
                        height: 2.5rem
                        border-radius: var(--radius-s)

                        &.actions
                            background: none

            .table-body
                padding-block: .5rem

                .table-row
                    &:hover
                        background-color: var(--color-background-soft)

                        .table-column.actions
                            opacity: 1

                            .button-container
                                transform: translateX(0)

                    .table-column
                        align-self: stretch



        .table-pagination-wrapper
            padding: 1rem
            display: flex
            align-items: center
            justify-content: center
            border-top: 1px solid var(--color-border)
</style>