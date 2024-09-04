<?php 
include('connection.php');
$tid=$_GET['x'];

$q1=mysqli_query($con,"select * from students where trans_id='$tid'");
$r1=mysqli_num_rows($q1);

if($r1)
{
echo "<script>alert ('Cannot Delete Route. Students are linked with this Route')</script>";
echo "<script>window.location='dashboard.php?option=view_transports'</script>";	
}
else
{
echo "<script>alert ('Do you want to delete the Route')</script>";	
mysqli_query($con,"delete from transports where trans_id='$tid'");
echo "<script>window.location='dashboard.php?option=view_transports'</script>";
}

?>