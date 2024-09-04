<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['sessionid'])  ){

	
	
	$sessionid=mysqli_real_escape_string($con,$_REQUEST['sessionid']);

	
  

	$result=sms_category_list($sessionid);

		if($result){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Students not Found";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter sessionid  is missing"; 

	    echo json_encode($response);

	}


	



?>