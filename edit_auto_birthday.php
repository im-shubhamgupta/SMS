<?php
//include('connection.php');
extract($_REQUEST);
$id=$_REQUEST['id'];
$status=$_REQUEST['status'];

if($status==0)
{
	mysqli_query($con,"update automatic_messages set status='1' where id='$id'");	
	echo "<script>window.location='dashboard.php?option=auto_birthday_message'</script>";
}
else
{
	mysqli_query($con,"update automatic_messages set status='0' where id='$id'");
	echo "<script>window.location='dashboard.php?option=auto_birthday_message'</script>";
}

?>