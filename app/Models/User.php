<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'comment_allowed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['url', 'avatar'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        //return route('questions.show', $this->id);
        return '#';
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * get the user email image using gravatar
     */
    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }


    /**
     * polymorphed relationship [equal to many to many relationship but we use one table for all models used in this relation]
     * we will use two relation because the user will have relation with question and relation with answer
     * user can vote many answer, user can vote many question
     * answer can voted by many users, question can voted by many users
     */
    public function voteQuestions()
    {
        //second arg is singuler form of pivot table name, with that elquent we will recognize that the table name is votables and they will be votable id and votable type columns
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers()
    {
        //second arg is singuler form of pivot table name, with that elquent we will recognize that the table name is votables and they will be votable id and votable type columns
        return $this->morphedByMany(Answer::class, 'votable');
    }

    //method to get the votes of this user on the question
    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        return $this->_vote($voteQuestions, $question, $vote);
    }

    //method to get the votes of this user on the answer
    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswer = $this->voteAnswers();
        return $this->_vote($voteAnswer, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote)
    {
        //check if this user vote on the model before and if this vote exists
        if($relationship->where('votable_id', $model->id)->exists())
        {
            //update the existing vote
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            //if not exists attach the vote on the model
            $relationship->attach($model, ['vote' => $vote]);
        }
        //refresh the model with the new votes by votes relation in answer model
        $model->load('votes');

        //count votes up and down
        $downVotes = (int) $model->downVotes()->sum('vote'); //downVotes() is method in answer model
        $upVotes = (int) $model->upVotes()->sum('vote'); //upVotes() is method in answer model
        $model->votes_count = $upVotes + $downVotes;
        $model->save();
        return $model->votes_count;
    }
}
