<template>
    <Head title="Nutzer verwalten" />

    <AdminLayout title="Nutzer verwalten" :loading="filter.processing">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()"/>
            <mui-input v-show="selection.length <= 0" type="search" class="search-input" placeholder="Suchen" v-model="filter.name" @input="getDataThrottled" />

            <div class="spacer"></div>

            <!-- <div class="flex v-center">
                <IconButton type="button" icon="search" v-tooltip="'Suchen'"/>
            </div> -->

            <mui-input type="number" class="search-input w-4" v-model="pagination.page" :min="1" @input="getDataThrottled" />
            <select class="search-input w-4" v-model="pagination.perPage" @change="getDataThrottled">
                <option :value="20">20</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
                <option :value="1000000">alle</option>
            </select>

            <Switcher v-model="layout" :options="[
                { value: 'list', icon: 'view_list', tooltip: 'Listenansicht' },
                { value: 'grid', icon: 'grid_view', tooltip: 'Kachelansicht' },
            ]"/>
        </div>

        <ListItemLayout class="w-100 margin-block-2" :layout="layout" v-show="items.length >= 1">
            <ImageCard
                v-for="item in items"
                :key="item.id"
                :item="item"
                :layout="layout"
                :enable-preview="isPreview"
                :selection="selection"
                @contextmenu.prevent.exact="setSelection(item)"
                @contextmenu.prevent.ctrl="toggleSelection(item)"
                @click.ctrl="toggleSelection(item)"
                @click.exact="openItem(item)"
                @open="openItem(item)"
                />
        </ListItemLayout>
        <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Keine User angelegt</small>

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small><b>{{items.length}}</b> User</small>
        
            <div class="spacer"></div>

            <mui-button type="button" variant="text" size="small" label="Newsletter" @click="openNewsletterPopup()"/>
            <mui-button type="button" variant="text" size="small" label="Einstellungen" @click="openSettingsPopup()"/>
        </div>
    </AdminLayout>



    <Popup title="Newsletter Emails" ref="newsletterPopup">
        <div class="flex vertical gap-1 padding-1">
            <div class="flex">
                <select class="flex-1" v-model="newsletterForm.newsletter" @change="getNewsletterData()">
                    <option value="generic">Allgemeiner Newsletter</option>
                    <option value="customer">Kunden Newsletter</option>
                </select>
                <div class="spacer"></div>
                <mui-button type="button" label="In Zwischenablage kopieren" @click="copyToClipboard(newsletterForm.users.map(e => e.email).join('; '))"/>
            </div>
            
            <div class="background-soft padding-1 radius-m h-20" style="overflow-y: auto;">
                {{ newsletterForm.users.map(e => e.email).join(';') }}
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
    import { ref, computed } from 'vue'
    import ItemInterface from '@/Interfaces/User.js'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ListItemLayout from '@/Components/Layout/ListItemLayout.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import ImageCard from '@/Components/Form/Card/ImageCard.vue'
    import Popup from '@/Components/Form/Popup.vue'



    // START: View Parameters
    const layout = ref('list')
    const isPreview = ref(false)
    // END: View Parameters



    // START: Fetch
    const fetchURL = ref('admin.users.search')
    const items = ref([])

    const filter = ref({
        name: '',
        order: ['name', 'asc'],
        processing: false,
    })

    const pagination = ref({
        page: 1,
        perPage: 20,
    })

    const getData = async () => {
        filter.value.processing = true

        try
        {
            let response = await axios.get(route(fetchURL.value, {...filter.value, ...pagination.value}))
            items.value = response?.data?.map(item => new ItemInterface(item))
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
        selection.value = itemObjects.map(i => i.id)
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
            console.log(response.data)
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
</style>