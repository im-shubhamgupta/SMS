<?php

	error_reporting(1);

	extract($_REQUEST);

	// if(isset($add))

	// {		

	// 	$sql=mysqli_query($con,"select * from department where dept_name='$deptname'");

	// 	$row=mysqli_num_rows($sql);

	// 	if($row)

	// 	{

	// 		$err="<span id='err_notsuccessful'>[ This Department Is Already Exists ]</span>";	

	// 	}

	// 	else

	// 	{

	// 		$query="insert into department values('0','$deptname')";	

	// 		if(mysqli_query($con,$query))

	// 		{

	// 			$action = "Department ".$deptname." is created"; 

	// 			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

	// 			machine_name,browser,date) 

	// 			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

	// 		}

	// 		$err="<span id='err_successful'>[ Department Added Successfully ]</span>";

	// 	}

		

	// }

	

?>

<div class="card">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_department">View Department</a>

  <span class="breadcrumb-item active">Create Department</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Create</strong> Department

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Department</label>

			<input type="text" name="deptname" placeholder="Enter Department" class="form-control" required></div>

			<input type="hidden" name="roles" value="<?=$roles?>">
			<input type="hidden" name="panelid" value="<?=$panelid?>">
			<input type="hidden" name="menuid" value="<?=$menuid?>">
			<input type="hidden" name="submenuname" value="<?=$submenuname?>">
			<input type="hidden" name="machinename" value="<?=$machinename?>">
			<input type="hidden" name="ExactBrowserNameBR" value="<?=$ExactBrowserNameBR?>">

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Create

		</button>

		

		<a href="dashboard.php?option=view_department" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>

</form>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){	
  toastr.options = {		
 		"closeButton": true, 
		"debug": false,"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,	

		"onclick": null,	
		"showDuration": "300",
		"hideDuration": "1000",	
		"timeOut": "3000",		
		"extendedTimeOut": "1000",
		"showEasing": "swing",	
		"hideEasing": "linear",	
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"	
		};					});

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action ="CreateDepartment";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
$("button[type='submit']").html("Please wait...");  
	$("button[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/StaffController.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=create_department&smid=22';
				},3000);
			}
			else if(result.type=="error"){
				toastr.error(result.msg); 
				
	    }
	    $("button[type='submit']").html("<i class='fa fa-plus'> Create"); 
	    $("button[type='submit']").attr("disabled", false);        
		}
	})
});

});

</script>
