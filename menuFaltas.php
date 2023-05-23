<?php
include_once("clases/faltas.php");
include_once("clases/asignatura.php");
include_once("clases/alumno.php");
include_once("lib/fecha.php");

$codigo_A="";
   $codigo_F="";
   $codigo_P="";


if(isset($_GET["exp"])){
    $expediente = $_GET["exp"];
}

if(isset($_GET["k"])){
    $nombreAlumno = $_GET["k"];
}

if(isset($_GET["coFalt"]))
$codigo_F = $_GET["coFalt"];

if(isset($_GET["coAsi"]))
$codigo_A = $_GET["coAsi"];  

if(isset($_GET["coPro"]))
$codigo_P = $_GET["coPro"];




$asAlu= new Alumno($expediente,"","","","","","","","","","","");

if($asAlu->asignaturasAlumnoBD()){
   $asignaturasAlum= $asAlu->asignaturasAlumnoBD();

}

$proAlu= new Alumno($expediente,"","","","","","","","","","","");

if($proAlu->profesoresAlumnoBD()){
    $profesoresAlum= $proAlu->profesoresAlumnoBD();
 }
 
 if(isset($_POST["añadir"])){
    $dia = $_POST["dia"];
    $mes = $_POST["mes"];
    $año = $_POST["año"];
    $fecha = dmy2date($dia,$mes,$año);
       
    if(isset($_POST["asignaturasDelAlumno"])&&isset($_POST["profesoresDelAlumnado"])&&isset($_POST["tipo"]))
    $asignatura = $_POST["asignaturasDelAlumno"];
    $profesor = $_POST["profesoresDelAlumnado"];
    $tipo = $_POST["tipo"];

    $añFalt= new Falta("",$asignatura,$expediente,$fecha,$tipo,$profesor);
    $añFalt->guardaFaltaBD();
    
    
}
     if(isset($_POST["si"])){
    $elFal = new Falta($codigo_F,$codigo_A,$expediente,"","",$codigo_P);
    $elFal->eliminarFaltaBD();
     }


if(isset($_GET["borr"])){
  

?>
    <h2>¿Quieres eliminar la falta del alumno <?php echo $nombreAlumno ?>?</h2>
    <form method="POST" action="index.php?p=menuFaltas&exp=<?php echo $expediente ?>&k=<?php echo $nombreAlumno?>&coFalt=<?php echo $_GET['coFalt']?>&coAsi=<?php echo $_GET['coAsi']?>&coPro=<?php echo $_GET['coPro']?>?>" enctype="multipart/form-data" >
    <input type="submit" name="si" value="si">
    <input type="submit" name="no" value="no">
    </form>
    
<?php
    
}



?>


<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
EXPEDIENTE:<?php echo $expediente ?><br>
NOMBRE: <?php echo $nombreAlumno ?>
<table border="1">
    <tr>
        <th>ASIGNATURA</th><th>PROFESOR</th>
        
        <th colspan="3">FECHA</th>
        <th>TIPO</th>
        <?php if(strcmp($_SESSION["admin"],"si")==0){ ?>
        <th>BORRAR</th>
        <?php } ?>
        
    </tr>
   <?php 
   
   $mosFalt = new Falta("","",$expediente,"","","");

   if($mosFalt->mostrarFaltasBD()){
   
   $mostrarFaltas = $mosFalt->mostrarFaltasBD();
   
   
  foreach($mostrarFaltas as $val){
        echo "<tr>";
        echo "<td>".$val['nombreAsignatura']."</td>";
        echo "<td>".$val['nombreProfesor']."</td>";
        echo "<td colspan='3'>".$val['fecha']."</td>";
        echo "<td>".$val['tipo']."</td>";
        echo "<td>"?><a href="index.php?p=menuFaltas&exp=<?php echo $expediente ?>&k=<?php echo $nombreAlumno?>&coFalt=<?php echo $val["codigo_F"]?>&coAsi=<?php echo $val["codigo_A"]?>&coPro=<?php echo $val["codigo_P"]?>&borr=si"><img src="icons/trash-solid.svg" class="icono"><?php echo "</td>";

        echo "</tr>";
  }
    
   }
  ?>



    <tr>
        <td>
        <select name="asignaturasDelAlumno">
            <option></option>
            <?php foreach($asignaturasAlum as $val){
                echo "<option value='".$val["codigo_A"]."'>".$val['nombre']."</option>";
            }
           
           ?>
        </select>
        </td>
        <td>
        <select name="profesoresDelAlumnado">
        <option></option>
            <?php foreach($profesoresAlum as $val){
                echo "<option value='".$val["codigo_P"]."'>".$val['nombre']."</option>";
            }
           
           ?>

        </select>
        </td >
        <td >
        <select name="dia">
        <?php 
                for($j=1;$j<=31;$j++){
                 echo "<option value='$j'>$j</option>";
                }
            ?>
        </select>
        </td>
        <td>
       <select name="mes">
            <?php 
                for($i=1;$i<=12;$i++){
                 echo "<option value='$i'>$i</option>";
                }
            ?>
       </select>
        </td>
        
        <td >
        <select name="año">
                <?php
                for($A=date("Y");$A>=date("Y")-20;$A--){
                    echo "<option value='$A'>$A</option>";
                }
                ?>
        </select>
        </td>
        <td>
        <select name="tipo">
            <option value="f">Falta</option>
            <option value="r">Retras</option>
            <option value="j">Justif</option>
        </select>
        </td>
        <td>
        <input type="submit" name="añadir" value="AÑADIR FALTA" >
        </td>
    </tr>
    
</table>
 
</form>


<a  href='index.php?p=menuProfesorado&q=<?php echo $anterior?>'><img src="icons/left-long-solid.svg" width="35px"></a>
<a  href='index.php?p=menuProfesorado&q=<?php echo $siguiente?>'><img src="icons/right-long-solid.svg" width="35px"></a><br><br>
