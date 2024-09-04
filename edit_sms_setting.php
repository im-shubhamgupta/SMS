<?php
//include('connection.php');
extract($_REQUEST);
$id=$_REQUEST['sid'];
$status=$_REQUEST['status'];

if($status==1)
{
	mysqli_query($con,"update sms_setting set status='0' where sms_id='$id'");	
	echo "<script>window.location='dashboard.php?option=update_sms_status'</script>";
}
else
{
	mysqli_query($con,"update sms_setting set status='1' where sms_id='$id'");
	echo "<script>window.location='dashboard.php?option=update_sms_status'</script>";
}

?>