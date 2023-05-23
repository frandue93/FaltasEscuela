<?php 
include_once("clases/alumno.php");

$msg="";

if(isset($_POST["sim"])){
    $expediente =  $_GET["q"];
    $elAl = new Alumno($expediente,"","","","","","","","","","","");
    if($elAl->eliminarMatriculaEnAlumnoBD()){
        if($elAl->eliminarAlumnoBD()){

            header("Location:index.php?p=menuAlumnado");
            }else{
                header("Location:index.php?p=menuAlumnado&e=$expediente");
    
            }
    }
}

if(isset($_POST["si"])){

    $expediente =  $_GET["q"];
    $elAl = new Alumno($expediente,"","","","","","","","","","","");

    if($elAl->alumnoEnMatriculaBD()){
        $msg= "¡ ATENCION ! El alumno esta añadido en alguna matricula, ¿quieres borrar tambien sus matriculas?";
        
    }else{



    if($elAl->eliminarAlumnoBD()){
        header("Location:index.php?p=menuAlumnado");
        }else{
            header("Location:index.php?p=menuAlumnado&e=$expediente");

        }


    }
        
}
if(isset($_POST["no"]))
    header("Location:index.php?p=menuAlumnado");


    if($msg!=""){
        ?>
        <h2><?php echo $msg?></h2>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
        <input type="submit" name="sim" value="si">
        <input type="submit" name="no" value="no">
        </form>
        <a href="index.php?p=menuProfesorado">Volver</a>
        <?php }else{ 
            if(!isset($_POST["sim"])){

?>
<h2>¿Quieres eliminar el alumno con el codigo <?php echo $_GET["q"]?></h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>
<?php } }?>