<?php 
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($facid))
{
	$que=mysqli_query($con,"select * from issue_bookto_faculty where book_id='$bkid' && st_id='$facid' && return_status='0'");
	if(mysqli_num_rows($que))
	{
		echo "true";
	}
}


?>