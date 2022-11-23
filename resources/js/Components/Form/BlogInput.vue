<template>
    <div class="editor-wrapper" v-if="editor">
        <div class="editor-controls">
            <select class="select" :value="getNodeType" @input="setNodeType">
                <option value="" disabled>---</option>
                <option value="paragraph">Text</option>
                <option value="h1">H1</option>
                <option value="h2">H2</option>
                <option value="h3">H3</option>
                <option value="h4">H4</option>
                <option value="h5">H5</option>
                <option value="h6">H6</option>
            </select>

            <div class="vertical-separator"></div>

            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('bold') }" @click="editor.chain().focus().toggleBold().run()">format_bold</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('underline') }" @click="editor.chain().focus().toggleUnderline().run()">format_underlined</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('italic') }" @click="editor.chain().focus().toggleItalic().run()">format_italic</button>

            <div class="vertical-separator"></div>
            
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('bulletList') }" @click="editor.chain().focus().toggleBulletList().run()">format_list_bulleted</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('orderedList') }" @click="editor.chain().focus().toggleOrderedList().run()">format_list_numbered</button>

            <div class="vertical-separator"></div>

            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('link') }" @click="openLinkDialog()">link</button>
            <!-- <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('image') }" @click="openImageDialog()">image</button> -->
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('blockquote') }" @click="editor.chain().focus().toggleBlockquote().run()">format_quote</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('code') }" @click="editor.chain().focus().toggleCode().run()">code</button>
            
            <div class="vertical-separator"></div>
            
            <button type="button" class="button icon" title="Formatierung löschen" @click="editor.chain().focus().clearNodes().unsetAllMarks().run()">format_clear</button>
        </div>

        <editor-content class="editor-content" :editor="editor" />

        <div class="editor-footer">
            <span>{{ editor.storage.characterCount.words() }} Wörter</span>
            <span>•</span>
            <span>{{ editor.storage.characterCount.characters() }} Zeichen</span>
        </div>

        <div class="dialog-wrapper" v-show="linkForm.isOpen">
            <div class="background" @click="linkForm.isOpen = false"></div>
            <div class="dialog-content">
                <mui-button type="button" label="Link entfernen" color="error" variant="contained" @click="removeLink()" />
                <hr>
                <mui-input type="text" label="URL" v-model="linkForm.url" />
                <select v-model="linkForm.target">
                    <option value="_blank">Neues Fenster</option>
                    <option value="_self">Gleiches Fenster</option>
                </select>
                <mui-button type="button" label="Link speichern" @click="insertLink()" />
            </div>
        </div>
    </div>
        
        
        
    <!-- <popup ref="linkDialog" title="Link einfügen oder bearbeiten" @close="editor.chain().focus().run()">
        <form class="margin-1 flex wrap gap-1 vertical" @submit.prevent>
            <div class="flex gap-1 wrap">
                <mui-input class="flex-3" type="text" label="URL" v-model="linkForm.url" />
                <select class="flex-1" v-model="linkForm.target">
                    <option value="_blank">Neues Fenster</option>
                    <option value="_self">Gleiches Fenster</option>
                </select>
            </div>

            <mui-input class="flex-1" type="text" label="Rel" v-model="linkForm.rel" />

            <hr>

            <div class="flex gap-1">
                <mui-button label="Link entfernen" color="error" variant="contained" @click="removeLink()"/>
                <div class="spacer"></div>
                <mui-button label="Link speichern" @click="insertLink()"/>
            </div>
        </form>
    </popup>

    <popup ref="imageDialog" title="Bild einfügen" @close="editor.chain().focus().run()">
        <form class="margin-1 flex wrap gap-1 vertical" @submit.prevent>
            <mui-input type="text" label="Bild-URL" v-model="imageForm.url"/>
            <mui-input type="text" label="Alternativ-Text" v-model="imageForm.alt"/>
            <select v-model="imageForm.aspect">
                <option value="">Auto</option>
                <option value="aspect-16-by-9">16 by 9</option>
                <option value="aspect-4-by-3">4 by 3</option>
                <option value="aspect-1-by-1">Square</option>
            </select>

            <div class="flex">
                <div class="spacer"></div>
                <mui-button label="Bild einfügen" @click="insertImage()"/>
            </div>
        </form>
    </popup> -->
