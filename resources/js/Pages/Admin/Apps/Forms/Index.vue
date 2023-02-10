<template>
    <Head title="Formulare verwalten" />

    <AdminLayout title="Formulare verwalten">
        <div class="flex v-center gap-1">
            <Actions v-show="selection.length >= 1" :selection="selection" @deselect="deselectAll()" @delete="openDeletePopup()"/>

            <div class="spacer"></div>

            <div class="flex v-center">
                <!-- <button class="icon-button" aria-hidden="true" v-tooltip="'Suchen'">search</button> -->
                <VDropdown placement="bottom-end">
                    <IconButton type="button" icon="settings" v-tooltip="'Ansichtseinstellungen'" />
                    <template #popper>
                        <div class="flex padding-1 vertical">
                            <mui-toggle type="switch" prepend-label="Bildvorschau" v-model="isPreview" />
                        </div>
                    </template>
                </VDropdown>
            </div>
        </div>

        <div class="table-wrapper" v-show="items.length > 0">
            <table class="list">
                <thead>
                    <tr>
                        <th class="w-3">
                            <mui-toggle class="checkbox" v-tooltip="'Alle Auswählen / Abwählen'" @update:modelValue="$event ? selectAll() : deselectAll()"/>
                        </th>
                        <th>Name</th>
                        <th>Seiten</th>
                        <th>Felder</th>
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
                        <td>{{item.pages.length}}</td>
                        <td>{{item.input_count}}</td>
                        <td>
                            <Tag :label="capitalizeWords(item.status)" variant="contained" shape="pill"/>
                        </td>
                        <td>
                            <div class="action-wrapper">
                                <IconButton type="button" icon="delete" style="color: var(--color-error);" v-tooltip="'Löschen'" @click.stop="openDeletePopup(item)"/>
                                <IconButton is="a" icon="edit" v-tooltip="'Bearbeiten'" :href="route('admin.forms.forms.editor', item.id)" @click.stop/>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <small v-show="items.length <= 0" class="w-100 flex h-center padding-inline-2 padding-block-5">Keine Formulare angelegt</small>

        <div class="flex v-center gap-1 border-top padding-top-1">
            <small><b>{{items.length}}</b> Formulare</small>
        
            <div class="spacer"></div>
        </div>

        <template #fab>
            <button class="fab-button" aria-hidden="true" title="Neues Formular" @click="$refs.newItemPopup.open()">add</button>
        </template>
    </AdminLayout>



    <Popup ref="newItemPopup" title="Neues Formular erstellen">
        <form class="confirm-popup-wrapper" @submit.prevent="storeNewItem">
            <mui-input v-model="newItemForm.name" label="Name" />
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.newItemPopup.close()" />
                <mui-button type="submit" variant="filled" label="Neu Erstellen" />
            </div>
        </form>
    </Popup>

    <Popup ref="deletePopup" title="Elemente löschen?">
        <form class="confirm-popup-wrapper" @submit.prevent="deleteItems">
            <p>Möchten Sie wirklich <b>{{selection.length}} Elemente</b> entgültig löschen?</p>
            <div class="confirm-popup-footer">
                <mui-button type="button" variant="contained" label="Abbrechen" @click="$refs.deletePopup.close()" />
                <mui-button type="submit" variant="filled" color="error" label="Entgültig löschen" />
            </div>
        </form>
    </Popup>
</template>

<script setup>
    import { Head, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { capitalizeWords } from '@/Utils/String'

    import AdminLayout from '@/Layouts/Admin.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Switcher from '@/Components/Form/Switcher.vue'
    import Actions from '@/Components/Form/Actions.vue'
    import Popup from '@/Components/Form/Popup.vue'
    import Tag from '@/Components/Form/Tag.vue'

    const props = defineProps({
        items: Array,
    })



    // START: View Parameters
    const layout = ref('list')
    const isPreview = ref(false)
    // END: View Parameters



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
        selection.value = props.items.map(i => i.id)
    }

    const deselectAll = () => {
        selection.value = []
    }
    // END: Selection



    // START: Editor
    const openItem = (item) => {
        Inertia.visit(route('admin.forms.forms.editor', item.id))
    }
    // END: Editor



    // START: New Item
    const newItemPopup = ref(null)

    const newItemForm = useForm({
        name: '',
    })
    
    const storeNewItem = () => {
        newItemForm.post(route('admin.forms.forms.store'), {
            onSuccess: () => {
                newItemPopup.value.close()
                newItemForm.reset()
            },
        })
    }
    // END: New Item



    // START: Delete
    const deletePopup = ref(null)

    const openDeletePopup = (item = null) => {
        if (item) setSelection(item)
        deletePopup.value.open()
    }
    
    const deleteItems = () => {
        useForm({ids: selection.value}).delete(route('admin.forms.forms.delete'), {
            onSuccess: () => {
                deletePopup.value.close()
                deselectAll()
            },
        })
    }
    // END: Delete



    // START: Duplicate
    const duplicateItem = (item) => {
        // useForm({returnTo: 'current'}).post(route('admin.'+props.app+'.categories.duplicate', item.id), {
        //     onSuccess: () => {
        //         deselectAll()
        //     },
        // })
    }
    // END: Duplicate

    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
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