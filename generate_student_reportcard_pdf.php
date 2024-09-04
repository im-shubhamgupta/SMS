<?php
require("mpdf/autoload.php");
include("myfunction.php");

// ob_clean();
// // ob_end_clean();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

ini_set('memory_limit', '-1');
$clsid = $_REQUEST['clsid'];
$secid = $_REQUEST['secid'];
$examid = $_REQUEST['examid'];
$display = $_REQUEST['display'];
$stuid = $_REQUEST['stuid'];


$html = '';
$qset = mysqli_query($con, "select * from setting");
$rset = mysqli_fetch_array($qset);
$sclname = $rset['company_name'];
$registration_number = $rset['registration_number'];
$affiliation_number = $rset['affiliation_number'];
$scllogo = $rset['company_image'];
$scladd = $rset['company_address'];
$sclmob = $rset['company_number'];
$sclemail = $rset['company_email'];
$wesite = $rset['website'];

$stuarr = explode(',', $stuid);

// <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


// <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
// <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
$html = '
<html>
<head>



<style>
    @page {
        size: auto;
        odd-header-name: html_myHeader1;
        even-header-name: html_myHeader2;
        odd-footer-name: html_myFooter1;
        even-footer-name: html_myFooter2;
    }
    @page chapter2 {
        odd-header-name: html_Chapter2HeaderOdd;
        even-header-name: html_Chapter2HeaderEven;
        odd-footer-name: html_Chapter2FooterOdd;
        even-footer-name: html_Chapter2FooterEven;
    }
    @page noheader {
        odd-header-name: _blank;
        even-header-name: _blank;
        odd-footer-name: _blank;
        even-footer-name: _blank;
    }
    div.chapter2 {
        page-break-before: right;
        page: chapter2;
    }
    div.noheader {
        page-break-before: right;
        page: noheader;
    }
    table{
    	border :1px solid black;
    	padding:5px;
    	border-collapse: collapse;
    }
   
    table{
    	
    	padding:10px;
    	style="padding:15px; border: 1px solid black; width:100%; "  
    }
</style>
</head>';

