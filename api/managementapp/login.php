<?php 

include('myfunction.php');
if(isset($_REQUEST['email']) && isset($_REQUEST['password'])  ){


	$email=mysqli_real_escape_string($con,$_REQUEST['email']);
	$password=mysqli_real_escape_string($con,$_REQUEST['password']);
  

	$result=login($email,$password);

		if(!empty($result)){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}else{

			$response["status"] = 0;

			$response["message"] = "Invalid email password";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter Email, Password is missing"; 

	    echo json_encode($response);

	}

	// echo login($object->email,$object->password);
	
?>