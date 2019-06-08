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
	   
	   public function airports_log($logs)
        {

         $file=fopen('./debug/airports_log.txt','a+');

         if (is_array($logs)) {
             $msg = print_r($logs,1);
         } else {
             $msg = $logs;
         }
         fwrite($file,$msg.' Timestamp: '.time()."\n");
       }
	   
	   
	   public function airlines_log($logs)
        {

         $file=fopen('./debug/airlines_log.txt','a+');

         if (is_array($logs)) {
             $msg = print_r($logs,1);
         } else {
             $msg = $logs;
         }
         fwrite($file,$msg.' Timestamp: '.time()."\n");
       }

}
