<template>
    <div class="editor-wrapper" v-if="editor">
        <div class="editor-controls">
            <div class="toolbar">
                <VDropdown placement="bottom-start">
                    <button type="button" class="toolbar-button drop">Einfügen</button>
                    <template #popper>
                        <div class="dropdown-list">
                            <button type="button" class="dropdown-button" :class="{ 'active': editor.isActive('image') }" @click="openImageDialog()" v-close-popper>
                                <div class="icon">image</div>
                                <div class="label">Bild einfügen</div>
                                <!-- <div class="secondary-info">ctrl+shift+p</div> -->
                            </button>
                            <button type="button" class="dropdown-button" :class="{ 'active': editor.isActive('keyfact') }" @click="openKeyfactDialog()" v-close-popper>
                                <div class="icon">star</div>
                                <div class="label">Keyfact einfügen</div>
                            </button>

                            <div class="dropdown-divider" v-show="!editor.isActive('link')"></div>

                            <button type="button" class="dropdown-button" v-show="!editor.isActive('link')" @click="openLinkDialog()" v-close-popper>
                                <div class="icon">link</div>
                                <div class="label">Link einfügen</div>
                            </button>
                        </div>
                    </template>
                </VDropdown>

                <VDropdown placement="bottom-start">
                    <button type="button" class="toolbar-button drop">Bearbeiten</button>
                    <template #popper>
                        <div class="dropdown-list">
                            <button type="button" class="dropdown-button" :class="{ 'active': editor.isActive('blockquote') }" @click="editor.chain().focus().toggleBlockquote().run()">
                                <div class="icon">format_quote</div>
                                <div class="label">Als <b>Zitat</b> formatieren</div>
                            </button>
                            <button type="button" class="dropdown-button" :class="{ 'active': editor.isActive('code') }" @click="editor.chain().focus().toggleCode().run()">
                                <div class="icon">code</div>
                                <div class="label">Als <b>Code</b> formatieren</div>
                            </button>

                            <div class="dropdown-divider" v-show="editor.isActive('link')"></div>

                            <button type="button" class="dropdown-button" v-show="editor.isActive('link')" @click="openLinkDialog()" v-close-popper>
                                <div class="icon">link</div>
                                <div class="label">Link bearbeiten</div>
                            </button>

                            <div class="dropdown-divider"></div>

                            <button type="button" class="dropdown-button" @click="editor.chain().focus().clearNodes().unsetAllMarks().run()">
                                <div class="icon">format_clear</div>
                                <div class="label">Formatierung löschen</div>
                            </button>
                        </div>
                    </template>
                </VDropdown>

                <div class="spacer"></div>

                <button type="button" class="toolbar-button" v-show="editor.isActive('image')" @click="openImageDialog()">Bild bearbeiten</button>
                <button type="button" class="toolbar-button" v-show="editor.isActive('link')" @click="openLinkDialog()">Link bearbeiten</button>
                <button type="button" class="toolbar-button" v-show="editor.isActive('keyfact')" @click="removeKeyfact()">Keyfact entfernen</button>
            </div>

            <div class="styling-panel" v-show="!isAnyDialogOpen">
                <select class="select" :value="getNodeType" @input="setNodeType">
                    <option value="" disabled>---</option>
                    <option value="paragraph">Paragraph</option>
                    <option value="h1">Überschrift 1</option>
                    <option value="h2">Überschrift 2</option>
                    <option value="h3">Überschrift 3</option>
                    <option value="h4">Überschrift 4</option>
                    <option value="h5">Überschrift 5</option>
                    <option value="h6">Überschrift 6</option>
                </select>
                
                <div class="button-group">
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive({textAlign: 'left'}) }" @click="editor.chain().focus().setTextAlign('left').run()">format_align_left</button>
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive({textAlign: 'center'}) }" @click="editor.chain().focus().setTextAlign('center').run()">format_align_center</button>
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive({textAlign: 'right'}) }" @click="editor.chain().focus().setTextAlign('right').run()">format_align_right</button>
                </div>
                
                <div class="button-group">
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('bold') }" @click="editor.chain().focus().toggleBold().run()">format_bold</button>
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('italic') }" @click="editor.chain().focus().toggleItalic().run()">format_italic</button>
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('underline') }" @click="editor.chain().focus().toggleUnderline().run()">format_underlined</button>
                </div>
                
                <div class="button-group">
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('bulletList') }" @click="editor.chain().focus().toggleBulletList().run()">format_list_bulleted</button>
                    <button type="button" class="button icon" :class="{ 'is-active': editor.isActive('orderedList') }" @click="editor.chain().focus().toggleOrderedList().run()">format_list_numbered</button>
                </div>
                
                <div class="button-group">
                    <VDropdown placement="bottom">
                        <button type="button" class="button icon">format_color_fill</button>
                        <template #popper>
                            <div class="dropdown-grid padding-1">
                                <button type="button" class="swatch blog-editor" v-for="swatch in swatches" :key="swatch.value" v-tooltip="swatch.name" :style="'background: '+swatch.value" @click="editor.chain().focus().setColor(swatch.value).run()"></button>
                                <button type="button" class="swatch blog-editor fullwidth" @click="editor.chain().focus().unsetColor().run()">Zurücksetzen</button>
                            </div>
                        </template>
                    </VDropdown>
                    <button type="button" class="button icon" v-show="!editor.isActive('link')" @click="openLinkDialog()">link</button>
                    <button type="button" class="button icon" v-show="editor.isActive('link')" @click="removeLink()">link_off</button>
                </div>
            </div>

            <div class="property-panel" v-show="imageForm.isOpen">
                <div class="flex wrap gap-1">
                    <mui-button type="button" label="Abbrechen" icon-left="close" variant="contained" size="small" @click="imageForm.isOpen = false" />
                    <div class="spacer"></div>
                    <mui-button type="button" label="Übernehmen" icon-left="check" size="small" @click="insertImage()" />
                </div>
                <div class="flex wrap gap-1">
                    <mui-input type="text" class="flex-1" label="Bild URL" v-model="imageForm.url" clearable/>
                    <mui-input type="text" class="flex-1" label="Alt-Text" v-model="imageForm.alt" clearable/>
                </div>
            </div>

            <div class="property-panel" v-show="linkForm.isOpen">
                <div class="flex wrap gap-1">
                    <mui-button type="button" label="Abbrechen" icon-left="close" variant="contained" size="small" @click="linkForm.isOpen = false" />
                    <div class="spacer"></div>
                    <mui-button type="button" label="Übernehmen" icon-left="check" size="small" @click="insertLink()" />
                </div>
                <div class="flex wrap gap-1">
                    <mui-input class="flex-1" type="text" label="URL" v-model="linkForm.url" clearable/>
                    <select class="flex-1" v-model="linkForm.target">
                        <option value="_blank">Neues Fenster</option>
                        <option value="_self">Gleiches Fenster</option>
                    </select>
                </div>
            </div>

            <div class="property-panel" v-show="keyfactForm.isOpen">
                <div class="flex wrap gap-1">
                    <mui-button type="button" label="Abbrechen" icon-left="close" variant="contained" size="small" @click="keyfactForm.isOpen = false" />
                    <div class="spacer"></div>
                    <mui-button type="button" label="Einfügen" icon-left="check" size="small" @click="insertKeyfact()" />
                </div>
                <div class="flex wrap gap-1">
                    <mui-input type="text" class="flex-1" label="Keyfact Icon" v-model="keyfactForm.icon" clearable />
                </div>
            </div>
        </div>

        <editor-content class="editor-content formatted-content" spellcheck="true" lang="de" :editor="editor" />
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
                isSticky: false,
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

            isAnyDialogOpen()
            {
                return this.linkForm.isOpen || this.imageForm.isOpen || this.keyfactForm.isOpen
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
        font-family: var(--font-interface)
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

    .dropdown-divider
        width: 100%
        border-bottom: 1px solid var(--color-border)
        margin: .5rem 0

    .dropdown-grid
        display: grid
        grid-template-columns: repeat(4, 1fr)
        gap: .5rem

    .dropdown-list
        display: flex
        flex-direction: column
        padding: .5rem 0

    .dropdown-button
        border: none
        background: none
        color: var(--color-text)
        font-family: var(--font-interface)
        padding: 0 .5rem
        text-align: left
        display: flex
        align-items: center
        gap: .5rem
        height: 2rem
        min-width: 14rem
        user-select: none
        cursor: pointer

        &:hover,
        &:focus
            outline: none
            background: var(--color-background-soft)

        &.active
            .icon
                background: var(--color-primary)
                color: var(--color-background)

        .icon
            aspect-ratio: 1
            height: 100%
            display: flex
            align-items: center
            justify-content: center
            font-family: var(--font-icon)
            border-radius: var(--radius-s)
            font-size: 1.1rem
            font-weight: 300
            line-height: 1

        .label
            color: var(--color-heading)
            font-size: .8rem
            font-weight: 500
            flex: 1

        .secondary-info
            font-size: .7rem
            

    .editor-wrapper
        height: 25rem
        width: 100%
        display: flex
        flex-direction: column
        background: var(--color-background)
        border-radius: var(--radius-s)
        position: relative

        .editor-controls
            flex: none
            position: relative
            z-index: 1
            display: flex
            flex-direction: column
            background: var(--color-background)
            position: sticky
            top: 0
            border-top-left-radius: inherit
            border-top-right-radius: inherit

            &::after
                content: ''
                position: absolute
                left: 2px
                bottom: 0
                transform: translateY(100%)
                width: calc(100% - 4px)
                height: 8px
                background: linear-gradient(180deg, rgb(black, 0.07) 0%, rgb(black, 0) 100%)

            .toolbar
                display: flex
                align-items: center
                gap: 1rem
                min-height: 2rem
                background: var(--color-background-soft)
                padding: 0 1rem
                border-top-left-radius: inherit
                border-top-right-radius: inherit

                .spacer
                    flex: 1

                .toolbar-button
                    background: none
                    border: none
                    padding: 0
                    margin: 0
                    cursor: pointer
                    user-select: none
                    display: flex
                    align-items: center
                    font-size:.9rem
                    font-family: var(--font-interface)
                    color: var(--color-heading)

                    &.drop::after
                        content: 'arrow_drop_down'
                        font-family: var(--font-icon)
                        font-size: 1.3rem
                        line-height: 1
                        user-select: none
                        pointer-events: none
                        opacity: .5

                    &:hover,
                    &:focus
                        outline: none
                        color: var(--color-primary)

            .styling-panel
                display: flex
                gap: .5rem
                padding: 1rem .5rem
                flex-wrap: wrap
                align-items: center
                border-left: 2px solid var(--color-background-soft)
                border-right: 2px solid var(--color-background-soft)

                .select
                    height: 2.5rem
                    border: none
                    background: var(--color-background-soft)
                    border-radius: var(--radius-m)
                    border: none

                .button-group
                    height: 2.5rem
                    display: flex
                    align-items: center
                    padding: 0 .25rem
                    border-radius: var(--radius-m)
                    background: var(--color-background-soft)

                .button
                    position: relative
                    display: flex
                    align-items: center
                    height: 2rem
                    padding: 0 .75rem
                    user-select: none
                    cursor: pointer
                    font-family: var(--font-interface)
                    color: var(--color-heading)
                    background: none
                    border-radius: var(--radius-s)
                    border: none

                    &.icon
                        aspect-ratio: 1.2
                        justify-content: center
                        font-family: var(--font-icon)
                        font-size: 1.3rem
                        line-height: 1
                        padding: 0

                    &::after
                        content: ''
                        position: absolute
                        top: 0
                        left: 0
                        right: 0
                        bottom: 0
                        border-radius: inherit
                        background: currentColor
                        opacity: 0

                    &:hover
                        color: var(--color-primary)

                    &:hover::after
                        opacity: .1
                    
                    &.is-active
                        background: var(--color-primary)
                        color: var(--color-background)
            .property-panel
                display: flex
                flex-direction: column
                gap: 1rem
                padding: 1rem
                border-radius: var(--radius-m)
                position: relative
                z-index: 1000
                box-shadow: 0 0 0 100vh rgb(black, 0.5)



        .editor-content
            flex: 1
            height: 100%
            width: 100%
            border: 2px solid var(--color-background-soft)
            border-top: none
            border-bottom-left-radius: inherit
            border-bottom-right-radius: inherit
</style>