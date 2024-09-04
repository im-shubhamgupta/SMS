<?php 
include('connection.php');
extract($_REQUEST);
if(isset($id))
{
$query = mysqli_query($con,"select * from expense where expense_type_id ='$id'");
$q1 = mysqli_query($con,"select * from expense_type where expense_type_id='$id'");
$r1 = mysqli_fetch_array($q1);
$expname = $r1['expense_type_name'];

if(mysqli_num_rows($query))
{
	echo $expname;
}
}

if(isset($del_id))
{
if(mysqli_query($con,"delete from expense_type where expense_type_id='$del_id'"))
{
	echo "deleted Successfully";
}	 
}



?>