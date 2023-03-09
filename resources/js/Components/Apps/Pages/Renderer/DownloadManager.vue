<template>
    <div class="pages-elem-wrapper flex vertical">
        <div class="flex padding-1">
            <mui-input type="search" class="searchbar" icon-left="search" placeholder="Suchen" v-model="search"/>
        </div>
        <div class="items-container flex vertical">
            <Loader class="loader" v-show="processing"/>

            <div class="flex h-8 h-center v-center" v-show="!items.length">
                Keine Dateien gefunden
            </div>

            <a class="item-wrapper flex" v-for="item in items" :href="item.path.url" target="_blank">
                <div class="icon" :style="'color: '+item.visual.color">{{ item.visual.icon }}</div>
                <span class="flex-1">{{ item.path.filename }}</span>
                <IconButton icon="download" is="a" :href="item.path.url" download/>
            </a>
        </div>
        <div class="flex padding-1 h-center">
            <TablePagination v-model="page" :size="size" :total="total"/>
        </div>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue'

    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import TablePagination from '@/Components/Form/Table/TablePagination.vue'
    import Loader from '@/Components/Form/Loader.vue'



    const props = defineProps({
        id: [Number, String],
    })



    const items = ref([])
    const processing = ref(false)

    const search = ref('')
    const page = ref(1)
    const size = ref(20)
    const total = ref(0)



    const fetch = async () => {
        processing.value = true

        try
        {
            let response = await axios.get(`/storage/private/${props.id}/index`, {
                params: {
                    page: page.value,
                    size: size.value,
                    search: search.value,
                },
            })

            if (!response?.data) throw new Error('No data returned')

            items.value = response?.data?.data ?? []
            total.value = response?.data?.total ?? 0
        }
        catch (error)
        {
            console.error(error)
        }
        
        processing.value = false
    }

    const throttledFetch = _.throttle(fetch, 300)



    // START: Watchers
    watch(() => props.id, () => fetch(), { immediate: true })
    watch(() => page.value, () => throttledFetch())
    watch(() => size.value, () => fetch())
    watch(() => search.value, () => throttledFetch())
    // END: Watchers
</script>

<style lang="sass" scoped>
    .pages-elem-wrapper
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)

        .searchbar
            flex: 1
            max-width: 300px
            height: 2.5rem

        .items-container
            display: flex
            flex-direction: column
            border: 0px solid var(--color-border)
            border-width: 1px 0
            position: relative
            padding: .5rem 0

            .loader
                position: absolute
                top: -1px
                left: 0
                width: 100%
                height: 2px
                z-index: 1

        .item-wrapper
            color: var(--color-text)
            min-height: 3rem
            padding: .25rem 1rem
            display: flex
            gap: 1rem
            line-height: 1.3
            align-items: center
            width: 100%

            &:hover
                color: var(--color-heading)
                background: var(--color-background-soft)

        .icon
            position: relative
            display: flex
            align-items: center
            font-family: var(--font-icon)
            justify-content: center
            height: 2rem
            width: 2rem
            font-size: 1.5rem
            line-height: 1
            border-radius: var(--radius-s)
            
            &::after
                content: ''
                position: absolute
                top: 0
                left: 0
                width: 100%
                height: 100%
                border-radius: inherit
                background: currentColor
                opacity: .2
</style>