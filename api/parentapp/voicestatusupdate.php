<?php 

include('myfunction.php');

if(isset($_REQUEST['msg_id'])  && isset($_REQUEST['sessionid']) ){

$msg_id= $_REQUEST['msg_id']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$result=voicestatusupdate($msg_id);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 
	}else{
			$response["status"] = 0;
			$response["message"] = "Not Updated.";
			echo json_encode($response);  
	}
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter msg_id, sessionid ";
	echo json_encode($response); 
}


	// echo voicestatusupdate($object->id);





?>