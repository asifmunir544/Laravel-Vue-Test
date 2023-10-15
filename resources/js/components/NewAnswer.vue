<template>
    <!--Display Create Answer Form For the questions-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Your Comment</h2>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <m-editor :body="body" name="new-answer">
                                <textarea class="form-control" name="body" required v-model="body"  cols="30" rows="7"></textarea>
                            </m-editor>
                        </div>
                        <div class="form-gruop mt-3">
                            <button type="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MEditor from "./MEditor";

export default {
    name: "NewAnswer",
    props: ['questionId'],
    components: {MEditor},

    methods: {
        create () {
            axios.post(`/questions/${this.questionId}/answers`, {
                body: this.body
            })
            .catch(error => {
                this.$toast.error(error.response.data.message, "Error");
            })
            .then(({data}) => {
                this.$toast.success(data.message, "Success");
                this.body = '';
                this.$emit('created', data.answer);
            })
        }
    },

    data() {
        return {
            body: ''
        }
    },

    computed: {
        isInvalid() {
            return ! this.signedIn || this.body.length < 10;
        }
    }
}
</script>
