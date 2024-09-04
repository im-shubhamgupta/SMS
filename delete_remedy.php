<?php
include('connection.php');
$id = $_REQUEST['x'];

$q1 = mysqli_query($con,"select * from remedy where remedy_id='$id'");
$r1 = mysqli_fetch_array($q1);
$pic = $r1['observations_proof'];

unlink('gallery/remedy/'.$pic);

mysqli_query($con,"delete from remedy where remedy_id='$id'");
echo "<script>window.location='dashboard.php?option=view_remedy'</script>";

?>