<?php 

include('connection.php');

$eid=$_GET['x'];

$reason=$_GET['rea'];

$query=mysqli_query($con,"select * from transport_expense where trans_expense_id='$eid'");

$res=mysqli_fetch_array($query);

$img=$res['proofs'];

// unlink('images/transport/'.$img);



mysqli_query($con,"update transport_expense set reason='$reason', status='1' where trans_expense_id='$eid'");

header('location:dashboard.php?option=view_transport_expense');



?>