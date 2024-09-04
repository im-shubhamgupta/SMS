<?php
include('connection.php');
$id = $_REQUEST['x'];
mysqli_query($con,"delete from department where dept_id='$id'");
echo "<script>window.location='dashboard.php?option=view_department'</script>";


?>