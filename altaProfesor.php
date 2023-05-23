<?php
include("clases/profesor.php");

    
function validarProf($nombre,$clave,$clave2){
    if(!(empty(trim($nombre))) && !(empty(trim($clave))) && !(empty(trim($clave2)))){
        if($clave != $clave2){
            echo "La contraseña es diferente";
        }
        return true;
    }else{
        echo "Falta algun dato";
    }

}
$msg="";
if(isset($_POST["crear"])){
    
    $nombre=$_POST["nombre"];
    $clave=$_POST["clave"];
    $clave2=$_POST["clave2"];
    if(validarProf($nombre,$clave,$clave2)){
        $prof=new Profesor("",$nombre,$clave,"si");
        $msg=$prof->guardaProfesorBD();
        header("Location:index.php?p=loginProfesor");
    }
}

?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >

<label>*Es obligatorio completar todos los campos</label><br><br>
<label>Nombre: </label><br><input type="text" value="" name="nombre"><br>
<label>Clave: </label><br><input type="password" value="" name="clave"><br>
<label>Repite la clave: </label><br><input type="password" value="" name="clave2"><br><br>


<input type="submit" name="crear" value="CREAR">
<p><?php echo $msg?></p>

<?php if(!(empty($_SESSION["nombre"]))){
    
    echo "<a href='index.php?p=menuNavegacion'>Menu de navegacion</a>";
    }?>

</form>