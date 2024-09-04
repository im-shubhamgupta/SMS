<?php
include('../dbcontroller.php');
extract($_REQUEST);


function get_student_byid($stuid)
{
	global $con;
	$response = array();
	$sset1 = mysqli_query($con, "select `student_name` from `students` where `student_id`='$stuid' ");

	if (mysqli_num_rows($sset1) > 0) {
		$rsset = mysqli_fetch_assoc($sset1);

		$response['student_name'] = $rsset['student_name'];

		return $response;
	} else {
		return array();
	}
}
function get_attendence_type_byid($att_type_id)
{
	global $con;
	$response = array();
	$q3 = mysqli_query($con, "select * from attendance_type where att_type_id='$att_type_id'");
	if (mysqli_num_rows($q3) > 0) {
		$rsset = mysqli_fetch_assoc($q3);
		$response['att_type_name'] = $rsset['att_type_name'];

		return $response;
	} else {
		return array();
	}
}
function get_staff_details_byid($st_id)
{
	global $con;
	$response = array();
	$sset1 = mysqli_query($con, "select * from `staff` where `st_id`='$st_id' ");
	if (mysqli_num_rows($sset1) > 0) {
		$rsset = mysqli_fetch_assoc($sset1);

		$response['staff_name'] = $rsset['staff_name'];

		return $response;
	} else {
		return array();
	}
}

function login($mobile, $password, $user_type, $session, $token_id)
{

	global $con;

	$query = $con->query("select * from staff where mobno='$mobile' && password='$password'");
	// $session=1;
	if ($query->num_rows > 0) {
		$res = $query->fetch_assoc();
		@$temp = array();
		$Teacherid = $res['st_id'];
		$temp['id'] = $res['st_id'];
		$temp['staffname'] = $res['staff_name'];
		// $temp['token_id'] = $token_id; //token_id='$token_id' 
		// echo "update staff SET session='$session'  where  id='$Teacherid'";  session='$session'
		$query = $con->query("update staff SET  session='$session'  where  st_id='$Teacherid'");
	}
	return $temp;
}


function profile($id)
{
	global $con;

	$sql = "select * from staff where st_id='$id'";
	$query = mysqli_query($con, $sql);

	if (mysqli_num_rows($query) > 0) {
		$res = mysqli_fetch_assoc($query);
		@$temp = array();
		$temp['id'] = $res['st_id'];
		$temp['staff_name'] = $res['staff_name'];
		$temp['designation'] = $res['designation'];
		$temp['mobno'] = $res['mobno'];
		$temp['address'] = $res['address'];
		// $temp['session'] = $res['session'];
		$temp['staff_id'] = $res['staff_id'];
		$temp['token_id'] = $res['token_id'];
		$temp['gender'] = $res['gender'];
		$temp['joining_date'] = date('d-m-Y', strtotime($res['joining_date']));
		$temp['qualification'] = $res['qualification'];
		$temp['teaching_type'] = $res['teaching_type'];

		// $temp['image'] = ($res['image']) ? $res['image'] : "no_image.png";

		$temp['image'] = Call_Baseurl() . '/' . get_staff_byid($res['st_id'])['image_path'];


		return $temp;
	} else {
		$temp = array();
		return $temp;
	}
}


function assignclass($id, $session)
{
	global $con;
	$data = array();
	$sql = "select * from assign_clsteacher where st_id='$id' && session='$session' group by class_id ";
	$query = mysqli_query($con, $sql);
	if (mysqli_num_rows($query) > 0) {
		while ($res = mysqli_fetch_assoc($query)) {
			$clsid = $res['class_id'];
			$q1 = mysqli_query($con, "select * from class where class_id='$clsid' ");
			$r1 = mysqli_fetch_array($q1);
			$clsname = $r1['class_name'];
			@$temp = array();
			$temp['class_id'] = $clsid;
			$temp['class_name'] = $clsname;

			array_push($data, $temp);
		}
	}
	return $data;
}
function assignsection($id, $class_id, $session)
{
	global $con;
	$data = array();

	$sql = "select * from assign_clsteacher where st_id='$id' and class_id='$class_id' && session='$session' ";
	$query = mysqli_query($con, $sql);
	if (mysqli_num_rows($query) > 0) {
		while ($res = mysqli_fetch_assoc($query)) {
			$secid = $res['section_id'];
			$q2 = mysqli_query($con, "select * from section where section_id='$secid'");
			$r2 = mysqli_fetch_array($q2);
			$secname = $r2['section_name'];
			@$temp = array();
			$temp['section_id'] = $secid;
			$temp['section_name'] = $secname;
			array_push($data, $temp);
		}
	}
	return $data;
}


function SectionAccordingClass($classid, $session)
{

	global $con;
	$data = array();
	// $sr_session_sql=($session) ? " && sr.session=$session " : ''; 
	$query = mysqli_query($con, "select * from section where class_id='$classid'");
	if (mysqli_num_rows($query) > 0) {
		while ($res = mysqli_fetch_assoc($query)) {
			$temp = array();
			$temp['section_id'] = $res['class_id'];
			$temp['section_name'] = $res['section_name'];
			$temp['class_id'] = $res['class_id'];

			array_push($data, $temp);
		}
		return $data;
	}
	return '';
}

function testname($session, $classid, $sectionid)
{
	global $con;
	$data = array();
	$session_sql = ($session) ? " && session=$session " : '';
	// $sql="select distinct(test_name) from test where class_id='$classid' && section_id='$sectionid' $session_sql ";
	$sql = "select max_marks,test_name from test where class_id='$classid' && section_id='$sectionid' $session_sql group by test_name ";
	$q1 = mysqli_query($con, $sql);
	$row = mysqli_num_rows($q1);
	if ($row) {
		while ($r1 = mysqli_fetch_array($q1)) {
			@$temp = array();
			$temp['test_name'] = $r1['test_name'];
			$temp['max_marks'] = $r1['max_marks'];
			array_push($data, $temp);
		}

		return $data;
	} else {
		// return $data;
		return '';
	}
}


function testsubject($classid, $sectionid, $testname, $session)
{
	global $con;
	$data = array();

	$sql = "select * from test where class_id='$classid' && section_id='$sectionid' && test_name='$testname'  && session='$session'  ";
	$q1 = mysqli_query($con, $sql);
	$row = mysqli_num_rows($q1);
	if ($row) {
		while ($r1 = mysqli_fetch_array($q1)) {
			$subjectid = $r1['subject_id'];
			$SubSql = "select * from subject where subject_id='$subjectid'";
			$q2 = mysqli_query($con, $SubSql);
			$r2 = mysqli_fetch_array($q2);
			$subjectname = $r2['subject_name'];

			@$temp = array();
			$temp['subject_id'] = $subjectid;
			$temp['subject_name'] = $subjectname;
			array_push($data, $temp);
		}

		return $data;
	} else {
		// return $data;
		return '';
	}
}



function attendancetype()
{
	global $con;
	$data = array();
	$query = mysqli_query($con, "select * from attendance_type");

	if (mysqli_num_rows($query) > 0) {
		while ($res = mysqli_fetch_assoc($query)) {
			@$temp = array();
			$temp['att_type_id'] = $res['att_type_id'];
			$temp['att_type_name'] = $res['att_type_name'];
			$temp['short_name'] = $res['short_name'];
			array_push($data, $temp);
		}
		return $data;
		// echo json_encode($data);
	} else {
		// return "Invalid Details";
		return array();
	}
}


