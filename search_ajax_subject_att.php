<?php 
session_start();
extract($_REQUEST);
include('connection.php');
$sec_id=$_REQUEST['sec_id'];


?>

<select class="form-control" style="width:175px;" required>
<option value="" selected="selected" disabled>Select Subject</option>

<?php 
$sec=mysqli_query($con,"select * from section where section_id='$sec_id'");
$sres=mysqli_fetch_array($sec);
$clsid=$sres['class_id'];

$c=mysqli_query($con,"select * from subject where class_id='$clsid'");
while($s_res=mysqli_fetch_array($c))
{
	
?>
<option value="<?php echo $s_res['subject_id']; ?>"><?php echo $s_res['subject_name']; ?></option>
<?php
}
?>
</select>
