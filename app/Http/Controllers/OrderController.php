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
	
	$RequestResponse= json_decode($RequestResponse->getBody(), true);
	file_put_contents("php://stderr", "$RequestResponse\n");
	file_put_contents("php://stderr", "done\n");	
	
//get order elements
	$note_attribute_count = (int)count($RequestResponse['note_attributes']);
	file_put_contents("php://stderr", "$note_attribute_count\n");	
}
	
 private function set_reorder($order){
  
	
}
}