</template>

<script>
    import Popup from '@/Components/Form/Popup.vue'
    import { Editor, EditorContent } from '@tiptap/vue-3'
    import Link from '@tiptap/extension-link'
    import Image from '@tiptap/extension-image'
    import Underline from '@tiptap/extension-underline'
    import CharacterCount from '@tiptap/extension-character-count'
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
                    isOpen: false,
                    url: '',
                    target: '_blank',
                    rel: '',
                },
                imageForm: {
                    url: '',
                    alt: '',
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
                        blockquote: {
                            HTMLAttributes: {
                                class: 'content-blockquote',
                            },
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
                    }),
                    Underline.configure({
                        HTMLAttributes: {
                            class: 'content-underline',
                        },
                    }),
                    CharacterCount,
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
                this.linkForm.rel = this.editor.getAttributes('link').rel || ''
                this.linkForm.isOpen = true
            },

            insertLink()
            {
                this.editor.chain().focus().extendMarkRange('link').setLink({
                    href: this.linkForm.url,
                    target: this.linkForm.target,
                    rel: this.linkForm.rel,
                }).run()

                this.linkForm.isOpen = false
            },

            removeLink()
            {
                this.editor.chain().focus().extendMarkRange('link').unsetLink().run()
                this.linkForm.isOpen = false
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
            display: inline-block
            width: 100%
            min-height: 100%
            padding: 0 1rem

            &:focus
                outline: none
</style>

<style lang="sass" scoped>
    .editor-wrapper
        --color-border: #ccc
        height: 25rem

        width: 100%
        display: flex
        flex-direction: column
        background: var(--color-background)
        border-radius: var(--radius-m)
        border: 1px solid var(--color-border)
        position: relative

        .editor-controls
            flex: none
            position: relative
            z-index: 1
            width: 100%
            margin: 0 auto
            display: flex
            flex-wrap: wrap
            align-items: center
            padding: 0 .5rem
            border-bottom: 1px solid var(--color-border)
            background: var(--color-background-soft)
            border-radius: var(--radius-m) var(--radius-m) 0 0

            .vertical-separator
                width: 0
                border-left: 1px solid var(--color-border)
                margin: 0 .5rem
                height: 3.5rem

            .select
                height: 2.5rem
                border: none
                background: var(--color-background-soft)
                border-radius: var(--radius-m)
                border: none

            .button
                position: relative
                display: flex
                align-items: center
                height: 2.5rem
                padding: 0 .75rem
                user-select: none
                cursor: pointer
                text-transform: uppercase
                font-weight: 500
                font-family: var(--font-text)
                background: var(--color-background-soft)
                border-radius: var(--radius-m)
                border: none

                &.icon
                    aspect-ratio: 1
                    justify-content: center
                    font-family: var(--font-icon)
                    font-size: 1.5rem
                    line-height: 1

                &:hover,
                &:focus
                    color: var(--color-primary)
                    background: rgba(0, 0, 0, 0.05)
                
                &.is-active
                    background: var(--color-primary)
                    color: var(--color-background)

        .editor-content
            flex: 1
            height: 100%
            width: 100%
            border-top: none
            overflow: auto

        .editor-footer
            display: flex
            flex-wrap: wrap
            align-items: center
            padding: 0 .5rem
            gap: .5rem
            font-size: .8rem
            min-height: 1.75rem
            border-top: 1px solid var(--color-border)
            background: var(--color-background-soft)
            border-radius: 0 0 var(--radius-m) var(--radius-m)

        .dialog-wrapper
            position: absolute
            top: 0
            left: 0
            width: 100%
            height: 100%
            border-radius: inherit
            display: flex
            align-items: center
            justify-content: center

            .background
                position: absolute
                top: 0
                left: 0
                width: 100%
                height: 100%
                background: rgba(0, 0, 0, 0.5)
                z-index: 1
                border-radius: inherit

            .dialog-content
                display: flex
                flex-direction: column
                gap: 1rem
                padding: 1rem
                background: var(--color-background)
                width: calc(100% - 2rem)
                max-width: 500px
                z-index: 1
                position: relative
                border-radius: var(--radius-m)
                box-shadow: var(--shadow-elevation-medium)
</style>