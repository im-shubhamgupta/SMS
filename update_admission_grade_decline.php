<?php
include('connection.php');
$admid=$_GET['x'];
$reason=$_GET['rea'];

$q1 = mysqli_query($con,"update admission set status='3', decline_reason='$reason', accept_decline_date=now() where admission_id='$admid'");		
		
echo "<script>window.location='dashboard.php?option=search_with_grade'</script>";
	
?>

