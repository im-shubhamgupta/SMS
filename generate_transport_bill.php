<?php

include('connection.php');

error_reporting(1);

extract($_REQUEST);

$email=$_SESSION['user_logged_in'];

$username=$res['username'];


$stuid=$_REQUEST['stuid'];


$que=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'");

$res1=mysqli_fetch_array($que);

$stuname=$res1['student_name'];

$clsid=$res1['class_id'];

$gender=$res1['gender'];

if($gender=="FEMALE")

{

 $gen="Daughter";	

}

else

{

 $gen="Son";	

}

$fname=$res1['father_name'];

$classid=$res1['class_id'];

$qcls=mysqli_query($con,"select * from class where class_id='$classid'");

$rcls=mysqli_fetch_array($qcls);

$stuclass=$rcls['class_name'];



$sectionid=$res1['section_id'];

$qsec=mysqli_query($con,"select * from section where section_id='$sectionid'");

$rsec=mysqli_fetch_array($qsec);

$stusec=$rsec['section_name'];

$qtrans = mysqli_query($con,"select * from student_route where student_id='$stuid'  && session='".$_SESSION['session']."' ");

$rstrans = mysqli_fetch_array($qtrans);

$trans_id = $rstrans['trans_id'];

$transamt = $rstrans['price'];
$fee_start_month = $rstrans['fee_start_month'];

$transdisc = $rstrans['discount'];


$qprev = mysqli_query($con,"select * from previous_transport_fees where student_id='$stuid' && session='".$_SESSION['session']."' ");

$rprev = mysqli_fetch_array($qprev);

$prevfees = $rprev['previous_transport_fees'];



if(!empty($nprevfee)){

	$nprevfee = $nprevfee;

}else{

	$nprevfee = '0';

}



if(!empty($ntransfee)){

	$ntransfee = $ntransfee;

}else{

	$ntransfee = '0';

}

$messagetype = 'transport_fee_paid';

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
//---------------------------------------------------------------------
$one_month_price= get_student_route_bystuid($stuid,$_SESSION['session'])['price'];

?>





<style>




</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  



<div class="container generate_trans_bill">

<form method="post" enctype="multipart/form-data" id="generate_transport_bill">

   

  <div class="row row1">

	  <div class="col-md-3 row4" style="padding:10px;">Student Name : <?php echo $stuname;?> </div>

	  <div class="col-md-3 row4" style="padding:10px;">Class : <?php echo $stuclass;?> </div>

	  <div class="col-md-3 row4" style="padding:10px;">Section : <?php echo $stusec;?> </div>
	  <div class="col-md-3" style="padding:10px;">Route : <?php echo get_route_name($trans_id);?> </div>

  </div>



<?php

	

	

	$q2 = mysqli_query($con,"select student_trans_fee_id  from student_transport_due_fees order by student_trans_fee_id desc limit 1");

	$r2 = mysqli_fetch_array($q2);

	$row2 = mysqli_num_rows($q2);	

	if($row2 > 0)

	{

		$rno = $r2['student_trans_fee_id'] + 1;

		$recptno = str_pad($rno, 4 , "0", STR_PAD_LEFT);

	}

	else

	{

		$recptno = "0001";

	}
$maxmonthvalue='0';
$no_of_paid_months='0';
 $month_arr=array();	

$stdfSql="select `month` from student_transport_due_fees where student_id='$stuid' AND session='".$_SESSION['session']."' AND `trans_id`='".$trans_id."' "; 
$stdf = mysqli_query($con,$stdfSql);
if(mysqli_num_rows($stdf)>0){
	while($rstdf = mysqli_fetch_array($stdf)){
		if(!empty($rstdf['month'])){
			$each_month[]=explode(',',$rstdf['month']);
		}
	}
	if(isset($each_month)){  //combine all associative array 
		foreach($each_month as $arm){
			foreach($arm as $val){
				$month_arr[]=$val;
			}
		}
    }
	
	if(!empty($month_arr)){
		
	// $array_of_paid_months= explode(',',$month_arr);
	 $LastPaidMonth = end($month_arr);
	 $no_of_paid_months=count($month_arr);
	}else{
	 $CurrentDate=date('d-m-Y');
     $month_arr=array();	 
		
	}
}else{
	  $month_id=get_student_route_bystuid($stuid,$_SESSION['session'])['fee_start_month'];
	  $maxmonthvalue=(get_months_byid($month_id)['fee_order_month']-1);
	 
	
}	