/*
function showattendance($classid,$sectionid,$atdate)
{
	global $con;
	$data = array();

	 $sql="select * from student_daily_attendance where class_id='$classid' && section_id='$sectionid' && date='$atdate'";
	$query=mysqli_query($con,$sql);
	$row = mysqli_num_rows($query);
	if($row>0)  
	{ 
		$q1 = mysqli_query($con,"select * from students where class_id='$classid' && section_id='$sectionid' order by (student_id)");
		while($r1 = mysqli_fetch_assoc($q1))
		{
			
		  @$temp = array();
		  $temp['student_att_id'] = "";
	    $temp['register_no'] = $r1['register_no'];
	    $temp['student_id'] = $r1['student_id'];
	    $temp['student_name'] = $r1['student_name'];
		  $temp['attendance_type_id'] = "";
	    $temp['attendance_type_name'] = "";
		array_push($data, $temp);
		}
		return $data;
		
	}
	else
	{
		$sql2="select * from students where class_id='$classid' && section_id='$sectionid' order by (student_id)";
		$q2 = mysqli_query($con,$sql2);
		while($r2 = mysqli_fetch_assoc($q2))
		{
			$stuid = $r2['student_id'];
		  $sql3="select * from student_daily_attendance where student_id='$stuid' && date='$atdate'";
			$status = mysqli_query($con,$sql3);
			$attres = mysqli_fetch_array($status);
			$student_att_id = $attres['student_att_id'];   //attendence id
			$attend_type_id = $attres['type_of_attend'];   //type of attendence
			
			$q3 = mysqli_query($con,"select * from attendance_type where att_type_id='$attend_type_id'");
			$r3 = mysqli_fetch_array($q3);
			$attendname = $r3['att_type_name'];
			
		if(empty( $student_att_id)){
		    
		     $student_att_id='';
		}
		
		if(empty( $attend_type_id)){
		    
		     $attend_type_id='';
		}
		
		if(empty( $attendname)){
		    
		     $attendname='';
		}
		if(empty( $r2['register_no'])){
		    
		      $r2['register_no']='';
		}
			
		@$temp = array();
	    $temp['student_att_id'] = $student_att_id;
	    $temp['register_no'] = $r2['register_no'];
	    $temp['student_id'] = $stuid;
	    $temp['student_name'] = $r2['student_name'];
	    $temp['attendance_type_id'] = $attend_type_id;
	    $temp['attendance_type_name'] = $attendname;
		array_push($data, $temp);
		}
		 return $data;
		
	}
}

*/

function getAttendencedata($student_id, $atdate)
{
	global $con;
	$data = array();
	$sql = "select * from student_daily_attendance where student_id='$student_id'  and date='$atdate'";
	$q = mysqli_query($con, $sql);
	$r = mysqli_num_rows($q);
	if ($r > 0) {
		$AttendaceData = mysqli_fetch_assoc($q);
		if (!empty($AttendaceData['type_of_attend'])) {
			$data['attendance_type_id'] = $AttendaceData['type_of_attend'];
			$data['attendance_type_name'] = get_attendence_type_byid($AttendaceData['type_of_attend'])['att_type_name'] ?? '';
			$data['reason'] = $AttendaceData['reason'];
		} else {
			$data['attendance_type_id'] = 'NA';
			$data['attendance_type_name'] = 'Not Available';
			$data['reason'] = 'NA';
		}
		return $data;
	} else {

		$data['attendance_type_id'] = 'NA';
		$data['attendance_type_name'] = 'Not Available';
		$data['reason'] = 'NA';
		return $data;
	}
}


function showattendance($teacher_id, $classid, $sectionid, $atdate, $session)
{
	global $con;
	$data = array();
	// $sr_session_sql=($session) ? " && sr.session=$session " : ''; 
	if (!empty($teacher_id)) {
		$login_user_id = $teacher_id;
	} else {
		$login_user_id = "0";
		// $session=1;
	}
	$sql = "select * from student_daily_attendance where class_id='$classid' and section_id='$sectionid'  and date='$atdate' and session='$session' ";
	$q1 = mysqli_query($con, $sql);
	if (mysqli_num_rows($q1) > 0) {
		// $temp['attendance_taken']='1';
		// array_push($data,$temp);
		$attendance_taken = '1';
	} else {
		// $temp['attendance_taken']='0';
		// array_push($data,$temp);
		$attendance_taken = '0';
	}

	$sql2 = "select student_id,student_name,sr.class_id from students as s join student_records as sr on s.student_id=sr.stu_id where sr.class_id='$classid' && sr.section_id='$sectionid' && sr.session='$session' && stu_status='0' ";

	$query = mysqli_query($con, $sql2);
	$row = mysqli_num_rows($query);
	if ($row > 0) {
		$count = 1;
		while ($Satt = mysqli_fetch_assoc($query)) {
			@$temp = array();

			$temp['count'] = $count;
			$temp['student_id'] = $Satt['student_id'];
			$temp['student_name'] = $Satt['student_name'];
			$temp['student_img'] = Call_Baseurl() . '/' . getStudent_byStudent_id($Satt['student_id'])['stu_image_path'];
			$temp['attendance_type_id'] = getAttendencedata($Satt['student_id'], $atdate)['attendance_type_id'];
			$temp['attendance_type_name'] = getAttendencedata($Satt['student_id'], $atdate)['attendance_type_name'];
			$temp['leave_reason'] = getAttendencedata($Satt['student_id'], $atdate)['reason'];
			$temp['date'] = $atdate;
			array_push($data, $temp);
			$count++;
		}
		return array($data, $attendance_taken);
	} else {
		$data = array();
		return $data;
	}
}


