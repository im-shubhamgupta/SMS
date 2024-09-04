<?php 
include('connection.php');
$searchid=$_REQUEST['searchid'];
?>


<select class="form-control" name="stuname" id="sub_cat" required>
<option value="" selected disabled>--Select Section--</option>

<?php 
$c=mysqli_query($con,"select * from students");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['student_name']; ?>"><?php echo $s_res['student_name']; ?></option>
<?php }
?>
</select>