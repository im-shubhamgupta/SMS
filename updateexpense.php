<?php

error_reporting(1);

extract($_REQUEST);

$eid=$_REQUEST['eid'];

// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";




$que = mysqli_query($con, "SELECT * FROM expense where expense_id='$eid'");

$result = mysqli_fetch_array($que);

$exptid=$result['expense_type_id'];

$oldproof=$result['proofs'];



$expdt = $result['expensed_datetime'];



?>	

	

<div class="card">

<form action="" method="post" enctype="multipart/form-data">

	<div class="card-header">

		<strong>Update</strong> Expense

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block" style="height:800px;">

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Receipt Number</label>

			<input type="text" name="eid" value="<?php echo $eid;?>" readonly class="form-control">

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Expense Type</label>

			<select name="expensetype" class="form-control" required> 

				<?php

				$sql = "SELECT * FROM expense_type";

				$resultset = mysqli_query($con, $sql);

				while( $rows  = mysqli_fetch_array($resultset) ) 

				{

					

				?>

				<option <?php if($rows['expense_type_id']==$exptid){echo "selected";}?> value="<?php echo $rows['expense_type_id'];?>"><?php echo $rows['expense_type_name'];?></option>

				<?php } ?>							

			</select>

			</div>

			

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Expense Details</label>

			<input type="text" name="expdetail"  value="<?php echo $result['expense_details']; ?>" class="form-control" placeholder="Enter Expense Details" required>

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

			<!--<input type="datetime" name="issdate" class="form-control" value="<?php echo $chgexdt;?>">

			-->

			<input type="datetime-local" name="issdate" class="form-control" value="<?php echo date('Y-m-d\TH:i:s', strtotime($expdt));?>">

			</div>

									

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Proofs</label>

			<input type="file" name="proofs" class="form-control">

			</div>

			<br>

			<img src="images/proof/<?php echo $oldproof; ?>" height="120px" width="120px" style="border-radius:50%">

	</div>

	<div class="card-footer">

		<button type="submit" name="Update_Expense" id='Update_Expense'  class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update Expense

		</button>

		

		<a href="dashboard.php?option=view_expense" class="btn btn-info btn-sm">

		<i class='fa fa-arrow-left'> Back</i></a>

		

	</div>

	</form>

</div>



<?php

// if (isset($Update_Expense))

// {

// 	$dt=$issdate;

// 	$newdt=date("Y-m-d",strtotime($dt));

// 	$pic=$_FILES['proofs']['name'];

	

// 	$qe = mysqli_query($con,"select * from expense_type where expense_type_id ='$expensetype'");

// 	$re = mysqli_fetch_array($qe);

// 	$expname = $re['expense_type_name'];

		

// 	if ($pic=="")

// 	{

// 		$qe = mysqli_query($con,"select * from expense_type where expense_type_id ='$expensetype'");

// 		$re = mysqli_fetch_array($qe);

// 		$expname = $re['expense_type_name'];

			

// 		$que1="update expense set expense_type_id='$expensetype', expense_details='$expdetail',

// 		amount='$amount',point_of_contact='$poc',expensed_datetime='$issdate',date='$newdt' 

// 		where expense_id='$eid'";

// 		if(mysqli_query($con,$que1))

// 		{

// 			$action = "Expense for ".$expname." is edited"; 

// 			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

// 			machine_name,browser,date) 

// 			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

// 		}

// 		echo "<script>window.location='dashboard.php?option=view_expense'</script>";

// 	}

// 	else

// 	{

// 		$que1="update expense set expense_type_id='$expensetype', expense_details='$expdetail',

// 		amount='$amount',proofs='$pic',point_of_contact='$poc',expensed_datetime='$issdate',

// 		date='$newdt' where expense_id='$eid'";

// 		unlink ("images/proof/$oldproof");

// 		if(mysqli_query($con,$que1))

// 		{

// 			$action = "Expense for ".$expname." is edited"; 

// 			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

// 			machine_name,browser,date) 

// 			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

// 		}

// 		move_uploaded_file($_FILES['proofs']['tmp_name'],"images/proof/".$_FILES['proofs']['name']);

// 		echo "<script>window.location='dashboard.php?option=view_expense'</script>";

		

// 	}

	

// }

include('bootstrap_datatable_javascript_library.php'); 

?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
</script>



	<script >
			"use: strict";
	    $(function () {

	        $('#datepicker').datepicker({

	            format: "dd/mm/yyyy",

	            autoclose: true,

	            todayHighlight: true,

		        showOtherMonths: true,

		        selectOtherMonths: true,

		        autoclose: true,

		        changeMonth: true,

		        changeYear: true,

		        orientation: "button"

	        });

	    });

		

	</script>
	<script>
	
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
	// alert(123);
  var action = $("#Update_Expense").attr("name");

	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("#Update_Expense").text("Updating, please wait...");  
	$("#Update_Expense").attr("disabled", true);

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
				$("#Update_Expense").text("Update Expense");  
	      $("#Update_Expense").attr("disabled", false);

			}else if(result.type=="MAX_STU"){
				toastr.error(result.message); 
				$("#Update_Expense").text("Update Expense");  
	      $("#Update_Expense").attr("disabled", false);

			}else if(result.type=="ERROR"){
				toastr.error(result.message); 
				$("#Update_Expense").text("Update Expense");  
	      $("#Update_Expense").attr("disabled", false);

			}else if(result.type=="ALREADY"){
				toastr.error(result.message);
				$("#Update_Expense").text("Update Expense");  
	      $("#Update_Expense").attr("disabled", false);
			}
		}
	})
});
});
</script>