// $stuid,$attendanceid,
function studentattendance($teacher_id, $attendance_list, $atdate, $reason, $session, $class_id, $section_id)
{
	global $con;

	$reason = "";
	$username = '';
	$messagetype = '';
	$title = "Attendance ";

	$array = json_decode($attendance_list, true);

	// print_r($array);

	$sclname = get_school_details()['company_name'];



	$date = date("d-m-Y", strtotime($atdate));

	$presentmsg = "Dear Parents,%0aYour son/daughter has been Present today.%0a" . $date . ".%0aRegards,%0a" . $sclname . "%0aISCTDT";

	$npresentmsg = "Dear Parents,<br>Your son/daughter has been Present today.<br>" . $date . ".<br>Regards,<br>" . $sclname . "<br>ISCTDT";

	$absentmsg = "Dear Parents,%0aYour son/daughter has been Absent today.%0a" . $date . ".%0aRegards,%0a" . $sclname . "%0aISCTDT";

	$nabsentmsg = "Dear Parents,<br>Your son/daughter has been Absent today.<br>" . $date . ".<br>Regards,<br>" . $sclname . "<br>ISCTDT";

	$leavemsg = "Dear Parents,%0aYour son/daughter has been Leave on today.%0a" . $date . ".%0aRegards,%0a" . $sclname . "%0aISCTDT";

	$nleavemsg = "Dear Parents,<br>Your son/daughter has been Leave on today.<br>" . $date . ".<br>Regards,<br>" . $sclname . "<br>ISCTDT";

	// $newstuid=$stuid;
	if (!empty($teacher_id)) {

		$login_user_id = $teacher_id;
	} else {
		$login_user_id = "0";
	}
	$seSql = ($session) ? " AND `session`='$session' " : '';
	$srSql = ($session) ? " AND `sr`.`session`='$session' " : '';

	// $PresentWhatsappmob = array();
	// $AbsentWhatsappmob = array();
	// $LeaveWhatsappmob = array();
	$PresentTextmob = array();
	$AbsentTextmob = array();
	$LeaveTextmob = array();


	$sql = "select * from student_daily_attendance where class_id='$class_id' AND section_id='$section_id'  AND date='$atdate' $seSql";
	$q = mysqli_query($con, $sql);
	$r = mysqli_num_rows($q);

	if (!$r) { //when Insert attendance
		
		//attendance taken only ------------------------------------------------------------------
		foreach ($array as $item) {
			$newreg = getStudent_byStudent_id($item['student_id'])['register_no'];
			$newstuid = $item['student_id'];
			$newattendance = $item['attendance_type_id'];
			if ($item['attendance_type_id'] == '3') {
				$reason = $item['leave_reason'];
			} else {
				$reason = '';
			}
			
			$sql1 = "insert into student_daily_attendance (register_no,student_id,class_id,section_id,type_of_attend,date,session,reason,create_date,modify_date)values('$newreg','$newstuid','$class_id','$section_id','$newattendance','$atdate','$session','$reason',now(),now())";
			$q2 = mysqli_query($con, $sql1);
			
			$tempSql= "insert into temp_attendace (register_no,student_id,class_id,section_id,type_of_attend,date,session,reason,create_date,modify_date)values('$newreg','$newstuid','$class_id','$section_id','$newattendance','$atdate','$session','$reason',now(),now())";
			$$tempquey = mysqli_query($con, $tempSql);

		}

		//send notifications to parent APP-------------------------------------------------------
		foreach ($array as $item) {	
			$newreg = getStudent_byStudent_id($item['student_id'])['register_no'];
			$newstuid = $item['student_id'];
			$newattendance = $item['attendance_type_id'];
			if ($item['attendance_type_id'] == '3') {
				$reason = $item['leave_reason'];
			} else {
				$reason = '';
			}

			$sqll = "select student_id,student_name,parent_no,msg_type_id,father_name,gender,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where student_id='$newstuid' and stu_status='0' $srSql ";
			$que1 = mysqli_query($con, $sqll);

			$r1 = mysqli_fetch_array($que1);

			$name = $r1['student_name'];

			$class = $r1['class_id'];

			$section = $r1['section_id'];

			$mobile = $r1['parent_no'];

			$msgtype = $r1['msg_type_id'];
			$stu_token_id = ($row['token_id'] != '') ? $row['token_id'] : '';

			$fathername = $r1['father_name'];
			$gender = $r1['gender'];
			$gen = ($gender == "FEMALE") ? "Daughter" : "Son";


			if ($item['attendance_type_id'] == 1) {
				    $Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Present on " . $date . ".%0aRegards,%0a" . $sclname . ",";
					$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Present on " . $date . ".<br>Regards,<br>" . $sclname . ",";

					$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,login_user_id,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$title','$Wnmessage','$login_user_id',now(),'$atdate','$session')");
				
			} elseif ($item['attendance_type_id'] == 2) {
				
				
					$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Absent on " . $date . ".%0aRegards,%0a" . $sclname . ",";
					$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Absent on " . $date . ".<br>Regards,<br>" . $sclname . ",";

					$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,login_user_id,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$title','$Wnmessage','$login_user_id',now(),'$atdate','$session')");
				
			} elseif ($item['attendance_type_id'] == 3) {
				$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Leave on " . $date . ".%0aRegards,%0a" . $sclname . ",";
				$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Leave on " . $date . ".<br>Regards,<br>" . $sclname . ",";

					$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,login_user_id,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$title','$Wnmessage','$login_user_id',now(),'$atdate','$session')");
			}

			
		} //close for loop

		//send notifications Push and SMS only to parent -------------------------------------------------------
		/*foreach ($array as $item) {	
			$newreg = getStudent_byStudent_id($item['student_id'])['register_no'];
			$newstuid = $item['student_id'];
			$newattendance = $item['attendance_type_id'];
			if ($item['attendance_type_id'] == '3') {
				$reason = $item['leave_reason'];
			} else {
				$reason = '';
			}

			$sqll = "select student_id,student_name,parent_no,msg_type_id,token_id,father_name,gender,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where student_id='$newstuid' and stu_status='0' $srSql ";
			$que1 = mysqli_query($con, $sqll);
			if (mysqli_num_rows($que1) > 0) {
		
				$r1 = mysqli_fetch_array($que1);

				$token_id = $r1['token_id'];
				// push notification ---------------------------------
				if(!empty($token_id)){
					$Title = "Attendance Taken Today";
					$Remarks = 'Regards  ' . get_school_details()['company_name'];
					$type = 'notification_attendance';
					$resp = push_notification_android($token_id, $Title, $Remarks, $type);
				}
				// end push notification ---------------------------------

				$name = $r1['student_name'];

				$class = $r1['class_id'];

				$section = $r1['section_id'];

				$mobile = $r1['parent_no'];

				$msgtype = $r1['msg_type_id'];
				$stu_token_id = ($row['token_id'] != '') ? $row['token_id'] : '';

				$fathername = $r1['father_name'];
				$gender = $r1['gender'];
				$gen = ($gender == "FEMALE") ? "Daughter" : "Son";

				//sending sms notifications-------------------------------------------------------------

				if ($item['attendance_type_id'] == 1) {
					if ($msgtype == 1) {
						$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Present on " . $date . ".%0aRegards,%0a" . $sclname . ",";
						$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Present on " . $date . ".<br>Regards,<br>" . $sclname . ",";

						
						$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
					} elseif ($msgtype == 2) {
						$PresentTextmob[] = getStudents_text_mobno($item['student_id'], $session)['parent_no'] ?? '';

						
					}
				} elseif ($item['attendance_type_id'] == 2) {
				
					if ($msgtype == 1) {
						$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Absent on " . $date . ".%0aRegards,%0a" . $sclname . ",";
						$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Absent on " . $date . ".<br>Regards,<br>" . $sclname . ",";

						$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
					} elseif ($msgtype == 2) {
						$AbsentTextmob[] = getStudents_text_mobno($item['student_id'], $session)['parent_no'] ?? '';
						
					}
				} elseif ($item['attendance_type_id'] == 3) {
					$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Leave on " . $date . ".%0aRegards,%0a" . $sclname . ",";
					$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Leave on " . $date . ".<br>Regards,<br>" . $sclname . ",";

					if ($msgtype == 1) {
						$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
					} elseif ($msgtype == 2) {
						$LeaveTextmob[] = getStudents_text_mobno($item['student_id'], $session)['parent_no'] ?? 0;

						
					}
				}

			}		
		} //close for loop*/

		
		// if (!empty($PresentTextmob)) {
		// 	sendtextMessage($PresentTextmob, $presentmsg, $messagetype);
		// }
		// if (!empty($AbsentTextmob)) {
		// 	sendtextMessage($AbsentTextmob, $absentmsg, $messagetype);
		// }
		// if (!empty($LeaveTextmob)) {
		// 	sendtextMessage($LeaveTextmob, $leavemsg, $messagetype);
		// }

	if ($q2) {
		$device_id = get_staff_byid($teacher_id)['token_id'];
		$classname = get_class_byid($class_id)['class_name'];
		$Title = $classname . "Attendance Taken Successfully";
		$Remarks = 'Attendance Taken.';
		$type = 'notification_attendance';
		push_notification_android($device_id, $Title, $Remarks, $type);
		return "Inserted";
	} else {
		return array();
	}	
	
	

		
	} else {
		return "Already";
	}
}


