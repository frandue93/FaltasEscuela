<?php 
include_once("clases/profesor.php");

$msg="";
$msgAdmin="";
if(isset($_POST["sim"])){
    $codigo_P =  $_GET["q"];
    $elPro = new Profesor($codigo_P,"","","");
    if($elPro->eliminarMatriculaEnProfesorBD()){
        if($elPro->eliminarProfesorBD()){

            header("Location:index.php?p=menuProfesorado");
            }else{
                header("Location:index.php?p=menuProfesorado&e=$codigo_P");
    
            }
    }
}


if(isset($_POST["si"])){

    $codigo_P =  $_GET["q"];
    if($codigo_P!=$_SESSION["codigo_P"]){
    $elPro = new Profesor($codigo_P,"","","");
    if($elPro->profesorEnMatriculaBD()){
        $msg= "¡ ATENCION ! El profesor esta añadido en alguna matricula, ¿quieres borrar tambien sus matriculas?";
        
    }else{
    if($elPro->eliminarProfesorBD()){

        header("Location:index.php?p=menuProfesorado");
        }else{
            header("Location:index.php?p=menuProfesorado&e=$codigo_P");

        }
    }
}else{

    $msgAdmin="NO PUEDES BORRAR LA SESION ACTUAL";
    header("Location:index.php?p=menuProfesorado&k=$msgAdmin");
}
        
}
if(isset($_POST["no"]))
    header("Location:index.php?p=menuProfesorado");


if($msg!=""){
?>
<h2><?php echo $msg?></h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="sim" value="si">
<input type="submit" name="nom" value="no">
</form>
<a href="index.php?p=menuProfesorado">Volver</a>
<?php }else{ 
    if(!isset($_POST["sim"])){?>
    
<h2>¿Quieres eliminar el profesor con el codigo <?php echo $_GET["q"]?> ?</h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>
<?php } }?>