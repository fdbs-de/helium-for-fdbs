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
            
            <!-- <button type="button" class="button icon" :class="{ 'is-active': editor.isActive({textAlign: 'left'}) }" @click="editor.chain().focus().setTextAlign('left').run()">format_align_left</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive({textAlign: 'center'}) }" @click="editor.chain().focus().setTextAlign('center').run()">format_align_center</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive({textAlign: 'right'}) }" @click="editor.chain().focus().setTextAlign('right').run()">format_align_right</button>
            
            <div class="vertical-separator"></div> -->
            
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('bold') }" @click="editor.chain().focus().toggleBold().run()">format_bold</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('underline') }" @click="editor.chain().focus().toggleUnderline().run()">format_underlined</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('italic') }" @click="editor.chain().focus().toggleItalic().run()">format_italic</button>
            
            <div class="vertical-separator"></div>
            
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('bulletList') }" @click="editor.chain().focus().toggleBulletList().run()">format_list_bulleted</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('orderedList') }" @click="editor.chain().focus().toggleOrderedList().run()">format_list_numbered</button>
            
            <div class="vertical-separator"></div>

            <VDropdown placement="bottom">
                <button type="button" class="button icon">format_color_fill</button>
                <template #popper>
                    <div class="dropdown-grid padding-1">
                        <button type="button" class="swatch blog-editor" v-for="swatch in swatches" :key="swatch.value" v-tooltip="swatch.name" :style="'background: '+swatch.value" @click="editor.chain().focus().setColor(swatch.value).run()"></button>
                        <button type="button" class="swatch blog-editor fullwidth" @click="editor.chain().focus().unsetColor().run()">Zurücksetzen</button>
                    </div>
                </template>
            </VDropdown>
            
            <div class="vertical-separator"></div>
            
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('link') }" @click="openLinkDialog()">link</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('image') }" @click="openImageDialog()">image</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('blockquote') }" @click="editor.chain().focus().toggleBlockquote().run()">format_quote</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('code') }" @click="editor.chain().focus().toggleCode().run()">code</button>
            <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('keyfact') }" @click="openKeyfactDialog()">star</button>
            
            <div class="vertical-separator"></div>
            
            <button type="button" class="button icon" title="Formatierung löschen" @click="editor.chain().focus().clearNodes().unsetAllMarks().run()">format_clear</button>
        </div>

        <editor-content class="editor-content formatted-content" :editor="editor" />

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

        <div class="dialog-wrapper" v-show="imageForm.isOpen">
            <div class="background" @click="imageForm.isOpen = false"></div>
            <div class="dialog-content">
                <mui-input type="text" label="Bild URL" v-model="imageForm.url" />
                <mui-input type="text" label="Alt-Text" v-model="imageForm.alt" />
                <mui-button type="button" label="Bild speichern" @click="insertImage()" />
            </div>
        </div>

        <div class="dialog-wrapper" v-show="keyfactForm.isOpen">
            <div class="background" @click="keyfactForm.isOpen = false"></div>
            <div class="dialog-content">
                <mui-button type="button" label="Keyfact entfernen" color="error" variant="contained" @click="removeKeyfact()" />
                <hr>
                <mui-input type="text" label="Keyfact Icon" v-model="keyfactForm.icon" />
                <mui-button type="button" label="Keyfact einfügen" @click="insertKeyfact()" />
            </div>
        </div>
    </div>
</template>

