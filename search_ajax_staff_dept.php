<?php 
session_start();
extract($_REQUEST);
include('connection.php');

?>

<select class="form-control" style="width:175px;">
<?php 
$c=mysqli_query($con,"select * from staff");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['st_id']; ?>"><?php echo $s_res['staff_name']; ?></option>
<?php 
}
?>
</select>