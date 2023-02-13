<template>
    <TextSubLayout title="Form Test" has-small-limiter>
        <Head>
            <title>TEST – FDBS</title>
        </Head>

        <form class="flex vertical gap-1" @submit.prevent="submit">
            <h2 class="margin-0">{{ form.name }}</h2>

            <div class="flex vertical gap-1" v-for="page in form.pages" :key="page.id">
                <div v-for="input in page.inputs" :key="input.id">
                    <template v-if="['text', 'textarea', 'tel', 'email', 'password'].includes(input.type)">
                        <mui-input
                            v-model="input.value"
                            :type="input.type"
                            :name="input.key"
                            :label="input.options.label"
                            :placeholder="input.options.placeholder"
                            :required="input.validation.required"
                            :min="input.validation.min"
                            :max="input.validation.max"
                        />
                    </template>
                </div>
            </div>

            <mui-button type="submit" variant="filled" label="Absenden" />
        </form>
    </TextSubLayout>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'

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