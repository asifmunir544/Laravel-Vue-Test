<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    // php artisan make:policy QuestionPolicy --model=Question

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Question $question)
    {
        return $user->id == $question->user_id && $question->answers_count < 1; //that is mean if questions has answers cannot be deleted
    }


    /**
     * @return bool
     */
    public function view()
    {
        return auth()->user()->is_admin == 1;
    }

    /**
     * @return bool
     */
    public function comment()
    {
        return auth()->user()->comment_allowed == 1;
    }

}
