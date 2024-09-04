<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if (isset($_REQUEST['stuid'])  && isset($_REQUEST['sessionid'])) {

	$stuid = $_REQUEST['stuid'];
	if (empty($_REQUEST['sessionid'])) {
		$response["status"] = 3;
		$response["message"] = "Required Session id";
		$response["result"] = [];
		echo json_encode($response);
		die;
	}
	$sessionid = $_REQUEST['sessionid'];

	$result = reportcardsummary($stuid, $sessionid);

	if (!empty($result)) {
		$response["status"] = 1;
		$response["message"] = "Success";
		$response["result"] = $result;
		echo json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "Marks Not Entered";
		$response["result"] = [];
		echo json_encode($response);
	}
} else {
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid, sessionid";
	$response["result"] = [];
	echo json_encode($response);
}
	// echo reportcardsummary($object->stuid);
