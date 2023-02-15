<template>
    <div class="flex vertical">
        <b v-show="input.options.showLabel">
            {{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span>
        </b>
        <label class="flex gap-1 v-center">
            <input type="checkbox" :name="input.key" value="checked" v-model="input.value" :required="input.validation.required" />
            <span v-html="input.options.description" class="formatted-content frontend-forms-root"></span>
        </label>
    </div>
</template>

<script setup>
    const props = defineProps({
        input: Object,
    })

    if (props.input.value == 'checked') props.input.value = true
    else props.input.value = false
</script>

<style lang="sass" scoped>
</style>