<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['session_id'])) {


	if (isset($_REQUEST['session_id']) && !empty($_REQUEST['session_id'])) {
		$session_id = $_REQUEST['session_id'];
	} else {
		$response["status"] = 3;
		$response["message"] = "session_id not found ";
		echo json_encode($response);
		die;
	}
	$teacher_id = mysqli_real_escape_string($con, $_REQUEST['teacher_id']);




	$result = recentshowgallery($teacher_id, $session_id);

	if (!empty($result)) {
		$response["status"] = 1;
		$response["message"] = "Success";
		$response["result"] = $result;

		echo json_encode($response);
	} else {

		$response["status"] = 0;
		$response["message"] = "Not found";
		$response["result"] = [];
		echo json_encode($response);
	}
} else {

	$response["status"] = 2;
	$response["message"] = "Required Parameter teacher_id is missing , session_id";
	$response["result"] = [];
	echo json_encode($response);
}
