<?php

	error_reporting(1);


?>





<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Staff Management</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_staff">View Staff</a>

  <span class="breadcrumb-item active">Add Staff</span>

</nav>

<!-- breadcrumb -->



<form action="" method="post" enctype="multipart/form-data" id="devel-generate-content-form">

	<div class="card-header">

	

		<strong>Add</strong> Staff

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:850px;">

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="name" pattern="[a-z A-Z]*" class="form-control" placeholder="Enter Name" required>

			<input type="hidden" name="roles" value="<?php echo $roles;?>" >
			<input type="hidden" name="panelid" value="<?php echo $panelid;?>" >
			<input type="hidden" name="menuid" value="<?php echo $menuid;?>" >
			<input type="hidden" name="submenuname" value="<?php echo $submenuname;?>" >
			<input type="hidden" name="machinename" value="<?php echo $machinename;?>" >
			<input type="hidden" name="ExactBrowserNameBR" value="<?php echo $ExactBrowserNameBR;?>" >
			<input type="hidden" name="currdt" value="<?php echo $currdt;?>" >

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Staff ID <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" onchange="chkstafid()" name="staffid" id="staffid" class="form-control" placeholder="Enter Staff Id" autocomplete="off" required><span id="res1" ></span>

			</div>

			</div>

			</div>

			

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label" style="margin-top:10px">Select Gender <span style="color:red;font-weight:bold;">*</span></label><br>

			<input type="radio" name="gender" value="MALE" checked>&nbsp;MALE &nbsp;

			<input type="radio" name="gender" value="FEMALE">&nbsp;FEMALE

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class="form-control-label">Address <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="address" placeholder="Enter Address" required></textarea>

			</div>

			</div>

			</div>

			

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Mobile Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="mobno" name="mobno" class="form-control mobile" placeholder="Enter Mobile No" required><span class="mobile_error"></span>	

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Password <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" id="password" name="password" class="form-control" placeholder="Enter Password" required><span id="wm2"></span>

			</div>

			</div>

			</div>

				

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Alternate Mobile Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" id="altmobno" name="altmobno" class="form-control mobile" placeholder="Enter Alternate Number" required><span class="mobile_error"></span>	

			</div>

			</div>

					

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Qualification <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" name="qualification" placeholder="Enter Qualification" required>

			</div>

			</div>

			</div>

			

			<script>

			$(document).ready(function(){		

			$("#teachtype").change(function(){

			var ntotalpaid=document.getElementById("teachtype").value;

			//alert (ntotalpaid);

			if(ntotalpaid!="Others")

			{

				//alert("Paid amount should not be greater than amount to pay");

				document.getElementById("others").disabled = true;

				document.getElementById("others").value = "";

			}

			else

			{

				document.getElementById("others").disabled = false;

				document.getElementById("others").required = true;

			}

			});

			});

			</script>

			

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Skills <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" name="skills" placeholder="Enter Skills" required>

			</div>

			</div>	

			

			<div class="col-md-6">	

			<div class="form-group">

				<div class="row">

				<div class="col-md-6">

				<label class=" form-control-label">Teaching Type <span style="color:red;font-weight:bold;">*</span></label>

				<select class="form-control" name="teachtype" id="teachtype" onchange="chkteach()" required selected="selected">

						<option value="">Select Teaching Type</option>

						<option value="Teaching">Teaching</option>

						<option value="Non-Teaching">Non-Teaching</option>

						<option value="Others">Others</option>

				</select>

				</div>

				<div class="col-md-6">

				<label class=" form-control-label"></label>

				<input class="form-control" type="text" name="others" id="others" disabled style="margin-top:9px;">

				</div>

				</div>

			</div>

			</div>

			</div>

						

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Date of Joining <span style="color:red;font-weight:bold;">*</span></label>

			<input type="date" class="form-control" name="joindate" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Designation <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" class="form-control" name="designation" placeholder="Enter Designation" required>

			</div>

			</div>

			</div>

			

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Message Type <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="msg_type" required>

			<?php

			$qmsg = mysqli_query($con,"select * from message_type");

			while($rmsg = mysqli_fetch_array($qmsg))

			{

			?>	

			<option value="<?php echo $rmsg['msg_type_id'];?>"><?php echo $rmsg['msg_name'];?></option>

			<?php

			}

			?>

			</select>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Aadhar No <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" class="form-control aadhar" id="aadharno" name="aadharno" placeholder="Enter Aadhar No" required><span class="aadhar_error"></span>

			</div>

			</div>

			</div>

			

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Caste </label>

			<input type="text" class="form-control" name="caste" placeholder="Enter Caste">

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Image Upload</label>

			<input type="file" name="propic" class="form-control">

			</div>

			</div>

			</div>

			

			<div class="row">	

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Resume Upload</label>

			<input type="file" name="resume" class="form-control">

			</div>

			</div>

			</div>

			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="add_staff" id="add_staff" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add Staff

		</button>

		

		<a href="dashboard.php?option=view_staff" class="btn btn-info btn-sm"> 

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
  var action = $("#add_staff").attr("name");
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#add_staff").text("Sending, please wait...");  
	$("#add_staff").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"AjaxHandler.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.type=="SUCCESS"){
				// alert('success');
				toastr.success(result.message); 

				// setInterval(function(){ 
				// window.location.href='dashboard.php?option=add_staff&smid=15';
				// },3000);
				setTimeout(function(){
		 		   $('#devel-generate-content-form')[0].reset();	
		 		   $("#add_staff").text("Add Staff");  
	         $("#add_staff").attr("disabled", false);
		 	  },3000)
			}
			else if(result.type=="FAILED"){
				toastr.error(result.message); 
				$("#add_staff").text("Add Staff");  
	      $("#add_staff").attr("disabled", false);

			}
			else if(result.type=="ERROR"){
				toastr.error(result.message); 
				$("#add_staff").text("Add Staff");  
	      $("#add_staff").attr("disabled", false);

			}else if(result.type=="ALREADY"){
				toastr.error(result.message);
				$("#add_staff").text("Add Staff");  
	      $("#add_staff").attr("disabled", false);
			}
		}
	})
});

});

</script>

