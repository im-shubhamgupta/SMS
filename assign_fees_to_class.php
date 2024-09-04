<?php
	// extract($_REQUEST);


	

?>





<div class="card">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Fees</a>

  <a class="breadcrumb-item" href="dashboard.php?option=view_assign_fees_to_class">View Assign Fees to Class</a>

  <span class="breadcrumb-item active">Assign Fees to Class</span>

</nav>

<!-- breadcrumb -->

<form action="" method="post">

	<div class="card-header">

		<strong>Assign</strong> Fees

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo @$err; ?></label>

	</div>

	<div class="card-body card-block">

		

			<div class="form-group">

			<label for="nf-email" class=" form-control-label">Select Class</label>

			<select class="form-control" name="class" onchange="check_assign_feeto_class(this.value)" autofocus required>

					<option value="" selected disabled>---Select Class--</option>

					<?php

						$sql = "SELECT * FROM class";

						$resultset = mysqli_query($con, $sql);

						while( $rows = mysqli_fetch_array($resultset) ) {

						?>

						<option value="<?php echo $rows['class_id']; ?>"><?php echo $rows['class_name']; ?>

						</option>

						<?php } ?>	

				</select>

			

			</div>

			
           <div class="form-group">

			<label for="nf-email" class=" form-control-label">Select NO. Of Months</label>

			<select class="form-control" id="month" name="months"  readonly onchange="checktamount(this.value)" autofocus required>

					<option value="" selected disabled>---Select No of Months--</option>

					<?php

						$rows=1;

						while( $rows<13)  {

						?>

						<option <?php if($rows==12){ echo "selected"; } ?>  value="<?php echo $rows; ?>"><?php echo $rows; ?>

						</option>

						<?php  $rows++; } ?>	

				</select>

			

			</div>
			

			<div class="form-group">

			<label for="nf-email" class="form-control-label">Select Fees Headers</label><br>

			
          
			

			<?php

			$qfee = mysqli_query($con,"select * from fee_header");

			while($rfee = mysqli_fetch_array($qfee))

			{

				$feeid = $rfee['fee_header_id'];

				$feename = $rfee['fee_header_name'];
				
				$Type = $rfee['type'];
				if($Type=='1'){
					$TypeTex="Monthly";
				}else{
						
					$TypeTex="Yearly";	
				}

			?>

			<div class="row">

			<div class="col-md-1">

			<input type="checkbox" name="feehead[]" id="fid<?php echo $feeid;?>" style="margin-left:10px;" 

			onclick="saveheader(this.value)" value="<?php echo $feeid;?>">

			</div>

			

			<div class="col-md-2">

			<span><?php echo $feename.' (<b>'.$TypeTex.'</b>)';?></span>

			</div>

			

			<div class="col-md-1">

			<span><input class="amount" type="number"  data-typeid='<?=$Type;?>' name="feeamt[]" id="feeamt<?php echo $feeid;?>" disabled placeholder="Enter Amount"></span>
         


			</div>

			</div><br>

			<?php 

			}

			?>

			

			<div class="row">

			<div class="col-md-1"></div>



			<div class="col-md-2" style="font-size:17px;font-weight:bold">Total</div>

			

			<div class="col-md-1">

			<span><input type="number" name="tamount" id="tamount" style="font-size:14px;font-weight:bold" readonly></span>

			</div>

			</div>

					

					

			</div>

			

	</div>

	<div class="card-footer">

		<button type="submit" name="add" class="btn btn-primary btn-sm">

			<i class="fa fa-plus"></i> Assign Fees

		</button>

		

		<a href="dashboard.php?option=view_assign_fees_to_class" class="btn btn-info btn-sm"> 

		<i class='fa fa-arrow-left'> Back</i></a>



	</div>

	</form>

</div>

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>



<script>

function check_assign_feeto_class(str){

	$.ajax({

		url : 'check_assign_feeto_class.php?clsid='+str,

		type : 'get',

		success : function(data)

		{

			if(data==1)

			{

				alert("Already Fees is Assigned.");

				window.location = "dashboard.php?option=view_assign_fees_to_class";

			}

		}

		

	})

}



 function checktamount(month){
	 
	 var sum = 0;
	$(".amount").each(function(){

	

	if($(this).val()=='')

		$a=0;
		else

		$a=$(this).val();
        var $type=($(this).attr('data-typeid'));
		if($type=='1'){
		   var $no_of_month=month;
		   if(!$no_of_month) {
			alert("Please Select No of Months");
		  }
	  
		var monthlysum=$a*$no_of_month;
		}else{
		 monthlysum=$a;
			
		}
		
       
	   sum = parseInt(sum) + parseInt(monthlysum);



	});

	

	$("#tamount").val(sum);
	 
	 
 }

</script>



<script>

function saveheader(x)

{

	if($('#fid'+x).is(':checked')) {
		autocheck_total();
		$('#feeamt'+x).removeAttr('disabled');

		$('#feeamt'+x).prop('required',true);

	} else {

		$('#feeamt'+x).val('');
		$('#feeamt'+x).prop('disabled', 'disabled');
		autocheck_total();
	}

	



}



</script>	



<script>

$(document).ready(function(){

	$(".amount").keyup(function(){

	
	var sum = 0;
	$(".amount").each(function(){

	

	if($(this).val()=='')

		$a=0;
		else

		$a=$(this).val();
        var $type=($(this).attr('data-typeid'));
		if($type=='1'){
		   var $no_of_month=$('#month').val();
		   if(!$no_of_month) {
			alert("Please Select No of Months");
		  }
	  
		var monthlysum=$a*$no_of_month;
		}else{
		 monthlysum=$a;
			
		}
		
       
	   sum = parseInt(sum) + parseInt(monthlysum);



	});

	

	$("#tamount").val(sum);

	

	});

});
function autocheck_total(){
var sum = 0;
	$(".amount").each(function(){
	if($(this).val()=='')

		$a=0;
	else

		$a=$(this).val();
        var $type=($(this).attr('data-typeid'));
		if($type=='1'){
		   var $no_of_month=$('#month').val();
		   if(!$no_of_month) {
			alert("Please Select No of Months");
		  }
	  
		var monthlysum=$a*$no_of_month;
		}else{
		 monthlysum=$a;
			
		}
		
       
	   sum = parseInt(sum) + parseInt(monthlysum);
	});
	$("#tamount").val(sum);
}


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
  var action = "assign_fees_to_class";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(12);

	$.ajax({
		url:"Controllers/ConfigurationControllers.php",
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
				window.location.href='dashboard.php?option=view_assign_fees_to_class';
							// $('form')[0].reset(); 
				},3000);
			
			}else{
				toastr.error(result.message);
			}
			$('button[type="submit"]').html('<i class="fa fa-plus"></i> Assign Fees');  
	    $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>



