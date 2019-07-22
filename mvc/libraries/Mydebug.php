<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mydebug {

      public function debug($logs)
        {

         $file=fopen('./logs.txt','a+');

         if (is_array($logs)) {
             $msg = print_r($logs,1);
         } else {
             $msg = $logs;
         }
         fwrite($file,$msg."\n");
       }
	   
	   public function airports_log($logs) //ERROR - 2018-01-23 07:12:31 --> 404 Page Not Found: admin/Logs/indexx
        {

        // $file=fopen('./debug/airports_log.txt','a+');
		   $file = fopen(APPPATH.'/logs/log-airport.php','a+');

         if (is_array($logs)) {
             $msg = print_r($logs,1);
         } else {
             $msg = $logs;
         }
         fwrite($file,'ERROR - '.date('Y-m-d H:m:s')." --> ".$msg."\n");
       }
	   
	   
	   public function airlines_log($logs)
        {

         //$file=fopen('./debug/airlines_log.txt','a+');
         $file = fopen(APPPATH.'/logs/log-airline.php','a+');
         if (is_array($logs)) {
             $msg = print_r($logs,1);
         } else {
             $msg = $logs;
         }
         fwrite($file,'ERROR - '.date('Y-m-d H:m:s')." --> ".$msg."\n");
       }

	  public function rafeed_log($logs)
        {

       	$file = fopen(APPPATH.'/logs/log-rafeed.txt','a+');
         if (is_array($logs)) {
             $msg = print_r($logs,1);
         } else {
             $msg = $logs;
         }
         fwrite($file,'ERROR - '.date('Y-m-d H:m:s')." --> ".$msg."\n");
       }


}
