<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }

include("clases/profesor.php");

$profe= new Profesor("","","","");
if(!($profe->algunProfesorBD())){
   header("Location:index.php?p=altaProfesor");
  

}else{
   header("Location:index.php?p=loginProfesor");
if(!(isset($_SESSION["nombre"]))){
    
    
   
}

}
?>

