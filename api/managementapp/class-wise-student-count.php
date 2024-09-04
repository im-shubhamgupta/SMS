<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if(isset($_REQUEST['sessionid'])){

$sessionid= $_REQUEST['sessionid'];

	$result=studentcount($sessionid);

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "error";

			echo json_encode($response);   

		}


}else{
    
    	$response["status"] = 0;
    	$response["message"] = "Provide Required Parameter";

	    echo json_encode($response);
}



?>