function homework($teacher_id, $classid, $sectionid, $message, $nmsg, $staffname, $heading, $attach_name, $session, $subjectid)
{

	global $con;
	if (!empty($attach_name)) {
		$attachment = $attach_name;
	} else {
		$attachment = '';
	}
	// $session=profile($teacher_id)['session'];
	$sr_session_sql = ($session) ? " && sr.session=$session " : '';
	$session = ($session) ? " $session " : '';
	$subjectid = ($subjectid) ? " $subjectid " : '0';

	// $q1 = mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$sectionid' and session ='$session' "); // and msg_type_id='1'
	$sql = "select student_id,student_name,parent_no,msg_type_id,firebase_reg_id,father_name,gender,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where 1 and sr.class_id='$classid' and sr.section_id='$sectionid' $sr_session_sql  and stu_status='0'";
	$q1 = mysqli_query($con, $sql);
	$row = mysqli_num_rows($q1);
	if ($row) {
		$q3 = "INSERT INTO `staff_message`(`heading`, `class_id`, `category`, `section_id`,`subject_id`, `message`,`teacher_id`,`assignment`, `loginuser`, `date`, `status`, `session`) VALUES ( '$heading','$classid','2','$sectionid','$subjectid','$message','$teacher_id','$attach_name','$staffname',now(),'0','$session') ";
		mysqli_query($con, $q3);

		while ($r1 = mysqli_fetch_array($q1)) {

			$studid = $r1['student_id'];
			$mobile = $r1['parent_no'];
			$token = $r1['firebase_reg_id'];
			$msgtype = $r1['msg_type_id'];

			$q2 = "insert into student_notifications(category,student_id,class_id,section_id,subject,
			selected_no,heading,message,attachment,loginuser,login_user_id,notice_datetime,date,session)
			values(2,'$studid','$classid','$sectionid','$subjectid','$mobile','$heading','$message','$attachment','$staffname','$teacher_id',now(),now(),'$session')";
			mysqli_query($con, $q2);

			// $action = "Homework Sent to Class ".$clname." Section ".$sename."."; 

			$messagetype = "assignment";
			$compose = $nmsg;
			if (!empty($nmsg)) {
				if ($msgtype == 1) {

					$encod = urlencode($compose);

					$msg = $encod;

					sendwhatsappMessage($mobile, $msg, $messagetype);
				} elseif ($msgtype == 2) {

					$encod = urlencode($compose);

					$msg = $compose;

					sendtextMessage($mobile, $msg, $messagetype);
				}
			}
		} //while

		// -----------------send push notification for each parent----------------------	

		$qpush = mysqli_query($con, $sql);
		if (mysqli_num_rows($qpush) > 0) {
			while ($row = mysqli_fetch_array($qpush)) {
				$token_id = $row['token_id'];
				// $classname=get_class_byid($classid)['class_name'];
				$Title = "Assignment Received";
				$Remarks = 'Regards : ' . get_school_details()['company_name'];
				$type = 'notification_assignment';
				$resp = push_notification_android($token_id, $Title, $Remarks, $type);
			}
		}

		// -----------------send push notification for each parent----------------------	
		$device_id = get_staff_byid($teacher_id)['token_id'];
		$classname = get_class_byid($classid)['class_name'];
		$Title = $classname . "Assignment Send Successfully";
		$Remarks = 'Assignment Sent.';
		$type = 'notification_assignment';
		push_notification_android($device_id, $Title, $Remarks, $type);



		return "Message Sent.";
	} else {
		return array();
	}
}

// View Assignment Details Section:
function ShowHomework($SessionID, $TeacherID, $ClassID, $SectionID, $SubjectID, $CurrentPage, $PerPage)
{

	global $con;
	$response = array();
	$data = array();

	$SessionSQL = ($SessionID) ? " && session = $SessionID " : '';
	$SubjectSQL = ($SubjectID) ? " && subject = $SubjectID " : '';
	// $current_page=!empty($current_page) ? $current_page : '0';
	$PerPage = '15'; //set default

	if (!empty($CurrentPage)) { //pagination
		$c_page = $PerPage * ($CurrentPage - 1);
	} else {
		$c_page = 0;
	}

	//$sql1="select * from student_notifications where 1 and `group_id` ='0' and `category`='2' $SessionSQL and `login_user_id`='$teacher_id' $subjectid   ";

	$sql1 = "SELECT * FROM `student_notifications` WHERE 1 AND `group_id` = '0' AND `category` = '2' $SessionSQL AND `login_user_id` = '" . $TeacherID . "' $SubjectSQL ";

	if (!empty($ClassID) && !empty($SectionID)) {
		$sql1 .= " AND `class_id` = " . $ClassID . " AND `section_id` = " . $SectionID . " ";
	}
	if (!empty($ClassID) && empty($SectionID)) {
		$sql1 .= " AND `class_id` = " . $ClassID . " ";
	}

	$sql1 .= " GROUP BY `category`, `class_id`, `section_id`, `message`, CAST(`date` AS date) ORDER BY `notice_datetime` DESC ";

	$qmsg1 = mysqli_query($con, $sql1);
	$TotalRecords = mysqli_num_rows($qmsg1);

	$sql1 .= " Limit $c_page, $PerPage ";

	//---------------------------------

	$qmsg = mysqli_query($con, $sql1);
	$TotalPage = mysqli_num_rows($qmsg);
	if ($TotalPage > 0) {
		while ($res = mysqli_fetch_assoc($qmsg)) {
			$dt = $res['date'];
			$chgdt = date("d-m-Y (h:i A) ", strtotime($dt));

			@$temp = array();
			$temp['heading'] = ($res['heading']) ? $res['heading'] : "NA";
			$temp['message'] = htmlspecialchars(stripcslashes($res['message']));
			$temp['class_name'] = get_class_byid($res['class_id'])['class_name'];
			$temp['section_name'] = get_section_byid($res['section_id'])['section_name'];
			$temp['subject'] = !empty($res['subject']) ? get_subject_byid($res['subject'])['subject_name'] : "NA";

			if (!empty($res['attachment'])) {
				$temp['assignment'] = comma_separated_to_array_path(Call_Baseurl() . '/images/assignment/', $res['attachment']) ?? "NA";
			} else {
				$temp['assignment'] = array();
			}

			$temp['date'] = $chgdt;
			$temp['status'] = $res['status'];
			array_push($data, $temp);
		}

		$response["status"] = 1;
		$response["message"] = "Success";
		$response['current_page'] = $CurrentPage;
		$response['per_page'] = $PerPage;
		$response['total_page'] = ceil($TotalRecords / $PerPage);
		$response['total_records'] = $TotalRecords;
		$response['result'] = $data;

		return json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "No message";
		$response['current_page'] = $CurrentPage;
		$response['per_page'] = $PerPage;
		$response['total_page'] = ceil($TotalRecords / $PerPage);
		$response['total_records'] = $TotalRecords;
		$response['result'] = [];

		return json_encode($response);
	}
}


