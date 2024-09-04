<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';   
include('myfunction.php');

if(isset($_REQUEST['classid']) && isset($_REQUEST['sessionid']) ){

$classid= $_REQUEST['classid']; 
$sectionid= isset($_REQUEST['sectionid']) ? $_REQUEST['sectionid'] : '' ; 
$sessionid= $_REQUEST['sessionid'];

$result=subject($classid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "No Subjects";
			$response["result"] = [];
			echo json_encode($response);  
	}

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter classid,sectionid, sessionid ";
	$response["result"] = [];
	echo json_encode($response); 

}
	// echo subject($object->classid);


?>