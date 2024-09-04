<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['classid']) ){


	$classid=mysqli_real_escape_string($con,$_REQUEST['classid']);
	
  

	$result=sectionname($classid);

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "No Section";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter classid is missing"; 

	    echo json_encode($response);

	}


	// echo sectionname($object->classid);



?>