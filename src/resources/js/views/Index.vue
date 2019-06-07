<template>
    <div>
        <div class="mx-auto pb-md-4 pt-md-5 px-3 py-3 text-center">
            <h1 class="display-4">Blog</h1>
            <p class="lead">
                Read more about why certain features of EventGo really work, tech questions, meet the devs and more!
            </p>
        </div>

        <post-filter></post-filter>
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
    }
</script>