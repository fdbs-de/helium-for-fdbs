<template>
    <div class="mfa-input-wrapper" ref="wrapper" tabindex="0" @focus="onFocus">
        <input
            ref="inputs"
            maxlength="1"
            tabindex="-1"
            autocomplete="new-password"
            v-for="(digit, index) in values"
            :key="index"
            :type="password ? 'password' : 'text'"
            :readonly="readonly"
            :disabled="disabled"
            :style="{order: index}"
            v-model="values[index]"
            @focus.stop="onFocus"
            @paste.prevent="onPaste"
            @keydown="onKey($event, index)"
        />

        <div class="mfa-divider" v-for="divider in dividers" :style="{order: divider-1}"></div>
    </div>
</template>

<script setup>
    import { ref, watch, computed } from 'vue'



    const props = defineProps({
        modelValue: {
            type: String,
            default: '',
        },
        length: {
            type: Number,
            required: true,
        },
        charset: {
            type: String,
            default: '0123456789',
        },
        password: {
            type: Boolean,
            default: false,
        },
        readonly: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        dividers: {
            type: Array,
            default: () => [],
        }
    })

    const emits = defineEmits([
        'update:modelValue',
        'complete',
    ])



    const values = ref(Array(props.length).fill(''))
    const inputs = ref([])
    const wrapper = ref(null)



    function onKey(event, index)
    {
        const ctrl = event.ctrlKey
        const key = event.key

        // Dont prevent default
        if (key === 'Enter') return
        if (key === 'Tab') return
        if (ctrl && key === 'c') return
        if (ctrl && key === 'v') return
        if (ctrl && key === 'x') return

        // Prevent default
        if (ctrl && key === 'Backspace') clear()
        if (ctrl && key === 'Delete') clear()
        if (key === 'Backspace') onBackspace(index)
        if (key === 'Delete') onBackspace(index)
        if (props.charset.includes(key)) onChar(event, index)

        event.preventDefault()
    }

    function onChar(event, index)
    {
        values.value[index] = event.key

        if (index < props.length - 1 && values.value[index] !== '')
        {
            inputs.value[index + 1].focus()
        }
        
        emits('update:modelValue', values.value.join(''))
    }

    function onBackspace(index)
    {
        values.value[index] = ''

        if (index > 0 && values.value[index] === '')
        {
            inputs.value[index - 1].focus()
        }

        emits('update:modelValue', values.value.join(''))
    }

    function onPaste(event)
    {
        values.value = parse(event.clipboardData.getData('Text'))

        emits('update:modelValue', values.value.join(''))
    }

    // TODO: handle shift+tab when focus is on input
    function onFocus(event)
    {
        const emptyIndex = values.value.findIndex(char => char === '')
        const currentIndex = inputs.value.findIndex(input => input === event.target)

        if (emptyIndex === -1) return

        if (emptyIndex < currentIndex || currentIndex === -1)
        {
            inputs.value[emptyIndex].focus()
        }
    }



    function parse(value)
    {
        value = String(value).split('').filter(char => props.charset.includes(char))

        value = value.slice(0, props.length)

        while (value.length < props.length) value.push('')

        return value
    }

    function clear()
    {
        values.value = Array(props.length).fill('')
        inputs.value[0].focus()
    }



    watch(() => props.modelValue, (value) => {
        values.value = parse(value)
    }, {
        immediate: true,
    })

    watch(values, () => {
        if (values.value.every(char => char !== '')) emits('complete')
    }, {
        deep: true,
        immediate: true,
    })



    defineExpose({
        clear,
    })
</script>

<style lang="sass" scoped>
    .mfa-input-wrapper
        display: flex
        align-items: center
        gap: .5rem
        height: 3rem
        border-radius: var(--radius-m)

        &:has(input:not(:disabled)),
        &:has(input:not(:read-only))
            cursor: text

        input
            flex: 1
            width: 0
            min-width: 0
            padding: 0
            height: 100%
            background: var(--color-background-soft)
            border-radius: inherit
            border: none
            text-align: center
            font-size: 1.25rem
            font-family: var(--font-text)
            color: var(--color-text)

            &:not(:disabled):focus
                outline: 3px solid var(--color-primary)

            &:disabled
                color: var(--color-text-soft-disabled)
                background: var(--color-background-disabled)

        .mfa-divider
            user-select: none
            pointer-events: none
            height: 0
            width: 12px
            border-top: 2px solid var(--color-border)
</style>