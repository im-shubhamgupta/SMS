<?php 
include('../../connection.php');
//include('myfunction.php');

extract($_REQUEST);

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
				if($msgfor=="student")
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
							
						$que1=mysqli_query($con,"insert into voice_message(msgfor,stu_staff_id,class_id,section_id,selected_no,message_name,message,loginuser,login_id,date)
						values('$msgfor','$studid','$classid','$sectionid','$mobile','$messagename','$audio','users','$loginid',now())");
						}
						
						echo "Inserted";
					}
					else
					{
						echo "No Students";
					}
					
				}
				else if($msgfor=="staff")
				{
					$q2 = mysqli_query($con,"select * from staff where status='1'");
					$row2 = mysqli_num_rows($q2);
					
					if($row2)	
					{
						move_uploaded_file($_FILES["file"]["tmp_name"], "../../gallery/audio/" . $_FILES["file"]["name"]);
						
						while($r2 = mysqli_fetch_array($q2))
						{
							$stid=$r2['st_id'];
							$mobile=$r2['mobno'];
							
						$que2=mysqli_query($con,"insert into voice_message(msgfor,stu_staff_id,selected_no,message_name,message,loginuser,login_id,date)
						values('$msgfor','$stid','$mobile','$messagename','$audio','users','$loginid',now())");
						}
						
						echo "Inserted";
					}
					else
					{
						echo "No Staff";
					}	
			
				}
					
			}
	
		}
		else
		{
			echo "Error";
		}	
	}


?>