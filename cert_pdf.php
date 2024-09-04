<?php
require('fpdf/fpdf.php');
include('connection.php');
extract($_REQUEST);

$lastid = $_REQUEST['id'];
$q1 = mysqli_query($con,"select * from certificate_download where id='$lastid'");
$r1 = mysqli_fetch_array($q1);
$image = $r1['cert_name'];
$filename = basename($image,".jpg");

$pdf=new FPDF();
$pdf->AddPage('L','A5', 0);
$pdf->Image('pic/certificates/'.$image,0,0,210,150);
$pdf->Output($filename.'.pdf','D');
?>