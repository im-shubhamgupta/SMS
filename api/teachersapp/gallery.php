<?php
// print_r($_REQUEST);
if (isset($_REQUEST['teacher_id']) && isset($_REQUEST['classid']) && isset($_REQUEST['sectionid'])  && isset($_FILES['image']['name'])) {

	if (isset($_REQUEST['registration_no'])) {
		$registration_no = $_REQUEST['registration_no'];
	} else {
		$registration_no = '';
	}
	include('myfunction.php');
	date_default_timezone_set("Asia/Kolkata");
	$image = $_FILES['image']['name'];
	$teacher_id = $_REQUEST['teacher_id'];
	$sectionid = $_REQUEST['sectionid'];
	$classid = $_REQUEST['classid'];
	$heading = mysqli_real_escape_string($con, $_REQUEST['heading']);
	$message = mysqli_real_escape_string($con, $_REQUEST['message']);
	$nmsg = urlencode($_REQUEST['message']);


	if (isset($_REQUEST['session_id']) and !empty($_REQUEST['session_id'])) {
		$session = $_REQUEST['session_id'];
		$sr_session_sql = " && sr.session=$session ";
	} else {
		$session = '';
		$sr_session_sql = '';
	}


	if (empty($_FILES['image']['name'])) {
		$response['status'] = 4;
		$response['message'] = 'Image is Required';
		$response["result"] = [];
		echo json_encode($response);
		die;
	}
	// print_r($_FILES);
	// die;

	// $q1 = mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$sectionid'");
	$sql1 = "select student_id,student_name,parent_no,msg_type_id,father_name,gender,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where stu_status='0'  and sr.class_id='$classid' and sr.section_id='$sectionid'  $sr_session_sql ";
	$q1 = mysqli_query($con, $sql1);

	$row = mysqli_num_rows($q1);

	if ($row) {



		foreach ($_FILES['image']['name'] as $key => $img) {
			// foreach ($_FILES["image"]["error"] as $key => $img){




			$name = explode('.', $img);
			$ext = pathinfo($img, PATHINFO_EXTENSION);
			$num = substr($name[0], 0, 4);                   //take four letter only 
			$image_name = $num . '_' . date("Ymd-His") . '_' . rand(111, 999) . '.' . trim($ext);
			// $response['status']=3;		
			// $response['message']=$_FILES['image']['tmp_name'][$key];		
			// echo json_encode($response);die;

			$mul_img2[] = $image_name;
			$move_img = move_uploaded_file($_FILES['image']['tmp_name'][$key], "../../gallery/" . $image_name);
			// $move_img=move_uploaded_file($_FILES['image']['tmp_name'][$key],$image_name);


		}

		if ($move_img) {
			$image_n = implode(', ', $mul_img2);

			while ($r1 = mysqli_fetch_array($q1)) {

				$studid = $r1['student_id'];

				$mobile = $r1['parent_no'];
				$arr_mob[] = $mobile;


				$sql = "insert into student_notifications(category,student_id,class_id,section_id,selected_no,heading,message,photos,session,notice_datetime,date,login_user_id)
				  values(4,'$studid','$classid','$sectionid','$mobile','$heading','$message','$image_n','$session',now(),now(),'$teacher_id')";

				$q2 = mysqli_query($con, $sql);
			}
			//seperate for send whatsapp message---------------------------------
			if (!empty($arr_mob) && !empty($nmsg)) {
				$msg_type = "gallery_msg";
				foreach (array_unique($arr_mob) as $mo) {
					$result = sendwhatsappMessage($mo, $nmsg, $msg_type);
				}
			}
			//seperate for send whatsapp message---------------------------------

			// -----------------send push notification for each parent----------------------	

			$qpush = mysqli_query($con, $sql1);
			if (mysqli_num_rows($qpush) > 0) {
				while ($row = mysqli_fetch_array($qpush)) {
					$token_id = $row['token_id'];
					// $classname=get_class_byid($classid)['class_name'];
					$Title = "New Gallery Created";
					$Remarks = 'Regards \n ' . get_school_details()['company_name'];
					$type = 'notification_attendance';
					$resp = push_notification_android($token_id, $Title, $Remarks, $type);
				}
			}

			// -----------------send push notification for each parent----------------------	

			$device_id = get_staff_byid($teacher_id)['token_id'];
			$classname = get_class_byid($classid)['class_name'];
			$Title = $classname . "Gallery Uploaded Successfully";
			$Remarks = 'Gallery Saved';
			$type = 'notification_gallery';
			push_notification_android($device_id, $Title, $Remarks, $type);

			$response['status'] = 1;
			$response['message'] = 'Success';
			$response["result"] = [];
			echo json_encode($response);
		} else {

			$response['status'] = 3;
			$response['message'] = 'Image not Uploaded , Please Try Again';
			$response["result"] = [];
			echo json_encode($response);
		}
	} else {

		$response['status'] = 0;
		$response['message'] = 'Failed , Please Try Again';
		$response['result'] = [];
		echo json_encode($response);
	}
} else {

	$response["status"] = 2;
	$response["message"] = "Required Parameter Id, class, section, message or Image is missing";
	$response["result"] = [];
	echo json_encode($response);
}


		

		

								
		// if(move_uploaded_file($_FILES['image']['tmp_name'],"../../gallery/".$image_name)){
