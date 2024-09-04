<?php 

include('connection.php');

extract($_REQUEST);

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));



	// if(isset($add))

	// {		

	// 		$qe = mysqli_query($con,"select * from transport_expense_type where trans_expense_type_id ='$expensetype'");

	// 		$re = mysqli_fetch_array($qe);

	// 		$expname = $re['trans_expense_type_name'];



	// 		$file=$_FILES['proofs']['name'];

			

	// 		if($file=="")

	// 		{

	// 			$query=mysqli_query($con,"insert into transport_expense (trans_expense_type_id,trans_expense_details,amount,proofs,point_of_contact,expensed_datetime,date,status) values('$expensetype','$expdetail',$amount,'','$poc','$issdate',now(),'0')");	

				

	// 			if(mysqli_error($con)){

	// 			echo("Error description: " . mysqli_error($con));

	// 			}

				

	// 			$err="<span id='err_successful'>[ Expense Add Successfully ]</span>";

	// 		}

	// 		else

	// 		{

	// 		$query=mysqli_query($con,"insert into transport_expense (trans_expense_type_id,trans_expense_details,amount,proofs,point_of_contact,expensed_datetime,date,status)

	// 		values('$expensetype','$expdetail',$amount,'$file','$poc','$issdate',now(),'0')");	

			

	// 			move_uploaded_file($_FILES['proofs']['tmp_name'],"images/transport/".$_FILES['proofs']['name']);

	// 			$err="<span id='err_successful'>[ Expense Add Successfully ]</span>";

				

	// 		}

	// }

	

	$q2 = mysqli_query($con,"select trans_expense_id from transport_expense order by trans_expense_id desc limit 1");

	$r2 = mysqli_fetch_array($q2);

	$row2 = mysqli_num_rows($q2);	

	if($row2 > 0)

	{

		$rno = $r2['trans_expense_id'] + 1;

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

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Transport Expense</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_transport_expense">View Transport Expense</a>

  <span class="breadcrumb-item active">Add Transport Expense</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Add</strong> Transport Expense

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Receipt Number <span style="color:red;font-weight:bold;">*</span></label>

			<input type="text" name="expdetail" value="<?php echo $expno;?>" readonly class="form-control" placeholder="Enter Expense Details">

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Expense Type <span style="color:red;font-weight:bold;">*</span></label>

			<select name="expensetype" class="form-control" required> 

			<option value="" selected disabled>---Select Expense Type---</option>

				<?php

				$sql = "SELECT * FROM transport_expense_type where session='".$_SESSION['session']."'";

				$res1 = mysqli_query($con, $sql);

				while( $rows = mysqli_fetch_array($res1) ) {

				?>

				<option value="<?php echo $rows['trans_expense_type_id']; ?>">

				<?php echo $rows['trans_expense_type_name']; ?>

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

			var localDatetime = year + "-" +

							  (month < 10 ? "0" + month.toString() : month) + "-" +

							  (day < 10 ? "0" + day.toString() : day) + "T" +

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

		<button type="submit" name="add" class="btn btn-primary btn-sm">

		<i class="fa fa-plus"></i> Add Expense

		</button>

		

		<a href="dashboard.php?option=view_transport_expense" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>

	</div>

	</form>

</div>



<script>

$("#stucontact").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });

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
  var action ="Add_Transport_Expense";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
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
				window.location.href='dashboard.php?option=add_transport_expense';
					// $('form')[0].reset();
					// document.getElementById("assign_driver").reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("button[type='submit']").html('<i class="fa fa-plus"></i> Add Expense');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>