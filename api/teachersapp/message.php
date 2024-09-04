<?php

if (isset($_REQUEST['classid']) && isset($_REQUEST['sectionid']) && isset($_REQUEST['message']) &&  isset($_REQUEST['teacher_id'])) {

	if (isset($_REQUEST['registration_no'])) {
		$registration_no = $_REQUEST['registration_no'];
	} else {
		$registration_no = '';
	}
	include('myfunction.php');
	// $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

	if (isset($_REQUEST['heading'])) {
		$heading = $_REQUEST['heading'];
	} else {
		$heading = '';
	}

	$classid = $_REQUEST['classid'];

	$sectionid = $_REQUEST['sectionid'];

	if (empty($_REQUEST['session_id'])) {
		$response["status"] = 0;
		$response["message"] = "Session_id not found";
		$response["result"] = [];
		echo json_encode($response);
		die;
	} else {
		$session_id = mysqli_real_escape_string($con, $_REQUEST['session_id']);
	}

	if (empty($_REQUEST['message'])) {
		$response["status"] = 0;
		$response["message"] = "Please Enter Message";
		echo json_encode($response);
		die;
	} else {
		$message = mysqli_real_escape_string($con, $_REQUEST['message']);
		$nmsg = $_REQUEST['message'];
	}

	$teacher_id = $_REQUEST['teacher_id'];



	$result =  message($heading, $classid, $sectionid, $message, $nmsg, $teacher_id, $session_id);



	if (!empty($result)) {

		$response["result"] = $result;

		$response["status"] = 1;

		$response["message"] = "Success";
		echo json_encode($response);
	} else {



		$response["status"] = 0;

		$response["message"] = "Invalid Class and Section Id.";
		$response["result"] = [];
		echo json_encode($response);
	}
} else {



	$response["status"] = 2;

	$response["message"] = "Required Parameter classid, sectionid, message or teacher_id is missing";
	$response["result"] = [];

	echo json_encode($response);
}
