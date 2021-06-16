<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IpController extends Controller
{
    public function testIp(Request $request){
       $result = shell_exec("sh /var/www/html/app/Http/Controllers/testip.sh ". $request->ip . " " . $request->username . " " . $request->password . " " . $request->to . " " . $request->from . " " .$request->subject . " " . $request->bodyContent );
       return $result;
    } 
    public function configIp(Request $request){
       $result = shell_exec("sh /var/www/html/app/Http/Controllers/configip.sh ". $request->ip . " " . $request->username . " " . $request->password);
       return $result;
    }

    public function configHetznerServer(Request $request){
       echo $request->ip;
       $content = file_get_contents("/var/www/html/app/Http/Controllers/confighetznerserver.sh");
       $result = shell_exec("ssh root@135.181.41.187");
       return $result;

    }
    public function testHetznerServer(Request $request){
          $result =shell_exec("sudo ./var/www/html/app/Http/Controllers/testhetznerip.sh ". $request->ip . " " . $request->username . " " . $request->to . " " . $request->from . " " .$request->subject);
       return $result;
    }
   function callAPI($method, $url, $data , $apiKey){
         $curl = curl_init();
         switch ($method){
             case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer $apiKey',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
} 

}
