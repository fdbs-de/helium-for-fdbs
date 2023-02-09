<template>
    <Head title="Nutzer verwalten" />

    <AdminLayout title="Nutzer verwalten" :loading="filter.processing">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()" @delete="openDeletePopup()"/>
            <mui-input v-show="selection.length <= 0" type="search" class="search-input" placeholder="Suchen" v-model="filter.name" @input="getDataThrottled" @clear="getDataThrottled"/>

            <div class="spacer"></div>

            <mui-input type="number" class="search-input w-5" v-model="pagination.page" :min="1" @input="getDataThrottled" />
            <select class="search-input w-5" v-model="pagination.perPage" @change="getDataThrottled">
                <option :value="20">20</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
                <option :value="1000000">alle</option>
            </select>
        </div>

        <div class="table-wrapper" v-show="items.length > 0">
            <table class="list">
                <thead>
                    <tr>
                        <th class="w-3">
                            <mui-toggle class="checkbox" v-tooltip="'Alle Auswählen / Abwählen'" @update:modelValue="$event ? selectAll() : deselectAll()"/>
                        </th>
                        <th>Anzeigename</th>
                        <th>Email</th>
                        <th>Rollen</th>
                        <th>Profile</th>
                        <th>Status</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
    
                <tbody>
                    <tr
                        v-for="item in items"
                        :key="item.id"
                        :class="{ 'selected': selection.includes(item.id) }"
                        @click.exact="toggleSelection(item)"
                        @dblclick="openItem(item)"
                        >
                        <td>
                            <mui-toggle class="checkbox" :modelValue="selection.includes(item.id)" @update:modelValue="toggleSelection(item)" @click.stop/>
                        </td>
                        <td v-tooltip="item.name">{{item.name}}</td>
                        <td v-tooltip="item.email">{{item.email}}</td>
                        <td>
                            <div class="flex v-center wrap" style="gap: .5rem; padding-block: .5rem">
                                <Tag v-for="role in item.roles" :label="role.name" shape="pill"/>
                                <Tag v-if="item.roles.length <= 0" label="Keine Rolle" variant="contained" shape="pill" color="var(--color-text)"/>
                            </div>
                        </td>
                        <td>
                            <div class="flex v-center wrap" style="gap: .5rem; padding-block: .5rem">
                                <Tag v-for="profile in item.profiles" :key="profile" :label="capitalizeWords(profile)" shape="pill" color="var(--color-text)"/>
                            </div>
                        </td>
                        <td>
                            <div class="flex gap-1 v-center">
                                <span class="property icon green" v-tooltip="'Email Bestätigt'" v-if="item.email_verified_at">mail</span>
                                <span class="property icon" v-tooltip="'Emailbestätigung ausstehend'" v-else>mail</span>
                                <span class="property icon green" v-tooltip="'Nutzer freigegeben'" v-if="item.is_enabled">check_circle</span>
                                <span class="property icon" v-tooltip="'Nutzerfreigabe ausstehend'" v-else>check_circle</span>
                            </div>
                        </td>
                        <td>
                            <div class="action-wrapper">
                                <IconButton type="button" icon="delete" style="color: var(--color-error);" v-tooltip="'Löschen'" @click.stop="openDeletePopup(item)"/>
                                <IconButton is="a" icon="edit" v-tooltip="'Bearbeiten'" :href="route('admin.users.editor', item.id)" @click.stop/>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Keine User angelegt</small>

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small><b>{{items.length}}</b> User</small>
        
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
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { Inertia } from '@inertiajs/inertia'
    import { ref, watch, computed } from 'vue'
    import { capitalizeWords } from '@/Utils/String'
    import LocalSetting from '@/Classes/Managers/LocalSetting'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ListItemLayout from '@/Components/Layout/ListItemLayout.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import ImageCard from '@/Components/Form/Card/ImageCard.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Tag from '@/Components/Form/Tag.vue'



    // START: Settings Parameters
    const scope = 'users.index'
    // END: Settings Parameters

    // START: View Parameters
    const layout = ref(LocalSetting.get(scope, 'view.layout', 'list'))
    watch(layout, (value) => LocalSetting.set(scope, 'view.layout', value), { immediate: true })

    const isPreview = ref(LocalSetting.get(scope, 'view.hasPreview', false))
    watch(isPreview, (value) => LocalSetting.set(scope, 'view.hasPreview', value), { immediate: true })
    // END: View Parameters



    // START: Fetch
    const fetchURL = ref('admin.users.search')
    const items = ref([])
    const latestSearch = ref(0)


    const filter = ref({
        name: LocalSetting.get(scope, 'filter.name', ''),
        order: LocalSetting.get(scope, 'filter.order', ['name', 'asc']),
        processing: false,
    })

    watch(filter, (value) => {
        LocalSetting.set(scope, 'filter.name', value.name)
        LocalSetting.set(scope, 'filter.order', value.order)
    }, { deep: true, immediate: true })


    const pagination = ref({
        page: LocalSetting.get(scope, 'pagination.page', 1),
        perPage: LocalSetting.get(scope, 'pagination.perPage', 20),
    })

    watch(pagination, (value) => {
        LocalSetting.set(scope, 'pagination.page', value.page)
        LocalSetting.set(scope, 'pagination.perPage', value.perPage)
    }, { deep: true, immediate: true })


    const getData = async () => {
        filter.value.processing = true
        let requestTime = new Date().getTime()

        try
        {
            let response = await axios.get(route(fetchURL.value, {...filter.value, ...pagination.value}))

            if (requestTime > latestSearch.value)
            {
                items.value = response?.data
                latestSearch.value = requestTime
            }
        }
        catch (error)
        {
            console.log(error)
        }
        
        filter.value.processing = false
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