<?php include("clases/profesor.php");
$msg="";
$msgProf="";
$checkAdmin="";
$inicio=0;
$cuantos=7;

$totPr = new Profesor("","","","");

if(isset($_GET['q']))
$inicio=$_GET['q'];

if(isset($_GET["k"]))
$msgProf=$_GET["k"];



if($totalFilas = $totPr->totalProfesoradoBD()){
   
}else{
    $totalFilas=0;
}


if(isset($_POST["añadir"])){
    
    if(!empty(trim($_POST["nom"]))){
        $nombre=$_POST["nom"];
        if(isset($_POST["adminBox"]))
        $checkAdmin = $_POST["adminBox"];
        $busPr = new Profesor("",$nombre,"",$checkAdmin);
        $msg = $busPr->siguenteIdProfesorBD();

    }else{
        $msg="Introduce el nombre ";
    }

}

include_once("lib/paginar.php");




$msg="";
$msgAdmin="";
if(isset($_POST["sim"])){
    $codigo_P =  $_GET["codP"];
    $elPro = new Profesor($codigo_P,"","","");
    if($elPro->eliminarMatriculaEnProfesorBD()){
        $elPro->eliminarProfesorBD();
    
            
    }
}


if(isset($_POST["si"])){

    $codigo_P =  $_GET["codP"];
    if($codigo_P!=$_SESSION["codigo_P"]){
    $elPro = new Profesor($codigo_P,"","","");
    if($elPro->profesorEnMatriculaBD()){
        $msg= "¡ ATENCION ! El profesor esta añadido en alguna matricula, ¿quieres borrar tambien sus matriculas?";
        
    }else{
    $elPro->eliminarProfesorBD();

       
    
}
}else{

    $msgAdmin="NO PUEDES BORRAR LA SESION ACTUAL";
    
}
        
}

   
if(isset($_POST["si"])&&$msg!=""){
?>
<h2><?php echo $msg?></h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="sim" value="si">
<input type="submit" name="nom" value="no">
</form>

<?php }
    if(isset($_GET["borr"])){
        ?>
<h2>¿Quieres eliminar el profesor con el codigo <?php echo $_GET["codP"]?> ?</h2>
<form method="POST" action="index.php?p=menuProfesorado&codP=<?php echo $_GET["codP"]?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>
<?php } ?>





<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >

<table border="1">
    <tr>
        <th>CODIGO</th><th>NOMBRE PROFESOR</th>
        <?php if(strcmp($_SESSION["admin"],"si")==0){ ?>
        <th>ADMIN</th>
        <th>BORRAR</th>
        <?php } ?>
        <th>MODIF.</th>
    </tr>
   <?php 
   

   if($totPr->todosProfesoresBD($inicio,$cuantos)){
    $totProf=$totPr->todosProfesoresBD($inicio,$cuantos);
    foreach($totProf as $val){
      
        if(strcmp($_SESSION["admin"],"si")==0||(($_SESSION["codigo_P"])==$val["codigo_P"])){
        echo "<tr>";
        echo "<td>".$val["codigo_P"]."</td><td>".$val["nombre"]."</td>";
        
        if(strcmp($_SESSION["admin"],"si")==0){
        echo "<td>".$val['admin']."</td>";
        if($val["codigo_P"]!=$_SESSION["codigo_P"]){
        echo "<td>"?><a href="index.php?p=menuProfesorado&codP=<?php echo $val['codigo_P']?>&borr=si"><img src="icons/trash-solid.svg" class="icono"><?php echo "</td>";
        }else{
            echo "<td></td>";
        }}
        echo "<td>"?><a href="index.php?p=modificacionProfesor&q=<?php echo $val['codigo_P']?>"><img src="icons/file-pen-solid.svg" class="icono"><?php echo "</td>"; 
        
        echo "</tr>";
        }
    }

}  if(strcmp($_SESSION["admin"],"si")==0){?>
    <tr>
        <td>
        </td>
        <td>
        <input type="text" name="nom" value="" size="20">
        </td >
        <td >
        <input type="checkbox" name="adminBox" value="si">
        </td>
        <td colspan="2">
        <input type="submit" name="añadir" value="AÑADIR PROFESOR" >
        </td>
    </tr>
    <?php }?>
</table>
 
</form>
<p><?php echo $msgProf ?></p>
<?php if(strcmp($_SESSION["admin"],"si")==0){?>
<a  href='index.php?p=menuProfesorado&q=<?php echo $anterior?>'><img src="icons/left-long-solid.svg" width="35px"></a>
<a  href='index.php?p=menuProfesorado&q=<?php echo $siguiente?>'><img src="icons/right-long-solid.svg" width="35px"></a><br><br>
<?php } ?>

