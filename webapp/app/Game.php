<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {

//    protected $fillable = [];
//
//    protected $dates = [];
//
//    public static $rules = [
//        // Validation rules
//    ];


    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'last_played';

    protected $table = 'games';
    protected $primaryKey = 'game_id';


    // Relationships
    public function factions()
    {
        return $this->hasMany('App\GameFaction', 'game_id');
    }

    public function objectives()
    {
        return $this->hasMany('App\GameObjective', 'game_id');
    }


    public function scoredObjectives()
    {
        return $this->hasMany('App\ScoredObjective', 'game_id');
    }

}
