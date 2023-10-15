<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!--Editing or Deleting question form-->
                <form class="card-body" v-show="authorize('modify', question) && editing" @submit.prevent="update">
                    <div class="card-title ">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>

                    <hr>

                    <div class="d-flex">
                        <div class="flex-grow-1">

                            <div class="form-group mb-3">
                                <m-editor :body="body" :name="uniqueName">
                                    <textarea class="form-control" v-model="body" rows="10" required></textarea>
                                </m-editor>
                            </div>
                            <button type="submit" class="btn btn-primary" :disabled="isInvalid">Update</button>
                            <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>

                        </div>
                    </div>

                </form>

                <!--Display question-->
                <div class="card-body" v-show="!editing">
                    <div class="card-title ">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="">{{title}}</h2>
                            <div class="ms-2">
                                <a href="/questions" class="btn btn-outline-secondary">Back to all Feedbacks</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex">
                        <!--Display feedback content-->
                        <vote :model="question" name="question"></vote>

                        <div class="flex-grow-1 ms-3">

                            <div v-html="bodyHtml" ref="bodyHtml"></div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="d-flex align-items-end">

                                        <div v-if="authorize('modify', question)">
                                            <a @click.prevent="edit" class="btn btn-outline-info btn-sm me-2">Edit</a>
                                        </div>

                                        <button v-if="authorize('deleteQuestion', question)" @click.prevent="destroy" class="btn btn-outline-danger btn-sm">Delete</button>

                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <user-info :model="question" label="Asked"></user-info>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserInfo from "./UserInfo";
import Vote from "./Vote";
import MEditor from "./MEditor";
import highlight from "../mixins/highlight";

export default {
    name: "Question",
    props: ['question'],
    components: {UserInfo, Vote, MEditor},

    mixins: [highlight],

    data() {
        return {
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            editing: false,
            id: this.question.id,
            beforeEditCache: {}
        }
    },

    computed: {
        isInvalid () {
            return this.body.length < 10 || this.title.length < 10;
        },

        endpoint () {
            return `/questions/${this.id}`;
        },

        uniqueName () {
            return `question-${this.id}`;
        }
    },

    methods: {
        edit () {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            };

            this.editing = true
        },

        cancel () {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
            this.editing = false;
        },

        update () {
            //we will use put instead of patch because wil update the title and body of the question
            axios.put(this.endpoint, {
                body: this.body,
                title: this.title
            })
            //server side validation error message in flash message
            .catch(({response}) => {
                this.$toast.error(response.data.message, "Error", {timeout: 3000});
            })
            //when succeed we need to replace the local bodyHtml with bodyHtml that come from ajax response
            .then(({data}) => {
                this.bodyHtml = data.body_html;
                this.$toast.success(data.message, "Success", {timeout: 3000});
                this.editing = false;
            })
            .then(()=> this.highlight()) //from mixins highlight.js
        },

        destroy () {
            this.$toast.question('Are you sure about that?', "Confirm", {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [

                    ['<button><b>YES</b></button>', (instance, toast) => {
                        //our code//
                        axios.delete(this.endpoint)
                            .then(({data}) => {
                                this.$toast.success(data.message, "Success", {timeout:2000});
                            });
                            //redirect to questions page using javascript setTimeout()
                            setTimeout(() => {
                                window.location.href = "/questions";
                            }, 3000);
                        //end our code //
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],

                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
        }
    }
}
</script>
