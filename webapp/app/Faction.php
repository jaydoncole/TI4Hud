<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model {

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    protected $table = 'factions';
    protected $primaryKey = 'faction_id';

    public $timestamps = false;

    // Relationships

}
