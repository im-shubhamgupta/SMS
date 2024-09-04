<?php 
include('connection.php');
extract($_REQUEST);
//echo $id; 
if(isset($id))
{
	$query=mysqli_query($con,"select * from student_daily_attendance where class_id=1 && section_id=4");
	if(mysqli_num_rows($query))
	{
		echo "true";
	}
}

?>