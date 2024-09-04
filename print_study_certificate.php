<?php

require("fpdf/fpdf.php");

include('myfunction.php');

extract($_REQUEST);

// ob_end_clean();

$qset = mysqli_query($con,"select * from setting");

$rset = mysqli_fetch_array($qset);

$sclname = $rset['company_name'];

$scllogo = $rset['company_image'];
$scllogo_path=get_school_details()['company_image_path'];
$scladd = $rset['company_address'];

$sclmob = $rset['company_number'];

$sclemail = $rset['company_email'];
$show_number = $rset['show_number'];
$show_email = $rset['show_email'];



$sid = $_REQUEST['stuid'];

$stuarr = explode(',',$sid);



$pdf = new FPDF('P','mm',array(200,250));



foreach($stuarr as $val){
$type='study';
$key="SC";
	$sql1="select * from generate_certificate where certificate_type LIKE '$type'  order by id desc limit 1";
	$q2 = mysqli_query($con,$sql1);
	$r2 = mysqli_fetch_assoc($q2);
	$row2 = mysqli_num_rows($q2);	
	if($row2 > 0){
		$Count2 = substr($r2['certificate_no'], 2);  //return character after 4 words
        if(is_numeric($Count2)){
        	$count=ltrim($Count2,'0');  
        }
		$recptno = $key.str_pad(intval($count)+1, 6 , "0", STR_PAD_LEFT);
		mysqli_query($con,"INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$val', '".$_SESSION['session']."',now())");
	}
	else
	{
		$recptno = $key."000001";
		$sql="INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno', '$val','".$_SESSION['session']."',now())";
		$no=mysqli_query($con,$sql);	
		if(!$no){
			// if(mysqli_error()){
				die("Error_desc: ".mysqli_error($con));
			// }
		}
	}
	$recptno_sch=get_school_details()['company_short_name'].$recptno;


	// $qstu = mysqli_query($con,"select * from students where student_id='$val'");
	$qstu=mysqli_query($con,"select `student_id`,dob,`register_no`,stuaddress,`student_name`,father_name,mother_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$val' && stu_status='0'  && sr.session='".$_SESSION['session']."'");


	$rstu = mysqli_fetch_array($qstu);

	$stuname = $rstu['student_name'];

	$gender = $rstu['gender'];

	if($gender=="MALE")

	{

		$gen = "S/O";

		$m = "Mr.";

	}

	if($gender=="FEMALE")

	{

		$gen = "D/O";

		$m = "Miss";

	}

	

	// $fname = $rstu['father_name'];
	if(!empty($rstu['father_name']) && !empty($rstu['mother_name'])){
		$FMname = $rstu['father_name'].' / '. $rstu['mother_name'];
	}elseif(!empty($rstu['mother_name']) && empty($rstu['father_name']) ){
		$FMname =  $rstu['mother_name'];
	}elseif(empty($rstu['mother_name']) && !empty($rstu['father_name'])) {
		$FMname =  $rstu['father_name'];
	}
	else{
		$FMname =  $rstu['father_name'];
	}

	

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

	$dob = $rstu['dob'];

	$ndob = date("d-m-Y",strtotime($dob));

	

	$stuadd = $rstu['stuaddress'];

	$curdt = date("d-m-Y");

	

	$regno = $rstu['register_no'];  

	

	$msg = "This is to certify that $m $stuname $gen $FMname is a student of this school studying in $class Section $section in the Academic year $admyear Register number of $stuname is $regno and his date of birth is $ndob The conduct of $stuname during the period of study in our school is very good.";

	

$pdf->AddPage();

$pdf->SetMargins(15, 5, 5);

$pdf->Rect(10, 10, 180, 230, 'D');

//----------------
$pdf->Ln(3);
$pdf->SetFont('Times','',9);

$pdf->Cell(100,0,'Registration Number :'.get_school_details()['registration_number'].'',0,0,'L');
$pdf->Cell(50,0,'Affiliation No. / UDISE Code :'.get_school_details()['affiliation_number'].'',0,0,'C');

$pdf->Ln(2);

//--------------

$pdf->SetFont('Times','B',16);

// $pdf->Image('images/profile/'.$scllogo,12,12,25);
if(!empty($scllogo_path)){
	$pdf->Image($scllogo_path,25,18,25,25);
}


$pdf->Cell(180,12,$sclname,0,1,'C');

$pdf->SetFont('Times','',5);
// $pdf->SetMargins(0, 0, 14);
$pdf->Cell(320,0,'SL No. : '.$recptno_sch,0,1,'C');


$pdf->SetFont('Times','',11);

$pdf->Cell(160,0,$scladd,0,1,'C');
if($show_number=='1'){ 
   $pdf->Cell(160,12,'M : '.$sclmob,0,1,'C');
}else{
	$pdf->Cell(160,12,'',0,1,'C');
} 
if($show_email=='1'){ 
$pdf->Cell(160,0,'Email : '.$sclemail,0,1,'C');
}else{
	$pdf->Cell(160,12,'',0,1,'C');
}
$pdf->Rect(10, 55, 180, 1, 'F');



$pdf->Ln(20);

$pdf->Cell(170,25,'Date : '.$curdt,0,1,'R');

$pdf->SetFont('Courier','BU',16);

$pdf->Cell(180,5,'STUDY CERTIFICATE',0,1,'C');







$pdf->Ln(10);

$pdf->SetFont('Courier','B',14);



$pdf->MultiCell(170,8,$msg,0,'J',false);



$pdf->Ln(35);

$pdf->SetFont('Courier','B',14);

$pdf->Cell(8);

$pdf->Cell(160,10,'Head of the School',0,1,'R');

 $pdf->SetY(180);


$pdf->Ln(30);
// $pdf->SetFont('Arial','',7);
// $pdf->Cell(172,0,'SL No. : '.$recptno_sch,0,1,'R');
$pdf->SetMargins(10, 10, 5);

}

$pdf->Output();





?>