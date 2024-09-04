 <?php
	error_reporting(1);
	extract($_REQUEST);
	
	if(isset($add))
	{		
		
		$sql=mysqli_query($con,"select * from panel where panel_name='$panel'");
		$res=mysqli_num_rows($sql);
		if($res)
		{
			$err="<style='color:red;font-weight:bold'>[ This Panel Is Already Exists ]</style>";	
		}
		else
		{
			$query=mysqli_query($con,"insert into panel values('','$panel')");	
			
			$err="<style='color:green;font-weight:bold'>[Panel Added Successfully ]</style>";
		}
		
	}
	
?>
<div class="card">
<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Administration Panel</a>
  <a class="breadcrumb-item" href="#">Activity History</a>
  <a class="breadcrumb-item" href="#">View Panel</a>
  <span class="breadcrumb-item active">Add Panel</span>
</nav>
<!-- breadcrumb -->
<form action="" method="post">
	<div class="card-header">
		<strong>Add</strong> Panel
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Enter Panel</label>
			<input type="text" name="panel" placeholder="Enter Panel" class="form-control" required></div>
		
	</div>
	<div class="card-footer">
		<button type="submit" name="add" class="btn btn-primary btn-sm">
		<i class="fa fa-plus"></i> Add Panel
		</button>
		
		<a href="dashboard.php?option=view_panel" class="btn btn-info btn-sm"> 
		<i class='fa fa-arrow-left'> Back</i></a>
	</div>
</form>
</div>