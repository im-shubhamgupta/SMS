<?php

	//error_reporting(1);



	

?>



<div class="card">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Library Management</a>

  <a class="breadcrumb-item" href="#">Configuration</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_book_type">View Book Type</a>

  <span class="breadcrumb-item active">Add Book Type</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Add</strong> Book Type

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Book Type</label>

			<input type="text" name="book" placeholder="Enter Book Type" class="form-control" required></div>

			

		

	</div>

	<div class="card-footer">

		<button onclick="return confirm('Do you want to save?')" type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Add

		</button>

		

		<a href="dashboard.php?option=view_book_type" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

</form>

</div>
<?php include('datatable_links.php')?>
<script>

	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "add_book_type";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/LibraryControllers.php",
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
				// window.location.href='dashboard.php?option=add_class&smid=1';
							$('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-plus"></i> Add ');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>