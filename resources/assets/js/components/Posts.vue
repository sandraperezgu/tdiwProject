<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12" v-for="item in posts">
                <div class="post_container margin20bottom">
                    <a v-bind:href="'post/'+item.id">
                        <div class="row"><div class="col-md-12">
                                <span>{{ item.title }}</span>
                            </div>
                        </div>

                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <pagination :pagination="pagination" :callback="fetchPosts" :options="paginationOptions"></pagination>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('posts, posts nowhere');
        },
        data: function() {
            return {
                items: [],
                posts: [],
                pagination: {
                    total: 0,
                    per_page: 5,    // required
                    current_page: 1, // required
                    last_page: 0,    // required
                    from: 1,
                    to: 5           // required
                },
                paginationOptions: {
                    offset: 4,
                    previousText: 'Prev',
                    nextText: 'Next',
                    alwaysShowPrevNext: true
                }
            }
        },
        created: function () {
            this.fetchPosts();
        },
        methods: {
            fetchPosts (){
                var page = this.pagination.current_page;
                console.log(page);
                axios.get('/api/post?page=' + page).then((response) => {
                    console.log(response);
                    this.posts = response.data.data;
                    this.pagination = response.data;
                }, error => {
                    //Error Handling
                });
            },

        },
        components: {
            pagination: require('vue-bootstrap-pagination'),
        }
    }

</script>
<style scoped>
</style>