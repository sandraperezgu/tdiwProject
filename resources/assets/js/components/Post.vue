<template>
    <div class="container">
        <div class="col-xs-12">
            <h1 v-if="datapost.status == 0">(CLOSED) {{ datapost.title }}</h1>
            <h1 v-else>{{ datapost.title }}</h1>
                <div class="row question-box">
                    <hr class="separator" />
                    <div class="col-xs-12">
                        <div class="col-xs-1 voteContainer">
                            <span id="voteUp" class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
                            <span id="reputation" class="reputation_score" aria-hidden="true">{{datapost.rate_number}}</span>
                            <span id="voteDown" class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
                        </div>
                        <div class="col-xs-11">
                            <span>{{ datapost.description }}</span>
                        </div>
                    </div>
                </div>
        </div>
        <h2 v-if="datacomments.length == 0" class="margin20top">No answers yet!</h2>
        <h2 v-else class="margin20top">{{ datacomments.length}} Answers:</h2>
        <hr class="separator" />
        <div class="row question-box" v-for="item in datacomments">
            <div v-if="datapost.status == 0" class="col-xs-12">
                <div v-if="item.status == 2" class="col-xs-2 correctOne">
                   Correct Answer!
                </div>
                <div v-else class="col-xs-2">
                </div>
                <div class="margin20bottom col-xs-10">
                    <span>{{ item.description }}</span>
                </div>
            </div>
            <div v-else-if="user == datapost.user_id" class="col-xs-12">
                <div v-on:click="saveAnswer(item)" class="col-xs-2 answerContainer" v-bind:data-answer="item.id" v-bind:data-post="item.post_id">
                    Select as Correct Answer
                </div>
                <div class="margin20bottom col-xs-10">
                    <span>{{ item.description }}</span>
                </div>
            </div>
            <div v-else class="col-xs-12">
                <div class="col-xs-2">
                </div>
                <div class="margin20bottom col-xs-10">
                    <span>{{ item.description }}</span>
                </div>
            </div>
        </div>
        <span v-if="datapost.status != 0" id="showFormAnswer" v-on:click="showForm()"> Do you want to answer? Click here</span>
        <span v-else>You can't answer closed posts.</span>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('posts, posts nowhere');
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
            }
        },
        methods: {
            saveAnswer(answer){
                axios.post('/setanswer', {
                    answer: answer.id, post:answer.post_id
                }).then(response => {
                    location.reload();
                }, response => {
                    alert('Error');
                });
            },
            showForm(){
                window.$('#form_test').show();
            }
        },
    }
    console.log('posts, posts nowhere');

</script>

<style scoped>

</style>