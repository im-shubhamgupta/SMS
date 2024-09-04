<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');


	$result=classname();

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "No Class";

			echo json_encode($response);   

		}




	
?>