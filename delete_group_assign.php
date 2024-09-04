<?php
include('connection.php');
$id = $_REQUEST['x'];
mysqli_query($con,"delete from assign_custome_group where ass_cus_id='$id'");
echo "<script>window.location='dashboard.php?option=view_group_students'</script>";


?>