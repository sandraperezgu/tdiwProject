<template>
    <div class="container">
        <div class="col-lg-8 col-md-8" id="cont">
            <!-- POST -->
            <div class="post">
                <div class="topwrap">
                    <div class="userinfo pull-left">
                        <div class="avatar">
                            <img src="images/avatar.jpg" alt="">
                            <div class="status green">&nbsp;</div>
                        </div>
                    </div>
                    <div class="posttext pull-left">
                        <h2 v-if="datapost.status == 0">(CLOSED) {{ datapost.title }}</h2>
                        <h2 v-else>{{ datapost.title }}</h2>
                        <p>{{ datapost.description }}</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="postinfobot">

                    <div class="likeblock pull-left">
                        <a @click="vote(1,datapost.id)" href="#" class="up"><i class="glyphicon glyphicon-thumbs-up"></i></a>
                        <span>{{datapost.rate_number}}</span>
                        <a @click="vote(-1,datapost.id)" href="#" class="down"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                    </div>

                    <div class="prev pull-left">
                        <a v-if="datapost.status != 0" id="showFormAnswer" v-on:click="showForm()"><i class="glyphicon glyphicon-share-alt reply"></i></a>
                    </div>

                    <div class="posted pull-left"><i class="glyphicon glyphicon-time"></i> {{datapost.created_at}}</div>

                    <div class="clearfix"></div>
                </div>
            </div><!-- POST -->

            <!-- ANSWER -->
            <div class="post answer" v-for="item in datacomments">
                <div class="topwrap">
                    <div class="userinfo pull-left">
                        <div class="avatar">
                            <img src="images/avatar.jpg" alt="">
                            <div class="status green">&nbsp;</div>
                        </div>
                    </div>
                    <div class="posttext pull-left">

                        <div v-if="datapost.status == 0">
                            <i v-if="item.status == 2" class="glyphicon glyphicon-ok correctAnswer"></i>
                            {{ item.description }}
                        </div>
                        <div v-else>{{ item.description }}</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="postinfobot">

                    <div class="likeblock pull-left">
                        <a @click="vote(1,item.id)" href="#" class="up"><i class="glyphicon glyphicon-thumbs-up"></i></a>
                        <span>{{item.rate_number}}</span>
                        <a @click="vote(-1,item.id)" href="#" class="down"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                    </div>

                    <div class="prev pull-left">
                        <!--<a href="#"><i class="glyphicon glyphicon-share-alt reply"></i></a>-->
                    </div>

                    <div class="posted pull-left"><i class="glyphicon glyphicon-time"></i> {{datapost.created_at}}</div>

                    <div v-if="user == datapost.user_id && datapost.status != 0" class="next pull-right">
                        <div v-on:click="saveAnswer(item)" class="col-xs-2 answerContainer" v-bind:data-answer="item.id"
                             v-bind:data-post="item.post_id">
                            <a href="#"><i class="glyphicon glyphicon-ok"></i></a>
                        </div>


                        <a href="#"><i class="fa fa-flag"></i></a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div><!-- ANSWER -->
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="sidebarblock">
                <h3>Tags</h3>
                <div class="divline"></div>
                <div class="blocktxt">
                    <ul class="tags">
                        <li v-for="item in datanumbersofposts"><a href="#">{{item.tag_id}}<span
                                class="badge pull-right">{{item.total}}</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
        },
        props: {
            datapost: {
                type: Object,
            },
            datacomments: {
                type: Array,
            },
            user: {
                type: Number,
            },
            datanumbersofposts: {
                type: Array,
            }
        },
        methods: {
            saveAnswer(answer) {
                axios.post('/setanswer', {
                    answer: answer.id, post: answer.post_id
                }).then(response => {
                    location.reload();
                }, response => {
                    alert('Error');
                });
            },
            showForm() {
                window.$('#form_test').appendTo('#cont');
                window.$('#form_test').show();
            },
            vote(vote,post_id){
                var url = '/vote_post?post_id=' + post_id + "&vote="+vote;
                axios.get(url).then((response) => {
                    location.reload();
                }, error => {
                    //Error Handling
                });
            },
        },
    }
</script>

<style scoped>

</style>