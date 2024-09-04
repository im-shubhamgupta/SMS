<?php

// include('connection.php');
include_once('myfunction.php');

extract($_REQUEST);



$class = $_REQUEST['class'];

$section = $_REQUEST['section'];

$fromdt = $_REQUEST['fromdt'];

$todt = $_REQUEST['todt'];

$student = $_REQUEST['student'];



	// $query="select * from student_daily_attendance where (class_id='$class' && section_id='$section' && student_id='$student')&&(date between '$fromdt' and '$todt')";

	$query="select * from student_daily_attendance where (class_id='$class' && section_id='$section' ) ";

	if(!empty($_REQUEST['fromdt']) &&  !empty($_REQUEST['todt'])){
		$query.=" AND date between '$fromdt' and '$todt' ";

	}

	if(!empty($_REQUEST['fromdt']) && empty($_REQUEST['todt'])){
		$query.=" AND date='$fromdt'  ";

	}

	if(!empty($_REQUEST['student'])){
		$query.=" AND student_id='$student' ";
	}

	$search_result = filterTable($query);

	

	

function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



$columnHeader ='';

$columnHeader.= "Register no".","."Name".","."Attendance Date".","."Attendance".","."Reason";



$data='';



	$present=0;

	$absent=0;

	$leave=0;

	$rowcount=mysqli_num_rows($search_result);

	while($res1=mysqli_fetch_array($search_result))

	{
		$student_id=$res1['student_id'];
		$register_no = getStudent_byStudent_id($student_id)['register_no'];
	    $stuname =getStudent_byStudent_id($student_id)['student_name'];


	$q1 = mysqli_query($con,"select * from students where student_id='$student'");

	$r1 = mysqli_fetch_array($q1);

	// print_r($r1);die;

	

				

	$ndate=$res1['date'];

	$chgdate=date('d-m-Y',strtotime($ndate));



	$attend=$res1['type_of_attend'];

	if($attend==1){

	$present=$present+1; 

	}

	else if($attend==2)

	{

	$absent=$absent+1;

	}

	else if($attend==3)

	{

	$leave=$leave+1;

	}



	$queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");

	$ratt=mysqli_fetch_array($queatt);

	// $attname=$ratt['short_name'];
	$attname=$ratt['att_type_name'];



	$reason=$res1['reason'];

																									

		$data.= $register_no.",".$stuname.",".$chgdate.",".$attname.",".$reason."\n";


}

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));	

$dat = $date->format('d-m-Y H:i:s');



$filename =  "studentwise_daily_attendance_report_".$dat.".csv";

header('Content-type: application/csv');

header('Content-Disposition: attachment; filename='.$filename);



echo ucwords($columnHeader)."\n".$data."\n"; 

exit; 



?>

