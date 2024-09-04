<?php


if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['classid']) && isset($_REQUEST['sectionid']) && isset($_REQUEST['fromdate'])  && isset($_REQUEST['todate'])) {

  if (isset($_REQUEST['registration_no'])) {
    $registration_no = $_REQUEST['registration_no'];
  } else {
    $registration_no = '';
  }
  include('myfunction.php');
  // $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

  if (!empty($_REQUEST['fromdate'])) {
    $fromdate = $_REQUEST['fromdate'];
  } else {
    $error = "fromdate not found";
  }
  if (!empty($_REQUEST['todate'])) {
    $todate = $_REQUEST['todate'];
  } else {
    $error = "todate not found";
  }
  if (!empty($_REQUEST['classid'])) {
    $classid = $_REQUEST['classid'];
  } else {
    $error = "classid not found";
  }
  if (!empty($_REQUEST['sectionid'])) {
    $sectionid = $_REQUEST['sectionid'];
  } else {
    $error = "sectionid not found";
  }
  if (!empty($_REQUEST['session_id'])) {
    $session_id = $_REQUEST['session_id'];
  } else {
    $error = "session_id not found";
  }
  if (isset($error)) {
    $response["status"] = 4;
    $response["message"] = $error;
    $response["result"] = [];
    echo json_encode($response);
    die;
  }
  $current_page = isset($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '';
  $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '';

  echo $result = eventcalendar($_REQUEST['classid'], $_REQUEST['sectionid'], $_REQUEST['fromdate'], $_REQUEST['todate'], $session_id, $current_page, $per_page);



  // if(!empty($result)){


  //     $response["status"] = 1;

  //     $response["message"] = "Success";  
  //     $response["current_page"] = $result['current_page'];
  //     $response["per_page"] = $result['per_page'];
  //     $response["total_page"] = $result['total_page'];
  //     $response["total_records"] = $result['total_records'];
  //     $response["result"] = $result['data'];  
  //     echo json_encode($response);   



  // }else{



  //   $response["status"] = 0;

  // $response["message"] = "No Event Created";   

  //   echo json_encode($response);  

  // }



} else {

  $response["status"] = 2;

  $response["message"] = "Require Parameter is Missing";
  $response["result"] = [];

  echo json_encode($response);
}
