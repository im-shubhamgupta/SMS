<?php
$registration_no=isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
 include_once('myfunction.php');
 
 if(isset($_REQUEST['class_id']) && isset($_REQUEST['section_id']) && isset($_REQUEST['sessionid'])){
 
 $class_id=$_REQUEST['class_id'];
 $section_id=$_REQUEST['section_id'];
 $session_id=$_REQUEST['sessionid'];
  if(isset($_REQUEST['date'])){
  $date=$_REQUEST['date'];
  }else{
  $date=(date("Y-m-d"));
  }
  $current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '1';
  $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

 $result= getClasswiseAttendance($class_id,$section_id,$session_id,$date,$current_page,$per_page);
 if(!empty($result['total_records'])){
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
   $responce['message']="Please Provide Required Parameter class_id,section_id,and section_id";
    echo json_encode($response);
 }