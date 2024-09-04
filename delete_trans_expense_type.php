<?php 
include('connection.php');
extract($_REQUEST);
if(isset($id))
{
$query = mysqli_query($con,"select * from transport_expense where trans_expense_type_id ='$id'");
$q1 = mysqli_query($con,"select * from transport_expense_type where trans_expense_type_id ='$id'");
$r1 = mysqli_fetch_array($q1);
$expname = $r1['trans_expense_type_name'];

if(mysqli_num_rows($query))
{
	echo $expname;
}
}

if(isset($del_id))
{
if(mysqli_query($con,"delete from transport_expense_type where trans_expense_type_id ='$del_id'"))
{
	echo "deleted Successfully";
}	 
}



?>