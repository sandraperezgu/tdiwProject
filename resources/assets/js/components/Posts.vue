<template>

    <div class="container">
        <h1>Last Posts</h1>
        <div class="row">
            <div class="col-xs-6 col-sm-4">
                <input v-model="inputVal" type="search" id="name_search" class="form-control" placeholder="Search questions by title..." />
            </div>
            <div class="col-xs-6 col-sm-4">
            <button @click="search_query()" id="search_button" class="btn btn-primary">Search</button>
            <a href="/" class="btn btn-primary">Clean filters</a>
            </div>
        </div>
        <hr class="separator"/>
        <div class="row">
            <div class="col-lg-8 col-md-8" >
                <!-- POST -->

                <div class="post" v-for="item in posts">

                    <div class="wrap-ut pull-left">
                        <!-- AVATAR -->
                        <div class="userinfo pull-left">
                            <div class="avatar">
                                <img v-if="datausers[item.user_id]" v-bind:src="datausers[item.user_id]" alt="">
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
                            <div class="commentbg" v-if="datareplies[item.id]>=0">
                                {{datareplies[item.id]}}
                                <div class="mark"></div>
                            </div>
                            <div class="commentbg" v-else>
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
                    <h3>Filter by Tags</h3>
                    <div class="divline"></div>
                    <div class="blocktxt">
                        <ul class="tags" >
                            <li v-for="item in datanumbersofposts"><a :class="{ selected : tags.includes(item.tag_id) }" v-on:click="addOrRemoveTag(item)">{{item.tag_id}}<span class="badge pull-right">{{item.total}}</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <b-pagination align="center" size="md" :total-rows="items" v-model="currentPage" :per-page="per_page">
        </b-pagination>
    </div>

</template>

<script>
    export default {

        mounted() {
        },
        props: {
            datanumbersofposts: {
                type: Array,
            },
            datareplies: {
                type: Object
            },
            datausers: {
                type: Object
            }
        },
        data: function () {
            return {
                items: 0,
                posts: [],
                tags: [],
                inputVal:'',
                currentPage: 1,
                per_page: 15,
                pagination: {
                    total: 0,
                    per_page: 15,    // required
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
        watch: {
            /**
             * When prop currentPage updated
             * react to it
             */
            currentPage(newVal) {
                axios.get('/api/post?page=' + newVal).then((response) => {
                    this.posts = response.data.data;
                    this.pagination = response.data;
                    this.items = response.data.total;
                }, error => {
                    //Error Handling
                });
            }
        },
        created: function () {
            this.fetchPosts();
        },
        methods: {
            fetchPosts() {
                var page = this.currentPage;
                axios.get('/api/post?page=' + page).then((response) => {
                    this.posts = response.data.data;
                    this.pagination = response.data;
                    this.items = response.data.total;
                }, error => {
                    //Error Handling
                });
            },
            search_query(){
                var title = this.inputVal;
                var tags = this.tags.join();
                /*$.each('.tags li a.selected').each(function(){
                    tags.push($(this).val());
                });*/
                var url = '/api/post?page=' + this.currentPage;
                if(title != '') url = url +'&title='+title;
                if(this.tags.length != 0) url = url +'&tags='+tags;
                axios.get(url).then((response) => {
                    this.posts = response.data.data;
                    this.pagination = response.data;
                    this.items = response.data.total;
                }, error => {
                    //Error Handling
                });
            },
            addOrRemoveTag(item){
                if(item.selected){
                    item.selected = false;
                    this.tags.splice(this.tags.indexOf(item.tag_id), 1);
                }else{
                    item.selected = true;
                    this.tags.push(item.tag_id);
                }
            }
        }
    }


    import bPagination from 'bootstrap-vue/es/components/pagination/pagination';

    Vue.component('b-pagination', bPagination);
</script>
<style scoped>
</style>