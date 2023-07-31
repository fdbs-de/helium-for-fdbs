<template>
    <TextSubLayout title="MKBS Kundenzufriedenheit" has-small-limiter>
        <Head>
            <title>MKBS Kundenzufriedenheit – FDBS Umfragen</title>
        </Head>

        <p v-if="!submitted && step === 0">
            Wie zufrieden sind Sie mit unserer Marketing-Abteilung? Bitte nehmen Sie sich ein paar
            Minuten Zeit um die nachfolgenden Fragen zu beantworten. Ihr Feedback gibt uns die
            Möglichkeit unsere Produkte und Dienstleistungen zu verbessern und mehr auf Ihre
            Bedürfnisse anzupassen. Es ist uns wichtig, dass Sie als Kunde mit unseren Leistungen
            und der Qualität zufrieden sind.<br><br><br>
        </p>

        <form class="pages-wrapper" @submit.prevent="submit()" v-if="!submitted">
            <div class="progress">
                <div class="text">{{step}} / 11</div>
                <div class="progress-bar" :style="`width: ${step / 11 * 100}%`"></div>
            </div>

            <transition-group :name="`slide-${stepDirection}`" tag="div" class="animation-wrapper" :class="`slide-${stepDirection}`">
                <div class="page" key="0" v-show="step === 0">
                    <div class="inner-page">
                        <h4>Wie zufrieden sind Sie insgesamt mit uns als Marketing-Abteilung?</h4>
                        <ScaleInput name="s1" :options="sentimentOptions" required v-model="form.generalSentiment"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" disabled/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[0]" @click="step = 1"/>
                    </div>
                </div>
        
                <div class="page" key="1" v-show="step === 1">
                    <div class="inner-page">
                        <h4>Wie zufrieden sind Sie im Allgemeinen mit folgenden Leistungsmerkmalen?</h4>
                        <h5>Angebot</h5>
                        <ScaleInput name="s2" :options="sentimentOptions" required v-model="form.metricPortfolioSentiment"/>
                        <h5>Qualität</h5>
                        <ScaleInput name="s3" :options="sentimentOptions" required v-model="form.metricQualitySentiment"/>
                        <h5>Preis-Leistung</h5>
                        <ScaleInput name="s4" :options="sentimentOptions" required v-model="form.metricPriceSentiment"/>
                        <h5>Design</h5>
                        <ScaleInput name="s5" :options="sentimentOptions" required v-model="form.metricDesignSentiment"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 0"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[1]" @click="step = 2"/>
                    </div>
                </div>
        
                <div class="page" key="2" v-show="step === 2">
                    <div class="inner-page">
                        <h4>Wie zufrieden sind Sie im Allgemeinen mit den folgenden Bereichen?</h4>
                        <h5>Print</h5>
                        <ScaleInput name="s6" :options="sentimentOptions" required v-model="form.departmentPrintSentiment"/>
                        <h5>Website/Shop</h5>
                        <ScaleInput name="s7" :options="sentimentOptions" required v-model="form.departmentWebsiteSentiment"/>
                        <h5>Social Media</h5>
                        <ScaleInput name="s8" :options="sentimentOptions" required v-model="form.departmentSocialMediaSentiment"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 1"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[2]" @click="step = 3"/>
                    </div>
                </div>
        
                <div class="page" key="3" v-show="step === 3">
                    <div class="inner-page">
                        <h4>Wie beurteilen Sie das Leistungsniveau des Marketing-Teams in den folgenden Bereichen?</h4>
                        <h5>Freundlichkeit</h5>
                        <ScaleInput name="s9" :options="sentimentOptions" required v-model="form.softskillsPolitenessSentiment"/>
                        <h5>Beratung</h5>
                        <ScaleInput name="s10" :options="sentimentOptions" required v-model="form.softskillsConsultationSentiment"/>
                        <h5>Professionalität</h5>
                        <ScaleInput name="s11" :options="sentimentOptions" required v-model="form.softskillsProfessionalismSentiment"/>
                        <h5>Problemlösung</h5>
                        <ScaleInput name="s12" :options="sentimentOptions" required v-model="form.softskillsProblemSolvingSentiment"/>
                        <h5>Gesamteindruck</h5>
                        <ScaleInput name="s13" :options="sentimentOptions" required v-model="form.softskillsOverallSentiment"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 2"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[3]" @click="step = 4"/>
                    </div>
                </div>
        
                <div class="page" key="4" v-show="step === 4">
                    <div class="inner-page">
                        <h4>Was können wir tun, um Ihre Zufriedenheit zu erhöhen?</h4>
                        <mui-input type="textarea" class="input" v-model="form.increaseHappiness" placeholder="Ihre Antwort..."/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 3"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[4]" @click="step = 5"/>
                    </div>
                </div>
        
                <div class="page" key="5" v-show="step === 5">
                    <div class="inner-page">
                        <h4>Wünschen Sie sich Schulungen/Beratung?</h4>
                        <ScaleInput name="s14" show-label :options="booleanOptions" required v-model="form.wantsWorkshops"/>
                        <mui-input type="textarea" class="input" v-if="form.wantsWorkshops == 'ja'" v-model="form.workshops" placeholder="In welcher Form?"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 4"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[5]" @click="step = 6"/>
                    </div>
                </div>
        
                <div class="page" key="6" v-show="step === 6">
                    <div class="inner-page">
                        <h4>Würden Sie sich von uns öfter Angebote/Aktionen wünschen?</h4>
                        <ScaleInput name="s15" show-label :options="booleanOptions" required v-model="form.wantsNewsletter"/>
                        <mui-input type="textarea" class="input" v-if="form.wantsNewsletter == 'ja'" v-model="form.newsletter" placeholder="In welcher Form? (z. B. Rabatte, Angebotspakete, Gewinnspiele, ...)"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 5"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[6]" @click="step = 7"/>
                    </div>
                </div>
        
                <div class="page" key="7" v-show="step === 7">
                    <div class="inner-page">
                        <h4>Wussten Sie, dass wir auch folgende Produkte/Leistungen anbieten?</h4>
                        <div class="flex gap-1 v-center">
                            <b class="flex-1">Social Media Betreuung</b>
                            <ScaleInput name="s16" show-label :options="booleanOptions" required v-model="form.serviceSocialMediaAcknowledgement"/>
                        </div>
                        <div class="flex gap-1 v-center">
                            <b class="flex-1">Erstellung von Webseiten / Onlineshops</b>
                            <ScaleInput name="s17" show-label :options="booleanOptions" required v-model="form.serviceWebsiteAcknowledgement"/>
                        </div>
                        <div class="flex gap-1 v-center">
                            <b class="flex-1">Recruiting (Kampagnen zur Mitarbeitergewinnung)</b>
                            <ScaleInput name="s18" show-label :options="booleanOptions" required v-model="form.serviceRecruitingAcknowledgement"/>
                        </div>
                        <div class="flex gap-1 v-center">
                            <b class="flex-1">Digital Signage (personalisierte Monitorwerbung in Ihrem Laden)</b>
                            <ScaleInput name="s19" show-label :options="booleanOptions" required v-model="form.serviceDigitalSignageAcknowledgement"/>
                        </div>
                        <div class="flex gap-1 v-center">
                            <b class="flex-1">Produktfotografie</b>
                            <ScaleInput name="s20" show-label :options="booleanOptions" required v-model="form.servicePhotographyAcknowledgement"/>
                        </div>
                        <div class="flex gap-1 v-center">
                            <b class="flex-1">Geschäftsausstattung (Visitenkarte, Briefpapier, Blöcke, Kugelschreiber...)</b>
                            <ScaleInput name="s21" show-label :options="booleanOptions" required v-model="form.serviceStationariesAcknowledgement"/>
                        </div>
                        <div class="flex gap-1 v-center">
                            <b class="flex-1">Werbetechnik (Beschilderung, Beklebung von Fahrzeugen und Schaufenstern...)</b>
                            <ScaleInput name="s22" show-label :options="booleanOptions" required v-model="form.serviceAdtechAcknowledgement"/>
                        </div>
                        
                        <mui-input type="textarea" class="input" v-model="form.productSuggestions" label="Gibt es Produkte, die Sie bei uns vermissen?"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 6"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[7]" @click="step = 8"/>
                    </div>
                </div>
                
                <div class="page" key="8" v-show="step === 8">
                    <div class="inner-page">
                        <h4>Wie bewerten Sie uns in folgenden Bereichen gegenüber Mitbewerbern?</h4>
                        <h5>Qualität</h5>
                        <ScaleInput name="s23" :options="comparisonOptions" required v-model="form.competitorQualitySentiment"/>
                        <h5>Preis-Leistung</h5>
                        <ScaleInput name="s24" :options="comparisonOptions" required v-model="form.competitorPriceSentiment"/>
                        <h5>Problemlösung</h5>
                        <ScaleInput name="s25" :options="comparisonOptions" required v-model="form.competitorProblemSolvingSentiment"/>
                        <h5>Gesamteindruck</h5>
                        <ScaleInput name="s26" :options="comparisonOptions" required v-model="form.competitorOverallSentiment"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 7"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[8]" @click="step = 9"/>
                    </div>
                </div>
        
                <div class="page" key="9" v-show="step === 9">
                    <div class="inner-page">
                        <h4>Wie wahrscheinlich ist es, dass Sie uns als Werbepartner weiterempfehlen?</h4>
                        <ScaleInput name="s27" :show-label="false" :options="recommendOptions" required v-model="form.wouldRecommend"/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 8"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[9]" @click="step = 10"/>
                    </div>
                </div>
        
                <div class="page" key="10" v-show="step === 10">
                    <div class="inner-page">
                        <h4>Haben Sie noch weitere Anregungen/Wünsche für die zukünftige Zusammenarbeit?</h4>
                        <mui-input type="textarea" class="input" v-model="form.note" placeholder="Ihre Antwort..."/>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 9"/>
                        <mui-button type="button" label="Weiter" size="large" :disabled="!validSteps[10]" @click="step = 11"/>
                    </div>
                </div>
        
                <div class="page" key="11" v-show="step === 11">
                    <div class="inner-page">
                        <mui-toggle type="checkbox" class="checkbox" label="Anonym versenden" v-model="form.sendAnonymously"/>
        
                        <template v-if="!form.sendAnonymously">
                            <mui-input type="text" class="input" v-model="form.name" required label="Name"/>
                            <mui-input type="email" class="input" v-model="form.email" required label="Email"/>
                        </template>
        
                        <mui-toggle type="checkbox" class="checkbox" v-model="form.gdpr" required>
                            <template #label>
                                Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> gelesen und akzeptiere diese.
                            </template>
                        </mui-toggle>
                    </div>
    
                    <div class="controls">
                        <mui-button type="button" label="Zurück" size="large" variant="contained" @click="step = 10"/>
                        <mui-button type="submit" label="Absenden" size="large" :disabled="!valid"/>
                    </div>
                </div>
            </transition-group>
        </form>

        <Alert title="Vielen Dank für Ihr Feedback!" type="success" v-if="submitted">
            <p>
                Vielen Dank für Ihre Teilnahme an unserer Kundenzufriedenheitsumfrage.
                Wir freuen uns über Ihr Feedback und werden uns bemühen,
                Ihre Anregungen und Wünsche in unsere zukünftige Zusammenarbeit mit einzubeziehen.
            </p>
        </Alert>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'

    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import ScaleInput from '@/Components/Form/Survey/ScaleInput.vue'
    import Alert from '@/Components/Alert.vue'



    const sentimentOptions = [
        { color: '#249b5c', icon: 'sentiment_very_satisfied', label: 'sehr zufrieden', value: 2 },
        { color: '#3abe78', icon: 'sentiment_satisfied', label: 'zufrieden', value: 1 },
        { color: '#53585c', icon: 'sentiment_neutral', label: 'neutral', value: 0 },
        { color: '#EF434D', icon: 'sentiment_dissatisfied', label: 'unzufrieden', value: -1 },
        { color: '#BE1846', icon: 'sentiment_very_dissatisfied', label: 'sehr unzufrieden', value: -2 },
    ]

    const comparisonOptions = [
        { color: '#249b5c', icon: 'sentiment_very_satisfied', label: 'viel besser', value: 2 },
        { color: '#3abe78', icon: 'sentiment_satisfied', label: 'besser', value: 1 },
        { color: '#53585c', icon: 'sentiment_neutral', label: 'identisch', value: 0 },
        { color: '#EF434D', icon: 'sentiment_dissatisfied', label: 'schlechter', value: -1 },
        { color: '#BE1846', icon: 'sentiment_very_dissatisfied', label: 'viel schlechter', value: -2 },
    ]

    const recommendOptions = [
        { color: '#249b5c', icon: 'sentiment_very_satisfied', label: 'sehr wahrscheinlich', value: 2 },
        { color: '#3abe78', icon: 'sentiment_satisfied', label: 'wahrscheinlich', value: 1 },
        { color: '#53585c', icon: 'sentiment_neutral', label: 'neutral', value: 0 },
        { color: '#EF434D', icon: 'sentiment_dissatisfied', label: 'unwahrscheinlich', value: -1 },
        { color: '#BE1846', icon: 'sentiment_very_dissatisfied', label: 'sehr unwahrscheinlich', value: -2 },
    ]

    const booleanOptions = [
        { color: '#249b5c', label: 'Ja', value: 'ja' },
        { color: '#EF434D', label: 'Nein', value: 'nein' },
    ]



    const form = useForm({
        generalSentiment: null,
        metricPortfolioSentiment: null,
        metricQualitySentiment: null,
        metricPriceSentiment: null,
        metricDesignSentiment: null,
        departmentPrintSentiment: null,
        departmentWebsiteSentiment: null,
        departmentSocialMediaSentiment: null,
        softskillsPolitenessSentiment: null,
        softskillsConsultationSentiment: null,
        softskillsProfessionalismSentiment: null,
        softskillsProblemSolvingSentiment: null,
        softskillsOverallSentiment: null,
        increaseHappiness: '',
        wantsWorkshops: null,
        workshops: '',
        wantsNewsletter: null,
        newsletter: '',
        serviceSocialMediaAcknowledgement: null,
        serviceWebsiteAcknowledgement: null,
        serviceRecruitingAcknowledgement: null,
        serviceDigitalSignageAcknowledgement: null,
        servicePhotographyAcknowledgement: null,
        serviceStationariesAcknowledgement: null,
        serviceAdtechAcknowledgement: null,
        productSuggestions: '',
        competitorQualitySentiment: null,
        competitorPriceSentiment: null,
        competitorProblemSolvingSentiment: null,
        competitorOverallSentiment: null,
        wouldRecommend: null,
        note: '',
        sendAnonymously: false,
        name: '',
        email: '',
        gdpr: false,
    })

    const step = ref(0)
    const submitted = ref(false)

    const stepDirection = ref('right')
    
    watch(step, (newStep, oldStep) => {
        stepDirection.value = (newStep > oldStep) ? 'left' : 'right'
    })



    const isFilled = (values) => {
        if (!Array.isArray(values)) values = [values]

        return values.every(value => value !== null && value !== '')
    }

    const validSteps = computed(() => {
        return {
            0: isFilled(form.generalSentiment),
            1: isFilled([
                form.metricPortfolioSentiment,
                form.metricQualitySentiment,
                form.metricPriceSentiment,
                form.metricDesignSentiment,
            ]),
            2: isFilled([
                form.departmentPrintSentiment,
                form.departmentWebsiteSentiment,
                form.departmentSocialMediaSentiment,
            ]),
            3: isFilled([
                form.softskillsPolitenessSentiment,
                form.softskillsConsultationSentiment,
                form.softskillsProfessionalismSentiment,
                form.softskillsProblemSolvingSentiment,
                form.softskillsOverallSentiment,
            ]),
            4: true,
            5: isFilled([
                form.wantsWorkshops,
            ]),
            6: isFilled([
                form.wantsNewsletter,
            ]),
            7: isFilled([
                form.serviceSocialMediaAcknowledgement,
                form.serviceWebsiteAcknowledgement,
                form.serviceRecruitingAcknowledgement,
                form.serviceDigitalSignageAcknowledgement,
                form.servicePhotographyAcknowledgement,
                form.serviceStationariesAcknowledgement,
                form.serviceAdtechAcknowledgement,
            ]),
            8: isFilled([
                form.competitorQualitySentiment,
                form.competitorPriceSentiment,
                form.competitorProblemSolvingSentiment,
                form.competitorOverallSentiment,
            ]),
            9: isFilled([
                form.wouldRecommend,
            ]),
            10: true,
            11: form.gdpr,
        }
    })

    const valid = computed(() => {
        return Object.values(validSteps.value).every(value => value)
    })



    const submit = () => {
        if (!valid.value) return

        form.post(route('survey.mkbs.store'), {
            onSuccess: () => submitted.value = true,
        })
    }
