<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OrderController extends Controller
{   
	
public function reorder($id){
	
	file_put_contents("php://stderr", "$id\n");
	
//get order by id
	$url =(string)('https://919dbb1d353c767687732dccb73b3b6c:fba6ef04320dec52cf543b6b266f2b9e@saaraketha-organics.myshopify.com/admin/orders/');
	$url = $url."$id".".json";
	$client = new Client();
	$RequestResponse = $client->get($url);
	$RequestResponse=$RequestResponse->getBody()->getContents();
	$json_response = json_decode($RequestResponse,true);
		
	//get note attributes count
	$note_attribute_count = (int)count($json_response['order']['note_attributes']);
	
	//get inside order element of json
	$request = $json_response['order'];
	$note = (int)count($request['note_attributes']);
	file_put_contents("php://stderr", "$note\n");	
	
	//initialize note atributes
	$_subscribe_order_name ='';
	$_include_gift_wrapping_name='';
	$_include_gift_wrapping_value='';
	$_subscribe_order_value='';
	$_recurring_duration_months_name='';
	$_recurring_duration_months_value=0;
	$_streamthing_delivery_date_name='';
	$_streamthing_delivery_date_value='';
	$_area_name='';
	$_area_value='';
	$_packing_specification_name='';
	$_packing_specification_value='';
	$_tag_name='';
	
	//prevent placing recurring orders more than once
	//edit the root order to place tag
	//following process if only tag not in order
	
	//traverse through note attributes
	
	file_put_contents("php://stderr", "done\n");	
	
}
	
 private function set_reorder($order){
  
	
}
}