// Recent Assignment Activities Section:
function recentshowhomework($teacher_id, $session)
{
	global $con;
	$response = array();
	$data = array();

	$sql1 = "select * from student_notifications where 1 and `group_id` ='0' and `category`='2'  && session='$session' and `login_user_id`='$teacher_id' $subjectid   ";


	$sql1 .= " group by category,class_id,section_id,message, CAST(`date` AS date)  order by notice_datetime DESC ";

	$sql1 .= " Limit 0,10 ";
	// echo $sql1;
	//---------------------------------

	$qmsg = mysqli_query($con, $sql1);
	$total_records = mysqli_num_rows($qmsg);
	if ($total_records > 0) {
		while ($res = mysqli_fetch_assoc($qmsg)) {
			$dt = $res['date'];
			$chgdt = date("d-m-Y (h:i A) ", strtotime($dt));

			@$temp = array();

			$temp['heading'] = ($res['heading']) ? $res['heading'] : "NA";
			$temp['message'] = htmlspecialchars(stripcslashes($res['message']));
			$temp['class_name'] = get_class_byid($res['class_id'])['class_name'];
			$temp['section_name'] = get_section_byid($res['section_id'])['section_name'];
			$temp['subject'] = !empty($res['subject']) ? get_subject_byid($res['subject'])['subject_name'] : "NA";


			if (!empty($res['attachment'])) {
				$temp['assignment'] = comma_separated_to_array_path(Call_Baseurl() . '/images/assignment/', $res['attachment']) ?? "NA";
			} else {
				$temp['assignment'] = array();
			}
			$temp['date'] = $chgdt;
			$temp['status'] = $res['status'];
			array_push($data, $temp);
		}

		return $data;
	} else {
		return array();
	}
}




function message($heading, $classid, $sectionid, $message, $nmsg, $teacher_id, $session)
{
	global $con;
	date_default_timezone_set("Asia/Kolkata");
	$create_date = date('Y-m-d H:i:s');
	$session = ($session) ? " $session " : '';
	// $sr_session_sql=($session) ? " && sr.session=$session " : ''; 
	$staffname = get_staff_details_byid($teacher_id)['staff_name'];

	// $session=profile($teacher_id)['session'];

	$sql = "select student_id,student_name,parent_no,msg_type_id,father_name,gender,token_id,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where  stu_status='0' and sr.class_id='$classid' and sr.section_id='$sectionid' && sr.session=$session ";
	$q1 = mysqli_query($con, $sql); //and sr.session='$session'
	$row = mysqli_num_rows($q1);
	if ($row) {

		while ($r1 = mysqli_fetch_array($q1)) {
			$studid = $r1['student_id'];
			$mobile = $r1['parent_no'];
			$token = $r1['firebase_reg_id'];
			$arr_mob[] = $mobile;
			// echo $token;


			$q3 = "insert into student_notifications(heading,category,student_id,class_id,section_id,subject,
			selected_no,message,loginuser,login_user_id,notice_datetime,date,session)
			values('$heading',3,'$studid','$classid','$sectionid',0,'$mobile','$message','$staffname',$teacher_id,now(),now(),'$session')";
			$query = mysqli_query($con, $q3);
		}
		//seperate for send whatsapp message---------------------------------
		if (!empty($arr_mob) && !empty($nmsg)) {
			$msg_type = "Message_msg";
			foreach (array_unique($arr_mob) as $mo) {
				$result = sendwhatsappMessage($mo, $nmsg, $msg_type);
			}
		}
		//seperate for send whatsapp message---------------------------------

		$q2 = "INSERT INTO `staff_message`(`heading`,`class_id`, `section_id`, `message`, `teacher_id`, `date`,`category`,`status`,`session`) VALUES ('$heading','$classid','$sectionid','$message','$teacher_id',now(),'1','0','$session')";
		$qu = mysqli_query($con, $q2);

		if ($query) {
			// -----------------send push notification for each parent----------------------	
			$qpush = mysqli_query($con, $sql);
			if (mysqli_num_rows($qpush) > 0) {
				while ($row = mysqli_fetch_array($qpush)) {
					$token_id = $row['token_id'];
					// $classname=get_class_byid($classid)['class_name'];
					$Title = "Message has been received ";
					$Remarks = 'Regards : ' . get_school_details()['company_name'];
					$type = 'notification_message';
					$resp = push_notification_android($token_id, $Title, $Remarks, $type);
				}
			}
			// -----------------send push notification for each parent----------------------	

			// -----------------send push notification only teacher----------------------	
			$device_id = get_staff_byid($teacher_id)['token_id'];
			$classname = get_class_byid($classid)['class_name'];
			$Title = $classname . " Message Send Successfully";
			$Remarks = 'Message Sent';
			$type = 'notification_message';
			$resp = push_notification_android($device_id, $Title, $Remarks, $type);

			// -----------------send push notification only teacher----------------------	    

			return "Message Sent.";
		} else {
			return array();
		}
	} else {
		return array();
	}
}





function showstudents($session, $classid, $sectionid, $testname, $subjectid)
{
	global $con;
	$data = array();
	$session_sql = ($session) ? " && session=$session " : '';
	$sr_session_sql = ($session) ? " && sr.session=$session " : '';
	// $q1=mysqli_query($con,"select * from students where class_id='$classid' && section_id='$sectionid' && `session`='$session' ");
	$q1 = mysqli_query($con, "select student_id,register_no,student_name,parent_no,msg_type_id,father_name,gender,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where sr.class_id='$classid' && sr.section_id='$sectionid' $sr_session_sql and stu_status='0' ");

	$row = mysqli_num_rows($q1);
	if ($row) {

		while ($r1 = mysqli_fetch_assoc($q1)) {
			$regno = $r1['register_no'];
			$stuid = $r1['student_id'];
			$stuname = $r1['student_name'];
			$sql2 = "select * from marks where class_id='$classid' && section_id='$sectionid' 
           && test_name='$testname' && subject_id='$subjectid' && student_id='$stuid' $session_sql ";
			$q2 = mysqli_query($con, $sql2);

			$r2 = mysqli_fetch_array($q2);
			$markid = $r2['mark_id'];
			$marks = $r2['marks'];

			if (empty($markid)) {

				$markid = '';
			}
			if ($marks == '' || $marks == null) {
				$marks = '';
			}

			@$temp = array();
			$temp['register_no'] = $regno;
			$temp['student_id'] = $stuid;
			$temp['student_name'] = $stuname;
			$temp['student_img'] = Call_Baseurl() . '/' . getStudent_byStudent_id($stuid)['stu_image_path'];
			$temp['markid'] = $markid;
			$temp['student_marks'] = $marks;
			array_push($data, $temp);
		} //while
		if (!empty($markid)) {
			// $final['marks_inserted']=1;  //marks is inserted  
			// 	array_unshift($data, $final);
			$marks_inserted = 1;
		} else {
			// $final['marks_inserted']=0;  //marks is not inserted  
			// 	array_unshift($data, $final);
			$marks_inserted = 0;
		}
		return array($data, $marks_inserted);
	} else {
		// return "No Students"; 
		return array();
	}
}


