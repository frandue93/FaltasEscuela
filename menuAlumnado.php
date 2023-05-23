<?php include_once("clases/alumno.php");

$msg="";
$inicio=0;
$cuantos=7;

if(isset($_GET["e"])){
    $msg="No se a podido borrar el usuario con expediente ".$_GET["e"];
}


$totAl = new Alumno("","","","","","","","","","","","");
if(isset($_GET['q']))
$inicio=$_GET['q'];

if(isset($_GET["exp"]))
$expediente =  $_GET["exp"];




$msg="";

if(isset($_POST["sim"])){
   
    $elAl = new Alumno($expediente,"","","","","","","","","","","");
    if($elAl->eliminarMatriculaEnAlumnoBD()){
        if($elAl->eliminarAlumnoBD()){
            
            }
    }
}

if(isset($_POST["si"])){

    
    $elAl = new Alumno($expediente,"","","","","","","","","","","");

    if($elAl->alumnoEnMatriculaBD()){
        $msg= "¡ ATENCION ! El alumno esta añadido en alguna matricula, ¿quieres borrar tambien sus matriculas?";
        
    }else{

    $elAl->eliminarAlumnoBD();
       
    }
        
}

  


    if($msg!=""&&isset($_POST["si"])){
        ?>
        <h2><?php echo $msg?></h2>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
        <input type="submit" name="sim" value="si">
        <input type="submit" name="no" value="no">
        </form>
      
        <?php }
if(isset($_GET["borr"])){
?>
<h2>¿Quieres eliminar el alumno con el codigo <?php echo $expediente?></h2>
<form method="POST" action="index.php?p=menuAlumnado&exp=<?php echo $expediente?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>
<?php }







if($totalFilas = $totAl->totalAlumnosBD()){
}else{
    $totalFilas=0;
}
if($totAl->todosAlumnosBD($inicio,$cuantos)){
$totAlum=$totAl->todosAlumnosBD($inicio,$cuantos);

}

if((isset($_POST["buscar"]))){

    if(isset($_POST["busqApell"])){
      
        $apellido=$_POST["busqApell"];
        
        if(empty(trim($apellido))){
            
        }else{
            
            $busApe = new Alumno("","",$apellido,"","","","","","","","","");
            if($totalFilas = $busApe->totalPorApellido()){
               
            }else{
                $totalFilas=0;
            }
            if($busApe->buscarApellidoBD($inicio,$cuantos)){
               
                $totAlum=$busApe->buscarApellidoBD($inicio,$cuantos);
                
            }
        }
    }else{
        $totAlum="";
    }
}


include_once("lib/paginar.php");

?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >





<?php
if(!empty($totAlum)){
?>
<input type="text" name="busqApell" value=""><input type="submit" name="buscar" value="BUSCAR APELL"> 
<?php
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>EXPED.</th><th>NOMBRE</th><th>APELLIDOS</th>";

    if(strcmp($_SESSION["admin"],"si")==0)
    echo "<th>DETALLES</th><th>ASIGNATURAS</th>";
    echo "<th>FALTAS</th><th>NOTAS</th>";
    if(strcmp($_SESSION["admin"],"si")==0)
    echo "<th>BORRAR</th>";
    echo "<th>BOLET</th>";
    echo "</tr>";
    foreach($totAlum as $val){
        
    echo "<tr>";
    echo "<td>".$val["expediente"]."</td>
    <td>".$val["nombre"]."</td>
    <td>".$val["apellidos"]."</td>";
    if(strcmp($_SESSION["admin"],"si")==0){
    echo "<td>"?><a href="index.php?p=modificacionAlumno&q=<?php echo $val['expediente']?>"><img src="icons/file-pen-solid.svg" class="icono"><?php echo "</td>
    <td>"?><a href="index.php?p=asignaturasAlumno&q=<?php echo $val['expediente']?>"><img src="icons/book-solid.svg" class="icono"><?php echo "</td>";
    }
    echo "<td>"?><a href="index.php?p=menuFaltas&exp=<?php echo $val['expediente']?>&k=<?php echo $val['nombre']?>"><img src="icons/f-solid.svg" class="icono"><?php echo "</td>";
    echo "<td>"?><a href="index.php?p=menuNotasAlumno&exp=<?php echo $val['expediente']?>&k=<?php echo $val['nombre']?>"><img src="icons/book-open-solid.svg" class="icono"><?php echo "</td>";
    if(strcmp($_SESSION["admin"],"si")==0){
    echo "<td>"?><a href="index.php?p=menuAlumnado&exp=<?php echo $val['expediente']?>&borr=si"><img src="icons/trash-solid.svg" class="icono"><?php echo "</td>";
    }
    echo "<td>"?><a href="listaFPDFNotas.php?exp=<?php echo $val['expediente']?>&curso=<?php echo $_SESSION['curso'] ?>"><img src="icons/file-circle-check-solid.svg" class="icono"><?php echo "</td>";
    echo "</tr>";
}




    echo "</table>";
}else{
    echo "No hay alumnos registrados<br><br>";
}



?>



<a  href='index.php?p=menuAlumnado&q=<?php echo $anterior?>'><img src="icons/left-long-solid.svg" width="35px"></a>
<?php if(strcmp($_SESSION["admin"],"si")==0){?>
<a href="index.php?p=altaAlumno"><img src="icons/user-plus-solid.svg" width="35px"></a>
<?php }?>
<a  href='index.php?p=menuAlumnado&q=<?php echo $siguiente?>'><img src="icons/right-long-solid.svg" width="35px"></a>
<br><br>


