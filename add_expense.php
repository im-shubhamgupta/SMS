<?php 

include('connection.php');

// extract($_REQUEST);

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));



	//generate expense no

	$q2 = mysqli_query($con,"select expense_id from expense order by expense_id desc limit 1");

	$r2 = mysqli_fetch_array($q2);

	$row2 = mysqli_num_rows($q2);	

	if($row2 > 0)

	{

		$rno = $r2['expense_id'] + 1;

		$expno = str_pad($rno, 4 , "0", STR_PAD_LEFT);

	}

	else

	{

		$expno = "0001";

	}

?> 

<div class="card">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Accounts Panel</a>

  <a class="breadcrumb-item" href="#">Expense</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_expense">View Expense</a>

  <span class="breadcrumb-item active">Add  Expense</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Add</strong> Expense

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Receipt Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="expdetail" value="<?php echo $expno;?>" readonly class="form-control" placeholder="Enter Expense Details">

				<input type="hidden" name="roles" value="<?php echo $roles;?>" >
			<input type="hidden" name="panelid" value="<?php echo $panelid;?>" >
			<input type="hidden" name="menuid" value="<?php echo $menuid;?>" >
			<input type="hidden" name="submenuname" value="<?php echo $submenuname;?>" >
			<input type="hidden" name="machinename" value="<?php echo $machinename;?>" >
			<input type="hidden" name="ExactBrowserNameBR" value="<?php echo $ExactBrowserNameBR;?>" >
			<input type="hidden" name="currdt" value="<?php echo $currdt;?>" >

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Expense Type <span style="color:red;font-weight:bold;">*</span></label>

			<select name="expensetype" class="form-control" required> 

			<option value="" selected disabled>---Select Expense Type---</option>

				<?php

				$sql = "SELECT * FROM expense_type";

				$res1 = mysqli_query($con, $sql);

				while( $rows = mysqli_fetch_array($res1) ) {

				?>

				<option value="<?php echo $rows['expense_type_id']; ?>">

				<?php echo $rows['expense_type_name']; ?>

				</option>

				<?php } ?>							

			</select>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Details <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="expdetail" class="form-control" placeholder="Enter Expense Details" required>

			</div>

			

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Amount <span style="color:red;font-weight:bold;">*</span></label>

			<input type="number" name="amount" class="form-control" placeholder="Enter Amount" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Proofs</label>

			<input type="file" name="proofs" class="form-control">

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Point of Contact <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="poc" class="form-control" placeholder="Enter Point of Contact" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Date & Time</label>

			

			<input step="1" type="datetime-local" name="issdate" id="myDatetimeField" class="form-control"/>

			

			<!--<input type="datetime" name="issdate" class="form-control" value="<?php echo $date->format('d-M-Y H:i:s A');?>" readonly>

			--></div>

			

			<script>

			window.addEventListener("load", function() {

			var now = new Date();

			var utcString = now.toISOString().substring(0,19);

			var year = now.getFullYear();

			var month = now.getMonth() + 1;

			var day = now.getDate();

			var hour = now.getHours();

			var minute = now.getMinutes();

			var second = now.getSeconds();
// T
			var localDatetime = year + "-" +

							  (month < 10 ? "0" + month.toString() : month) + "-" +

							  (day < 10 ? "0" + day.toString() : day) + " " +

							  (hour < 10 ? "0" + hour.toString() : hour) + ":" +

							  (minute < 10 ? "0" + minute.toString() : minute) +

							  utcString.substring(16,19);

			var datetimeField = document.getElementById("myDatetimeField");

			datetimeField.value = localDatetime;

			

			var datetimeField1 = document.getElementById("myDatetimeField1");

			datetimeField1.value = localDatetime;

			});

			</script>

			

	</div>

	<div class="card-footer">

		<button type="submit" name="Add_Expense" class="btn btn-primary btn-sm" id="Add_Expense">

		<i class="fa fa-plus"></i> Add Expense

		</button>

		

		<a href="dashboard.php?option=view_expense" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	</form>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>

$("#stucontact").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

</script>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = $("#Add_Expense").attr("name");

	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#Add_Expense").text("Sending, please wait...");  
	$("#Add_Expense").attr("disabled", true);

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
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_expense';
				},3000);
			}
			else if(result.type=="ADD_FEE"){
				toastr.error(result.message); 
				$("#Add_Expense").text("Add Expense");  
	      $("#Add_Expense").attr("disabled", false);

			}else if(result.type=="MAX_STU"){
				toastr.error(result.message); 
				$("#Add_Expense").text("Add Expense");  
	      $("#Add_Expense").attr("disabled", false);

			}else if(result.type=="ERROR"){
				toastr.error(result.message); 
				$("#Add_Expense").text("Add Expense");  
	      $("#Add_Expense").attr("disabled", false);

			}else if(result.type=="ALREADY"){
				toastr.error(result.message);
				$("#Add_Expense").text("Add Expense");  
	      $("#Add_Expense").attr("disabled", false);
			}
		}
	})
});
});
</script>