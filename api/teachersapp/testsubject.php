<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
include('myfunction.php');

if (isset($_REQUEST['classid']) && isset($_REQUEST['sectionid']) && isset($_REQUEST['testname'])) {

  // $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';

  if (isset($_REQUEST['session_id']) && !empty($_REQUEST['session_id'])) {
    $session_id = $_REQUEST['session_id'];
  } else {
    $Responce['status'] = '2';
    $Responce['message'] = 'session_id not found';
    $response["result"] = [];
    echo json_encode($Responce);
    die;
  }

  $classid = $_REQUEST['classid'];

  $sectionid = $_REQUEST['sectionid'];

  $testname = $_REQUEST['testname'];

  $result = testsubject($classid, $sectionid, $testname, $session_id);



  if (!empty($result)) {



    $response["result"] = $result;

    $response["status"] = 1;

    $response["message"] = "Success";


    echo json_encode($response);
  } else {

    $response["status"] = 0;

    $response["message"] = "No Subject Found For this Class";
    $response["result"] = [];

    echo json_encode($response);
  }
} else {

  $response["status"] = 2;

  $response["message"] = "Required Parameter class, section or subject is missing";
  $response["result"] = [];

  echo json_encode($response);
}
