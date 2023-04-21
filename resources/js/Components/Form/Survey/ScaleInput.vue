<template>
    <div class="wrapper">
        <label v-for="option in options" :class="{'active': option.value === modelValue}" tabindex="0" :style="`--color-active: ${option.color || 'black'};`">
            <div class="icon" v-if="option.icon">{{ option.icon }}</div>
            <div class="text" v-if="option.label" v-show="showLabel">{{ option.label }}</div>
            <input type="radio" :name="name" :value="option.value" v-model="value" :required="required">
        </label>
    </div>
</template>

<script setup>
    import { ref, watch } from 'vue'



    // Props
    const props = defineProps({
        name: {
            type: String,
            required: true
        },
        options: {
            type: Array,
            required: true
        },
        modelValue: {
            type: [Number, String],
            default: 0
        },
        required: {
            type: Boolean,
            default: false
        },
        showLabel: {
            type: Boolean,
            default: true
        }
    })
    


    // Emits
    const emits = defineEmits([
        'update:modelValue',
    ])



    // Local state
    const value = ref(props.modelValue)



    // Watchers
    watch(() => props.modelValue, (newValue) => {
        value.value = newValue
    })

    watch(value, (newValue) => {
        emits('update:modelValue', newValue)
    })
</script>

<style lang="sass" scoped>
    .wrapper
        display: flex
        gap: 1rem

        label
            flex: 1
            display: flex
            flex-direction: column
            align-items: center
            justify-content: flex-start
            background: var(--color-background)
            border-radius: var(--radius-s)
            border: 1px solid var(--color-border)
            cursor: pointer
            transition: all 70ms ease-in-out
            user-select: none

            &:hover
                border-color: var(--color-active)

            &.active
                border-color: var(--color-active)
                color: var(--color-active)

                .icon
                    background-color: var(--color-active)
                    color: white

            .icon
                width: 100%
                height: 5rem
                border-bottom: 1px solid transparent
                border-bottom-color: inherit
                display: flex
                align-items: center
                justify-content: center
                font-size: 2rem
                color: inherit
                line-height: 1
                font-family: var(--font-icon)

            .text
                font-size: 1rem
                color: inherit
                line-height: 1.3
                text-align: center
                padding: .5rem 1rem
                font-weight: 500

            input
                display: none
</style>