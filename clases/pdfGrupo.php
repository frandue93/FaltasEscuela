<?php 
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
require_once('./lib/fpdf/fpdf.php');
   require_once("clases/matricula.php");
   require_once("clases/alumno.php");
   require_once("clases/grupo.php");

class PDF extends FPDF{

    

function header(){
   global $codigo_Grupo;
   $this->SetFont('Arial','B',14);
    $this->Image("./imagenes/logoMusica.PNG",10,9,33);
    $this->Cell(50,10,"",0,0);
    $this->Cell(110,10,"LISTADO DE ALUMNOS POR GRUPO",1,0);
    $this->Ln();
    $this->Cell(50,10,"",0,0);
    $this->Cell(20,10,UTF8_DECODE("Año escolar ").$_SESSION["curso"],0,0);
    $this->Ln();
    $gru = new Grupo($codigo_Grupo,"","");
    if($gru->buscarGrupoBD()){
    $buscar = $gru->buscarGrupoBD();
    $this->Cell(50,10,"",0,0);
    if(isset($buscar["nombre"])){
    $this->Cell(20,10,UTF8_DECODE($buscar["nombre"]),0,0);
    }
    }else{
        $this->Cell(50,10,"",0,0);
        $this->Cell(20,10,UTF8_DECODE("TODOS ALUMNOS EN LOS GRUPOS"),0,0);
    }
    $this->Ln();
    $this->Cell(20,10,'NUM.',0,0);
    $this->Cell(40,10,'APELLIDOS',0,0);
    $this->Cell(40,10,'NOMBRE',0,0);
    $this->Cell(40,10,'CONV.',0,0);  
    $this->Cell(40,10,'EXP.',0,0);
    $this->Line(10,50,180,50);
    $this->Ln();
    
}



function CuerpoTabla($codigo_Grupo){
    
    
    if($codigo_Grupo!=""){
        $alumnosGrupo= new Grupo($codigo_Grupo,"");
    if($alumnosGrupo->alumnosEnGrupoBD()){
     $totalGrupo = $alumnosGrupo->alumnosEnGrupoBD();
    
    foreach($totalGrupo as $indice=>$val){
       
        $this->Cell(20,10,$indice+1,0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["apellidos"]),0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["nombre"]),0,0);
        $this->Cell(40,10,$val["convocatoria"],0,0);
        $this->Cell(40,10,$val["expediente"],0,0);

        $this->Ln();
 }
    
}else{
    
}
    }else{

        $alumnosGrupo= new Grupo("","");
        if($alumnosGrupo->todosAlumnosEnGrupoBD()){
        $alumnosTodos = $alumnosGrupo->todosAlumnosEnGrupoBD();
    foreach($alumnosTodos as $indice=>$val){
       
        $this->Cell(20,10,$indice+1,0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["apellidos"]),0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["nombre"]),0,0);
        $this->Cell(40,10,$val["convocatoria"],0,0);
        $this->Cell(40,10,$val["expediente"],0,0);

        $this->Ln();
    }
 }

}


}


function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','',14);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'',0,0,'C');
}
}