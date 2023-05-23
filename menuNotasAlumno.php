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

if(isset($_GET["exp"])){
    $expediente = $_GET["exp"];
}

if(isset($_GET["k"])){
    $nombreAlumno = $_GET["k"];
}

if(isset($_POST["enviar1"])||isset($_POST["enviar2"])||isset($_POST["enviar3"])||isset($_POST["enviarFin"])||isset($_POST["enviarObs"])){
    if(($_POST["asignaturasDelAlumno"])!=""&&($_POST["profesoresDelAlumnado"])!=""){
        $codProf=$_POST["profesoresDelAlumnado"];
        $codAsig=$_POST["asignaturasDelAlumno"];
        if($_POST["not1"]!=-1 && isset($_POST["enviar1"])){
            
                $nota1 = $_POST["not1"];
                $modMat = new Matricula($codAsig,$codProf,"",$expediente,$_SESSION["curso"],$nota1,"","","","");
                $modMat->modificaNotaBD();
            
        }
        if($_POST["not2"]!=-1 && isset($_POST["enviar2"])){
            
            $nota2 = $_POST["not2"];
            $modMat = new Matricula($codAsig,$codProf,"",$expediente,$_SESSION["curso"],"",$nota2,"","","");
            $modMat->modificaNotaBD();
        
        }
        if($_POST["not3"]!=-1 && isset($_POST["enviar3"])){
            
        $nota3 = $_POST["not3"];
        $modMat = new Matricula($codAsig,$codProf,"",$expediente,$_SESSION["curso"],"","",$nota3,"","");
        $modMat->modificaNotaBD();
    
        }
        if($_POST["notFin"]!=-1 && isset($_POST["enviarFin"])){
            
        $notaFin = $_POST["notFin"];
        $modMat = new Matricula($codAsig,$codProf,"",$expediente,$_SESSION["curso"],"","","",$notaFin,"");
        $modMat->modificaNotaBD();

        }

        if($_POST["observaciones"]!="" && isset($_POST["enviarObs"])){
        $observaciones = $_POST["observaciones"];
        $modMat = new Matricula($codAsig,$codProf,"",$expediente,$_SESSION["curso"],"","","","",$observaciones);
        $modMat->modificaNotaBD();
        }    
        
    }
    
}



$totMat= new Matricula("","","",$expediente,"");
    if($totMat->matriculasPorAlumnoBD()){
        $totMatricul=$totMat->matriculasPorAlumnoBD();
        $matriculas=true;
    }

    $asAlu= new Alumno($expediente,"","","","","","","","","","","");

if($asAlu->asignaturasAlumnoBD()){
   $asignaturasAlum= $asAlu->asignaturasAlumnoBD();

}

$proAlu= new Alumno($expediente,"","","","","","","","","","","");

if($proAlu->profesoresAlumnoBD()){
    $profesoresAlum= $proAlu->profesoresAlumnoBD();
 }


?>


<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
EXPEDIENTE:<?php echo $expediente ?><br>
NOMBRE: <?php echo $nombreAlumno ?>
<table border="1">

<tr>
<th>ASIGNATURA</th><th>CV</th><th>PROFESOR</th><th>NOTA 1</th><th>NOTA 2</th><th>NOTA 3</th><th>NOTA FIN</th><th>OBSERV. BOLETIN</th>
<?php
if($matriculas){
    foreach($totMatricul as $valMat){

        echo "<tr>";
        echo "<td>".$valMat["nombreAsignatura"]."</td>";
        echo "<td>".$valMat["convocatoria"]."</td>";
        echo "<td>".$valMat["nombreProfesor"]."</td>";
        if($valMat["nota1"]<5){
            echo "<td class='rojo'>".$valMat["nota1"]."</td>";
        }else{
            echo "<td class='azul'>".$valMat["nota1"]."</td>";
        }
        if($valMat["nota2"]<5){
            echo "<td class='rojo'>".$valMat["nota2"]."</td>";
        }else{
            echo "<td class='azul'>".$valMat["nota2"]."</td>";

        }
        if($valMat["nota3"]<5){
            echo "<td class='rojo'>".$valMat["nota3"]."</td>";
        }else{
            echo "<td class='azul'>".$valMat["nota3"]."</td>";

        }
        if($valMat["notaFin"]<5){
            echo "<td class='rojo'>".$valMat["notaFin"]."</td>";
        }else{
            echo "<td class='azul'>".$valMat["notaFin"]."</td>";

        }
        echo "<td>".$valMat["observaciones"]."</td>";


        }

?>
</tr>

<tr>
    <td>
    </td>
    <td>
    </td>
    <td>
    </td>
    <td>
        <input type="submit" name="enviar1" value="NOTA 1">
    </td>
    <td>
        <input type="submit" name="enviar2" value="NOTA 2">
    </td>
    <td>
        <input type="submit" name="enviar3" value="NOTA 3">
    </td>
    <td>
        <input type="submit" name="enviarFin" value="NOTA FINAL">
    </td>
    <td>
    </td>
</tr>

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

        <td>
        <select name="not1">
        <?php 
                for($j=-1;$j<=10;$j++){
                 echo "<option value='$j'>$j</option>";
                }
            ?>
        </select>
        </td>

        <td>
        <select name="not2">
        <?php 
                for($j=-1;$j<=10;$j++){
                 echo "<option value='$j'>$j</option>";
                }
            ?>
        </select>
        </td>

        <td>
        <select name="not3">
        <?php 
                for($j=-1;$j<=10;$j++){
                 echo "<option value='$j'>$j</option>";
                }
            ?>
        </select>
        </td>

        <td>
        <select name="notFin">
        <?php 
                for($j=-1;$j<=10;$j++){
                 echo "<option value='$j'>$j</option>";
                }
            ?>
        </select>
        </td>
        
    </tr>
   
    </table>
Observaciones: <input type="text" value="" name="observaciones" size="50">
<input type="submit" name="enviarObs" value="Enviar Observaciones">

<?php
}
?>
 </form>



