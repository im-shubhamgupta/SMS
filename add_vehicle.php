<?php

	error_reporting(1);

	// extract($_REQUEST);

	// if(isset($add))

	// {			
	// 	date_default_timezone_set('Asia/Kolkata');
	// 	$create_date=date('Y-m-d H:i:s');
	//   $modify_date=$create_date;
	//   $session=$_SESSION['session'];


	// 	$query=mysqli_query($con,"insert into vehicle (vehicle_name,vehicle_type,vehicle_number,chassis_no,purchased_year,

	// 	vehicle_status,about_vehicle,prev_exp,description,status,create_date,modify_date,session ) 

	// 	values ('$name','$vehicletype','$vehicleno','$chassisno','$purchasedyear','$vehicle_status','$aboutvehicle','$preexp',

	// 	'$description','0','$create_date','$modify_date','$session')");

	// 	if($query){

	// 	   $err="<span id='err_successful'>[ Vehicle Added Successfully ]</span>";

	// 	}else{
	// 			if(mysqli_error($con)){
	//     			echo ("Error description :" .mysqli_error($con));
  //  			}
	// 		 $err="<span id='err_successful' style='color:red'>[ Something Wrong Please Try Again ]</span>";
	// 	}		

	// }

?>



<link href="datejquery/jquery.datepicker2.css" rel="stylesheet">

<script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script>      



<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_vehicle">Vehicle Detail</a>

  <span class="breadcrumb-item active">Add Vehicle</span>

</nav>

<!-- breadcrumb -->



<form action="" method="post" enctype="multipart/form-data" id="vechicle_form">

	<div class="card-header">

	

		<strong>Add</strong> Vehicle

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:550px;">

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Vehicle Name <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="name" class="form-control" placeholder="Enter Vehicle Name" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Vehicle Type <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="vehicletype" class="form-control" placeholder="Enter Vehicle Type" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Vehicle Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="vehicleno" class="form-control" placeholder="Enter Vehicle Number" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Chassis Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="chassisno" class="form-control" placeholder="Enter Chassis Number" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Purchased Year <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" name="purchasedyear" class="form-control" placeholder="Enter Purchased Year" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">Status <span style="color:red;font-weight:bold;">*</span></label>

			<select class="form-control" name="vehicle_status" required>

				<option selected="selected" disabled value="">Select Vehicle Status</option>

				<option value="Running">Running</option>

				<option value="Maintenance">Maintenance</option>

				<option value="Non Working">Non Working</option>

			</select>

			</div>

			</div>

				

			<div class="col-md-6">	

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Previous Experience <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="preexp" class="form-control" placeholder="Enter Previous Experience" required>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">About Vehicle <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="aboutvehicle" placeholder="About Vehicle" required></textarea>

			</div>

			</div>

			

			<div class="col-md-6">	

			<div class="form-group">

			<label class=" form-control-label">About Him/Her <span style="color:red;font-weight:bold;">*</span></label>

			<textarea class="form-control" name="description" placeholder="Enter Description" required></textarea>

			</div>

			</div>			

				

		

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add

		</button>

		

		<a href="dashboard.php?option=view_vehicle" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>

	</form>

</div>





<script>

$("#mobno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#altmobno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>



<script>

$("#aadharno").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 12	) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>







<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>

<script src="datejquery/jquery.datepicker2.js"></script>

<script type="text/javascript">



  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-36251023-1']);

  _gaq.push(['_setDomainName', 'jqueryscript.net']);

  _gaq.push(['_trackPageview']);



  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();
</script>
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
	// alert(12);
	// console.log(this);
  var action ="Add_Vechicle";
	$(this).append("<input type='hidden' name="+action+" >");
	// var data_string=new FormData(this);
	var data_string=new FormData($('#vechicle_form')[0]);
	$("button[type='submit']").html("Please wait...");  
	$("button[type='submit']").attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/TransportController.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			// console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=add_vehicle';
					// $('form')[0].reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("button[type='submit']").html('<i class="fa fa-plus"></i> Add');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>