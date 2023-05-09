<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
	//Table name
    protected $table = 'm_receipt';
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
        'id','facility_code','create_date','create_user','mod_date','mod_user','wms_asn_nbr','item_code','std_pallet_qty','batch_nbr','shipped_qty','received_qty','status', 'in_wms', 'is_upload_batch'
    ];
	
	public function LpnReceipt()
	{
		return $this->hasMany('App\Models\LpnReceipt' , 'receipt_id');
	}
}
