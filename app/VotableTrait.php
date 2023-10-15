<?php
namespace App;

use App\Models\User;

trait VotableTrait
{
    public function votes()
    {
        //second arg is singuler form of pivot table name, with that elquent we will recognize that the table name is votables and they will be votable id and votable type
        return $this->morphToMany(User::class, 'votable');
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}
