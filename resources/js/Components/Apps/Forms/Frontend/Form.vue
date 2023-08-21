<template>
    <form class="flex vertical gap-2" @submit.prevent="submit" v-if="activated">
        <Alert v-if="Object.keys($page.props.errors).length > 0" type="error" title="Upps, da lief etwas schief!">
            <div class="flex vertical">
                <span v-for="(error, key) in $page.props.errors" :key="key">{{ error }}</span>
            </div>
        </Alert>

        <Alert v-for="message in errorMessages" :title="message.title" type="error">
            <span class="formatted-content frontend-forms-root" v-html="message.message"></span>
        </Alert>
        
        <Alert v-for="message in successMessages" :title="message.title" type="success">
            <span class="formatted-content frontend-forms-root" v-html="message.message"></span>
        </Alert>

        <div class="flex vertical gap-2" v-for="page in form.pages" :key="page.id">
            <Input :input="input" v-for="input in page.inputs" :key="input.id" />
        </div>

        <mui-button type="submit" variant="filled" label="Absenden" />

        <span>
            <span class="color-red">*</span> Pflichtfelder
        </span>
    </form>
</template>

<script setup>
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, onMounted } from 'vue'

    import Input from '@/Components/Apps/Forms/Frontend/Inputs/Input.vue'
    import Alert from '@/Components/Alert.vue'



    const props = defineProps({
        formId: String,
    })

    const form = useForm()
    const activated = ref(false)



    const transformForm = (form) => {
        form.pages.forEach(page => {
            page.inputs.forEach(input => {
                input.value = ''

                if (['radio', 'select'].includes(input.type))
                {
                    input.value = input?.options?.options?.find(e => e.selected)?.value ?? null
                }

                if (['checkbox'].includes(input.type))
                {
                    input.value = false
                }
            })
        })

        return form
    }

    onMounted(async () => {
        form.processing = true

        try
        {
            let response = await axios.get(route('forms.form.fetch', props.formId))

            if (!response?.data) throw new Error('No data returned')

            form.defaults(transformForm(response?.data?.data ?? []))
            form.reset()

            activated.value = true
        }
        catch (error)
        {
            console.error(error)
        }

        form.processing = false
    })



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
            onSuccess: () => {
                form.reset()
            },
        })
    }

    const successMessages = computed(() => {
        return usePage()?.props?.value?.flash?.message?.filter(e => e?.display === true && e?.title && e?.status === 'success') ?? []
    })

    const errorMessages = computed(() => {
        return usePage()?.props?.value?.flash?.message?.filter(e => e?.display === true && e?.title && e?.status === 'error') ?? []
    })
</script>