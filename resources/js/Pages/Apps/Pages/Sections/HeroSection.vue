<template>
    <section class="he-section he-hero-section" :style="sectionStyle">
        <component :is="LimiterManifest.component" class="he-hero-section-limiter" :size="size">
            <div class="he-inner-wrapper" :style="limiterStyle">
                <component :is="titleTag || 'h1'" v-if="title" :style="{color, textAlign}">{{ title }}</component>
            </div>
        </component>
    </section>
</template>

<script setup>
    import { computed } from 'vue'

    import LimiterManifest from '@/Pages/Apps/Pages/Partials/Limiter.manifest.js'



    const props = defineProps({
        size: String,
        titleTag: String,
        title: String,
        isCard: Boolean,
        height: String,
        padding: String,
        backgroundColor: String,
        backgroundImage: String,
        color: String,
        textAlign: String,
        borderRadius: String,
    })

    const backgroundImage = computed(() => {
        return props.backgroundImage ? `url(${props.backgroundImage})` : null
    })

    const sectionStyle = computed(() => {
        if (props.isCard) return {}

        return {
            height: props.height,
            padding: props.padding,
            backgroundColor: props.backgroundColor,
            backgroundImage: backgroundImage.value,
            borderRadius: props.borderRadius,
        }
    })

    const limiterStyle = computed(() => {
        if (!props.isCard) return {}

        return {
            height: props.height,
            padding: props.padding,
            backgroundColor: props.backgroundColor,
            backgroundImage: backgroundImage.value,
            borderRadius: props.borderRadius,
        }
    })
</script>

<style lang="sass" scoped>
    .he-hero-section
        background-size: cover
        background-position: center
        background-repeat: no-repeat
        display: flex
        align-items: center

        .limiter
            max-width: 1200px

        .he-hero-section-limiter
            .he-inner-wrapper
                padding: 0
                border-radius: .75rem
                background-size: cover
                background-position: center
                background-repeat: no-repeat
                display: flex
                flex-direction: column
                justify-content: center

        h1, h2, h3, h4, h5, h6
            font-weight: 700
</style>