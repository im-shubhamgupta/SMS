<?php
include('connection.php');
extract($_REQUEST);
$stuid=$_REQUEST['stuid'];
$que=mysqli_query($con,"select * from students where student_id=11");
$res=mysqli_fetch_array($que);
$tutdisc=$res['tutionfee_disc'];
$transdisc=$res['transfee_disc'];


$classid=$res['class_id'];
$qcls=mysqli_query($con,"select * from class where class_id='$classid'");
$rcls=mysqli_fetch_array($qcls);
$qfee=mysqli_query($con,"select * from fees where class_id='$classid'");
$rfee=mysqli_fetch_array($qfee);
$admfee=$rfee['admissionfees'];
$tufee=$rfee['tutionfees'];
$miscfee=$rfee['misfees'];

$transid=$res['trans_id'];
$qtra=mysqli_query($con,"select * from transports where trans_id='$transid'");
$rtra=mysqli_fetch_array($qtra);
$transfee=$rtra['price'];


if(isset($add))
{
	$query1=mysqli_query($con,"insert into bill values ('','$stuid','$nadmfee','$ntutnfee','$nmiscfee','$ntransfee',
	'$paidby','$chlno','$issby','$issdate')" );
	
	echo "<script>window.location='dashboard.php?option=view_bill'</script>";
	
}


?>

<style>
.row #top-div{
	width:100%;
	border:3px solid grey;
	padding:10px;
	border-radius:10px;
	//text-align:center;
	font-size:18px;
	padding-top:15px;
	
}	
#top-div h6{
	display:inline-block;
	margin-left:8px;
	font-weight:bold;
	
}

.heading{
		color:grey
		font-weight:bold;
		margin-left:10px;
	}

.heading1{
		color:grey
		font-weight:bold;
		margin-left:55px;
	}
.heading2{
		color:grey
		font-weight:bold;
		margin-left:70px;
	}
	
	.heading3{
		color:grey
		font-weight:bold;
		margin-left:100px;
	}
	.heading4{
		color:grey
		font-weight:bold;
		margin-left:130px;
	}
	.heading5{
		color:grey
		font-weight:bold;
		margin-left:25px;
	}

#top-amt-pay{
	border:3px solid grey;
	padding:10px;
	border-radius:10px;
	margin-top:15px;
	width:250px;
}
#top-amt-pay h4{
	text-align:center;
	
}
#amt-fld{
	margin-top:20px;
	font-size:20px;
	font-weight:bold;
	width:400px;
}

#amt-paid{
	border:3px solid grey;
	padding:10px;
	border-radius:10px;
	margin-top:15px;
	margin-left:0px;

	
}
#amt-paid h4{
	text-align:center;
}
#div-name{
	font-size:20px;
	font-weight:bold;
}

#div-data{
	width:300px;
}
#chk{
	width:500px;
	margin-top:5px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<div class="container">
<form method="post" enctype="multipart/form-data">
   <div class="row">
   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" id="top-div">
   <span class="heading">	Student Name :</span>
   <h6> <?php echo $res['student_name'];?></h6>  
   <span class="heading1"> Class : </span>
 <h6>   <?php echo $rcls['class_name'];?> </h6><br>
 
 <span class="heading"> Admission Fee :</span>
   <h6> <?php echo $admfee;?> </h6> 

