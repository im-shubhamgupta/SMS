<?php 
include('connection.php');
$id=$_GET['x'];
mysqli_query($con,"delete from co_scholastic where scholastic_id ='$id'");
echo "<script>window.location='dashboard.php?option=view_scholastic'</script>";
?>