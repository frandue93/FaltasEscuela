<?php 
if(session_status() !== PHP_SESSION_ACTIVE){
session_start();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/stylee.css?1.0" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>
<body>


<header>



    <nav class="menu">
    <?php $añoActual = date("Y");
          $mesActual = date("m");
          if($mesActual>6){
            $cursoActual =$añoActual."-".($añoActual+1);
          }
          if($mesActual<6){
            
            $cursoActual = ($añoActual-1)."-".$añoActual;
          }
          $_SESSION["curso"]=$cursoActual;

    ?>
   
   
    </nav>
    
    
</header>
<nav class="page__menu menuu">
<ul class="menu__list r-list">
      <li class="menu__group"><a class="menu__link azul "><?php echo $cursoActual ?></a></li>
      <li class="menu__group"><a href="index.php?a=logout" class="menu__link r-link">LOGOUT</a></li>
      <?php 
       if(isset($_SESSION["nombre"])){
            echo "<li class='sesionProf'><a class='menu__link r-link'>".$_SESSION['nombre'].", codigo: ".$_SESSION['codigo_P']."</a></li>";
        if(strcmp($_SESSION["admin"],"si")==0){
            echo "<li class='sesionProf'><a class='menu__link r-link'>ADMINISTRADOR</a></li>";
        }
    ?>
      </ul>
    <ul class="menu__list r-list">
      <li class="menu__group"><a href="index.php?p=menuAlumnado" class="menu__link r-link text-underlined">Menu Alumnado</a></li>
      <?php if(strcmp($_SESSION["admin"],"si")==0){?>
      <li class="menu__group"><a href="index.php?p=menuAsignaturas" class="menu__link r-link text-underlined">Menu Asignaturas</a></li>
      <?php }?>
      <li class="menu__group"><a href="index.php?p=menuListados" class="menu__link r-link text-underlined">Menu listados</a></li>
      <li class="menu__group"><a href="index.php?p=menuProfesorado" class="menu__link r-link text-underlined">Menu Profesorado</a></li>
      <li class="menu__group"><a href="index.php?p=menuGrupos" class="menu__link r-link text-underlined">Menu Grupos</a></li>
    </ul>
   <?php } ?>
  </nav>
  
  <article>
  <?php
  
    echo "<h2 >";
    if($p=='altaProfesor')
       echo "ALTA PROFESOR";
    if($p=='menuAlumnado')  
        echo "ALUMNOS";
    if($p=='altaAlumno') 
        echo "ALTA ALUMNO"; 
    if($p=='asignaturasAlumno')
        echo "ASIGNATURAS ALUMNO";
    if($p=='modificacionAlumno') 
        echo "MODIFICACION ALUMNO"; 
    if($p=='menuAsignaturas')
        echo "Menu Asignaturas";    
    if($p=='menuProfesorado')
        echo "Menu Profesorado"; 
    if($p=='menuListados')
        echo "Menu Listados";
    if($p=='menuGrupos')
        echo "Menu Grupos";
    if($p=='menuFaltas')
        echo "Menu Faltas";
    if($p=='loginProfesor'){
        if(empty($_SESSION["nombre"])){
        echo "Login del profesor";
        }else{
            
        }
    }
    if($p=='modificacionAsignatura')
        echo "Modificacion asignatura";
    if($p=='modificacionProfesor')
        echo "Modificacion profesor";
    if($p=='modificarGrupo')
        echo "Modificacion del grupo";
    if($p=='borrarAlumno')
        echo "Borrar Alumno";
    if($p=='borrarProfesor')
        echo "Borrar Profesor";
    if($p=='borrarAsignatura')
        echo "Borrar Asignatura";
    if($p=='borrarMatricula')
        echo "Borrar Matricula";
    if($p=='borrarGrupo')
        echo "Borrar Grupo";
    if($p=='borrarFalta')
        echo "Borrar Falta";
        echo "</h2>";
    ?>

