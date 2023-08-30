<template>
    <div class="tab-layout">
        <IconButton :is="Link" :href="route('admin.pages.pages')" icon="arrow_back" @click="exitFullscreen"/>
        <TabButton
            v-for="tab in editor.tabs"
            :tab="tab"
            @select-tab="emits('select-tab', tab)"
            @close-tab="emits('close-tab', tab)"
        />
        <IconButton icon="add" @click="emits('new-tab')" v-show="!editor.hasBlankTab"/>

        <div class="spacer"></div>

        <IconButton class="small" :icon="isFullscreen ? 'fullscreen_exit' : 'fullscreen'" v-tooltip="'Vollbild (Strg+Shift+Alt+F)'" @click="toggleFullscreen"/>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import { ref, onMounted } from 'vue'

    import TabButton from '@/Pages/Apps/SharedAdmin/Editor/Partials/TabButton.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'



    const emits = defineEmits([
        'close-tab',
        'select-tab',
        'new-tab',
        'enter-fullscreen',
        'exit-fullscreen',
    ])

    const props = defineProps({
        editor: {
            type: Object,
            required: true,
        },
    })



    // START: Keyboard Shortcuts
    hotkeys('ctrl+alt+shift+f, f11', (event, handler) => { event.preventDefault(); toggleFullscreen() })
    // END: Keyboard Shortcuts



    // START: Fullscreen
    const isFullscreen = ref(false)
    const fullscreenAvailable = ref(false)

    onMounted(() => {
        isFullscreen.value = !!document.fullscreenElement
        fullscreenAvailable.value = document.fullscreenEnabled
    })

    window.addEventListener('fullscreenchange', () => {
        isFullscreen.value = !!document.fullscreenElement
    })

    

    const enterFullscreen = () => {
        document.documentElement.requestFullscreen()
        emits('enter-fullscreen')
    }

    const exitFullscreen = () => {
        document.exitFullscreen()
        emits('exit-fullscreen')
    }

    const toggleFullscreen = () => {
        isFullscreen.value ? exitFullscreen() : enterFullscreen()
    }
    // END: Fullscreen
</script>

<style lang="sass" scoped>
    .tab-layout
        width: 100%
        height: 2.25rem
        display: flex
        background: var(--color-background-dark-soft)
        color: var(--color-heading-on-background-dark)
        padding-right: .5rem

        > button:not(.tab),
        > a:not(.tab)
            border-radius: var(--radius-s)
            height: 100%
            width: 3.5rem

        > button.small
            width: auto
            aspect-ratio: 1
</style>