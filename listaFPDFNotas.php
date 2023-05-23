<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
require_once('lib/fpdf/fpdf.php');
require_once("clases/pdfBoletin.php");
include_once("clases/matricula.php");
global $expediente;
global $curso;
if(isset($_GET["exp"])&&isset($_GET["curso"])){
    
    $expediente = $_GET["exp"];
    $curso = $_GET["curso"];

    
}

if(isset($_POST["alumnos"])){
    if($_POST["alumnos"]==""){
        $expediente = "todos";
    }else{
        $expediente = $_POST["alumnos"];
    }
    $curso = $_SESSION["curso"];

    
}



if($expediente=="todos"){
    $selAluBol = new Matricula("","","","",$curso);
    if($selAluBol->expedientesConMatBD()){
       $aluBol = $selAluBol->expedientesConMatBD();
      

      
    }
    $pdf = new PDF();

    $pdf->SetFont('Arial','',14);
    foreach($aluBol as $val){
       $expediente= $val["expediente"];
        $pdf->AddPage();
        $pdf->CuerpoTabla($expediente);
        
       
    }
    $pdf->Output();
   
    


}else{
    $pdf = new PDF();

    $pdf->SetFont('Arial','',14);
    
    $pdf->AddPage();
    
    
    $pdf->CuerpoTabla($expediente);
    
    $pdf->Output();
}

?>