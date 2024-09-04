<?php
$registration_no = isset($_REQUEST['registration_no']) ? $_REQUEST['registration_no'] : '';
// if(isset($_REQUEST['teacher_id']) ){

$teacher_id = $_REQUEST['teacher_id'];


include('myfunction.php');
if (isset($_REQUEST['session_id'])) {
  $session = $_REQUEST['session_id'];
} else {
  $session = '';
}


$result = attendancetype();
if (!empty($result)) {
  $response["result"] = $result;
  $response['status'] = 1;
  $response['message'] = "Success";
  echo json_encode($response);
} else {


  $response["status"] = 0;
  $response["message"] = "No Record Found";
  $response["result"] = [];
  echo json_encode($response);
}

// }else{
// 	$response["status"] = 2;

// 	$response["message"] = "Required Parameter Teacher id"; 

//     echo json_encode($response);

// }



// $body = file_get_contents('php://input');

// $object = json_decode($body);
