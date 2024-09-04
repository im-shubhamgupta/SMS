<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$que = mysqli_query($con,"select * from return_stock order by roid desc limit 1");

$row = mysqli_num_rows($que);

if($row)

{

	$r2 = mysqli_fetch_array($que);

	$rid = $r2['roid'];

	$nrid = preg_split('#(?=\d)(?<=[a-z])#i', "$rid");

	$nroid = $nrid[1]; 

	$rid++;

	$newroid = $rid++;

}

else

{

	$newroid  = "Return1";

}


/*
if(isset($save))

{

	

	$q1 = mysqli_query($con,"insert into return_stock (roid,issue_ord_id,pur_ord_id,stock_type_id,vendor_id,return_qty,identification_no,returned_date,

	returned_by,returned_to,description) 

	values('$returnid','$issid','$purchaseid','$stockid','$vendorid','$returnqty','$identno','$returndt','$returnedby','$returnedto','$description')");

	if(mysqli_error($con)){

	echo("Error description: " . mysqli_error($con));

	}
*/
	

	// if($q1)

	// {

		// $q2 = mysqli_query($con,"select * from issue_order where issue_ord_id='$issid'");

		// $r2 = mysqli_fetch_array($q2);

		// $oldqty = $r2['quantity'];

		// $newqty = $oldqty - $returnqty;

		// $q2 = mysqli_query($con,"update issue_order set quantity='$newqty' where issue_ord_id='$issid'");

	// }

	

	//echo "<script>window.loaction='dashboard.php?option=return_stock'</script>";

/*}
*/
?>



<style>



input[type=checkbox] {

    zoom: 1.8;

	margin-top:5px;

}

</style>



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#"> Stock Management</a>

  <span class="breadcrumb-item active"> Return Order</span>

</nav>





<form method="post" enctype="multipart/form-data"> 



	<div class="row" style="margin-top:50px;margin-left:50px;">

		<div class="col-md-2">Return ID: </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="returnid" value="<?php echo $newroid;?>" class="form-control" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:40px;">Select Issue Order: </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:175px;" name="issid" class="form-control" onchange="showissue(this.value)" required autofocus>

		<option value="" selected="selected" disabled>Select Issued ID</option>

		<?php

		$qst = mysqli_query($con,"select * from issue_order");

		while( $rst = mysqli_fetch_array($qst) ) {

		?>

		<option <?php if($issid==$rst['issue_ord_id']){echo "selected";}?> value="<?php echo $rst['issue_ord_id']; ?>"><?php echo $rst['ioid']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

	

	</div>

<br><br>



	<script>

		function showissue(str) 

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_ajax_issueorder.php?issued_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4){

		// document.getElementsByClassName("return_qty").value='';
		$('#returnqty').val('');
		document.getElementById("showissue").innerHTML=xmlhttp.responseText;

		}

		} 

		}

	</script>	





<div class="container" style="background-color:#ffffff;padding-left:10px;padding-right:10px;">

	<div class="row">

	<div class="col-md-4" style="font-weight:bold">Issued Order Detail</div>

	</div>

	<br>

	

	<div class="row">

	<div class="col-md-12">

	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">

	<thead>

		<tr>

			 <th>Sr. No</th>

   			 <th>Issued Date</th>

   			 <th>Stock Type</th>

   			 <th>Vendor</th>

   			 <th>Issued Quantity</th>

   			 <th>Identification No</th>

   			 <th>Purchased Order</th>

		</tr>

	</thead>

	

	<tbody id="showissue">



	</tbody>

	</table>

	

	</div>

	

	</div>

</div>

<br>





	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Returning Quantity : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="returnqty"  id="returnqty"  class="form-control return_qty" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Identification Number : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="identno" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Returned Date : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="date" name="returndt" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Returned By : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="returnedby" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Returned To : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="returnedto" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:100px;" required autofocus></textarea>

	</div>

	</div>		

	<br><br>

	

	<div>

	<input onclick="return confirm('Do you want to Return Order.')" type="submit" name="save" value="Return Stock" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>



</form>
<script>
	// $('#returnqty').on('keyup',function(){

	// 	var iss_qty=$('#issue_qty').val();

	// 	// var iss_qty=document.getElementByid('issue_qty').value;
	// 	// var ret_qty=document.getElementByid('returnqty').value;
	// 	var ret_qty=$('#returnqty').val();
	// 		// console.log(iss_qty);
	// 	// alert(ret_qty);
	// 		// console.log('');
	// 		// console.log(res_qty);
	// 	if(ret_qty > iss_qty){

	// 		$('#returnqty').val('');
	// 	alert('Can,t accept max quantity from Issued Quantity ');
	// 	}


	// });
	</script>
<?php include('datatable_links.php');?>


<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "return_stock";
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
				window.location.href='dashboard.php?option=return_stock';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('input[type="submit"]').val('Return Stock ');  
	      $('#add').attr("disabled",false);
		}
	})
});

});

</script>

