<template>
    <AdminLayout :title="form.id ? 'Firma bearbeiten' : 'Firma erstellen'" sticky>
        <template #header-left>
            <IodButton label="Zurück" variant="contained" size="small" :loading="form.processing" is="a" :href="route('admin.companies')" v-tooltip="'Zurück zur Übersicht'"/>
        </template>

        <template #header-right>
            <IodButton label="Speichern" variant="filled" size="small" :loading="form.processing" @click="saveItem()" v-tooltip.bottom="'(STRG+S zum Speichern)'"/>
        </template>
        


        <form class="card flex vertical" @submit.prevent="saveItem()">
            <div class="limiter text-limiter">
                <div class="flex vertical gap-4 padding-block-4">
                    <ValidationErrors />



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Allgemein</b>
                        </div>

                        <IodInput type="text" v-model="form.name" label="Firmenname"/>
                        <IodInput type="text" v-model="form.description" label="Beschreibung"/>
                        <IodInput type="text" v-model="form.notes" label="Notizen"/>
                        <hr>
                        <IodSelect style="width: 100% !important" v-model="form.legal_form" label="Rechtsform" :options="[
                            { value: 'gmbh', text: 'GmbH' },
                            { value: 'gbr', text: 'GbR' },
                            { value: 'ohg', text: 'OHG' },
                            { value: 'kg', text: 'KG' },
                            { value: 'ug', text: 'UG' },
                            { value: 'ag', text: 'AG' },
                            { value: 'eg', text: 'eG' },
                            { value: 'ev', text: 'e.V.' },
                            { value: 'sole-proprietor', text: 'Einzelunternehmen' },
                            { value: 'freelancer', text: 'Freiberufler' },
                            { value: 'other', text: 'Anders' },
                        ]"/>
                    </div>



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Rechtliche Details</b>
                            <IodButton type="button" class="margin-left-auto" label="Neues Detail" size="small" variant="text" @click="addLegalDetail()"/>
                        </div>
                        <div class="flex v-center background-soft radius-m" v-for="legal_detail, i in form.legal_details">
                            <IodIconButton class="margin-0-5" type="button" icon="close" variant="text" color-preset="error" @click="removeLegalDetail(i)"/>
                            <hr class="h-3 vertical">
                            <IodSelect class="w-12" v-model="legal_detail.type" label="Rechtsinfo" :options="[
                                { value: 'vat_id', text: 'Umsatzsteuer ID' },
                                { value: 'tax_id', text: 'Steuernummer' },
                                { value: 'trade_id', text: 'Handelsregister ID' },
                                { value: 'board', text: 'Vorstand' },
                                { value: 'supervisory_board', text: 'Aufsichtsrat' },
                                { value: 'register_court', text: 'Registergericht' },
                            ]"/>
                            <hr class="h-3 vertical">
                            <IodInput class="flex-1" v-model="legal_detail.value" label="Eingabe" />
                        </div>
                    </div>

                    

                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Adressen</b>
                            <IodButton type="button" class="margin-left-auto" label="Neue Adresse" size="small" variant="text" @click="addAddress()"/>
                        </div>

                        <div class="address-grid">
                            <div class="flex vertical background-soft radius-m gap-0-5 padding-block-0-5" v-for="address, i in form.addresses">
                                <IodIcon icon="location_on" class="margin-inline-auto" style="font-size: 4rem; height: 8rem; width: 4rem; color: var(--color-text)" />
                                <hr class="margin-0">
                                <IodSelect style="width: 100% !important" v-model="address.type" label="Adress-Typ" :options="[
                                    { value: 'main', text: 'Hauptadresse' },
                                    { value: 'home', text: 'Zuhause' },
                                    { value: 'work', text: 'Arbeit' },
                                    { value: 'billing', text: 'Rechnungsadresse' },
                                    { value: 'shipping', text: 'Lieferadresse' },
                                    { value: 'other', text: 'Anders' },
                                ]"/>
                                <IodInput v-model="address.address_line_1" label="Straße" />
                                <IodInput v-model="address.postal_code" label="Postleitzahl" />
                                <IodInput v-model="address.city" label="Stadt" />
                                <IodInput v-model="address.country" label="Land" />
                                <hr class="margin-0">
                                <IodButton type="button" class="margin-inline-0-5" label="löschen" size="small" variant="text" color-preset="error" @click="removeAddress(i)"/>
                            </div>
                        </div>
                    </div>



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Bankverbindungen</b>
                            <IodButton type="button" class="margin-left-auto" label="Neue Bankverbindung" size="small" variant="text" @click="addBankDetails()"/>
                        </div>

                        <div class="address-grid">
                            <div class="flex vertical background-soft radius-m gap-0-5 padding-block-0-5" v-for="bank, i in form.bank_details">
                                <IodIcon icon="account_balance" class="margin-inline-auto" style="font-size: 4rem; height: 8rem; width: 4rem; color: var(--color-text)" />
                                <hr class="margin-0">
                                <IodSelect style="width: 100% !important" v-model="bank.type" label="Verbindungs-Typ" :options="[
                                    { value: 'checking', text: 'Girokonto' },
                                    { value: 'savings', text: 'Sparbuch' },
                                    { value: 'business', text: 'Geschäftskonto' },
                                    { value: 'loan', text: 'Kreditkonto' },
                                    { value: 'investment', text: 'Investmentkonto' },
                                    { value: 'other', text: 'Anders' },
                                ]"/>
                                <IodInput v-model="bank.bank_name" label="Bankname" />
                                <IodInput v-model="bank.branch" label="Filiale" />
                                <IodInput v-model="bank.account_name" label="Kontoinhaber" />
                                <IodInput v-model="bank.account_number" label="Kontonummer" />
                                <IodInput v-model="bank.swift_code" label="SWIFT / BIC" />
                                <IodInput v-model="bank.iban" label="IBAN" />
                                <hr class="margin-0">
                                <IodButton type="button" class="margin-inline-0-5" label="löschen" size="small" variant="text" color-preset="error" @click="removeBankDetails(i)"/>
                            </div>
                        </div>
                    </div>

                    

                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Emails</b>
                            <IodButton type="button" class="margin-left-auto" label="Neue Email" size="small" variant="text" @click="addEmail()"/>
                        </div>
                        <div class="flex v-center background-soft radius-m" v-for="email, i in form.emails">
                            <IodIconButton class="margin-0-5" type="button" icon="close" variant="text" color-preset="error" @click="removeEmail(i)"/>
                            <hr class="h-3 vertical">
                            <IodSelect class="w-12" v-model="email.type" label="Email-Typ" :options="[
                                { value: 'main', text: 'Hauptemail' },
                                { value: 'other', text: 'Anders' },
                            ]"/>
                            <hr class="h-3 vertical">
                            <IodInput type="email" class="flex-1" v-model="email.email" label="Email" />
                        </div>
                    </div>

                    

                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Telefonnummern</b>
                            <IodButton type="button" class="margin-left-auto" label="Neuer Nummer" size="small" variant="text" @click="addPhoneNumber()"/>
                        </div>
                        <div class="flex v-center background-soft radius-m" v-for="phone_number, i in form.phone_numbers">
                            <IodIconButton class="margin-0-5" type="button" icon="close" variant="text" color-preset="error" @click="removePhoneNumber(i)"/>
                            <hr class="h-3 vertical">
                            <IodSelect class="w-12" v-model="phone_number.type" label="Nummer-Typ" :options="[
                                { value: 'main', text: 'Hauptnummer' },
                                { value: 'other', text: 'Anders' },
                            ]"/>
                            <hr class="h-3 vertical">
                            <IodInput type="tel" class="flex-1" v-model="phone_number.number" label="Telefonnummer" />
                        </div>
                    </div>

                    

                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Daten</b>
                            <IodButton type="button" class="margin-left-auto" label="Neues Datum" size="small" variant="text" @click="addSignificantDate()"/>
                        </div>
                        <div class="flex v-center background-soft radius-m" v-for="date, i in form.significant_dates">
                            <IodIconButton class="margin-0-5" type="button" icon="close" variant="text" color-preset="error" @click="removeSignificantDate(i)"/>
                            <hr class="h-3 vertical">
                            <IodSelect class="w-12" v-model="date.type" label="Datum-Typ" :options="[
                                { value: 'founding', text: 'Gründungsdatum' },
                                { value: 'other', text: 'Anders' },
                            ]"/>
                            <hr class="h-3 vertical">
                            <input type="date" class="flex-1" v-model="date.date" />
                        </div>
                    </div>

                    

                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Links</b>
                            <IodButton type="button" class="margin-left-auto" label="Neuer Link" size="small" variant="text" @click="addWebsiteLink()"/>
                        </div>
                        <div class="flex v-center background-soft radius-m" v-for="link, i in form.website_links">
                            <IodIconButton class="margin-0-5" type="button" icon="close" variant="text" color-preset="error" @click="removeWebsiteLink(i)"/>
                            <hr class="h-3 vertical">
                            <IodInput class="w-12" v-model="link.name" label="Label" />
                            <hr class="h-3 vertical">
                            <IodInput class="flex-1" v-model="link.url" label="URL" />
                        </div>
                    </div>



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Sonstige Informationen</b>
                        </div>

                        <div class="flex vertical gap-0-5 padding-1 background-soft radius-m">
                            <template v-if="item.id">
                                <span class="flex v-center">
                                    <span class="flex-1">Firmen ID:</span>
                                    <b class="flex-2">{{item.id}}</b>
                                </span>
        
                                <span class="flex v-center">
                                    <span class="flex-1">Erstellt:</span>
                                    <b class="flex-2" v-tooltip="$dayjs(item.created_at).format('DD.MM.YYYY - HH:mm')">{{$dayjs(item.created_at).format('DD.MM.YYYY')}}</b>
                                </span>
                                <hr>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import hotkeys from 'hotkeys-js'
    import { computed, watch } from 'vue'

    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import AdminLayout from '@/Layouts/Admin.vue'
    import Alert from '@/Components/Alert.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); saveItem() })



    const props = defineProps({
        item: Object,
    })



    const form = useForm({
        id: null,
        name: '',
        legal_form: 'gmbh',
        description: '',
        notes: '',

        addresses: [],
        removed_addresses: [],
        legal_details: [],
        removed_legal_details: [],
        bank_details: [],
        removed_bank_details: [],
        emails: [],
        removed_emails: [],
        phone_numbers: [],
        removed_phone_numbers: [],
        significant_dates: [],
        removed_significant_dates: [],
        website_links: [],
        removed_website_links: [],
    })



    const openItem = () => {
        form.id = props.item.id
        form.name = props.item.name || ''
        form.legal_form = props.item.legal_form || 'gmbh'
        form.description = props.item.description || ''
        form.notes = props.item.notes || ''

        form.addresses = props.item.addresses || []
        form.legal_details = props.item.legal_details || []
        form.bank_details = props.item.bank_details || []
        form.emails = props.item.emails || []
        form.phone_numbers = props.item.phone_numbers || []
        form.significant_dates = props.item.significant_dates || []
        form.website_links = props.item.website_links || []
    }

    watch((props) => props?.user, () => {
        openItem(props?.user)
    },{ immediate: true, deep: true })



    // START: Save Item
    const saveItem = () => {
        form.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        form.post(route('admin.companies.store'), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }

    const updateItem = () => {
        form.put(route('admin.companies.update', form.id), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }
    // END: Save Item



    // START: Addresses
    const addAddress = () => {
        form.addresses.push({
            id: null,
            type: 'main',
            address_line_1: '',
            address_line_2: '',
            postal_code: '',
            city: '',
            state: '',
            country: '',
            notes: '',
        })
    }

    const removeAddress = (index) => {
        if (form.addresses[index].id)
        {
            form.removed_addresses.push(form.addresses[index].id)
        }

        form.addresses.splice(index, 1)
    }
    // END: Addresses

    // START: Legal Details
    const addLegalDetail = () => {
        form.legal_details.push({
            id: null,
            type: 'vat_id',
            value: '',
        })
    }

    const removeLegalDetail = (index) => {
        if (form.legal_details[index].id)
        {
            form.removed_legal_details.push(form.legal_details[index].id)
        }

        form.legal_details.splice(index, 1)
    }
    // END: Legal Details

    // START: Bank Details
    const addBankDetails = () => {
        form.bank_details.push({
            id: null,
            type: 'business',
            bank_name: '',
            branch: '',
            account_name: '',
            account_number: '',
            swift_code: '',
            iban: '',
        })
    }

    const removeBankDetails = (index) => {
        if (form.bank_details[index].id)
        {
            form.removed_bank_details.push(form.bank_details[index].id)
        }

        form.bank_details.splice(index, 1)
    }
    // END: Bank Details

    // START: Emails
    const addEmail = () => {
        form.emails.push({
            id: null,
            type: 'main',
            email: '',
            verified_at: null,
        })
    }

    const removeEmail = (index) => {
        if (form.emails[index].id)
        {
            form.removed_emails.push(form.emails[index].id)
        }

        form.emails.splice(index, 1)
    }
    // END: Emails

    // START: Phone Numbers
    const addPhoneNumber = () => {
        form.phone_numbers.push({
            id: null,
            type: 'main',
            number: '',
            verified_at: null,
        })
    }

    const removePhoneNumber = (index) => {
        if (form.phone_numbers[index].id)
        {
            form.removed_phone_numbers.push(form.phone_numbers[index].id)
        }

        form.phone_numbers.splice(index, 1)
    }
    // END: Phone Numbers

    // START: Significant Dates
    const addSignificantDate = () => {
        form.significant_dates.push({
            id: null,
            type: 'founding',
            date: null,
            ignore_year: false,
            repeats_annually: true,
        })
    }

    const removeSignificantDate = (index) => {
        if (form.significant_dates[index].id)
        {
            form.removed_significant_dates.push(form.significant_dates[index].id)
        }

        form.significant_dates.splice(index, 1)
    }
    // END: Significant Dates

    // START: Website Links
    const addWebsiteLink = () => {
        form.website_links.push({
            id: null,
            name: 'Website',
            url: '',
        })
    }

    const removeWebsiteLink = (index) => {
        if (form.website_links[index].id)
        {
            form.removed_website_links.push(form.website_links[index].id)
        }

        form.website_links.splice(index, 1)
    }
    // END: Website Links
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .cb-error
        color: var(--color-error)
        background: #ff000020
        --local-color-off: var(--color-error) !important
        --local-color-on: var(--color-error) !important

    .address-grid
        display: grid
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))
        grid-gap: 1rem
</style>