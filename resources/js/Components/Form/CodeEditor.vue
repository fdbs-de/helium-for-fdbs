<template>
    <div class="monaco-code-editor-wrapper" id="monaco-editor"></div>
</template>

<script setup>
    import { onMounted, onBeforeUnmount, watch, defineEmits } from 'vue'
    import { emmetHTML, emmetCSS, emmetJSX, expandAbbreviation } from 'emmet-monaco-es'
    import * as monaco from 'monaco-editor'



    const emits = defineEmits(['update:modelValue'])
    const props = defineProps({
        modelValue: {
            type: String,
            default: ''
        },
        language: {
            type: String,
            default: 'html'
        },
        theme: {
            type: String,
            default: 'vs-dark'
        },
    })

    let editor = null
    let emmetHTMLDispose = null



    onMounted(() => {
        editor = monaco.editor.create(document.getElementById('monaco-editor'), {
            value: props.modelValue ?? '',
            language: props.language,
            theme: props.theme,
            automaticLayout: true,
            minimap: {
                enabled: true,
            },
        })

        emmetHTMLDispose = emmetHTML(monaco, ['html', 'php'])

        editor.onDidChangeModelContent((event) => {
            emits('update:modelValue', editor.getValue())
        })
    })

    onBeforeUnmount(() => {
        editor.dispose()
        emmetHTMLDispose()
    })



    watch(() => props.modelValue, (value) => {
        if (editor.getValue() !== value) editor.setValue(value ?? '')
    })

    watch(() => props.language, (value) => {
        monaco.editor.setModelLanguage(editor.getModel(), value)
    })

    watch(() => props.theme, (value) => {
        monaco.editor.setTheme(value)
    })
</script>

<style lang="sass">
.monaco-code-editor-wrapper
    height: 400px
    width: 100%
</style>