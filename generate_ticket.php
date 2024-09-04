<?php
require("fpdf/fpdf.php");
include('myfunction.php');extract($_REQUEST);


  // [class] => 10
  //   [section] => 10
  //   [ticket_header] => Exam pattern
  //   [exam] => Mid Nine
  //   [instr] => no
  //   [description] => 
  //   [save] => Generate


$sesQuery = mysqli_query($con,"select year from session where id='".$_SESSION['session']."'");
$sesRow = mysqli_fetch_array($sesQuery);$sessYear=$sesRow['year'];


 $myschool_name=get_school_details()['watermark'];
$qset = mysqli_query($con,"select * from setting");
$rset = mysqli_fetch_array($qset);$sclname = $rset['company_name'];
$scllogo = $rset['company_image'];$scladd = $rset['company_address'];
$sclmob = $rset['company_number'];$sclemail = $rset['company_email'];
$registration_number = $rset['registration_number'];
$affiliation_number = $rset['affiliation_number'];
$clsid = $_REQUEST['class'];$secid = $_REQUEST['section'];
$ticket_header = $_REQUEST['ticket_header'];
$exam = $_REQUEST['exam'];$instr = $_REQUEST['instr'];
$description = nl2br($_REQUEST['description']);
$desc = explode("<br />",$description);
$trm = array_map('trim', $desc);

class PDF_Rotate extends FPDF{
var $angle=0;function Rotate($angle,$x=-1,$y=-1){    
	if($x==-1)        $x=$this->x;  
	if($y==-1)        $y=$this->y;   
	if($this->angle!=0)        $this->_out('Q');    $this->angle=$angle; 
	if($angle!=0)    {  
	    $angle*=M_PI/180;     

	    $c=cos($angle);        $s=sin($angle);    
	                   $cx=$x*$this->k;   
	                        $cy=($this->h-$y)*$this->k;       
	    $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));    }}function _endpage(){    if($this->angle!=0)    {        $this->angle=0;        $this->_out('Q');    }    parent::_endpage();}}


class PDF extends PDF_Rotate{
	
		// public	$school_name=$myschool_name;

	    	function Header(){  
				global $myschool_name;
	    	    $this->SetFont('Arial','B',25);
	    	        $this->SetTextColor(255, 203, 205);	
	    	        $this->SetFillColor(0,0,0);  
	    	        //   $this->RotatedText(50,150,'Magadh Central High School',45);
					
	    	          $this->RotatedText(50,150,$myschool_name,45);
			}

	    function RotatedText($x, $y, $txt, $angle){    
	        $this->Rotate($angle,$x,$y); 
	          $this->Text($x,$y,$txt);  
	            $this->Rotate(0);}}

