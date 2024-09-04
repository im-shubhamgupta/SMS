<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if (isset($_REQUEST['id'])) {

	// $teacher_id=$_REQUEST['teacher_id'];
	$id = $_REQUEST['id'];

	// $session=profile($teacher_id)['session'];

	$session_id = isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

	$result = messagestatusupdate($session_id, $id);
	if (!empty($result)) {

		$response["result"] = $result;

		$response["status"] = 1;

		$response["message"] = "Success";

		echo json_encode($response);
	} else {

		$response["status"] = 0;

		$response["message"] = "Not Updated";
		$response["result"] = [];
		echo json_encode($response);
	}
} else {
	$response["status"] = 2;

	$response["message"] = "Required Parameter Teacherid & id";
	$response["result"] = [];
	echo json_encode($response);
}
