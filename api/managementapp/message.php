<?php 
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');
if(isset($_REQUEST['message']) && isset($_REQUEST['login_userid'])   ){

	if(!empty($_REQUEST['classid'])){
		$classid=mysqli_real_escape_string($con,$_REQUEST['classid']);
	}else{
		$classid="";
	}
	if(!empty($_REQUEST['sectionid'])){
		$sectionid=mysqli_real_escape_string($con,$_REQUEST['sectionid']);
	}else{
		$sectionid="";
	}
	if(!empty($_REQUEST['heading'])){
		$heading=mysqli_real_escape_string($con,$_REQUEST['heading']);
	}else{
		$heading="";
	}
	if(!empty($_REQUEST['msgtype'])){
		$msgtype=mysqli_real_escape_string($con,$_REQUEST['msgtype']);
	}else{
		$msgtype="3";    //3rd category for message
	}
	$template_id=isset($_REQUEST['template_id']) ? mysqli_real_escape_string($con,$_REQUEST['template_id']) : '';

	if(empty($_REQUEST['message'])){

		$response["status"] = 4;

		$response["message"] = "Please Write Something";

		echo json_encode($response); die;

	}else{
		$message=mysqli_real_escape_string($con,$_REQUEST['message']);
	}

	$sessionid=isset($_REQUEST['sessionid']) ? $_REQUEST['sessionid'] : '';
	
	$login_userid=mysqli_real_escape_string($con,$_REQUEST['login_userid']);
	$roles=mysqli_real_escape_string($con,$_REQUEST['roles']);
	
  

	$result=message($heading,$msgtype,$classid,$sectionid,$message,$login_userid,$sessionid,$template_id);

		if($result=="success"){

			$response["result"] = $result;

		    $response["status"] = 1;

			$response["message"] = "Success";  

			echo json_encode($response);   

		}elseif($result=="error"){

			$response["result"] = $result;

		    $response["status"] = 3;

			$response["message"] = "Something went wrong plesae try again";  

			echo json_encode($response); 



		}else{

			$response["status"] = 0;

			$response["message"] = "Students not Found";

			echo json_encode($response);   

		}
	}else{

		$response["status"] = 2;

		$response["message"] = "Required Parameter message, login_userid  is missing"; 

	    echo json_encode($response);

	}


	// echo message($object->msgtype,$object->classid,$object->sectionid,$object->message,$object->username);



?>