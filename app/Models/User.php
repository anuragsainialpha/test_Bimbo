<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	//Table name
    protected $table = 'user';
    //primary key
    public $primarykey = 'id';
    //timestamps
    public $timestamps = false;
	
    protected $fillable = [
    	'username', 'password', 'role_id', 'facility_code', 'create_user', 'create_date', 'mod_user', 'mod_date', 'is_admin', 'label_designer_code', 'printer_name'

    ];
	
	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
