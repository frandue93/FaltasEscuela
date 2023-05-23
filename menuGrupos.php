<?php
include("clases/grupo.php");
$inicio=0;
$cuantos=7;
$msg="";

if(isset($_GET['q']))
$inicio=$_GET['q'];


$msg="";

if(isset($_GET["codG"])){
    $codigo_G =  $_GET["codG"];
}

if(isset($_POST["sim"])){
    
    $elGru = new Grupo($codigo_G,"");
    if($elGru->eliminarAlumnosEnGrupoBD()){
        $elGru->eliminarGrupoBD();
    }
}


if(isset($_POST["si"])){

    
   
    $elGru = new Grupo($codigo_G,"");

    if($elGru->grupoConAlumnoBD()){
        $msg= "¡ ATENCION ! El grupo contiene alumnos, ¿quieres borrar tambien los alumnos?";
        
    }else{

    $elGru->eliminarGrupoBD();
    
        
}

}


    if($msg!=""){
        ?>
        <h2><?php echo $msg?></h2>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
        <input type="submit" name="sim" value="si">
        <input type="submit" name="no" value="no">
        </form>
        
        <?php }else{ 
            if(!isset($_POST["sim"])&&isset($_GET["borr"])){

?>
<h2>¿Quieres eliminar el grupo?</h2>
<form method="POST" action="index.php?p=menuGrupos&codG=<?php echo $codigo_G?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>
<?php } }




$totGr= new Grupo("","","");

$todosGrupos = $totGr->todosGruposSinLimiteBD();

if($totalFilas = $totGr->totalGruposBD()){
   
}else{
    $totalFilas=0;
}

if(isset($_POST["enviar"])){
    $codigo_Grupo=$_POST["grupofpdf"];
    header("Location:listaGrupoFPDF.php?k=$codigo_Grupo");
}

if($totGr->todosGruposBD($inicio,$cuantos)){
    $totGrup=$totGr->todosGruposBD($inicio,$cuantos);
}


if(isset($_POST["añadir"])){
    $nombre=$_POST["nombre"];
   
    if(isset($nombre)){
        $grup=new Grupo("",$nombre);
        $msg=$grup->guardaGrupoBD();
        header("Location:index.php?p=menuGrupos");
    }else{
        $msg="Nombre vacio";
    }
}

include_once("lib/paginar.php");
?>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >

<label>Filtar alumnos por grupo: </label>
<select name="grupofpdf">
    <option value=""></option>
<?php

foreach($todosGrupos as $valGru){
    echo "<option value='".$valGru["codigo_G"]."'>".$valGru["nombre"]."</option>";
}
?>
</select>
<input type="submit" name="enviar" value="enviar fpdf">

<?php if(strcmp($_SESSION["admin"],"si")==0){ ?>

<table border="1">
    <tr>
        <th>CODIGO</th><th>NOMBRE</th><th>BORRAR</th><th>MODIF.</th>
    </tr>
   <?php 
 if(!empty($totGrup)){
    foreach($totGrup as $val){
        echo "<tr>";
        echo "<td>".$val["codigo_G"]."</td><td>".$val["nombre"]."</td>
        <td>"?><a href="index.php?p=menuGrupos&codG=<?php echo $val['codigo_G']?>&borr=si"><img src="icons/trash-solid.svg" class="icono"><?php echo "</td>
        <td>"?><a href="index.php?p=modificarGrupo&q=<?php echo $val['codigo_G']?>"><img src="icons/file-pen-solid.svg" class="icono"><?php echo "</td>";
        echo "</tr>";
    }
}?>
    <tr>
        <td>
        </td>
        <td>
        <input type="text" name="nombre" value="" size="20">
        </td>
        <td colspan="2">
        <input type="submit" name="añadir" value="AÑADIR GRUPO" >
        </td>
    </tr>
</table>
 

</form>


<a  href='index.php?p=menuGrupos&q=<?php echo $anterior?>'><img src="icons/left-long-solid.svg" width="35px"></a>
<a  href='index.php?p=menuGrupos&q=<?php echo $siguiente?>'><img src="icons/right-long-solid.svg" width="35px"></a><br><br>
<?php }?>

