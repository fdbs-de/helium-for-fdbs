<template>
    <div class="container">
        <div class="header">
            <div class="filter">
                <button @click="group = null" :class="{'active': group === null}">Alle</button>
                <button v-for="g in groups" :key="g" @click="group = g" :class="{'active': group === g}">{{g}}</button>
            </div>
            <div class="spacer"></div>
            <b>{{$dayjs(date).format('MMMM YYYY')}}</b>
            <button @click="prevMonth()">chevron_left</button>
            <button @click="nextMonth()">chevron_right</button>
        </div>
        <div class="content">
            <div class="grid" v-if="filteredEntries.length">
                <div class="entry" v-for="entry in filteredEntries" :key="entry.id" :class="{'important': entry.important}">
                    <span v-html="dateFormat(entry)"></span>
                    <h3>{{entry.title}}</h3>
                </div>
            </div>
            <div class="placeholder" v-else>
                <span>Für den <b>{{$dayjs(date).format('MMMM YYYY')}}</b> sind keine Termine geplant</span>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue'
    import dayjs from 'dayjs'

    const props = defineProps({
        entries: Array,
        groups: Array,
    })



    const date = ref(new Date())

    const nextMonth = () => {
        date.value = dayjs(date.value).add(1, 'month').toDate()
    }

    const prevMonth = () => {
        date.value = dayjs(date.value).subtract(1, 'month').toDate()
    }



    const group = ref(null)

    const filteredEntries = computed(() => {
        return props.entries.filter(entry => {
            return dayjs(entry.start).isSame(date.value, 'month') && (group.value === null || entry.group === group.value)
        })
    })



    const dateFormat = (entry) => {
        let start = dayjs(entry.start).format('DD.MM.YYYY')
        let end = dayjs(entry.end).format('DD.MM.YYYY')

        return (start === end) ? `${start}` : `${start} bis ${end}`
    }
</script>

<style lang="sass" scoped>
    .container
        display: flex
        flex-direction: column
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-l)

        .header
            display: flex
            align-items: center
            flex-wrap: wrap
            padding: 1rem
            gap: 1rem
            border-bottom: 1px solid var(--color-border)
            border-top-left-radius: inherit
            border-top-right-radius: inherit

            > button
                flex: none
                height: 2.5rem
                width: 2.5rem
                padding: 0
                border-radius: 50%
                border: none
                font-family: var(--font-icon)
                user-select: none
                cursor: pointer
                background: var(--color-background)
                box-shadow: var(--shadow-elevation-low)
                font-size: 1.5rem 
                color: var(--color-heading)

                &:hover,
                &:focus
                    color: var(--color-primary)

            .filter
                display: flex
                height: 1.75rem
                border-radius: var(--radius-s)
                background: var(--color-background-soft)
                align-items: stretch

                > button
                    padding: 0 1rem
                    border: none
                    background: var(--color-background-soft)
                    color: var(--color-text)
                    font-family: var(--font-heading)
                    font-size: 0.9rem
                    font-weight: 500
                    cursor: pointer
                    transition: background 0.2s ease
                    border-radius: inherit

                    &:hover,
                    &:focus
                        color: var(--color-heading)

                    &.active
                        background: var(--color-primary)
                        color: var(--color-background)

        .content
            display: flex
            border-bottom-left-radius: inherit
            border-bottom-right-radius: inherit
            border: 1px solid var(--color-background-soft)
            border-top: none
            min-height: 10rem

            .placeholder
                display: flex
                align-items: center
                justify-content: center
                flex: 1
                padding: 1rem

            .grid
                width: 100%
                display: grid
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))
                gap: 1rem
                padding: 1rem

                .entry
                    display: flex
                    flex-direction: column
                    padding: 1rem
                    background: var(--color-background)
                    border-radius: var(--radius-s)
                    box-shadow: var(--shadow-elevation-low)
                    gap: .5rem
                    border-left: 5px solid var(--color-info)

                    &.important
                        border-color: var(--color-primary)

                    span
                        font-size: 0.9rem

                    h3
                        font-size: 1.1rem
                        font-weight: 600
                        margin: 0
                        color: var(--color-heading)
                        font-family: var(--font-heading)



    @media screen and (max-width: 500px)
        .container
            .header
                .filter
                    flex-direction: column
                    height: auto
                    width: 100%

                    > button
                        width: 100%
                        height: 1.75rem
</style>