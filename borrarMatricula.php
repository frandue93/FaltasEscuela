<?php 
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
include_once("clases/asignatura.php");
include_once("clases/matricula.php");
$msg="";


if(isset($_POST["si"])){

    $expediente =  $_GET["exped"];
    $codigo_A =$_GET["codA"];
    $convocatoria =$_GET["convo"];
    $elMat = new Matricula($codigo_A,"",$convocatoria,$expediente,"");

    $elMat->eliminarMatriculaBD()
      
}



?>
<h2>¿Quieres eliminar la matricula?</h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>

