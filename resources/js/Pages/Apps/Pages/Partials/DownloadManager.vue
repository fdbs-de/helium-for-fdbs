<template>
    <div class="pages-elem-wrapper flex vertical">
        <div class="flex padding-1 border-bottom">
            <mui-input type="search" class="searchbar" icon-left="search" placeholder="Suchen" v-model="search"/>
        </div>
        <div class="items-container flex vertical">
            <Loader class="loader" v-show="processing"/>

            <div class="flex h-8 h-center v-center" v-if="!items.length">
                Keine Dateien gefunden
            </div>

            <div class="list" v-show="layout === 'list'" v-if="items.length">
                <a class="item-wrapper flex" v-for="item in items" :href="item.path.url" target="_blank">
                    <div class="icon" :style="'color: '+item.visual.color">{{ item.visual.icon }}</div>
                    <span class="flex-1">{{ item.path.filename }}</span>
                    <IconButton icon="download" is="a" :href="item.path.url" download/>
                </a>
            </div>

            <div class="grid" v-show="layout === 'grid'" v-if="items.length">
                <Card v-for="item in items" new-window
                    :key="item.id"
                    :name="item.meta.title"
                    :alt="item.meta.alt"
                    :image="item.thumbnail"
                    :link="item.path.url"
                />
            </div>
        </div>
        <div class="flex padding-1 h-center border-top" v-show="total > size">
            <TablePagination v-model="page" :size="size" :total="total"/>
        </div>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue'

    import TablePagination from '@/Components/Form/Table/TablePagination.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import Loader from '@/Components/Form/Loader.vue'
    import Card from '@/Components/Page/Card.vue'



    const props = defineProps({
        mediaId: [String, Number],
        layout: {
            type: String,
            default: 'list',
        },
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
            let response = await axios.get(`/storage/private/${props.mediaId}/index`, {
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
        .searchbar
            flex: 1
            max-width: 300px
            height: 2.5rem

        .items-container
            display: flex
            flex-direction: column
            position: relative

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



        .list
            display: flex
            flex-direction: column
            padding: .5rem 0

        .grid
            display: grid
            gap: 1rem
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr))
            padding: 1rem
</style>