<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$id = $_REQUEST['id'];



$que = mysqli_query($con,"select * from purchase_order where pur_ord_id='$id'");

$res = mysqli_fetch_array($que);

$create_date = $res['pur_ord_created'];

$stock_id = $res['stock_type_id'];

$vendor_id = $res['stock_vendor_id'];

$oldimg = $res['image'];







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

  <a class="breadcrumb-item" href="#"> Stock Report</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_purchase_order"> View Purchase Order</a>

  <span class="breadcrumb-item active"> Update Purchase Order</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Purchasr Order Id : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="poid" value="<?php echo $res['poid'];?>" class="form-control" style="width:175px;" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;margin-top:-10px">Purchase Order Created : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="pur_ord_crt" value="<?php echo $res['pur_ord_created'];?>" class="form-control" style="width:175px;" readonly>

		</div>

	</div>



	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Stock Type : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:175px;" name="nstockid" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Stock Type</option>

		<?php

		$scls = mysqli_query($con,"select * from stock_type");

		while( $rcls = mysqli_fetch_array($scls) ) {

		?>

		<option <?php if($stock_id==$rcls['stock_type_id']){echo "selected";}?> value="<?php echo $rcls['stock_type_id']; ?>"><?php echo $rcls['stock_type_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Purchased Date : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="date" name="npurdt" value="<?php echo $res['purchase_date']; ?>" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2" style="margin-top:-10px;">Identification Number : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="nidentno" value="<?php echo $res['identification_no']; ?>" class="form-control" style="width:175px;" required autofocus>

		</div>



		<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Quantity : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="number" name="nqty" id="qty" value="<?php echo $res['quantity'];?>" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2" style="margin-top:-10px;">Amount Per Item : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="namt_item" id="amt_item" value="<?php echo $res['amt_per_item'];?>" class="form-control" style="width:120px;" required autofocus>

		</div>



		<div class="col-md-2" style="margin-top:-10px;">Discount Per Item : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="ndisc_item" id="disc_item" value="<?php echo $res['disc_per_item'];?>" class="form-control" style="width:120px;" required autofocus>

		</div>

		

		<div class="col-md-2">Total Amount : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="namount" id="amount" value="<?php echo $res['amount'];?>" class="form-control" style="width:120px;margin-left:-30px" readonly required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="ndescription" class="form-control" style="width:580px;height:120px;" required autofocus><?php echo $res['description']; ?></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Vendor Name & Address : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<select style="width:250px;" name="nvendor" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Vendor</option>

		<?php

		$qvn = mysqli_query($con,"select * from stock_vendor");

		while( $rvn = mysqli_fetch_array($qvn) ) {

		?>

		<option <?php if($vendor_id ==$rvn['stock_vendor_id']){echo "selected";}?> value="<?php echo $rvn['stock_vendor_id']; ?>"><?php echo $rvn['stock_vendor_name']; ?>

		</option>

		<?php } ?>							

		</select>

	</div>

	</div>



	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Attachment : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<img src="gallery/purchaseorder/<?php echo $res['image'];?>" width="90px" height="90px" style="border:1px solid grey"/>

	</div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="file" name="file1" class="form-control" style="width:250px;">
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<input type="hidden" name="oldimg" value="<?=$oldimg?>">

	</div>

	</div>

		

	<br><br>

	

	<div>

	<input onclick="return confirm('Do you want to Update.')" type="submit" name="update" value="Update" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>



</form>

<script>

$("#disc_item").blur(function()

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
  var action = "update_purchase_order";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
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
			$('input[type="submit"]').val(' Update ');  
	      $('inupt[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>