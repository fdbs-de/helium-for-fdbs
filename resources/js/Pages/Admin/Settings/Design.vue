<template>
    <Head title="Design Einstellungen" />

    <AdminLayout title="Design Einstellungen">
        <div class="card flex vertical gap-1 padding-block-2">
            <div class="limiter text-limiter">
                <h2>Farben</h2>
                <div class="color-grid">
                </div>
            </div>

            <div class="limiter text-limiter">
                <div class="flex gap-2 vertical">
                    <div class="flex gap-1 v-center padding-bottom-1 border-bottom">
                        <h2 class="margin-0 flex-1">Schriften</h2>
                        <mui-button label="Schrift hinzufügen" @click="addFont()"/>
                    </div>
                    <div class="flex gap-2 vertical" v-if="fontsForm.fonts.length">
                        <div class="flex gap-1 vertical padding-1 background-soft radius-m" v-for="(font, fontIndex) in fontsForm.fonts">
                            <mui-input type="text" placeholder="Name" border v-model="font.name"/>
                            <div class="flex gap-1 vertical" v-for="(file, fileIndex) in font.files">
                                <mui-input type="text" placeholder="Pfad zur Schriftdatei" clearable border v-model="file.url">
                                    <template #right>
                                        <div class="input-group">
                                            <IconButton icon="folder_open" class="input-button" @click="$refs.fontPicker.open((path) => { file.url = path })"/>
                                        </div>
                                        <div class="input-group">
                                            <select class="input-select" v-model="file.weight">
                                                <option value="100">100 – Thin</option>
                                                <option value="200">200 – Extra Light</option>
                                                <option value="300">300 – Light</option>
                                                <option value="400">400 – Regular</option>
                                                <option value="500">500 – Medium</option>
                                                <option value="600">600 – Semi Bold</option>
                                                <option value="700">700 – Bold</option>
                                                <option value="800">800 – Extra Bold</option>
                                                <option value="900">900 – Black</option>
                                            </select>
                                            <IconButton icon="format_italic" class="input-button" :class="{'active': file.style == 'italic'}" @click="file.style = (file.style == 'italic' ? 'normal' : 'italic')"/>
                                        </div>
                                        <div class="input-group">
                                            <IconButton icon="delete" class="input-button" style="color: var(--color-error);" @click="removeFontFile(fontIndex, fileIndex)"/>
                                        </div>
                                    </template>
                                </mui-input>
                            </div>
                            <div class="flex gap-1 v-center">
                                <mui-button type="text" icon-left="delete" label="Schrift löschen" color="error" size="small" variant="contained" border @click="removeFont(fontIndex)"/>
                                <div class="spacer"></div>
                                <mui-button type="text" icon-left="add" label="Schriftschnitt hinzufügen" size="small" variant="contained" border @click="addFontFile(fontIndex)"/>
                            </div>
                        </div>
                    </div>
                    <div class="flex h-center padding-1 padding-block-3" v-else>
                        <span>Es wurden noch keine Schriften hinzugefügt</span>
                    </div>
                </div>
            </div>

            <div class="limiter text-limiter">
                <h2>Logos & Icons</h2>
            </div>

        </div>
    </AdminLayout>

    <Picker ref="imagePicker" accept="image/*"/>
    <Picker ref="fontPicker" accept="*"/>
</template>

<script setup>
    import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { ref, computed, watch } from 'vue'

    import AdminLayout from '@/Layouts/Admin.vue'
    import Picker from '@/Components/Form/MediaLibrary/Picker.vue'
    import IconButton from '@/Components/Apps/Pages/IconButton.vue'

    const props = defineProps({
        settings: Object,
    })



    // START: Fonts
    const fontsForm = useForm({
        fonts: [],
    })

    const addFont = () => {
        fontsForm.fonts.push({
            name: '',
            files: [
                { url: '', style: 'normal', weight: 400 }
            ],
        })
    }

    const removeFont = (index) => {
        fontsForm.fonts.splice(index, 1)
    }

    const addFontFile = (fontIndex) => {
        fontsForm.fonts[fontIndex].files.push({ url: '', style: 'normal', weight: 400, })
    }

    const removeFontFile = (fontIndex, fileIndex) => {
        fontsForm.fonts[fontIndex].files.splice(fileIndex, 1)
    }


    
    
    // START: Error Handling
    const errors = computed(() => usePage().props.value.errors)
    const hasErrors = computed(() => Object.keys(errors.value).length > 0)
    // END: Error Handling
</script>

<style lang="sass" scoped>
    .card
        background: var(--color-background)
        box-shadow: var(--shadow-elevation-low)
        border-radius: var(--radius-m)

    .input-button
        height: 2rem
        width: 2rem
        border-radius: var(--radius-s)
        flex: none

        &.active
            background: var(--color-primary)
            color: var(--color-background)

    .input-group
        gap: .5rem
        padding-inline: .5rem
        display: flex
        align-items: center
        height: 3rem
        border-left: 1px solid var(--color-border)

        &:last-child
            padding-right: 0

    .input-select
        height: 2rem
        border-radius: var(--radius-s)
        flex: none
        background: transparent
        color: var(--color-text)
</style>