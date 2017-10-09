<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class OrderController extends Controller
{   
public function reorder(Request $request){

file_put_contents("php://stderr", "inside\n");
	
}
 
}




