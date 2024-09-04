<?php 
include('connection.php');
$sub_cat=$_REQUEST['duration_id'];
$que=mysqli_query($con,"select * from transport where route_name='$sub_cat'");
$res=mysqli_fetch_array($que);
$dname=$res['route_name'];
?>


<select class="form-control" name="studuration" id="sub_cat" required>
<option value="" selected disabled>--Select Duration--</option>

<?php 
$c=mysqli_query($con,"select * from transport where route_name='$dname'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['price_type']; ?>"><?php echo $s_res['price_type']; ?></option>
<?php 
}
?>
</select>