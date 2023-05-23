<?php require_once('./lib/fpdf/fpdf.php');
   require_once("clases/matricula.php");
   require_once("clases/alumno.php");
   require_once("clases/asignatura.php");
   require_once("clases/faltas.php");

class PDF extends FPDF{

function header(){
  
   $this->SetFont('Arial','B',14);
    $this->Image("./imagenes/logoMusica.PNG",10,9,33);
    $this->Cell(50,10,"",0,0);
    $this->Cell(110,10,"LISTADO FALTAS ALUMNO(desde 1 falta",1,0);
    $this->Ln();
    $this->Cell(50,10,"",0,0);
    $this->Cell(20,10,UTF8_DECODE("CURSO ESCOLAR: ").$_SESSION["curso"],0,0);
    $this->Ln();

    
    $this->Ln();
    $this->Cell(20,10,'EXP.',0,0);
    $this->Cell(40,10,'APELLIDOS',0,0);
    $this->Cell(40,10,'NOMBRE',0,0);
    $this->Line(10,50,150,50);
    $this->Ln();
    
}



function CuerpoTabla($expedienteAlum){
    global $expedienteAlum;
    $fal= new Falta("","",$expedienteAlum,"","","");
    
    if($expedienteAlum != ""){
    if($fal->alumnoSelConFaltas()){
     $alFal = $fal->alumnoSelConFaltas();
   
        $this->Cell(40,10,UTF8_DECODE($alFal["exp"]),0,0); 
        $this->Cell(40,10,UTF8_DECODE($alFal["apellidos"]),0,0);
        $this->Cell(40,10,UTF8_DECODE($alFal["nombre"]),0,0);
        $this->Ln();
    
    

    $this->SetFont('Arial','B',14);
    
    $this->Cell(100,10,'',0,0);
    $this->Cell(20,10,'FECHA',0,0);
    $this->Cell(40,10,'FALTA',0,0);
    $this->Line(100,70,160,70);
    $this->SetFont('Arial','',14);
    $this->Ln();
        $falAl = $fal->mostrarFaltasBD();
        foreach($falAl as $val){
            $this->Cell(70,10,'',0,0);
            $this->Cell(20,10,UTF8_DECODE($val["nombreAsignatura"]),0,0); 
            $this->Cell(40,10,UTF8_DECODE($val["fecha"]),0,0); 
            $this->Cell(40,10,UTF8_DECODE($val["tipo"]),0,0); 
            $this->Ln();
        }
    }
        
    }else{
        $todAl = new Falta("","","","","","");
        $todAlFal = $todAl->alumnosConFaltas();
        $cont=70;
        foreach($todAlFal as $valA){
            

            $this->Cell(40,10,UTF8_DECODE($valA["expediente"]),0,0); 
            $this->Cell(40,10,UTF8_DECODE($valA["apellidos"]),0,0);
            $this->Cell(40,10,UTF8_DECODE($valA["nombre"]),0,0);
            $this->Ln();
        
        
    
        $this->SetFont('Arial','B',14);
        
        $this->Cell(100,10,'',0,0);
        $this->Cell(20,10,'FECHA',0,0);
        $this->Cell(40,10,'FALTA',0,0);
        $this->Line(100,$cont,160,$cont);
        $cont+=20;
        $this->SetFont('Arial','',14);
        $this->Ln();
             $fal = new Falta("","",$valA["expediente"],"","","");
            $falAl = $fal->mostrarFaltasBD();
            foreach($falAl as $val){
                $cont+=10;
                $this->Cell(70,10,'',0,0);
                $this->Cell(20,10,UTF8_DECODE($val["nombreAsignatura"]),0,0); 
                $this->Cell(40,10,UTF8_DECODE($val["fecha"]),0,0); 
                $this->Cell(40,10,UTF8_DECODE($val["tipo"]),0,0); 
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