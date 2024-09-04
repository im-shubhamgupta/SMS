<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
  include_once('myfunction.php');
  if(isset($_REQUEST['class_id']) && isset($_REQUEST['section_id']) && isset($_REQUEST['sessionid'])){
  
  $class_id=$_REQUEST['class_id'];
  $section_id=$_REQUEST['section_id'];
  $session_id=$_REQUEST['sessionid'];
  
  $result= getClasswiseExam($class_id,$section_id,$session_id);
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
   $responce['status']=2;
   $responce['message']="Please Provide Required Parameter class_id,section_id,and session_id";
   echo json_encode($response);
  
  }
 
  
  
 ?>
