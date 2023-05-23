<?php
include("clases/grupo.php");

$msg="";

function validar($nombre){
    if(!(empty(trim($nombre)))){
        return true;
        
    }else{
        return false;
    }
}

if(isset($_GET['q'])){
 
    $codigo_G=$_GET["q"];
    $busGru = new Grupo($codigo_G,"");
    $buscarGru=$busGru->buscarGrupoBD();
    $nombre=$buscarGru["nombre"];
    $codigo_G=$buscarGru["codigo_G"];
}

if(isset($_POST["modificar"])){
    
    $nombre=$_POST["nombre"];
    
    if(validar($nombre)){
        $grup=new Grupo($codigo_G,$nombre);
        $msg=$grup->modificaGrupoBD();
        header("Location: index.php?p=menuGrupos");

    }else{
        $msg="Hay algun dato invalido";
    }
}

?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >

<table border="1">
    <tr>
        <th>CODIGO</th><th>NOMBRE GRUPO</th>
    </tr>
    <tr>
        <td>
        <input type="text" name="codigo_G" value="<?php echo $codigo_G?>" size="6" disabled>
        </td>
        <td>
        <input type="text" name="nombre" value="<?php echo $nombre?>" size="20">
        </td>
        
    </tr>
    <td colspan="2">
    <input type="submit" name="modificar" value="MODIFICAR GRUPO" >

    </td>
    </table>
 <p><?php echo $msg ?></p>
</form>