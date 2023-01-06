<template>
    <Head>
        <title>Kontakt & Ansprechpartner</title>
    </Head>

    <TextSubLayout title="Kontakt & Ansprechpartner" image="/images/content/banner/kontakt_360006987.webp">
        <section id="form-section">
            <div class="card">
                <h2>Anfahrt</h2>

                <span>
                    Christian-Pommer-Straße 31/33<br>
                    38112 Braunschweig<br>
                </span>
                <span>
                    Email: <a href="mailto:info@fdbs.de">info@fdbs.de</a><br>
                    Tel.: <a href="tel:0531210550">0531 210 55 0</a><br>
                    Fax: 0531 210 55 39<br>
                </span>
            </div>

            <form class="card" @submit.prevent="submit">
                <Alert type="info" title="Vielen Dank für Ihre Anfrage!" v-if="$page.props.flash.success">
                    Wir haben Ihre Kontaktanfrage erhalten und werden Ihnen schnellsmöglich antworten.
                </Alert>

                <h2>Kontaktformular</h2>

                <ValidationErrors />

                <mui-input type="text" label="Ihr Name *" required autocomplete="name" v-model="form.name"/>
                <mui-input type="email" label="Ihre Email *" required autocomplete="email" v-model="form.email"/>
                <mui-input type="textarea" class="textarea" label="Nachricht *" max="2000" required autocomplete="message" v-model="form.message"/>

                <mui-toggle type="checkbox" class="checkbox" v-model="form.terms">
                    <template #label>
                        <span>
                            Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> gelesen und akzeptiere diese.
                        </span>
                    </template>
                </mui-toggle>

                <div class="flex center">
                    <mui-button type="submit" label="Absenden" :loading="form.processing"/>
                    <div class="spacer"></div>
                </div>
            </form>
        </section>

        <h2 class="text-align-center">Der Vorstand</h2>
        <div class="staff-card-container">
            <div></div>
            <StaffCard name="Sebastian Gerlach" job="Vorstand" leader label="(geschäftsführend)" image="/images/content/mitarbeiter/sebastian_gerlach.png" overlay="/images/content/mitarbeiter/sebastian_gerlach_zeichnung.png"/>
            <StaffCard name="Jens Löser" job="Vorstand" leader label="(geschäftsführend)" image="/images/content/mitarbeiter/jens_loeser.png" overlay="/images/content/mitarbeiter/jens_loeser_zeichnung.png"/>
            <div></div>
        </div>

        <h2 class="text-align-center">Ansprechpartner</h2>
        <div class="staff-card-container">
            <template v-for="department in departments" :key="department.id">
                <StaffCard
                    v-for="employee in department.employees"
                    :key="employee.name"
                    :name="employee.name"
                    :job="employee.job"
                    :leader="employee.leader"
                    :tel="employee.tel"
                    :image="employee.image || '/images/content/mitarbeiter/missing.png'"
                    :overlay="employee.overlay"/>
            </template>
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { ref } from 'vue'
    import { Head, useForm } from '@inertiajs/inertia-vue3'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import ValidationErrors from '@/Components/ValidationErrors.vue'
    import StaffCard from '@/Components/Page/StaffCard.vue'
    import Alert from '@/Components/Alert.vue'
    import departments from '@/Pages/Kontakt.json'

    const form = useForm({
        email: '',
        name: '',
        message: '',
        terms: false
    })

    const isSent = ref(false)

    const submit = () => {
        form.post(route('kontakt.send'), {
            onSuccess: () => {
                isSent.value = true
                form.reset()
            },
        })
    }
</script>

<style lang="sass" scoped>
    #form-section
        display: flex
        gap: 4rem
        margin-bottom: 6rem

        .card
            flex: 1
            display: flex
            flex-direction: column
            padding: 2rem
            gap: 2rem
            background: var(--color-background-soft)
            border-radius: var(--radius-xl)

            h2
                color: var(--color-heading)
                text-align: left
                margin: 0


        form
            --mui-background: var(--color-background)

            .checkbox
                --mui-background: var(--color-background-soft)

            .textarea
                --base-height: 10rem

    .staff-card-container
        display: grid !important
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr))
        gap: 3rem
        margin-bottom: 4rem
        justify-content: center



    @media only screen and (max-width: 500px)
        #form-section
            flex-direction: column
            gap: 1rem

            .card
                padding: 1rem
</style>