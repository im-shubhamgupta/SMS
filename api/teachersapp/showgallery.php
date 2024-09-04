<?php

if (isset($_REQUEST['teacher_id'])) {

	if (isset($_REQUEST['registration_no'])) {
		$registration_no = $_REQUEST['registration_no'];
	} else {
		$registration_no = '';
	}
	include('myfunction.php');


	$session_id = isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
	$teacher_id = mysqli_real_escape_string($con, $_REQUEST['teacher_id']);
	$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '';
	$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';
	if (!empty($_REQUEST['classid'])) {
		$classid = mysqli_real_escape_string($con, $_REQUEST['classid']);
	} else {
		$classid = "";
	}

	if (!empty($_REQUEST['sectionid'])) {
		$sectionid = mysqli_real_escape_string($con, $_REQUEST['sectionid']);
	} else {
		$sectionid = "";
	}




	echo $result = showgallery($teacher_id, $classid, $sectionid, $session_id, $current_page, $per_page);

	// if(!empty($result)){

	// 	// $response["result"] = $result;

	//     $response["status"] = 1;
	// 	$response["message"] = "Success";
	// 	$response["current_page"] = $result['current_page'];
	// 	$response["per_page"] = $result['per_page'];
	// 	$response["total_page"] = $result['total_page'];
	// 	$response["total_records"] = $result['total_records'];
	// 	$response["result"] = $result['data'];  

	// 	echo json_encode($response);   

	// }else{

	// 	$response["status"] = 0;

	// 	$response["message"] = "Not found";

	// 	echo json_encode($response);   

	// }

} else {

	$response["status"] = 2;
	$response["message"] = "Required Parameter teacher_id is missing";
	$response["result"] = [];
	echo json_encode($response);
}
