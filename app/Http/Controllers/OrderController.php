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
	
	//get inside order element of json
	$request = $json_response['order'];
		
	//get note attributes count
	$note_attribute_count = (int)count($request['note_attributes']);
		
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
	for($r=0;$r<$note_attribute_count;$r++){
		$_name = $request['note_attributes'][$r]['name'];
		
		switch ($_name){
				 case 'include_gift_wrapping':
					$_include_gift_wrapping_name = $_name;
					$_include_gift_wrapping_value = (string)$request['note_attributes'][$r]['value'];
					break;
				 case 'subscribe_order':
					$_subscribe_order_name = $_name;
					$_subscribe_order_value =  (string)$request['note_attributes'][$r]['value'];
					break;
				 case 'recurring_duration_months':
					$_recurring_duration_months_name=$_name;
					$_recurring_duration_months_value = (int)$request['note_attributes'][$r]['value'];
					break;
				 case 'streamthing_delivery_date':
					$_streamthing_delivery_date_name = $_name;
					$_streamthing_delivery_date_value=date('m/d/Y', strtotime((string)$request['note_attributes'][$r]['value']));
				  	break;
				 case 'packing_specification':
					$_packing_specification_name = $_name;
					$_packing_specification_value= (string)$request['note_attributes'][$r]['value'];
				  	break;
				 case 'area': //add later after test
					$_area_name = $_name;
					$_area_value= (string)$request['note_attributes'][$r]['value'];
					break;
				default:
					break;
				}
	}//end of for loop
	file_put_contents("php://stderr", "$_subscribe_order_name\n");
	
	file_put_contents("php://stderr", "done\n");	
	
}
	
 private function set_reorder($order){
  
	
}
}
