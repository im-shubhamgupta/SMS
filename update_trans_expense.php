<?php

error_reporting(1);

extract($_REQUEST);

$eid=$_REQUEST['eid'];



$que = mysqli_query($con, "SELECT * FROM transport_expense where trans_expense_id='$eid'");

$result = mysqli_fetch_array($que);

$exptid=$result['trans_expense_type_id'];

$oldproof=$result['proofs'];



$expdt = $result['expensed_datetime'];



?>	

	

<div class="card">

<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Update</strong> Transport Expense

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:800px;">

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Receipt Number</label>

			<input type="text" name="expdetail" value="<?php echo $eid;?>" readonly class="form-control">

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Expense Type</label>

			<select name="expensetype" class="form-control" required> 

				<?php

				$sql = "SELECT * FROM transport_expense_type where session='".$_SESSION['session']."'";

				$resultset = mysqli_query($con, $sql);

				while( $rows  = mysqli_fetch_array($resultset) ) 

				{

					

				?>

				<option <?php if($rows['trans_expense_type_id']==$exptid){echo "selected";}?> value="<?php echo $rows['trans_expense_type_id'];?>"><?php echo $rows['trans_expense_type_name'];?></option>

				<?php } ?>							

			</select>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Details</label>

			<input type="text" name="expdetail"  value="<?php echo $result['trans_expense_details']; ?>" class="form-control" placeholder="Enter Expense Details" required>

			</div>

			

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Amount</label>

			<input type="number" name="amount"  value="<?php echo $result['amount']; ?>" class="form-control" placeholder="Enter Amount" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Point of Contact</label>

			<input type="text" name="poc"  value="<?php echo $result['point_of_contact']; ?>" class="form-control" placeholder="Enter Point of Contact" required>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Expensed Datetime</label>

			<input type="datetime-local" name="issdate" class="form-control" value="<?php echo date('Y-m-d\TH:i:s', strtotime($expdt));?>">

			</div>

									

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Proofs</label>

			<input type="file" name="proofs" class="form-control">
			<input type="hidden" name="oldproof" value="<?=$oldproof?>">
			<input type="hidden" name="eid" value="<?=$_GET['eid']?>">

			</div>

			<br>

			<img src="images/transport/<?php echo $oldproof; ?>" height="120px" width="120px" style="border-radius:50%">

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update Expense

		</button>

		

		<a href="dashboard.php?option=view_transport_expense" class="btn btn-info btn-sm">

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
	// alert(12);
	// console.log(this);
  var action ="Update_Transport_Expense";
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
			if(result.type=="success"){
				// alert('success');
				toastr.success(result.msg); 
				setInterval(function(){ 
				window.location.href='dashboard.php?option=view_transport_expense';
					// $('form')[0].reset();
					// document.getElementById("assign_driver").reset();
				},3000);
			}
		
			else if(result.type=="error"){
				toastr.error(result.msg); 
			}
			  $("button[type='submit']").html('<i class="fa fa-plus"></i> Update Expense');  
	      $("button[type='submit']").attr("disabled", false);
		}
	})
});

});

</script>



<?php
/*
if (isset($update))

{

	$dt=$issdate;

	$newdt=date("Y-m-d",strtotime($dt));

	$pic=$_FILES['proofs']['name'];

	

	$qe = mysqli_query($con,"select * from transport_expense_type where trans_expense_type_id ='$expensetype'");

	$re = mysqli_fetch_array($qe);

	$expname = $re['trans_expense_type_name'];

		

	if ($pic=="")

	{

	

		$que1=mysqli_query($con,"update transport_expense set trans_expense_type_id='$expensetype', trans_expense_details='$expdetail',

		amount='$amount',point_of_contact='$poc',expensed_datetime='$issdate',date='$newdt' 

		where trans_expense_id='$eid'");

		

		echo "<script>window.location='dashboard.php?option=view_transport_expense'</script>";

	}

	else

	{

		$que1=mysqli_query($con,"update transport_expense set trans_expense_type_id='$expensetype', trans_expense_details='$expdetail',

		amount='$amount',proofs='$pic',point_of_contact='$poc',expensed_datetime='$issdate',

		date='$newdt' where trans_expense_id='$eid'");

		unlink ("images/transport/$oldproof");

		

		move_uploaded_file($_FILES['proofs']['tmp_name'],"images/transport/".$_FILES['proofs']['name']);

		echo "<script>window.location='dashboard.php?option=view_transport_expense'</script>";

		

	}

	

}

include('bootstrap_datatable_javascript_library.php'); 
*/
?>

