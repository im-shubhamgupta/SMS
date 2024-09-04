<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



// $q = mysqli_query($con,"select * from assign_subject where assign_sub_id='$id'");

// $r = mysqli_fetch_array($q);

// $stid = $r['st_id'];

// $clid = $r['class_id'];

// $secid = $r['section_id'];

// $subid = $r['subject_id'];



// if(isset($save))

// {

	

	// $q1 = $con->query("insert into assign_syllabus_staff (staff_id,class_id,section_id,subject_id,chapter,from_dt,

	// to_dt,days,description,status,creation_dt) values('$stid','$clid','$secid','$subid','$chapter','$fromdt','$todt','$days','$description','3',now())");

	

	// if(mysqli_error($con)){

	// 	echo("Error description: " . mysqli_error($con));

	// }

	

// 	echo "<script>alert('Syllabus Assigned.');</script>";

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

  <a class="breadcrumb-item" href="dashboard.php?option=assign_syllabus_staff">Assign Syllabus to Staff</a>  

  <span class="breadcrumb-item active">Assign Syllabus</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Chapter : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

		<input type="text" name="chapter" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:50px;">Days : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-70px;">

		<input type="number" name="days" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-top:50px;margin-left:20px;">	

		<div class="col-md-2">From Date : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

		<input type="date" name="fromdt" class="form-control" style="width:175px;" required autofocus>
		<input type="hidden" name="id" value="<?=$_GET['id']?>">

		</div>

		

		<div class="col-md-2" style="margin-left:50px;">To Date : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-70px;">

		<input type="date" name="todt" class="form-control" style="width:175px;" required autofocus>

		</div>

		

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-50px;">

	<textarea name="description" class="form-control" style="width:580px;height:80px;" required autofocus></textarea>

	</div>

	</div>

	<br><br>

	

	<div>

	<input onclick="return confirm('Do you want to create a Allocation.');" type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

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
  var action ="AssignSyllabus";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("Please wait...");  
	$("input[type='submit']").attr("disabled", true);

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
			// console.log(responce);
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=assign_syllabus_staff';
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			

			}
			  $("input[type='submit']").val("Assign");  
	      $("input[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>

