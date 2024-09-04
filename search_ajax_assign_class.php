<?php 
extract($_REQUEST);
include('connection.php');
$st_id=$_REQUEST['st_id'];

?>

<select class="form-control" style="width:175px;" required>
<option value="" selected="selected" disabled>Select Class</option>

<?php 
$q=mysqli_query($con,"select distinct(class_id) from assign_subject where st_id ='$st_id'");
while($r=mysqli_fetch_array($q))
{
	$clid = $r['class_id'];
	$q1 = mysqli_query($con,"select * from class where class_id='$clid'");
	$r1 = mysqli_fetch_array($q1);
	
?>
<option value="<?php echo $r1['class_id']; ?>"><?php echo $r1['class_name']; ?></option>
<?php }
?>
</select>