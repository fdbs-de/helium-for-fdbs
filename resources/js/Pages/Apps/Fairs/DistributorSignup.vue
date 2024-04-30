<template>
    <TextSubLayout title="Anmeldung zur Hausmesse 2024" image="/images/content/banner/marken_509487561.webp" has-small-limiter>
        <Head title="Anmeldung zur Hausmesse 2024 (Lieferant)" />

        <div class="margin-bottom-4 background-soft radius-l padding-1">
            <h2 class="margin-top-0 padding-inline-0-5" style="font-size: 1.5rem;">Alle wichtigen Infos im Überblick</h2>
            <hr>
            <div class="flex gap-1 v-center padding-left-0-5">
                <IodIcon style="color: rgb(59, 130, 246)" icon="calendar_today"/>
                <span>
                    Messedatum: <b>22. bis 23. September 2024</b><br>
                    Adresse: <a href="https://goo.gl/maps/equP1jmcJSuFogSc8" target="_blank"><b>Christian-Pommer-Straße 31/33 38112 Braunschweig</b></a><br>
                </span>
            </div>
            <hr>
            <div class="flex gap-1 v-center padding-left-0-5">
                <IodIcon style="color: rgb(5, 150, 105)" icon="local_shipping"/>
                <span>
                    <b>Anlieferung der Messestände</b><br>
                    Mittwoch, 18.09.2024 bis Freitag, 20.09.2024, 6:00 bis 12:00
                </span>
            </div>
            <hr>
            <div class="flex gap-1 v-center padding-left-0-5">
                <IodIcon style="color: rgb(5, 150, 105)" icon="line_start_diamond"/>
                <span>
                    <b>Aufbau der Messestände</b><br>
                    Samstag, 21.09.2024, 9:00 bis 17:00
                </span>
            </div>
            <hr>
            <div class="flex gap-1 v-center padding-left-0-5">
                <IodIcon style="color: rgb(100, 116, 139)" icon="line_end_diamond"/>
                <span>
                    <b>Abbau der Messestände</b><br>
                    Montag, 23.09.2024, nach Messeschluss bis 20:00
                </span>
            </div>
            <hr>
            <div class="flex gap-1 v-center padding-left-0-5">
                <IodIcon style="color: rgb(100, 116, 139); transform: scaleX(-1)" icon="local_shipping"/>
                <span>
                    <b>Abholung der Messestände</b><br>
                    Dienstag, 24.09.2024, 6:00 bis 14:00
                </span>
            </div>
        </div>

        <h2 class="text-align-center">Online-Anmeldung</h2>

        <form class="form" @submit.prevent="submit" v-if="!isSent">
            <div class="group">
                <h4><IodIcon icon="counter_1"/> Kontaktinformationen</h4>
                <div class="subgroup">
                    <IodInput type="text" required border label="Firma" v-model="form.company"/>
                    <IodInput type="text" required border label="Ansprechpartner" v-model="form.name"/>
                    <IodInput type="email" required border label="Email" v-model="form.email"/>
                    <IodInput type="text" required border label="Telefon" v-model="form.phone"/>
                </div>
            </div>


            <div class="group">
                <h4><IodIcon icon="counter_2"/>Rechnungsadresse</h4>
                <div class="subgroup">
                    <IodInput type="text" required border label="Firma / Name" v-model="form.billing_name"/>
                    <IodInput type="text" required border label="Adresse" v-model="form.billing_address"/>
                    <IodInput type="text" required border label="PLZ" v-model="form.billing_zip"/>
                    <IodInput type="text" required border label="Ort" v-model="form.billing_city"/>
                </div>
            </div>


            <div class="group">
                <h4><IodIcon icon="counter_3"/>Ihr Messestand</h4>

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
                    <IodToggle class="toggle-with-input with-flex v-center" border :modelValue="form.options.power220 !== null" @update:modelValue="form.options.power220 = $event ? 0 : null">
                        <template #label>
                            <h6 class="flex-1">220 Volt</h6>
                            <IodInput type="number" suffix="kW" class="toggle-input" min="1" :required="form.options.power220 !== null" v-show="form.options.power220 !== null" v-model="form.options.power220" />
                        </template>
                    </IodToggle>
                    <IodToggle class="toggle-with-input with-flex v-center" border :modelValue="form.options.power380 !== null" @update:modelValue="form.options.power380 = $event ? 0 : null">
                        <template #label>
                            <h6 class="flex-1">380 Volt</h6>
                            <IodInput type="number" suffix="kW" class="toggle-input" min="1" :required="form.options.power380 !== null" v-show="form.options.power380 !== null" v-model="form.options.power380" />
                        </template>
                    </IodToggle>
                </div>

                <div class="subgroup">
                    <h6>Standoptionen</h6>
                    <IodToggle class="toggle-with-input with-flex v-center" border :modelValue="form.options.table !== null" @update:modelValue="form.options.table = $event ? 0 : null">
                        <template #label>
                            <h6 class="flex-1">
                                Tische
                                <small>(20€)</small>
                            </h6>
                            <IodInput type="number" suffix="Stk." class="toggle-input" min="1" :required="form.options.table !== null" v-show="form.options.table !== null" v-model="form.options.table" />
                        </template>
                    </IodToggle>
                    <IodToggle class="toggle-with-input with-flex v-center" border :modelValue="form.options.standing_table !== null" @update:modelValue="form.options.standing_table = $event ? 0 : null">
                        <template #label>
                            <h6 class="flex-1">
                                Stehtische
                                <small>(25€)</small>
                            </h6>
                            <IodInput type="number" suffix="Stk." class="toggle-input" min="1" :required="form.options.standing_table !== null" v-show="form.options.standing_table !== null" v-model="form.options.standing_table" />
                        </template>
                    </IodToggle>
                    <IodToggle class="toggle-with-input with-flex v-center" border :modelValue="form.options.chair !== null" @update:modelValue="form.options.chair = $event ? 0 : null">
                        <template #label>
                            <h6 class="flex-1">
                                Stühle
                                <small>(5€)</small>
                            </h6>
                            <IodInput type="number" suffix="Stk." class="toggle-input" min="1" :required="form.options.chair !== null" v-show="form.options.chair !== null" v-model="form.options.chair" />
                        </template>
                    </IodToggle>
                </div>
            </div>


            <div class="group">
                <h4><IodIcon icon="counter_4"/>Bayerischer Abend</h4>

                <div class="subgroup">
                    <IodToggle label="Ich / wir möchten am bayerischen Abend teilnehmen" class="toggle-with-input" border :modelValue="!!form.participants.length" @update:modelValue="form.participants = $event ? [{...participantTemplate}] : []" />
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
                <h4><IodIcon icon="counter_5"/>Eingaben überprüfen</h4>

                <div class="subgroup">
                    <div class="wrapper flex vertical gap-0-5 padding-1 border radius-m">
                        <p>
                            <b>Kontaktinformationen</b><br>
                            Firma: <b>{{ form.company || '---' }}</b><br>
                            Ansprechpartner: <b>{{ form.name || '---' }}</b><br>
                            Email: <b>{{ form.email || '---' }}</b><br>
                            Telefon: <b>{{ form.phone || '---' }}</b>
                        </p>
                        <hr>
                        <p>
                            <b>Rechnungsadresse</b><br>
                            <template v-if="form.billing_name">{{ form.billing_name }}<br></template>
                            <template v-if="form.billing_address">{{ form.billing_address }}<br></template>
                            <template v-if="[form.billing_zip, form.billing_city].join(' ')">{{ [form.billing_zip, form.billing_city].join(' ') }}</template>
                        </p>
                        <hr>
                        <p>
                            <b>Messestand</b><br>
                            Breite: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.standWidth) }} m</b><br>
                            Tiefe: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.standDepth) }} m</b><br>
                            Fläche: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.standWidth * form.standDepth) }} m²</b><br>
                        </p>
                        <p>
                            <b>Standoptionen</b><br>
                            220V Stromanschluss: <b>{{ form.options.power220 ? new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.options.power220) + ' kW' : "nicht benötigt" }}</b><br>
                            380V Stromanschluss: <b>{{ form.options.power380 ? new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(form.options.power380) + ' kW' : "nicht benötigt" }}</b><br>
                            Tische: <b>{{ form.options.table || 'keine' }}</b><br>
                            Stehtische: <b>{{ form.options.standing_table || 'keine' }}</b><br>
                            Stühle: <b>{{ form.options.chair || 'keine' }}</b><br>
                        </p>
                        <hr>
                        <p class="flex v-center gap-1">
                            <span>
                                Preis: <b>{{ new Intl.NumberFormat("de-DE", {minimumFractionDigits: 2}).format(price) }} Euro zzgl. Ust.</b><br>
                                Der Rechnungsbetrag wird nach Rechnungseingang überwiesen.
                            </span>
                            <div class="spacer"></div>
                            <VDropdown placement="bottom-end">
                                <IodIcon icon="info"/>
                                <template #popper>
                                    <small class="flex vertical padding-1 color-text">
                                        <span>• 100€ pro m² Standfläche</span>
                                        <span>• 100€ für Strom, Wasser, Verpflegung etc.</span>
                                        <span>• 20€ pro Tisch</span>
                                        <span>• 25€ pro Stehtisch</span>
                                        <span>• 5€ pro Stuhl</span>
                                    </small>
                                </template>
                            </VDropdown>
                        </p>
                        <hr>
                        <p>
                            <b>Bayerischer Abend</b><br>
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

                    <IodToggle class="toggle-with-input" border required v-model="form.video">
                        <template #label>
                            Mit der Anmeldung zur Messe stimme ich der Aufzeichnung und Verarbeitung von
                            Foto- und Videoaufnahmen gemäß Art. 13 DSGVO zu.
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
    import { ref, computed } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'



    const isSent = ref(false)

    const participantTemplate = {
        salutation: '',
        firstname: '',
        lastname: '',
    }

    const form = useForm({
        company: '',
        name: '',
        email: '',
        phone: '',
        billing_name: '',
        billing_address: '',
        billing_zip: '',
        billing_city: '',
        standWidth: 4,
        standDepth: 3,
        options: {
            power220: null,
            power380: null,
            table: null,
            chair: null,
            standing_table: null,
        },
        participants: [],
        gdpr: false,
        video: false,
    })

    const price = computed(() => {
        let price = form.standWidth * form.standDepth * 100 + 100

        if (form.options.table) price += form.options.table * 20
        if (form.options.standing_table) price += form.options.standing_table * 25
        if (form.options.chair) price += form.options.chair * 5

        return price
    })



    function addParticipant()
    {
        if (form.participants.length >= 4) return
        form.participants.push({...participantTemplate})
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
        if (!form.video) return

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