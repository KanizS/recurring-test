<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class OrderController extends Controller
{   
public function reorder(Request $request){
file_put_contents("php://stderr", "####################\n");
       //================optimize later using threads and synchronizatioon ====================================
   
	//traverse through note attributes
	$note_attribute_count = (int)count($request['note_attributes']);
	file_put_contents("php://stderr", "before note loop\n");
	for($r=0;$r<$note_attribute_count;$r++){
	file_put_contents("php://stderr", "inside note loop\n");
		file_put_contents("php://stderr", "$r\n");
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
					file_put_contents("php://stderr", "$_recurring_duration_months_name\n");
					$_recurring_duration_months_value = (int)$request['note_attributes'][$r]['value'];
					file_put_contents("php://stderr", "$_recurring_duration_months_value\n");
					break;
				 case 'streamthing_delivery_date':
					$_streamthing_delivery_date_name = $_name;
					$_streamthing_delivery_date_value=date('m/d/Y', strtotime((string)$request['note_attributes'][$r]['value']));
				  	break;
// 				 case 'area': //add later after test
// 					$_area_name = $_name;
// 					$_area_value= (string)$request['note_attributes'][$r]['value'];
// 					break;
				default:
					break;
				}
		}
	//prevent looping request of previous orders
	$order_request_name = $request['name'];
	$order_request_name = (int)str_replace('#', '', $order_request_name);
	if( $order_request_name < 1029){
		$_subscribe_order_name = '';
		$_subscribe_order_value='';
		file_put_contents("php://stderr", "$_subscribe_order_name\n");
		file_put_contents("php://stderr", "$_subscribe_order_value\n");
	}
	
	file_put_contents("php://stderr", "$_subscribe_order_name\n");
	if($_subscribe_order_name=='subscribe_order'){
		if($_subscribe_order_value){
			$_recurring_duration = $_recurring_duration_months_value*4;
			for($i=0;$i<$_recurring_duration;$i++){
				file_put_contents("php://stderr", "$i\n");
				
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
													
// 						//calculate delivery date
// 						$_streamthing_delivery_date_value = date('Y-m-d', strtotime($_streamthing_delivery_date_value . " + 7 day"));
// 						file_put_contents("php://stderr", "$_streamthing_delivery_date_value\n");
// 						file_put_contents("php://stderr", "******\n");
// 						$_streamthing_delivery_date_value = date('F jS, Y', strtotime($_streamthing_delivery_date_value));
// 						file_put_contents("php://stderr", "$_streamthing_delivery_date_value\n");
				
						//calculate cut off date
// 						$_cut_off_date_value = date('F jS, Y', strtotime($_streamthing_delivery_date_value . " - 2 day"))." - 12:00 AM";
// 						file_put_contents("php://stderr", "$_cut_off_date_value\n");
// 						file_put_contents("php://stderr", "========\n");
					
						//root order details
						$root_order_id = $request['id'];
						$root_order_name = $request['name'];
				
						$note_attributes = array(
							'created_as_recurring' => true,
							'root_order_name' => $root_order_name,
							'root_order_id' => $root_order_id,
							'current_recurring_iteration'=> $i+1,
							'recurring_frequency' => $_recurring_duration,
							//$_streamthing_delivery_date_name=>$_streamthing_delivery_date_value,
							//'cut_off_date' =>$_cut_off_date_value, 
							//$_area_name =>$_area_value  //remove after test
							);
						$payment_gateway_names = $request['payment_gateway_names'];
						$contact_email = $request['contact_email'];
						$origin_location = $request['origin_location'];
						$destination_location = $request['destination_location'];
						$shipping_lines = $request['shipping_lines'];
						$billing_address = $request['billing_address'];
						$shipping_address=$request['shipping_address'];
				
						//set order name
						$order_name = $request['name'];
						$order_iteration = $i+1;
						$order_name_suffix = (string)$order_iteration;
						$order_name = $order_name."R".$order_name_suffix;
						file_put_contents("php://stderr", "$order_name\n");
				
				//set order
						$orderdata = array(
							'order' => array(
							'name' => $order_name,
							'email' => $request['email'],
							'line_items' => $line_items,
							//'gateway' => $gateway,  //check with requirements
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
						$logcontent = "$order\n";
						file_put_contents("php://stderr", $logcontent);
					//post  reorder
						$this -> set_reorder($order);
			}//end of for loop
				
		}// end of if
}// end of if
	else{
		file_put_contents("php://stderr", "123\n");
	
	}
	//$request->delete();
	file_put_contents("php://stderr", "456\n");
		
}
	
 private function set_reorder($order){
    //create client and post data
	//$url =(string)('https://accf0d648fe303e54a665730c8510ce3:e10a8dab1c81ca2dfc1e76a3fb0ebc0c@saaraketha-organics.myshopify.com/admin/orders.json');
	$url =(string)('https://087d5b65d796c168b3991f22bb931df5:74048127bf735281c6e3fdd2d2dfb336@test-saarai.myshopify.com/admin/orders.json');
	 $client = new Client();
	$RequestResponse = $client->post($url, ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 'body' => $order]);
 }
	
}
