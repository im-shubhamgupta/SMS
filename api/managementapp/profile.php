<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['user_id']) ){


	$user_id=mysqli_real_escape_string($con,$_REQUEST['user_id']);
	$sessionid=mysqli_real_escape_string($con,$_REQUEST['sessionid']);
	
  

	$result=profile($user_id, $sessionid);

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Invalid Id";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter user_id is missing"; 

	    echo json_encode($response);

	}

	// echo profile($object->id);







?>