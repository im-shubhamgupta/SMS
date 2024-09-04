<?php 
include('../../connection.php');
//include('myfunction.php');
extract($_REQUEST);

define('API_ACCESS_KEY','AAAAMDGQTqs:APA91bH0rm7cQiLS41q00fmFjbPM_mscd_f66s57tpB7f5F2VtyIPXgr5uiaar991jjSgzhX6FG4Fs4GelgPpVi4Xdo7BNbCOWF-pnSgl0n6uzCoIbmsrRFbKCX2UaRhXGalZPyL1aPS');
define('fcmUrl','https://fcm.googleapis.com/fcm/send');
 
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$audio = $_FILES['file']['name'];
		
		if ((($_FILES["file"]["type"] == "audio/mp3")
		 || ($_FILES["file"]["type"] == "audio/mpeg")
		 || ($_FILES["file"]["type"] == "audio/mpeg3")
		 || ($_FILES["file"]["type"] == "audio/x-mpeg3")
		 || ($_FILES["file"]["type"] == "audio/wav")
		 || ($_FILES["file"]["type"] == "audio/x-wav")
		) && ($_FILES["file"]["size"] < 1000000))
		
		{
			
			if ($_FILES["file"]["error"] > 0)
			{
				echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
			}
			else
			{
				
				$q1 = mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$sectionid' and msg_type_id='1'");
				$row1 = mysqli_num_rows($q1);
				
				if($row1)	
				{
					move_uploaded_file($_FILES["file"]["tmp_name"], "../../gallery/audio/" . $_FILES["file"]["name"]);
					
					while($r1 = mysqli_fetch_array($q1))
					{
						$studid=$r1['student_id'];
						$mobile=$r1['parent_no'];
						$token=$r1['firebase_reg_id'];
						
					$que1="insert into voice_message(msgfor,stu_staff_id,class_id,section_id,selected_no,message_name,message,loginuser,login_id,date)
					values('student','$studid','$classid','$sectionid','$mobile','$messagename','$audio','staff','$loginid',now())";
					
					if(mysqli_query($con,$que1))
					{
						$notification = [
						'title' =>'Audio Message',
						'body' => $message,
						];
						//$extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

						$fcmNotification = [
							//'registration_ids' => $tokenList, //multple token array
							'to'        => $token, //single token
							'notification' => $notification
						];

						$headers = [
							'Authorization: key=' . API_ACCESS_KEY,
							'Content-Type: application/json'
						];

						
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL,fcmUrl);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
						$result = curl_exec($ch);
						curl_close($ch);

						echo $result;
						
					}
											
					}
					
					echo "Inserted";
				}
				else
				{
					echo "No Students";
				}
					
			}
		}
		else
		{
			echo "Error";
		}	
	}


?>