<?php 
error_reporting(1);
extract($_REQUEST);
include('connection.php');

if(isset($grpid))
{
	$que=mysqli_query($con,"select * from assign_custome_group where group_id='$grpid'");
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