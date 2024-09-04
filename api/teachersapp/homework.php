<?php
// print_r($_REQUEST);
// print_r($_FILES);
if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['classid']) && isset($_REQUEST['sectionid']) && isset($_REQUEST['message'])) {
	if (isset($_REQUEST['registration_no'])) {
		$registration_no = $_REQUEST['registration_no'];
	} else {
		$registration_no = '';
	}
	include('myfunction.php');
	// $session=isset($_REQUEST['session_id']) ? $_REQUEST['session_id'] : '';
	if (!empty($_REQUEST['session_id'])) {
		$session = $_REQUEST['session_id'];
	} else {
		$response["status"] = 3;
		$response["message"] = "Session_id no Found";
		$response["result"] = [];
		echo json_encode($response);
		die;
	}
	$subjectid = isset($_REQUEST['subjectid']) ? $_REQUEST['subjectid'] : '';

	date_default_timezone_set("Asia/Kolkata");
	$teacher_id = $_REQUEST['teacher_id'];
	$classid = $_REQUEST['classid'];
	$sectionid = $_REQUEST['sectionid'];
	$message = mysqli_real_escape_string($con, $_REQUEST['message']);
	$nmsg = $_REQUEST['message'];

	$staffname = get_staff_details_byid($_REQUEST['teacher_id'])['staff_name'];
	// $staffname= $_REQUEST['staffname']; 
	if (!empty($_REQUEST['heading'])) {
		$heading = mysqli_real_escape_string($con, $_REQUEST['heading']);
	} else {
		$heading = '';
	}



	if (isset($_FILES['attachment']['name'])) {

		foreach ($_FILES['attachment']['name'] as $key => $img) {

			$name = explode('.', $img);
			$ext = pathinfo($img, PATHINFO_EXTENSION);
			$num = substr($name[0], 0, 4);                   //take four letter only 
			$image_name = $num . '_' . date("Ymd-His") . '_' . rand(111, 999) . '.' . $ext;
			$mul_img2[] = $image_name;
			$move_img = move_uploaded_file($_FILES['attachment']['tmp_name'][$key], "../../images/assignment/" . $image_name);
		}
		if ($move_img) {
			$attach_name = implode(', ', $mul_img2);
		} else {
			$attach_name = '';
		}
	} else {
		$attach_name = '';
	}

	$result = homework($teacher_id, $classid, $sectionid, $message, $nmsg, $staffname, $heading, $attach_name, $session, $subjectid);



	if (!empty($result)) {

		$response["result"] = $result;
		$response["status"] = 1;
		$response["message"] = "Success";
		echo json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "Students Not Found";
		$response["result"] = [];
		echo json_encode($response);
	}

	// echo homework($object->classid,$object->sectionid,$object->message,$object->staffname);

} else {
	$response["status"] = 2;
	$response["message"] = "Required Parameter Teacher id ,classid, sectionid, message is missing";
	$response["result"] = [];
	echo json_encode($response);
}


