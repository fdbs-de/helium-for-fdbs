<template>
    <label class="flex vertical">
        <b v-show="input.options.showLabel">
            {{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span>
        </b>
        <input
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
    const props = defineProps({
        input: Object,
    })
</script>

<style lang="sass" scoped>
    .forms-input,
    .forms-textarea
        width: 100%
        height: auto
        padding: .5rem
        border: none
        border-radius: var(--radius-s)
        font-size: 1rem
        line-height: 1.5
        color: var(--color-text)
        background: var(--color-background-soft)
        font-family: var(--font-text)

        &:focus
            outline: none
            border-color: var(--color-info)
    
    .forms-textarea
        height: 10rem
        resize: none
</style>