?>	



  

  <div class="row row3" style="margin-bottom:10px;">

	  <div class="col-md-3 row4" style="padding:10px;">Transport Fee : <?php echo $transamt;?> </div>

	  <div class="col-md-3 row4" style="padding:10px;">Previous Transport Fee : <?php echo $prevfees;?> </div>

	  <div class="col-md-3 row4" style="padding:10px;">Total Discount : <?php echo $transdisc;?> </div>

	  <div class="col-md-3" style="padding:10px;color:red;">Receipt No : <?php echo $recptno;?> </div>


  </div>
  <div class="row"> 
			<div class="col-md-6 offset-1">
				<label for="month" style="color:blue;"> Choose Month</label>
				<select data-placeholder="Choose Month ..."  class="chosen-select" id="month" name="month[]" multiple required >	
					<option value=""></option>	
					<?php
                     $months = array(1=> 'April', 2 => 'May',  3=> 'June', 4 => 'July', 5 => 'August', 6 => 'September', 7 => 'October', 8 => 'November', 9=> 'December',10 => 'January', 11=> 'February', 12 => 'March' ); 
					$tik='1';
					foreach($months as $key=>$value){
						if(!in_array($key,$month_arr)){
						echo "<option value='".$key."'>".$value."</option>";
						}

						}
							 
					?>   
				</select>			
					
			</div>
			<div class="col-md-3 offset-1" >
			   <input type="button" name="demandfee" value="Demand Fee" id="demandfee" class="btn btn-primary btn-md"/> 
			</div>
    </div>

      

	<div class="row">

				<div class="col-md-4 col-sm-12" id="top-amt-pay" style="margin-right:30px;">

				<table class="table table-striped">

					<tr align="center"><th colspan="2">Paid Details</th></tr>

					

						<?php

						$qfee2 = mysqli_query($con,"select * from student_transport_due_fees where student_id='$stuid' && (status='0' || status='1') and session='".$_SESSION['session']."'");

						$tramt = 0;

						$ptramt = 0;

						$ttrdue = 0;

						$tptrdue = 0;

						while($rfee2 = mysqli_fetch_array($qfee2))

						{

							$rectransamt = $rfee2['trans_amount'];

							$tramt = $tramt + $rectransamt;

							

							$prevtransamt = $rfee2['previous_trans_amount'];

							$ptramt = $ptramt + $prevtransamt;

						}	

							

							$ttrdue = $transamt - $tramt;

							$tptrdue = $prevfees - $ptramt;

							

							

							$total_amt_paid += $tramt + $ptramt;

						

							$total_amount_to_pay = $ttrdue + $tptrdue;

						

						

						?>

					

					<tr><td><?php echo "Transport Fee";?> :</td> <td><?php echo $tramt;?></td></tr>

					<tr><td><?php echo "Previous Transport Fee";?> :</td> <td><?php echo $ptramt;?></td></tr>
					<tr><td><?php echo "No of Months";?> :</td> <td><?php echo $no_of_paid_months;?></td></tr>

					

					<tr><td><?php echo "Total";?> :</td> <td><?php echo $total_amt_paid;?></td></tr>

				</table>

				</div>

	

			

	

				<div class="col-md-4 col-sm-12" id="top-amt-pay" style="margin-right:30px;">

				<table class="table table-striped">

					<tr align="center"><th colspan="2">Amount to Pay</th></tr>

					

					<tr><td>Transport Fee (Monthly) : </td> <td><span id="baltransfee"> <?=get_student_route_bystuid($stuid,$_SESSION['session'])['price']?></span></label>

					</td></tr>

					

					<tr><td>Previous Transport Fee : </td> <td><span id="balprevfee"> <?php echo $tptrdue;?></span></label>

					</td></tr>
						<?php
						$start_month=get_student_route_bystuid($stuid,$_SESSION['session'])['no_of_months'] ?? '0';
						if($start_month > 0){
							$no_of_remaining_months= $start_month- $no_of_paid_months;
						}
						else{
							$no_of_remaining_months= intval('12')- $no_of_paid_months;
							
						}
							
						?>
					<tr><td>No. of Remaining Months : </td> <td><span id="balprevfee"> <?=$no_of_remaining_months?></span></label>

					</td></tr>



					

					<tr><td>Total : </td> <td><span id="totalpayble1"><?= (get_student_route_bystuid($stuid,$_SESSION['session'])['price']*$no_of_remaining_months)+$tptrdue;?></span></label>

					</td></tr>

								

				</table>

				</div>

				

					

				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12" id="top-amt-pay">

				<table class="table table-striped">

					<tr align="center"><th colspan="2">Paying Amount</th></tr>

					

					<tr id="chk">

						<td>Transport Fee :</td>

						<td><input type="number" name="ntransfee" id="ntransfee" class="form-control tranp tot"  value="<?=get_student_route_bystuid($stuid,$_SESSION['session'])['price']?>"/></td>

					</tr>								

					<tr id="chk">

						<td>Previous Transport Fee :</td>

						<td><input type="number" name="nprevfee" id="nprevfee" class="form-control prevp tot"/></td>

					</tr>

					<tr id="chk">

						<td>Total :</td>

						<td><input type="number" name="totalpaid" id="totalpaid" readonly class="form-control"/></td>

					</tr>

					<tr id="chk">

						<td>Amount Due : </td>

						<td><input type="number" name="amtdue" id="amtdue" readonly class="form-control"/></td>

					</tr>

					

					<tr id="chk">

						<td>Paid By :</td>

						<td>

						<select name="paidby" id="paidby" onchange="test456()" required> 

							<option value="" selected="selected" disabled>Select Paid by</option>

							<?php

							$qpt = mysqli_query($con,"SELECT * FROM payment_type");

							while( $rpt = mysqli_fetch_array($qpt) ) {

							?>

							<option value="<?php echo $rpt['payment_type_id']; ?>"><?php echo $rpt['payment_type_name']; ?>

							</option>

							<?php } ?>	

						</select>

						</td>

					</tr>

					

					

				</table>

				

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" id="demo345" style="display:none">

					<table class="table table-striped" style="width:276px">

					<tr id="chk">

						<td>Cheque/DD No :</td>

						<td><input type="text" name="chqno" id="chqno" class="form-control"/></td>					

					</tr>

					<tr id="chk">

						<td>Bank Name :</td>

						<td><input type="text" name="bankname1" id="bankname1" class="form-control"/></td>

					</tr>

					<tr id="chk">

						<td>Remarks :</td>

						<td><input type="text" name="remarks1" id="remarks1" class="form-control"/></td>

					</tr>

					</table>

				</div>

				

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" id="demo346" style="display:none">

					<table class="table table-striped">

					<tr id="chk">

						<td>Txn No :</td>

						<td><input type="text" name="txnno" id="txnno" class="form-control"/></td>					

					</tr>

					<tr id="chk">

						<td>Bank Name :</td>

						<td><input type="text" name="bankname2" id="bankname2" class="form-control"/></td>

					</tr>

					<tr id="chk">

						<td>Remarks :</td>

						<td><input type="text" name="remarks2" id="remarks2" class="form-control"/></td>

					</tr>

					</table>

				</div>

				

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" id="demo347" style="display:none">

					<table class="table table-striped">

					<tr id="chk">

						<td>UTR No :</td>

						<td><input type="text" name="utrno" id="utrno" class="form-control"/></td>					

					</tr>

					</table>

				</div>

			

				</div>			



			<script>	
			$(".chosen-select").chosen({
					no_results_text: "Oops, nothing found!",
					width: '300px'
				  });

			function test456()

			{

			var p=document.getElementById("paidby").value

			if(p=="1")

			{

			document.getElementById("demo345").style="display:none";

			document.getElementById("demo346").style="display:none";

			document.getElementById("demo347").style="display:none";

			}

			else if(p=="2")

			{

			document.getElementById("demo345").style="display:block";

			document.getElementById("chqno").required = true;

			document.getElementById("bankname1").required = true;

			document.getElementById("remarks1").required = true;

			document.getElementById("demo347").style="display:none";

			document.getElementById("utrno").required = false;

			document.getElementById("demo346").style="display:none";

			document.getElementById("chlno").required = false;

			document.getElementById("bankname2").required = false;

			document.getElementById("remarks2").required = false;

			

			}

			else if(p=="3")

			{

			document.getElementById("demo347").style="display:none";

			document.getElementById("utrno").required = false;

			document.getElementById("demo345").style="display:none";

			document.getElementById("chqno").required = false;

			document.getElementById("bankname1").required = false;

			document.getElementById("remarks1").required = false;

			document.getElementById("demo346").style="display:block";

			document.getElementById("chlno").required = true;

			document.getElementById("bankname2").required = true;

			document.getElementById("remarks2").required = true;

			

			}

			else if(p=="4")

			{

			document.getElementById("demo347").style="display:block";

			document.getElementById("utrno").required = true;

			document.getElementById("demo345").style="display:none";

			document.getElementById("chqno").required = false;

			document.getElementById("bankname1").required = false;

			document.getElementById("remarks1").required = false;

			document.getElementById("demo346").style="display:none";

			document.getElementById("chlno").required = false;

			document.getElementById("bankname2").required = false;

			document.getElementById("remarks2").required = false;

			

			}

			}

			</script>										

								

	</div>

	

								<div class="row" style="margin-top:20px;">

								<div class="col-md-3" style="float:right">	

								Issued By :   

								</div>

								<div class="col-md-3">	

								<input type="text" name="issby" class="form-control" value="<?php echo $username;?>" 

								style="width:230px;" required>

								</div>

								</div>

								

								

								<div class="row" style="margin-top:20px;">

								<div class="col-md-3">	

								Issued Date : (DD-MM-YYYY)     

								</div>

								<div class="col-md-3" style="float:right">	

								<input step="1" type="datetime-local" id="myDatetimeField" name="issdate" class="form-control" 

								style="width:230px;"/>

								</div>

								</div><br>

								

								<script>

								window.addEventListener("load", function() {

								var now = new Date();

								var utcString = now.toISOString().substring(0,19);

								var year = now.getFullYear();

								var month = now.getMonth() + 1;

								var day = now.getDate();

								var hour = now.getHours();

								var minute = now.getMinutes();

								var second = now.getSeconds();

								var localDatetime = year + "-" +

												  (month < 10 ? "0" + month.toString() : month) + "-" +

												  (day < 10 ? "0" + day.toString() : day) + "T" +

												  (hour < 10 ? "0" + hour.toString() : hour) + ":" +

												  (minute < 10 ? "0" + minute.toString() : minute) +

												  utcString.substring(16,19);

								var datetimeField = document.getElementById("myDatetimeField");

								datetimeField.value = localDatetime;

								

								var datetimeField1 = document.getElementById("myDatetimeField1");

								datetimeField1.value = localDatetime;

								});

								</script>

