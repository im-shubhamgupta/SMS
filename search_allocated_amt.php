<?php 

extract($_REQUEST);

include('connection.php');



$c=mysqli_query($con,"select * from allocate_budget where budget_header_id ='$header_id' and session='".$_SESSION['session']."'");

$r=mysqli_fetch_array($c);

echo $r['allocate_amount'];

?>

