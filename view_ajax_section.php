<?php 
include('connection.php');
$sub_cat=$_REQUEST['sub_id'];
?>


<select class="form-control" name="stusection" id="sub_cat" required>
<option value="" selected disabled>--Select Section--</option>

<?php 
$c=mysqli_query($con,"select * from section where class_id='$sub_cat'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['section_id']; ?>"><?php echo $s_res['section_name']; ?></option>
<?php }
?>
</select>