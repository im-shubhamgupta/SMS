<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);
$query=mysqli_query($con,"select * from sms_setting");
$res=mysqli_fetch_array($query);


?>
	<!-- breadcrumb-->

<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <span class="breadcrumb-item active">Previous Fees</span>
</nav>
<!-- breadcrumb -->	
		
		<div class="content mt-3" style="width:1000px;">	
		<div class="col-md-9">
			<div class="card">
			  <div class="card-header">
				<strong>Update</strong> Previous Fees Authorization
			  </div>
				<div class="card-body card-block">
				<form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">
										
					<div class="row form-group">
					<div class="col-md-2">
					<label for="email-input" class=" form-control-label">Status</label>
					</div>
					<div class="col-md-9">
					<?php
					$que=mysqli_query($con,"select * from superadmin_authority where id='1'");
					$res=mysqli_fetch_array($que);
					$id=$res['id'];
					$sta=$res['status'];
					if($sta==1)
					{
					?>
					<a href='dashboard.php?option=edit_previous_fees_auth&id=<?php echo $id;?>&status=<?php echo $sta;?>'><button type="button" class="btn btn-danger" style="width:100px;border-radius:20px">OFF</button></a>
					<span id='err_notsuccessful'>Click To Deactivate Changes</span>
					<?php
					}
					else
					{						
					?>
					<a href='dashboard.php?option=edit_previous_fees_auth&id=<?php echo $id;?>&status=<?php echo $sta;?>'><button type="button" class="btn btn-success" style="width:100px;border-radius:20px;margin-right:20px;">ON</button></a>
					<span id='err_successful'>Click To Activate Changes</span>
					<?php
					}
					?>
					</div>
					</div><br>
								  
				</div>
				</form>
			</div>
	    </div>

<script>
function limit(element)
{
    var max_chars = 6;

    if(element.value.length > max_chars) {
        element.value = element.value.substr(0, max_chars);
    }
}
</script>