<!--

<script>

$(document).ready(function(){

	

 var currentTime = new Date();

 var hours = currentTime.getHours();

 var minutes = currentTime.getMinutes();

 var t =currentTime.getHours()  + ":" + currentTime.getMinutes();



	

 $("#add").prop("disabled",!(t >= '08:00' && t <= '20:00' ))

 });

</script> 





<script>

$(document).ready(function(){

	

 var currentTime = new Date();

 var hours = currentTime.getHours();

 var minutes = currentTime.getMinutes();

 var t =currentTime.getHours()  + ":" + currentTime.getMinutes();



	

 $("#addprint").prop("disabled",!(t >= '08:00' && t <= '20:00' ))

 });

</script> 

	-->

	<input type="hidden" name="stuid" value="<?=$_GET['stuid']?>"/>
	<input type="hidden" name="route_fee" value="<?=$transamt?>"/>
	<input type="hidden" name="fee_start_month" value="<?=$fee_start_month?>"/>

		<div style="text-align:center">

	
		<input type="submit" name="add"  value="Save Bill" id="add" class="btn btn-primary btn-md"/>

		

		<a href="dashboard.php?option=view_transport_fee_detail" class="btn btn-danger btn-md" style="margin-left:20px;">Back</a>

		

		<input type="submit" name="addprint"   value="Save & Print with sms" id="addprint" class="btn btn-warning btn-md" style="margin-left:20px;"/>

		

		</div>

		

