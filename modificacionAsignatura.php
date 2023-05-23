<?php
include("clases/asignatura.php");
$msg="";
function validar($nombre,$duracion_semanal){
    if(!(empty(trim($nombre)))&&!(empty(trim($duracion_semanal)))){
        if(!(is_numeric($duracion_semanal))||$duracion_semanal>999||$duracion_semanal<0){
            return false;
        }else{
            return true;
        }
        
    }else{
        return false;
    }
}

if(isset($_GET['q'])){
    $codigo_A=$_GET["q"];
    $busAs = new Asignatura($codigo_A,"","");
    $buscarAsi=$busAs->buscarAsignaturaBD();
    $nombre=$buscarAsi["nombre"];
    $duracion_semanal=$buscarAsi["duracion_semanal"];
}




if(isset($_POST["modificar"])){
    $nombre=$_POST["nombre"];
    $duracion_semanal=$_POST["duracion_semanal"];
    
    if(validar($nombre,$duracion_semanal)){
        $asig=new Asignatura($codigo_A,$nombre,$duracion_semanal);
        $msg=$asig->modificaAsignaturaBD();
        header("Location: index.php?p=menuAsignaturas");

    }else{
        $msg="Hay algun dato invalido";
    }
}?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >

<table border="1">
    <tr>
        <th>CODIGO</th><th>NOMBRE</th><th>MINUT/SEM</th><th>BORRAR</th><th>MODIF.</th>
    </tr>
   <?php 
   
   
   
   
   ?>
    <tr>
        <td>
        <input type="text" name="codigo_A" value="<?php echo $codigo_A?>" size="6" disabled>
        </td>
        <td>
        <input type="text" name="nombre" value="<?php echo $nombre?>" size="20">
        </td>
        <td>
        <input type="text" name="duracion_semanal" value="<?php echo $duracion_semanal?>" size="6">
        </td>
        <td colspan="2">
        <input type="submit" name="modificar" value="MODIFICAR ASIGNATURA" >
        </td>
    </tr>
</table>
 <p><?php echo $msg ?></p>
</form>



