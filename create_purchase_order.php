<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);
$que = mysqli_query($con,"select * from purchase_order order by poid desc limit 1");

$row = mysqli_num_rows($que);
if($row){

	$r2 = mysqli_fetch_array($que);

	$pid = $r2['poid'];

	$npid = preg_split('#(?=\d)(?<=[a-z])#i', "$pid");

	$npoid = $npid[1]; 

	$pid++;

	$newpoid = $pid++;

}else{

	$newpoid  = "PO1";

}



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

  <a class="breadcrumb-item" href="#"> Stock Management</a>

  <a class="breadcrumb-item" href="#"> Purchase Order</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_purchase_order"> View Purchase Order</a>

  <span class="breadcrumb-item active"> Create Purchase Order</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Purchasr Order Id : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="poid" value="<?php echo $newpoid;?>" class="form-control" style="width:175px;" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;margin-top:-10px">Purchase Order Created : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="datetime" name="pur_ord_crt" value="<?php echo date('Y-m-d h:i')?>" class="form-control" style="width:175px;" readonly>

		</div>

	</div>



	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Stock Type : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:175px;" name="stockid" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Stock Type</option>

		<?php

		$scls = mysqli_query($con,"select * from stock_type");

		while( $rcls = mysqli_fetch_array($scls) ) {

		?>

		<option value="<?php echo $rcls['stock_type_id']; ?>"><?php echo $rcls['stock_type_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Purchased Date : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="date" name="purdt" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2" style="margin-top:-10px;">Identification Number : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="identno" class="form-control" style="width:175px;" required autofocus>

		</div>



		<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Quantity : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="number" name="qty" id="qty" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2" style="margin-top:-10px;">Amount Per Item : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="amt_item" id="amt_item" class="form-control" style="width:120px;" required autofocus>

		</div>



		<div class="col-md-2" style="margin-top:-10px;">Discount Per Item : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="disc_item" id="disc_item" class="form-control" style="width:120px;" required autofocus>

		</div>

		

		<div class="col-md-2">Total Amount : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="amount" id="amount" class="form-control" style="width:120px;margin-left:-30px" readonly required autofocus>

		</div>

	</div>

		

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:120px;" required autofocus></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Vendor Name & Address : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:250px;" name="vendor" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Vendor</option>

		<?php

		$qvn = mysqli_query($con,"select * from stock_vendor");

		while( $rvn = mysqli_fetch_array($qvn) ) {

		?>

		<option value="<?php echo $rvn['stock_vendor_id']; ?>"><?php echo $rvn['stock_vendor_name']; ?>

		</option>

		<?php } ?>							

		</select>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Attachment : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="file" name="file" class="form-control" style="width:250px;">

	</div>

	</div>

		

	<br><br>

	

	<div>

	<input onclick="return confirm('Do you want to save.')" type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>



</form>



<script>
	
$("#amt_item").keyup(function()

{

	var qty = $("#qty").val();

	var amt = $("#amt_item").val();

	var disc = $("#disc_item").val();

	var tamt = (amt * qty) - (disc * qty);

	$("#amount").val(tamt);

});


$("#disc_item").keyup(function()

{

	var qty = $("#qty").val();

	var amt = $("#amt_item").val();

	var disc = $("#disc_item").val();

	var tamt = (amt * qty) - (disc * qty);

	$("#amount").val(tamt);

});

</script>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "create_purchase_order";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	// $("button[type='submit']").html("please wait...");  
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

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
				window.location.href='dashboard.php?option=view_purchase_order';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('input[type="submit"]').val(' Add ');  
	      $('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>