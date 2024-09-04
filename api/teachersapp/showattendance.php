<?php

if (isset($_REQUEST['classid']) && isset($_REQUEST['sectionid']) && isset($_REQUEST['atdate'])) {

  if (isset($_REQUEST['registration_no'])) {
    $registration_no = $_REQUEST['registration_no'];
  } else {
    $registration_no = '';
  }

  include('myfunction.php');
  $session_id = isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

  if (!empty($_REQUEST['teacher_id'])) {
    $teacher_id = $_REQUEST['teacher_id'];
  } else {
    $teacher_id = '';
  }

  $classid = $_REQUEST['classid'];
  $sectionid = $_REQUEST['sectionid'];
  $atdate = $_REQUEST['atdate'];
  $result = showattendance($teacher_id, $classid, $sectionid, $atdate, $session_id);

  if (!empty($result)) {
    $response["status"] = 1;
    $response["message"] = "Success";
    $response["attendance_taken"] = $result[1];
    $response["result"] = $result[0];

    echo json_encode($response);
  } else {

    $response["status"] = 0;
    $response["message"] = "Not Found";  //Attendance Not Taken Yet
    $response["result"] = [];
    echo json_encode($response);
  }
} else {
  $response["status"] = 2;
  $response["message"] = "Required Parameter Id, class, section,registration_no or Date is missing";
  $response["result"] = [];
  echo json_encode($response);
}
