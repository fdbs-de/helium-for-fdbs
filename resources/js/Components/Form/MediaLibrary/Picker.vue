<template>
    <Popup ref="picker">
        <div class="flex padding-1">
            <!-- <mui-button label="TEST" @click="select('test File')"/> -->
            <mui-button label="TEST" @click="git()"/>
        </div>
    </Popup>
</template>

<script setup>
    import { ref } from 'vue'

    import Popup from '@/Components/Form/Popup.vue'



    const picker = ref(null)
    const successCallback = ref(null)

    const open = (callback) => {
        successCallback.value = callback
        picker.value.open()
    }

    const git = () => {
        console.log('git')
    }

    const select = (file) => {
        successCallback.value(file)
        picker.value.close()
    }



    defineExpose({
        open
    })
</script>