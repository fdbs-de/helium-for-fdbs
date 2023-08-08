<template>
    <Popup title="Rolle suchen" ref="popup" style="--max-width: 500px">
        <div class="flex vertical gap-1 padding-1">
            <mui-input type="search" ref="searchInput" v-model="form.filter.search" label="Rolle suchen" @update:modelValue="fetch"/>
            <div class="flex vertical gap-0-5">
                <button class="select-button" type="button" v-for="item in form.items" @click="done(item)">
                    <span class="text name">{{ item.name }}</span>
                </button>
            </div>
        </div>
    </Popup>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'
    import { ref, nextTick } from 'vue'

    import Popup from '@/Components/Form/Popup.vue'
    import Icon from '@/Components/Icon.vue'


    
    const form = useForm({
        filter: {
            search: '',
            exclude: [],
            scope: 'user-exact'
        },
        sort: {
            field: 'name',
            order: 'asc',
        },
        pagination: {
            page: 1,
            size: 25,
            total: 0,
        },
        items: [],
    })

    const popup = ref(null)
    const searchInput = ref(null)
    const callback = ref(null)
    


    const open = (cb = () => {}, filter = {}, sort = {}) => {
        // Set the callback function
        callback.value = cb

        // Reset the form
        form.reset()

        // Set the filters
        form.filter = {...form.filter ,...filter}

        // Set sort
        form.sort = {...form.sort, ...sort}

        // Fetch the items
        fetch()

        // Open the popup
        popup.value.open()

        // Focus the search input on next tick
        nextTick(() => searchInput.value.focus())
        // setTimeout(() => searchInput.value.focus(), 1)
    }



    const fetch = async () => {
        form.processing = true

        try
        {
            let response = await axios.get(route('admin.search.roles', {...form.data(), items: []}))

            if (!response?.data) throw new Error('No data returned')

            form.items = response?.data?.data ?? []
            form.pagination.total = response?.data?.total ?? 0
        }
        catch (error)
        {
            console.error(error)
        }
        
        form.processing = false
    }

    

    const done = (item) => {
        // Call the callback function
        callback.value?.(item)

        // Close the popup
        popup.value.close()
    }



    defineExpose({
        open
    })
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .select-button
        font-family: inherit
        font-size: inherit
        font-weight: inherit
        color: inherit
        text-align: left
        height: 3rem
        border-radius: var(--radius-m)
        background: var(--color-background-soft)
        border: 1px solid transparent
        display: flex
        gap: 1rem
        padding: .25rem .5rem
        align-items: center

        &:hover
            border: 1px solid var(--color-background-soft)
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)

        .profile-image
            height: 2rem

        .text
            white-space: nowrap
            overflow: hidden
            text-overflow: ellipsis

        .name
            font-weight: bold

        .username
            font-size: .8rem
            width: 200px
            flex: none
</style>