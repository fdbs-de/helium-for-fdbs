<template>
    <TextSubLayout title="Anmeldung zur Hausmesse 2024" image="/images/content/banner/marken_509487561.webp" has-small-limiter>
        <Head title="Anmeldung zur Hausmesse 2024 (Lieferant)" />

        <div class="margin-bottom-4 background-soft radius-l padding-1">
            <h2 class="text-align-center margin-top-0">Alle wichtigen Infos im Überblick</h2>
            Messedatum: <b>22. bis 23. September 2024</b><br>
            Adresse: <a href="https://goo.gl/maps/equP1jmcJSuFogSc8" target="_blank"><b>Christian-Pommer-Straße 31/33 38112 Braunschweig</b></a><br>
            <hr>
            Anlieferung der Messestände: <b>Freitag, 20.09.2024, 6:00 bis 15:00</b><br>
            Aufbau der Messestände: <b>Samstag, 21.09.2024, 9:00 bis 17:00</b><br>
            Abbau der Messestände: <b>Montag, 23.09.2024, nach Messeschluss bis 20:00</b><br>
            Abholung der Messestände: <b>Dienstag, 24.09.2024, 6:00 bis 14:00</b><br>
        </div>

        <h2 class="text-align-center">Online-Anmeldung</h2>

        <form class="form" @submit.prevent="submit" v-if="!isSent">
            <div class="group">
                <h4><IodIcon icon="counter_1"/> Kontaktinformationen</h4>
                <div class="subgroup">
                    <IodInput type="text" required border label="Firma" v-model="form.company"/>
                    <IodInput type="email" required border label="Email" v-model="form.email"/>
                </div>
            </div>


            <div class="group">
                <h4><IodIcon icon="counter_2"/>Ihr Messestand</h4>

                <div class="subgroup">
                    <h6>Ausstellungsfläche</h6>
                    <IodInput type="number" required border label="Breite in Meter" min="2" v-model="form.standWidth"/>
                    <IodInput type="number" disabled border label="Tiefe in Meter" :modelValue="form.standDepth">
                        <template #right>
                            <IodIcon icon="info" v-tooltip.left="{content: 'Die Tiefe ist vorgegeben', triggers: ['hover', 'click']}"/>
                        </template>
                    </IodInput>
                </div>

                <div class="subgroup">
                    <h6>Stromanschlüsse</h6>
                    <IodToggle class="toggle-with-input with-flex v-center" border :modelValue="form.power220 !== null" @update:modelValue="form.power220 = $event ? 0 : null">
                        <template #label>
                            <h6 class="flex-1">220 Volt</h6>
                            <IodInput type="number" suffix="kW" class="toggle-input" min="1" :required="form.power220 !== null" v-show="form.power220 !== null" v-model="form.power220" />
                        </template>
                    </IodToggle>
                    <IodToggle class="toggle-with-input with-flex v-center" border :modelValue="form.power380 !== null" @update:modelValue="form.power380 = $event ? 0 : null">
                        <template #label>
                            <h6 class="flex-1">380 Volt</h6>
                            <IodInput type="number" suffix="kW" class="toggle-input" min="1" :required="form.power380 !== null" v-show="form.power380 !== null" v-model="form.power380" />
                        </template>
                    </IodToggle>
                </div>

                <div class="subgroup">
                    <h6>Sonderwünsche</h6>
                    <IodInput type="text" border label="Notizen" v-model="form.notes"/>
                </div>
            </div>


            <div class="group">
                <h4><IodIcon icon="counter_3"/> Oktoberfest</h4>

                <div class="subgroup">
                    <IodToggle label="Ich / wir möchten am Oktoberfest teilnehmen" class="toggle-with-input" border :modelValue="!!form.participants.length" @update:modelValue="form.participants = $event ? [{...participantTemplate}] : []" />
                </div>

                <div class="subgroup" v-show="!!form.participants.length">
                    <h6>
                        Teilnehmer ({{form.participants.length}}/4)
                        <div class="spacer"></div>
                        <IodButton type="button" size="small" variant="text" shape="pill" icon-left="add" label="Teilnehmer" @click="addParticipant"/>
                    </h6>

                    <div class="participant-grid">
                        <div class="participant" v-for="(participant, index) in form.participants">
                            <IodButton type="button" label="Entfernen" size="small" variant="contained" color-preset="error" @click="removeParticipant(index)" />
                            <select required v-model="participant.salutation">
                                <option value="" disabled>Anrede</option>
                                <option value="Herr">Herr</option>
                                <option value="Frau">Frau</option>
                                <option value="---">Keine</option>
                            </select>
                            <IodInput type="text" class="participant-input" required label="Vorname *" v-model="participant.firstname"/>
                            <IodInput type="text" class="participant-input" required label="Nachname *" v-model="participant.lastname"/>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="group">
                <h4><IodIcon icon="counter_4"/>Eingaben überprüfen</h4>

                <div class="subgroup">
                    <div class="wrapper flex vertical gap-0-5 padding-1 border radius-m">
                        <p>
                            <b>Kontaktinformationen</b><br>
                            Firma: <b>{{ form.company || '---' }}</b><br>
                            Email: <b>{{ form.email || '---' }}</b>
                        </p>
                        <hr>
                        <p>
                            <b>Messestand</b><br>
                            Breite: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.standWidth) }} m</b><br>
                            Tiefe: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.standDepth) }} m</b><br>
                            Fläche: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.standWidth * form.standDepth) }} m²</b><br>
                            220V Stromanschluss: <b>{{ form.power220 ? new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.power220) + ' kW' : "nicht benötigt" }}</b><br>
                            380V Stromanschluss: <b>{{ form.power380 ? new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.power380) + ' kW' : "nicht benötigt" }}</b><br>
                            Sonderwünsche: <b>{{ form.notes || 'keine' }}</b><br>
                        </p>
                        <hr>
                        <p>
                            Preis: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.standWidth * form.standDepth * 100 + 100) }} Euro zzgl. Ust.</b><br>
                            <small>(100€/m² + einmalig 100€ für Strom, Wasser, Verpflegung etc.)</small><br>
                            <small>Den Rechnungsbetrag werden wir nach Rechnungseingang überweisen.</small>
                        </p>
                        <hr>
                        <p>
                            <b>Oktoberfest</b><br>
                            Teilnahme: <b>{{ !!form.participants.length ? 'ja' : 'nein' }}</b><br>
                            <template v-for="(participant, index) in form.participants">
                                Teilnehmer Nr. {{index + 1}}: <b>{{ participant.firstname + ' ' + participant.lastname }}</b><br>
                            </template>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="group">
                <div class="subgroup">
                    <IodToggle class="toggle-with-input" border required v-model="form.gdpr">
                        <template #label>
                            Ich habe die <a target="_blank" href="/datenschutz">Datenschutzerklärung</a>
                            <!-- und <a target="_blank" href="/datenschutz">AGBs</a> -->
                            gelesen und akzeptiere diese.
                        </template>
                    </IodToggle>
                </div>
    
                <div class="subgroup">
                    <IodButton label="Jetzt verbindlich anmelden" size="large" :loading="form.processing"/>
                </div>
            </div>
        </form>

        <div class="flex vertical gap-1 v-center padding-block-4" v-else>
            <h3 class="text-align-center color-primary margin-0">Vielen Dank für Ihre Anmeldung!</h3>
            <p class="text-align-center margin-0">
                Ihre Anmeldung wurde erfolgreich abgesendet!
            </p>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'



    const isSent = ref(false)

    const participantTemplate = {
        salutation: '',
        firstname: '',
        lastname: '',
    }

    const form = useForm({
        company: '',
        email: '',
        standWidth: 4,
        standDepth: 3,
        power220: null,
        power380: null,
        notes: '',
        participants: [],
        gdpr: false,
    })

    function addParticipant()
    {
        if (form.participants.length >= 4) return
        form.participants.push({...participantTemplate})

        console.log(form.participants)
    }
    
    function removeParticipant(index)
    {
        if (form.participants.length <= 0) return
        form.participants.splice(index, 1)
    }

    function submit()
    {
        if (isSent.value) return
        if (!form.gdpr) return

        form.post(route('fair.store.distributor'), {
            onSuccess: () => {
                isSent.value = true
                form.reset()
            }
        })
    }
</script>

<style lang="sass" scoped>
    .form
        display: flex
        flex-direction: column
        gap: 4rem

        .iod-input:not(.toggle-input, .participant-input)
            --color-background-soft: transparent

        h1, h2, h3, h4, h5, h6
            display: flex
            align-items: center
            gap: .5rem
            margin: 0
            
        p
            margin: 0

        .group,
        .subgroup
            > h6
                color: var(--color-text-soft)

        .group
            display: flex
            flex-direction: column

            .subgroup
                display: flex
                flex-direction: column
                gap: .5rem
                margin-top: 1.5rem

            .subgroup:first-of-type
                margin-top: 1rem


        .toggle-with-input
            min-height: 3rem
            padding-left: 1rem !important

        .toggle-input
            height: 2rem !important
            width: 8rem


        .participant-grid
            display: grid
            grid-template-columns: repeat(2, 1fr)
            gap: 1rem

            .participant
                display: flex
                flex-direction: column
                gap: .5rem
                padding: .5rem
                border: 1px solid var(--color-border)
                border-radius: var(--radius-l)

                .participant-input
                    width: 100%
</style>