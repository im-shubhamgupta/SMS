<?php 

include('connection.php');

$eid=$_GET['x'];

$reason=$_GET['rea'];

$query=mysqli_query($con,"select * from expense where expense_id='$eid'");

$res=mysqli_fetch_array($query);

$img=$res['proofs'];





$up=mysqli_query($con,"update expense set reason='$reason', status='1',modify_date=now(),deleted_date=now(),deleted_by='".$_SESSION['user_roles']."' where expense_id='$eid' and session ='".$_SESSION['session']."' ");
if($up){
	unlink('images/proof/'.$img);
}
header('location:dashboard.php?option=view_expense');



?>