<template>
    <AdminLayout :title="form.id ? 'Account bearbeiten' : 'Account erstellen'" sticky>
        <template #header-left>
            <IodButton label="Zurück" variant="contained" size="small" :loading="form.processing" is="a" :href="route('admin.users')" v-tooltip="'Zurück zur Übersicht'"/>
        </template>

        <template #header-right>
            <IodButton label="Speichern" variant="filled" size="small" :loading="form.processing" @click="saveItem()" v-tooltip.bottom="'(STRG+S zum Speichern)'"/>
        </template>
        


        <form class="card flex vertical" @submit.prevent="saveItem()">
            <div class="profile-card">
                <div class="profile-banner" :style="{backgroundImage: `url(/images/app/defaults/user_banner.png)`}"></div>
                <div class="profile-image">
                    <img :src="user.image" :alt="user.name">
                </div>
                <div class="profile-info">
                    <h2>{{ user.name ?? user.email }}</h2>
                    <p v-if="user.username">@{{ user.username }}</p>
                </div>
            </div>

            <div class="limiter text-limiter">
                <div class="flex vertical gap-4 padding-block-4">
                    <ValidationErrors />



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Account</b>
                        </div>

                        <IodInput type="text" v-model="form.name" label="Anzeigename"/>

                        <IodInput type="email" v-model="form.email" label="Email">
                            <template #right>
                                <IodIconButton type="button" variant="text" icon="domain" style="color: var(--color-text)" v-if="domainMatch && !!user.email_verified_at" v-tooltip="'Dieser Nutzer hat eine Domain-Email-Adresse'"/>
                            </template>
                        </IodInput>
                        <IodInput type="password" label="Passwort setzen" autocomplete="new-password" no-border show-password-score :password-score-function="zxcvbn" v-model="form.password"/>
                        <div class="flex v-center gap-0-5">
                            <IodInput type="text" class="flex-1" v-model="form.custom_account_id" label="Kundennummer"/>
                            <IodInput type="text" class="flex-1" v-model="form.username" label="Username"/>
                        </div>

                        <hr>

                        <div class="flex v-center gap-1 wrap">
                            <IodToggle class="flex-1 background-soft" label="Email verifiziert" :modelValue="!!form.email_verified_at" @update:modelValue="form.email_verified_at = $event ? new Date() : null "/>
                            <IodToggle class="flex-1 background-soft" label="Freigegeben" :modelValue="!!form.enabled_at" @update:modelValue="form.enabled_at = $event ? new Date() : null "/>
                            <IodToggle class="flex-1 background-soft cb-error" label="Gesperrt" :modelValue="!!form.terminated_at" @update:modelValue="form.terminated_at = $event ? new Date() : null "/>
                        </div>

                        <hr v-if="!!form.enabled_at && !user.email_verified_at">

                        <Alert type="warning" title="Email ist nicht verifiziert" v-if="!!form.enabled_at && !user.email_verified_at">
                            <p>
                                Der Nutzer hat seine Email noch nicht bestätigt.<br>
                                Vorsicht bei der Freischaltung – es kann sich um einen <b>Bot oder Spam-Account</b> handeln!
                            </p>
                        </Alert>
                    </div>



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Rollen</b>
                        </div>

                        <div class="flex gap-1 wrap">
                            <IodToggle class="background-soft"
                                v-for="role in roles"
                                :key="role.id"
                                :label="role.name"
                                :modelValue="form.roles.includes(role.id)"
                                @update:modelValue="toggleRole(role.id)"
                            />
                        </div>
                    </div>



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Kundenprofil (veraltet)</b>
                            <IodToggle type="switch" v-model="form.profiles.customer.has_customer_profile"/>
                        </div>
                
                        <template v-if="form.profiles.customer.has_customer_profile">
                            <IodInput v-model="form.profiles.customer.company" label="Firmenname" />
                            <IodInput v-model="form.profiles.customer.customer_id" label="Kundennummer" />
                        </template>
                    </div>



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Mitarbeiterprofil (veraltet)</b>
                            <IodToggle type="switch" v-model="form.profiles.employee.has_employee_profile"/>
                        </div>
                        
                        <template v-if="form.profiles.employee.has_employee_profile">
                            <IodInput v-model="form.profiles.employee.first_name" label="Vorname" />
                            <IodInput v-model="form.profiles.employee.last_name" label="Nachname" />
                        </template>
                    </div>



                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Newsletter</b>
                        </div>
                        <IodToggle class="background-soft" label="Allgemeiner Newsletter" v-model="form.newsletter.generic"/>
                        <IodToggle class="background-soft" label="Kunden Newsletter" v-model="form.newsletter.customer"/>
                    </div>

                    

                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Name</b>
                        </div>

                        <IodInput v-model="form.details.prefix" label="Titel" />
                        <IodInput v-model="form.details.firstname" label="Vorname" />
                        <IodInput v-model="form.details.middlename" label="Zweiter Vorname" />
                        <IodInput v-model="form.details.lastname" label="Nachname" />
                        <IodInput v-model="form.details.suffix" label="Suffix" />
                        <IodInput v-model="form.details.nickname" label="Spitzname" />
                        <IodInput v-model="form.details.legalname" label="Name für Rechtliches" />
                    </div>

                    

                    <div class="flex vertical gap-0-5">
                        <div class="flex gap-0-5 v-center">
                            <b class="flex-1 padding-left-0-5 color-heading user-select-none">Firma</b>
                        </div>

                        <IodInput v-model="form.details.company" label="Firma" />
                        <IodInput v-model="form.details.department" label="Abteilung" />
                        <IodInput v-model="form.details.title" label="Jobtitel" />
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
                                { value: 'home', text: 'Privat' },
                                { value: 'work', text: 'Arbeit' },
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
                                { value: 'home', text: 'Privat' },
                                { value: 'work', text: 'Arbeit' },
                                { value: 'mobile', text: 'Mobil' },
                                { value: 'fax', text: 'Fax' },
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
                                { value: 'birthday', text: 'Geburtstag' },
                                { value: 'anniversary', text: 'Jahrestag' },
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
                            <template v-if="user.id">
                                <span class="flex v-center">
                                    <span class="flex-1">User ID:</span>
                                    <b class="flex-2">{{user.id}}</b>
                                </span>
        
                                <span class="flex v-center">
                                    <span class="flex-1">Erstellt:</span>
                                    <b class="flex-2" v-tooltip="$dayjs(user.created_at).format('DD.MM.YYYY - HH:mm')">{{$dayjs(user.created_at).format('DD.MM.YYYY')}}</b>
                                </span>
        
                                <span class="flex v-center" v-if="user.email_verified_at">
                                    <span class="flex-1">Bestätigt:</span>
                                    <b class="flex-2" v-tooltip="$dayjs(user.email_verified_at).format('DD.MM.YYYY - HH:mm')">{{$dayjs(user.email_verified_at).format('DD.MM.YYYY')}}</b>
                                </span>
        
                                <span class="flex v-center" v-if="user.enabled_at">
                                    <span class="flex-1">Freigegeben:</span>
                                    <b class="flex-2" v-tooltip="$dayjs(user.enabled_at).format('DD.MM.YYYY - HH:mm')">{{$dayjs(user.enabled_at).format('DD.MM.YYYY')}}</b>
                                </span>

                                <hr>

                                <span class="flex v-center">
                                    <span class="flex-1">Posts:</span>
                                    <b class="flex-2">{{ user.resources.post_count ?? 0 }}</b>
                                </span>

                                <span class="flex v-center">
                                    <span class="flex-1">Kategorien:</span>
                                    <b class="flex-2">{{ user.resources.post_category_count ?? 0 }}</b>
                                </span>
                                <hr>
                            </template>

                            <span class="flex v-center">
                                <span class="flex-1">Kennt uns durch:</span>
                                <b class="flex-2" v-if="user.settings_object.referal">{{user.settings_object.referal.join(', ')}}</b>
                                <b class="flex-2" v-else><i>Nicht Angegeben</i></b>
                            </span>
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
    import zxcvbn from 'zxcvbn'

    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import AdminLayout from '@/Layouts/Admin.vue'
    import Alert from '@/Components/Alert.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); saveItem() })



    const props = defineProps({
        user: Object,
        roles: Array,
        settings: Object,
    })



    const form = useForm({
        id: null,
        name: '',
        email: '',
        username: '',
        custom_account_id: '',
        password: '',
        email_verified_at: null,
        enabled_at: null,
        terminated_at: null,
        details: {
            prefix: '',
            firstname: '',
            middlename: '',
            lastname: '',
            suffix: '',
            nickname: '',
            legalname: '',
            company: '',
            department: '',
            title: '',
        },
        profiles: {
            customer: {
                has_customer_profile: false,
                company: '',
                customer_id: '',
            },
            employee: {
                has_employee_profile: false,
                first_name: '',
                last_name: '',
            },
        },
        addresses: [],
        removed_addresses: [],
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
        roles: [],
        newsletter: {
            generic: false,
            customer: false,
        }
    })

    const domainMatch = computed(() => {
        let siteDomain = usePage()?.props?.value?.settings['site.domain'] || null

        if (!siteDomain) return false

        return props.user?.email?.endsWith('@' + siteDomain)
    })



    const openItem = () => {
        form.id = props.user.id
        form.name = props.user.name || ''
        form.email = props.user.email || ''
        form.username = props.user.username || ''
        form.custom_account_id = props.user.custom_account_id || ''
        form.password = ''
        form.enabled_at = props.user.enabled_at
        form.terminated_at = props.user.terminated_at
        form.email_verified_at = props.user.email_verified_at

        form.profiles.customer.has_customer_profile = !!props.user.profiles.customer
        form.profiles.customer.company = props.user.profiles?.customer?.company || ''
        form.profiles.customer.customer_id = props.user.profiles?.customer?.customer_id || ''

        form.profiles.employee.has_employee_profile = !!props.user.profiles.employee
        form.profiles.employee.first_name = props.user.profiles?.employee?.first_name || ''
        form.profiles.employee.last_name = props.user.profiles?.employee?.last_name || ''

        form.details.prefix = props.user.details?.prefix || ''
        form.details.firstname = props.user.details?.firstname || ''
        form.details.middlename = props.user.details?.middlename || ''
        form.details.lastname = props.user.details?.lastname || ''
        form.details.suffix = props.user.details?.suffix || ''
        form.details.nickname = props.user.details?.nickname || ''
        form.details.legalname = props.user.details?.legalname || ''
        form.details.company = props.user.details?.company || ''
        form.details.department = props.user.details?.department || ''
        form.details.title = props.user.details?.title || ''

        form.addresses = props.user.addresses || []
        form.bank_details = props.user.bank_details || []
        form.emails = props.user.emails || []
        form.phone_numbers = props.user.phone_numbers || []
        form.significant_dates = props.user.significant_dates || []
        form.website_links = props.user.website_links || []

        form.roles = props.user.roles?.map(e => e.id)

        form.newsletter.generic = props.user.settings_object['newsletter.subscribed.generic'] || false
        form.newsletter.customer = props.user.settings_object['newsletter.subscribed.customer'] || false
    }

    watch((props) => props?.user, () => {
        openItem(props?.user)
    },{ immediate: true, deep: true })



    // START: Save Item
    const saveItem = () => {
        form.id ? updateItem() : storeItem()
    }

    const storeItem = () => {
        form.post(route('admin.users.store'), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }

    const updateItem = () => {
        form.put(route('admin.users.update', form.id), {
            preserveScroll: true,
            onSuccess: (data) => {
                openItem(data?.props?.post)
            },
        })
    }
    // END: Save Item



    // START: Roles
    const toggleRole = (role) => {
        if (form.roles.includes(role))
        {
            form.roles = form.roles.filter(e => e !== role)
        }
        else
        {
            form.roles.push(role)
        }
    }
    // END: Roles

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

    // START: Bank Details
    const addBankDetails = () => {
        form.bank_details.push({
            id: null,
            type: 'checking',
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
            type: 'birthday',
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

    .profile-card
        width: 100%
        display: flex
        flex-direction: column
        align-items: center
        text-align: center
        border-radius: var(--radius-m) var(--radius-m) 0 0
        border-bottom: 1px solid var(--color-border)
        overflow: hidden

        .profile-banner
            width: 100%
            height: 12rem
            background-size: cover
            background-position: center
            background-repeat: no-repeat
            background-color: var(--color-background-soft)

        .profile-image
            width: 10rem
            height: 10rem
            margin-top: -5rem
            border-radius: 50%
            background: var(--color-background)
            position: relative

            &::before,
            &::after
                content: ''
                position: absolute
                bottom: 50%
                width: 1.5rem
                height: 1.5rem
                background: transparent
                pointer-events: none

            &::before
                right: calc(100% - 1px)
                border-radius: 0 0 var(--radius-xl) 0
                box-shadow: .75rem .75rem 0 var(--color-background)

            &::after
                left: calc(100% - 1px)
                border-radius: 0 0 0 var(--radius-xl)
                box-shadow: -.75rem .75rem 0 var(--color-background)

            img
                width: 100%
                height: 100%
                object-fit: cover
                border-radius: 50%
                border: 5px solid var(--color-background)
                position: relative
                z-index: 1

        .profile-info
            width: 100%
            display: flex
            flex-direction: column
            align-items: center
            padding-block: 1rem 2rem

            h2
                margin: 0
                font-size: 1.5rem
                font-weight: 600

            p
                margin: 0
</style>