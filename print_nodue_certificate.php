<?php
require("fpdf/fpdf.php");
include("myfunction.php");
extract($_REQUEST);

$qset = mysqli_query($con,"select * from setting");
$rset = mysqli_fetch_array($qset);
$sclname = $rset['company_name'];
$scllogo = $rset['company_image'];
$scladd = $rset['company_address'];
$sclmob = $rset['company_number'];
$sclemail = $rset['company_email'];

$sid = $_REQUEST['student'];

$pdf = new FPDF('P','mm',array(210,280));

	// $qstu = mysqli_query($con,"select * from students where student_id='$sid'");
	 $sql1="select `student_id`,religion_id,student_contact,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where  student_id='$sid' and sr.session='".$_SESSION['session']."' "; 
	$qstu=mysqli_query($con,$sql1);
	$rstu = mysqli_fetch_array($qstu);

	// echo "<pre>";
	// print_r($rstu);
	// echo "</pre>";

	// die;
	$stuname = $rstu['student_name'];
		
	$clid = $rstu['class_id'];
	$qc = mysqli_query($con,"select * from class where class_id='$clid'");
	$rc = mysqli_fetch_array($qc);
	$class = $rc['class_name'];
	
	$secid = $rstu['section_id'];
	$qs = mysqli_query($con,"select * from section where section_id='$secid'");
	$rs = mysqli_fetch_array($qs);
	$section = $rs['section_name'];
	
	// $admyear = $rstu['academic_year'];
	$admyear = getSessionByid($rstu['session'])['year'];
	$mobile = $rstu['student_contact'];
	$regno = $rstu['register_no'];
	$curdate = date("d-M-Y");
	
$pdf->AddPage();
$pdf->SetMargins(5, 5, 5);
$pdf->SetFont('Times','B',14);
$pdf->Image('images/profile/'.$scllogo,35,5,25);
$pdf->Cell(190,12,$sclname,0,1,'C');

$pdf->SetFont('Times','',11);
$pdf->Cell(180,0,$scladd,0,1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(180,12,'M : '.$sclmob,0,1,'C');
$pdf->Cell(180,0,'Email : '.$sclemail,0,1,'C');


$pdf->SetMargins(15, 5, 25);
$pdf->Rect(10, 38, 190, 110, 'D');

$pdf->SetFont('Arial','BU',14);
$pdf->Cell(200,25,'LIBRARY NO-DUES CERTIFICATE',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(90,0,'Student Name : '.$stuname ,0,0,'L');
$pdf->Cell(90,0,'Enrollment No : '.$regno ,0,1,'L');
$pdf->Cell(90,15,'Session : '.$admyear ,0,0,'L');
$pdf->Cell(90,15,'Class : '.$class.' '.$section,0,1,'L');
$pdf->Cell(90,0,'Mobile No: '.$mobile ,0,0,'L');

$pdf->Ln(18);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(140,0,'This is to certify that, as on '.$curdate.', there are no library items or penalty due from',0,1,'L');
$pdf->Cell(140,10,'this student.',0,1,'L');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(150,15,'Date : ',0,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,15,'Signature',0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(150,0,'',0,0,'L');
$pdf->Cell(140,0,'(Librarian)',0,1,'L');

$pdf->Output();


?>