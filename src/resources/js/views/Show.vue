<template>
    <div>
        <div>
            <div class="my-5">
                <a href="/blog" class="btn btn-outline-primary mb-3">Back to blog</a>

                <img class="img-fluid border-r-6" :src="post.post_image ? post.post_image : '/vendor/blog/images/default/post-image.png'" />
            </div>

            <h1>{{ post.title }}</h1>

            <div class="mb-5">
                <p class="mb-0" v-if="post.published_at">{{ post.published_at | moment("from") }}</p>
                <p>{{ post.content | readingTime }}</p>
            </div>

            <div v-html="post.content"> </div>

        </div>
        <div class="container-fluid" style="background: #f8fafc">
            <div class="container mt-5 py-5 ">
                <h4 class="mb-4">Read more</h4>
                <posts :posts="related"></posts>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        metaInfo: {
            title: 'Blog | EventGo',
            meta: [
                {
                    name: 'description',
                    content: 'Read more about why certain features of EventGo really work, tech questions, meet the devs and more!',
                }
            ],
        },
        props: ['slug'],
        data() {
           return {
               // Use this slug getter in case you are using vuex
               // slug: this.$route.params.slug,
               post: [],
               related: [],
           }
        },
        created() {
           this.fetchPost();
        },
        methods: {
            fetchPost() {
                axios.get('/blog/api/post/' + this.slug)
                    .then(response => {
                        this.post = response.data.post;
                        this.related = response.data.related;
                    })
                    .catch(error => {});
            }
        }
    }
</script>