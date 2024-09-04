<?php 
include_once('myfunction.php');

if(isset($_REQUEST['teacher_id']) &&  $_REQUEST['session_id'] ){
    $registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
	$teacher_id=$_REQUEST['teacher_id'];
    // $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

    if(!empty($_REQUEST['session_id'])){
      $session_id= $_REQUEST['session_id'];     
    }else{
      $response["status"] = 3;
      $response["message"] = "Session_id not Found";
      $response["result"] = [];    
      echo json_encode($response);  die;
    } 
	
	$result= recentshowhomework($teacher_id,$session_id);
    if(!empty($result)){
        $response["status"] = 1;
        $response["message"] = "Success";  
        $response["result"] = $result;
        echo json_encode($response);   
    }else{
        $response["status"] = 0;
        $response["message"] = "No Message";
        $response["result"] = [];
        echo json_encode($response);   
    }
}else{
    $response["status"] = 2;
    $response["message"] = "Required Parameter teacher_id, session_id are missing"; 
    $response["result"] = [];
    echo json_encode($response);
}

 // $staffid=$_REQUEST['staffid'];
?>