<?php

if (isset($_REQUEST['atdate']) && isset($_REQUEST['attendance_list']) && isset($_REQUEST['class_id']) && isset($_REQUEST['section_id'])) {
	// isset($_REQUEST['student_id']) && isset($_REQUEST['attendance_type_id'])
	if (isset($_REQUEST['registration_no'])) {
		$registration_no = $_REQUEST['registration_no'];
	} else {
		$registration_no = '';
	}
	include('myfunction.php');


	if (!empty($_REQUEST['atdate'])) {
		$atdate = $_REQUEST['atdate'];
	} else {
		$error = "atdate not found";
	}
	if (!empty($_REQUEST['teacher_id'])) {
		$teacher_id = $_REQUEST['teacher_id'];
	} else {
		$error = "teacher_id not found";
	}
	if (!empty($_REQUEST['class_id'])) {
		$class_id = $_REQUEST['class_id'];
	} else {
		$error = "class_id not found";
	}
	if (!empty($_REQUEST['section_id'])) {
		$section_id = $_REQUEST['section_id'];
	} else {
		$error = "section_id not found";
	}
	if (!empty($_REQUEST['session_id'])) {
		$session_id = $_REQUEST['session_id'];
	} else {
		$error = "session_id not found";
	}
	if (!empty($_REQUEST['attendance_list'])) {
		$attendance_list = $_REQUEST['attendance_list'];
	} else {
		$error = "Attendance data not found";
	}
	if (isset($error)) {
		$response["status"] = 4;
		$response["message"] = $error;
		$response["result"] = [];
		echo json_encode($response);
		die;
	}
	// $student_id,$attendanceid

	if($_REQUEST['attendance_type_id']=='3'){
		$leave_reason=$_REQUEST['leave_reason']; 
	}else{
	$leave_reason = '';
	}	
	// $attendance_list=json_encode($attendance_list);
	$result = studentattendance($teacher_id, $attendance_list, $atdate, $leave_reason, $session_id, $class_id, $section_id);


	// $result=studentattendance($teacher_id,$student_id,$attendanceid,$atdate);
	// if(!empty($result)){
	if ($result == 'Inserted') {

		$response["result"] = $result;
		$response["status"] = 1;
		$response["message"] = "Success";
		echo json_encode($response);
	} elseif ($result == 'Already') {
		$response["result"] = $result;
		$response["status"] = 0;
		$response["message"] = "Attendance Already Taken";
		echo json_encode($response);
	} else {

		$response["status"] = 0;
		$response["message"] = "Not Found";
		$response["result"] = [];

		echo json_encode($response);
	}
} else {

	$response["status"] = 3;

	$response["message"] = "Required Parameter class_id, section_id, atdate, attendance_list is missing";
	$response["result"] = [];
	echo json_encode($response);
}


	// $result= showattendance($classid,$sectionid,$date);
  
// $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
	// $leave_reason=isset($_REQUEST['leave_reason']) ? $_REQUEST['leave_reason'] : '';

	// $attendanceid=$_REQUEST['attendance_type_id']; 
