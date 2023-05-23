<?php 
function validarDni($dni){
    if(empty($dni)){
        return true;
    }
	
    $str = trim($dni);  
   $str = str_replace("-","",$str);  
   $str = str_ireplace(" ","",$str);  
   $n = substr($str,0,strlen($str)-1);  
   $n = intval($n);  
   if (!is_int($n))  
   {  
      return 0;  
   }  
   $l = substr($str,-1);  
   if (!is_string($l))  
   {  
      return 0;  
   }  
   $letra = substr ("TRWAGMYFPDXBNJZSQVHLCKE", $n%23, 1);  
   if ( strtolower($l) == strtolower($letra))  
   {  
      return $n.$l;  
   }  
   else  
   {  
      return 0;  
   }  
}
?>