<span class="heading2"> Tution Fee :</span>
 <h6> <?php echo $tufee;?>   </h6> 
 
 <span class="heading3"> Miscellaneous Fee : </span>
   <h6><?php echo $miscfee;?> </h6>
 <span class="heading4"> Transport Fee :</span>
   <h6><?php echo $transfee;?></h6><br>
   
   <span class="heading"> Tution Fee Discount :</span>
   <h6> <?php echo $tutdisc;?>  </h6>

   <span class="heading5">Transport Fee Discount:</span>
    <h6><?php echo $transdisc;?></h6>
   </div>
   </div>
   
   
	<div class="row">
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12" id="top-amt-pay">
						<div class="our-services-wrapper mb-60">
							<div class="services-inner">
								<div class="our-services-img">
								<img src="https://www.orioninfosolutions.com/assets/img/icon/Agricultural-activities.png" width="68px" alt="">
								</div>
								<div class="our-services-text">
									<h4>Amount To Pay</h4><hr>
								<div class="col-md-6">	
								<div class="form-group">
								
								<?php
								$qubill=mysqli_query($con,"select * from bill where student_id='$stuid'");
								
								$afpaid=0;
								$tfpaid=0;
								$mfpaid=0;
								$trfpaid=0;
								while($resbill=mysqli_fetch_array($qubill))
								{
									$afpaid+=$resbill['admfeepaid'];
									$tfpaid+=$resbill['tutionfeepaid'];
									$mfpaid+=$resbill['miscfeepaid'];
									$trfpaid+=$resbill['transfeepaid'];
								
								}
								$baladmfee=$admfee-$afpaid;
								$bal_tutfee=$tufee-$tutdisc-$tfpaid;
								$bal_miscfee=$miscfee-$mfpaid;
								$bal_transfee=$transfee-$transdisc-$trfpaid;
								$totalamt=$baladmfee+$bal_tutfee+$bal_miscfee+$bal_transfee;
									
							
								?>
								<label id="amt-fld">Admission Fee :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $baladmfee;?></label><br>
								<label id="amt-fld">Tution Fee : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bal_tutfee;?></label><br>
								<label id="amt-fld">Miscellaneous Fee : &nbsp;<?php echo $bal_miscfee;?></label><br>
								<label id="amt-fld">Transport Fee : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bal_transfee;?></label><br>
								<label id="amt-fld">Total : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $totalamt;?></label><br>
								<input type="hidden" id="totalpayble" name="totalpayble" value="<?php echo $totalamt;?>"/>
								</div>
								</div>								
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" id="amt-paid">
						<div class="our-services-wrapper mb-60">
							<div class="services-inner">
								<div class="our-services-img">
								<img src="https://www.orioninfosolutions.com/assets/img/icon/Agricultural-activities.png" width="68px" alt="">
								</div>
								<div class="our-services-text">
									<h4>Paid</h4><hr>
	
								<div class="col-md-6">	
								<div class="form-group">
								<div class="row" id="chk">
									<div class="col-md-6" id="div-name">Admission Fee :</div>
									<div class="col-md-6" id="div-data"><input type="number" name="nadmfee" class="form-control" id="admfee"/></div>
								</div>
								
								<div class="row"  id="chk">
									<div class="col-md-6" id="div-name">Tution Fee :</div>
									<div class="col-md-6" id="div-data"><input type="number" name="ntutnfee" class="form-control" id="tutnfee"/></div>
								</div>
								<div class="row"  id="chk">
									<div class="col-md-6" id="div-name">Miscellaneous Fee :</div>
									<div class="col-md-6" id="div-data"> <input type="number" name="nmiscfee" class="form-control" id="miscfee"/></div>
								</div>
								<div class="row"  id="chk">
									<div class="col-md-6" id="div-name">Transport Fee :</div>
									<div class="col-md-6" id="div-data"><input type="number" name="ntransfee" class="form-control" id="transfee"/></div>
								</div>
								<div class="row"  id="chk">
									<div class="col-md-6" id="div-name">Total :</div>
									<div class="col-md-6" id="div-data"> <input type="number" name="totalpaid" id="totalpaid" class="form-control" readonly/></div>
								</div>
								<div class="row"  id="chk">
									<div class="col-md-6" id="div-name">Amount Due : </div>
									<div class="col-md-6" id="div-data"><input type="number" name="amtdue" id="amtdue" class="form-control" readonly/></div>
								</div>
								<div class="row"  id="chk">
									<div class="col-md-6" id="div-name">Paid By :</div>
									<div class="col-md-6" id="div-data"><input type="text" name="paidby" class="form-control"/></div>
								</div>
								<div class="row"  id="chk">
									<div class="col-md-6" id="div-name">Challan Number :</div>
									<div class="col-md-6" id="div-data"><input type="number" name="chlno" class="form-control"/></div>
								</div>
								
							
								</div>
								</div>
									
								</div>
							</div>
						</div>
					</div>
	</div>
	
								<div class="row" style="width:400px;margin-top:20px;">
								<div class="col-md-6" style="float:right">	
								Issued By :   
								</div>
								<div class="col-md-6">	
								<input type="text" name="issby" class="form-control"/>
								</div>
								</div>
								
								<div class="row" style="width:400px;margin-top:20px;">
								<div class="col-md-6">	
								Issued Date :     
								</div>
								<div class="col-md-6" style="float:right">	
								<input type="date" name="issdate" class="form-control"/><br>
								</div>
								</div>
								
	

		<div style="text-align:center">
		<button onclick="myFunction()" class="btn btn-primary">Print Receipt</button>
		</div>
		
</form>
</div>
<br>
<br>

		
<script>
$(document).ready(function(){		
$("#transfee").blur(function(){
var admfee=document.getElementById("admfee").value;
var tutnfee=document.getElementById("tutnfee").value;
var miscfee=document.getElementById("miscfee").value;					
var transfee=document.getElementById("transfee").value;
var totalpaid=Number(admfee)+Number(tutnfee)+Number(miscfee)+Number(transfee);
//alert (Insurance1);
document.getElementById("totalpaid").value=parseInt(totalpaid);

var totalpayble=document.getElementById("totalpayble").value;
var amtdue=Number(totalpayble)-Number(totalpaid);
document.getElementById("amtdue").value=parseInt(amtdue);

});

});
</script>

<script>
function myFunction() {
  window.print();
}
</script>

