<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$que = mysqli_query($con,"select * from issue_order order by ioid desc limit 1");

$row = mysqli_num_rows($que);

if($row)

{

	$r2 = mysqli_fetch_array($que);

	$iid = $r2['ioid'];

	$niid = preg_split('#(?=\d)(?<=[a-z])#i', "$iid");

	$nioid = $niid[1]; 

	$iid++;

	$newioid = $iid++;

}

else

{

	$newioid  = "Issued1";

}



/*if(isset($save))

{

	

	$img = $_FILES['file']['name'];

	

	if($img=="")

	{

	$q1 = mysqli_query($con,"insert into issue_order (issue_ord_id,ioid,issued_date,issued_department,issued_to_id,stock_type_id,pur_ord_id,Identification_no,quantity,description,item_incharge,stock_vendor_id,issued_by) values('0','$ioid','$issueddate','$issueddept','$issuedto','$stockid','$purordr','$identno','$qty','$description','$incharge','$venid','$issuedby')");

	

	if(mysqli_error($con)){

	echo("Error description: " . mysqli_error($con));

	}

	

	}

	else

	{

	$q1 = mysqli_query($con,"insert into issue_order (issue_ord_id,ioid,issued_date,issued_department,issued_to_id,stock_type_id,pur_ord_id,Identification_no,quantity,amount,description,item_incharge,stock_vendor_id,issued_by,image) values('0','$ioid','$issueddate','$issueddept','$issuedto','$stockid','$purordr','$identno','$qty','$amount','$description',

	'$incharge','$venid','$issuedby','$img')");

	move_uploaded_file($_FILES['file']['tmp_name'],"gallery/issuedorder/".$_FILES['file']['name']);

	}

	

	echo "<script>window.loaction='dashboard.php?option=stock_available'</script>";

	

}*/

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

  <span class="breadcrumb-item active"> Issue Order</span>

</nav>





<form method="post" enctype="multipart/form-data"> 



	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Issue Order Id : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-30px">

		<input type="text" name="ioid" value="<?php echo $newioid;?>" class="form-control" style="width:90px;" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:-20px">Stock Type : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-50px">

		<select style="width:175px;" name="stockid" class="form-control" onchange="showpur(this.value)" required autofocus>

		<option value="" selected="selected" disabled>Select Stock Type</option>

		<?php

		$qst = mysqli_query($con,"select * from stock_type");

		while( $rst = mysqli_fetch_array($qst) ) {

		?>

		<option <?php if($stockid==$rst['stock_type_id']){echo "selected";}?> value="<?php echo $rst['stock_type_id']; ?>"><?php echo $rst['stock_type_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Select Purchase Order : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-30px;">

		<select style="width:175px;" name="purordr" id="purordr" onchange="show_stock(this.value)" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Purchase</option>

		<?php

		$qpr = mysqli_query($con,"select * from purchase_order");

		while( $rpr = mysqli_fetch_array($qpr)) {

		?>

		<option <?php if($purordr==$rpr['pur_ord_id']){echo "selected";}?> value="<?php echo $rpr['pur_ord_id']; ?>"><?php echo $rpr['poid']; ?>

		</option>

		<?php } ?>	

		</select>

		</div>

	</div>

<br><br>



	<script>

		function showpur(str) 

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_ajax_pur.php?stock_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("purordr").innerHTML=xmlhttp.responseText;

		}

		} 

		}

		

		

		function show_stock(str) 

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_ajax_stock.php?pur_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{
				$('#Quantity').val('');

		document.getElementById("showstock").innerHTML=xmlhttp.responseText;

		}

		} 

		}

	</script>	





<div class="container" style="background-color:#ffffff;padding-left:10px;padding-right:10px;">

	<div class="row">

	<div class="col-md-4" style="font-weight:bold">Stock Detail</div>

	</div>

	<br>

	

	<div class="row">

	<div class="col-md-12">

	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">

	<thead>

		<tr>

			 <th>Sr. No</th>

   			 <th>Purchased Date</th>

   			 <th>Stock Type</th>

   			 <th>Quantity</th>

   			 <th>Issued Quantity</th>

   			 <th>Available Quantity</th>

   			 <th>Vendor Name</th>

		</tr>

	</thead>

	

	<tbody id="showstock">



	</tbody>

	</table>

	

	</div>

	

	</div>

</div>

<br>





	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Issued Date : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="date" name="issueddate" class="form-control" style="width:175px;" required autofocus>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Issued Department : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<select style="width:175px;" name="issueddept" onchange="show_issuedto(this.value)" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select Department</option>

		<option value="department">Department</option>

		<option value="individual">Individual</option>

		</select>

		</div>

	</div>

	

	<script>

	function show_issuedto(str)

	{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","view_issuedto.php?issueddept="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("issuedto").innerHTML=xmlhttp.responseText;

		}

		} 

	}

	</script>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2" style="margin-top:-10px;">Issued To: </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<select style="width:175px;" name="issuedto" id="issuedto" class="form-control" required autofocus>

		<option value="" selected="selected" disabled>Select</option>						

		</select>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Identification Number : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" name="identno" class="form-control" style="width:175px;" required autofocus>

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2" style="margin-top:-10px;">Quantity : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="qty"  id="Quantity" class="form-control" style="width:175px;" required autofocus>
<!-- onkeyup="check_qty(this.value)"  -->
		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:100px;" required autofocus></textarea>

	</div>

	</div>



	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Item In-Charge : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="incharge" class="form-control" style="width:200px;height:80px;" required autofocus></textarea>

	</div>

	<div class="col-md-2" style="margin-left:80px;margin-top:-10px;">Issued By : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<input type="text" name="issuedby" class="form-control" style="width:175px;" required autofocus>

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

	<input onclick="return confirm('Do you want to Issue Order.')" type="submit" name="save" value="Issue Order" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>



</form>
<script>
// function check_qty(qty){
// 	$(document).on('keyup','#Quantity',function(){
// 		var qty1=$('#Quantity').val();
// 	// var avi_qty=$('#avilable_qty').val();
// 	var avi_qty=document.getElementById('avilable_qty').value;
// 	// alert(avi_qty);

// 	if(qty1 > avi_qty){
// 		$('#Quantity').val('');
// 		alert('Can,t enter max quantity from Available Quantity ');
		
// 	}
// });
</script>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "issue_order";
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
				window.location.href='dashboard.php?option=issue_order';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('input[type="submit"]').val('Issue Order ');  
	      $('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
