<template>
    <div>
        <div class="row mt-4" v-cloak v-if="count">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{title}}</h2>
                        </div>
                        <hr>

                        <answer @deleted="remove(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id"></answer>

                        <div class="text-center mt-3" v-if="nextUrl">
                            <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more comments</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <new-answer @created="add" :question-id="question.id"></new-answer>
    </div>
</template>

<script>
import Answer from "./Answer";
import NewAnswer from "./NewAnswer";
import highlight from "../mixins/highlight";

export default {
    name: "Answers",
    props: ['question'],
    mixins: [highlight],
    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answersIds: [],
            answers: [],
            nextUrl: null
        }
    },
    //created() called after the instance is created and used to fetch data from backend api
    created () {
        this.fetch(`/questions/${this.questionId}/answers`) //index route //and defining index method in AnswersController
    },
    methods: {
        add(answer) {
          this.answers.push(answer);
          this.count++;
          this.$nextTick(() => {
              this.highlight(`answer-${answer.id}`);
          })
        },
        remove(index){
            this.answers.splice(index, 1);
            this.count--;
        },
        fetch(endpoint) {
            this.answersIds = [];//before make ajax call reset answersIds array to make sure that every time make ajax call we donot have duplicate answer ids
            axios.get(endpoint)
            .then(({data}) => {  //extract or get data property from response object by using ({data})

                this.answersIds = data.data.map(a => a.id); // collect all answers ids by map method and send them to answersIds array

                this.answers.push(...data.data); //to merge data property array with answers array ussing es6 by (...)

                this.nextUrl = data.next_page_url; //
            })
            .then(() => {
                //get back answers from ajax request and loap each one of them and call highlight method for evry single answer using answersIds which hold all answers ids that called back from ajax request
                this.answersIds.forEach(id => {
                    this.highlight(`answer-${id}`);
                });
            })
        },
    },
    computed: {
        title() {
            return this.count + " " + (this.count > 1 ? 'Comments' : 'Comment');
        }
    },
    components: {Answer, NewAnswer}
}
</script>

