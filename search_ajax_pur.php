<?php 
extract($_REQUEST);
include('connection.php');

?>

<option value="" selected disabled>Select Purchase</option>

<?php 
$c=mysqli_query($con,"select * from purchase_order where stock_type_id='$stock_id'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['pur_ord_id']; ?>"><?php echo $s_res['poid']; ?></option>
<?php }
?>
