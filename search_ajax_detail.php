<?php 
extract($_REQUEST);
include('connection.php');

$q=mysqli_query($con,"select * from students where student_id='$stu_id'");
$r=mysqli_fetch_array($q);
$regno=$r['register_no'];
$fathername=$r['father_name'];
$mobile=$r['parent_no'];

?>
		<div class="col-md-2">Register No : </div>
		<div class="col-md-2">
		<input type="text" name="regno" class="form-control" value="<?php echo $regno;?>" 
		readonly required style="margin-left:-30px;">
		</div>
		
		<div class="col-md-2">Father Name :</div>
		<div class="col-md-2">
		<input type="text" name="fathername" class="form-control" value="<?php echo $fathername;?>"
		style="margin-left:-60px;width:155px;" readonly required>
		</div>
		
		<div class="col-md-2" style="margin-left:-30px;">Father Mobile :</div>
		<div class="col-md-2">
		<input type="text" name="mobile" class="form-control" value="<?php echo $mobile;?>" readonly required>
		</div>
