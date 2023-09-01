<template>
    <label class="flex vertical">
        <b v-show="input.options.showLabel">
            {{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span>
        </b>
        <select class="app-forms-select" v-model="input.value" :name="input.key" :required="input.validation.required">
            <option v-for="option in input.options.options" :value="option.value" :key="option.value">{{ option.label }}</option>
        </select>
        <span v-if="$page.props.errors.hasOwnProperty(input.key)" class="color-red">{{$page.props.errors[input.key]}}</span>
    </label>
</template>

<script setup>
    const props = defineProps({
        input: Object,
    })
</script>

<style lang="sass" scoped>
    .app-forms-select
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
</style>