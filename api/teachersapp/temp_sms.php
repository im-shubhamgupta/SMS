<?php

include('myfunction.php');


   $sclname = get_school_details()['company_name'];


	

	
	
	$PresentTextmob = array();
	$AbsentTextmob = array();
	$LeaveTextmob = array();
	$messagetype = "attendance-sms";

	
	   $sql = "select * from temp_attendace";
	   $q = mysqli_query($con, $sql);
	   $r = mysqli_num_rows($q);
	

		//send notifications Push and SMS only to parent -------------------------------------------------------
		 while($item=mysqli_fetch_assoc($q)){
			$newreg = $item['register_no'];
			$newstuid = $item['student_id'];
			$newattendance = $item['type_of_attend'];
			if ($item['type_of_attend'] == '3') {
				$reason = $item['reason'];
			} else {
				$reason = '';
			}
			$session=$item['session'];
			$date = date("d-m-Y", strtotime($item['date']));

			$sqll = "select student_id,student_name,parent_no,msg_type_id,token_id,father_name,gender,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where student_id='$newstuid' and stu_status='0'";
			$que1 = mysqli_query($con, $sqll);
			if (mysqli_num_rows($que1) > 0) {
		
				$r1 = mysqli_fetch_array($que1);
				$token_id = $r1['token_id'];
				

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

				if ($item['type_of_attend'] == 1) {
					if ($msgtype == 1) {
						$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Present on " . $date . ".%0aRegards,%0a" . $sclname . ",";
						$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Present on " . $date . ".<br>Regards,<br>" . $sclname . ",";

						
						$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
					} elseif ($msgtype == 2) {
						$PresentTextmob[] = getStudents_text_mobno($item['student_id'], $session)['parent_no'] ?? '';

						
					}
				} elseif ($item['type_of_attend'] == 2) {
				
					if ($msgtype == 1) {
						$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Absent on " . $date . ".%0aRegards,%0a" . $sclname . ",";
						$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Absent on " . $date . ".<br>Regards,<br>" . $sclname . ",";

						$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
					} elseif ($msgtype == 2) {
						$AbsentTextmob[] = getStudents_text_mobno($item['student_id'], $session)['parent_no'] ?? '';
						
					}
				} elseif ($item['type_of_attend'] == 3) {
					$Wmessage = "Dear " . $fathername . "%0aYour " . $gen . " " . $name . " is Leave on " . $date . ".%0aRegards,%0a" . $sclname . ",";
					$Wnmessage = "Dear " . $fathername . "<br>Your " . $gen . " " . $name . " is Leave on " . $date . ".<br>Regards,<br>" . $sclname . ",";

					if ($msgtype == 1) {
						$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
					} elseif ($msgtype == 2) {
						$LeaveTextmob[] = getStudents_text_mobno($item['student_id'], $session)['parent_no'] ?? 0;

						
					}
				}

			}		
		} //close for loop

		
	$presentmsg = "Dear Parents,%0aYour son/daughter has been Present today.%0a" . $date . ".%0aRegards,%0a" . $sclname . "%0aISCTDT";

	$npresentmsg = "Dear Parents,<br>Your son/daughter has been Present today.<br>" . $date . ".<br>Regards,<br>" . $sclname . "<br>ISCTDT";

	$absentmsg = "Dear Parents,%0aYour son/daughter has been Absent today.%0a" . $date . ".%0aRegards,%0a" . $sclname . "%0aISCTDT";

	$nabsentmsg = "Dear Parents,<br>Your son/daughter has been Absent today.<br>" . $date . ".<br>Regards,<br>" . $sclname . "<br>ISCTDT";

	$leavemsg = "Dear Parents,%0aYour son/daughter has been Leave on today.%0a" . $date . ".%0aRegards,%0a" . $sclname . "%0aISCTDT";

	$nleavemsg = "Dear Parents,<br>Your son/daughter has been Leave on today.<br>" . $date . ".<br>Regards,<br>" . $sclname . "<br>ISCTDT";

		
		if (!empty($PresentTextmob)) {
			sendtextMessage($PresentTextmob, $presentmsg, $messagetype);
		}
		if (!empty($AbsentTextmob)) {
			sendtextMessage($AbsentTextmob, $absentmsg, $messagetype);
		}
		if (!empty($LeaveTextmob)) {
			sendtextMessage($LeaveTextmob, $leavemsg, $messagetype);
		}
		
        $Delete= "DELETE FROM temp_attendace";
		$Query = mysqli_query($con, $Delete);
		if ($Query) {
		
			echo "Message Sent Successfully";
		} else {
			return array();
		}	
	
