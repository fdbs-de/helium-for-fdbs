<template>
    <AdminLayout :title="IPM.options.pageTitle">
        <Table
            show-create
            :columns="tableColumns"
            :actions="tableActions"
            :filter-settings="tableFilters"
            :items="IPM.items"
            :scope="IPM.tableScope"
            :loading="IPM.processing"
            v-model:selection="IPM.selection"
            v-model:filter="IPM.modelFilter"
            v-model:sort="IPM.modelSort"
            v-model:pagination="IPM.modelPagination"
            @request:refresh="IPM.fetch()"
            @request:create="IPM.open()"
        />

        <div class="flex v-center gap-1 wrap border-top padding-top-1 margin-top-2">
            <div class="spacer"></div>
            <IodButton type="button" variant="text" size="small" label="Einladungen" @click="openInvitesPopup()"/>
            <IodButton type="button" variant="text" size="small" label="Newsletter" @click="openNewsletterPopup()"/>
            <IodButton type="button" variant="text" size="small" label="Einstellungen" @click="openSettingsPopup()"/>
        </div>
    </AdminLayout>



    <Popup title="Einladungen" ref="invitesPopup" position="right" style="--max-width: 400px;">
        <div class="flex vertical gap-1 padding-1 h-100">
            <select class="w-100" v-model="invitesForm.invite" @change="getInvitesData()">
                <option value="sommerfest">Sommerfest</option>
            </select>

            <select class="w-100" v-model="invitesForm.status" @change="getInvitesData()">
                <option value="yes">Angenommen</option>
                <option value="no">Abgelehnt</option>
            </select>

            <div class="flex vertical background-soft padding-0-5 radius-m flex-1">
                <div class="flex-1 flex vertical" style="overflow-y: auto;">
                    <span v-for="user in invitesForm.users">{{ user.name }} – {{ user.email }}</span>
                </div>
                <mui-button type="button" :label="invitesForm.users.length+' Emails kopieren'" size="small" @click="copyToClipboard(invitesForm.users.map(e => e.email).join('; '))"/>
            </div>
        </div>
    </Popup>



    <Popup title="Newsletter Emails" ref="newsletterPopup" position="right" style="--max-width: 400px;">
        <div class="flex vertical gap-1 padding-1 h-100">
            <select class="w-100" v-model="newsletterForm.newsletter" @change="getNewsletterData()">
                <option value="generic">Allgemeiner Newsletter</option>
                <option value="customer">Kunden Newsletter</option>
            </select>

            <div class="flex vertical background-soft padding-0-5 radius-m flex-1">
                <div class="flex-1 flex vertical" style="overflow-y: auto;">
                    <span v-for="user in newsletterForm.users">{{ user.email }};</span>
                </div>
                <mui-button type="button" :label="newsletterForm.users.length+' Emails kopieren'" size="small" @click="copyToClipboard(newsletterForm.users.map(e => e.email).join('; '))"/>
            </div>
        </div>
    </Popup>
        
        
        
    <Popup title="Einstellungen" ref="settingsPopup">
        <div class="flex vertical gap-1 padding-1">
            <h5 class="margin-0">Globale Benutzer Verwaltung</h5>
            
            <fieldset class="flex vertical padding-inline-0">
                <mui-toggle type="switch" v-model="settingsForm.fixProfiles" label="Profile migrieren" v-tooltip="'Diese Option migriert die alten Benutzerprofile zu den neuen user-settings'"/>
                <mui-toggle type="switch" v-model="settingsForm.updateNames" label="Anzeigenamen aktualisieren" v-tooltip="'Diese Option synkronisiert die Anzeigenamen mit den Daten der Benutzerprofile'"/>
            </fieldset>
            
            <div class="flex">
                <div class="spacer"></div>
                <mui-button type="button" label="Einstellungen speichern" @click="saveSettings()"/>
            </div>
        </div>
    </Popup>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'
    import dayjs from 'dayjs'
    import ItemPageManager from '@/Classes/Managers/ItemPageManager'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    const props = defineProps({
        roles: {
            type: Array,
            default: () => [],
        },
    })



    const IPM = ref(new ItemPageManager({
        pageTitle: 'Accounts verwalten',
        scope: 'admin.users.index',
        routes: {
            fetch: 'admin.users.search',
            editor: 'admin.users.editor',
            duplicate: 'admin.users.duplicate',
            delete: 'admin.users.delete',
        }
    }))

    IPM.value.fetch()



    const tableColumns = [
        {type: 'text', name: 'name', label: 'Name', valuePath: 'name', sortable: true, width: 300, resizeable: true, hideable: true},
        {type: 'text', name: 'username', label: 'Nutzername', valuePath: 'username', sortable: true, width: 150, resizeable: true, hideable: true, transform: (value) => value || '-'},
        {type: 'text', name: 'email', label: 'Email', valuePath: 'email', sortable: true, width: 250, resizeable: true, hideable: true, transform: (value) => value || '-' },
        {type: 'text', name: 'roles', label: 'Rollen', valuePath: 'roles', sortable: false, width: 200, resizeable: true, hideable: true, transform: (value) => {
            return value.map(e => e.name).join(', ') || '-'
        }},
        {type: 'text', name: 'profiles', label: 'Profile', valuePath: 'profiles', sortable: false, width: 100, resizeable: true, hideable: true, transform: (value) => {
            let profiles = []
            if (value.customer) profiles.push('Kunde')
            if (value.employee) profiles.push('Personal')
            return profiles.join('; ') || '-'
        }},
        {type: 'date', name: 'created_at', label: 'Registriert am', valuePath: 'created_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'date', name: 'email_verified_at', label: 'Verifikation am', valuePath: 'email_verified_at', sortable: true, width: 200, resizeable: true, hideable: true},
        {type: 'tags', name: 'status', label: 'Status', valuePath: 'status', sortable: false, width: 100, resizeable: true, hideable: true, transform: (value, item) => {
            if (item.is_enabled) return [{icon: null, text: 'Aktiv', color: 'var(--color-success)', variant: 'filled', shape: 'pill'}]
            return [{icon: null, text: 'Ausstehend', color: 'var(--color-warning)', variant: 'filled', shape: 'pill'}]
        }},
    ]

    const tableActions = [
        {
            icon: 'edit',
            text: 'Bearbeiten',
            color: 'var(--color-text)',
            individual: true,
            multiple: false,
            triggerOnRowClick: true,
            isAvailable: () => true,
            run: (items) => IPM.value.open(items[0]),
        },
        {
            icon: 'delete',
            text: 'Löschen',
            color: 'var(--color-error)',
            individual: true,
            multiple: true,
            triggerOnRowClick: false,
            isAvailable: () => true,
            run: (items) => IPM.value.delete(items, 'Sollen {{count}} Benutzer gelöscht werden?'),
        },
    ]

    const tableFilters = [
        {
            type: 'select',
            multiple: true,
            name: 'profiles',
            label: 'Profile',
            values: [
                {text: 'Kunde', value: 'customer'},
                {text: 'Personal', value: 'employee'},
            ],
        },
        {
            type: 'select',
            multiple: true,
            name: 'roles',
            label: 'Rollen',
            values: props.roles.map(e => ({text: e.name, value: e.name})),
        },
        {
            type: 'select',
            multiple: true,
            name: 'newsletter',
            label: 'Newsletter',
            values: [
                {text: 'Allgemein', value: 'generic'},
                {text: 'Kunden', value: 'customer'},
            ],
        },
    ]



    // START: Newsletter
    const newsletterPopup = ref(null)

    const newsletterForm = useForm({
        newsletter: 'generic',
        users: [],
    })

    const openNewsletterPopup = () => {
        getNewsletterData()
        newsletterPopup.value.open()
    }

    const getNewsletterData = async () => {
        try
        {
            let response = await axios.get(route('admin.newsletter.search'), {params: {newsletter: newsletterForm.newsletter}})
            newsletterForm.users = response.data
        }
        catch (error)
        {
            console.log(error)
        }
    }

    const copyToClipboard = (text) => {
        navigator.clipboard.writeText(text)
    }
    // END: Newsletter



    // START: Invites
    const invitesPopup = ref(null)

    const invitesForm = useForm({
        invite: 'sommerfest',
        status: 'yes',
        users: [],
    })

    const openInvitesPopup = () => {
        getInvitesData()
        invitesPopup.value.open()
    }

    const getInvitesData = async () => {
        try
        {
            let response = await axios.get(route('admin.invites.search'), {params: {
                invite: invitesForm.invite,
                status: invitesForm.status
            }})

            invitesForm.users = response.data
        }
        catch (error)
        {
            console.log(error)
        }
    }
    // END: Invites



    // START: Global Settings
    const settingsPopup = ref(null)

    const settingsForm = useForm({
        fixProfiles: false,
        updateNames: false,
    })

    const openSettingsPopup = () => {
        settingsPopup.value.open()
    }

    const saveSettings = () => {
        settingsForm.patch(route('admin.users.settings'))
    }
    // END: Global Settings
</script>

<style lang="sass" scoped>
</style>