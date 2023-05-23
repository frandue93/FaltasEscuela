<?php require_once('./lib/fpdf/fpdf.php');
   require_once("clases/matricula.php");
   require_once("clases/alumno.php");
   require_once("clases/asignatura.php");
   require_once("clases/faltas.php");

class PDF extends FPDF{

function header(){
   global $codigoAsignatura;
   $this->SetFont('Arial','B',14);
    $this->Image("./imagenes/logoMusica.PNG",10,9,33);
    $this->Cell(50,10,"",0,0);
    $this->Cell(110,10,"LISTADO DE ALUMNOS POR ASIGNATURA",1,0);
    $this->Ln();
    $this->Cell(50,10,"",0,0);
    $this->Cell(20,10,UTF8_DECODE("Año escolar ").$_SESSION["curso"],0,0);
    $this->Ln();
    $asig = new Asignatura($codigoAsignatura,"","");
    if($asig->buscarAsignaturaBD()){
    $buscar = $asig->buscarAsignaturaBD();
    $this->Cell(50,10,"",0,0);
    $this->Cell(20,10,UTF8_DECODE($buscar["nombre"]),0,0);
    }else{
        $this->Cell(50,10,"",0,0);
        $this->Cell(20,10,UTF8_DECODE("TODOS ALUMNOS"),0,0);
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



function CuerpoTabla($codigoAsignatura){

    $mat= new Matricula($codigoAsignatura,"","","","");
    if($codigoAsignatura!=""){
    if($mat->alumnosPorMatriculaBD()){
     $matriculadosAsignatura = $mat->alumnosPorMatriculaBD();
    
    foreach($matriculadosAsignatura as $indice=>$val){
       
        $this->Cell(20,10,$indice+1,0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["apellidoAlumno"]),0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["nombreAlumno"]),0,0);
        $this->Cell(40,10,$val["convocatoria"],0,0);
        $this->Cell(40,10,$val["expediente"],0,0);

        $this->Ln();
 }
    
}else{
    
}
    }else{

    $matriculados = $mat->todosAlumnosBD();
    
    foreach($matriculados as $indice=>$val){
       
        $this->Cell(20,10,$indice+1,0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["apellidoAlumno"]),0,0); 
        $this->Cell(40,10,UTF8_DECODE($val["nombreAlumno"]),0,0);
        $this->Cell(40,10,$val["convocatoria"],0,0);
        $this->Cell(40,10,$val["expediente"],0,0);

        $this->Ln();
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