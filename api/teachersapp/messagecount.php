<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';

include('myfunction.php');

if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['staffid'])) {

	date_default_timezone_set("Asia/Kolkata");

	$teacher_id = $_REQUEST['teacher_id'];
	$staffid = $_REQUEST['staffid'];

	$session_id = isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

	// echo "hello world<br>";

	$result = messagecount($session_id, $staffid);
	if (!empty($result)) {
		$response["result"] = $result;
		$response['status'] = 1;
		$response['message'] = "Success";
		echo json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "No Record Found";
		$response["result"] = [];
		echo json_encode($response);
	}
} else {
	$response["status"] = 2;
	$response["message"] = "Requires Parameters is Teacherid, staffid,";
	$response["result"] = [];
	echo json_encode($response);
}
