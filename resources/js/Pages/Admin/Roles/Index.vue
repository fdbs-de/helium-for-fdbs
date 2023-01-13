<template>
    <Head title="Rollen verwalten" />

    <AdminLayout title="Rollen verwalten">
        <div class="layout">
            <div class="sidebar">
                <mui-button class="margin-bottom-1" @click="createItem()" icon-left="add" size="large" variant="contained">Neue Rolle</mui-button>
                <mui-input class="margin-bottom-1" type="search" v-model="search" icon-left="search" placeholder="Rollen suchen" />
                
                <div class="role" v-for="role in items" :key="role.id" :class="{'active': role.id === form.id}">
                    <button type="button" class="name" :loading="createForm.processing" @click="openItem(role)">
                        <span v-tooltip.bottom="role.name">{{ role.name }}</span>
                    </button>
                    <IconButton icon="delete" @click="deleteItem(role)" v-tooltip.right="'Rolle löschen'"/>
                </div>

                <div class="flex v-center h-center padding-1 h-3" v-if="items.length <= 0">
                    <span>
                        Keine Rollen gefunden
                    </span>
                </div>
            </div>

            <form class="content flex vertical gap-1" @submit.prevent="saveItem()" v-if="form.id">
                <div class="flex gap-1 v-center">
                    <mui-input class="flex-1" v-model="form.name" label="Rollen Name" />
                    <mui-button size="large" :loading="form.processing" >Rolle speichern</mui-button>
                </div>
                
                <div class="flex gap-1 vertical">
                    <mui-toggle class="checkbox" v-for="permission in permissions" :key="permission.name" :modelValue="form.permissions.includes(permission.name)" @update:modelValue="togglePermission(permission.name)">
                        <template #label>
                            <div class="w-100 flex v-center">
                                <span class="flex-1">{{ permission.label }}</span>
                                <div class="icon" v-tooltip="permission.description">info</div>
                            </div>
                        </template>
                    </mui-toggle>

                    <fieldset class="flex gap-1 vertical" v-for="(group, key) in groupedPermissions" :key="key">
                        <legend>{{ group.title }}</legend>

                        <div class="flex vertical" v-for="(subgroup, i) in group.permissions" :key="'permission_group_'+group.title+'_'+i">
                            <!-- <mui-toggle class="checkbox" v-for="permission in subgroup" :key="permission.name" :modelValue="form.permissions.includes(permission.name)" @update:modelValue="togglePermission(permission.name)"> -->
                            <mui-toggle class="checkbox" v-for="permission in subgroup" :key="permission.name" :modelValue="form.permissions.includes(permission.name)">
                                <template #label>
                                    <div class="w-100 flex v-center">
                                        <span class="flex-1">{{ permission.label }}</span>
                                        <div class="icon" v-tooltip="permission.description">info</div>
                                    </div>
                                </template>
                            </mui-toggle>
                        </div>
                    </fieldset>
                </div>
            </form>

            <div class="content" v-else>
                <div class="flex v-center h-center padding-1 radius-l background-soft h-20">
                    <span>
                        Wähle eine Rolle aus, um sie zu bearbeiten
                    </span>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import IconButton from '@/Components/Form/IconButton.vue'
    import Popup from '@/Components/Form/Popup.vue'



    const props = defineProps({
        items: Array,
        permissions: Object,
    })

    const search = ref('')

    const items = computed(() => {
        return props.items.filter((item) => item.name.toLowerCase().includes(search.value.toLowerCase()))
    })

    const groupedPermissions = computed(() => {
        return props.permissions
    })

    const permissions = ref([
        {name: 'access admin panel', label: 'Admin-Bereich betreten', description: 'Der Benutzer kann den Admin-Bereich betreten.'},
        {name: 'edit users', label: 'Benutzer verwalten', description: 'Der Benutzer kann Benutzer verwalten.'},
        {name: 'edit posts', label: 'Beiträge verwalten', description: 'Der Benutzer kann Beiträge verwalten.'},
        {name: 'edit docs', label: 'Dokumente verwalten', description: 'Der Benutzer kann Dokumente verwalten.'},
        {name: 'edit specs', label: 'Spezifikationen verwalten', description: 'Der Benutzer kann Spezifikationen verwalten.'},
        {name: 'edit job offers', label: 'Jobangebote verwalten', description: 'Der Benutzer kann Jobangebote verwalten.'},
    ])



    // START: Form
    const form = useForm({
        id: null,
        name: '',
        permissions: [],
    })

    const createForm = useForm({name: 'Neue Rolle'})

    const togglePermission = (permission) => {
        if (form.permissions.includes(permission))
        {
            form.permissions = form.permissions.filter((p) => p !== permission)
        }
        else
        {
            form.permissions.push(permission)
        }
    }
    // END: Form



    // START: Editor
    const openItem = (item = null) => {
        form.id = item?.id ?? null
        form.name = item?.name ?? ''
        form.permissions = item?.permissions?.map(e => e.name) ?? []
    }

    const createItem = () => {
        createForm.post(route('admin.roles.store'))
    }

    const saveItem = () => {
        form.put(route('admin.roles.update', form.id), {
            preserveScroll: true,
        })
    }

    const deleteItem = (item) => {
        if (confirm('Soll die Rolle "'+item.name+'" wirklich gelöscht werden?'))
        {
            useForm().delete(route('admin.roles.delete', item.id))
        }
    }
    // END: Editor



    
</script>

<style lang="sass">
    .checkbox
        .label
            width: 100%
</style>

<style lang="sass" scoped>
    .layout
        display: flex
        flex-direction: row
        height: 100%
        border-radius: var(--radius-m)
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)

        .sidebar
            width: 340px
            display: flex
            flex-direction: column
            gap: 3px
            padding: 1rem
            border-right: 1px solid var(--color-border)

            .role
                height: 3rem
                display: flex
                flex-direction: row
                align-items: center
                justify-content: space-between
                user-select: none
                border-radius: var(--radius-m)

                &:hover
                    background: var(--color-background-soft)
                    color: var(--color-heading)

                &.active
                    background: var(--color-background-soft)
                    color: var(--color-heading)

                .name
                    font-weight: 400
                    font-family: inherit
                    font-size: inherit
                    background: none
                    border: none
                    cursor: pointer
                    color: inherit
                    text-align: left
                    padding: 0 1rem
                    flex: 1
                    height: 100%
                    overflow: hidden
                    text-overflow: ellipsis
                    white-space: nowrap

        .content
            flex: 1
            padding: 1rem

            .checkbox
                --mui-background: var(--color-background)

                .icon
                    font-family: var(--font-icon)
                    font-size: 1.2rem
                    color: var(--color-text)
</style>