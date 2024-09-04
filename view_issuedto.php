<?php 
include('connection.php');
$issueddept=$_REQUEST['issueddept'];

if($issueddept=="department")
{
?>

<select class="form-control" required>
<option value="" selected disabled>Select Department</option>

<?php 
$c=mysqli_query($con,"select * from department");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['dept_id']; ?>"><?php echo $s_res['dept_name']; ?></option>
<?php }
?>
</select>	

<?php	
}
else
{
?>

<select class="form-control" required>
<option value="" selected disabled>Select Staff</option>

<?php 
$c=mysqli_query($con,"select * from staff");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['st_id']; ?>"><?php echo $s_res['staff_name']; ?></option>
<?php }
?>
</select>

<?php	
}
?>





