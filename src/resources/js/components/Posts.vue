<template>
    <div>
        <div class="d-flex flex-column flex-lg-row mb-lg-5 mt-5" v-for="chunk in postChunks">
            <div class="blog-card" v-for="post in chunk">
                <div class="blog-card__thumbnail">
                    <a :href="'/blog/' + post.slug" :title="post.title">
                        <img :src="post.preview_image ? post.preview_image : 'vendor/blog/images/default/post-preview.png'" :alt="post.title">
                    </a>
                </div>
                <div class="blog-card__content">
                    <a :href="'/blog/' + post.slug" :title="post.title">
                        <h6 class="blog-card__title mb-2 mt-3 bold">{{ post.title }}</h6>
                    </a>
                    <div class="mb-2">
                        <div v-html="substr(post.content, 100)"> </div>
                    </div>
                    <div>{{ post.content | readingTime }}</div>
                    <div>
                        <a :href="'/blog/' + post.slug" :title="post.title">
                            Read more &nbsp; <i class="fas fa-long-arrow-alt-right"></i>
                        </a>
<!--                        <router-link :to="'/blog/' + post.slug" class="blog-card__readmore-link">-->
<!--                            Read more &nbsp; <i class="fas fa-long-arrow-alt-right"></i>-->
<!--                        </router-link>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['posts'],
        methods: {
            substr(text, words){
                var newtext = text.substring(0, words) + '...';

                newtext = newtext.replace(/<br>/gi, "\n");
                newtext = newtext.replace(/<p.*>/gi, "\n");
                newtext = newtext.replace(/<(?:.|\s)*?>/g, "");

                return newtext;
            }
        },
        computed: {
            postChunks(){
                if(!this.posts) { return; }
                return _.chunk(this.posts, 3);
            },
        },
    }
</script>