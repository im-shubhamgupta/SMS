<?php 
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($stuid))
{
	$que=mysqli_query($con,"select * from issue_bookto_students where book_id='$bkid' && student_id='$stuid' && return_status='0'");
	if(mysqli_num_rows($que))
	{
		echo "true";
	}
}


?>