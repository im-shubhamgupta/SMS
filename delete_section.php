<?php 
include('connection.php');
extract($_REQUEST);
if(isset($id))
{
$query_fee=mysqli_query($con,"select * from students where section_id='$id'");
$r = mysqli_fetch_array($query_fee);
$cid = $r['class_id'];

$q1 = mysqli_query($con,"select * from class where class_id='$cid'");
$r1 = mysqli_fetch_array($q1);
$clsname = $r1['class_name'];

$q2 = mysqli_query($con,"select * from section where section_id='$id'");
$r2 = mysqli_fetch_array($q2);
$secname = $r2['section_name'];

if(mysqli_num_rows($query_fee))
{	
echo $clsname.' '.$secname;
}
}


if(isset($del_id))
{
if(mysqli_query($con,"delete from section where section_id='$del_id'"))
{
		
	echo "deleted Successfully";
}	 
}

?>