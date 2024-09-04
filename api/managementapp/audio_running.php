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
				move_uploaded_file($_FILES["file"]["tmp_name"], "../../gallery/audio/" . $_FILES["file"]["name"]);
				
				$q2=mysqli_query($con,"insert into voice_message(message)
				values('$audio')");
			
				// echo "Upload: " . $_FILES["file"]["name"] . "<br />";
				echo "Type: " . $_FILES["file"]["type"] . "<br />";
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