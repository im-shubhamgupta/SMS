<?php 
include('connection.php');
extract($_REQUEST);
$id=$_GET['x'];

if(isset($id))
{
	
	$qd = mysqli_query($con,"select * from student_notifications where st_notification_id='$id'");
	$rd = mysqli_fetch_array($qd);
	$categoryid = $rd['category'];
	$classid = $rd['class_id'];
	$sectionid = $rd['section_id'];
	//$subjectid = $rd['subject'];
	$message = $rd['message'];
	$date = $rd['date'];
	
	$query = "delete from student_notifications where category='$categoryid' 
	&& class_id='$classid' && section_id='$sectionid' && message='$message' 
	&& date ='$date'";
	if(mysqli_query($con,$query))
	{
	echo "<script>window.location='dashboard.php?option=view_student_notification'</script>";
	}
}

?>