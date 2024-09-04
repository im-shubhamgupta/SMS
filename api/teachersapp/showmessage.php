<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if (isset($_REQUEST['teacher_id'])) {

	$teacher_id = $_REQUEST['teacher_id'];
	// $session=profile($teacher_id)['session'];
	// $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
	$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '';
	$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';
	if (isset($_REQUEST['session_id']) && !empty($_REQUEST['session_id'])) {
		$session_id = $_REQUEST['session_id'];
	} else {
		$response["status"] = 3;
		$response["message"] = "session_id not found ";
		$response["result"] = [];
		echo json_encode($response);
		die;
	}

	if (!empty($_REQUEST['classid']) && !empty($_REQUEST['sectionid'])) {
		$classid = $_REQUEST['classid'];
		$sectionid = $_REQUEST['sectionid'];
	} elseif (!empty($_REQUEST['classid']) && empty($_REQUEST['sectionid'])) {
		$classid = $_REQUEST['classid'];
		$sectionid = '';
	} else {
		$classid = '';
		$sectionid = '';
	}
	// 
	echo $result = showmessage($teacher_id, $classid, $sectionid, $session_id, $current_page, $per_page);

	// if(!empty($result)){

	// 	$response["status"] = 1;

	// 	$response["message"] = "Success";  
	// 	$response["current_page"] = $result['current_page'];
	// 	$response["per_page"] = $result['per_page'];
	// 	$response["total_page"] = $result['total_page'];
	// 	$response["total_records"] = $result['total_records'];
	// 	$response["result"] = $result['data'];  
	// 	echo json_encode($response);   


	// }else{

	// 	$response["status"] = 0;

	// 	$response["message"] = "No Message";

	// 	echo json_encode($response);   

	// }
} else {

	$response["status"] = 2;

	$response["message"] = "Required Parameter teacher_id,session_id ";
	$response["result"] = [];

	echo json_encode($response);
}

 // $staffid=$_REQUEST['staffid'];
