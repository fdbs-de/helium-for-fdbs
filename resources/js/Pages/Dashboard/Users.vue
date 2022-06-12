<template>
    <Head title="Dashboard: Nutzerverwaltung" />

    <DashboardSubLayout title="Nutzerverwaltung">
        <div class="grid">
            <div class="row">
                <b>Name</b>
                <b>Email</b>
                <b>Rollen</b>
                <b>Eigenschaften</b>
                <b>&nbsp;</b>
            </div>
            <div class="row" v-for="user in users" :key="user.id">
                <span v-if="user.name">{{user.name}}</span>
                <i v-else>Kein Name angegeben</i>
                <span>{{user.email}}</span>
                <span class="flex center gap">
                    <div class="tag" v-for="role in user.roles" :key="role.id">{{role.name}}</div>
                </span>
                <span class="flex center gap">
                    <div class="icon" :class="{'active': user.email_verified_at}">mail</div>
                    <div class="icon" :class="{'active': user.enabled_at}">check_circle</div>
                    <div class="icon" :class="{'active': user.customer_profile}">shopping_cart</div>
                    <div class="icon" :class="{'active': user.employee_profile}">work</div>
                </span>
                <span class="flex h-end">
                    <mui-button size="small" label="Verwalten" @click="enableUser(user)"/>
                </span>
            </div>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'

defineProps({
    users: Array,
})

const enableUser = (user) => {
    if (user.enabled_at) return

    useForm().put(route('dashboard.admin.users.enable', { user: user.id }), {
        onFinish() {
        },
    })
}
</script>

<style lang="sass" scoped>
    .grid
        display: flex
        flex-direction: column
        width: 100%
        padding-block: 1rem

        .row
            display: grid
            align-items: center
            grid-template-columns: 2fr 3fr 3fr 150px 150px
            gap: var(--su)
            padding: .5rem 1rem

            .tag
                display: flex
                align-items: center
                padding-inline: .5rem
                border: 1px solid var(--color-primary)
                border-radius: 2rem
                height: 1.5rem
                font-size: .8rem
                color: var(--color-primary)

            .icon
                font-family: var(--font-icon)
                font-size: 1.5rem
                line-height: 1
                color: var(--color-text)
                user-select: none

                &.active
                    color: var(--color-primary)

            &:hover
                background: var(--color-background-soft)
</style>