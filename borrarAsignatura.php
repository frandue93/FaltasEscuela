<?php 
include_once("clases/asignatura.php");

$msg="";

if(isset($_POST["sim"])){
    $codigo_A =  $_GET["q"];
    $elAs = new Asignatura($codigo_A,"","");
    if($elAs->eliminarMatriculaEnAsignaturaBD()){
        if($elAs->eliminarAsignaturaBD()){

            header("Location:index.php?p=menuAsignaturas");
            }else{
                header("Location:index.php?p=menuAsignaturas&e=$codigo_A");
    
            }
    }
}

if(isset($_POST["si"])){

    $codigo_A =  $_GET["q"];
    $elAs = new Asignatura($codigo_A,"","");


    if($elAs->asignaturaEnMatriculaBD()){
        $msg= "¡ ATENCION ! La asignatura esta añadido en alguna matricula, ¿quieres borrar tambien sus matriculas?";
        
    }else{



    if($elAs->eliminarAsignaturaBD()){
        
        header("Location:index.php?p=menuAsignaturas");
        }else{
            header("Location:index.php?p=menuAsignaturas&e=$codigo_A");

        }

    }

        
}
if(isset($_POST["no"]))
    header("Location:index.php?p=menuAsignaturas");

if($msg!=""){
?>
<h2><?php echo $msg?></h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="sim" value="si">
<input type="submit" name="nom" value="no">
</form>
<a href="index.php?p=menuAsignaturas">Volver</a>
<?php }else{ 
    if(!isset($_POST["sim"])){

?>
<h2>¿Quieres eliminar la asignatura con el codigo <?php echo $_GET["q"]?></h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>

<?php } }?>