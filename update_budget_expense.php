<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$que = mysqli_query($con,"select * from allocate_budget_expense where id='$id'");

$res = mysqli_fetch_array($que);

$hid = $res['budget_header_id'];



$q1 = mysqli_query($con,"select * from budget_header where budget_header_id ='$hid'");

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

  <a class="breadcrumb-item" href="dashboard.php?option=view_allocated_budget_expense">View Allocated Budget Expense</a>

  <span class="breadcrumb-item active">Update Budget Expense</span>

</nav>

<!-- breadcrumb -->



<div class="card">

<form method="post" enctype="multipart/form-data"> 



	<div class="card-header">

		<strong>Update</strong> Budget Expense

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:red"><?php echo @$err; ?></label>

	</div>

	

	<div class="card-body card-block">



	<div class="row" style="margin-top:20px;margin-left:20px;">

		<div class="col-md-2">Expense ID : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="expid" value="<?php echo $res['expense_id'];?>" class="form-control" style="width:175px;" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Allocated To : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="hid" value="<?php echo $headername;?>" class="form-control" style="width:175px;" readonly>

		</div>

	</div>

	

		<script>

		function allocatedamt(str) 

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_allocated_amt.php?header_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("allocated_amt").value=xmlhttp.responseText;

		}

		} 

		}

		

		function availableamt(str) 

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_available_amt.php?header_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("available_amt").value=xmlhttp.responseText;

		}

		} 

		}

		</script>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Allocated Amount : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" style="width:175px;" name="allocated_amt" value="<?php echo $res['allocated_amount'];?>" id="allocated_amt" class="form-control" readonly>							

		</div>



		<div class="col-md-2" style="margin-left:80px;">Available Amount : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">
<!-- available_amount -->
		<input type="text" style="width:175px;" name="available_amt" id="available_amt" value="<?php echo $res['available_amount'];?>" class="form-control" readonly>							

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Expensed Amount : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" style="width:175px;" name="expensed_amt" id="expensed_amt" value="<?php echo $res['expensed_amount'];?>" class="form-control" autofocus required>							

	</div>



	<div class="col-md-2" style="margin-left:80px;">Expensed Date : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<input type="date" style="width:175px;" name="exp_dt" value="<?php echo $res['expense_date'];?>" class="form-control" autofocus required>							

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:180px;" required autofocus><?php echo $res['description'];?></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Attachment : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<img src="gallery/budgetexp/<?php echo $res['attachment']; ?>" width="80px" height="80px" alt="no image"/>

	</div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="file" name="file" class="form-control" style="width:250px;">
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<input type="hidden" name="hid" value="<?=$hid?>">
	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Amount Remaining: </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" style="width:175px;" name="remaining_amt" id="remaining_amt" value="<?php echo $res['amount_remaining'];?>" class="form-control" readonly>							

	</div>

	</div>

	<br><br>

	

	</div>

	

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_allocated_budget_expense" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>



</form>

</div>



<script>

$("#expensed_amt").keyup(function()

{

	var expamt = $(this).val();

	var availamt = $("#available_amt").val();

	

	if(parseInt(expamt) > parseInt(availamt))

	{

		alert("Expensed amount is not more than available amount.");

		$(this).val("");

		$(this).focus();

	}

	else

	{

	//var expamt = $("#expensed_amt").val();

	var balamt = availamt - expamt;

	$("#remaining_amt").val(balamt);

	}

});

</script>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "update_budget_expense";
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
				window.location.href='dashboard.php?option=view_allocated_budget_expense';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("button[type='submit']").html(" <i class='fa fa-edit'></i> Update");  
	        $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
