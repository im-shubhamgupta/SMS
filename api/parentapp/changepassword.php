<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : ''; 
include('myfunction.php');

if(isset($_REQUEST['mobile']) && isset($_REQUEST['sessionid'])  && isset($_REQUEST['currentpassword']) && isset($_REQUEST['newpassword']) ){

$mobile= $_REQUEST['mobile']; 
$currentpassword= $_REQUEST['currentpassword']; 
$newpassword= $_REQUEST['newpassword']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid'];

$result=changepassword($mobile,$currentpassword, $newpassword,$sessionid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "Invalid Details";
			$response["result"] = [];
			echo json_encode($response);  
	}

}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter mobile, sessionid, currentpassword,newpassword ";
	$response["result"] = [];
	echo json_encode($response); 

}

	// echo changepassword($object->mobile,$object->currentpassword,$object->newpassword);



?>