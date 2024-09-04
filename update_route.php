<?php
	//error_reporting(1);
	include('connection.php');
	extract($_REQUEST);
	$rid=$_REQUEST['rid'];
	$sql=mysqli_query($con,"select * from route where route_id='$rid'");
	$res=mysqli_fetch_array($sql);
	$route=$res['route_name'];
		
	
	if(isset($update))
	{
		$que=mysqli_query($con,"select * from route where route_name='$nroute'");
		
		$chk=mysqli_num_rows($que);
		
		if($chk)
		{
			$err="<style='color:red;font-weight:bold'>[ This Route Is Already Exists ]</style>";	
		}
		else
		{	
		mysqli_query($con,"update route set route_name='$nroute' where route_id='$rid'");		
		echo "<script>window.location='dashboard.php?option=view_route'</script>";	
		}
	}	
?>
<div class="card">
<form method="post">
	<div class="card-header">
		<strong>Update</strong> Transport
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:red"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Route Name</label>
			<input type="text" name="nroute" value="<?php echo $route; ?>" class="form-control" placeholder="Enter Price" required>
			</div>
			
		
	</div>
	<div class="card-footer">
		<button type="submit" name="update" class="btn btn-primary btn-sm">
			<i class="fa fa-dot-circle-o"></i> Update
		</button>
		
	</div>
	</form>
</div>