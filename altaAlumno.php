<?php
include("clases/alumno.php");
include("lib/fecha.php");
include("lib/correo.php");
include("lib/dni.php");
include("clases/grupo.php");

$msgDni="";
$msgEmail="";
$msgObligatorios="";
$msgGuardado="";
$msgFecha="";
$fecha="";
$msgGrupo="";
$selGru="";
function validarAlumno($nombre,$apellidos){

    if(empty($nombre)||empty($apellidos)){
        return false;
    }
        return true;
}


$gru = new Grupo("","");

if($gru->todosGruposSinLimiteBD()){
    $selGru=$gru->todosGruposSinLimiteBD();
}



if(isset($_POST["altaAlumno"])){
   $nombre= $_POST["nombre"];
   $apellidos= $_POST["apellidos"];
   $fechaDia=$_POST["fechaDia"];
   $fechaMes=$_POST["fechaMes"];
   $fechaAño=$_POST["fechaAño"];
   $dni=$_POST["dni"];

   if(isset($_POST["grupo"]))
   $codigo_G=$_POST["grupo"];

  
   if(isset($_POST["direccion"])){
    $direccion=$_POST["direccion"];
   }else{
    $direccion="";
   }
   if(isset($_POST["telefonos"])){
   $telefonos=$_POST["telefonos"];
   }else{
    $telefonos="";
   }
   $email=$_POST["email"];
   if(isset($_POST["nompadres"])){
   $nompadres=$_POST["nompadres"];
   }
   if(isset($_POST["socio"])){
    $socio=$_POST["socio"];
   }else{
    $socio="false";
   }
   if(isset($_POST["observaciones"])){
   $observaciones=$_POST["observaciones"];
   }

   if(!validarAlumno($nombre,$apellidos)){
    $msgObligatorios= "Faltan los nombres<br>";
   }

   if(dmy2date($fechaDia,$fechaMes,$fechaAño)){
     $fecha=dmy2date($fechaDia,$fechaMes,$fechaAño);
   }else{
    $msgFecha = "Fecha erronea<br>";
   }

   if(!validarCorrecto($email)){
    $msgEmail= "El correo es incorrecto";
   }

   if(empty($codigo_G))
   $msgGrupo="Inserta algun grupo";

   if(!validarDni($dni)){
    $msgDni= "El dni es incorrecto";
   }

   if($msgObligatorios=="" &&$msgDni=="" && $msgEmail=="" && $fecha!="" && $msgGrupo==""){
    $alu = new Alumno("",$nombre,$apellidos,$fecha,$dni,$direccion,$telefonos,$email,$nompadres,$observaciones,$socio,$codigo_G);
    $msgGuardado=$alu->guardaAlumnoBD();
    header("Location: index.php?p=menuAlumnado");
    }else{
        $msgGuardado="no se guardo el alumno";
    }
   
}


?>
<section class="formAlta">
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
(Los campos con * son obligatorios)<br><br>
<label>NOMBRE:*</label><br><input type="text" name="nombre" value=""><br><br>
<label>APELLIDOS:*</label><br> <input type="text" name="apellidos" value=""><br><?php echo $msgObligatorios ?><br>
<label>FECHA NACIMIENTO:*</label><br> Dia: <input type="text" name="fechaDia" value="" size="2"> Mes: <input type="text" name="fechaMes" value="" size="10"> Año: <input type="text" name="fechaAño" value="" size="4"><br><?php echo $msgFecha ?><br>
<label>DNI:</label><br><input type="text" name="dni" value=""><?php echo $msgDni ?><br><br>
<label>DIRECCION:</label><br> <input type="text" name="direccion" value=""><br><br>
<label>TELEFONOS:</label><br> <input type="text" name="telefonos" value=""><br><br>
<label>E-MAIL:</label> <br><input type="text" name="email" value=""><?php echo $msgEmail ?><br><br>
<label>NOMBRE DE LOS PADRES:</label> <br><input type="text" name="nompadres" value=""><br><br>
<label>SOCIO:</label> <br><input type="checkbox" name="socio" value="si"><br><br>
<label>OBSERVACIONES:</label><br><input type="text" name="observaciones" value="" size="100"><br><br>
<label>GRUPO:</label><br>
<?php if($selGru !=""){
    ?>
<select name="grupo">
<option></option>
<?php
foreach($selGru as $val){
    echo "<option value='".$val["codigo_G"]."'>".$val["nombre"]."</option>";
}
?>
</select>
<?php
}else{
 echo "<h4>Es necesario crear algun grupo</h4>";
}
echo "<br> $msgGrupo";
?>
<br>
<?php echo $msgGuardado."<br>" ?><br>
<input type="submit" name="altaAlumno" value="Alta Alumno"><br><br>


</form>
</section>
