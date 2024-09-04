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

	$result = allcount($stuid, $sessionid);

	if (!empty($result)) {
		$response["status"] = 1;
		$response["message"] = "Success";
		$response["result"] = $result;
		echo json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "Invalid Id";
		$response["result"] = [];
		echo json_encode($response);
	}
} else {
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid and sessionid missing";
	$response["result"] = [];
	echo json_encode($response);
}

	// echo allcount($object->stuid);
