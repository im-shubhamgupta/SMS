<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['id']) && isset($_REQUEST['currentpassword'])   && isset($_REQUEST['newpassword'])  ){


	$id=mysqli_real_escape_string($con,$_REQUEST['id']);
	$currentpassword=mysqli_real_escape_string($con,$_REQUEST['currentpassword']);
	$newpassword=mysqli_real_escape_string($con,$_REQUEST['newpassword']);
	
  

	$result=changepassword($id,$currentpassword,$newpassword);

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Invalid details";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter id, currentpassword, newpassword  is missing"; 

	    echo json_encode($response);

	}

	// echo changepassword($object->id,$object->currentpassword,$object->newpassword);







?>