function exammarks($classid, $sectionid, $testname, $subjectid, $studentid, $marks, $markid, $session, $exam_list)
{
	global $con;

	$array = json_decode($exam_list, true);

	// $totalstu = count($array['studentid']);
	// $totalstu = sizeof($studentid);

	// $stumax=max($marks);


	// for($k=0;$k<$totalstu;$k++){
	// 	$chnewstuid = $studentid[$k];
	// 	$chnewmarks = $marks[$k];

	// if($maxmarks > $stumax){
	// 	echo "max marks: ";
	// 	return 'maxmark'; die;
	// }

	// for($i=0;$i<$totalstu;$i++){

	// $newstuid = $studentid[$i];
	// if(!empty($marks[$i])){
	//    $newmarks = $marks[$i];
	foreach ($array as $item) {
		$newstuid = $item['studentid'];
		if (!empty($item['marks'])) {
			$newmarks = $item['marks'];
		} else {
			$newmarks = '0';
		}
		$session_sql = ($session) ? " && session=$session " : '';
		$session = ($session) ? " $session " : '';
		$q = mysqli_query($con, "select * from marks where class_id='$classid' && section_id='$sectionid' && student_id='$newstuid' && test_name='$testname' && subject_id='$subjectid' $session_sql");
		$r = mysqli_num_rows($q);

		if (!$r) {
			// 	$re = mysqli_fetch_array($q);
			// 	$markid = $re['mark_id'];

			// 	$queryupdate = mysqli_query($con,"update marks set marks='$newmarks', modify_date=now()  where mark_id='$markid' $session_sql");


			// }else{
			$isql = "select * from test where class_id='$classid' && section_id='$sectionid' 
		     && test_name='$testname' && subject_id='$subjectid' $session_sql";

			$q2 = mysqli_query($con, $isql);
			$r2 = mysqli_fetch_array($q2);
			$maxmarks = $r2['max_marks'];

			$querysave = mysqli_query($con, "insert into marks (class_id,section_id,subject_id,test_name,student_id,marks,max_mark,date,modify_date,session) values 
		    ('$classid','$sectionid','$subjectid','$testname','$newstuid','$newmarks','$maxmarks',now(),now(),$session)");
		}
	}
	if ($querysave) {
		return 'insert';
	} else {
		return array();
	}
}
// elseif($queryupdate){
// 		return 'update';

// }
// $q1 = mysqli_query($con,"select * from marks where class_id='$classid' && section_id='$sectionid' 
// && test_name='$testname' && subject_id='$subjectid' && student_id='$studentid'");

// $row = mysqli_num_rows($q1);
// if(!$row)
// {
//     $q2 = mysqli_query($con,"select * from test where class_id='$classid' && section_id='$sectionid' 
//     && test_name='$testname' && subject_id='$subjectid'");
//     $r2 = mysqli_fetch_array($q2);
//     $maxmarks = $r2['max_marks'];

//    $querysave = mysqli_query($con,"insert into marks (class_id,section_id,test_name,subject_id,student_id,marks,max_mark,date) values 
//    ('$classid','$sectionid','$testname','$subjectid','$studentid','$marks','$maxmarks',now())");

//    return  'Marks Inserted Successfully';
// }
// else
// {

// 	$querysave = mysqli_query($con,"update marks set marks='$marks' where mark_id='$markid'");
// 	return  'Marks Updated Successfully';
// }




function eventcalendar($classid, $sectionid, $fromdate, $todate, $session, $current_page, $per_page)
{
	global $con;

	$data = array();
	$total_records = '0';
	$total_page = '0';
	$session_sql = ($session) ? " && session=$session " : '';
	// $current_page=!empty($current_page) ? $current_page : '0';
	$per_page = '15'; //set default
	if (!empty($current_page)) { //pagination
		$c_page = $per_page * ($current_page - 1);
	} else {
		$c_page = 0;
	}
	//  $sql="select * from events where 1 and class_id='$classid' && section_id='$sectionid' && 
	//  from_date >='$fromdate' && to_date<='$todate' $session_sql ";
	$sql = " select * from events where 1 and ((class_id='$classid' && section_id='$sectionid') || ( class_id='$classid' || section_id='$sectionid') || (class_id='$classid' || section_id='$sectionid') ) && from_date >='$fromdate' && to_date
		<='$todate' $session_sql ";
	//  echo $sql;
	$q2 = mysqli_query($con, $sql);
	if ($q2) {
		$total_records = mysqli_num_rows($q2);
	}

	$sql .= " Limit $c_page, $per_page ";


	$q1 = mysqli_query($con, $sql);
	if ($q1) {
		$total_page = mysqli_num_rows($q1);
	}

	if ($total_page > 0) {
		while ($event = mysqli_fetch_assoc($q1)) {
			$result = array();
			// $result['event_for']=$event['event_for']; 
			$result['event_for'] = get_event_type_byid($event['event_for'])['event_name'];
			$result['no_of_days'] = $event['no_of_days'];
			$result['event_heading'] = $event['event_heading'];
			//   $result['description']=htmlspecialchars($event['description']); 
			//   $result['description']=trim(preg_replace('/\s\s+/', ' ', $event['description']));
			$des = str_replace("\r\n", "", $event['description']);
			$result['description'] = stripcslashes($des);
			$result['creation_date'] = $event['creation_date'];
			$result['creation_date'] = $event['creation_date'];
			$result['class_name'] = get_class_byid($event['class_id'])['class_name'] ?? 'All';
			$result['section_name'] = get_section_byid($event['section_id'])['section_name'] ?? 'All';
			array_push($data, $result);
		}
		$response["status"] = 1;
		$response["message"] = "Success";
		$response['current_page'] = $current_page;
		$response['per_page'] = $per_page;
		$response['total_page'] = ceil($total_records / $per_page);
		$response['total_records'] = $total_records;
		$response['result'] = $data;
		return json_encode($response);
	}
	$response["status"] = 0;
	$response["message"] = "No Event Created";
	$response['current_page'] = $current_page;
	$response['per_page'] = $per_page;
	$response['total_page'] = ceil($total_records / $per_page);
	$response['total_records'] = $total_records;
	$response['result'] = array();
	return json_encode($response);
}


/*
function viewresponsefeedback($staffid)
{
	global $con;
	$data = array();
	$q1 = mysqli_query($con,"select * from feedback where staff_id='$staffid'");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$feedid = $r1['feedback_id'];
			
			$subdt = $r1['submission_date'];
			$chgsudt = date("d-m-Y", strtotime($subdt)); 
			
			$clsid = $r1['class_id'];
			$qcls = mysqli_query($con,"select * from class where class_id='$clsid'");
			$rcls = mysqli_fetch_array($qcls);
			$clsname = $rcls['class_name'];	
			
			$secid = $r1['section_id'];
			$qsec = mysqli_query($con,"select * from section where section_id='$secid'");
			$rsec = mysqli_fetch_array($qsec);
			$secname = $rsec['section_name'];	
			
			$stuid = $r1['student_id'];
			$qstu = mysqli_query($con,"select * from students where student_id='$stuid'");
			$rstu = mysqli_fetch_array($qstu);
			$stuname = $rstu['student_name'];
		
			$reqid = $r1['request_id'];
			$qreq = mysqli_query($con,"select * from request_type where request_id='$reqid'");
			$rreq = mysqli_fetch_array($qreq);
			$reqname = $rreq['request_name'];
			
			$title = $r1['title'];
			$desp = $r1['description'];
			$response = $r1['response'];
			
			$temp['Feedback Id'] = $feedid;
			$temp['Submission Date'] = $chgsudt;
			$temp['Class'] = $clsname;
			$temp['Section'] = $secname;
			$temp['Student Name'] = $stuname;
			$temp['Request Type'] = $reqname;
			$temp['Title'] = $title;
			$temp['Description'] = $desp;
			$temp['Response'] = $response;
			array_push($data, $temp);
		}
		
			echo json_encode($data);
	}
	else
	{
		echo "No Feedback";
	}
}


function insertresponsefeedback($feedid,$response,$staffname)
{
	global $con;
	
	$q1 = mysqli_query($con,"update feedback set response='$response', status=1 where feedback_id='$feedid'");
	
	$q2 = mysqli_query($con,"select * from feedback where feedback_id='$feedid'");
	$row2 = mysqli_num_rows($q2);
	
	if($row2)
	{	
	$r2 = mysqli_fetch_array($q2);
	$sdate = $r2['submission_date'];
	$chgsdate = date("d-m-Y", strtotime($sdate));
	
	$reqid = $r2['request_id'];
	$qreq = mysqli_query($con,"select * from request_type where request_id='$reqid'");
	$rreq = mysqli_fetch_array($qreq);
	$reqname = $rreq['request_name'];
	
	$raisedfor = $r2['raised_for'];
	$title = $r2['title'];
	$desc = $r2['description'];
	
	
	$stuid = $r2['student_id'];
	$class = $r2['class_id'];
	$section = $r2['section_id'];
	$message = $r2['response'];
	
	$q3 = mysqli_query($con,"select * from students where student_id='$stuid'");
	$r3 = mysqli_fetch_array($q3);
	$mobile = $r3['parent_no'];
	
	$msg = "Hi,<br>Please find the Response for the Feedback as below:<br>Submission Date: ".$chgsdate.
	"<br>Request Type: ".$reqname."<br>Raised For : ".$raisedfor."<br>Title: ".$title."<br>Description : "
    .$desc."<br>Response : ".$message;
	
	$q4 =mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,loginuser,notice_datetime,date)
	values(3,'$stuid','$class','$section',0,'$mobile','$msg','$staffname',now(),now())");
	
		echo "Inserted";
	}
	else
	{
		echo "Invalid Details";
	}

}  
*/


function showmessage($staffid, $classid, $sectionid, $session, $current_page, $per_page)
{

	global $con;
	$data = array();
	// $qmsg = mysqli_query($con,"select * from staff_notifications where staff_id='$staffid' && category='1' order by notice_datetime desc");
	$session_sql = ($session) ? " && session=$session " : '';

	$per_page = '15'; //set default
	if (!empty($current_page)) { //pagination
		$c_page = $per_page * ($current_page - 1);
	} else {
		$c_page = 0;
	}

	// $sql1="select * from staff_message where teacher_id='$staffid' and category='1' $session_sql ";

	// if(!empty($classid)){
	// 	$sql1.=" and class_id='$classid' ";
	// }
	// if(!empty($sectionid)){
	// 	$sql1.=" and section_id='$sectionid' ";
	// }

	// $sql1.=" order by date desc ";

	$sql1 = "select * from student_notifications where 1 and `group_id` ='0' and `category`='3'  && session=$session  and `login_user_id`='$staffid' ";

	if (!empty($classid) && !empty($sectionid)) {
		$sql1 .= " and `class_id`='" . $classid . "' and `section_id`='" . $sectionid . "' ";
	}
	if (!empty($classid)  && empty($sectionid)) {
		$sql1 .= " and `class_id`='" . $classid . "' ";
	}

	$sql1 .= " group by category,class_id,section_id,message, CAST(`date` AS date)  order by notice_datetime DESC ";

	$qmsg1 = mysqli_query($con, $sql1);
	$total_records = mysqli_num_rows($qmsg1);
	$sql1 .= " Limit $c_page, $per_page ";
	// echo $sql1;
	$qmsg = mysqli_query($con, $sql1);
	$total_page = mysqli_num_rows($qmsg);
	if ($total_page > 0) {
		while ($res = mysqli_fetch_array($qmsg)) {
			$dt = $res['notice_datetime'];
			$chgdt = date("d-m-Y (h:i A) ", strtotime($dt));

			@$temp = array();
			// $temp['st_notification_id'] = $res['st_notification_id'];
			$temp['st_notification_id'] = $res['id'];

			$temp['heading'] = ($res['heading']) ? $res['heading'] : "NA";
			// $temp['message'] = htmlspecialchars(stripcslashes($res['message']));
			$temp['message'] = str_replace('<br>', ' ', $res['message']);
			// $temp['message'] =htmlspecialchars($res['message']);
			$temp['class_name'] = get_class_byid($res['class_id'])['class_name'];
			$temp['section_name'] = get_section_byid($res['section_id'])['section_name'];
			$temp['date'] = $chgdt;
			$temp['status'] = ($res['status'] != '') ?   $res['status'] : '';
			array_push($data, $temp);
		}
		$response["status"] = 1;
		$response["message"] = "Success";

		$response['current_page'] = $current_page;
		$response['per_page'] = $per_page;
		$response['total_page'] = ceil($total_records / $per_page);
		$response['total_records'] = $total_records;
		$response['result'] = $data;
		return json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "No Message";
		$response['current_page'] = $current_page;
		$response['per_page'] = $per_page;
		$response['total_page'] = ceil($total_records / $per_page);
		$response['total_records'] = $total_records;
		$response['result'] = array();
		return json_encode($response);
	}
}
function recentshowmessage($staffid, $session)
{

	global $con;
	$data = array();

	// $sql1="select * from staff_message where teacher_id='$staffid' and category='1'  && session=$session ";
	// $sql1.=" order by date desc ";
	// $sql1.=" Limit 0, 10  ";

	$sql1 = "select * from student_notifications where 1 and `group_id` ='0' and `category`='3'  && session=$session  and `login_user_id`='$staffid'  ";
	$sql1 .= " group by category,class_id,section_id,message, CAST(`date` AS date)  order by notice_datetime DESC ";
	$sql1 .= " Limit 0, 10  ";

	$qmsg = mysqli_query($con, $sql1);
	$total_records = mysqli_num_rows($qmsg);
	if ($total_records > 0) {
		while ($res = mysqli_fetch_array($qmsg)) {

			$dt = $res['notice_datetime'];
			$chgdt = date("d-m-Y (h:i A) ", strtotime($dt));
			@$temp = array();
			$temp['st_notification_id'] = $res['st_notification_id'];

			$temp['heading'] = ($res['heading']) ? $res['heading'] : "NA";
			// $temp['message'] = htmlspecialchars(stripcslashes($res['message']));
			$temp['message'] = str_replace('<br>', ' ', $res['message']);
			$temp['class_name'] = get_class_byid($res['class_id'])['class_name'];
			$temp['section_name'] = get_section_byid($res['section_id'])['section_name'];
			$temp['date'] = $chgdt;
			$temp['status'] = $res['status'];
			array_push($data, $temp);
		}
		return $data;
	} else {
		return array();
	}
}

function showgallery($teacher_id, $classid, $sectionid, $session, $current_page, $per_page)
{
	global $con;
	$data = array();
	$session_sql = ($session) ? " && session=$session " : '';
	$per_page = '15'; //set default
	if (!empty($current_page)) { //pagination
		$c_page = $per_page * ($current_page - 1);
	} else {
		$c_page = 0;
	}

	$sql = "select * from student_notifications where 1 and `group_id` ='0' and `category`='4' $session_sql and `login_user_id`='$teacher_id'  ";

	if (!empty($classid) && !empty($sectionid)) {
		$sql .= " and `class_id`=" . $classid . " and `section_id`=" . $sectionid . " ";
	}
	if (!empty($classid)  && empty($sectionid)) {
		$sql .= " and `class_id`=" . $classid . " ";
	}

	$sql .= " group by category,class_id,section_id,message, CAST(`date` AS date)  order by notice_datetime DESC ";
	$qmsg1 = mysqli_query($con, $sql);
	$total_records = mysqli_num_rows($qmsg1);
	$sql .= " Limit $c_page, $per_page ";
	// echo $sql;
	$qmsg = mysqli_query($con, $sql);
	$total_page = mysqli_num_rows($qmsg);
	if ($total_records > 0) {

		while ($res = mysqli_fetch_array($qmsg)) {


			$dt = $res['date'];
			$chgdt = date("d-m-Y (h:i A) ", strtotime($dt));

			$temp = array();

			// $temp['photos'] = comma_separated_to_array($res['photos']);
			$temp['photos'] = comma_separated_to_array_path(Call_Baseurl() . '/gallery/', $res['photos']);

			$temp['st_notification_id'] = $res['st_notification_id'];

			$temp['heading'] = ($res['heading']) ? $res['heading'] : "NA";
			$temp['message'] = htmlspecialchars(stripcslashes($res['message']));
			$temp['class_id'] = $res['class_id'];
			$temp['section_id'] = $res['section_id'];
			$temp['class_name'] = get_class_byid($res['class_id'])['class_name'];
			$temp['section_name'] = get_section_byid($res['section_id'])['section_name'];
			// $temp['photos'] = ($res['photos']) ? $res['photos'] : "NA" ;
			$temp['date'] = $chgdt;
			$temp['status'] = $res['status'];

			array_push($data, $temp);
		}
		$response["status"] = 1;
		$response["message"] = "Success";
		$response['current_page'] = $current_page;
		$response['per_page'] = $per_page;
		$response['total_page'] = ceil($total_records / $per_page);
		$response['total_records'] = $total_records;
		$response['result'] = $data;

		return json_encode($response);
	} else {
		$response["status"] = 0;
		$response["message"] = "Not Found";
		$response['current_page'] = $current_page;
		$response['per_page'] = $per_page;
		$response['total_page'] = ceil($total_records / $per_page);
		$response['total_records'] = $total_records;
		$response['result'] = array();

		return json_encode($response);
	}
}
function recentshowgallery($teacher_id, $session)
{
	global $con;
	$data = array();
	$session_sql = ($session) ? "  " : '';

	$sql = "select * from student_notifications where 1 and `group_id` ='0' and `category`='4' && session=$session and `login_user_id`='$teacher_id'  ";

	$sql .= " group by category,class_id,section_id,message, CAST(`date` AS date)  order by notice_datetime DESC ";

	$sql .= " Limit 0,10 ";
	// echo $sql;
	$qmsg = mysqli_query($con, $sql);
	$total_records = mysqli_num_rows($qmsg);
	if ($total_records > 0) {

		while ($res = mysqli_fetch_array($qmsg)) {


			$dt = $res['date'];
			$chgdt = date("d-m-Y (h:i A) ", strtotime($dt));

			$temp = array();

			// $temp['photos'] = comma_separated_to_array($res['photos']);
			$temp['photos'] = comma_separated_to_array_path(Call_Baseurl() . '/gallery/', $res['photos']);

			$temp['st_notification_id'] = $res['st_notification_id'];

			$temp['heading'] = ($res['heading']) ? $res['heading'] : "NA";
			$temp['message'] = htmlspecialchars(stripcslashes($res['message']));
			$temp['class_id'] = $res['class_id'];
			$temp['section_id'] = $res['section_id'];
			$temp['class_name'] = get_class_byid($res['class_id'])['class_name']??'';
			$temp['section_name'] = get_section_byid($res['section_id'])['section_name']??'';
			// $temp['photos'] = ($res['photos']) ? $res['photos'] : "NA" ;
			$temp['date'] = $chgdt;
			$temp['status'] = $res['status'];

			array_push($data, $temp);
		}

		return $data;
	} else {
		return array();
	}
}


function messagestatusupdate($session, $id)
{
	global $con;

	$data = array();
	// $session_sql=($session) ? " && session=$session " : '';
	$query_msg = mysqli_query($con, "update staff_notifications set status='1' where st_notification_id='$id' ");

	if ($query_msg) {
		return "Updated Successfully.";
	} else {
		// return "Not Updated.";
		return array();
	}
}


function messagecount($session, $staffid)
{
	global $con;
	$data = array();
	$session_sql = ($session) ? " && session=$session " : '';
	$sql1 = "select `message`,`date`,`status` from staff_notifications where staff_id='$staffid' $session_sql && category='1' order by date desc";

	$query_msg = mysqli_query($con, $sql1);
	if (mysqli_num_rows($query_msg)) {
		$unread = 0;
		$read = 0;
		while ($res = mysqli_fetch_assoc($query_msg)) {
			$sta = $res['status'];
			if ($sta == 0) {
				$unread = $unread + 1;
			} else {
				$read = $read + 1;
			}
		}

		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		// echo json_encode($data);
		return $data;
	} else {
		// return "No Message";
		return array();
	}
}


function voicemessage($staffid)
{
	global $con;

	$data = array();

	$query_vo = mysqli_query($con, "select * from voice_message where msgfor='staff' && stu_staff_id='$staffid' order by date desc");

	if (mysqli_num_rows($query_vo)) {
		while ($res = mysqli_fetch_assoc($query_vo)) {
			$chgdt = date("d-m-Y", strtotime($res['date']));

			@$temp = array();
			$temp['voice_msg_id'] = $res['voice_msg_id'];
			$temp['messagename'] = $res['message_name'];
			$temp['message'] = $res['message'];
			$temp['date'] = $chgdt;
			$temp['status'] = $res['status'];
			array_push($data, $temp);
		}

		// echo json_encode($data);
		return $data;
	} else {
		// return "No Voice Message";
		return array();
	}
}


function voicestatusupdate($id)
{
	global $con;

	$data = array();

	$query_vo = mysqli_query($con, "update voice_message set status='1' where voice_msg_id='$id'");

	if ($query_vo) {
		return "Updated Successfully.";
	} else {
		return "Not Updated.";
	}
}


function voicemessagecount($staffid)
{
	global $con;

	$data = array();

	$query_vo = mysqli_query($con, "select * from voice_message where msgfor='staff' && stu_staff_id='$staffid' order by date desc");

	if (mysqli_num_rows($query_vo)) {
		$unread = 0;
		$read = 0;
		while ($res = mysqli_fetch_assoc($query_vo)) {

			$sta = $res['status'];
			if ($sta == 0) {
				$unread = $unread + 1;
			} else {
				$read = $read + 1;
			}
		}

		$temp['unread'] = $unread;
		$temp['read'] = $read;
		array_push($data, $temp);
		echo json_encode($data);
	} else {
		return "No Message";
	}
}


function changepassword($id, $currentpassword, $newpassword)
{
	global $con;

	//$data = array();

	$que = mysqli_query($con, "select * from staff where st_id='$id' && password='$currentpassword'");
	$row = mysqli_num_rows($que);
	if ($row) {
		$que1 = mysqli_query($con, "update staff set password='$newpassword' where st_id='$id'");

		$temp['Response'] = "Updated";
		return $temp['Response'];
	} else {
		$responce = array();
		return $responce;
	}
}
