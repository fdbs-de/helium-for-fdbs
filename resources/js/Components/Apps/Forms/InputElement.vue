<template>
    <div class="element-wrapper" :class="['type-'+input.type, { 'selected': selected, 'expanded': input.editorMeta.expanded }]" >
        <div class="input-head" @click.exact="$emit('select:toggle', input)">
            <div class="icon">{{ input.icon }}</div>
            <div class="name">
                <b>{{ capitalizeWords(input.type) }}</b> – <span v-if="input.options.label">{{ input.options.label }}</span>
                <span class="color-red" v-if="input.validation.required"> *</span>
            </div>
            <template v-if="selected">
                <IconButton class="icon-button" icon="delete" style="color: var(--color-error)" @click.stop="$emit('delete', input)"/>
                <IconButton class="icon-button" icon="content_copy"/>
                <mui-button type="button" size="small" label="Fertig" @click.stop="$emit('select:toggle', input)"/>
            </template>
            <IconButton class="icon-button" icon="drag_indicator" @click.stop/>
        </div>

        <div class="input-fixtures" v-show="selected">
            <div class="group">
                <div class="flex gap-1 v-center wrap">
                    <select class="flex-1" v-model="input.inputType">
                        <option :value="null" disabled>Feldtyp auswählen</option>
                        <option :value="option" v-for="option in input.types.input" :key="'type-'+option">Feldtyp: {{capitalizeWords(option)}}</option>
                    </select>
                    <select class="flex-1" v-model="input.options.type" v-if="input.hasFixtures.textSubtypes">
                        <option :value="null" disabled>Text-Typ auswählen</option>
                        <option :value="option" v-for="option in input.types.text" :key="'subtype-'+option">Text-Typ: {{capitalizeWords(option)}}</option>
                    </select>
                </div>
                <mui-input type="text" label="Feldname" v-model="input.key"/>
            </div>
            <div class="group">
                <mui-input type="text" label="Label" v-model="input.options.label" v-if="input.hasFixtures.label"/>
                <div class="flex gap-1 v-center wrap">
                    <mui-toggle label="Label anzeigen" v-model="input.options.showLabel" v-if="input.hasFixtures.showLabel" />
                </div>
                <mui-input type="text" label="Placeholder" v-model="input.options.placeholder" v-if="input.hasFixtures.placeholder"/>
                <!-- <mui-input type="text" label="Vorgabewert" v-model="input.options.defaultValue" v-if="input.hasFixtures.defaultTextValue"/> -->
                <TextEditor label="Beschreibung" v-model="input.options.description" v-if="input.hasFixtures.description"/>
            </div>
            <div class="group" v-if="input.hasFixtures.options">
                <div class="flex gap-1 v-center" v-for="(option, index) in input.options.options">
                    <mui-toggle :modelValue="option.selected" @update:modelValue="input.toggleDefaultOption(index)"/>
                    <mui-input class="flex-1" type="text" placeholder="Label" v-model="option.label"/>
                    <mui-input class="flex-1" type="text" placeholder="Wert" v-model="option.value"/>
                    <IconButton class="icon-button" icon="delete" @click.stop="input.removeOption(index)"/>
                </div>
                <mui-button type="button" label="Auswahlmöglichkeit Hinzufügen" @click="input.addOption()"/>
            </div>
            <div class="group">
                <mui-input type="text" label="Fehlermeldung" v-model="input.validation.errorMessage" v-if="input.hasFixtures.errorMessage"/>
                <mui-input type="text" label="Mindestlänge" v-model="input.validation.min" v-if="input.hasFixtures.min"/>
                <mui-input type="text" label="Maximallänge" v-model="input.validation.max" v-if="input.hasFixtures.max"/>
                <div class="flex gap-1 v-center wrap">
                    <mui-toggle label="Pflichtfeld" v-model="input.validation.required" v-if="input.hasFixtures.required"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import FormInput from '@/Classes/Apps/Forms/FormInput'
    import { capitalizeWords } from '@/Utils/String'

    import IconButton from '@/Components/Apps/Pages/IconButton.vue'
    import TextEditor from '@/Components/Form/TextEditor.vue'


    
    const props = defineProps({
        input: FormInput,
        selected: {
            type: Boolean,
            default: false,
        },
    })
</script>

<style lang="sass" scoped>
    .element-wrapper
        display: flex
        flex-direction: column
        position: relative
        transition: all 100ms ease-in-out
        border-radius: var(--radius-m)
        user-select: none

        --color-input-type: var(--color-text-soft)

        &:hover
            box-shadow: 0 0 0 1px var(--color-background-soft)

            .input-head
                padding-left: .5rem

        &.selected
            margin-block: 1rem
            box-shadow: 0 0 0 1px var(--color-input-type), 0 0 6px var(--color-input-type)

            .input-head
                padding: 1rem
                padding-right: 0

        &.type-text
            --color-input-type: #1e90ff

        &.type-select
            --color-input-type: #f368e0

        &.type-checkbox
            --color-input-type: #ffa502

        &.type-radio
            --color-input-type: #00b894

        .input-head
            cursor: pointer
            display: flex
            align-items: center
            padding: .5rem 0
            gap: .5rem
            border-radius: var(--radius-m)
            color: var(--color-text-soft)
            transition: all 100ms ease-in-out

            .icon
                display: flex
                align-items: center
                justify-content: center
                height: 2rem
                width: 2rem
                font-size: 1.25rem
                line-height: 1
                color: var(--color-input-type)
                font-family: var(--font-icon)
                border-radius: var(--radius-s)
                position: relative

                &::after
                    content: ''
                    position: absolute
                    top: 0
                    left: 0
                    width: 100%
                    height: 100%
                    border-radius: inherit
                    background-color: currentColor
                    opacity: .15

            .name
                flex: 1
                overflow: hidden
                text-overflow: ellipsis
                white-space: nowrap

            .icon-button
                height: 2rem
                width: 2rem
                border-radius: var(--radius-s)

        .input-fixtures
            display: flex
            flex-direction: column
            
            .group
                display: flex
                flex-direction: column
                padding: 1rem
                gap: 1rem
                border-top: 1px solid var(--color-input-type)
</style>