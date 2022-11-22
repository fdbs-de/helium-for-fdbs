<template>
    <div class="editor-wrapper" v-if="editor">
        <div class="editor-controls">
            <select class="select" :value="getNodeType" @input="setNodeType">
                <option value="" disabled>---</option>
                <option value="paragraph">Paragraph</option>
                <option value="h1">H1</option>
                <option value="h2">H2</option>
                <option value="h3">H3</option>
                <option value="h4">H4</option>
                <option value="h5">H5</option>
                <option value="h6">H6</option>
            </select>

            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('bold') }" @click="editor.chain().focus().toggleBold().run()">format_bold</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('italic') }" @click="editor.chain().focus().toggleItalic().run()">format_italic</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('code') }" @click="editor.chain().focus().toggleCode().run()">code</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('link') }" @click="openLinkDialog()">link</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('image') }" @click="openImageDialog()">image</button>
        </div>
        <editor-content class="editor-content" :editor="editor" />
    </div>

    <popup ref="linkDialog" @close="editor.chain().focus().run()">
        <form class="popup-form" @submit.prevent>
            <mui-input type="text" label="URL" v-model="linkForm.url" />
            <select v-model="linkForm.target">
                <option value="_blank">New Window</option>
                <option value="_self">Same Window</option>
            </select>
            <mui-input type="text" label="Rel" v-model="linkForm.rel" />

            <div class="flex">
                <mui-button label="Remove Link" color="error" variant="contained" @click="removeLink()"/>
                <div class="spacer"></div>
                <mui-button label="Insert Link" @click="insertLink()"/>
            </div>
        </form>
    </popup>

    <popup ref="imageDialog" @close="editor.chain().focus().run()">
        <form class="popup-form" @submit.prevent>
            <mui-input type="text" label="URL" v-model="imageForm.url"/>
            <mui-input type="text" label="Alt text" v-model="imageForm.alt"/>
            <!-- <select v-model="imageForm.aspect">
                <option value="">Auto</option>
                <option value="aspect-16-by-9">16 by 9</option>
                <option value="aspect-4-by-3">4 by 3</option>
                <option value="aspect-1-by-1">Square</option>
            </select> -->

            <div class="flex">
                <div class="spacer"></div>
                <mui-button label="Insert Image" @click="insertImage()"/>
            </div>
        </form>
    </popup>
</template>

<script>
    import Popup from '@/Components/Form/Popup.vue'
    import { Editor, EditorContent } from '@tiptap/vue-3'
    import Link from '@tiptap/extension-link'
    import Image from '@tiptap/extension-image'
    import StarterKit from '@tiptap/starter-kit'

    export default {
        props: {
            modelValue: {
                type: String,
                default: '',
            },
        },
        data() {
            return {
                editor: null,
                linkForm: {
                    url: '',
                    target: '_blank',
                    rel: 'nofollow',
                },
                imageForm: {
                    url: '',
                    alt: '',
                    // aspect: '',
                },
            }
        },
        mounted() {
            this.editor = new Editor({
                extensions: [
                    StarterKit.configure({
                        heading: {
                            levels: [1, 2, 3, 4, 5, 6,],
                        },
                    }),
                    Link.configure({
                        linkOnPaste: true,
                        openOnClick: false,
                    }),
                    Image.configure({
                        HTMLAttributes: {
                            class: 'content-image',
                        },
                    })
                ],
                content: this.modelValue,
                onUpdate: () => {
                    this.$emit('update:modelValue', this.editor.getHTML())
                },
            })
        },

        beforeUnmount() {
            this.editor.destroy()
        },

        watch: {
            modelValue(value)
            {
                if (this.editor.getHTML() === value) return
                this.editor.commands.setContent(value, false)
            },
        },

        computed: {
            getNodeType()
            {
                if      (this.editor.isActive('paragraph')) return 'paragraph'
                else if (this.editor.isActive('heading'))   return 'h' + this.editor.getAttributes('heading').level
                else    return ''
            },
        },

        methods: {
            setNodeType(e)
            {
                switch (e.target.value)
                {
                    case 'paragraph': this.editor.chain().focus().setParagraph().run(); break;
                    case 'h1': this.editor.chain().focus().setHeading({ level: 1 }).run(); break;
                    case 'h2': this.editor.chain().focus().setHeading({ level: 2 }).run(); break;
                    case 'h3': this.editor.chain().focus().setHeading({ level: 3 }).run(); break;
                    case 'h4': this.editor.chain().focus().setHeading({ level: 4 }).run(); break;
                    case 'h5': this.editor.chain().focus().setHeading({ level: 5 }).run(); break;
                }
            },

            openLinkDialog()
            {
                this.linkForm.url = this.editor.getAttributes('link').href || ''
                this.linkForm.target = this.editor.getAttributes('link').target || '_blank'
                this.linkForm.rel = this.editor.getAttributes('link').rel || 'nofollow'
                this.$refs.linkDialog.open()
            },

            insertLink()
            {
                this.editor.chain().focus().extendMarkRange('link').setLink({
                    href: this.linkForm.url,
                    target: this.linkForm.target,
                    rel: this.linkForm.rel,
                }).run()
                this.$refs.linkDialog.close()
            },

            removeLink()
            {
                this.editor.chain().focus().extendMarkRange('link').unsetLink().run()
                this.$refs.linkDialog.close()
            },

            openImageDialog()
            {
                this.imageForm.url = this.editor.getAttributes('image').src || ''
                this.imageForm.alt = this.editor.getAttributes('image').alt || ''
                // this.imageForm.aspect = ''
                this.$refs.imageDialog.open()
            },

            insertImage() {
                this.editor.chain().focus().setImage({
                    src: this.imageForm.url,
                    alt: this.imageForm.alt,
                }).run()

                this.$refs.imageDialog.close()
            },
        },

        components: {
            EditorContent,
            Popup,
        },
    }
</script>

<style lang="sass">
    .editor-content
        > div.ProseMirror
            width: 100%
            height: 100%
            padding: 0 1rem
            overflow: auto

            &:focus
                outline: none
</style>

<style lang="sass" scoped>
    .editor-wrapper
        width: 100%
        display: flex
        flex-direction: column
        border: 1px solid var(--color-background-soft)
        background: var(--color-background)
        border-radius: var(--radius-l)
        height: 20rem

        .editor-content
            flex: 1
            height: 100%
            width: 100%
            border-radius: 0 0 var(--radius-l) var(--radius-l)

        .editor-controls
            flex: none
            position: relative
            z-index: 1
            width: 100%
            margin: 0 auto
            display: flex
            padding: .5rem
            gap: .5rem
            border-bottom: 1px solid var(--color-background-soft)
            border-radius: var(--radius-l) var(--radius-l) 0 0

            .select
                height: 2.5rem
                border: none
                background: var(--color-background)
                border-radius: var(--radius-m)
                border: 1px solid var(--color-background-soft)

            .button
                position: relative
                display: flex
                align-items: center
                height: 2.5rem
                padding: 0 .5rem
                user-select: none
                cursor: pointer
                background: var(--color-background)
                border-radius: var(--radius-m)
                border: 1px solid var(--color-background-soft)

                &.icon
                    aspect-ratio: 1
                    justify-content: center
                    font-family: var(--font-icon)
                    font-size: 1.5rem
                    line-height: 1

                &:hover,
                &:focus
                    color: var(--color-heading)
                    background: var(--color-background-soft)
                
                &.is-active
                    background: var(--color-primary)
                    color: var(--color-background)
                    border-color: var(--color-primary)
</style>