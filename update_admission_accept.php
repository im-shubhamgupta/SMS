<?php
extract($_REQUEST);

$admid = $_REQUEST['id'];
$page = $_REQUEST['page'];

$q1 = mysqli_query($con,"update admission set status='2', accept_decline_date=now() where admission_id='$admid'");		
		
echo "<script>window.location='dashboard.php?option=$page'</script>";
	
?>

