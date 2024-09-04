<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';   
include('myfunction.php');

if(isset($_REQUEST['mobile']) && isset($_REQUEST['sessionid'])){

$mobile= $_REQUEST['mobile']; 
if(empty($_REQUEST['sessionid'])){
	$response["status"] = 3;
	$response["message"] = "Required Session id"; 
	$response["result"] = [];
	echo json_encode($response);die; 
}
$sessionid= $_REQUEST['sessionid']; 
// $session=get_session_byid($sessionid);

$result=userdetail($mobile,$sessionid);

	if(!empty($result)){
	        $response["status"] = 1;
			$response["message"] = "Success"; 
			$response["result"] = $result;
			echo json_encode($response); 

	}else{
			$response["status"] = 0;
			$response["message"] = "Not Found";
			$response["result"] = [];
			echo json_encode($response);  
	}



}else{
$response["status"] = 2;
$response["message"] = "Required Parameter mobile no & sessionid missing";
$response["result"] = [];
echo json_encode($response); 

}




?>