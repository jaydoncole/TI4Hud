<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GameObjective extends Model {

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public $timestamps = false;

    protected $table = 'game_objectives';
    protected $primaryKey = 'game_objective_id';

    // Relationships
    public function objective()
    {
        return $this->hasOne('App\Objective', 'objective_id');
    }

    public function game()
    {
        return $this->hasOne('App\Game', 'game_id');
    }



}
