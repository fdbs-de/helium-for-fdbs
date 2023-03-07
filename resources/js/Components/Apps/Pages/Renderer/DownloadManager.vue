<template>
    <div class="pages-elem-wrapper flex vertical gap-1">
        <h3 class="margin-0 flex h-center w-100" v-show="!!title">{{ title }}</h3>
        <div class="flex vertical w-100">
            <a class="item-wrapper flex" v-for="item in items" :href="item.path.url" target="_blank">
                <div class="icon" :style="'color: '+item.visual.color">{{ item.visual.icon }}</div>
                <span class="flex-1">{{ item.path.filename }}</span>
                <IconButton icon="download" is="a" :href="item.path.url" download/>
            </a>
        </div>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue';



    const props = defineProps({
        title: String,
        id: [Number, String],
    })

    const items = ref([])
    const processing = ref(false)
    const pagination = ref({
        total: 0,
        perPage: 10,
        page: 1,
    })



    const fetch = async () => {
        processing.value = true

        try
        {
            let response = await axios.get(`/storage/private/${props.id}/index`)

            if (!response?.data) throw new Error('No data returned')

            items.value = response?.data?.data ?? []
            pagination.value.total = response?.data?.total ?? 0
        }
        catch (error)
        {
            console.error(error)
        }
        
        processing.value = false
    }

    watch(() => props.id, () => fetch(), { immediate: true })
</script>

<style lang="sass" scoped>
    .pages-elem-wrapper
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)
        padding: 1rem 0

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