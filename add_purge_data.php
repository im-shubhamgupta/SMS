<?php

error_reporting(1);

include('connection.php');

// extract($_REQUEST);


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

	



<style>



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Administration Panel</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_purge_data"> View Purge Data</a>

   <span class="breadcrumb-item active"> Add Purge Data</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Select Date : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="date" name="purgedate" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:50px;" required autofocus></textarea>

	</div>

	</div>



	<br><br>

	

	<div>

	<input type="submit" name="save" value="Add" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<!-- <input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-sm"/> -->

	</div>



</form>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "add_purge_data";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/AdministrationControllers.php",
		type:"POST",
		data:data_string,
		contentType:false,
		cache:false,
		processData:false,
		success:function(responce) {
			var result = JSON.parse(responce); 
			// alert(responce);
			console.log(responce);
			if(result.status=="success"){
				// alert('success');
				toastr.success(result.message);
				setTimeout(function(){ 
				// window.location.href='dashboard.php?option=add_budget_header';
							$('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("input[type='submit']").val(" Add");  
	        $('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>


