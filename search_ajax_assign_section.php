<?php 

extract($_REQUEST);

include('connection.php');

//$st_id=$_REQUEST['st_id'];



?>



<select class="form-control" style="width:175px;" required>

<!-- <option value="" selected="selected" disabled>Select Section</option> -->



<?php 

$q=mysqli_query($con,"select distinct(section_id) from assign_subject where class_id='$cls_id' && st_id ='$stid'");

while($r=mysqli_fetch_array($q))

{

	$secid = $r['section_id'];

	$q1 = mysqli_query($con,"select * from section where section_id='$secid'");

	$r1 = mysqli_fetch_array($q1);

	

?>

<option value="<?php echo $r1['section_id']; ?>"><?php echo $r1['section_name']; ?></option>

<?php }

?>

</select>