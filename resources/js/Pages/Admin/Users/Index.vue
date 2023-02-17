<template>
    <Head title="Nutzer verwalten" />

    <AdminLayout title="Nutzer verwalten" :loading="processing">
        <Table
            class="margin-bottom-2"
            :items="items"
            v-model:selection="selection"
            v-model:search="filter.name"
            v-model:pagination="pagination"
            @selection:delete="openDeletePopup()"
            @request:refetch="getDataThrottled"
            :columns="tableColumns"
        />

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small><b>{{pagination.total}}</b> User</small>
        
            <div class="spacer"></div>

            <mui-button type="button" variant="text" size="small" label="Newsletter" @click="openNewsletterPopup()"/>
            <mui-button type="button" variant="text" size="small" label="Einstellungen" @click="openSettingsPopup()"/>
        </div>
    </AdminLayout>



    <Popup ref="deletePopup" title="Benutzer löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteItems">
            <p>Möchten Sie wirklich <b>{{selection.length}} Benutzer</b> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.deletePopup.close()" />
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen" />
            </div>
        </form>
    </Popup>



    <Popup title="Newsletter Emails" ref="newsletterPopup">
        <div class="flex vertical gap-1 padding-1">
            <div class="flex gap-1 v-center">
                <select class="flex-1" v-model="newsletterForm.newsletter" @change="getNewsletterData()">
                    <option value="generic">Allgemeiner Newsletter</option>
                    <option value="customer">Kunden Newsletter</option>
                </select>
                <mui-button type="button" label="Email-Adressen kopieren" size="large" @click="copyToClipboard(newsletterForm.users.map(e => e.email).join('; '))"/>
            </div>
            
            <div class="background-soft padding-1 radius-m h-20" style="overflow-y: auto;">
                {{ newsletterForm.users.map(e => e.email).join('; ') }}
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
    import { Head, useForm } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import { ref, watch } from 'vue'
    import LocalSetting from '@/Classes/Managers/LocalSetting'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Table from '@/Components/Form/Table/Table.vue'



    // START: Settings Parameters
    const scope = 'users.index'
    // END: Settings Parameters



    const tableColumns = [
        {type: 'text', label: 'Anzeigename', valuePath: 'name', sortable: true, sticky: true, defaultWidth: 300, scaleable: true},
        {type: 'text', label: 'Nutzername', valuePath: 'username', sortable: true, sticky: true, defaultWidth: 150, scaleable: true, transform: (value) => value || '---'},
        {type: 'text', label: 'Email', valuePath: 'email', sortable: true, sticky: false, defaultWidth: 250, scaleable: true},
        {type: 'tags', label: 'Rollen', valuePath: 'roles', sortable: false, sticky: false, defaultWidth: 200, scaleable: true, transform: (value) => {
            if (!value || value.length <= 0)
            {
                return [{icon: null, text: 'Keine Rolle', color: 'var(--color-text)', variant: 'contained', shape: 'pill'}]
            }

            return value.map((role) => ({icon: null, text: role.name, color: 'var(--color-heading)', variant: 'filled', shape: 'pill'}))}
        },
        {type: 'tags', label: 'Profile', valuePath: 'profiles', sortable: false, sticky: false, defaultWidth: 100, scaleable: true, transform: (value) => {
            if (!value || value.length <= 0)
            {
                return [{icon: null, text: 'Kein Profil', color: 'var(--color-text)', variant: 'contained', shape: 'pill'}]
            }

            let profiles = []

            if (value.customer)
            {
                profiles.push({icon: null, text: 'Kunde', color: '#22a6b3', variant: 'filled', shape: 'pill'})
            }

            if (value.employee)
            {
                profiles.push({icon: null, text: 'Personal', color: '#6ab04c', variant: 'filled', shape: 'pill'})
            }
            
            return profiles
        }},
        {type: 'icons', label: 'Status', valuePath: 'status', sortable: false, sticky: false, defaultWidth: 100, scaleable: true, transform: (value, item) => {
            return [
                {
                    icon: 'mail',
                    color: item.email_verified_at ? 'var(--color-success)' : 'var(--color-text)',
                },{
                    icon: 'check_circle',
                    color: item.is_enabled ? 'var(--color-success)' : 'var(--color-text)',
                },
            ]
        }},
        {type: 'actions', label: 'Aktionen', valuePath: null, sortable: false, sticky: false, defaultWidth: null, scaleable: false, transform: (value, item) => {
            return [
                {
                    icon: 'edit',
                    text: 'Bearbeiten',
                    color: 'var(--color-text)',
                    run: () => openItem(item),
                },{
                    icon: 'delete',
                    text: 'Löschen',
                    color: 'var(--color-error)',
                    run: () => openDeletePopup(item),
                },
            ]
        }},
    ]



    // START: Fetch
    const fetchURL = ref('admin.users.search')
    const items = ref([])
    const latestSearch = ref(0)
    const processing = ref(false)


    const filter = ref({
        name: LocalSetting.get(scope, 'filter.name', ''),
        order: LocalSetting.get(scope, 'filter.order', ['name', 'asc']),
    })

    watch(filter, (value) => {
        LocalSetting.set(scope, 'filter.name', value.name)
        LocalSetting.set(scope, 'filter.order', value.order)
    }, { deep: true, immediate: true })


    const pagination = ref({
        page: LocalSetting.get(scope, 'pagination.page', 1),
        size: LocalSetting.get(scope, 'pagination.size', 20),
    })

    watch(pagination, (value) => {
        LocalSetting.set(scope, 'pagination.page', value.page)
        LocalSetting.set(scope, 'pagination.size', value.size)
    }, { deep: true, immediate: true })


    const getData = async () => {
        processing.value = true
        let requestTime = new Date().getTime()

        try
        {
            let response = await axios.get(route(fetchURL.value, {...filter.value, ...pagination.value}))

            if (requestTime > latestSearch.value)
            {
                items.value = response?.data?.data
                pagination.value.total = response?.data?.total
                latestSearch.value = requestTime
            }
        }
        catch (error)
        {
            console.log(error)
        }
        
        processing.value = false
    }

    const getDataThrottled = _.throttle(getData, 300)

    getData()
    // END: Fetch



    // START: Selection
    const selection = ref([])

    const toggleSelection = (item) => {
        if (selection.value.includes(item.id))
        {
            selection.value = selection.value.filter(p => p !== item.id)
        }
        else
        {
            selection.value.push(item.id)
        }
    }

    const setSelection = (item) => {
        selection.value = [item.id]
    }

    const selectAll = () => {
        selection.value = items.value.map(i => i.id)
    }

    const deselectAll = () => {
        selection.value = []
    }
    // END: Selection



    // START: Editor
    const openItem = (item = null) => {
        Inertia.visit(route('admin.users.editor', item?.id))
    }
    // END: Editor



    // START: Delete
    const deletePopup = ref(null)

    const openDeletePopup = (item = null) => {
        if (item) setSelection(item)
        deletePopup.value.open()
    }
    
    const deleteItems = () => {
        useForm({ids: selection.value}).delete(route('admin.users.delete'), {
            onSuccess: () => {
                deletePopup.value.close()
                deselectAll()
                getData()
            },
        })
    }
    // END: Delete



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
    .search-input
        height: 2.5rem !important
        --mui-background: var(--color-background)
        border-radius: var(--radius-m) !important
        box-shadow: var(--shadow-elevation-low)

    .table-wrapper
        background: var(--color-background)
        border-radius: var(--radius-m)
        box-shadow: var(--shadow-elevation-low)
        padding-block: 1rem
        margin: 2rem 0

    table.list
        padding: 0
        width: 100%
        border-collapse: collapse
        border-spacing: 0

        tbody tr
            cursor: pointer

            &:hover,
            &.selected
                background: var(--color-background-soft)

        thead,
        tbody
            border-bottom: 1px solid var(--color-border)

        thead tr th,
        tbody tr td
            padding: 0
            height: 3rem
            text-align: left
            overflow: hidden
            text-overflow: ellipsis
            white-space: nowrap
            padding-inline: .5rem
            max-width: 300px

            &:last-child
                text-align: right
                padding-right: 1rem

            .pfp
                width: 2rem
                height: 2rem
                border-radius: 50%

            .checkbox
                width: 100%
                justify-content: center
                --mui-background: var(--color-background)

            .property
                user-select: none

                &.icon
                    font-size: 1.25rem
                    font-family: var(--font-icon)

                &.green
                    color: var(--color-success)

            .action-wrapper
                display: inline-flex
                align-items: center
                border-radius: var(--radius-m)
                background: var(--color-background-soft)
                
                a,
                button
                    height: 2rem
</style>