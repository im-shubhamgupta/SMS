<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';

include('myfunction.php');

if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['classid']) && isset($_REQUEST['sectionid'])) {

  // $session_id=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
  if (isset($_REQUEST['session_id']) && !empty($_REQUEST['session_id'])) {
    $session_id = $_REQUEST['session_id'];
  } else {
    $response["status"] = 3;
    $response["message"] = "session_id not found ";
		$response["result"] = [];
    echo json_encode($response);
    die;
  }

  $teacher_id = $_REQUEST['teacher_id'];
  $classid = $_REQUEST['classid'];

  $sectionid = $_REQUEST['sectionid'];
  // $session=profile($teacher_id)['session'];



  $result = testname($session_id, $classid, $sectionid);



  if (!empty($result)) {



    $response["result"] = $result;

    $response["status"] = 1;

    $response["message"] = "Success";
    
    echo json_encode($response);
  } else {



    $response["status"] = 0;

    $response["message"] = "No Test Is Assigned to this class";
    $response["result"] = [];
    echo json_encode($response);
  }
} else {



  $response["status"] = 2;

  $response["message"] = "Requires Parameter Teacher id, Class id or Section Id  is Missing";
  $response["result"] = [];
  echo json_encode($response);
}
