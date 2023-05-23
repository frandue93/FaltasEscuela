<?php
include_once("clases/faltas.php");
$msg="";

 $codigo_F = $_GET["coFalt"];
    $codigo_A = $_GET["coAsi"];
    
    $codigo_P = $_GET["coPro"];
    

if(isset($_POST["si"])){
    $elFal = new Falta($codigo_F,$codigo_A,$expediente,"","",$codigo_P);
    $elFal->eliminarFaltaBD();
   
}

?>

<h2>¿Quieres eliminar la falta del alumno <?php echo $nombreAlumno ?>?</h2>
<form method="POST" action="index.php?p=menuFaltas&q=<?php echo $expediente?>&k=<?php echo $nombreAlumno?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>