</form>

</div>

<br>

<br>



<script>

$(document).ready(function(){

  $(".fhp").keyup(function(){

    

	 var paidfee = $(this).val();

	 $a=parseInt($('#fht'+$(this).attr('id')).html());

	 

	 if($(this).val() == 0){

		 $(this).val('');

		 return false;

	 }	

	 

	 if($(this).val() < 0){

		 $(this).val('');

		 return false;

	 }	

	 

	 if($(this).val() > $a) {


		 alert('Paid amount cant be greater than amount to pay.');

		 $(this).val('');

		 return false;

	 }

	});

});

</script>



<script>

$(document).ready(function(){

	$(".prevp").keyup(function(){

	var paidtranfee = $(this).val();

	$b = parseInt($('#balprevfee').html());

	

	if($(this).val() == 0){

		 $(this).val('');

		 return false;

	 }	



	if($(this).val() < 0){

		 $(this).val('');

		 return false;

	 }

	 

	if($(this).val() > $b){

		 alert('Paid amount cant be greater than amount to pay.');

		 $(this).val('');

		 return false;

	 }

	

	

	});	

});

</script>



<script>

$(document).ready(function(){

	$(".tranp").keyup(function(){

	var paidtranfee = $(this).val();

	$b = parseInt($('#baltransfee').html());

	

		if($(this).val() == 0){

			$(this).val('');

			return false;

		}	

		

		if($(this).val() < 0){

			$(this).val('');

			return false;

		}

		

		// if($(this).val() > $b){

		// 	alert('Paid amount cant be greater than amount to pay.');

		// 	$(this).val('');

		// 	return false;

		// }	

	});	

});

