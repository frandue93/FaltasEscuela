
<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
include("clases/profesor.php");

if(isset($_POST["loggear"])){

if(isset($_POST["codigo_P"]) && isset($_POST["clave"])){

    $codigo_P=$_POST["codigo_P"];
    $clave=$_POST["clave"];

    $prof = new Profesor($codigo_P,"",$clave,"");
    if($prof->buscarProfesorBD()){
        header("Location:index.php?p=menuAlumnado");
       

    }
        
}

}

if(empty($_SESSION["nombre"])){

?>


<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >

<label>Codigo del profesor: </label><br><input type="text" value="" name="codigo_P"><br>
<label>clave: </label><br><input type="password" value="" name="clave"><br>
<label>*Es obligatorio completar todos los campos</label>
<input type="submit" name="loggear" value="LOGGEAR">

</form>
<?php }?>