$pdf = new PDF('P','mm',array(200,250));

	
	$qstu = mysqli_query($con,"select `student_id`,`student_name`,`stu_image`,`gender`,`father_name`,`mother_name`,`register_no`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`roll_no` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where sr.class_id='$clsid' && sr.section_id='$secid' && stu_status='0' && `sr`.`session`='".$_SESSION['session']."'  order by sr.roll_no asc");
	while($res = mysqli_fetch_array($qstu))
	{
			$stuname = $res['student_name'];
	    $gender = $res['gender'];	$student_id = $res['student_id'];		$stu_image = $res['stu_image'];
			
		//generate serial no-------------------------------------------------------------------------------------
	    $type='admit-card';
	    $key='AC';
			$sql1="select * from generate_certificate where certificate_type LIKE '$type'  order by id desc limit 1";
			$q2 = mysqli_query($con,$sql1);
			$r2 = mysqli_fetch_assoc($q2);
			$row2 = mysqli_num_rows($q2);	
			if($row2 > 0){
				$Count2 = substr($r2['certificate_no'], 2);  //return character after 2 words
		        if(is_numeric($Count2)){
		        	$count=ltrim($Count2,'0');  
		        }
				$recptno = $key.str_pad($count+1, 6 , "0", STR_PAD_LEFT);
				$no=mysqli_query($con,"INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$student_id', '".$_SESSION['session']."',now())");
				if(!$no){
						die("Error_description: ".mysqli_error($con));
				}	
			}
			else
			{
				$recptno = $key."000001";
				$sql="INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$student_id', '".$_SESSION['session']."',now())";
				$no=mysqli_query($con,$sql);	
				if(!$no){
					// if(mysqli_error()){
						die("Error_desc: ".mysqli_error($con));
					// }
				}
			}
		$recptno_sch=get_school_details()['company_short_name'].$recptno;	
		//generate serial no----------------------------------------------------------------------------------


	if($gender=="MALE")
	{
		$gen = "S/o";
		
	}
	if($gender=="FEMALE")
	{
		$gen = "D/o";
		
	}
	
	$fname = $res['father_name'];
	$mname = $res['mother_name'];
	$roll_no = $res['roll_no'];
	$student_image_path=getStudent_byStudent_id($student_id)['stu_image_path'];
	$clid = $res['class_id'];
	$qc = mysqli_query($con,"select * from class where class_id='$clid'");
	$rc = mysqli_fetch_array($qc);
	$class = $rc['class_name'];
	
	$secid = $res['section_id'];
	$qs = mysqli_query($con,"select * from section where section_id='$secid'");
	$rs = mysqli_fetch_array($qs);
	$section = $rs['section_name'];

	$regno = $res['register_no'];
	
	

$pdf->AddPage();
$pdf->SetMargins(15, 5, 5);
$pdf->Rect(10, 10, 180, 230, 'D');

//$pdf->Rect(11, 11, 27, 33, 'D');
if(!empty($scllogo) && file_exists('images/profile/'.$scllogo)){
	$pdf->Image('images/profile/'.$scllogo,12,19,25);$pdf->SetFont('Times','B',16);
}

// -------------------------------------
$pdf->SetFont('Times','',9);
$pdf->Cell(94,10,'Registration Number :'.get_school_details()['registration_number'].'',0,0,'C');

$pdf->Cell(100,10,'Affiliation No. / UDISE Code :'.get_school_details()['affiliation_number'].'',0,0,'C');

$pdf->Ln(6);
// -------------------------------
$pdf->SetFont('Times','B',14);
$pdf->Cell(0,12,$sclname,0,0,'C');
// $pdf->SetFont('Times','B',8); $pdf->Cell(50,12,'Reg No: '.$registration_number,0,0,'R');
$pdf->Ln(16);
$pdf->SetFont('Times','',12);
$pdf->Cell(180,0,$scladd,0,0,'C');$pdf->Ln(10);
$pdf->SetFont('Times','',12);$pdf->Cell(180,0,'SESSION: '.$sessYear,0,0,'C');

$pdf->Ln(20);
// if(!empty($stu_image)){$pdf->Image('images/student/'.str_replace('/','-',$regno).'/'.$stu_image, 150,70,30);}
// $pdf->Image($student_image_path, 150,70,40);
$pdf->Image($student_image_path,150,68,25,25);
$pdf->SetFont('Times','B',13);
//$pdf->Rect(82, 50, 45, 10, 'D');
$pdf->Cell(170,5,$ticket_header,0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Times','',10);
$pdf->Cell(70,6,'Register Number : '.$regno,0,0,'L');
$pdf->Cell(70,6,'Name : '.$stuname,0,0,'L');$pdf->Ln(6);
$pdf->Cell(70,6,'Class : '.$class ,0,0,'L');$pdf->Cell(70,6,' Section : '.$section,0,0,'L');$pdf->Ln(6);
$pdf->Cell(70,6,'Fathers Name : '.$fname,0,0,'L');$pdf->Cell(70,6,'Roll No. : '.$roll_no,0,0,'L');$pdf->Ln(6);
$pdf->Cell(70,6,'Mothers Name : '.$mname,0,0,'L');
$pdf->SetMargins(10, 0, 0);

$pdf->Ln(15);

$pdf->Cell(180,8,'Time Table', 1,1, 'C');

$x = $pdf->GetX();
$pdf->Cell(20,6,'Sl.No.', 1,0,'C');
$pdf->Cell(40,6,'Subject', 1,0,'C');
$pdf->Cell(40,6,'Date', 1,0,'C');
$pdf->Cell(40,6,'Time', 1,0,'C');
$pdf->Cell(40,6,'R.I. Sign', 1,1,'C');

$pdf->SetFont('Times','',10);

$qs = mysqli_query($con,"select * from test where class_id='$clid' && section_id='$secid' && test_name='$exam' && session='".$_SESSION['session']."'");
	$sr = 1;
	while($rs = mysqli_fetch_array($qs))
	{
		$subjectid = $rs['subject_id'];
		$qsub = mysqli_query($con,"select * from subject where subject_id='$subjectid'");
		$rsub = mysqli_fetch_array($qsub);
		$subname = $rsub['subject_name'];
		
		$tdate = $rs['test_date'];
		$chgdt = date("d-m-Y",strtotime($tdate));
		$sttime = $rs['starttime'];
		$stime = date("h:iA",strtotime($sttime));
		$entdate = $rs['endtime']; 
		$etime = date("h:iA",strtotime($entdate));
		
	$pdf->Cell(20,6,$sr, 1,0,'C');
	$pdf->Cell(40,6,$subname, 1,0,'C');
	$pdf->Cell(40,6,$chgdt, 1,0,'C');
	$pdf->Cell(40,6,$stime." To ".$etime, 1,0,'C');
	$pdf->Cell(40,6,'', 1,1,'C');
	$sr++;
	}

	
if($instr=="yes")
{
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(180,8,'Instructions : ',0,1,'L');
	$pdf->SetFont('Times','B',10);
	foreach($trm as $k)
	{
	$pdf->Cell(180,5,$k,0,1,'L');
	}
	$pdf->Cell(180,0,'',1,1,'L');
}	

	$pdf->Ln(30);
	$pdf->SetFont('Times','',10);
	$pdf->Cell(90,10,'Signature of Exam Controller',0,0,'L');
	$pdf->Cell(90,10,'Signature of Principal',0,0,'R');


$pdf->Ln(21);
$pdf->SetY(229);
$pdf->SetFont('Arial','',7);
$pdf->Cell(178,0,'SL No. : '.$recptno_sch,0,1,'R');
$pdf->SetMargins(10, 10, 5);  //effect on next page top
	}//while
	
$pdf->Output();


?>
