<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
require_once('lib/fpdf/fpdf.php');
require_once("clases/pdfFaltas.php");
global $expedienteAlum;
if(isset($_POST["listarF"])){
    
    $expedienteAlum = $_POST['alumnos'];
   

}

$pdf = new PDF();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();


$pdf->CuerpoTabla($expedienteAlum);

$pdf->Output();
?>