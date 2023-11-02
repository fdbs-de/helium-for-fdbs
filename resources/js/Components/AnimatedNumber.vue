<template>
    <span>{{ formatNumber(animatedNumber) }}</span>
</template>

<script setup>
    import { ref, computed, onMounted, onUpdated, watch } from 'vue'



    const props = defineProps({
        number: {
            type: Number,
            required: true,
        },
        startFrom: {
            type: Number,
            default: 0,
        },
        duration: {
            type: Number,
            default: 1000,
        },
        easing: {
            type: String,
            default: 'easeOutQuart',
        },
        decimals: {
            type: Number,
            default: 0,
        },
    })

    const animatedNumber = ref(props.startFrom)

    const easingFunctions = {
        linear(t) {
            return t;
        },
        easeInQuad(t) {
            return t * t;
        },
        easeOutQuad(t) {
            return t * (2 - t);
        },
        easeInOutQuad(t) {
            return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
        },
        easeInCubic(t) {
            return t * t * t;
        },
        easeOutCubic(t) {
            return (--t) * t * t + 1;
        },
        easeInOutCubic(t) {
            return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
        },
        easeInQuart(t) {
            return t * t * t * t;
        },
        easeOutQuart(t) {
            return 1 - (--t) * t * t * t;
        },
        easeInOutQuart(t) {
            return t < 0.5 ? 8 * t * t * t * t : 1 - 8 * (--t) * t * t * t;
        },
    }

    watch(() => props.number, (newNumber, oldNumber) => {
        if (newNumber !== oldNumber) startAnimation(newNumber)
    }, {
        immediate: true,
    })



    function startAnimation(newNumber)
    {
        let startTime

        function animate(timestamp)
        {
            if (!startTime) startTime = timestamp

            const progress = (timestamp - startTime) / props.duration

            if (progress < 1)
            {
                animatedNumber.value = props.startFrom + (newNumber - props.startFrom) * easingFunctions[props.easing](progress)
                requestAnimationFrame(animate)
            }
            else
            {
                animatedNumber.value = newNumber
            }
        }

        requestAnimationFrame(animate)
    }



    function formatNumber(number)
    {
        return number.toFixed(props.decimals)
    }
</script>