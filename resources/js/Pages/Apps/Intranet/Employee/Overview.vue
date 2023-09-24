<template>
    <DashboardSubLayout title="News und Termine">
        <div class="flex vertical gap-2">
            <StatefulAccordion title="Termine" scope="auth.employee.news.appointments">
                <Calendar class="margin-bottom-4" :entries="appointments" :groups="['Allgemein', 'Audits', 'Vertrieb', 'Messen']"/>
            </StatefulAccordion>
            
            <StatefulAccordion title="News" scope="auth.employee.news.news">
                <div class="flex vertical gap-2">
                    <article class="post-wrapper" v-for="post in posts" :key="post.id">
                        <Tag v-if="post.pinned" class="pinned" icon="push_pin" color="green" label="Angepinnt"/>
                        <div class="info-group">
                            <h3 class="title">{{post.title}}</h3>
                            <time class="date" :datetime="post.created_at">{{$dayjs(post.created_at).format('DD. MMM YYYY')}}</time>
                        </div>
                        <div class="formatted-content" v-html="post.content"></div>
                    </article>
                </div>
            </StatefulAccordion>
        </div>
    </DashboardSubLayout>
</template>

<script setup>
    import DashboardSubLayout from '@/Layouts/SubLayouts/Dashboard.vue'
    import Calendar from '@/Components/Form/Calendar.vue'
    import Tag from '@/Components/Form/Tag.vue'
    import appointments from '@/Pages/Apps/Intranet/Employee/appointments.json'
    import StatefulAccordion from '@/Components/Form/StatefulAccordion.vue'



    defineProps({
        posts: Array,
    })
</script>

<style lang="sass" scoped>
    .post-wrapper
        display: flex
        align-items: flex-start
        flex-direction: column
        border-radius: var(--radius-m)
        gap: 1rem
        padding: 1rem
        background: var(--color-background)
        border: 1px solid var(--color-border)

        .pinned
            display: inline-flex

        .title
            margin: 0

        .date
            margin: 0
            font-size: .9rem

        .formatted-content
            margin: 0
            width: 100%
            max-width: 800px
</style>                    