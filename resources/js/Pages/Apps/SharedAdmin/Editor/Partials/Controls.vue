<template>
    <div class="tab-layout">
        <IodIconButton size="small" variant="text" icon="home" is="a" :href="route('admin')" @mousedown="exitFullscreen"/>

        <Container @drop="editor.dropTab($event)" class="tab-bar" orientation="horizontal" behaviour="contain" lock-axis="x">            
            <Draggable v-for="tab in editor.tabs" :key="tab.localId">
                <TabButton :tab="tab" @select-tab="emits('select-tab', tab)" @close-tab="emits('close-tab', tab)" />
            </Draggable>
            <IodIconButton size="small" variant="text" icon="add" @click="emits('new-tab')" v-show="!editor.hasBlankTab" />
        </Container>

        <IodIconButton size="small" variant="text" :icon="isFullscreen ? 'fullscreen_exit' : 'fullscreen'" v-tooltip="'Vollbild (Strg+Shift+Alt+F)'" @click="toggleFullscreen"/>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue'

    import TabButton from '@/Pages/Apps/SharedAdmin/Editor/Partials/TabButton.vue'
    import { Container, Draggable } from 'vue3-smooth-dnd'



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
        color: var(--color-text-on-background-dark)

        .iod-button,
        .iod-icon-button
            height: 100% !important
            width: 3.5rem !important
            --local-color-background: var(--color-text-on-background-dark)

        .tab-bar
            flex: 1
            display: flex
            overflow-x: auto
</style>