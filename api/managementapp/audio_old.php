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
				
				$q1 = mysqli_query($con,"select * from students where stu_status='0' and class_id='$classid' and section_id='$sectionid' and msg_type_id='1'");
				$row = mysqli_num_rows($q1);
				if($row)	
				{
					move_uploaded_file($_FILES["file"]["tmp_name"], "../../gallery/audio/" . $_FILES["file"]["name"]);
					
					while($r1 = mysqli_fetch_array($q1))
					{
						$studid=$r1['student_id'];
						$mobile=$r1['parent_no'];
						
					$q2=mysqli_query($con,"insert into voice_message(student_id,class_id,section_id,selected_no,message,loginuser,notice_datetime,date)
					values('$studid','$classid','$sectionid','$mobile','$audio','$name',now(),now())");
					}
				}	
					
				// echo "Upload: " . $_FILES["file"]["name"] . "<br />";
				// echo "Type: " . $_FILES["file"]["type"] . "<br />";
				// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
				// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
				
			}
		
			echo "Inserted";
		}
		else
		{
			echo "Error";
		}	
	}


?>