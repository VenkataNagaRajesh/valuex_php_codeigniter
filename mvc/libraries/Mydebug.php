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

}
