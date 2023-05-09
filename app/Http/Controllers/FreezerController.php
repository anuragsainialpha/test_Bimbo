<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

class FreezerController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$ShippingLocation = DB::Select("SELECT location_name, location_barcode FROM freezerlocations WHERE location_type = '1'");
		$StorageLocation = DB::Select("SELECT location_name, location_barcode FROM freezerlocations WHERE location_type = '2'");
		
        return view('freezerlpn', array('ShippingLocation' => $ShippingLocation, 'StorageLocation' => $StorageLocation));
    }
	
	public function Process(Request $request)
	{
		//return $request->All();
		
		//Get LPNs
		$url = env('API_BASE_URL').'wms/lgfapi/v10/entity/iblpn?curr_location_id__barcode='.$request->ShippingLocation.'&fields=container_nbr';
		
		$username = env('API_USER');
		$password = env('API_PASS');
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = [
			'Content-Type: application/x-www-form-urlencoded',
			'Authorization: Basic ' . base64_encode("$username:$password"),
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		
		/*echo "<br />Response<br />";
		echo "<pre>";
		echo print_r(json_decode($server_output));
		echo "</pre>";*/
		
		$response = json_decode($server_output,true);
		//print_r($response);
		
		$mainXML="
					<LgfData>
					<Header>
					<DocumentVersion>19C</DocumentVersion>
					<OriginSystem>Host</OriginSystem>
					<ClientEnvCode>QA</ClientEnvCode>
					<ParentCompanyCode>QATSTPC</ParentCompanyCode>
					<Entity>lpn_locate</Entity>
					<TimeStamp>2018-04-02T12:12:12</TimeStamp>
					<MessageId>LpnLocate</MessageId>
					</Header>
					<ListOfLpnLocates>";
		
		$listOfLocate = "";
		if(!isset($response['results']))
		{
			Session::flash('flash_message', 'No LPN found');
			$ShippingLocation = DB::Select("SELECT location_name, location_barcode FROM freezerlocations WHERE location_type = '1'");
			$StorageLocation = DB::Select("SELECT location_name, location_barcode FROM freezerlocations WHERE location_type = '2'");
		
       	 	return view('freezerlpn', array('ShippingLocation' => $ShippingLocation, 'StorageLocation' => $StorageLocation));
		}
		foreach($response['results'] as $data)
		{
			$listOfLocate = $listOfLocate."
					<lpn_locate>
						<company_code>USBBU</company_code>
						<facility_code>UDE</facility_code>
						<lpn_nbr>".$data['container_nbr']."</lpn_nbr>
						<location_barcode>".$request->StorageLocation."</location_barcode>
					</lpn_locate>
					";
		}
		
		$mainXML = $mainXML . $listOfLocate . "</ListOfLpnLocates></LgfData>
		";
		/*echo "<br />XML<br />";
		echo "<pre>";
		echo htmlentities($mainXML);
		echo "</pre>";*/
		if($listOfLocate != "")
		{
			$url = env('API_BASE_URL').'wms/api/init_stage_interface/';
			$username = env('API_USER');
			$password = env('API_PASS');
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(array("async" => "false", "xml_data" => $mainXML)));  //Post Fields
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$headers = [
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic ' . base64_encode("$username:$password"),
			];
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			//$xmlResponse = new \SimpleXMLElement($server_output);

			/*echo "<br />Response<br />";
			echo "<pre>";
			echo htmlentities($server_output);
			echo "</pre>";*/
		}
		
		Session::flash('flash_message', 'LPNs shipped to freezer location');
		$ShippingLocation = DB::Select("SELECT location_name, location_barcode FROM freezerlocations WHERE location_type = '1'");
		$StorageLocation = DB::Select("SELECT location_name, location_barcode FROM freezerlocations WHERE location_type = '2'");
	
		return view('freezerlpn', array('ShippingLocation' => $ShippingLocation, 'StorageLocation' => $StorageLocation));
	}
}