<template>

    <div class="container">
        <h1>Last Posts</h1>
        <hr class="separator"/>
        <div class="row">
            <div class="col-lg-8 col-md-8" >
                <!-- POST -->

                <div class="post" v-for="item in posts">

                    <div class="wrap-ut pull-left">
                        <!-- AVATAR -->
                        <div class="userinfo pull-left">
                            <div class="avatar">
                                <img src="images/avatar.jpg" alt="">
                                <div class="status green"> </div>
                            </div>
                        </div>
                        <!-- TITULO DEL POST Y DESCRIPCION -->
                        <div class="posttext pull-left">
                            <h2><a v-bind:href="'post/'+item.id">
                                    <span v-if="item.status == 0">(CLOSED) {{ item.title }}</span>
                                    <span v-else>{{ item.title }}</span>
                                </a>
                            </h2>
                            <p>{{ item.description }}</p>

                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="postinfo pull-left">
                        <div class="comments">
                            <div class="commentbg">
                                0
                                <div class="mark"></div>
                            </div>
                        </div>
                        <div class="ranking"><i class="glyphicon glyphicon-star"></i>
                            {{item.rate_number}}
                        </div>
                        <div class="created_at"><i class="glyphicon glyphicon-time"></i>
                            {{item.created_at}}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="sidebarblock">
                    <h3>Tags</h3>
                    <div class="divline"></div>
                    <div class="blocktxt">
                        <ul class="tags" >
                            <li v-for="item in datanumbersofposts"><a href="#">{{item.tag_id}}<span class="badge pull-right">{{item.total}}</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('posts, posts nowhere');
        },
        props: {
            datanumbersofposts: {
                type: Array,
            }
        },
        data: function () {
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
            fetchPosts() {
                var page = this.pagination.current_page;
                console.log(page);
                axios.get('/api/post?page=' + page).then((response) => {
                    console.log(response);
                    this.posts = response.data.data;
                    this.pagination = response.data;
                }, error => {
                    //Error Handling
                });
            }
        },
        components: {
            pagination: require('vue-bootstrap-pagination'),
        }
    }

</script>
<style scoped>
</style>