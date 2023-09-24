<template>
    <div class="container">
        <div class="header">
            <select class="filter" v-model="group">
                <option :value="null">Alle</option>
                <option v-for="g in groups" :key="g" :value="g">{{g}}</option>
            </select>
            <div class="spacer"></div>
            <b class="text-heading color-heading">{{$dayjs(date).format('MMMM YYYY')}}</b>
            <div class="spacer"></div>
            <div class="flex gap-0-5">
                <IodIconButton type="button" icon="arrow_back" variant="contained" shape="pill" @click="prevMonth()"/>
                <IodIconButton type="button" icon="arrow_forward" variant="contained" shape="pill" @click="nextMonth()"/>
            </div>
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
        border: 1px solid var(--color-border)
        border-radius: var(--radius-m)
        overflow: hidden

        .header
            display: flex
            align-items: center
            flex-wrap: wrap
            padding: 1rem
            gap: 1rem
            border-bottom: 1px solid var(--color-border)
            border-top-left-radius: inherit
            border-top-right-radius: inherit

            .filter
                height: 2.5rem

        .content
            display: flex
            border-bottom-left-radius: inherit
            border-bottom-right-radius: inherit

            .placeholder
                display: flex
                align-items: center
                justify-content: center
                flex: 1
                padding: 1rem

            .grid
                width: 100%
                display: flex
                flex-direction: column

                .entry
                    display: flex
                    align-items: center
                    flex-wrap: wrap
                    padding: 1rem
                    gap: 1rem
                    border-bottom: 1px solid var(--color-border)

                    &:last-child
                        border-bottom: none

                    &.important
                        background: var(--color-background-soft)

                        h3
                            color: var(--color-red)

                    span
                        flex: none
                        width: 12rem

                    h3
                        flex: 1
                        font-size: 1rem
                        font-weight: 600
                        margin: 0
                        color: var(--color-text)
                        font-family: var(--font-text)



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