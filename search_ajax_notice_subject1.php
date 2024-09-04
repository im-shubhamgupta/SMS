<?php 
session_start();
extract($_REQUEST);
include('connection.php');

?>

<select class="form-control" style="width:175px;">
<option>All</option>

<?php 
$c=mysqli_query($con,"select * from subject where class_id='$cls_id'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['subject_id']; ?>"><?php echo $s_res['subject_name']; ?></option>
<?php }
?>
</select>