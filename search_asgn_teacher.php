<?php 
extract($_REQUEST);
include('connection.php');

?>

<select name="faculty" id="faculty" class="form-control" style="width:175px;" autofocus required>
<option value="" selected="selected">Select Faculty</option>
<?php
$sct =mysqli_query($con,"select * from assign_clsteacher where section_id='$secid'");
while( $rsct = mysqli_fetch_array($sct))
{
	$ctid=$rsct['st_id'];
	$cl=mysqli_query($con,"select * from staff where st_id='$ctid'");
	$rcl=mysqli_fetch_array($cl);
?>
<option value="<?php echo $rcl['st_id']; ?>"><?php echo $rcl['staff_name']; ?></option>
<?php } ?>							
</select>