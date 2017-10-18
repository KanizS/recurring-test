<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OrderController extends Controller
{   
	
public function reorder(Request $request){
	
file_put_contents("php://stderr", "inside\n");
	$val = $request['id'];
      file_put_contents("php://stderr", "$val\n");

	$url =(string)('https://919dbb1d353c767687732dccb73b3b6c:fba6ef04320dec52cf543b6b266f2b9e@saaraketha-organics.myshopify.com/admin/orders/116273315870.json');
	$client = new Client();
	$RequestResponse = $client->get($url);
	$x=$RequestResponse['order']['value'];
	file_put_contents("php://stderr", "$x\n");
	file_put_contents("php://stderr", "done\n");	
}
	
 private function set_reorder($order){
  
	
}
}
