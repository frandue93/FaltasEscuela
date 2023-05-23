<?php
include("clases/alumno.php");
include("clases/asignatura.php");
include("clases/profesor.php");
include("clases/matricula.php");
$matriculas=false;
$msg="";
$expediente="";
$nom="";
$codigo_A="";
$convocatoria="";
function validarMatricula($codigo_A,$codigo_P,$convocatoria){
if(empty($codigo_A)||empty($codigo_P)||empty(trim($convocatoria))){
    return false;
}
    return true;
}

$todAs = new Asignatura("","","");
if($todAs->todasAsignaturasSinLimiteBD()){
    $todAsign=$todAs->todasAsignaturasSinLimiteBD();
}

$totPr = new Profesor("","","","");
if($totPr->todosProfesoresSinLimiteBD()){
 $totProf=$totPr->todosProfesoresSinLimiteBD();
}

if(isset($_GET["q"])){
    $expediente =  $_GET["q"];
}

if(isset($_GET["codA"])){
    $codigo_A =$_GET["codA"];
}

if(isset($_GET["convo"])){
$convocatoria =$_GET["convo"];
}

if(isset($_GET['q'])){
    $expediente=$_GET["q"];
    $busAl = new Alumno($expediente,"","","","","","","","","","","");
    $buscarAlu=$busAl->buscarAlumnoBD();
    $nom=$buscarAlu['nombre'];
}



if(isset($_POST["añadir"])){
    
    $convocatoria=1;
    $codigo_A=$_POST["asig"];
    $codigo_P=$_POST["prof"];
    
    if(validarMatricula($codigo_A,$codigo_P,$convocatoria)){
        
    $mat = new Matricula($codigo_A,$codigo_P,$convocatoria,$expediente,$_SESSION["curso"]);
    if($mat->mismaEsteAñoBD()){
        $msg="Ya hay una matricula con esos mismos datos guardada este año<br>";
    }else{
       if($convocatoria = $mat->matriculadoOtroAñoBD()){
        $mat = new Matricula($codigo_A,$codigo_P,$convocatoria,$expediente,$_SESSION["curso"]);
       } 
       if($convocatoria<4){
    $msg=$mat->guardaMatriculaBD();
    header("Location:index.php?p=asignaturasAlumno&q=$expediente");
       }else{
        $msg="El alumno agoto las convocatorias<br>";
       }
    }
    }else{
        $msg="Falta algun dato<br>";
    }
}

if(isset($_POST["si"])){

   
    $elMat = new Matricula($codigo_A,"",$convocatoria,$expediente,"");

    $elMat->eliminarMatriculaBD();

   
    $codigo_A="";
    $convocatoria="";
      
}

if($codigo_A!=""&&$convocatoria!=""&&!(isset($_POST["no"]))&&(isset($_GET["borr"]))){
    ?>
    <h2>¿Quieres eliminar la matricula?</h2>
    <form method="POST" action="index.php?p=asignaturasAlumno&q=<?php echo $expediente?>&convo=<?php echo $convocatoria?>&codA=<?php echo $codigo_A?>" enctype="multipart/form-data" >
    <input type="submit" name="si" value="si">
    <input type="submit" name="no" value="no">
    </form>
<?php
}

$totMat= new Matricula("","","",$expediente,"");
    if($totMat->matriculasPorAlumnoBD()){
        $totMatricul=$totMat->matriculasPorAlumnoBD();
        $matriculas=true;
    }



?> <form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" > <?php

echo "Expediente: $expediente<br>"; 
echo "Nombre: $nom<br>";

echo "<table border='1'>";
echo "<tr>";
echo "<th>ASIGNATURA</th>";
echo "<th>CONVOCATORIA</th>";
echo "<th>PROFESOR</th>";
echo "<th>N1</th>";
echo "<th>N2</th>";
echo "<th>N3</th>";
echo "<th>NF</th>";
echo "<th>BORRAR</th>";
if($matriculas){
foreach($totMatricul as $valMat){
    echo "<tr>";
    echo "<td>".$valMat["nombreAsignatura"]."</td>";
    echo "<td>".$valMat["convocatoria"]."</td>";
    echo "<td>".$valMat["nombreProfesor"]."</td>";
    echo "<td>".$valMat["nota1"]."</td>";
    echo "<td>".$valMat["nota2"]."</td>";
    echo "<td>".$valMat["nota3"]."</td>";
    echo "<td>".$valMat["notaFin"]."</td>";
    echo "<td>"?><a href="index.php?p=asignaturasAlumno&q=<?php echo $expediente?>&convo=<?php echo $valMat['convocatoria']?>&codA=<?php echo $valMat['codigo_A']?>&borr=si"><img src="imagenes/borrar.PNG"></a><?php echo "</td>";
}
}
echo "</tr><tr><td><select name='asig'>";
echo "<option value=''></option>";
foreach($todAsign as $valAs){
echo "<option value='".$valAs["codigo_A"]."'>".$valAs["nombre"]."</option>";
}
echo "</select></td><td>";
//echo "<input type='text' name='convocatoria' value='1' size='2' disabled>";
echo "</td><td><select name='prof'>";
echo "<option value=''></option>";
foreach($totProf as $valPro){
echo "<option value='".$valPro["codigo_P"]."'>".$valPro["nombre"]."</option>";
}
echo "</td><td colspan='4'>";
echo '<input type="submit" name="añadir" value="AÑADIR ASIGNATURA">';
echo "</table>";
echo "</from>";
echo $msg;
?>



