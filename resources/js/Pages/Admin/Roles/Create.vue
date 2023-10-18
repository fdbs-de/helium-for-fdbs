<template>
    <AdminLayout :title="form.id ? 'Rolle bearbeiten' : 'Rolle erstellen'" sticky>
        <template #header-left>
            <IodButton label="Zurück" variant="contained" size="small" :loading="form.processing" is="a" :href="route('admin.roles')" v-tooltip="'Zurück zur Übersicht'"/>
        </template>

        <template #header-right>
            <div class="flex gap-1 v-center">
                <IodButton :label="form.id ? 'Speichern' : 'Erstellen'" variant="filled" size="small" :loading="form.processing" @click="saveItem()" v-tooltip.bottom="'(STRG+S zum Speichern)'"/>
            </div>
        </template>


        
        <form class="card flex vertical gap-1 padding-1" @submit.prevent="saveItem()">
            <div class="limiter text-limiter">
                <div class="flex vertical gap-1">
                    <ValidationErrors />

                    <IodInput label="Name" v-model="form.name"/>

                    <div class="flex gap-1 v-center wrap">
                        <IodInput class="flex-1" label="Farbe" v-model="form.color"/>
                        <IodInput class="flex-1" label="Icon" v-model="form.icon"/>
                    </div>

                    <div class="flex gap-3 vertical">
                        <fieldset class="flex gap-2 vertical" v-for="(group, key) in permissions" :key="key">
                            <legend class="font-heading">{{ group.title }}</legend>

                            <div class="flex vertical" v-for="(subgroup, i) in group.permissions" :key="'permission_group_' + group.title + '_' + i">
                                <IodToggle v-for="permission in subgroup" :key="permission.name" :modelValue="form.permissions.includes(permission.name)" @update:modelValue="togglePermission(permission.name)">
                                    <template #label>
                                        <div class="flex vertical">
                                            <b>{{ permission.label }}</b>
                                            <small>{{ permission.description }}</small>
                                        </div>
                                    </template>
                                </IodToggle>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/inertia-vue3'
    import { computed } from 'vue'
    import hotkeys from 'hotkeys-js'

    import AdminLayout from '@/Layouts/Admin.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'



    hotkeys('ctrl+s', (event, handler) => { event.preventDefault(); saveItem() })



    const props = defineProps({
        item: Object,
        permissions: Object,
    })
    
    
    
    // START: Form
    const form = useForm({
        id: null,
        name: '',
        color: '',
        icon: '',
        permissions: [],
    })

    const submitRoute = computed(() => form.id ? route(`admin.roles.update`, form.id) : route(`admin.roles.store`))
    const submitMethod = computed(() => form.id ? 'put' : 'post')

    const open = (item = null) => {
        form.id = item?.id ?? null
        form.name = item?.name ?? ''
        form.color = item?.color ?? ''
        form.icon = item?.icon ?? ''
        form.permissions = item?.permissions?.map(e => e.name) ?? []
    }

    const saveItem = () => {
        if (form.processing) return

        form.submit(submitMethod.value, submitRoute.value, {
            preserveScroll: true,
            onSuccess: (data) => {
                open(data?.props?.item)
            },
        })
    }

    open(props?.item)
    // END: Form



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
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)
</style>