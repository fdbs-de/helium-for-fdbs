<template>
    <form class="flex vertical gap-1" @submit.prevent="submit">
        <div class="flex vertical gap-1" v-for="page in form.pages" :key="page.id">
            <Input :input="input" v-for="input in page.inputs" :key="input.id" />
        </div>

        <mui-button type="submit" variant="filled" label="Absenden" />

        <span>
            <span class="color-red">*</span> Pflichtfelder
        </span>
    </form>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'

    import Input from '@/Components/Apps/Forms/Frontend/Inputs/Input.vue'



    const props = defineProps({
        form: Object,
    })

    const form = useForm(props.form)

    const submit = () => {
        form
        .transform(data => {
            let values = {}
            
            data.pages.forEach(page => {
                page.inputs.forEach(input => {
                    values[input.key] = input.value
                })
            })

            return values
        })
        .post(route('forms.form.submit', form.id), {
            preserveScroll: true,
        })
    }
</script>