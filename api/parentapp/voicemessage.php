<?php 

include('myfunction.php');

if(isset($_REQUEST['stuid'])  && isset($_REQUEST['sessionid']) ){

$stuid= $_REQUEST['stuid']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$result=voicemessage($stuid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 
	}else{
			$response["status"] = 0;
			$response["message"] = "No Voice Message";
			echo json_encode($response);  
	}
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter stuid, sessionid ";
	echo json_encode($response); 
}


	// echo voicemessage($object->stuid);



	



?>