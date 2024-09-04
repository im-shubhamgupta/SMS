<?php
	//error_reporting(1);
	include('connection.php');
	extract($_REQUEST);
	$sid=$_REQUEST['sid'];
	$sql=mysqli_query($con,"select * from subject where subject_id='$sid'");
	$res=mysqli_fetch_array($sql);
	$class=$res['class_id'];
	$subject=$res['subject_name'];
		
	if(isset($update))
	{
		$que=mysqli_query($con,"select * from subject where class_id='$class' && subject_name='$nsubject'");
		
		$chk=mysqli_num_rows($que);
		
		if($chk)
		{
			$err="<span id='err_notsuccessful'>[ This Subject Is Already Exists ]</span>";	
		}
		else{	
		mysqli_query($con,"update subject set subject_name='$nsubject' where subject_id='$sid'");
		echo "<script>window.location='dashboard.php?option=view_subject'</script>";	
		}
	}	
?>
<div class="card">
<form action="" method="post">
	<div class="card-header">
		<strong>Update</strong> Subject
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Class</label>
			
					<?php
						$sql = "SELECT * FROM class where class_id='$class'";
						$resclass = mysqli_query($con, $sql);
						$rows  = mysqli_fetch_array($resclass); 	
					?>
			<input type="text" value="<?php echo $rows['class_name']; ?>" readonly class="form-control" name="nclass">
							
			</div>
			<div class="form-group">
			<label for="nf-email" class="form-control-label">Enter Subject</label>
			<input type="text" name="nsubject" placeholder="Enter Subject" value="<?php echo $subject;?>" class="form-control" required>
			</div>
		
	</div>
	<div class="card-footer">
		<button type="submit" name="update" class="btn btn-secondary btn-sm">
			<i class='fa fa-edit'></i> Update
		</button>
		
		<a href="dashboard.php?option=view_subject" class="btn btn-info btn-sm">
		<i class='fa fa-arrow-left'> Back</i></a>
	</div>
	</form>
</div>