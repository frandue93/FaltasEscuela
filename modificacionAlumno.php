
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

if(isset($_GET['q'])){
    $expediente=$_GET["q"];
    $busAl = new Alumno($expediente,"","","","","","","","","","","");
    $buscarAlu=$busAl->buscarAlumnoBD();
    $nom=$buscarAlu['nombre'];
    $ape=$buscarAlu['apellidos'];
    $dir=$buscarAlu['direccion'];
    $dn=$buscarAlu['dni'];
    $fNaz=$buscarAlu['fecha_nacimiento'];
    $fec = explode('-',$fNaz);
     $año =$fec[0];
     $mes =$fec[1];
     $dia =$fec[2];
    $nomPad=$buscarAlu['nombre_padres'];
    $obser=$buscarAlu['observaciones'];
    $soc=$buscarAlu['socio_banda'];
    $tel=$buscarAlu['telefonos'];
    $ema=$buscarAlu['email'];
    $codigo_G=$buscarAlu['codigo_G'];
}

if(isset($_POST["modificaAlumno"])){
   $nombre= $_POST["nombre"];
   $apellidos= $_POST["apellidos"];
   $fechaDia=$_POST["fechaDia"];
   $fechaMes=$_POST["fechaMes"];
   $fechaAño=$_POST["fechaAño"];
   $dni=$_POST["dni"];
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
    $socio="";
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

   if(!validarDni($dni)){
    $msgDni= "El dni es incorrecto";
   }

   if($msgObligatorios=="" &&$msgDni=="" && $msgEmail=="" && $fecha!=""){
    $alu = new Alumno($expediente,$nombre,$apellidos,$fecha,$dni,$direccion,$telefonos,$email,$nompadres,$observaciones,$socio,$codigo_G);
    $msgGuardado=$alu->modificaAlumnoBD();
    header("Location: index.php?p=menuAlumnado");
    }else{
        $msgGuardado="no se modifico el alumno";
    }
   
}


?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
(Los campos con * son obligatorios)<br><br>
EXPEDIENTE.<br> <input type="text" name="expediente" value="<?php echo $expediente ?>" disabled><br><br>
NOMBRE:*<br>       <input type="text" name="nombre" value="<?php echo $nom?>"><br><br>
APELLIDOS:* <br><input type="text" name="apellidos" value="<?php echo $ape?>"><br><?php echo $msgObligatorios ?><br>
FECHA NACIMIENTO:*<br> Dia: <input type="text" name="fechaDia" value="<?php echo $dia?>" size="2"> Mes: <input type="text" name="fechaMes" value="<?php echo $mes?>" size="10"> Año: <input type="text" name="fechaAño" value="<?php echo $año?>" size="4"><br><?php echo $msgFecha ?><br>
DNI:<br> <input type="text" name="dni" value="<?php echo $dn?>"><?php echo $msgDni ?><br><br>
DIRECCION:<br> <input type="text" name="direccion" value="<?php echo $dir?>"><br><br>
TELEFONOS:<br> <input type="text" name="telefonos" value="<?php echo $tel?>"><br><br>
E-MAIL:<br> <input type="text" name="email" value="<?php echo $ema?>"><?php echo $msgEmail ?><br><br>
NOMBRE DE LOS PADRES:<br> <input type="text" name="nompadres" value="<?php echo $nomPad?>"><br><br>
SOCIO:<br> <input type="checkbox" name="socio" value="si" <?php if($soc=="si")echo "checked='checked'" ?>
><br><br>
OBSERVACIONES:<br> <input type="text" name="observaciones" value="<?php echo $obser?>" size="100"><br>
<?php echo $msgGuardado."<br>" ?>


GRUPO:<br>
<?php if($selGru !=""){
    ?>
<select name="grupo">

<?php
foreach($selGru as $val){
    if($val == $expediente){
        $msgGrupoSelect='true';
    }else{
        $msgGrupoSelect='';
    }
    echo "<option selected = ".$msgGrupoSelect." value='".$val["codigo_G"]."'>".$val["nombre"]."</option>";
}
?>
</select>
<?php
}else{
 echo "<h4>Es necesario crear algun grupo</h4>";
}

?>
<br><br><br>
<input type="submit" name="modificaAlumno" value="Modificar Alumno">
</form>
