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
	
	//prevent placing recurring orders more than once
	//edit the root order to place tag
	//following process if only tag not in order
	$order_tags = $request['tags'];
	$order_tags_count = (int)count($order_tags);
	file_put_contents("php://stderr", "$order_tags_count\n");
	file_put_contents("php://stderr", "$order_tags\n");
	$verify = $this -> verify_request($request);
	
	//if previously no recurring orders created
	if($verify){
		file_put_contents("php://stderr", "inside verify\n");
		//$this -> edit_root_order($id);

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

		//traverse through note attributes
		for($r=0;$r<$note_attribute_count;$r++){
			$_name = $request['note_attributes'][$r]['name'];

			switch ($_name){
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

		//create recurring orders if note attribute set
		if($_subscribe_order_name=='subscribe_order'){
			file_put_contents("php://stderr", "outer if\n");

			if($_subscribe_order_value){
				$_recurring_duration = $_recurring_duration_months_value*4;

				//loop over for recurring duration
				for($i=0;$i<$_recurring_duration;$i++){

				//edit order json
					//items from previous order
					$line_items = $request['line_items'];
					$gateway = $request['gateway']; //check with requirements
					$total_price= $request['total_price'];					
					$subtotal_price= $request['subtotal_price'];					
					$total_weight= $request['total_weight'];				
					$total_tax= $request['total_tax'];					
					$taxes_included= $request['taxes_included'];				
					$currency= $request['currency'];	
					$total_discounts = $request['total_discounts'];
					$total_line_items_price = $request['total_line_items_price'];
					$total_price_usd = $request['total_price_usd'];	

					//calculate delivery date //add after test
					$_streamthing_delivery_date_value = date('Y-m-d', strtotime($_streamthing_delivery_date_value . " + 7 day"));
					$_streamthing_delivery_date_value = date('F jS, Y', strtotime($_streamthing_delivery_date_value));

					//calculate cut off date //add after test
					$_cut_off_date_value = date('F jS, Y', strtotime($_streamthing_delivery_date_value . " - 2 day"))." - 12:00 AM";

					//root order details
					$root_order_id = $request['id'];
					$root_order_name = $request['name'];

					$note_attributes = array(
						'created_as_recurring' => true,
						'packing_specification'=>$_packing_specification_value,
						'root_order_name' => $root_order_name,
						'root_order_id' => $root_order_id,
						'current_recurring_iteration'=> $i+1,
						'recurring_frequency' => $_recurring_duration,
						$_streamthing_delivery_date_name=>$_streamthing_delivery_date_value, //add after test
						'cut_off_date' =>$_cut_off_date_value, //add after test
						$_area_name =>$_area_value  //add after test
						);

					$contact_email = $request['contact_email'];
					$shipping_lines = $request['shipping_lines'];
					$billing_address = $request['billing_address'];
					$shipping_address=$request['shipping_address'];

					//set order name
					$order_name = $request['name'];
					$order_iteration = $i+1;
					$order_name_suffix = (string)$order_iteration;
					$order_name = $order_name."R".$order_name_suffix;

				//set order
					$orderdata = array(
						'order' => array(
						'name' => $order_name,
						'email' => $request['email'],
						'line_items' => $line_items,
						'total_price'=>$total_price,
						'subtotal_price'=>$subtotal_price,
						'total_weight'=>$total_weight,
						'total_tax'=>$total_tax,
						'taxes_included'=>$taxes_included,
						'currency'=>$currency,
						'financial_status'=> 'pending',
						'total_discounts'=>$total_discounts,
						'total_line_items_price'=>$total_line_items_price,
						'total_price_usd'=>$total_price_usd,
						'tags'=>'created_on_subscription',
						'contact_email'=>$contact_email,
						'shipping_lines'=>$shipping_lines,
						'billing_address'=>$billing_address,
						'shipping_address'=>$shipping_address,
						'note_attributes' => $note_attributes
						));

					$order = json_encode ($orderdata);

				//post  reorder
					$this -> set_reorder($order);

				}//end of for loop

			}// end of if
			else{
				file_put_contents("php://stderr", "inner else\n");
			}//end of else

		}// end of if
		else{
			file_put_contents("php://stderr", "outer else\n");

		}//end of else
		}//end of verify if
	else{
		file_put_contents("php://stderr", "Not Verified\n");
	}//end of verify else

	file_put_contents("php://stderr", "end of code\n");
	

}
	
 private function set_reorder($order){
   //create client and post data
	$url =(string)('https://919dbb1d353c767687732dccb73b3b6c:fba6ef04320dec52cf543b6b266f2b9e@saaraketha-organics.myshopify.com/admin/orders.json');
	$client = new Client();
	//$RequestResponse = $client->post($url, ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 'body' => $order]);
	
}

private function edit_root_order($root_id){
	file_put_contents("php://stderr", "edit_root_order_function\n");
	$edit_orderdata = array('order' => array('id' => $root_id,
					    'tags'=>array("Created_Recurring_Orders")
					   )
			  );
	$order_data = json_encode ($edit_orderdata);
	file_put_contents("php://stderr", "before url\n");
	$edit_url =(string)('https://919dbb1d353c767687732dccb73b3b6c:fba6ef04320dec52cf543b6b266f2b9e@saaraketha-organics.myshopify.com/admin/orders/');
	$edit_url = $edit_url."$root_id".".json";
	$client = new Client();
	file_put_contents("php://stderr", "before url\n");
	$RequestResponse = $client->put($edit_url, ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 'body' => $order_data]);
	file_put_contents("php://stderr", "end of edit_root_order function\n");
}
	
private function verify_request($request_data){
	$type = gettype($request_data['tags']);
	file_put_contents("php://stderr", "$type\n");
	$tag_count = (int)count($request_data['tags']);
	file_put_contents("php://stderr", "$tag_count\n");
	$tags_ = $request_data['tags'];
	file_put_contents("php://stderr", "$tags_\n");
	$tag='';
	
	for($x=0;$x<$tag_count;$x++){
		$tag = 	$request_data['tags'][$x];
		//$json_response = json_decode($RequestResponse,true);
		file_put_contents("php://stderr", "$tag\n");
		if($tag == 'Created_Recurring_Orders')
			return true;
		else
			continue;
	}//end of for loop
		
	return false;
}
	
}
