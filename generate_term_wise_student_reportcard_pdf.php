<?php
require("mpdf/autoload.php");
include("myfunction.php");

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
// @page {
// 	size: auto;
// 	odd-header-name: html_myHeader1;
// 	even-header-name: html_myHeader2;
// 	odd-footer-name: html_myFooter1;
// 	even-footer-name: html_myFooter2;
// }
// @page chapter2 {
// 	odd-header-name: html_Chapter2HeaderOdd;
// 	even-header-name: html_Chapter2HeaderEven;
// 	odd-footer-name: html_Chapter2FooterOdd;
// 	even-footer-name: html_Chapter2FooterEven;
// }
// @page noheader {
// 	odd-header-name: _blank;
// 	even-header-name: _blank;
// 	odd-footer-name: _blank;
// 	even-footer-name: _blank;
// }
// @page *{
	// 	margin-top: 2.54cm;
	// 	margin-bottom: 2.54cm;
	// 	margin-left: 3.175cm;
	// 	margin-right: 3.175cm;
	// }
	// height:80%;
		// transform: scale(.5);

// <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
// <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
$html = '
<html>
<head>



<style>
  
    table{		
		zoom : 82%;
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
	td {
		height: 6px;
		
	  }
    .co_scholastic table, th, td{

    }
    .card-body{
    	
    }
    .card-body table,tr,td{
    	padding:5px;	
    }
    div{ 
    	

    }
</style>
</head>';

$scount = 0;
$page_count = 1;
$totalpage = count($stuarr);
foreach ($stuarr as $val) {
	// ----------------------------generate serial no ------------------------------------------------
	$type = 'term-report';
	$key = 'TRC';

	$sql1 = "select * from generate_certificate where certificate_type LIKE '$type'  order by id desc limit 1";
	$q2 = mysqli_query($con, $sql1);
	$r2 = mysqli_fetch_assoc($q2);
	$row2 = mysqli_num_rows($q2);
	if ($row2 > 0) {
		$Count2 = substr($r2['certificate_no'], 3);  //return character after 3 words
		if (is_numeric($Count2)) {
			$count = ltrim($Count2, '0');
		}
		$recptno = $key . str_pad(intval($count) + 1, 6, "0", STR_PAD_LEFT);
		$no = mysqli_query($con, "INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$val', '" . $_SESSION['session'] . "',now())");
		if (!$no) {
			die("Error_description: " . mysqli_error($con));
		}
	} else {
		$recptno = $key . "000001";
		$sql = "INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno', '$val','" . $_SESSION['session'] . "',now())";
		$no = mysqli_query($con, $sql);
		if (!$no) {
			die("Error_desc: " . mysqli_error($con));
		}
	}
	$recptno_sch = get_school_details()['company_short_name'] . $recptno;
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



	$html .= '<section class="report_card py-3" style="">
	
	
	
	<div class="col-md-12 py-3" style="">
	 ';


	$html .= ' <table style="width:100%;margin-top:0px;border:0px solid black;">
 	<tr>
 		<td><span class="text-center"><small>Registration Number :' . $registration_number . '</small></span></td>
 		<td text-align="right"><span class="text-center"><small>Affiliation No. / UDISE Code: ' . $affiliation_number . '</small></span></td>
 		

 	</tr>
    </table>';

	$html .= ' <table  style="width:100%;margin-top:0px;border:0px solid black;text-align:center;">
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

	$html .= '  <table class=" stu_detail table table-sm" style="width:100%;padding:20px;" >
	  <tbody>
		<tr>
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
	// container
	// $html .= '<div class="">  
	// <div class="card bg-transparent border-0">
	// <div class="card-title bg-success py-1" style="font-size:15px;color:white;border:1px solid black;border-top-left-radius:8px;border-top-right-radius:8px;">
	// <h6 class="ml-3"><h3>ACADEMIC PERFORMANCE</h3></h6>
	// </div>
	// <div class="card-body" style=" border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000; border-bottom-left-radius:8px;border-bottom-right-radius:8px;">';

	$html .= '<br><div  style="border:1px solid black;width:100%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
		<h3 style="padding-left:10px;margin:2px;">ACADEMIC PERFORMANCE</h3>';

	$html .= '<table class="table table-sm mt-2"  style="width:100%;border:1px solid black;" border=1>
  <thead >
  <tr>
  <th class="text-center" width="70%" style="background:#ededed">Subjects</th>';

	$Total_marks = array();
	$Total_max_marks = array();
	$examarr = explode(',', $examid);
	$PtestQ = mysqli_query($con, "select * from test where parent_test_id='$examid' and class_id='$clsid' AND  section_id='$secid' AND session='" . $_SESSION['session'] . "'");
	if ($PtestQ->num_rows > 0) {

		while ($Prow = $PtestQ->fetch_assoc()) {

			$TestData[$Prow['test_name']] = array('max_marks' => $Prow['max_marks']);
		}
	}

	foreach ($TestData as $TesName => $TestMaxMarks) {

		$MaxMarks = $TestMaxMarks['max_marks'];
		$Total_marks[$scount][] = $TestMaxMarks['max_marks'];


		$html .= '<td class="text-center" style="background:#ededed;font-size:10px;" ><b><h6>' . $TesName . '</h6></b>Max Marks: ' . $MaxMarks . '</td>';
	}
	$Total_max_marks = array_sum($Total_marks[$scount]);

	// "background:#ff4d4d"
	$html .= '<td class="text-center" style="background:#ededed;width:30px;"><h6>Total Marks:</h6>' . $Total_max_marks . '</td>';
	$html .= '<th class="text-center" style="width:50px;background:#ededed"  ><h6 >Grade</h6></th>';

	$html .= '</tr> </thead>';

	$html .= '<tbody style="">';

	$total_Marks = array();
	$total_Marks_by_test = array();
	$i = 0;
	$qsub = mysqli_query($con, "select st.subject_id, st.subject_name from subject as st  JOIN test as t ON t.subject_id=st.subject_id where st.class_id='$clsid' AND  t.section_id='$secid' and t.session='" . $_SESSION['session'] . "' AND t.parent_test_id='$examid' GROUP BY st.subject_id");

	$No_Of_Subject = $qsub->num_rows;
	while ($rsub = mysqli_fetch_assoc($qsub)) {
		// echo "<pre>";
		// echo print_r($rsub);
		// echo "</pre>";

		$subid = $rsub['subject_id'];
		$subject = $rsub['subject_name'];
		$html .= '<tr>
	    <th scope="row" style="border:1px solid black;padding:6px;"  >' . $subject . '</th>';
		$total_Marks_by_test = array();
		foreach ($TestData as $TesName => $TestMaxMarks) {
			$max_marks = $TestMaxMarks['max_marks'];
			$qm = mysqli_query($con, "select * from marks where student_id='$val' && test_name='$TesName' && subject_id='$subid' and session='" . $_SESSION['session'] . "'");
			$rm = mysqli_fetch_array($qm);
			$marksid = $rm['mark_id'];
			$marks = $rm['marks'];

			$total_Marks_by_test[$i][$scount] += $rm['marks'];


			$html .= '<td class="text-center" style="width:65px;"><span class="px-3 py-1">' . $marks . '</span></td>';
		}

		$MarksPerctle = round($total_Marks_by_test[$i][$scount] * 100 / $Total_max_marks);


		$FinalMarks[$scount] += $total_Marks_by_test[$i][$scount];


		$qg1 = mysqli_query($con, "select * from grade where condition1 <='$MarksPerctle' && condition2 >='$MarksPerctle'");
		$rg1 = mysqli_fetch_array($qg1);
		$color = $rg1['colors'];
		$Grade = $rg1['grade_name'];


		$html .= '<td style="border:1px solid black;width:65px;"    class="text-center"><span class="px-3 py-1">' . $total_Marks_by_test[$i][$scount] . '</span></td>	   
	   <td style="border:1px solid black;width:70px; text-align:center;"   class="text-center"><spanclass="px-3 py-1">' . $Grade . '</span></td>';



		$html .= '<tr>';
		$i++;
	} //while


	$html .= ' </tbody> </table>';


	$html .= '</div>';

	$No_Of_Subject = count($total_Marks);
	$Total_Marks = array_sum($total_Marks);
	if ($No_Of_Subject == '0') {  //divided by zero is error
		$No_Of_Subject = '1';
	}
	if ($max_marks == '0') {
		$max_marks = '1';
	}

	$Total_Percentile = round($Total_Marks * 100 / ($max_marks * $No_Of_Subject), 2);
	$TPERC = mysqli_query($con, "select * from grade where condition1 <='$Total_Percentile' && condition2 >='$Total_Percentile'");
	$TPERCQ = mysqli_fetch_array($TPERC);
	$Tcolor = $TPERCQ['colors'];
	$TGrade = $TPERCQ['grade_name'];


	$margin='200px';
	$Corow='0';
	$qs = mysqli_query($con, "select cs.scholastic_name,scg.grade from co_scholastic as cs JOIN  `scholastic-grade` as scg ON scg.subject_id=cs.scholastic_id where scg.class_id='$clsid' AND  scg.section_id='$secid' AND scg.term_id='$examid' and scg.student_id='$val' and scg.session='" . $_SESSION['session'] . "'   and grade!=''");
	if ($Corow=$qs->num_rows > 0) {



		$html .= '<br><div  style="border:1px solid black;width:100%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
		<h3  style="padding-left:10px;margin:2px;">CO-SCHOLASTIC PERFORMANCE</h3>';
		$html .= '<table class="co_scholastic" border=1  style="width:100%; border:1px solid black;" >
					<tbody>
						<thead >
							<tr >
								<th width=80%  style="background:#ededed">Subjects</th>
								<th  style="background:#ededed">Grade</th>
							</tr>
						</thead>';

		while ($rs = mysqli_fetch_array($qs)) {

			$html .= '<br><tr>
						<td  ><center><b>' . $rs['scholastic_name'] . '</b></center></td>
						<td ><center><span style="background:' . $color . ';" >' . $rs['grade'] . '</span></center></td>
					</tr>';
		}


		$html .= '</tbody></table>';

		$html .= '</div><br />';
		$margin='50px';
	}


	//socalistic grade
	// if(!$Corow>1){
		$html .= ' <br><div ><h6 class="mt-2" style="margin:1px;" >Class Teacher\'s Remarks:</h6></div>';
	// }
	
  
    $html.='<table style="width:100%;margin-top:'.$margin.';border:0px solid black;">
 	<tr>
 		<td><b><p>Class Teacher\'s Remarks:</p></b></td>
 		<td> <b><p class="text-center">Controller of Examinations<br>(Vice - Principal)</p></b></td>
 		<td><b><p >Principal</p><b></td>

 	</tr>
</table>';


	$html .= '</div>  
</div>
 
</div>

 </div>
</section>';
	$html .= "<div align='right' style='font-size:8px;'>SL No. : " . $recptno_sch . "</div>";
	

	$html .= ' </html>';
	if ($page_count != $totalpage) {
		$html .= '<pagebreak/>';  //stop the generate of extra page
	}


	// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [200, 330]]);
	// $mpdf = new \Mpdf\Mpdf();
	// $mpdf=new \Mpdf\Mpdf('c','A4','','',0,0,0,0,0,0);
	$mpdf=new \Mpdf\Mpdf(['margin_footer' => 0]);
	// $mpdf = new \Mpdf\Mpdf('', '', 0, '', 15, 15, 15, 15, 8, 8);

	$mpdf->WriteHTML($html);
	// $mpdf->AddPage();

	// $mpdf->use_kwt = true;    // Default: false
	$mpdf->SetDisplayMode(90);


	// ob_end_clean();
	// $mpdf->output($file,'I');
	$page_count++;
}
// ini_set('memory_limit', '-1');
// echo $html;die;

$file = time() . '.pdf';
// ob_clean();
ob_end_clean();
$mpdf->output($file, 'I');



// echo $html;




// $mpdf=new mPDF('fsalbertpro','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);

// $html='----'; // this variables contain all css and HTML to be shown in PDF

// ob_clean(); // cleaning the buffer before Output()

// $mpdf->SetDisplayMode('fullpage');

// $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
