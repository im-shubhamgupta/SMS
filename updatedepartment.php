<?php
	error_reporting(1);
	extract($_REQUEST);
	$id = $_REQUEST['id'];
	$query = mysqli_query($con,"select * from department where dept_id='$id'");
	$res = mysqli_fetch_array($query);
	$deptname = $res['dept_name']; 
		
	if(isset($update))
	{		
		$sql=mysqli_query($con,"select * from department where dept_name='$ndeptname'");
		$row=mysqli_num_rows($sql);
		if($row)
		{
			$err="<span id='err_notsuccessful'>[ This Department Is Already Exists ]</span>";	
		}
		else
		{
			$query=mysqli_query($con,"update department set dept_name='$ndeptname' where dept_id='$id'");	
			if($query)
			{
				$action = "Department ".$ndeptname." is edited"; 
				$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
				machine_name,browser,date) 
				values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
			}
			
			echo "<script>window.location='dashboard.php?option=view_department'</script>";
		}
		
	}
	
?>
<div class="card">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Staff Panel</a>
  <a class="breadcrumb-item" href="#">Staff Management</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_department">View Department</a>
  <span class="breadcrumb-item active">Update Department</span>
</nav>
<!-- breadcrumb -->
<form action="" method="post">
	<div class="card-header">
		<strong>Update</strong> Department
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Enter Department</label>
			<input type="text" name="ndeptname" value="<?php echo $deptname;?>" placeholder="Enter Group" 
			class="form-control" required></div>
		
	</div>
	<div class="card-footer">
		<button type="submit" name="update" class="btn btn-info btn-sm">
			<i class='fa fa-edit'> </i> Update
		</button>
		
	</div>
</form>
</div>