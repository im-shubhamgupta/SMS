<?php

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
	$current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '';
	$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

	echo $result = message($stuid, $sessionid, $current_page, $per_page);

	// if(!empty($result)){
	//         $response["status"] = 1;
	// 		$response["message"] = "Success"; 
	// 		$response["current_page"] = $result['current_page'];
	// 		$response["per_page"] = $result['per_page'];
	// 		$response["total_page"] = $result['total_page'];
	// 		$response["total_records"] = $result['total_records'];
	// 		$response["result"] = $result['data'];
	// 		echo json_encode($response); 
	// }else{
	// 		$response["status"] = 0;
	// 		$response["message"] = "No Message";
	// 		echo json_encode($response);  
	// }

} else {
	$response["status"] = 2;
	$response["message"] = "Required Parameter  stuid, sessionid";
	$response["result"] = [];
	echo json_encode($response);
}


	// echo message($object->classid,$object->sectionid,$object->stuid);
