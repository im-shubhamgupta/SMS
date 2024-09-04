<?php 
extract($_REQUEST);
include('connection.php');

$q=mysqli_query($con,"select * from section where section_id='$sec_id'");
$r=mysqli_fetch_array($q);
$clsid=$r['class_id'];

?>

<option value="" selected disabled>Select</option>

<?php 
$qe=mysqli_query($con,"select  distinct(test_name),test_id from test where class_id='$clsid' and section_id='$sec_id' and session='".$_SESSION['session']."' group by test_name");
while($rqe=mysqli_fetch_array($qe))
{	
?>
<option value="<?php echo $rqe['test_id']; ?>"><?php echo $rqe['test_name']; ?></option>
<?php }
?>
