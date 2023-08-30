<template>
    <div class="new-tab-layout">
        <div class="new-button-wrapper">
            <div class="limiter">
                <button class="new-button pages" @click="emits('open', {type: 'page'})">
                    <div class="icon">add</div>
                    <span class="text">Neue Seite</span>
                    <span class="subtext">Inhaltsseiten</span>
                </button>
                <button class="new-button forms" @click="emits('open', {type: 'form'})">
                    <div class="icon">add</div>
                    <span class="text">Neues Formular</span>
                    <span class="subtext">Formular oder Funnel</span>
                </button>
            </div>
        </div>
        <div class="pages-wrapper">
            <div class="limiter text-limiter">
            </div>
        </div>
    </div>
</template>

<script setup>
    const emits = defineEmits([
        'open',
    ])

    const props = defineProps({
        tab: {
            type: Object,
            required: true,
        },
    })
</script>

<style lang="sass" scoped>
    .new-tab-layout
        flex: 1
        background: var(--color-background-dark-soft)
        display: flex
        flex-direction: column

        .new-button-wrapper
            width: 100%
            padding-block: 6rem 4rem
            background: var(--color-background-dark)
            user-select: none

            .limiter
                display: flex
                gap: 2rem
                justify-content: center

            .new-button
                height: 12rem
                aspect-ratio: 16/9
                border-radius: var(--radius-l)
                display: flex
                flex-direction: column
                align-items: center
                justify-content: center
                color: var(--color-background)
                gap: .25rem
                margin: 0
                padding: 0
                border: none
                cursor: pointer
                transition: all 80ms ease-in-out

                &:hover
                    box-shadow: var(--shadow-elevation-high)

                &.pages
                    background: var(--color-app-pages-on-light)

                &.forms
                    background: var(--color-app-forms-on-light)

                .icon
                    font-family: var(--font-icon)
                    font-size: 2.5rem
                    opacity: .7
                    line-height: 1
                    margin-bottom: 1rem

                .text
                    font-size: 1.1rem
                    font-weight: 600
                    font-family: var(--font-heading)

                .subtext
                    font-weight: 400
                    font-family: var(--font-text)
                    opacity: .8
</style>