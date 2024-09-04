<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



$que = mysqli_query($con,"select * from allocate_budget_expense order by expense_id desc limit 1");

$row = mysqli_num_rows($que);

if($row)

{

	$r2 = mysqli_fetch_array($que);
	// echo "<pre>";
	// print_r($r2);
	// 	echo "</pre>";

	$iid = $r2['expense_id'];

	//$niid = preg_split('#(?=\d)(?<=[a-z])#i', "$iid");

	//$nioid = $niid[1]; 

	 $iid++;

	 $newioid = $iid++;

}

else

{

	$newioid  = "BE_01";

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

  <a class="breadcrumb-item" href="#">Administration Panel</a>

  <a class="breadcrumb-item" href="#">Budget Management</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_allocated_budget_expense">View Allocated Budget Expense</a>

  <span class="breadcrumb-item active">Add Budget Expense</span>

</nav>

<!-- breadcrumb -->



<form method="post" enctype="multipart/form-data"> 

	<div class="row" style="margin-top:50px;margin-left:20px;">

		<div class="col-md-2">Expense ID : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" name="expid" value="<?php echo $newioid;?>" class="form-control" style="width:175px;" readonly>

		</div>

		

		<div class="col-md-2" style="margin-left:80px;">Allocated To : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<select style="width:175px;" name="allocateto" class="form-control" onchange="allocatedamt(this.value), availableamt(this.value)" required autofocus>

		<option value="" selected="selected" disabled>Select Header</option>

		<?php

		$qh = mysqli_query($con,"select * from budget_header");

		while( $rh = mysqli_fetch_array($qh) ) {

		?>

		<option value="<?php echo $rh['budget_header_id']; ?>"><?php echo $rh['budget_header_name']; ?>

		</option>

		<?php } ?>							

		</select>

		</div>

	</div>

	

		<script>

		function allocatedamt(str) 

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_allocated_amt.php?header_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("allocated_amt").value=xmlhttp.responseText;

		}

		} 

		}

		

		function availableamt(str) 

		{

		var xmlhttp= new XMLHttpRequest();	

		xmlhttp.open("get","search_available_amt.php?header_id="+str,true);

		xmlhttp.send();

		xmlhttp.onreadystatechange=function()

		{

		if(xmlhttp.status==200  && xmlhttp.readyState==4)

		{

		document.getElementById("available_amt").value=xmlhttp.responseText;

		}

		} 

		}

		</script>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

		<div class="col-md-2">Allocated Amount : </div>

		<div class="col-md-2" style="margin-top:-8px;">

		<input type="text" style="width:175px;" name="allocated_amt" id="allocated_amt" class="form-control" readonly>							

		</div>



		<div class="col-md-2" style="margin-left:80px;">Available Amount : </div>

		<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

		<input type="text" style="width:175px;" name="available_amt" id="available_amt" class="form-control" readonly>							

		</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2">Expensed Amount : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" style="width:175px;" name="expensed_amt" id="expensed_amt" class="form-control" autofocus required>							

	</div>



	<div class="col-md-2" style="margin-left:80px;">Expensed Date : </div>

	<div class="col-md-2" style="margin-top:-8px;margin-left:-20px;">

	<input type="date" style="width:175px;" name="exp_dt" class="form-control" autofocus required>							

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Description : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<textarea name="description" class="form-control" style="width:580px;height:180px;" required autofocus></textarea>

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Attachment : </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="file" name="file" class="form-control" style="width:250px;">

	</div>

	</div>

	

	<div class="row" style="margin-left:20px;margin-top:50px;">

	<div class="col-md-2" style="font-size:16px;">Amount Remaining: </div>

	<div class="col-md-2" style="margin-top:-8px;">

	<input type="number" style="width:175px;" name="remaining_amt" id="remaining_amt" class="form-control" readonly>							

	</div>

	</div>

	<br><br>

	

	<div>

	<input onclick="return confirm('Do you want to save.');" type="submit" name="save" value="Save" id="add" style="margin-left:390px;" class="btn btn-primary btn-sm"/>

	<input type="reset" name="reset" value="Cancel" style="margin-left:30px;" class="btn btn-primary btn-sm"/>

	</div>



</form>



<script>

$("#expensed_amt").keyup(function()

{

	var expamt = $(this).val();

	var availamt = $("#available_amt").val();

	

	if(parseInt(expamt) > parseInt(availamt))

	{

		alert("Expensed amount is not more than available amount.");

		$(this).val("");

		$(this).focus();

	}

	else

	{

	//var expamt = $("#expensed_amt").val();

	var balamt = availamt - expamt;

	$("#remaining_amt").val(balamt);

	}

});

</script>
<?php include('datatable_links.php');?>
<script>
	"use strict";
$(document).ready(function(){
$('form').on('submit', function (e) {
	e.preventDefault();
  var action = "add_budget_expense";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("input[type='submit']").val("please wait...");  
	$('input[type="submit"]').attr("disabled", true);

	$.ajax({
		url:"Controllers/AdministrationControllers.php",
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
				window.location.href='dashboard.php?option=add_budget_expense';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$("input[type='submit']").val(" Save");  
	        $('input[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>
