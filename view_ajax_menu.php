<?php 
include('connection.php');
$panelid=$_REQUEST['panel_id'];
?>


<select class="form-control" name="stusection" id="menu" required>
<option value="" selected disabled>--Select Menu--</option>

<?php 
$c=mysqli_query($con,"select * from menu where panel_id='$panelid'");
while($s_res=mysqli_fetch_array($c))
{
?>
<option value="<?php echo $s_res['menu_id']; ?>"><?php echo $s_res['menu_name']; ?></option>
<?php }
?>
</select>