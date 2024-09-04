<?php 
include('connection.php');
extract($_REQUEST);
$id=$_GET['x'];

if(isset($id))
{
	$qd = mysqli_query($con,"select * from student_scheduled_notifications where st_notification_id='$id'");
	$rd = mysqli_fetch_array($qd);
	$categoryid = $rd['category'];
	$classid = $rd['class_id'];
	$sectionid = $rd['section_id'];
	$subjectid = $rd['subject'];
	$message = $rd['message'];
	$date = $rd['date'];
	
	if(mysqli_query($con,"delete from student_scheduled_notifications where category='$categoryid' 
	&& class_id='$classid' && section_id='$sectionid' && subject='$subjectid' && message='$message' 
	&& date ='$date'"));
	echo "<script>window.location='dashboard.php?option=view_scheduled_notification'</script>";
}

?>