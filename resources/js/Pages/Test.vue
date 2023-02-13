<template>
    <TextSubLayout title="Form Test" has-small-limiter>
        <Head>
            <title>TEST – FDBS</title>
        </Head>

        <form class="flex vertical gap-1" @submit.prevent="submit">
            <div class="flex vertical gap-1" v-for="page in form.pages" :key="page.id">
                <div v-for="input in page.inputs" :key="input.id">
                    <template v-if="input.type == 'text' && input.options.type !== 'textarea'">
                        <label class="flex vertical">
                            <b>{{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span></b>
                            <input
                                class="app-forms-input"
                                :type="input.options.type"
                                :name="input.key"
                                :placeholder="input.options.placeholder"
                                :required="input.validation.required"
                                :min="input.validation.min"
                                :max="input.validation.max"
                                v-model="input.value"
                            />
                        </label>
                    </template>

                    <template v-if="input.type == 'text' && input.options.type === 'textarea'">
                        <label class="flex vertical">
                            <b>{{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span></b>
                            <textarea
                                class="app-forms-textarea"
                                :name="input.key"
                                :placeholder="input.options.placeholder"
                                :required="input.validation.required"
                                :min="input.validation.min"
                                :max="input.validation.max"
                                v-model="input.value"
                            ></textarea>
                        </label>
                    </template>

                    <template v-if="input.type == 'acceptance'">
                        <label class="flex vertical">
                            <b>{{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span></b>
                            <div class="flex gap-1 v-center">
                                <input type="checkbox" :name="input.key" :value="input.value" :required="input.validation.required" />
                                <span v-html="input.options.description" class="formatted-content"></span>
                            </div>
                        </label>
                    </template>

                    <template v-if="input.type == 'select'">
                        <label class="flex vertical">
                            <b>{{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span></b>
                            <select class="app-forms-select" :value="input.options.options.find(e => e.selected).value" v-model="input.value" :name="input.key" :required="input.validation.required">
                                <option v-for="option in input.options.options" :value="option.value" :key="option.value">{{ option.label }}</option>
                            </select>
                        </label>
                    </template>

                    <template v-if="input.type == 'checkbox'">
                        <div class="flex vertical">
                            <b>{{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span></b>
                            <label class="flex gap-1 v-center">
                                <input type="checkbox" :name="input.key" :value="input.value" :required="input.validation.required" />
                                <span v-html="input.options.label" class="formatted-content"></span>
                            </label>
                        </div>
                    </template>

                    <template v-if="input.type == 'radio'">
                        <div class="flex vertical">
                            <b>{{ input.options.label }} <span class="color-red" v-if="input.validation.required">*</span></b>
                            <label class="flex gap-1 v-center" v-for="option in input.options.options" :key="option.value">
                                <input type="radio" :name="input.key" :value="option.value" :required="input.validation.required" :checked="option.selected" v-model="input.value"/>
                                <span v-html="option.label" class="formatted-content"></span>
                            </label>
                        </div>
                    </template>
                </div>
            </div>

            <mui-button type="submit" variant="filled" label="Absenden" />

            <span>
                <span class="color-red">*</span> Pflichtfelder
            </span>
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

<style lang="sass" scoped>
    .app-forms-input
        width: 100%
        height: auto
        padding: .5rem
        border: 1px solid var(--color-border)
        border-radius: var(--radius-s)
        font-size: 1rem
        line-height: 1.5
        color: var(--color-text)
        background: var(--color-background)

    .app-forms-textarea
        width: 100%
        height: 10rem
        resize: none
        padding: .5rem
        border: 1px solid var(--color-border)
        border-radius: var(--radius-s)
        font-size: 1rem
        line-height: 1.5
        color: var(--color-text)
        background: var(--color-background)

    .app-forms-select
        width: 100%
        height: auto
        padding: .5rem
        border: 1px solid var(--color-border)
        border-radius: var(--radius-s)
        font-size: 1rem
        line-height: 1.5
        color: var(--color-text)
        background: var(--color-background)

    .app-forms-input:focus,
    .app-forms-textarea:focus,
    .app-forms-select:focus
        outline: none
        border-color: var(--color-info)
</style>

<style lang="sass">
    .formatted-content
        p:first-child
            margin-top: 0

        p:last-child
            margin-bottom: 0
</style>