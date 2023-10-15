export default {
    modify (user, model) {
        return user.id === model.user_id;
    },

    //Determine that the owner of the question can only accept the answer as best answer
    accept (user, answer) {
        return user.id === answer.question.user_id;
    },

    deleteQuestion (user, question) {
        return user.id === question.user_id && question.answers_count < 1;
    }

}
