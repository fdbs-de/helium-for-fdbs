<template>
    <label class="flex vertical">
        <b v-show="input.options.showLabel">
            {{ label }}
        </b>
        <IodInput
            v-if="input.options.type != 'textarea'"
            class="forms-input"
            :type="input.options.type"
            :name="input.key"
            :required="input.validation.required"
            :placeholder="input.options.placeholder"
            :min="input.validation.min"
            :max="input.validation.max"
            v-model="input.value"
            />
        <textarea
            v-else
            class="forms-textarea"
            :name="input.key"
            :placeholder="input.options.placeholder"
            :required="input.validation.required"
            :min="input.validation.min"
            :max="input.validation.max"
            v-model="input.value"
        ></textarea>
        <span v-if="$page.props.errors.hasOwnProperty(input.key)" class="color-red">{{$page.props.errors[input.key]}}</span>
    </label>
</template>

<script setup>
    import { computed } from 'vue'



    const props = defineProps({
        input: Object,
    })

    const label = computed(() => {
        let result = ''

        if (!props.input.options.showLabel) return result

        result += props.input.options.label

        if (!props.input.validation.required) return result
        
        return result + ' *'
    })
</script>

<style lang="sass" scoped>
    .forms-textarea
        width: 100%
        height: auto
        padding: .5rem
        border: none
        border-radius: var(--radius-s)
        font-size: 1rem
        line-height: 1.5
        color: var(--color-text-soft)
        background: var(--color-background-soft)
        font-family: var(--font-text)

        &:focus
            outline: none
            border-color: var(--color-info)
    
    .forms-textarea
        height: 10rem
        resize: none
</style>