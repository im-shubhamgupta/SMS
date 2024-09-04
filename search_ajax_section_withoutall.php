<?php 

session_start();

extract($_REQUEST);

include('connection.php');

$cls_id=$_REQUEST['cls_id'];



?>



<select class="form-control" name="section" style="width:175px;" required>

<!-- <option value="" selected="selected" disabled>Select Section</option> -->



<?php 

$c=mysqli_query($con,"select * from section where class_id='$cls_id'");

while($s_res=mysqli_fetch_array($c))

{

?>

<option value="<?php echo $s_res['section_id']; ?>"><?php echo $s_res['section_name']; ?></option>

<?php }

?>

</select>