<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$que = mysqli_query($con,"select * from dead_stock order by dsid desc limit 1");

$row = mysqli_num_rows($que);

if($row)

{

	$r2 = mysqli_fetch_array($que);

	$did = $r2['dsid'];

	$ndid = preg_split('#(?=\d)(?<=[a-z])#i', "$did");

	$ndsid = $ndid[1]; 

	$did++;

	$newdsid = $did++;

}

else

{

	$newdsid  = "Deadstock1";

}




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

  <span class="breadcrumb-item active"> Dead Stock</span>

</nav>





<form method="post" enctype="multipart/form-data"> 



	<div class="row" style="margin-top:50px;margin-left:50px;">

		<div class="col-md-2">Dead Stock ID: </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="deadstockid" value="<?php echo $newdsid;?>" class="form-control" readonly>

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

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

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

		<div class="col-md-2" style="margin-top:-8px;">Dead Stock Quantity : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="number" name="deadqty" class="form-control" style="width:175px;" required autofocus>

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

	<input type="submit" name="save" value="Submit" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-info btn-sm"/>

	</div>
</form>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "dead_stock";
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
				window.location.href='dashboard.php?option=dead_stock';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("input[type='submit']").val("Submit");  
	$('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>

