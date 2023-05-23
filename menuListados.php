<?php include_once("clases/asignatura.php");
include_once("clases/matricula.php");
include_once("clases/faltas.php");


$msg="";
$cursoEscolar = $_SESSION["curso"];
$selAsig = new Asignatura("","","");
$selMat = new Matricula("","","","",$cursoEscolar);

if($selMat->algunaMatricula()){
$asig = $selAsig->todasAsignaturasSinLimiteBD();
}else{
    $msg="No hay matriculas";
}


$selAlu = new Falta("","","","","","");
if($selAlu->alumnosConFaltas()){
    $alu = $selAlu->alumnosConFaltas();
}

$selAluBol = new Matricula("","","","",$cursoEscolar);
if($selAluBol->todosAlumnosBD()){
    $aluBol = $selAluBol->todosAlumnosBD();

}


if($msg==""){
?>


<form method="POST" action="listaFPDF.php" enctype="multipart/form-data" >

<label>ASIGNATURA: </label>
<select name="asignaturas">
    <option value="">Todos</option>
<?php 
foreach($asig as $val){
    echo "<option value='".$val["codigo_A"]."'>".$val["nombre"]."</option>";
}
?>
</select>

<br><input type="submit" value="LISTAR" name="listar"> 
</form>





<br><br><br>

<form method="POST" action="listaFPDFFaltas.php" enctype="multipart/form-data" >

<label>ALUMNOS CON FALTAS: </label>
<select name="alumnos">
    <option value="">Todos</option>
<?php 
foreach($alu as $val){
    echo "<option value='".$val["expediente"]."'>".$val["nombre"]."</option>";
}
?>
</select>

<br><input type="submit" value="LISTAR" name="listarF"> 
</form>
<br><br><br>
<form method="POST" action="listaFPDFNotas.php" enctype="multipart/form-data" >

<label>Boletin de: </label>
<select name="alumnos">
    <option value="">Todos</option>
<?php 
foreach($aluBol as $val){
    echo "<option value='".$val["expediente"]."'>".$val["nombreAlumno"]."</option>";
}
?>
</select>

<br><input type="submit" value="LISTAR" name="listarF"> 
</form>


<?php


}
    echo "<h3>$msg</h3>";





?>

