<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
	//Table name
    protected $table = 'parameters';
    //primary key
    public $primarykey = 'id';
    //timestamps
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'parameter', 'value', 'create_user', 'mod_user', 'create_date', 'mod_date'
    ];
}
