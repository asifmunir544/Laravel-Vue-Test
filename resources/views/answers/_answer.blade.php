<answer :answer="{{$answer}}" inline-template>
    <div class="d-flex post">
        <!--Display answer content-->
        <vote :model="{{$answer}}" name="answer"></vote>

        <div class="flex-grow-1 ms-3">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group mb-3">
                    <textarea class="form-control" v-model="body" rows="10" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>
            </form>

            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">

                    <div class="d-flex col-4 align-items-end">
                        @can('update', $answer)
                            <div>
                                <a @click.prevent="edit" class="btn btn-outline-info btn-sm me-2">Edit</a>
                            </div>
                        @endcan
                        @can('delete', $answer)
                                <button @click.prevent="destroy" class="btn btn-outline-danger btn-sm">Delete</button>
                        @endcan
                    </div>

                    <div class="col-4">

                    </div>

                    <div class="col-4">
                        <user-info :model="{{$answer}}" label="Answered"></user-info>
                    </div>

                </div>
            </div>
        </div>
    </div>
</answer>
