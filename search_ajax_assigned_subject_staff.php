<?php 
session_start();
extract($_REQUEST);
include('connection.php');

?>

<select class="form-control" style="width:170px;" required>
<option value="" selected>Select Subject</option>

<?php 
$c=mysqli_query($con,"select * from assign_subject where st_id='$stid' && class_id='$clid' && section_id='$secid'");
while($r=mysqli_fetch_array($c))
{
	$subid = $r['subject_id'];
	$q1 = mysqli_query($con,"select * from subject where subject_id='$subid'");
	$r1 = mysqli_fetch_array($q1);
?>
<option value="<?php echo $r1['subject_id']; ?>"><?php echo $r1['subject_name']; ?></option>
<?php }
?>
</select>