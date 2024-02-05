<template>
    <VDropdown placement="bottom" v-if="filterSettings && filterSettings.length">
        <IodIconButton type="button" variant="text" size="small" icon="filter_list" v-tooltip="'Filter'"/>
        
        <template #popper>
            <div class="flex vertical padding-block-0-5">
                <template v-for="row in filterSettings">
                    <VDropdown placement="right-start" v-if="row.type == 'select'">
                        <button type="button" class="row-button">
                            <span class="text flex-1">
                                {{ row.label }}:
                                <b v-tooltip="displayValues(row, filter)">{{ displayValues(row, filter) || '---' }}</b>
                            </span>
                            <IodIcon icon="chevron_right"/>
                        </button>

                        <template #popper>
                            <div class="flex vertical padding-block-0-5 max-h-26 small-scrollbar">
                                <IodToggle
                                    class="w-20 h-2-5"
                                    v-for="option in row.values"
                                    :label="option.text"
                                    :modelValue="isFilterSet(row, filter, option.value)"
                                    @update:modelValue="setFilter(row, filter, option.value, $event)"
                                />
                            </div>
                        </template>
                    </VDropdown>
                </template>
            </div>
        </template>
    </VDropdown>
</template>

<script setup>
    const props = defineProps({
        filterSettings: {
            type: Array,
            default: () => [],
        },
        filter: {
            type: Object,
            default: () => ({}),
        },
    })

    function displayValues(row, filter)
    {
        if (row.multiple)
        {
            return row.values.filter(option => filter[row.name]?.includes(option.value))?.map(option => option.text)?.join(', ')
        }

        return row.values.find(option => option.value == filter[row.name])?.text
    }

    function setFilter(row, filter, value, toggleState)
    {
        if (row.multiple)
        {
            if (toggleState)
            {
                filter[row.name] = filter[row.name] || []
                filter[row.name].push(value)
            }
            else
            {
                filter[row.name] = filter[row.name].filter(e => e != value)
            }

            filter[row.name] = filter[row.name].length ? filter[row.name] : undefined
        }
        else
        {
            if (toggleState)
            {
                filter[row.name] = value
            }
            else
            {
                filter[row.name] = undefined
            }
        }
    }

    function isFilterSet(row, filter, value)
    {
        if (row.multiple)
        {
            return filter[row.name]?.includes(value)
        }

        return filter[row.name] == value
    }
</script>

<style lang="sass" scoped>
    .iod-button
        --local-color-background: var(--color-text) !important

    .row-button
        text-align: left
        display: flex
        align-items: center
        padding: 0 1rem
        gap: .5rem
        height: 3rem
        background: none
        border: none
        cursor: pointer
        user-select: none
        color: var(--color-text-soft)
        font-family: var(--font-interface)
        font-size: .9rem
        width: 20rem
        transition: all 100ms

        &:hover
            background: var(--color-background-soft)

            .iod-icon
                transform: translateX(4px)

        .text
            white-space: nowrap
            overflow: hidden
            text-overflow: ellipsis

        .iod-icon
            transition: all 100ms
</style>