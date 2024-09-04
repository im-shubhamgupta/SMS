<?php

// include('connection.php');
include('myfunction.php');

include('tcpdf/tcpdf.php');

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





$pdf = new TCPDF();



foreach($stuarr as $val){
	$type='transfer';
	$key='TC';

	$sql1="select * from generate_certificate where certificate_type LIKE '$type'  order by id desc limit 1";
	$q2 = mysqli_query($con,$sql1);
	$r2 = mysqli_fetch_assoc($q2);
	$row2 = mysqli_num_rows($q2);	
	if($row2 > 0){
		$Count2 = substr($r2['certificate_no'], 2);  //return character after 4 words
        if(is_numeric($Count2)){
        	$count=ltrim($Count2,'0');  
        }
		$recptno = $key.str_pad($count+1, 6 , "0", STR_PAD_LEFT);
		$no=mysqli_query($con,"INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$val', '".$_SESSION['session']."',now())");
		if(!$no){
		   die("Error_description: ".mysqli_error($con));
		}
	}
	else
	{
		$recptno = $key."000001";
		$sql="INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno', '$val','".$_SESSION['session']."',now())";
		$no=mysqli_query($con,$sql);	
		if(!$no){
			// if(mysqli_error()){
				die("Error__desc: ".mysqli_error($con));
			// }
		}
	}
	$recptno_sch=get_school_details()['company_short_name'].$recptno;



	// $qstu = mysqli_query($con,"select * from students where student_id='$val'");
	$qstu=mysqli_query($con,"select `student_id`,dob,admission_date,`register_no`,soc_cat_id,stuaddress,religion_id,`student_name`,father_name,mother_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$val' && stu_status='0'  && sr.session='".$_SESSION['session']."'");


	$rstu = mysqli_fetch_array($qstu);

	$stuname = $rstu['student_name'];

	$gender = $rstu['gender'];

	if($gender=="MALE")

	{

		$gen = "S/o";

		$m = "Mr.";

	}

	if($gender=="FEMALE")

	{

		$gen = "D/o";

		$m = "Miss";

	}

	

	$fname = $rstu['father_name'];

	$mname = $rstu['mother_name'];

	

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

	$ndob = date("d-M-Y",strtotime($dob));

	

	$stuadd = $rstu['stuaddress'];

	$curdt = date("d-m-Y");

	

	$regno = $rstu['register_no'];

	$admdt = $rstu['admission_date'];

	$nadmdt = date("d-m-Y",strtotime($admdt));

	$relid = $rstu['religion_id'];

	$qr = mysqli_query($con,"select * from religion where religion_id='$relid'");

	$rr = mysqli_fetch_array($qr);

	$religion = $rr['religion_name'];

	$scatid = $rstu['soc_cat_id'];

	$qsc = mysqli_query($con,"select * from social_category where soc_cat_id='$scatid'");

	$rsc = mysqli_fetch_array($qsc);

	$socialcat = $rsc['soc_cat_name'];

	

$pdf->SetMargins(19, 12, 19, true);

$pdf->AddPage('P', 'A4');

// TC No.: 19031008412568 <br/>
// <div >Academic year: '.getSessionByid($_SESSION['session'])[year].'</div>

// <p><span align="center" style="font-size:11px;font-weight:bold;color:green">'.$sclname.' <br/> </span><span style="font-size:10px">'.$scladd.'</span></p>

// <h4 align="center" style="color:green">SCHOOL TRANFER CERTIFICATE</h4>



$html ='<div style="border: 1px solid black;"> 

<table  cellpadding="6"   style="font-size:8px;">
<tr>
	<td><span>Registration Number : '.get_school_details()['registration_number'].' </span>

	</td>
	<td style="width=200px;">
	      <span>Affiliation No. / UDISE Code :'.get_school_details()['affiliation_number'].' </span></td>
	
</tr>
</table>
<div><span style="text-align:right;font-size:5px;" >SL No. : '.$recptno_sch.'</span>
</div>

<table  cellpadding="6"  style="1px solid black">
<tr>

<td >      <img src="images/profile/'.$scllogo.'" style="width:60px; height:60px;"></td>

<td><p >	<span align="center" style="font-size:11px;font-weight:bold;color:green">'.$sclname.' <br/>
 </span><span style="font-size:10px">'.$scladd.'</span><br/>';
 if(get_school_details()['show_number']=='1'){ 
      $html.='<span align="center" style="font-size:10px;">'.$sclmob.'</span><br/>';
 }else{
	// $html.='<br/>';
 } 
 if(get_school_details()['show_email']=='1'){  
$html.=' <span align="center" style="font-size:10px; ">         '.$sclemail.'</span><br/>';
 }
 $html.='</p>';





$html.='</td>
<td></td>
</tr>';
	
$html.='</table>';


$html .='<br>';

// $html .='</div><div style="font-size:9px;">
$html .='


<table border="1" cellpadding="6" style="font-size:8px;">

<tr>

<td> 1. Register No. <br><b>'.$regno.'</b></td>

<td> 13. Standard in which the student is studying at the time of leaving the School<br/><b>'.$class.'</b></td>

</tr>

<tr>

<td> 2. Date of Admission To School <br/><b>'.$nadmdt.'</b></td>

<td> 14. Student opted Subject <br/>

 a) Languages Studied : <br/>

 b) Elective Studied : </td>

