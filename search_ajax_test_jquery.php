<?php 
extract($_REQUEST);
include('connection.php');

?>

<option value="" selected>Select Test</option>
<?php 
$c=mysqli_query($con,"select distinct(test_name) from test where class_id='$cls_id' && section_id='$sec_id'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['test_name']; ?>"><?php echo $s_res['test_name']; ?></option>
<?php }
?>
