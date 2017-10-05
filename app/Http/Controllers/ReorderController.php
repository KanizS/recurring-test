<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ReorderController extends Controller

{     

// 	public function reorder(Request $request){

// // 		  	$order = [
// // 							    "email" => "kanishkas@99x.lk",
// // 							    "fulfillment_status" => "unfulfilled",
// // 							    "line_items" => [
// // 							      [
// // 							          "variant_id" => 42837938757,
// // 							          "quantity" => 5
// // 							      ]
// // 							    ]
// // 							];

// // 		 		$url 		=  'https://3d7b2f6a83f57bc4d0abb14205942ef5:b04081ebe8a2849ed05f0decc4606e1e@saaraketha-organics.myshopify.com/admin/orders.json';
// // 		file_put_contents("php://stderr", "#######".PHP_EOL); 		
// // 		$client 	= new Client();

// // 		 		file_put_contents("php://stderr", "123223".PHP_EOL);

// // 		 		$res = $client->post($url, [
// //    					  'json' => 	$order
// // 						]);

	
// 		 		$url 		=  'https://3d7b2f6a83f57bc4d0abb14205942ef5:b04081ebe8a2849ed05f0decc4606e1e@saaraketha-organics.myshopify.com/admin/orders/83333414942/close.json';
// 		$client 	= new Client();
// 	    $res 		= $client->request('POST', $url);
	
// 		 		file_put_contents("php://stderr", "sending push !!!".PHP_EOL);
	
// 		  	$order = [
// 							    "email" => "kanishkas@99x.lk",
// 							    "fulfillment_status" => "unfulfilled",
// 							    "line_items" => [
// 							      [
// 							          "variant_id" => 42837938757,
// 							          "quantity" => 5
// 							      ]
// 							    ]
// 							];
// 	file_put_contents("php://stderr", json_decode($order).PHP_EOL);
	
//   file_put_contents("php://stderr","asasa".PHP_EOL);
	
// 	$client = new Client([
//     'headers' => [ 'Content-Type' => 'application/json' ]
// ]);

// $response = $client->post('https://3d7b2f6a83f57bc4d0abb14205942ef5:b04081ebe8a2849ed05f0decc4606e1e@saaraketha-organics.myshopify.com/admin/orders.json',
//     ['body' => json_encode(
//         [
//             'order' => [
// 							    "email" => "kanishkas@99x.lk",
// 							    "fulfillment_status" => "unfulfilled",
// 							    "line_items" => [
// 							      [
// 							          "variant_id" => 42837938757,
// 							          "quantity" => 5
// 							      ]
// 							    ]
// 							]
//         ]
//     )]
// );
	
// 	echo '<pre>' . var_export($response->getStatusCode(), true) . '</pre>';
// echo '<pre>' . var_export($response->getBody()->getContents(), true) . '</pre>';
	echo('abc');
// 	$client = new Client(); 
// $result = $client->post('https://3d7b2f6a83f57bc4d0abb14205942ef5:b04081ebe8a2849ed05f0decc4606e1e@saaraketha-organics.myshopify.com/admin/orders.json', [
//             'order' => [
//                 'email' => 'kanishkas@99x.lk',
// 		    'fulfillment_status' => 'unfulfilled',
//                 'line_items' =>  
//                              array("variant_id" => 42837938757,
//                                     "quantity" => 5)
//                     ]
//                 ]);

// echo($result->getBody()->getContents());
	
	}
}
