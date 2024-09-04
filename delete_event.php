<?php 
include('connection.php');
extract($_REQUEST);
if(isset($id))
{
	$que = mysqli_query($con,"delete from events where event_id='$id'");
	
	echo "<script>window.location='dashboard.php?option=view_event_calendar'</script>";
}




?>