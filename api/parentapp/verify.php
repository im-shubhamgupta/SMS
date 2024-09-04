<?php 

include('myfunction.php');
if(isset($_REQUEST['mobile']) && isset($_REQUEST['password']) && isset($_REQUEST['firebaseid'])  && isset($_REQUEST['sessionid']) ){

$mobile= $_REQUEST['mobile']; 
$password= $_REQUEST['password']; 
$firebaseid= $_REQUEST['firebaseid']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid']; 

$result=verify($mobile,$password,$firebaseid,$sessionid);

	if(!empty($result)){
        $response["status"] = 1;
		$response["message"] = "Success"; 
		$response["result"] = $result;
		echo json_encode($response); 

	}else{
		$response["status"] = 0;
		$response["message"] = "Invalid Details";
		echo json_encode($response);  
	}
}else{
	$response["status"] = 2;
	$response["message"] = "Required Parameter mobile, password, firebaseid, sessionid  missing";
	echo json_encode($response); 

}
	// echo verify($object->mobile,$object->password,$object->firebaseid);

	
?>