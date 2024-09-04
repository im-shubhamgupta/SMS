<?php
include('connection.php');
$id = $_REQUEST['x'];
mysqli_query($con,"delete from custome_group where group_id='$id'");
echo "<script>window.location='dashboard.php?option=view_group'</script>";


?>