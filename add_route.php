<?php
	//error_reporting(1);
	extract($_REQUEST);
	if(isset($add))
	{		
		$sql=mysqli_query($con,"select * from route where route_name='$route'");
		$res=mysqli_num_rows($sql);
		if($res)
		{
			$err="<style='color:red;font-weight:bold'>[ This Route Is Already Exists. Plaese Select Another Route ]</style>";	
		}
		else
		{
			$query="insert into route values('','$route')";	
			mysqli_query($con,$query);
			$err="<style='color:green;font-weight:bold'>[ Route Added Successfully ]</style>";
		}
		
	}
	
?>
<div class="card">
<form action="" method="post">
	<div class="card-header">
		<strong>Add</strong> Transport
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Route Name</label>
			<input type="text" name="route" required class="form-control">
			</select>
			</div>
					
	</div>
	<div class="card-footer">
		<button type="submit" name="add" class="btn btn-primary btn-sm">
			<i class="fa fa-dot-circle-o"></i> Add
		</button>
		
	</div>
	</form>
</div>