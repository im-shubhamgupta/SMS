 <?php

	//error_reporting(1);

	include('connection.php');

	extract($_REQUEST);

	$eid=$_REQUEST['eid'];

	$sql=mysqli_query($con,"select * from stock_type where stock_type_id='$eid'");

	$res=mysqli_fetch_array($sql);

	$stockname=$res['stock_type_name'];

	

?> 

<div class="card">

<form action="" method="post">

	<div class="card-header">

		<strong>Update</strong> Stock Type

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Enter Stock Name</label>

			<input type="text" name="stock" placeholder="Enter Expense Name" class="form-control" value="<?php echo $stockname ?>" required></div>
			<input type="hidden" name="eid" value="<?=$_GET['eid']?>">
			

		

	</div>

	<div class="card-footer">

		<button type="submit" name="update" class="btn btn-secondary btn-sm">

			<i class='fa fa-edit'></i> Update

		</button>

		

		<a href="dashboard.php?option=view_stock_type" class="btn btn-info btn-sm"> 

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
  var action = "update_stock_type";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

	$.ajax({
		url:"Controllers/StockControllers.php",
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
				window.location.href='dashboard.php?option=view_stock_type';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-edit"></i> Update ');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>