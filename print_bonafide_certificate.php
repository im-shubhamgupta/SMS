<?php

require("fpdf/fpdf.php");

include("myfunction.php");

// extract($_REQUEST);
// echo "<pre>";
// print_r($_REQUEST);

ini_set('memory_limit', '-1');

$qset = mysqli_query($con,"select * from setting");

$rset = mysqli_fetch_array($qset);

$sclname = $rset['company_name'];

$scllogo = $rset['company_image'];

$scllogo_path=get_school_details()['company_image_path'];

$scladd = $rset['company_address'];

$sclmob = $rset['company_number'];

$sclemail = $rset['company_email'];
$show_number=get_school_details()['show_number'];
$show_email=get_school_details()['show_email'];


$sid = $_REQUEST['stuid'];

$stuarr = explode(',',$sid);



$pdf = new FPDF('P','mm',array(200,200));


$x=1;
foreach($stuarr as $val){
// echo $x;
	 $key="BC";
	
	$sql1="select * from generate_certificate where certificate_type LIKE 'bonafide'  order by id desc limit 1";
	$q2 = mysqli_query($con,$sql1);
	$r2 = mysqli_fetch_assoc($q2);
	$row2 = mysqli_num_rows($q2);	
	if($row2 > 0){
		$Count2 = substr($r2['certificate_no'], 2);  //return character after 2 words
        if(is_numeric($Count2)){
        	$count=ltrim($Count2,'0');  
        }
		$recptno = $key.str_pad($count+1, 6 , "0", STR_PAD_LEFT);
		$no=mysqli_query($con,"INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('bonafide','$recptno','$val', '".$_SESSION['session']."',now())");
		if(!$no){
				die("Error_description: ".mysqli_error($con));
		}	
	}
	else
	{
		$recptno = $key."000001";
		$sql="INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('bonafide','$recptno','$val', '".$_SESSION['session']."',now())";
		$no=mysqli_query($con,$sql);	
		if(!$no){
			// if(mysqli_error()){
				die("Error_desc: ".mysqli_error($con));
			// }
		}
	}
	$recptno_sch=get_school_details()['company_short_name'].$recptno;

	// $qstu = mysqli_query($con,"select * from students where student_id='$val'");
	$qstu=mysqli_query($con,"select `student_id`,`dob`,`register_no`,stuaddress,`student_name`,father_name,mother_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$val' && stu_status='0'  && sr.session='".$_SESSION['session']."'");

	$rstu = mysqli_fetch_array($qstu);

	$stuname = $rstu['student_name'];

	$gender = $rstu['gender'];

	if($gender=="MALE")

	{

		$gen = "S/O";

		

	}

	if($gender=="FEMALE")

	{

		$gen = "D/O";

		

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



	$msg = "This is to certify that $stuname $gen $FMname has been a bonafide student of our school in $class section $section since $admyear. His Date of Birth is $ndob according to the school Register No. $regno";

	

$pdf->AddPage();

$pdf->SetMargins(5, 5, 5);

$pdf->SetFont('Times','',9);
$pdf->Cell(94,0,'Registration Number :'.get_school_details()['registration_number'].'',0,0,'C');

$pdf->Cell(100,0,'Affiliation No. / UDISE Code :'.get_school_details()['affiliation_number'].'',0,0,'C');

$pdf->Ln(2);

$pdf->SetFont('Times','B',14);

// $pdf->Image('images/profile/'.$scllogo,25,15,25,25);
if(!empty($scllogo_path)){
	$pdf->Image($scllogo_path,25,15,25,25);
}


$pdf->Cell(190,12,$sclname,0,1,'C');
$pdf->SetFont('Times','',5);
$pdf->SetMargins(0, 0, 20);
$pdf->Cell(0,0,'SL No. : '.$recptno_sch,0,1,'R');


$pdf->SetFont('Times','',11);

$pdf->Cell(180,0,$scladd,0,1,'C');

$pdf->SetFont('Arial','B',11);
if(get_school_details()['show_number']=='1'){   //show mobile no if it's 1
   $pdf->Cell(180,12,'M : '.$sclmob,0,1,'C');
} 

if(get_school_details()['show_email']=='1' && $show_number=='1'){   //show email & mobile no if it's 1
   $pdf->Cell(180,0,'Email : '.$sclemail,0,1,'C');

 }elseif(get_school_details()['show_email']=='1'){
	$pdf->Cell(180,12,'Email : '.$sclemail,0,1,'C');
 } 



$pdf->SetMargins(30, 5, 25);

$pdf->Rect(20, 45, 160, 110, 'D');  //create rectangluar box

$pdf->Ln(10);

$pdf->SetFont('Arial','BU',14);



$pdf->Cell(140,30,'BONAFIDE CERTIFICATE',0,1,'C');



$pdf->SetFont('Arial','',12);



$pdf->MultiCell(140,8,$msg,0,'J',false);



$pdf->Ln(12);

$pdf->SetFont('Arial','',11);

$pdf->Cell(140,10,'Address      : '.$stuadd ,0,1,'L');

$pdf->Cell(140,0,'Date            : '.$curdt ,0,1,'L');

$pdf->SetFont('Arial','B',11);

$pdf->Cell(140,10,'Principal',0,1,'R');

$pdf->Ln(12);


$pdf->SetMargins(10, 10, 5);
// $pdf->Ln(18);
// $pdf->SetFont('Arial','',7);
// if($show_number!='1' && $show_email!='1' ){

//     $pdf->Cell(165,20,'SL No. :'.$recptno_sch,0,1,'R');

// }else{
// 	$pdf->Cell(165,0,'SL No. :'.$recptno_sch,0,1,'R');
// }


//insert serial no on db so that its unique
// $pdf->Cell(0,10,'Prepared by: Your Name');





//insert serial no on db so that its unique



$x++;
}//foreach

$pdf->Output();





?>