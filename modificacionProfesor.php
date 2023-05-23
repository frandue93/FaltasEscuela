<?php
include("clases/profesor.php");

$msg="";
$disabled="";
function validar($nombre,$clave){
    if(!(empty(trim($nombre)))&&!(empty(trim($clave)))){
        return true;
        
    }else{
        return false;
    }
}

if(isset($_GET['q'])){
    $codigo_P=$_GET["q"];
    $busPro = new Profesor($codigo_P,"","","");
    $buscarPro=$busPro->buscarProfesorBD();
    $nombre=$buscarPro["nombre"];
    $clave=$buscarPro["clave"];
}

if(isset($_POST["modificar"])){
    if(strcmp($_SESSION["admin"],"si")==0){
    $nombre=$_POST["nombre"];
    }
    $clave=$_POST["clave"];
    
    if(validar($nombre,$clave)){
        $profes=new Profesor($codigo_P,$nombre,$clave,"");
        $msg=$profes->modificaProfesorBD();
        header("Location: index.php?p=menuProfesorado");

    }else{
        $msg="Hay algun dato invalido";
    }
}

if(!strcmp($_SESSION["admin"],"si")==0){
$disabled = "disabled";
}

?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >

<table border="1">
    <tr>
        <th>CODIGO</th><th>NOMBRE PROFESOR</th><th>PWD</th>
    </tr>
    <tr>
        <td>
        <input type="text" name="codigo_P" value="<?php echo $codigo_P?>" size="6" disabled>
        </td>
        <td>
        <input type="text" name="nombre" value="<?php echo $nombre?>" size="20" <?php echo $disabled ?>>
        </td>
        <td>
        <input type="text" name="clave" value="<?php echo $clave?>" size="6">
        </td>
    </tr>
    <td colspan="3">
    <input type="submit" name="modificar" value="MODIFICAR PROFESOR" >

    </td>
    </table>
 <p><?php echo $msg ?></p>
</form>