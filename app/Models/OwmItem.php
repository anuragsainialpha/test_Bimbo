<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwmItem extends Model
{
	//Table name
    protected $table = 'owmitems';
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
        'id', 'company_code', 'item_alternate_code', 'part_a', 'part_b', 'part_c', 'part_d', 'part_e', 'part_f', 'pre_pack_code', 'action_code', 'description', 'barcode', 'cases_per_pallet', 'unit_cost', 'unit_length', 'unit_width', 'unit_height', 'unit_weight', 'unit_volume', 'hazmat', 'recv_type', 'ob_lpn_type', 'catch_weight_method', 'order_consolidation_attr', 'season_code', 'brand_code', 'cust_attr_1', 'cust_attr_2', 'retail_price', 'net_cost', 'currency_code', 'std_pack_qty', 'std_pack_length', 'std_pack_width', 'std_pack_height', 'std_pack_weight', 'std_pack_volume', 'std_case_qty', 'max_case_qty', 'std_case_length', 'std_case_width', 'std_case_height', 'std_case_weight', 'std_case_volume', 'dimension1', 'dimension2', 'dimension3', 'hierarchy1_code', 'hierarchy1_description', 'hierarchy2_code', 'hierarchy2_description', 'hierarchy3_code', 'hierarchy3_description', 'hierarchy4_code', 'hierarchy4_description', 'hierarchy5_code', 'hierarchy5_description', 'group_code', 'group_description', 'external_style', 'vas_group_code', 'short_descr', 'putaway_type', 'conveyable', 'stackability_code', 'sortable', 'min_dispatch_uom', 'product_life', 'percent_acceptable_product_life', 'lpns_per_tier', 'tiers_per_pallet', 'velocity_code', 'req_batch_nbr_flg', 'serial_nbr_tracking', 'regularity_code', 'harmonized_tariff_code', 'harmonized_tariff_description', 'full_oblpn_type', 'case_oblpn_type', 'pack_oblpn_type', 'description_2', 'description_3', 'invn_attr_a_tracking', 'invn_attr_a_dflt_value', 'invn_attr_b_tracking', 'invn_attr_b_dflt_value', 'invn_attr_c_tracking', 'invn_attr_c_dflt_value', 'NMFC_code', 'conversion_factor', 'invn_attr_d_tracking', 'invn_attr_e_tracking', 'invn_attr_f_tracking', 'invn_attr_g_tracking', 'host_aware_item_flg', 'packing_tolerance_percent', 'un_number', 'un_class', 'un_description', 'packing_group', 'proper_shipping_name', 'excepted_qty_instr', 'limited_qty_flg', 'fulldg_flg', 'hazard_statement', 'shipping_temperature_instr', 'carrier_commodity_description', 'shipping_conversion_factor', 'shipping_uom', 'hazmat_packaging_description', 'handle_decimal_qty_flg', 'dummy_sku_flg', 'pack_with_wave_flg'
    ];
}
