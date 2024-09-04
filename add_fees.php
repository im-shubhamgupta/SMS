
 <?php
	//error_reporting(1);
	extract($_REQUEST);
	if(isset($add))
	{		
		//$sql=mysqli_query($con,"select * from fees where class_id='$class' && ptype_id='$feestype'");
		$sql=mysqli_query($con,"select * from fees where class_id='$class'");
		$res=mysqli_num_rows($sql);
		if($res)
		{
			$err="<style='color:red;font-weight:bold'>[ This Fees Is Already Assigned for This Class. ]</style>";	
		}
		else
		{
			$query="insert into fees(class_id,admissionfees,tutionfees,misfees)  values('$class','$admissionfees','$tutionfees','$misfees')";	
			mysqli_query($con,$query);
			$err="<style='color:green;font-weight:bold'>[ Fees Added Successfully ]</style>";
		}
		
	}
	
?>
<div class="card">
<!-- breadcrumb-->
<style>
.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
	margin-left:-18px;
	margin-top:-17px;
    background-color: #237791;
    border-radius: .25rem;
	font-size:19px;
}
.breadcrumb-item{
	color:#fff;
}
.breadcrumb-item .fa fa-home{
	color:#fff;
}
.breadcrumb-item.active {
    color: #eff7ff;
}
.breadcrumb-item+.breadcrumb-item::before {
    display: inline-block;
    padding-right: .5rem;
    color: #eff4f9;
    content: "/";
} 

</style>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Fees
  <a class="breadcrumb-item" href="dashboard.php?option=view_fees">View Fees  </a>
  <span class="breadcrumb-item active">Add  Fees</span>
</nav>
<!-- breadcrumb -->
<form action="" method="post">
	<div class="card-header">
		<strong>Add</strong> Fees
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Class</label>
			<select class="form-control" name="class" required>
					<option value="" selected disabled>---Select Class--</option>
					<?php
						$sql = "SELECT * FROM class";
						$resultset = mysqli_query($con, $sql);
						while( $rows = mysqli_fetch_array($resultset) ) {
						?>
						<option value="<?php echo $rows['class_id']; ?>"><?php echo $rows['class_name']; ?>
						</option>
						<?php } ?>	
				</select>
			
			</div>
			
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Admission Fees</label>
			<input type="number" name="admissionfees" class="form-control" placeholder="Enter Admission Fees" required>
			</div>
			
	<!--		<div class="form-group">
			<label for="nf-email" class=" form-control-label">Tuition Fees Type</label>
			<select class="form-control" name="feestype" required>
					<option value="" selected disabled>---Select Tuition Fees Type--</option>
				<?php
					//	$sql = "SELECT * FROM transport_pricetype";
					//	$resultset = mysqli_query($con, $sql);
					//	while( $rows = mysqli_fetch_array($resultset) ) {
						?>
					//	<option value="<?php echo $rows['ptype_id']; ?>"><?php echo $rows['ptype_name']; ?>
					//	</option>
						<?php // } ?>	
				</select>
			
			</div> -->
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Tuition Fees</label>
			<input type="number" name="tutionfees" class="form-control" placeholder="Enter Tuition Fees" required>
			</div>
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Miscellaneous Fees</label>
			<input type="number" name="misfees" class="form-control" placeholder="Enter Miscellaneous Fees Fees" required>
			</div>
			
		
	</div>
	<div class="card-footer">
		<button type="submit" name="add" class="btn btn-primary btn-sm" style="background-image: linear-gradient(-90deg, #cc9216, #9c6c05);border:2px solid #f0f3f5;padding:10px;">
			<i class="fa fa-plus"></i> Add Fees
		</button>
		
	</div>
	</form>
</div>