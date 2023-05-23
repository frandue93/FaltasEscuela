<?php 
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }

include_once("clases/grupo.php");
$msg="";


if(isset($_POST["sim"])){
    $codigo_G =  $_GET["q"];
    $elGru = new Grupo($codigo_G,"");
    if($elGru->eliminarAlumnosEnGrupoBD()){
        $elGru->eliminarGrupoBD();
            header("Location:index.php?p=menuGrupos");
    }
}


if(isset($_POST["si"])){

    $codigo_G =$_GET["q"];
   
    $elGru = new Grupo($codigo_G,"");

    if($elGru->grupoConAlumnoBD()){
        $msg= "¡ ATENCION ! El grupo contiene alumnos, ¿quieres borrar tambien los alumnos?";
        
    }else{

    $elGru->eliminarGrupoBD();
    header("Location:index.php?p=menuGrupos");
        
}

}
if(isset($_POST["no"]))
    header("Location:index.php?p=menuGrupos");

    if($msg!=""){
        ?>
        <h2><?php echo $msg?></h2>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
        <input type="submit" name="sim" value="si">
        <input type="submit" name="no" value="no">
        </form>
        <a href="index.php?p=menuGrupos">Volver</a>
        <?php }else{ 
            if(!isset($_POST["sim"])){

?>
<h2>¿Quieres eliminar el grupo?</h2>
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>
<?php } }?>