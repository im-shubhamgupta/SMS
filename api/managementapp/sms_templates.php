<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['sessionid']) && isset($_REQUEST['user_type'])  ){

	
	$sessionid=mysqli_real_escape_string($con,$_REQUEST['sessionid']);
	$user_type=mysqli_real_escape_string($con,$_REQUEST['user_type']);

  

	$result=sms_templates($user_type,$sessionid);

		if($result){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Not Found";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter sessionid,user_type  is missing"; 

	    echo json_encode($response);

	}


	



?>