</script>



<script>
	"use strict";
	function calculate_data(){
		var sum = 0;
		var bal = 0;
		var $a = 0;


		$('.tot').each(function(){
			if($(this).val()=='')
				$a=0;
			else
				$a=$(this).val();
			sum = parseInt(sum)+parseInt($a);
		});

		$("#totalpaid").val(sum);	
		var t = $("#totalpayble1").html();
		var bal = parseInt(t) - parseInt(sum);
		
		$("#amtdue").val(bal);
	}

	// function calculate_amount(){
	// 	var monthArr=$('select[name="month[]"]').val();
	// 	console.log(monthArr);
	// 	if(monthArr!=''){
	// 		var no_of_mon=parseInt(monthArr.length);
	// 		var one_month=parseInt('<?//$one_month_price?>');
	// 		var total=one_month*no_of_mon;
	// 		console.log(total);
	// 		if(total!=''){
	// 			$('select[name="month[]"]').val(total);
	// 		}
	// 	}	

	// }

$(document).ready(function(){

	calculate_data();  //auto call 

	$(".tot").blur(function(){
	// $(".tot").keyup(function(){
		calculate_data();
	});

	// $(document).on('click change','#month',function(){
	// 	calculate_amount();
	// });
	// $(document).on('click','#month',function(){
	// 	calculate_amount();
	// });
	

});

</script>



<script>

