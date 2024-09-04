<?php
require("fpdf/fpdf.php");
include("connection.php");
extract($_REQUEST);

$qset = mysqli_query($con,"select * from setting");
$rset = mysqli_fetch_array($qset);
$sclname = $rset['company_name'];
$scllogo = $rset['company_image'];
$scladd = $rset['company_address'];
$sclmob = $rset['company_number'];
$sclemail = $rset['company_email'];

$sid = $_REQUEST['stuid'];
$stuarr = explode(',',$sid);

$pdf = new FPDF('P','mm',array(200,200));

foreach($stuarr as $val)
{
	$qstu = mysqli_query($con,"select * from students where student_id='$val'");
	$rstu = mysqli_fetch_array($qstu);
	$stuname = $rstu['student_name'];
	$gender = $rstu['gender'];
	if($gender=="MALE")
	{
		$gen = "S/o";
		
	}
	if($gender=="FEMALE")
	{
		$gen = "D/o";
		
	}
	
	$fname = $rstu['father_name'];
	
	$clid = $rstu['class_id'];
	$qc = mysqli_query($con,"select * from class where class_id='$clid'");
	$rc = mysqli_fetch_array($qc);
	$class = $rc['class_name'];
	
	$secid = $rstu['section_id'];
	$qs = mysqli_query($con,"select * from section where section_id='$secid'");
	$rs = mysqli_fetch_array($qs);
	$section = $rs['section_name'];
	
	$admyear = $rstu['academic_year'];
	$dob = $rstu['dob'];
	$ndob = date("d-m-Y",strtotime($dob));
	
	$parentmob = $rstu['parent_no'];
	$stuadd = $rstu['stuaddress'];
	$curdt = date("d-m-Y");
	$bloodgrp = $rstu['blood_grp'];
	$pic = $rstu['stu_image'];
	
	$regno = $rstu['register_no'];

$pdf->AddPage();
$pdf->SetFont('Times','B',9);
$pdf->Rect(10, 10, 90, 68, 'D');
$pdf->Image('images/profile/'.$scllogo,12,11,17,19);
$pdf->Cell(110,10,$sclname,0,1,C);

$pdf->SetFont('Times','',9);
$pdf->Cell(110,0,$scladd,0,1,C);
$pdf->Cell(110,9,'Phone : '.$sclmob,0,1,C);
$pdf->Cell(110,0,'Email : '.$sclemail,0,1,C);
$pdf->Ln(4);
$pdf->Cell(90,0,'',1,1,C);

$pdf->Ln(3);
$pdf->SetFont('Times','',9);
$pdf->Image('images/student/'.$regno.'/'.$pic,12,36,20,25);

$pdf->SetMargins(12,0, 0);
$pdf->Cell(24,0,'',0,0,L);
$pdf->Cell(158,5,'Name :    '.$stuname,0,1,L);
$pdf->Cell(22,0,'',0,0,L);
$pdf->Cell(158,5,'Register No. :  	'.$regno,0,1,L);
$pdf->Cell(22,0,'',0,0,L);
$pdf->Cell(158,5,'Class / Sec : 	 '.$class.' - '.$section,0,1,L);
$pdf->Cell(22,0,'',0,0,L);
$pdf->Cell(158,5,'Parent Mobile : 	 '.$parentmob,0,1,L);
$pdf->Cell(22,0,'',0,0,L);
$pdf->Cell(82,5,'Date Of Birth : 	 '.$ndob,0,1,L);
$pdf->Cell(22,0,'',0,0,L);
$pdf->Cell(82,5,'Blood Group : 	 '.$bloodgrp,0,1,L);
$pdf->Cell(1,0,'',0,0,L);
$pdf->MultiCell( 82,5,'Address : 	 '.$stuadd,0,1);
$pdf->Ln(15);
$pdf->SetMargins(10, 10);

}


$pdf->Output();


?>