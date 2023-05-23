<?php
include("clases/asignatura.php");
$msg="";
$inicio=0;
$cuantos=7;
$codigo_A="";
function validar($nombre,$duracion_semanal){
    if(!(empty(trim($nombre)))&&!(empty(trim($duracion_semanal)))){
        if(!(is_numeric($duracion_semanal))||$duracion_semanal>999||$duracion_semanal<0){
            return false;
        }else{
            return true;
        }
        
    }else{
        return false;
    }
}

if(isset($_GET['q']))
$inicio=$_GET['q'];

$totAs= new Asignatura("","","");

if($totalFilas = $totAs->totalAsignaturasBD()){
   
}else{
    $totalFilas=0;
}

if(isset($_GET["codA"])){
   $codigo_A = $_GET["codA"];
   
}


if(isset($_POST["añadir"])){
    $nombre=$_POST["nombre"];
    $duracion_semanal=$_POST["duracion_semanal"];
    if(validar($nombre,$duracion_semanal)){
        $asig=new Asignatura("",$nombre,$duracion_semanal);
        $msg=$asig->guardaAsignaturaBD();
        header("Location:index.php?p=menuAsignaturas");
    }else{
        $msg="Hay algun dato invalido";
    }
}








if(isset($_POST["buscar"])){
    
    if(isset($_POST["busqAsig"])){
        
        $asignatura=$_POST["busqAsig"];
        if(empty(trim($asignatura))){
           
        }else{
            $busAsi = new Asignatura("",$asignatura,"");
            if($totalFilas = $busAsi->totalPorNombre()){
             
            }else{
             $totalFilas =0;
            }
             if($busAsi->buscarPorNombrAsigBD($inicio,$cuantos)){
                 
                 $totAsign=$busAsi->buscarPorNombrAsigBD($inicio,$cuantos);
             }
        }
    }else{
        $totAsign="";
    }
}

include_once("lib/paginar.php");

if($codigo_A!=""&&isset($_GET["borr"])){
    echo "cod ".$codigo_A;
   ?><h2>¿Quieres borrar la asignatura? </h2>
<form method="POST" action="index.php?p=menuAsignaturas&codA=<?php echo $codigo_A?>" enctype="multipart/form-data" >
<input type="submit" name="si" value="si">
<input type="submit" name="no" value="no">
</form>
<?php
}

if(isset($_POST["si"])){
    
    $elAs = new Asignatura($codigo_A,"","");
    if($elAs->asignaturaEnMatriculaBD()){
        
        echo "¡ ATENCION ! La asignatura esta añadido en alguna matricula, ¿quieres borrar tambien sus matriculas?";
        ?>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
        <input type="submit" name="sim" value="si">
        <input type="submit" name="nom" value="no">
        </form>
        <?php
    }else{
        $elAs->eliminarAsignaturaBD();
    }
}

if(isset($_POST["sim"])){
    
    $elAs = new Asignatura($codigo_A,"","");
    $elAs->eliminarMatriculaEnAsignaturaBD();
    $elAs->eliminarAsignaturaBD();
    
    
}

if($totAs->todasAsignaturasBD($inicio,$cuantos)){
    $totAsign=$totAs->todasAsignaturasBD($inicio,$cuantos);
}

?>


<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="text" name="busqAsig" value=""><input type="submit" name="buscar" value="BUSCAR ASIG"> 

<table border="1">
    <tr>
        <th>CODIGO</th><th>NOMBRE</th><th>MINUT/SEM</th><th>SIGUIENTE ASIG</th><th>BORRAR</th><th>MODIF.</th>
    </tr>
   <?php 
 if(!empty($totAsign)){
    foreach($totAsign as $val){
        echo "<tr>";
        echo "<td>".$val["codigo_A"]."</td><td>".$val["nombre"]."</td><td>".$val['duracion_semanal']."</td>
        <td></td>
        <td>"?><a href="index.php?p=menuAsignaturas&codA=<?php echo $val['codigo_A']?>&borr=si"><img src="icons/trash-solid.svg" class="icono"><?php echo "</td>
        <td>"?><a href="index.php?p=modificacionAsignatura&q=<?php echo $val['codigo_A']?>"><img src="icons/file-pen-solid.svg" class="icono"><?php echo "</td>";
        echo "</tr>";
    }
}?>
    <tr>
        <td>
        </td>
        <td>
        <input type="text" name="nombre" value="" size="20">
        </td>
        <td>
        <input type="text" name="duracion_semanal" value="" size="6">
        </td>
        <td>
        </td>
        <td colspan="2">
        <input type="submit" name="añadir" value="AÑADIR ASIGNATURA" >
        </td>
    </tr>
</table>
 <p><?php echo $msg ?></p>
</form>


<a  href='index.php?p=menuAsignaturas&q=<?php echo $anterior?>'><img src="icons/left-long-solid.svg" width="35px"></a>
<a  href='index.php?p=menuAsignaturas&q=<?php echo $siguiente?>'><img src="icons/right-long-solid.svg" width="35px"></a><br><br>


