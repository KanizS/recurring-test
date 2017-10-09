<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OrderController extends Controller

{   
public $in  = 1;
public function reorder(Request $request){
this->$in++;
file_put_contents("php://stderr", "%in\n");
       //================optimize later using threads and synchronizatioon ====================================

	//traverse through note attributes
	
	
}

 private function set_reorder($order){
    //create client and post data
// 	$url =(string)('https://d69dc791fbc4e0f64edea9ec3ae422ea:3f2099e0135c61c8554819d7d294d125@saarai-test.myshopify.com/admin/orders.json');
// 	$client = new Client();
// 	$RequestResponse = $client->post($url, ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 'body' => $order]);
 }
}



