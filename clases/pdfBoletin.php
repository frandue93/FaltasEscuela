<?php require_once('./lib/fpdf/fpdf.php');
   require_once("clases/matricula.php");
   require_once("clases/alumno.php");
   require_once("clases/asignatura.php");
   require_once("clases/faltas.php");
   require_once("clases/grupo.php");

class PDF extends FPDF{

function header(){
    global $expediente;
    global $curso;
    $al = new Alumno($expediente,"","","","","","","","","","","");
    $alumno = $al->buscarAlumnoBD();
    $gr = new Grupo($alumno["codigo_G"],"");
    $grupo = $gr->buscarGrupoBD();

    $this->Line(60,10,180,10);
    $this->Line(60,10,60,40);
    $this->Line(60,40,180,40);
    $this->Line(180,10,180,40);
    $this->SetFont('Arial','B',14);
    $this->Image("./imagenes/logoMusica.PNG",10,9,33);
    $this->Cell(50,10,"",0,0);
    $this->Cell(110,10,UTF8_DECODE("NOTAS ALUMNO: ".$alumno["nombre"]." ".$alumno["apellidos"]),0,0);
    $this->Ln();
    $this->Cell(50,10,"",0,0);
    $this->Cell(20,10,UTF8_DECODE("CURSO ESCOLAR: ".$curso),0,0);
    $this->Ln();
    $this->Cell(50,10,"",0,0);
    $this->Cell(20,10,UTF8_DECODE("GRUPO: ".$grupo["nombre"]));
    $this->Ln();

    
    $this->Ln();
    $this->Cell(60,10,'ASIGNATURAS',0,0);
    $this->Cell(30,10,'NOTAS:',0,0);
    $this->Cell(20,10,'EV.1',0,0);
    $this->Cell(20,10,'EV.2',0,0);
    $this->Cell(20,10,'EV.3',0,0);
    $this->Cell(20,10,'FINAL',0,0);
    $this->Line(10,60,180,60);
    $this->Ln();
    
}



function CuerpoTabla($expediente){
   global $curso;
    $bol= new matricula("","","",$expediente,$curso,"","","","","");
    $boletin = $bol->matriculasPorAlumnoBD();
    $cont = 80;
    $this->Ln();
    foreach($boletin as $val){
       
        $this->Cell(20,10,UTF8_DECODE($val["nombreAsignatura"]));
        if($val["nota1"]!=-1){
            $this->Cell(75,10,"",0,0);
            $this->Cell(20,10,UTF8_DECODE($val["nota1"]));
        }
        if($val["nota2"]!=-1){
            $this->Cell(20,10,UTF8_DECODE($val["nota2"]));
        }
        if($val["nota3"]!=-1){
            $this->Cell(20,10,UTF8_DECODE($val["nota3"]));
        }
        if($val["notaFin"]!=-1){
            $this->Cell(20,10,UTF8_DECODE($val["notaFin"]));
        }

        $this->Ln();
        $cont+=10;
    }
    $this->Line(10,$cont,70,$cont);
    $this->Ln();
    $this->Cell(20,10,'*Las asignaturas se consideran aprovadas a partir de un 5',0,0);
    
    
    
    
}


function Footer()
{
    global $expediente;
    $al = new Alumno($expediente,"","","","","","","","","","","");
    $alumno = $al->buscarAlumnoBD();
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','',14);
    // Número de página
    $this->Line(10,270,180,270);
    $this->Cell(0,10,UTF8_DECODE('Alumno: '.$alumno["nombre"]." ".$alumno["apellidos"]),0,'','C',0);
}
}