<template>
    <TextSubLayout title="MKBS Kundenzufriedenheit" has-small-limiter>
        <Head>
            <title>MKBS Kundenzufriedenheit – FDBS Umfragen</title>
        </Head>

        <p>
            Wie zufrieden sind Sie mit unserer Marketing-Abteilung? Bitte nehmen Sie sich ein paar
            Minuten Zeit um die nachfolgenden Fragen zu beantworten. Ihr Feedback gibt uns die
            Möglichkeit unsere Produkte und Dienstleistungen zu verbessern und mehr auf Ihre
            Bedürfnisse anzupassen. Es ist uns wichtig, dass Sie als Kunde mit unseren Leistungen
            und der Qualität zufrieden sind.
        </p>
        <p>&nbsp;</p>

        <form @submit.prevent="submit()">
            <h4>Wie zufrieden sind Sie insgesamt mit uns als Marketing-Abteilung?</h4>
            <div class="group">
                <ScaleInput name="s1" :options="sentimentOptions" required v-model="form.generalSentiment"/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Wie zufrieden sind Sie im Allgemeinen mit folgenden Leistungsmerkmalen?</h4>
            <div class="group">
                <h5>Angebot</h5>
                <ScaleInput name="s2" :options="sentimentOptions" required v-model="form.metricPortfolioSentiment"/>
                <h5>Qualität</h5>
                <ScaleInput name="s3" :options="sentimentOptions" required v-model="form.metricQualitySentiment"/>
                <h5>Preis-Leistung</h5>
                <ScaleInput name="s4" :options="sentimentOptions" required v-model="form.metricPriceSentiment"/>
                <h5>Design</h5>
                <ScaleInput name="s5" :options="sentimentOptions" required v-model="form.metricDesignSentiment"/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Wie zufrieden sind Sie im Allgemeinen mit den folgenden Bereichen?</h4>
            <div class="group">
                <h5>Print</h5>
                <ScaleInput name="s6" :options="sentimentOptions" required v-model="form.departmentPrintSentiment"/>
                <h5>Website/Shop</h5>
                <ScaleInput name="s7" :options="sentimentOptions" required v-model="form.departmentWebsiteSentiment"/>
                <h5>Social Media</h5>
                <ScaleInput name="s8" :options="sentimentOptions" required v-model="form.departmentSocialMediaSentiment"/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Wie beurteilen Sie das Leistungsniveau des Marketing-Teams in den folgenden Bereichen?</h4>
            <div class="group">
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
            <p>&nbsp;</p>
    
            <h4>Was können wir tun, um Ihre Zufriedenheit zu erhöhen?</h4>
            <div class="group">
                <mui-input type="textarea" class="input" v-model="form.increaseHappiness" border placeholder="Ihre Antwort..."/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Wünschen Sie sich Schulungen/Beratung?</h4>
            <div class="group">
                <ScaleInput name="s14" show-label :options="booleanOptions" required v-model="form.wantsWorkshops"/>
                <mui-input type="textarea" class="input" v-if="form.wantsWorkshops == 'ja'" v-model="form.workshops" border placeholder="In welcher Form?"/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Würden Sie sich von uns öfter Angebote/Aktionen wünschen?</h4>
            <div class="group">
                <ScaleInput name="s15" show-label :options="booleanOptions" required v-model="form.wantsNewsletter"/>
                <mui-input type="textarea" class="input" v-if="form.wantsNewsletter == 'ja'" v-model="form.offers" border placeholder="In welcher Form? (z. B. Rabatte, Angebotspakete, Gewinnspiele, ...)"/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Wussten Sie, dass wir auch folgende Produkte/Leistungen anbieten?</h4>
            <div class="group">
                <div class="flex v-center gap-1">
                    <b class="flex-1">Social Media Betreuung</b>
                    <ScaleInput name="s16" show-label :options="booleanOptions" required v-model="form.serviceSocialMediaAcknowledgement"/>
                </div>
                <div class="flex v-center gap-1">
                    <b class="flex-1">Erstellung von Webseiten / Onlineshops</b>
                    <ScaleInput name="s17" show-label :options="booleanOptions" required v-model="form.serviceWebsiteAcknowledgement"/>
                </div>
                <div class="flex v-center gap-1">
                    <b class="flex-1">Recruiting (Kampagnen zur Mitarbeitergewinnung)</b>
                    <ScaleInput name="s18" show-label :options="booleanOptions" required v-model="form.serviceRecruitingAcknowledgement"/>
                </div>
                <div class="flex v-center gap-1">
                    <b class="flex-1">Digital Signage (personalisierte Monitorwerbung in Ihrem Laden)</b>
                    <ScaleInput name="s19" show-label :options="booleanOptions" required v-model="form.serviceDigitalSignageAcknowledgement"/>
                </div>
                <div class="flex v-center gap-1">
                    <b class="flex-1">Produktfotografie</b>
                    <ScaleInput name="s20" show-label :options="booleanOptions" required v-model="form.servicePhotographyAcknowledgement"/>
                </div>
                <div class="flex v-center gap-1">
                    <b class="flex-1">Geschäftsausstattung (Visitenkarte, Briefpapier, Blöcke, Kugelschreiber...)</b>
                    <ScaleInput name="s21" show-label :options="booleanOptions" required v-model="form.serviceStationariesAcknowledgement"/>
                </div>
                <div class="flex v-center gap-1">
                    <b class="flex-1">Werbetechnik (Beschilderung, Beklebung von Fahrzeugen und Schaufenstern...)</b>
                    <ScaleInput name="s22" show-label :options="booleanOptions" required v-model="form.serviceAdtechAcknowledgement"/>
                </div>
                
                <mui-input type="textarea" class="input" v-model="form.productSuggestions" border label="Gibt es Produkte, die Sie bei uns vermissen?"/>
            </div>
            <p>&nbsp;</p>
            
            <h4>Wie bewerten Sie uns in folgenden Bereichen gegenüber Mitbewerbern?</h4>
            <div class="group">
                <h5>Qualität</h5>
                <ScaleInput name="s23" :options="comparisonOptions" required v-model="form.competitorQualitySentiment"/>
                <h5>Preis-Leistung</h5>
                <ScaleInput name="s24" :options="comparisonOptions" required v-model="form.competitorPriceSentiment"/>
                <h5>Problemlösung</h5>
                <ScaleInput name="s25" :options="comparisonOptions" required v-model="form.competitorProblemSolvingSentiment"/>
                <h5>Gesamteindruck</h5>
                <ScaleInput name="s26" :options="comparisonOptions" required v-model="form.competitorOverallSentiment"/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Wie wahrscheinlich ist es, dass Sie uns als Werbepartner weiterempfehlen?</h4>
            <div class="group">
                <ScaleInput name="s27" :show-label="false" :options="recommendOptions" required v-model="form.wouldRecommend"/>
            </div>
            <p>&nbsp;</p>
    
            <h4>Haben Sie noch weitere Anregungen/Wünsche für die zukünftige Zusammenarbeit?</h4>
            <div class="group">
                <mui-input type="textarea" class="input" v-model="form.note" border placeholder="Ihre Antwort..."/>
            </div>
            <p>&nbsp;</p>
    
            <div class="group">
                <mui-toggle type="checkbox" class="checkbox" label="Anonym versenden" v-model="form.sendAnonymously"/>

                <template v-if="!form.sendAnonymously">
                    <mui-input type="text" class="input" v-model="form.name" border required label="Name"/>
                    <mui-input type="email" class="input" v-model="form.email" border required label="Email"/>
                </template>

                <hr>

                <mui-toggle type="checkbox" class="checkbox" v-model="form.gdpr" required>
                    <template #label>
                        Ich habe die <a target="_blank" :href="route('datenschutz')">Datenschutzerklärung</a> gelesen und akzeptiere diese.
                    </template>
                </mui-toggle>
        
                <mui-button type="submit" size="large">Absenden</mui-button>
            </div>
        </form>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'

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



    const submit = () => {
        if (!form.gdpr) return

        form.post(route('survey.mkbs.store'))
    }
</script>

<style lang="sass" scoped>
    h4
        font-weight: 600
        color: var(--color-primary)
        margin-top: 2rem
        margin-bottom: 2rem

    .group
        padding: 1rem
        border-radius: var(--radius-l)
        background: var(--color-background-soft)
        display: flex
        flex-direction: column
        gap: 1rem

        h1,h2,h3,h4,h5
            margin: 0

    .input
        width: 100%
        --mui-background: var(--color-background)
        --base-height: 10rem !important
</style>