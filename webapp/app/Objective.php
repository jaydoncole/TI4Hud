<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model {

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    protected $table = 'objectives';
    protected $primaryKey = 'objective_id';

    public $timestamps = false;

    // Relationships
    public function objective() {
        return $this->belongsTo('App\GameObjective', 'objective_id'); 
    }

}
