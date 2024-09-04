 <?php

	//error_reporting(1);

	extract($_REQUEST);

	$q1=mysqli_query($con,"select * from student_restrict where id='1'");

	$r1=mysqli_fetch_array($q1);

	$tstu=$r1['total_students'];

	

	if(isset($save))

	{		

		$query=mysqli_query($con,"update student_restrict set total_students='$tstudents'");	

		//$err="<style='color:green;font-weight:bold'>[ Added Successfully ]</style>";

		echo "<script>window.location='dashboard.php?option=student_restrict'</script>";

	}

	

?>
 <!-- style="width:600px;" -->
<div class="card" >

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Setting Panel</a>

  <span class="breadcrumb-item active">Students Restriction</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Students</strong> Restriction

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Total No. of Students</label>

			<input type="text" name="tstudents" class="form-control" value="<?php echo $tstu;?>" required></div>

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="save" class="btn btn-primary btn-sm">

			 Save

		</button>

		

	</div>

	</form>

</div>