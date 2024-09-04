<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

$username=$res['username'];



// if(isset($save))

// {

	

// 	$q1 = mysqli_query($con,"update assign_syllabus_staff set status='$status', completion_date='$completion_dt', 

// 	comments='$comments', updated_dt=now(), updated_by='$username' where assign_syllabus_id='$id'");

	

// 	echo "<script>alert('Status Updated.');</script>";

// }

?>



<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<script src="multi.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

	

	<style>

	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	}



	</style>

	

<script type="text/javascript">

$(document).ready(function(){

    $(".menu a").each(function(){

        if($(this).hasClass("disabled")){

            $(this).removeAttr("href");

        }

    });

});

</script>

<!-- breadcrumb-->

<style>



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb" style="width:1000px;">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Staff Panel</a>

  <a class="breadcrumb-item" href="#">Syllabus Management</a>  

  <a class="breadcrumb-item" href="dashboard.php?option=update_allocated_syllabus_status">Update Allocated Syllabus Status</a>  

  <span class="breadcrumb-item active">Update Syllabus Status</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">	

		<div class="col-md-2">Status : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

		<select style="width:170px;" name="status" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Status</option>

		<option value="1">Done</option>

		<option value="2">In Progress</option>

		<option value="3">Not Started</option>

		</select>

		</div>

		

		<div class="col-md-2" style="margin-left:50px;">Completion Date : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:0px;">

		<input type="date" name="completion_dt" class="form-control" style="width:175px;" required autofocus>

		</div>

		

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Comments : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

	<textarea name="comments" class="form-control" style="width:580px;height:50px;" required autofocus></textarea>
	<input type="hidden" name="id" value="<?=$_GET['id']?>">

	</div>

	</div>

	<br><br>

	

	<div>

	<input type="submit" name="save" value="Update" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-sm"/>

	</div>
</form>
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
	// console.log(this);
	// alert(12);
  var action ="UpdateSyllabusStatus";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("Please wait...");  
	$("input[type='submit']").attr("disabled", true);

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
			// console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
					// window.loaction.reload();
				window.location.href='dashboard.php?option=update_allocated_syllabus_status';
				},3000);
			}
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("input[type='submit']").val("Update");  
	      $("input[type='submit']").attr("disabled", false);
	      // $('form')[0].reset();
		}
	})
});

});

</script>
