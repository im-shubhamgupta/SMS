<?php 
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($deptid))
{
	$que=mysqli_query($con,"select * from assign_department where dept_id='$deptid'");
	$row = mysqli_num_rows($que);
	if($que)
	{
	echo "$row";
	}
	else
	{
	echo 0;	
	}
}

?>