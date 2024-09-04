<?php
include('connection.php');
$id = $_REQUEST['x'];
mysqli_query($con,"delete from assign_department where ass_dept_id='$id'");
echo "<script>window.location='dashboard.php?option=view_assign_department'</script>";


?>