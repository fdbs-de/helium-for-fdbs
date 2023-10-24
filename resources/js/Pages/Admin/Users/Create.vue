<template>
    <AdminLayout :title="form.id ? 'Account bearbeiten' : 'Account erstellen'" sticky>
        <template #header-left>
            <IodButton label="Zurück" variant="contained" size="small" :loading="form.processing" is="a" :href="route('admin.users')" v-tooltip="'Zurück zur Übersicht'"/>
        </template>

        <template #header-right>
            <IodButton label="Speichern" variant="filled" size="small" :loading="form.processing" @click="saveItem()" v-tooltip.bottom="'(STRG+S zum Speichern)'"/>
        </template>
        


        <form class="card flex vertical" @submit.prevent="saveItem()">
            <div class="flex vertical">
                <img class="w-100 h-20 object-fit-cover radius-top-m" src="/images/app/defaults/user_banner.png">
                <div class="flex border-bottom padding-block-1">
                    <div class="limiter text-limiter">
                        <Tabs v-model="tab" indicator-style="box" :tabs="[
                            { label: 'Allgemeines', value: 'general' },
                            { label: 'Berechtigungen', value: 'permissions' },
                            { label: 'Profile', value: 'profiles' },
                            { label: 'Info', value: 'info' },
                        ]" />
                    </div>
                </div>
            </div>

            <div class="limiter text-limiter">
                <div class="flex vertical gap-4 padding-block-2">
                    <ValidationErrors />



                    <div class="flex vertical gap-1" v-show="tab == 'general'">
                        <IodInput type="text" v-model="form.username" label="Username"/>
                        <IodInput type="email" v-model="form.email" label="Email" :helper="domainMatch && !!user.email_verified_at ? 'Dieser Nutzer hat eine Domain-Email-Adresse' : null"/>
                        <IodInput type="password" label="Passwort setzen" autocomplete="new-password" no-border show-password-score :password-score-function="zxcvbn" v-model="form.password"/>
                        
                        <hr>

                        <div class="flex v-center gap-1 wrap">
                            <IodToggle class="flex-1 background-soft" label="Email verifiziert" :modelValue="!!form.email_verified_at" @update:modelValue="form.email_verified_at = $event ? new Date() : null "/>
                            <IodToggle class="flex-1 background-soft" label="Freigegeben" :modelValue="!!form.enabled_at" @update:modelValue="form.enabled_at = $event ? new Date() : null "/>
                        </div>
                        
                        <Alert type="warning" title="Email ist nicht verifiziert" v-if="!!form.enabled_at && !user.email_verified_at">
                            <p>
                                Der Nutzer hat seine Email noch nicht bestätigt.<br>
                                Vorsicht bei der Freischaltung – es kann sich um einen <b>Bot oder Spam-Account</b> handeln!
                            </p>
                        </Alert>

                        <hr>

                        <IodToggle class="background-soft" label="Allgemeiner Newsletter" v-model="form.newsletter.generic"/>
                        <IodToggle class="background-soft" label="Kunden Newsletter" v-model="form.newsletter.customer"/>
                    </div>



                    <div class="flex vertical gap-1" v-show="tab == 'permissions'">
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
                    


                    <div class="flex vertical gap-1" v-show="tab == 'profiles'">
                        <IodToggle type="switch" label="Kundenprofil" v-model="form.profiles.customer.has_customer_profile"/>
                        
                        <template v-if="form.profiles.customer.has_customer_profile">
                            <IodInput v-model="form.profiles.customer.company" label="Firmenname" />
                            <IodInput v-model="form.profiles.customer.customer_id" label="Kundennummer" />
                        </template>

                        <hr>
                        
                        <IodToggle type="switch" label="Mitarbeiterprofil" v-model="form.profiles.employee.has_employee_profile"/>
    
                        <template v-if="form.profiles.employee.has_employee_profile">
                            <IodInput v-model="form.profiles.employee.first_name" label="Vorname" />
                            <IodInput v-model="form.profiles.employee.last_name" label="Nachname" />
                        </template>
                    </div>


    
                    <div class="flex vertical" v-show="tab == 'info'">
                        <span>
                            Kennt uns durch:
                            <b v-if="user.settings_object.referal">{{user.settings_object.referal.join(', ')}}</b>
                            <b v-else><i>Nicht Angegeben</i></b>
                        </span>

                        <template v-if="user.id">
                            <span>
                                UserID:
                                <b>{{user.id}}</b>
                            </span>
    
                            <span>
                                Erstellt:
                                <b v-tooltip="$dayjs(user.created_at).format('DD.MM.YYYY - HH:mm')">{{$dayjs(user.created_at).format('DD.MM.YYYY')}}</b>
                            </span>
    
                            <span v-if="user.email_verified_at">
                                Bestätigt:
                                <b v-tooltip="$dayjs(user.email_verified_at).format('DD.MM.YYYY - HH:mm')">{{$dayjs(user.email_verified_at).format('DD.MM.YYYY')}}</b>
                            </span>
    
                            <span v-if="user.enabled_at">
                                Freigegeben:
                                <b v-tooltip="$dayjs(user.enabled_at).format('DD.MM.YYYY - HH:mm')">{{$dayjs(user.enabled_at).format('DD.MM.YYYY')}}</b>
                            </span>
                        </template>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
    import { useForm, usePage } from '@inertiajs/inertia-vue3'
    import hotkeys from 'hotkeys-js'
    import { ref, computed, watch } from 'vue'
    import zxcvbn from 'zxcvbn'

    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import AdminLayout from '@/Layouts/Admin.vue'
    import Tabs from '@/Components/Form/Tabs.vue'
    import Alert from '@/Components/Alert.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); saveItem() })



    const props = defineProps({
        user: Object,
        roles: Array,
        settings: Object,
    })



    const tab = ref('general')

    const form = useForm({
        id: null,
        email: '',
        username: '',
        password: '',
        enabled_at: null,
        email_verified_at: null,
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
        form.email = props.user.email || ''
        form.username = props.user.username || ''
        form.password = ''
        form.enabled_at = props.user.enabled_at
        form.email_verified_at = props.user.email_verified_at

        form.profiles.customer.has_customer_profile = !!props.user.profiles.customer
        form.profiles.customer.company = props.user.profiles?.customer?.company || ''
        form.profiles.customer.customer_id = props.user.profiles?.customer?.customer_id || ''

        form.profiles.employee.has_employee_profile = !!props.user.profiles.employee
        form.profiles.employee.first_name = props.user.profiles?.employee?.first_name || ''
        form.profiles.employee.last_name = props.user.profiles?.employee?.last_name || ''

        form.roles = props.user.roles?.map(e => e.id)

        form.newsletter.generic = props.user.settings_object['newsletter.subscribed.generic'] || false
        form.newsletter.customer = props.user.settings_object['newsletter.subscribed.customer'] || false
    }

    watch((props) => props?.user, () => {
        openItem(props?.user)
    },{ immediate: true, deep: true })



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
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
</style>