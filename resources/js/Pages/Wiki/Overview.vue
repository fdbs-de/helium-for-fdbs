<template>
    <WikiLayout>
        <Head>
            <title>Firmenwiki</title>
            <meta name="description" content="Wir sind FDBS – Ihre Kompetenz rund um den Foodservice. Von Food, über Non-Food bis hin zum Marketing und technischen Kundendienst können wir Ihnen helfen.">
        </Head>

        <main>
            <section id="hero">
                <div class="limiter">
                    <div class="card">
                        <h1>Firmenwiki</h1>
                        <form class="search-bar" action="#" @submit.prevent>
                            <mui-input placeholder="Im Wiki Suchen" clearable/>
                            <div class="tags">
                                <small>Abteilungen</small>

                                <div class="department" style="color: #10ac84;">
                                    <div class="icon">badge</div>
                                    <h3>HR</h3>
                                </div>
                    
                                <div class="department" style="color: #1e90ff;">
                                    <div class="icon">local_shipping</div>
                                    <h3>Logistik</h3>
                                </div>
                    
                                <div class="department" style="color: #6c5ce7;">
                                    <div class="icon">campaign</div>
                                    <h3>Marketing</h3>
                                </div>
                    
                                <div class="department" style="color: #e84393;">
                                    <div class="icon">shopping_cart</div>
                                    <h3>Vertrieb</h3>
                                </div>
                    
                                <div class="department" style="color: #EA2027;">
                                    <div class="icon">restaurant</div>
                                    <h3>Fleisch</h3>
                                </div>
                    
                                <div class="department" style="color: #ff6348;">
                                    <div class="icon">tools_wrench</div>
                                    <h3>Werkstatt</h3>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section id="posts">
                <div class="limiter">
                    <h2>Neueste Beiträge</h2>
                    <div class="grid">
                        <Card v-for="post in posts" cover
                            aspect-ratio="16/9"
                            :key="post.id"
                            :name="post.title"
                            :image="post.image"
                            :primary-tag="post.category ? post.category.name : 'Keine Kategorie'"
                            :link="'#'"
                        />
                    </div>
                </div>
            </section>
        </main>
    </WikiLayout>
</template>

<script setup>
    import WikiLayout from '@/Layouts/Wiki.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import Card from '@/Components/Page/Card.vue'
    import { ref } from 'vue'

    defineProps({
        posts: Array,
    })
</script>

<style lang="sass" scoped>
    main
        display: flex
        flex-direction: column

    section#hero
        display: flex
        margin-top: calc(var(--height-header) + 1rem)
        margin-bottom: 8rem

        .card
            display: flex
            align-items: center
            justify-content: center
            height: 300px
            padding: 0 1rem
            background-color: var(--color-background-soft)
            background-position: center
            background-repeat: no-repeat
            background-size: cover
            border-radius: var(--radius-xl)
            position: relative

            h1
                color: var(--color-primary)
                text-align: center
                font-weight: 700
                text-shadow: 0 0 10px var(--color-background-soft)

        .search-bar
            position: absolute
            bottom: 0
            left: 4rem
            transform: translateY(50%)
            width: calc(100% - 8rem)
            --mui-background: var(--color-background)
            background: var(--color-background)
            border-radius: var(--radius-m)
            box-shadow: var(--shadow-elevation-medium)
            border: 1px solid var(--color-background-soft)

        .tags
            display: flex
            flex-wrap: wrap
            align-items: center
            gap: 1rem
            padding: .5rem 1rem
            border-top: 1px solid var(--color-background-soft)

        .department
            display: flex
            align-items: center
            gap: .5rem
            padding: .3rem 1rem .3rem .7rem
            border-radius: 60rem
            background: var(--color-background)
            position: relative
            user-select: none
            cursor: pointer
            margin: 0

            &::after
                content: ""
                position: absolute
                top: 0
                left: 0
                width: 100%
                height: 100%
                border-radius: inherit
                background: currentColor
                opacity: 0.1

            .icon
                font-size: 1.25rem
                font-family: var(--font-icon)
                aspect-ratio: 1
                line-height: 1
                display: flex
                align-items: center
                justify-content: center

            h3
                font-size: .8rem
                font-weight: 400
                margin: 0
                color: currentColor

    section#posts
        .grid
            display: grid
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))
            gap: 1rem
</style>