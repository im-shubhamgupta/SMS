<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['st_notification_id'])  && isset($_REQUEST['sessionid']) ){

$id= $_REQUEST['st_notification_id']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$result=messagestatusupdate($id,$sessionid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Updated Successfully."; 
			$response["result"] = $result;
			echo json_encode($response); 
	}else{
			$response["status"] = 0;
			$response["message"] = "Not Updated.";
			$response["result"] = [];
			echo json_encode($response);  
	}
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter id, sessionid ";
	$response["result"] = [];
	echo json_encode($response); 
}

	// echo messagestatusupdate($object->id);




?>