</tr>

<tr>

<td> 3. Name of the Student in full <br/><b>'.$stuname.'</b></td>

<td> 15. Medium of Instructions <br/><b>English</b></td>

</tr>

<tr>

<td> 4. Sex <br/><b>'.$gender.'</b></td>

<td> 16. Whether the Student has paid all the fees due to School ? <br/><b>YES</b></td>

</tr>

<tr>

<td> 5. Nationality <br/><b> INDIAN </b></td>

<td> 17. Fee Concession, if any (Nature and period to be specified) </td>

</tr>

<tr>

<td> 6. Religion / Caste / Caste_kannada <br/><b>'.$religion.'</b></td>

<td> 18. Scholarship if any (Nature and period to be specified) </td>

</tr>

<tr>

<td> 7. Name of the Father <br/><b>'.$fname.'</b></td>

<td> 19. Whether Medically Examined or not <br/><b>YES</b></td>

</tr>

<tr>

<td> 8. Name of the Mother <br/><b>'.$mname.'</b></td>

<td> 20. Month of student last attendance at the School </td>

</tr>

<tr>

<td> 9. Whether the candidate belongs to Schedule Caste or Schedule Tribe ? <br/><b>'.$socialcat.'</b></td>

<td> 21. Date on which the application for the Transfer

 Certificate was received </td>

</tr>

<tr>

<td> 10. Whether qualified for promotion to a Higher Standard ? </td>

<td> 22. Number of School Days up to the date of leaving in

 academic year </td>

</tr>

<tr>

<td> 11. Student Date of Birth <br/><b>'.$ndob.'</b></td>

<td> 23. Number of Total Days the student attended in

 academic year </td>

</tr>

<tr>

<td> 12. Place : <br/>

Taluka : <br/>

District : </td>



<td> 24. Character and Conduct <br/><b>Good</b></td>

</tr>

</table>





<p style="font-size:10"> Date of Entry : ___________________  <span style="text-align:center"> Date of Issue : ____ </span> </p>

<br/>

<p><span style="visibility:hidden;">________________</span><span style="border:1px solid #000; border-radius:25px 25px;padding:10px;">School Seal</span><span style="visibility:hidden;">________________</span></p>



<br/>

<br/>

<p style="font-size:10"> Data Entry operator Sign : ___ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Headmaster Sign : ___</p>

</div>';

$pdf->writeHTML($html, true, false, true, false, '');
// echo $html;

}






$pdf->Output();





?>