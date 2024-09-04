<?php

//error_reporting(1);

include('connection.php');

extract($_REQUEST);



$id = $_REQUEST['id'];



$que = mysqli_query($con,"select * from allocate_budget where allocate_budget_id ='$id'");

$res = mysqli_fetch_array($que);

$headerid = $res['budget_header_id'];

$amt = $res['allocate_amount'];



$q1 = mysqli_query($con,"select * from budget_header where budget_header_id='$headerid'");

$r1 = mysqli_fetch_array($q1);

$headername = $r1['budget_header_name'];






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

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">Budget Management</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_allocate_budget">View Allocate Budget</a>

  <span class="breadcrumb-item active">Edit Allocate Budget</span>

</nav>

<!-- breadcrumb -->



<div class="card">

<form action="" method="post">

	

	<div class="card-header">

		<strong>Update</strong> Allocate Budget

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:red"><?php echo @$err; ?></label>

	</div>

	

	<div class="card-body card-block">

		<div class="form-group">

		<label for="nf-email" class="form-control-label">Budget Header</label>

		<input type="text" name="header" value="<?php echo $headername;?>" class="form-control" readonly>

		</div>

		

		<div class="form-group">

		<label for="nf-email" class="form-control-label">Allocate Amount</label>

		<input type="text" name="amount" value="<?php echo $amt;?>" placeholder="Enter Amount" class="form-control" required>
		<input type="hidden" name="id" value="<?=$_GET['id']?>">
		</div>

	</div>

	

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_allocate_budget" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>

	</form>

</div>
 <?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "update_allocate_budget";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

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
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_allocate_budget';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("button[type='submit']").html("<i class='fa fa-edit'></i> Update");  
	        $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
