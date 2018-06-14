<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoredObjective extends Model {

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo('App\Game', 'game_id');
    }
}
