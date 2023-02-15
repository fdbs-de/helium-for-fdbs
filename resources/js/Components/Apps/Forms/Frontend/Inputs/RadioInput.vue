<template>
    <div class="flex vertical">
        <b v-show="input.options.showLabel">
            {{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span>
        </b>
        <label class="flex gap-1 v-center" v-for="option in input.options.options" :key="option.value">
            <input type="radio" :name="input.key" :value="option.value" :required="input.validation.required" :checked="option.selected" v-model="input.value"/>
            <span>{{option.label}}</span>
        </label>
        <span v-if="$page.props.errors.hasOwnProperty(input.key)" class="color-red">{{$page.props.errors[input.key]}}</span>
    </div>
</template>

<script setup>
    const props = defineProps({
        input: Object,
    })
</script>

<style lang="sass" scoped>
</style>