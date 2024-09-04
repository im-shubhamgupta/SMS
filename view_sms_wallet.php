<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

date_default_timezone_set("Asia/Kolkata");



?>

		  <!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Configuration Panel</a>

  <a class="breadcrumb-item" href="#">SMS Setting</a>

  <span class="breadcrumb-item active">SMS Wallet</span>

</nav>
<style>
	</style>
<?php// echo @$err; ?>
<!-- breadcrumb -->
	<?php 	
	$query2=mysqli_query($con,"select * from `log_sms_count` where id='2' ");
  $query1=mysqli_query($con,"select * from `log_sms_count` where id='1' ");

  $Trow=mysqli_fetch_assoc($query2);
  $Wrow=mysqli_fetch_assoc($query1);

  $Wmonth=date('F' ,strtotime($Wrow['modify_date']));
  	$Tmonth=date('F' ,strtotime($Trow['modify_date']));
?>
<div class='container' style="margin-top:40px;">
	<div class="row">


		<div class="col-md-5 offset-1 " >
				<table class="table table-bordered"  style="background-color: white;">
				  <thead>
				  	<tr>
				  		<th colspan="2" ><span><img src="images/sms_image/whatsapplogo.png" width="30px" height="30px" title="Whatsapp SMS"/></span>   Whatsapp SMS Details</th>
				  	</tr>
				  </thead>
				  <tbody>
				    
				 
				    <tr>
				      <th >Sms Limit</th>
				      <td><?=$Wrow['limit']?></td>
				    </tr>
				    <tr>
				      <th>Remaining SMS</th>
				      <!-- <td><?//$Wrow['limit']-$Wrow['curr_month']?></td> -->
				      <td><?=$Wrow['count_sms']?></td>
				    </tr>
				    <tr>
				     
				      <th><?=$Wmonth?> Month</th>
				      <td><?=$Wrow['curr_month']?></td>
				     
				    </tr>
				    <tr>
				      <th scope="row">Last Month</th>
				      <td><?=$Wrow['prev_month']?></td>
				    
				    </tr>
				    <tr>
				     
				      <th scope="col">Total Sent SMS</th>
				      <th scope="col"><?=$Wrow['total_send']?></th>
				      
				    </tr>
				  </tbody>
				</table>
			</div>

			<div class="col-md-5 " >
				<table class="table table-bordered"  style="background-color: white;">
				  <thead>
				  	<tr>
				  		<th colspan="2" ><span><img src="images/sms_image/textsms.png" width="30px" height="30px" title="Text SMS"/></span>   Text SMS Details</th>
				  	</tr>
				    
				  </thead>
				  <tbody>
				    <tr>
				      <th >Sms Limit</th>
				      
				      <td><?=$Trow['limit']?></td>
				
				    </tr>
				     <tr>
				      <th>Remaining SMS</th>
				      <!-- <td><?=$Trow['limit']-$Trow['curr_month']?></td> -->
				      <td><?=$Trow['count_sms']?></td>
				    </tr>
				    <tr>
				      <!-- <th scope="row">2</th> -->
				      <th><?=$Tmonth?> Month</th>
				      <td><?=$Trow['curr_month']?></td>
				      <!-- <td>@fat</td> -->
				    </tr>
				    <tr>
				      <th scope="row">Last Month</th>
				      <td><?=$Trow['prev_month']?></td>
				      
				    </tr>
				    <tr>
				      <!-- <th scope="col">#</th> -->
				      <th scope="col">Total Sent SMS</th>
				      <th scope="col"><?=$Trow['total_send']?></th>
				      
				    </tr>
				  </tbody>
				</table>
			</div>
</div>
</div>



<script>



</script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>

</script>