$count = 1;
$totalpage = count($stuarr);
foreach ($stuarr as $val) {
		// ----------------------------generate serial no ------------------------------------------------
		$type='report';
		$key='RC';

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
			$no=mysqli_query($con,"INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$val', '".$_SESSION['session']."',now())");
			if(!$no){
						die("Error_desc: ".mysqli_error($con));
			}
		}
		else
		{
			$recptno = $key."000001";
			$sql="INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno', '$val','".$_SESSION['session']."',now())";
			$no=mysqli_query($con,$sql);	
			if(!$no){
						die("Error_desc: ".mysqli_error($con));
			}
		}
		$recptno_sch=get_school_details()['company_short_name'].$recptno;
		// ----------------------------generate serial no ------------------------------------------------
	

	$qstu = mysqli_query($con, "select `student_id`,`register_no`,`student_name`,`father_name`,`mother_name`,`stu_image`,`dob`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`session` from students as s join student_records as sr ON s.student_id=sr.stu_id where student_id='$val' and sr.session='" . $_SESSION['session'] . "'");
	$rstu = mysqli_fetch_array($qstu);
	$regno = $rstu['register_no'];
	$stuname = $rstu['student_name'];
	$nstuname = strtoupper($stuname);
	$fname = $rstu['father_name'];
	$mother_name = $rstu['mother_name'];
	$student_image = $rstu['stu_image'];
	$stu_image_path=getStudent_byStudent_id($rstu['student_id'])['stu_image_path'];



	$class = get_class_byid($rstu['class_id'])['class_name'] ?? '';

	$section = get_section_byid($rstu['section_id'])['section_name'] ?? '';

	$dob = $rstu['dob'];
	$chgdob = date("d-M-Y", strtotime($dob));

	$academicyear = getSessionByid($rstu['session'])['year'] ?? '';



	$html .= ' <table style="width:100%;margin-top:20px;border:0px solid black;">
 	<tr>
 		<td><span class="text-center"><small>Registration Number :' . $registration_number . '</small></span></td>
 		<td text-align="right"><span class="text-center"><small>Affiliation No. / UDISE Code: ' . $affiliation_number . '</small></span></td>
 		

 	</tr>
 </table>';

	$html .= ' <table style="width:100%;margin-top:20px;border:0px solid black;text-align:center;">
 	<tr>
 		<td width="50px"><img src="images/profile/' . $scllogo . '" class="img-fluid logo text-center ml-3" style="width:100px;height:70px"></td>
 		<td text-align="right"><h4 class="text-center"><b>' . $sclname . '</b></h4><br>
		  <h5 class="text-center"><small>' . $scladd . '</small></h5></td>
 		

 	</tr>
 </table>';
	// $html .= '  <hr style="border:1px solid #b6bcc2">';

	$html .= '<div class="card py-0 border-0 bg-transparent">
		 <div class="row">
		  <div class="col-md-6  offset-3 text-center">
		     <h5>Academic Session : <b>' . $academicyear . '</b></h5>
		  </div>
		  
		  </div>';

	$html .= '<div class="card-body"  >';

	$html .= '  <table class=" stu_detail table table-sm" style="padding:20px;width:100%;" >
	  <tbody>
		<tr class="stu_details" >
		  <th scope="row">Student\'s Name:</th>
		  <td>' . $stuname . '</td>
		   <th scope="row">Date Of Birth:</th>
		   <td>' . $chgdob . '</td>
		
		  <td rowspan="3"><img src="'.$stu_image_path.'" width="90px" height="90px" /></td>
		</tr>
		
		<tr>
		  <th scope="row">Mothers\'s Name:</th>
		  <td>' . $mother_name . '</td>
		  <th scope="row">Class and Section:</th>
		  <td>' . $class . ' ' . $section . '</td>
		</tr>
		<tr>
		  <th scope="row">Father\'s Name:</th>
		  <td>' . $fname . '</td>
		  <th scope="row">Admission No:</th>
		 <td>' . $regno . '</td>
		</tr>
	
		
	  </tbody>';

	$html .= "</table>";
	$html .= "</div>";
	
	$html .= '<br><div  style="border:1px solid black;width:100%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
	<h3 style="padding-left:10px;margin:2px;">ACADEMIC PERFORMANCE</h3>';

	$html.='<table class="table table-sm mt-2"  style="width:100%;border:1px solid black;" border=1>
	<thead >
	<tr>
	<th class="text-center" width="70%" style="background:#ededed">Subjects</th>';


	$examarr = explode(',', $examid);
	foreach ($examarr as $e) {


		$qe = mysqli_query($con, "select * from test where test_id='$e'");
		$re = mysqli_fetch_array($qe);
		$max_marks = $re['max_marks'];
		$test_name = $re['test_name'];


		$html .= '<th class="text-center" width=10% style="background:#ededed"><h6>Score</h6>Max Marks: ' . $max_marks . '</th>     
   <th width=10% class="text-center" style="background:#ededed">Grade</th>';
		// <th class="text-center" ><h6>Grade</h6></th>';

	}
	$total_Marks = array();

	$html .= '</tr> </thead>';

	$html .= '<tbody style="">';


	$sql = "select st.subject_id, st.subject_name from subject as st  JOIN test as t ON t.subject_id=st.subject_id where st.class_id='$clsid' AND  t.section_id='$secid' AND t.test_name='$test_name'
	 and t.session='" . $_SESSION['session'] . "' ";
	$qsub = mysqli_query($con, $sql);
	while ($rsub = mysqli_fetch_array($qsub)) {
		$subid = $rsub['subject_id'];
		$subject = $rsub['subject_name'];


		$html .= '<tr  >
	    <th scope="row" style="border:1px solid black;padding:6px;"  >' . $subject . '</th>';

		foreach ($examarr as $e) {

			$tsql = "select * from test where test_id='$e'  and session='" . $_SESSION['session'] . "'  ";
			$qe1 = mysqli_query($con, $tsql);
			$re1 = mysqli_fetch_array($qe1);

			$mname = $re1['test_name'];
			$max_marks = $re1['max_marks'];

			$msql="select * from marks where student_id='$val' && test_name='$mname' && subject_id='$subid' and session='" . $_SESSION['session'] . "' ";
			$qm = mysqli_query($con, $msql);
			$rm = mysqli_fetch_array($qm);
			$marksid = $rm['mark_id'];

			$marks = $rm['marks'];

			$MarksPerctle = round($marks * 100 / $max_marks);
			$total_Marks[] = $rm['marks'];
			$total_percent[] = $MarksPerctle;
			$qg1 = mysqli_query($con, "select * from grade where condition1 <='$MarksPerctle' && condition2 >='$MarksPerctle'");
			$rg1 = mysqli_fetch_array($qg1);
			$color = $rg1['colors'];
			$Grade = $rg1['grade_name'];


			$html .= '<td style="border:1px solid black;"    class="text-center"><center><span class="px-3 py-1">' . $marks . '</span></center></td>	   
	   <td style="border:1px solid black;"   class="text-center"><center><spanclass="px-3 py-1">' . $Grade . '</span></center></td>';
		} //for each

		$html .= '<tr>';
	} //while


	$html .= ' </tbody> </table>';


	$html .= '</div>';

	$No_Of_Subject = count($total_Marks);
	if ($No_Of_Subject == '0') {  //divided by zero is error
		$No_Of_Subject = '1';
	}
	if ($max_marks == '0') {
		$max_marks = '1';
	}
	// echo $No_Of_Subject;
	$Total_Marks = array_sum($total_Marks);

	$Total_Percentile = round($Total_Marks * 100 / ($max_marks * $No_Of_Subject), 2);
	$TPERC = mysqli_query($con, "select * from grade where condition1 <='$Total_Percentile' && condition2 >='$Total_Percentile'");
	$TPERCQ = mysqli_fetch_array($TPERC);
	$Tcolor = $TPERCQ['colors'];
	$TGrade = $TPERCQ['grade_name'];



	// <!--second table-->

	$html .= ' <div margin-top:"60px"><h6 class="mt-2" >Class Teacher\'s Remarks:</h6></div>
  
	<table style="width:100%;margin-top:170px;border:0px solid black;">
		<tr>
			<td><h6 class="mt-2">Class Teacher\'s Remarks:</h6></td>
			<td> <p class="text-center">Controller of Examinations<br>(Vice - Principal)</p></td>
			<td><h6 class="mt-2">Principal</h6></td>

		</tr>
	</table>


	</div>




	
	</div>
	
	</div>

	</div>
	</section>';

	$html.="<div align='right' style='font-size:8px;'>SL No. : ".$recptno_sch."</div>";

// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf = new \Mpdf\Mpdf();
// $mpdf=new \Mpdf\Mpdf('c','A4','','',0,0,0,0,0,0);

$mpdf->WriteHTML($html);




	$html .= ' </html>';
	if($count !=$totalpage){
	$html .= '<pagebreak/>';  //stop the generate of extra page
	}
	
	
	// $mpdf->AddPage();
	// "<pagebreak/>";
	// $mpdf->use_kwt = true;    // Default: false

	// $file=time().'.pdf';  

	// ob_end_clean();
	// $mpdf->output($file,'I');
	// echo "counting: ".$count;
	// echo "<br>totalpage: ".$totalpage;
	$count++;
}//main foreach loop
// echo $html;die;
$file = time() . '.pdf';
// ob_clean();
ob_end_clean();
$mpdf->output($file, 'I');



// echo $html;