</script>

<style lang="sass" scoped>
    .progress
        height: 4px
        width: 150px
        background: var(--color-background-soft)
        border-radius: 2px
        display: flex
        align-items: center
        justify-content: flex-start
        margin: 1rem auto 0
        position: relative

        .text
            position: absolute
            left: 50%
            transform: translateX(-50%)
            bottom: 100%
            font-size: 14px
            color: var(--color-text)
            font-family: monospace

        .progress-bar
            border-radius: 2px
            height: 100%
            background: var(--color-primary)
            transition: width 100ms

    .slide-left-move,
    .slide-right-move,
    .slide-left-enter-active,
    .slide-right-enter-active,
    .slide-left-leave-active,
    .slide-right-leave-active
        transition: all 0.5s ease

    .slide-left-enter-from,
    .slide-right-leave-to
        transform: translate(100px, 0) !important
        opacity: 0

    .slide-right-enter-from,
    .slide-left-leave-to
        transform: translate(-100px, 0) !important
        opacity: 0

    .slide-left-leave-active,
    .slide-right-leave-active
        top: 0
        position: absolute

    .pages-wrapper
        position: relative

    .page
        width: 100%
        display: flex
        flex-direction: column

        .inner-page
            display: flex
            flex-direction: column
            gap: 1rem
            border-radius: var(--radius-l)
            margin: 3rem 0
            padding: 1.5rem
            background: var(--color-background)
            box-shadow: var(--shadow-elevation-low)
            border: 1px solid var(--color-background-soft)

        h4
            font-weight: 600
            margin-inline: auto
            margin-block: 0 1rem
            max-width: 500px
            text-align: center

        h5
            margin-bottom: 0
            color: var(--color-text)

        .controls
            display: flex
            align-items: center
            justify-content: space-between

        .input
            width: 100%
            --base-height: 10rem !important

        .checkbox
            --mui-background: var(--color-background)
</style>