<?php
if (isset($_REQUEST['id'])) {
	if (isset($_REQUEST['registration_no'])) {
		$registration_no = $_REQUEST['registration_no'];
	} else {
		$registration_no = '';
	}
	include('myfunction.php');
	$teacher_id = $_REQUEST['id'];

	// $section_id=isset($_REQUEST['section_id']) ? $_REQUEST['section_id'] : '';

	if (isset($_REQUEST['class_id']) && !empty($_REQUEST['class_id'])) {
		$class_id = $_REQUEST['class_id'];
	} else {

		$Responce['status'] = '2';
		$Responce['message'] = 'class_id not found';
		$response["result"] = [];
		echo json_encode($Responce);
		die;
	}
	if (isset($_REQUEST['section_id']) && !empty($_REQUEST['section_id'])) {
		$section_id = $_REQUEST['section_id'];
	} else {
		$Responce['status'] = '2';
		$Responce['message'] = 'section_id not found';
		$response["result"] = [];
		echo json_encode($Responce);
		die;
	}


	if (isset($_REQUEST['session_id']) && !empty($_REQUEST['session_id'])) {
		$session = $_REQUEST['session_id'];
	} else {
		$Responce['status'] = '2';
		$Responce['message'] = 'session_id not found';
		$response["result"] = [];
		echo json_encode($Responce);
		die;
		$session = '';
	}



	$sql = "select `subject_id`,`class_id` from assign_subject where st_id='$teacher_id' and class_id='$class_id' and section_id='$section_id' ";
	$Query = $con->query($sql);
	$Responce = array();
	if ($Query->num_rows > 0) {
		$i = 0;
		while ($Res = $Query->fetch_assoc()) {

			$sub_id = $Res['subject_id'];

			$clsid = $Res['class_id'];

			$classq1 = mysqli_query($con, "select * from class where class_id='$clsid'");
			$classr1 = mysqli_fetch_array($classq1);
			$clsname = $classr1['class_name'];

			$q1 = mysqli_query($con, "select * from subject where subject_id='$sub_id'");
			$r1 = mysqli_fetch_array($q1);
			$subject_id = $r1['subject_id'];
			$subject_name = $r1['subject_name'];

			$temp[$i]['subject_id'] = $subject_id;
			$temp[$i]['subject_name'] = $subject_name;
			$temp[$i]['classname'] = $clsname;
			$i++;
		}

		$Responce["result"] = $temp;
		$Responce['status'] = '1';
		$Responce['message'] = 'Success';



		echo json_encode($Responce);
	} else {
		$Responce = array();
		$Responce['status'] = '0';
		$Responce['message'] = 'No Subject Assigned';
		$response["result"] = [];

		echo json_encode($Responce);
	}
} else {
	$Responce = array();
	$Responce['status'] = '2';
	$Responce['message'] = 'Requires Parameter Teacher id is Missing';
	$response["result"] = [];

	echo json_encode($Responce);
}
