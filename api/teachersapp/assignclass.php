<?php
if (isset($_REQUEST['registration_no'])) {
  $registration_no = $_REQUEST['registration_no'];
} else {
  $registration_no = '';
}
include('myfunction.php');

if (isset($_REQUEST['id'])) {

  $teacher_id = $_REQUEST['id'];

  // $session=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

  if (!empty($_REQUEST['session_id'])) {
    $session = $_REQUEST['session_id'];
  } else {
    // $session='';
    $response["status"] = 3;
    $response["message"] = "Session_id no Found";
    $response["result"] = [];
    echo json_encode($response);
    die;
  }

  $Result = assignclass($teacher_id, $session);

  if (!empty($Result)) {

    $response["result"] = $Result;
    $response["status"] = 1;
    $response["message"] = "Success";

    echo json_encode($response);
  } else {

    $response["status"] = 0;
    $response["message"] = "NO Class is Assigne Yet";
    $response["result"] = [];
    echo json_encode($response);
  }
} else {
  $response["status"] = 2;
  $response["message"] = "Requires Parameter Teacher id or registration_no is Missing";
  $response["result"] = [];
  echo json_encode($response);
}
