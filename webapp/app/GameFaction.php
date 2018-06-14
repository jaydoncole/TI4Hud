<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GameFaction extends Model {

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public $timestamps = false;

    protected $table = 'game_factions';
    protected $primaryKey = 'game_faction_id';

    // Relationships
    public function faction()
    {
        return $this->hasOne('App\Faction', 'faction_id');
    }

    public function game()
    {
        return $this->hasOne('App\Game', 'game_id');
    }

}
