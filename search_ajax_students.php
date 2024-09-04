<?php 
session_start();
extract($_REQUEST);
include('connection.php');

?>

<select class="form-control" style="width:175px;">
<?php 
$c=mysqli_query($con,"select * from students where class_id='$cls_id'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['student_id']; ?>"><?php echo $s_res['student_name']; ?></option>
<?php 
}
?>
</select>