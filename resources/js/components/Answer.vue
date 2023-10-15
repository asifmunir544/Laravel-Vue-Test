<template>
    <div class="d-flex post">
        <!--Display answer content-->
        <vote :model="answer" name="answer"></vote>

        <div class="flex-grow-1 ms-3">
            <!--Editing or Deleting answer form-->
            <form v-show="authorize('modify', answer) && editing" @submit.prevent="update">
                <div class="form-group mb-3">
                    <m-editor :body="body" :name="uniqueName">
                        <textarea class="form-control" v-model="body" rows="10" required></textarea>
                    </m-editor>
                </div>
                <button type="submit" class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>
            </form>

            <!--Display answer-->
            <div v-show="!editing">
                <div :id="uniqueName" v-html="bodyHtml" ref="bodyHtml"></div>
                <div class="row">

                    <div class="d-flex col-4 align-items-end">

                        <div v-if="authorize('modify', answer)">
                            <a @click.prevent="edit" class="btn btn-outline-info btn-sm me-2">Edit</a>
                        </div>

                        <button v-if="authorize('modify', answer)" @click.prevent="destroy" class="btn btn-outline-danger btn-sm">Delete</button>

                    </div>

                    <div class="col-4">

                    </div>

                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
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
    name: "Answer",
    props: ['answer'],
    components: {UserInfo, Vote, MEditor},
    mixins: [highlight],
    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null
        }
    },
    methods: {
        edit() {
            this.beforeEditCache = this.body;
            this.editing = true
        },
        cancel() {
          this.body = this.beforeEditCache;
          this.editing = false;
        },
        update() {
            axios.patch(this.endpoint, {
                body: this.body,
            })
            .then(response => {
                console.log(response);
                this.editing = false;
                this.bodyHtml = response.data.body_html;
                this.$toast.success(response.data.message, "Success", {timeout: 3000});
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, "Error", {timeout: 3000});
            })
            .then(()=> this.highlight()) //from mixins highlight.js
        },
        destroy() {
            this.$toast.question('Are you sure about that?',"Confirm",{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>',  (instance, toast) => {

                        axios.delete(this.endpoint)
                            .then(response => {
                                // $(this.$el).remove();
                                this.$emit('deleted');
                                this.$toast.success(response.data.message, "Success", {timeout:2000});
                            });

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
            });
        }
    },
    computed: {
        isInvalid () {
            return this.body.length < 10
        },

        endpoint () {
            return `/questions/${this.questionId}/answers/${this.id}`;
        },
        uniqueName () {
            return `answer-${this.id}`;
        }
    }
}
</script>

<style scoped>

</style>
