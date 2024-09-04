<?php 
session_start();
extract($_REQUEST);
include('connection.php');
$cls_id=$_REQUEST['cls_id'];

?>

<select class="form-control" name="section" style="width:175px;" required>
<option value="" selected disabled>Select Period</option>
<option value="">All</option>		
<?php 
$c=mysqli_query($con,"select distinct period from staff_timetable where class_id='$cls_id'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['period']; ?>"><?php echo $s_res['period']; ?></option>
<?php }
?>
</select>