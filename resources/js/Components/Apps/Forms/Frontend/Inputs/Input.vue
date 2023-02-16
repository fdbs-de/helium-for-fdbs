<template>
    <component :is="component" :input="input" />
</template>

<script setup>
    import { computed } from 'vue'

    import TextInput from '@/Components/Apps/Forms/Frontend/Inputs/TextInput.vue'
    import SelectInput from '@/Components/Apps/Forms/Frontend/Inputs/SelectInput.vue'
    import CheckboxInput from '@/Components/Apps/Forms/Frontend/Inputs/CheckboxInput.vue'
    import RadioInput from '@/Components/Apps/Forms/Frontend/Inputs/RadioInput.vue'



    const props = defineProps({
        input: Object,
    })

    const component = computed(() => {
        switch (props.input.type)
        {
            case 'text': return TextInput
            case 'select': return SelectInput
            case 'checkbox': return CheckboxInput
            case 'radio': return RadioInput
            default: return TextInput
        }
    })
</script>