<script>
    import { Editor, EditorContent } from '@tiptap/vue-3'
    import { Node } from '@tiptap/core'
    import Link from '@tiptap/extension-link'
    import Image from '@tiptap/extension-image'
    import Underline from '@tiptap/extension-underline'
    import CharacterCount from '@tiptap/extension-character-count'
    import TextAlign from '@tiptap/extension-text-align'
    import TextStyle from '@tiptap/extension-text-style'
    import Color from '@tiptap/extension-color'
    import StarterKit from '@tiptap/starter-kit'

    import Popup from '@/Components/Form/Popup.vue'

    const swatches = [
        { value: 'var(--color-primary)', name: 'Primärfarbe' },
        { value: 'var(--color-primary-soft)', name: 'Weiche Primärfarbe' },
        { value: 'var(--color-text)', name: 'Textfarbe' },
        { value: 'var(--color-heading)', name: 'Überschriftfarbe' },
        { value: 'var(--color-info)', name: 'Info' },
        { value: 'var(--color-success)', name: 'Erfolg' },
        { value: 'var(--color-warning)', name: 'Warnung' },
        { value: 'var(--color-error)', name: 'Fehler' },
    ]



    const Keyfact = Node.create({
        name: 'keyfact',
        group: 'block',
        content: 'block*',
        defining: true,
        draggable: false,

        parseHTML() {
            return [
                {
                    tag: 'div.key-fact',
                    getAttrs: (element) => {
                        return {
                            icon: element.querySelector('span.icon').innerHTML,
                        }
                    },
                },
            ]
        },
        addAttributes() {
            return {
                icon: {
                    default: 'star',
                },
            }
        },
        renderHTML({ HTMLAttributes }) {
            return [
                'div',
                {
                    ...HTMLAttributes,
                    class: 'key-fact',
                },
                [
                    'span',
                    {
                        class: 'icon',
                        'data-icon': HTMLAttributes['icon'],
                        'contenteditable': 'false',
                    },
                    '',
                ],
                [
                    'div',
                    {
                        class: 'content',
                    },
                    0,
                ],
            ]
        },
        addCommands() {
            return {
                setKeyfact: (icon) => ({ commands }) => {
                    return commands.wrapIn('keyfact', { icon })
                },

                unsetKeyfact: () => ({ commands }) => {
                    return commands.lift('keyfact')
                },

                toggleKeyfact: (icon) => ({ commands }) => {
                    return commands.toggleWrap('keyfact', { icon })
                },

                updateKeyfact: (icon) => ({ commands }) => {
                    return commands.updateAttributes('keyfact', { icon })
                },
            }
        },
    })



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
                    isOpen: false,
                    url: '',
                    alt: '',
                },
                keyfactForm: {
                    isOpen: false,
                    icon: 'star',
                },
                swatches,
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
                    TextAlign.configure({
                        types: ['heading', 'paragraph'],
                        alignments: ['left', 'center', 'right'],
                    }),
                    TextStyle,
                    Color,
                    CharacterCount,
                    Keyfact,
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
                this.imageForm.isOpen = true
            },

            insertImage() {
                this.editor.chain().focus().setImage({
                    src: this.imageForm.url,
                    alt: this.imageForm.alt,
                }).run()

                this.imageForm.isOpen = false
            },

            openKeyfactDialog()
            {
                this.keyfactForm.isOpen = true
            },

            insertKeyfact()
            {
                this.editor.chain().focus().setKeyfact(this.keyfactForm.icon).run()
                this.keyfactForm.isOpen = false
            },

            removeKeyfact()
            {
                this.editor.chain().focus().unsetKeyfact().run()
                this.keyfactForm.isOpen = false
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
    .swatch.blog-editor
        display: flex
        align-items: center
        justify-content: center
        font-size: 1rem
        font-family: var(--font-text)
        color: var(--color-text)
        padding: 0 .5rem
        height: 2.5rem
        aspect-ratio: 1
        border-radius: 5px
        cursor: pointer
        user-select: none
        border: 2px solid var(--color-background)
        box-shadow: 0 0 0 1px var(--color-border)
        background: var(--color-background)

        &:hover
            box-shadow: 0 0 0 1px var(--color-primary)

        &.fullwidth
            grid-column: 1 / -1
            aspect-ratio: unset

    .dropdown-grid
        display: grid
        grid-template-columns: repeat(4, 1fr)
        gap: .5rem

    .editor-wrapper
        --color-border: #ccc
        height: 25rem

        width: 100%
        display: flex
        flex-direction: column
        background: var(--color-background)
        border-radius: var(--radius-m)
        border: 3px solid var(--color-background-soft)
        position: relative

        .editor-controls
            flex: none
            position: relative
            z-index: 1
            margin: 0 auto
            display: flex
            flex-wrap: wrap
            align-items: center
            padding: 0 .5rem
            background: var(--color-background-soft)
            border-radius: var(--radius-s)
            margin: 3px

            .vertical-separator
                width: 0
                border-left: 1px solid var(--color-border)
                margin: .5rem
                height: 2.5rem

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
                    padding: 0

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
            // overflow: auto

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