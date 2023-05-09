<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpnReceipt extends Model
{
	//Table name
    protected $table = 'm_receipt_lpn';
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
        'id', 'printed', 'receipt_id', 'lpn_nbr', 'item_code', 'batch_nbr', 'expire_date', 'current_qty', 'original_qty', 'printed_by', 'create_user', 'mod_user', 'create_date', 'mod_date'
    ];
	
	public function Receipt()
	{
		return $this->belongsTo('App\Models\Receipt' , 'receipt_id');
	}
	
	public function OwmItem()
	{
		return $this->belongsTo('App\Models\OwmItem' , 'item_code', 'part_a');
	}
}
