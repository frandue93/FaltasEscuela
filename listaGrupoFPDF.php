<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
require_once('lib/fpdf/fpdf.php');
require_once("clases/pdfGrupo.php");
require_once("clases/grupo.php");



if(isset($_GET["k"])){
    global $codigo_Grupo;
    $codigo_Grupo = $_GET["k"];

    $grup=new Grupo($codigo_Grupo,"");
    $alumnosEnGrupo = $grup->alumnosEnGrupoBD();

}





$pdf = new PDF();

$pdf->SetFont('Arial','',14);

$pdf->AddPage();


$pdf->CuerpoTabla($codigo_Grupo);

$pdf->Output();


?>