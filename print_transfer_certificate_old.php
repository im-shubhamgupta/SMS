<?php
include('connection.php');
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

foreach($stuarr as $val)
{

	$qstu = mysqli_query($con,"select * from students where student_id='$val'");
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
	
	$admyear = $rstu['academic_year'];
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

$html = '<div style="border:1px solid black;font-size:9px;">TC No.: 19031008412568 <br/>Academic year: 2019-2020

<p><span align="center" style="font-size:11px;font-weight:bold;color:green">'.$sclname.' <br/> </span><span style="font-size:10px">'.$scladd.'</span></p>

<h4 align="center" style="color:green">SCHOOL TRANFER CERTIFICATE</h4>

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


<p style="font-size:10"> Date of Entry : _______________________  <span style="text-align:center"> Date of Issue : ________________________ </span> </p>
<br/>
<br/>
<br/>
<p style="font-size:10"> Data Entry operator Sign : ____________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Headmaster Sign : ____________________</p>
</div>';

}

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output();


?>