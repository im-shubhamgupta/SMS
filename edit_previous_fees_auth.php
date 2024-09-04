<?php
//include('connection.php');
extract($_REQUEST);
$id=$_REQUEST['id'];
$status=$_REQUEST['status'];

if($status==1)
{
	mysqli_query($con,"update superadmin_authority set status='0' where id='$id'");	
	echo "<script>window.location='dashboard.php?option=previous_fees_auth'</script>";
}
else
{
	mysqli_query($con,"update superadmin_authority set status='1' where id='$id'");
	echo "<script>window.location='dashboard.php?option=previous_fees_auth'</script>";
}

?>