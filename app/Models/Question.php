<?php

namespace App\Models;

use App\VotableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $table = 'feedbacks';

    use VotableTrait;

    use HasFactory;

    protected $guarded = [];

    protected $appends = ['created_date', 'favorites_count', 'is_favorited', 'body_html'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if($this->answers_count > 0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC')->with('question');
    }

    /**
     * method used to invoke the on click function in AcceptAnswerController
     */
    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    //method check whether the current question is favorited by the auth user [return true or false]
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    //Accesore used to check whether the current question is favorited by the auth user
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    //Accesores used to count the number of favorites
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    private function bodyHtml()
    {
        return \Illuminate\Support\Str::markdown($this->body);
    }

    public function excerpt($length)
    {
        return \Illuminate\Support\Str::limit(strip_tags(clean($this->bodyHtml())), $length);
    }
}
