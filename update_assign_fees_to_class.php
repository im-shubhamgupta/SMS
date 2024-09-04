<?php
	//error_reporting(1);
	extract($_REQUEST);
	$cls_id = $_REQUEST['clsid'];
	$q = mysqli_query($con,"select * from class where class_id='$cls_id'");
	$r = mysqli_fetch_array($q);
	$clsname = $r['class_name'];
	
	$assid = $_REQUEST['afid'];
	$q2 = mysqli_query($con,"select * from assign_fee_class where assign_fee_id='$assid'");
	$r2 = mysqli_fetch_array($q2);
	$fhid = $r2['fee_header_id'];
	$fhamt = $r2['fee_header_amount'];
	$tamt = $r2['total_amount'];
	$month = $r2['no_of_months'];
	
?>
<div class="card">

<form action="" method="post">
	<div class="card-header">
		<strong>Update Assign</strong> Fees
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label STYLE="color:green"><?php echo @$err; ?></label>
	</div>
	<div class="card-body card-block">
		
			<div class="form-group">
			<label for="nf-email" class="form-control-label">Select Class</label><br>
			<input type="text" class="form-control" value="<?php echo $clsname;?>" disabled>
			</div>
			
			 <div class="form-group">

			<label for="nf-email" class=" form-control-label">Select NO. Of Months</label>

			<select class="form-control" id="month" name="months"    onchange="checktamount(this.value)" autofocus required>

				

					<?php

						$rows=1;

						while( $rows<13)  {

						?>

						<option <?php  if($rows==$month){ echo "selected";}else{  } ?> value="<?php echo $rows; ?>"><?php echo $rows; ?>

						</option>

						<?php  $rows++; } ?>	

				</select>

			

			</div>
			
			
			
			
			
			<div class="form-group">
			<label for="nf-email" class=" form-control-label">Select Fees Headers</label><br>
						
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
					
					$fhidarr = explode(',',$fhid);
					$fhamtarr = explode(',',$fhamt);
					
					$array =array_combine($fhidarr,$fhamtarr);
					
					
				?>
				<div class="row">
				<div class="col-md-1">
				<input type="checkbox" name="feehead[]" id="fid<?php echo $feeid;?>" style="margin-left:10px;" 
				onclick="saveheader(this.value)" value="<?php echo $feeid;?>" 
				<?php
				$a = 0;
				foreach($array as $key=>$value)
					{
						
						if($key == $feeid)
						{
							echo "checked";
							$a = $value;
						}
					}	
				?>
				>
				
				</div>
				
				<div class="col-md-2">
				<span><?php echo $feename .' (<b>'.$TypeTex.'</b>)';?></span>
				</div>
				
				<div class="col-md-1">
					<span><input class="amount" type="number" data-typeid='<?=$Type;?>'   name="feeamt[]" id="feeamt<?php echo $feeid;?>"	<?php if(empty($a)){echo "disabled";}?> placeholder="Enter Amount" value="<?php if($a!=0)echo $a;?>"
					
					></span>
				</div>
				</div><br>
			<?php 
				
			}
			?>
			
			
			<div class="row">
			<div class="col-md-1"></div>

			<div class="col-md-2" style="font-size:17px;font-weight:bold">Total</div>
			
			<div class="col-md-1">
			<span><input type="number" name="tamount" id="tamount" style="font-size:14px;font-weight:bold" value="<?php echo $tamt; ?>" readonly></span>
			<input type="hidden" name="assid" value="<?=$assid?>">
			<input type="hidden" name="cls_id" value="<?=$cls_id?>">
			</div>
			</div>
			
			
			</div>
			
		
	</div>
	<div class="card-footer">
		<button type="submit" name="update" class="btn btn-secondary btn-sm">
			<i class="fa fa-edit"></i> Update
		</button>
			
		<a href="dashboard.php?option=view_assign_fees_to_class" class="btn btn-info btn-sm"> 
		<i class='fa fa-arrow-left'> Back</i></a>
		
	</div>
	</form>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
function saveheader(x)
{
	if($('#fid'+x).is(':checked')) {
	    autocheck_total();
		$('#feeamt'+x).removeAttr('disabled');
		$('#feeamt'+x).prop('required',true);

	} else {
		$('#feeamt'+x).prop('disabled', 'disabled');
		$('#feeamt'+x).val('');
		autocheck_total();
	}
	
}


 function checktamount(month){

	 var sum = 0;
	$(".amount").each(function(){

	

	if($(this).val()=='')

		$a=0;
		else

		$a=$(this).val();
	// alert($a);
	// console.log(this);
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
$(document).ready(function(){
	$(".amount").keyup(function(){
	// alert(1);
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
	 autocheck_total();   //final calculate
  var action = "update_assign_fees_to_class";
	$(this).append("<input type='hidden' name="+action+" >");
	var data_string=new FormData(this);
	$("button[type='submit']").html("please wait...");  
	$('button[type="submit"]').attr("disabled", true);

	// alert(name);

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
			$('button[type="submit"]').html('<i class="fa fa-edit"></i> Update Section');  
	      $('button[type="submit"]').attr("disabled", false);
		}
	})
});

});

</script>