<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['classid']) && isset($_REQUEST['sectionid']) && isset($_REQUEST['testname'])  && isset($_REQUEST['subjectid'])) {

	$teacher_id = $_REQUEST['teacher_id'];
	$classid = $_REQUEST['classid'];
	$sectionid = $_REQUEST['sectionid'];
	$testname = $_REQUEST['testname'];
	$subjectid = $_REQUEST['subjectid'];
	// $session=profile($teacher_id)['session'];
	$session_id = isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

	if (empty($testname)) {
		$response['status'] = 3;
		$response['message'] = "Testname is Required";
		echo json_encode($response);
		die;
	}

	$result = showstudents($session_id, $classid, $sectionid, $testname, $subjectid);
	// print_r($result);die;
	if (!empty($result)) {

		$response["status"] = 1;
		$response["message"] = "Success";
		$response["marks_inserted"] = $result[1];
		$response["result"] = $result[0];


		echo json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "Students Not Found";
		$response["result"] = [];
		echo json_encode($response);
	}
} else {
	$response["status"] = 2;
	$response["message"] = "Required Parameter Teacher id ,class, section, Testname, Subject  is missing";
	$response["result"] = [];
	echo json_encode($response);
}

