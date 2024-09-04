<?php


if (isset($_REQUEST['classid']) && isset($_REQUEST['sectionid']) && isset($_REQUEST['testname']) && isset($_REQUEST['subjectid'])  && isset($_REQUEST['exam_list'])) {

  $exam_list = $_REQUEST['exam_list'];

  // && isset($_REQUEST['studentid'])&& isset($_REQUEST['marks'])
  if (isset($_REQUEST['registration_no'])) {
    $registration_no = $_REQUEST['registration_no'];
  } else {
    $registration_no = '';
  }
  include('myfunction.php');
  // $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
  if (!empty($_REQUEST['session_id'])) {
    $session_id = $_REQUEST['session_id'];
  } else {
    // $session='';
    $response["status"] = 3;
    $response["message"] = "Session_id no Found";
    $response["result"] = [];
    echo json_encode($response);
    die;
  }
  $studentid = isset($_REQUEST['studentid']) ? $_REQUEST['studentid'] : '';
  $marks = isset($_REQUEST['marks']) ? $_REQUEST['marks'] : '';

  // if(empty($_REQUEST['marks'])){
  //    $response["status"] = 0;
  //    $response["message"] = "Please Enter Marks";
  //    echo json_encode($response); die;

  // }
  if (!empty($_REQUEST['markid'])) {
    $markid = $_REQUEST['markid'];
  } else {
    $markid = "";
  }

  $Result = exammarks($_REQUEST['classid'], $_REQUEST['sectionid'], $_REQUEST['testname'], $_REQUEST['subjectid'], $studentid, $marks, $markid, $session_id, $exam_list);

  if ($Result == 'insert') {

    $response["result"] = "Marks Inserted Successfully";
    $response["status"] = 1;
    $response["message"] = "Success";
    echo json_encode($response);
  } elseif ($Result == 'update') {

    $response["result"] = "Marks Updated Successfully";
    $response["status"] = 1;
    $response["message"] = "Success";
    echo json_encode($response);
  }
  // elseif($Result== 'maxmark'){

  //   $response["result"] = "Marks is not greater than Max marks.";
  //   $response["status"] = 3;
  //   $response["message"] = "Marks is not greater than Max marks.";
  //   echo json_encode($response); 


  // }   
  else {

    $response["status"] = 0;
    $response["message"] = "Something went wrong, plesae try again";
    $response["result"] = [];
    echo json_encode($response);
  }
} else {
  $response["status"] = 2;
  $response["message"] = "Required Parameter is missing!";
  $response["result"] = [];
  echo json_encode($response);
}
