<template>
    <div>
        <div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-center my-5">
            <h4>Latest posts</h4>
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <h6 class="m-0">Filter by</h6>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                        {{ categoryName }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg-right">
                        <a class="dropdown-item" href="#" @click.prevent="filterPostsByCategory(0)">All</a>
                        <a v-for="category in categories" class="dropdown-item" :class="selectedCategory.id == category.id ? 'active' : ''" href="#" @click.prevent="filterPostsByCategory(category.id)">{{ category.name }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="posts.length">
            <div class="blog-card blog-card--featured" v-if="featuredPost">
                <div class="blog-card__thumbnail">
                    <a :href="'/blog/' + featuredPost.slug" :title="featuredPost.title">
                        <img style="max-width: 100%;" :src="featuredPost.preview_image ? featuredPost.preview_image : 'vendor/blog/images/default/post-preview.png'" :alt="featuredPost.title">
                    </a>
                </div>
                <div class="blog-card__content">
                    <a :href="'/blog/' + featuredPost.slug" :title="featuredPost.title">
                        <h5 class="blog-card__title mb-2">{{ featuredPost.title }}</h5>
                    </a>
                    <div class="mb-2">
                        <div v-html="substr(featuredPost.content, 232)"> </div>
                    </div>
                    <div class="blog-card__footer">
                        <div>{{ featuredPost.content | readingTime }}</div>
                        <div>
                            <a :href="'/blog/' + featuredPost.slug" :title="featuredPost.title">
                                Read more &nbsp; <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
<!--                            <router-link :to="'/blog/' + featuredPost.slug" :title="featuredPost.title" class="blog-card__readmore-link">-->
<!--                                Read more &nbsp; <i class="fas fa-long-arrow-alt-right"></i>-->
<!--                            </router-link>-->
                        </div>
                    </div>
                </div>
            </div>

            <posts :posts="normalPosts"></posts>
        </div>
        <div v-else>
            <h5>No posts match your criteria.</h5>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                posts: [],
                categories: [],
                featuredPost: [],
                normalPosts: [],
                selectedCategory: false,
            }
        },

        computed: {
            categoryName() {
                return this.selectedCategory ? this.selectedCategory.name : 'All'
            },
        },

        created(){
            this.fetchAllPosts();
            this.fetchAllCategories();
        },

        methods: {
            changeCategoryTag(id) {
                this.selectedCategory = false;

                if(id !== 0) {
                    this.selectedCategory = _.find(this.categories, ['id', id]);
                }
            },

            fetchAllPosts(){
                axios.get('/blog/api/latest')
                    .then(response => {
                        this.posts = response.data;

                        this.featuredPost = _.head(response.data);
                        this.normalPosts = _.drop(response.data, 1);
                    }).catch(error => {});
            },

            fetchAllCategories() {
                axios.get('/blog/api/categories')
                    .then(response => {
                        this.categories = response.data;
                    }).catch(error => {});
            },

            filterPostsByCategory(id) {
                this.changeCategoryTag(id);

                axios.get('/blog/api/categories/' + id)
                    .then(response => {
                        this.posts = response.data.posts;

                        this.featuredPost = _.head(response.data.posts);
                        this.normalPosts = _.drop(response.data.posts, 1);
                    }).catch(error => {});
            },

            substr(text, words){
                var newtext = text.substring(0, words) + '...';

                newtext = newtext.replace(/<br>/gi, "\n");
                newtext = newtext.replace(/<p.*>/gi, "\n");
                newtext = newtext.replace(/<(?:.|\s)*?>/g, "");

                return newtext;
            }
        },
    }
</script>

<style scoped>

</style>