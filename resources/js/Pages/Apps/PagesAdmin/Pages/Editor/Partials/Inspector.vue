<template>
    <template v-if="tab && element">
        <div class="group inspector-group">
            <div class="flex v-center">
                <span class="title flex-1">Name</span>
                <IodInput v-model="element.name" placeholder="143" @update:modelValue="emitUpdate()"/>
            </div>
        </div>

        <div class="group inspector-group">
            <template v-for="prop in element.props">
                <TextEditor v-if="prop.fixtureType === 'richtext'" :label="prop.label" v-model="prop.value" @update:modelValue="emitUpdate()"/>
    
                <div v-else-if="prop.fixtureType === 'code'" class="flex vertical">
                    <!-- <span class="title flex-1">{{ prop.label }}</span> -->
                    <CodeEditor class="border radius-m" theme="vs-light" v-model="prop.value" @update:modelValue="emitUpdate()"/>
                </div>
    
    
                
                <label v-else-if="prop.fixtureType === 'select'" class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <select v-model="prop.value" @change="emitUpdate()">
                        <option v-for="option in prop.options" :value="option.value">{{ option.label }}</option>
                    </select>
                </label>
                
                <div v-else-if="prop.fixtureType === 'toggle:switch'" class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <span class="w-14">
                        <IodToggle type="switch" v-model="prop.value" @update:modelValue="emitUpdate()" />
                    </span>
                </div>
    
    
    
                <div v-else-if="prop.fixtureType === 'media:folder'" class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <IodInput v-model="prop.value" placeholder="143" @update:modelValue="emitUpdate()"/>
                </div>
    
                <div v-else-if="prop.fixtureType === 'media:image'" class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <IodInput v-model="prop.value" placeholder="/images" @update:modelValue="emitUpdate()">
                        <template #right>
                            <IodIconButton type="button" class="folder-trigger" icon="folder_open" shape="radius-s" variant="text" size="small" @click="picker.open((file) => { prop.value = file; emitUpdate() })"/>
                        </template>
                    </IodInput>
                </div>
    
    
    
                <div v-else-if="prop.fixtureType === 'style:unit'" class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <IodInput v-model="prop.value" placeholder="100px" @update:modelValue="emitUpdate()"/>
                </div>
    
                <div v-else-if="prop.fixtureType === 'style:padding'" class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <IodInput v-model="prop.value" placeholder="4rem" @update:modelValue="emitUpdate()"/>
                </div>
    
                <div v-else-if="prop.fixtureType === 'style:color'" class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <IodInput v-model="prop.value" placeholder="#fef1f4" @update:modelValue="emitUpdate()">
                        <template #right>
                            <VDropdown placement="bottom-end" style="height: 1.5rem;">
                                <button class="color-trigger" :style="{ backgroundColor: prop.value }"></button>
    
                                <template #popper>
                                    <div class="flex vertical padding-1 gap-1">
                                        <div class="flex gap-0-5" v-for="group in tab.globalData.colorPalettes.default">
                                            <button v-for="color in group" class="color-trigger" :style="{ backgroundColor: color }" @click="prop.value = color; emitUpdate()" v-tooltip="color"></button>
                                        </div>
                                    </div>
                                </template>
                            </VDropdown>
                        </template>
                    </IodInput>
                </div>
                
    
    
                <div v-else class="flex v-center">
                    <span class="title flex-1">{{ prop.label }}</span>
                    <IodInput v-model="prop.value" @update:modelValue="emitUpdate()"/>
                </div>
            </template>
        </div>
    </template>
    <div class="group flex v-center" v-else>
        <small class="padding-block-4 user-select-none color-text">
            Wähle ein Element aus
        </small>
        {{ element }}
    </div>
</template>

<script setup>
    import { ref, watch, computed } from 'vue'
    import ElementTemplates from '@/Pages/Apps/Pages/ElementTemplates'

    import TextEditor from '@/Components/Form/TextEditor.vue'
    import CodeEditor from '@/Components/Form/CodeEditor.vue'



    const emits = defineEmits([
        'update:element',
    ])

    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
        picker: {
            type: Object
        },
    })



    // const elementProps = ref([])
    const element = computed(() => {
        return props.tab.data.content.find(element => element.localId === props.tab.selected.elements[0]) || null
    })



    // const getElementfromSelection = () => {
    //     return props.tab.data.content.find(element => element.localId === props.tab.selected.elements[0]) || null
    // }

    // const getPropsFromElement = () => {
    //     if (!props.tab.selected.elements.length) return []

    //     const element = getElementfromSelection()
    //     if (!element) return []

    //     const template = ElementTemplates[element.type]
    //     if (!template) return []

    //     return template.props.map(prop => {
    //         return { ...prop, value: element.props[prop.key] }
    //     })
    // }

    // const getElementFromProps = () => {
    //     if (!props.tab.selected.elements.length) return

    //     const element = getElementfromSelection()
    //     if (!element) return

    //     element.props = elementProps.value.reduce((props, prop) => {
    //         props[prop.key] = prop.value
    //         return props
    //     }, {})

    //     return element
    // }



    // watch(() => props.tab, () => {
    //     elementProps.value = getPropsFromElement()
    // }, {
    //     immediate: true,
    //     deep: true,
    // })

    const emitUpdate = () => {
        // emits('update:element', getElementFromProps())
    }
</script>

<style lang="sass" scoped>
    .inspector-group
        padding: 1rem !important
        display: flex
        flex-direction: column
        gap: 1rem
        border-bottom: 1px solid var(--color-border)

        .title
            font-size: .8rem
            font-weight: 500
            color: var(--color-text-soft)
            user-select: none

        .spacer
            flex: 1

        select,
        .iod-input
            height: 2.5rem
            width: 14rem

        .iod-toggle
            padding-inline: 0

    .color-trigger
        height: 1.5rem
        width: 1.5rem
        border-radius: 50%
        border: 1px solid var(--color-border)
        cursor: pointer
        padding: 0
        margin: 0
        outline: none
        transition: all 100ms ease-in-out

        &:hover
            transform: scale(1.05)

    .folder-trigger
        height: 1.5rem !important
        width: 1.5rem !important
        font-size: 1rem !important
        --local-color-background: var(--color-text) !important
</style>