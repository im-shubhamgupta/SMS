<?php
	//error_reporting(1);
	include('connection.php');
	extract($_REQUEST);
	$fid=$_REQUEST['fid'];
	$sql=mysqli_query($con,"select * from fees where fees_id='$fid'");
	$res=mysqli_fetch_array($sql);
	$id=$res['fees_id'];
	$cid=$res['class_id'];

		
		if(isset($update))
		{
			mysqli_query($con,"update fees set admissionfees='$admissionfees', tutionfees='$tutionfees', misfees='$misfees' where fees_id='$fid'");		
			echo "<script>window.location='dashboard.php?option=view_fees'</script>";	
			
		}
	
?>
<div class="card">
<form action="" method="post">
	<div class="card-header">
		<strong>Update</strong> Fees
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
		<!--	<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Class</label>
			<select class="form-control" name="class" required>
					<option value="" selected disabled>---Select Class--</option>
					<?php
						//$sql = "SELECT * FROM class";
						//$resultset = mysqli_query($con, $sql);
						//while( $rows = mysqli_fetch_array($resultset) ) {
						?>
						//<option <?php if($rows['class_id']==$cid){echo "selected";}?> value="<?php echo $rows['class_id'];?>"><?php echo $rows['class_name'];?></option>
						<?php //} ?>		
				</select>
			
			</div> -->
			
			<?php
			$sql = "SELECT * FROM class where class_id='$cid'";
			$resultset = mysqli_query($con, $sql);
		    $rows = mysqli_fetch_array($resultset);
			
			?>
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Class Name</label>
			<input type="text" name="class" value="<?php echo $rows['class_name'] ?>" class="form-control" placeholder="Enter Admission Fees" required readonly>
			</div>
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Admission Fees</label>
			<input type="number" name="admissionfees" value="<?php echo $res['admissionfees'] ?>" class="form-control" placeholder="Enter Admission Fees" required>
			</div>
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Tuition Fees</label>
			<input type="number" name="tutionfees" value="<?php echo $res['tutionfees'] ?>" class="form-control" placeholder="Enter Tuition Fees" required>
			</div>
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Miscellaneous Fees</label>
			<input type="number" name="misfees"  value="<?php echo $res['misfees'] ?>" class="form-control" placeholder="Enter Miscellaneous Fees Fees" required>
			</div>
			
		
	</div>
	<div class="card-footer">
		<button type="submit" name="update" class="btn btn-primary btn-sm">
			<i class="fa fa-dot-circle-o"></i> Update
		</button>
		
		<a href="dashboard.php?option=view_fees" class="btn btn-primary btn-sm">Back</a>
		
	</div>
	</form>
</div>