<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
require_once('lib/fpdf/fpdf.php');
require_once("clases/pdf.php");

if(isset($_POST["listar"])){
    global $codigoAsignatura;
    $codigoAsignatura = $_POST['asignaturas'];
    $asig= new matricula($codigoAsignatura,"","","","");
    $matriculadosAsignatura = $asig->alumnosPorMatriculaBD();
}




$pdf = new PDF();

$pdf->SetFont('Arial','',14);

$pdf->AddPage();


$pdf->CuerpoTabla($codigoAsignatura);

$pdf->Output();


?>