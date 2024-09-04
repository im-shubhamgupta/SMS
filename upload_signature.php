<?php

	//error_reporting(1);

	extract($_REQUEST);

	

	$q1 = mysqli_query($con,"select * from upload_sign where sign_id='1'");

	$r1 = mysqli_fetch_array($q1);

	$oldpic = $r1['signature'];
	$designation = $r1['designation'];

	

 	if(isset($add))

	{		

			$img1=$_FILES['sign1']['name'];

			

			$query="update upload_sign set designation='$name', signature='$img1',modify_date=now() where sign_id='1'";

			$img_up=move_uploaded_file($_FILES['sign1']['tmp_name'],"images/signature/".$_FILES['sign1']['name']);

						

			if(mysqli_query($con,$query) && $img_up)

			{

				//$action = "Expense type ".$expense." is created"; 

				// $q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

				// machine_name,browser,date) 

				// values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

				// $err="<style='color:green;font-weight:bold'>[ Signature Added Successfully ]</style>";
				$err="<script>window.location='dashboard.php?option=upload_signature'</script>";


			}else{
				$err="<style='color:red;font-weight:bold'>[ Signature not uploaded ]</style>";
			}

	}

	

?>



<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_expense_type">ID Card</a>

  <span class="breadcrumb-item active">View & Upload Signature</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Upload</strong> Signature

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Enter Designation</label>

			<input type="text" name="name" class="form-control" required autofocus value='<?=$designation?>'>

			</div>

						

			<div class="row">

			<div class="col-md-3">

			<label for="nf-email" class=" form-control-label">Upload Signature</label>

			<input type="file" name="sign1" class="form-control" required autofocus>

			</div>

			<div class="col-md-3">	

			<div class="form-group">

			<a href="images/signature/<?php echo $oldpic;?>"><img src="images/signature/<?php echo $oldpic;?>" width='150px' height='90px' style='margin-left:20px;'/>

			</div>

			</div>

			</div>

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">Submit</button>

		

		<!--<a href="dashboard.php?option=view_expense_type" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>-->

	</div>

</form>

</div>