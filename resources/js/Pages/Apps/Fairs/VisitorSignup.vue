<template>
    <TextSubLayout title="Anmeldung zur Hausmesse 2024" image="/images/content/banner/marken_509487561.webp" has-small-limiter>
        <Head>
            <title>Anmeldung zur Hausmesse 2024 (Besucher)</title>
        </Head>

        <form class="flex vertical gap-1" @submit.prevent="submit" v-if="!isSent">
            <p style="text-align: center">
                Die ADVENTure 2023 findet am <b class="color-primary">5. November</b>
                zwischen <b class="color-primary">9:00 Uhr</b> und <b class="color-primary">17:00 Uhr</b><br>
                bei uns in der <a href="https://goo.gl/maps/equP1jmcJSuFogSc8" target="_blank"><b>Christian-Pommer-Straße 31/33 38112 Braunschweig</b></a> statt.
            </p>
            <mui-input type="text" required label="Kundennummer *" placeholder="780000" v-model="form.customer"/>
            <mui-input type="text" required label="Firma *" placeholder="Musterfirma GmbH"  v-model="form.company"/>
            <mui-input type="email" label="Email" v-model="form.email"/>
            <div class="flex gap-2 vertical padding-top-2 padding-bottom-1">
                <div class="flex gap-1 vertical" v-for="(person, index) in form.people">
                    <h5 class="color-heading margin-0">
                        {{ index === 0 ? 'Ansprechpartner' : 'Weitere Person – Nr. '+index }}
                    </h5>
                    <div class="flex gap-1 v-center wrap">
                        <select required v-model="person.salutation">
                            <option value="" disabled>Anrede *</option>
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                            <option value="Divers">Divers</option>
                        </select>
                        <mui-input type="text" required label="Vorname *" v-model="person.firstname"/>
                        <mui-input type="text" required label="Nachname *" v-model="person.lastname"/>
                        <mui-button type="button" label="Entfernen" @click="removePerson(index)" :disabled="form.people.length <= 1" size="small" color="error"/>
                    </div>
                </div>
            </div>
            <mui-button type="button" label="Weitere Person hinzufügen" @click="addPerson" variant="contained" size="small"/>
            <p>&nbsp;</p>
            <mui-toggle required v-model="form.gdpr">
                <template #label>
                    Ich habe die <a target="_blank" href="/datenschutz">Datenschutzerklärung</a> gelesen und akzeptiere diese.
                </template>
            </mui-toggle>
            <mui-button label="Anmeldung absenden" size="large" :loading="form.processing"/>
        </form>

        <div class="flex vertical gap-1 v-center padding-block-4" v-else>
            <h3 class="color-primary margin-0">Vielen Dank für Ihre Anmeldung!</h3>
            <p class="margin-0">
                Sie erhalten in Kürze eine Bestätigung per Email.
            </p>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'



    const isSent = ref(false)

    const person = {
        salutation: '',
        firstname: '',
        lastname: '',
    }

    const form = useForm({
        customer: '',
        company: '',
        email: '',
        people: [{ ...person }],
        gdpr: false,
    })

    const addPerson = () => {
        form.people.push({...person})
    }
    
    const removePerson = (index) => {
        if (form.people.length > 1) {
            form.people.splice(index, 1)
        }
    }

    const submit = () => {
        if (isSent.value) return
        if (form.people.length < 1) return
        if (!form.gdpr) return

        form.post(route('fair.store.visitor'), {
            onSuccess: () => {
                isSent.value = true
                form.reset()
            }
        })
    }
</script>