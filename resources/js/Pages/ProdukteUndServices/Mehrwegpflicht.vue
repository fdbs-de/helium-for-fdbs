<template>
    <Head>
        <title>Mehrwegpflicht – FDBS</title>
    </Head>

    <TextSubLayout title="Mehrwegpflicht ab 01.01.2023" image="/images/content/banner/mehrwegpflicht_481353401.webp">
        <div class="flex wrap gap-3 margin-block-8 margin-top-4 v-center">
            <SpecCard class="flex-1" :spec="countdown.days" subtitle="Tage"/>
            <SpecCard class="flex-1" :spec="countdown.hours" subtitle="Stunden"/>
            <SpecCard class="flex-1" :spec="countdown.minutes" subtitle="Minuten"/>
            <SpecCard class="flex-1" :spec="countdown.seconds" subtitle="Sekunden"/>
        </div>

        <div class="limiter text-limiter" style="padding: 0">
            <h2>Was ist die Mehrwegpflicht?</h2>
            <p>
                Ab dem 01. Januar 2023 sind alle Geschäfte, die Essen oder Getränke „to go“ verkaufen, dazu verpflichtet, ihre Produkte
                sowohl in Einweg- als auch in Mehrwegverpackungen anzubieten.<br><br>
            </p>
            
            <h2>Gibt es Ausnahmen?</h2>
            <p>
                Es gibt eine Ausnahmeregelung, die besagt, dass Betriebe, die weniger als fünf Mitarbeiter und eine Verkaufsfläche
                unter 80m2 haben, von der Pflicht ausgenommen sind. Jene Betriebe sind aber dazu verpflichtet, Speisen oder Getränke
                auf Wunsch in mitgebrachte Behältnisse zu füllen.<br><br>
            </p>
            
            <h2>Und wozu das Ganze?</h2>
            <p>
                Als Anbieter von Mehrwegverpackungen leisten Sie zum einen einen Beitrag zum Umweltschutz. Zum anderen sparen Sie
                Kosten ein, denn die Verpackungen können wiederverwendet werden und müssen nicht so häufig ersetzt werden. Außerdem
                stärken Sie so die Kundenbindung: setzen Sie ein Pfandsystem ein, kommt der Kunde immer wieder zu Ihnen zurück und
                erwirbt bestenfalls häufiger Gerichte oder Getränke in Ihrem Geschäft!<br><br>
            </p>
            
            <h2>Was bietet der FDBS für Möglichkeiten?</h2>
            <p>
                Wir haben natürlich vorgesorgt und können Ihnen ein Sortiment an Mehrwegverpackungen der Marke Thermohauser zum Kauf
                anbieten. Diese können auf Wunsch auch mit Ihrem Logo versehen werden. Des Weiteren arbeiten wir mit der Firma FairCup
                zusammen und bieten Ihnen damit ein flexibles Mietpfandsystem für Ihr To-Go-Geschäft. Bestehend aus verschiedenen
                Bechern und Behältern können Sie Ihr eigenes Mehrwegportfolio zusammenstellen.<br><br>
            </p>

            <h2>Ich hätte gerne weitere Informationen, wo kann ich mich melden?</h2>
            <p>
                Für mehr Informationen, ein persönliches Gespräch oder Ihr individuelles Angebot, melden Sie
                sich gerne unter <b>0531 210 55 23</b> oder schreiben Sie eine Email an <a href="mailto:info@fdbs.de">info@fdbs.de</a>.
            </p>
            
            <img src="/images/content/mehrwegpflicht/mehrwegloesungen.jpg" alt="Mehrweglösungen" class="w-100 margin-top-3 border-soft radius-l">
        </div>
    </TextSubLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue'
    import TextSubLayout from '@/Layouts/SubLayouts/Text.vue'
    import SpecCard from '@/Components/Page/SpecCard.vue'

    const targetDay = new Date(2022, 11, 31, 23, 59, 59)
    const countdown = ref({
        days: '00',
        hours: '00',
        minutes: '00',
        seconds: '00'
    })

    const getCountdown = () => {
        const diff = targetDay.getTime() - new Date().getTime()
        const days = Math.max(Math.floor(diff / (1000 * 60 * 60 * 24)), 0).toString().padStart(2, '0')
        const hours = Math.max(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)), 0).toString().padStart(2, '0')
        const minutes = Math.max(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)), 0).toString().padStart(2, '0')
        const seconds = Math.max(Math.floor((diff % (1000 * 60)) / 1000), 0).toString().padStart(2, '0')

        countdown.value = {
            days,
            hours,
            minutes,
            seconds
        }
    }

    setInterval(getCountdown, 1000)
    getCountdown()
</script>