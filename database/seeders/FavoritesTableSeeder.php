<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('favorites')->delete(); //run seed individualy php artisan db:seed --class=FavoritesTableSeeder

        $users = User::pluck('id')->all();

        $numberOfUsers = count($users);

        foreach (Question::all() as $question)
        {
            //randomly attach every single question to be favorited to at least one user [so the rand() in the following loap should start by 1]
            for($i = 0; $i < rand(1, $numberOfUsers); $i++)
            {
                //get the random user
                $user = $users[$i];
                //attach the current question to the random user
                $question->favorites()->attach($user);
            }
        }
    }
}