$('.check').on('click', function(){

if(!$(this).is(':checked')) 

{

   if(confirm("Unchecked Fees Header will not be shown in  the Fees Receipt. Do you want to Continue."))

   {

	  $(this).prop("checked", false );

   }

   else

   {

	  $(this).prop("checked", true);

   }

}

});

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
		};	
		}); 
		
		
		
		$("#demandfee").on("click",function(){
		var baseulr= "<?php echo $baseurl;?>";
		
		var month= $("#month").val();
		var student_id="<?php echo $_GET['stuid'];?>";
		//var datastring= 'month='+month+'&student_id='+student_id+'&demandfee';
		
		window.open(
		baseulr+'/dashboard.php?option=transport-demandfee&student_id='+student_id+'&month='+month,
	  '_blank' 
	   );
	});	
		

	"use strict";
$(document).ready(function(){
// $('form').on('submit', function (e) {
$('#add').on('click', function (e) {
	e.preventDefault();
	flag=true;
	var paid=$('#paidby').val();
	if(paid=="" || paid==null){
		flag=false;
		alert("*Please select Paid by");
	}
	// var monthArr=$('select[name="month[]"]').val();
	// if($.isEmptyObject(monthArr)) {
	// 	$('input[class="default"]').css('border','1px solid red');
	// 	flag=false;
	// }



if(flag){
	// $("input[type='hidden']").removeAttr("name");
	if(confirm("Do you want to pay bill")){
		$(".Add_Transport_bill_print").removeAttr("name");
	  var action ="Add_Transport_bill";
		$(this).append("<input type='hidden' name="+action+" class='Add_Transport_bill' >");
		var data_string=new FormData($('#generate_transport_bill')[0]);
		// $("input[type='submit']").val("Please wait...")[0]; 
		$('#add').val("Please wait...");   
		$("input[type='submit']").attr("disabled", true);
		$.ajax({
			url:"Controllers/TransportController.php",
			type:"POST",
			data:data_string,
			contentType:false,
			cache:false,
			processData:false,
			success:function(responce) {
				var result = JSON.parse(responce); 
				// alert(responce);
				// console.log(responce);
				if(result.type=="success"){
					// alert('success');
					toastr.success(result.msg); 
					setInterval(function(){ 
					window.location.href='dashboard.php?option=view_transport_fee_detail';
						// $('form')[0].reset();
					},3000);
				}
			
				else if(result.type=="error"){
					toastr.error(result.msg); 
				}
				  	$('#add').val("Save Bill");  
		      $("input[type='submit']").attr("disabled", false);
			}
	  })
	}}
});

});

$(document).ready(function(){

$('#addprint').on('click', function (e) {
// $('#addprint').submit(function(e){
	e.preventDefault();
	flag=true;
	var paid=$('#paidby').val();
	if(paid=="" || paid==null){
		flag=false;
		alert("*Please select Paid by");
	}

  if(flag){

	if(confirm("Do you want to pay bill")){
		$(".Add_Transport_bill").removeAttr("name");

	  var action ="Add_Transport_bill_print";
		$(this).append("<input type='hidden' name="+action+" class='Add_Transport_bill_print' >");
		var data_string=new FormData($('#generate_transport_bill')[0]);
		
		$(this).val("Please wait...");   
		$("input[type='submit']").attr("disabled", true);
		$.ajax({
			url:"Controllers/TransportController.php",
			type:"POST",
			data:data_string,
			contentType:false,
			cache:false,
			processData:false,
			success:function(responce) {
				var result = JSON.parse(responce); 
				// alert(responce);
				// console.log(responce);
				if(result.type=="success"){
					// alert('success');
					toastr.success(result.msg); 
					setInterval(function(){ 
						// window.location.href=response.url;
						// var url='dashboard.php?option=';

					window.location.href=result.url;
						// $('form')[0].reset();
					},3000);
				}	
				else if(result.type=="error"){
					toastr.error(result.msg); 
				}
				  $('#addprint').val("Save & Print");  
		      $("input[type='submit']").attr("disabled", false);
			}
		})
	}	}
	});

});

</script>