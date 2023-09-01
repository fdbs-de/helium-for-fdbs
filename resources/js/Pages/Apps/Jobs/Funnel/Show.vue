<template>
    <TextSubLayout :title="funnel.title" image="/images/content/banner/karriere_513169496_482949832.webp" has-small-limiter>
        <Head>
            <title>{{funnel.title}} – FDBS Karriere</title>
        </Head>

        <form class="form" @submit.prevent="submit" v-if="funnel.pages">
            <div class="form-step" v-for="(page, index) in funnel.pages" v-show="validation.showPages.includes(index)">
                <template v-for="input in page.inputs">
                    <!-- Heading -->
                    <h2 class="question">{{input.label}} <span class="text-red">*</span></h2>

                    <!-- Multiple Choice Input -->
                    <div class="options" v-if="input.type === 'multiple'">
                        <button type="button" v-for="option in input.options" :class="{ 'active': form[input.id] === option.value }" @click="setFunnelInput(input.id, option.value)">{{option.label}}</button>
                    </div>

                    <!-- Text Input -->
                    <template v-else-if="input.type === 'text'">
                        <div class="options">
                            <mui-input class="flex-1" border :required="input.required" :label="input.label" :modelValue="form[input.id]" @update:modelValue="setFunnelInput(input.id, $event)"/>
                        </div>
                        <div class="flex gap-1 wrap" v-if="input.options && input.options.length">
                            <Tag style="font-size: .9rem; cursor: pointer" v-for="option in input.options" :color="option.color" :label="option.label" shape="pill" @click="setFunnelInput(input.id, option.value)"/>
                        </div>
                    </template>
                </template>
            </div>
    
            <div class="form-step" v-show="validation.showPages.includes(funnel.pages.length)">
                <h2 class="question">Wie können wir dich am besten für ein Gespräch erreichen?</h2>
                <mui-input border required v-model="form.name" label="Name *"/>
                <mui-input border v-model="form.email" label="Email"/>
                <mui-input border required v-model="form.phone" label="Telefonnummer *"/>
                <mui-input border required v-model="form.birthday" label="Geburtsdatum *"/>
                <mui-input border required v-model="form.city" label="Wohnort *" />
                <div></div>
                <mui-toggle class="checkbox" border required v-model="form.gdpr">
                    <template #label>
                        <span>Ich habe die <a :href="route('datenschutz')" target="_blank">Datenschutzerklärung</a> gelesen und akzeptiere diese <span class="text-red">*</span></span>
                    </template>
                </mui-toggle>
                <mui-button type="submit" size="large" :disabled="!validation.canSubmit">Bewerbung jetzt Absenden</mui-button>
            </div>

            <Alert title="Leider können wir dir keine Stelle anbieten" type="error" v-show="validation.exitCondition">
                <span class="margin-bottom-1">
                    {{validation.exitCondition}}
                </span>
            </Alert>

            <small><span class="text-red">*</span> Diese Felder musst du verpflichtend ausfüllen</small>
        </form>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import Alert from '@/Components/Alert.vue'
    import Tag from '@/Components/Form/Tag.vue'

    const props = defineProps({
        funnel: Object,
    })



    const formBase = () => {
        // get all input ids from all pages
        const inputIds = props.funnel.pages?.map(page => page?.inputs?.map(input => input.id))?.flat() || []

        // create an object with all input ids as keys and empty strings as values
        return {
            ...Object.fromEntries(inputIds.map(id => [id, ''])),
            name: '',
            email: '',
            phone: '',
            birthday: '',
            city: '',
            gdpr: false,
        }
    }

    const form = useForm(formBase())



    const validation = computed(() => {
        const validationObject = {
            exitCondition: null,
            showPages: [0],
            canSubmit: false,
        }

        // Loop through all pages
        for (let index = 0; index < props?.funnel?.pages?.length; index++)
        {
            const page = props.funnel.pages[index]
            
            // Check if there is an exit condition fulfilled
            let exitConditions = page.inputs.filter(input => input?.exitConditions).map(input => (input?.exitConditions[form[input.id]] || null)).filter(e => e !== null)
            
            if (exitConditions.length > 0)
            {
                validationObject.exitCondition = exitConditions[0]
                break
            }

            // Check if all required inputs are filled
            if (page.inputs.filter(input => input.required).some(input => !form[input.id])) break

            // If so, add the next page to the showPages array
            validationObject.showPages.push(index + 1)
        }

        validationObject.canSubmit = [
            // Mustn't have an exit condition
            (!validationObject.exitCondition),
            // Must have filled all required inputs so the last page is shown
            (!!validationObject.showPages.includes(props?.funnel?.pages?.length)),
            // Must have filled all required inputs
            (!!form.city),
            (!!form.name),
            (!!form.phone),
            (!!form.birthday),
            (!!form.gdpr),
        ].every(e => e === true)

        return validationObject
    })



    const setFunnelInput = (key, value) => {
        form[key] = value

        sendClick(`funnel.${props.funnel.slug}.${key}`, value)
    }



    const submit = () => {
        const eventName = `funnel.${props.funnel.slug}.submit`

        sendClick(eventName, 'start')

        form.post(route('karriere.funnel.store', props.funnel.slug), {
            onSuccess: () => {
                form.reset()
                sendClick(eventName, 'success')
            },
            onError: () => {
                sendClick(eventName, 'error')
            },
        })
    }



    const sendClick = (path, value = '') => {
        const _etracker = window._etracker
        
        if (!_etracker) return

        _etracker.sendEvent(new et_ClickEvent(path, value))
    }
</script>

<style lang="sass" scoped>
    .form
        display: flex
        flex-direction: column
        gap: 2rem

    .form-step
        display: flex
        flex-direction: column
        gap: 1rem
        padding: 1rem
        background: var(--color-background-soft)
        border-radius: var(--radius-m)

        &.error
            border: 1px solid var(--color-error)

            .question
                color: var(--color-error)
                margin-bottom: 0

            > p
                margin-top: 0

        .question
            font-size: 1.5rem
            font-weight: 500
            text-align: center

        > p
            text-align: center

        .options
            display: grid
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))
            gap: 1rem

            button
                flex: 1
                display: flex
                flex-direction: column
                align-items: center
                justify-content: center
                padding: 1rem
                border-radius: var(--radius-m)
                background: var(--color-background-soft)
                border: 1px solid var(--color-border)
                color: var(--color-text-soft)
                font-size: 1.25rem
                font-weight: 500
                cursor: pointer
                user-select: none

                &:hover
                    background: var(--color-background)
                &.active
                    background: var(--color-primary)
                    border: 1px solid var(--color-background)
                    color: var(--color-background)
</style>