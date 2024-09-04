<?php
if (isset($_REQUEST['registration_no'])) {
  $registration_no = $_REQUEST['registration_no'];
} else {
  $registration_no = '';
}
include('myfunction.php');

if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['class_id'])) {

  $teacher_id = $_REQUEST['teacher_id'];

  // $session=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
  if (isset($_REQUEST['session_id']) &&  !empty($_REQUEST['session_id'])) {
    $session = $_REQUEST['session_id'];
  } else {
    $response["status"] = 3;
    $response["message"] = "Session_id no Found";
    $response["result"] = [];
    echo json_encode($response);
    die;
  }

  $Result = assignsection($teacher_id, $class_id, $session);

  if (!empty($Result)) {

    $response["result"] = $Result;
    $response["status"] = 1;
    $response["message"] = "Success";

    echo json_encode($response);
  } else {

    $response["status"] = 0;
    $response["message"] = "NO Section is Assign Yet";
    $response["result"] = [];
    echo json_encode($response);
  }
} else {
  $response["status"] = 2;
  $response["message"] = "Requires Parameter Teacher id ,class id , session_id or registration_no is Missing";
  $response["result"] = [];
  echo json_encode($response);
}
