<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if (isset($_REQUEST['stuid'])  && isset($_REQUEST['sessionid'])) {

	$student_id = $_REQUEST['stuid'];
	if (empty($_REQUEST['sessionid'])) {
		$response["status"] = 3;
		$response["message"] = "Required Session id";
		$response["result"] = [];
		echo json_encode($response);
		die;
	}
	$sessionid = $_REQUEST['sessionid'];


	echo $result = fees($student_id, $sessionid);
	// echo "<pre>"; print_r($result);


} else {
	$response["status"] = 2;
	$response["message"] = "Required Parameter student_id, sessionid ";
	$response["result"] = [];
	echo json_encode($response);
}


	// echo fees($object->regno);
