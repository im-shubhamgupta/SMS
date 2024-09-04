<?php
error_reporting(1);
include('connection.php');

$que1 = mysqli_query($con,"select * from student_wise_fees");
$totalfee_tocollect = 0;
while($res1 = mysqli_fetch_array($que1))
{
	$discamount = $discamount + $res1['discount_amount'];
	
	$stramt = $res1['fee_amount'];
	$arramt = explode(',',$stramt);
	
	foreach($arramt as $k)
	{
		$totalfee_tocollect = $totalfee_tocollect + $k;
	}
	
}

$q1 = mysqli_query($con,"select * from student_route");
while($r1 = mysqli_fetch_array($q1))
{
	$transid = $r1['trans_id'];
	$q2 = mysqli_query($con,"select * from transports where trans_id='$transid'");
	$r2 = mysqli_fetch_array($q2);
	$orgprice = $orgprice + $r2['price'];
	$routeamt = $routeamt + $r1['price'];
}
	$distransamt = $orgprice - $routeamt;

	$totalfeediscount = $discamount + $distransamt;


$que2 = mysqli_query($con,"select * from student_route");
$totalfee_trans = 0;
while($res2 = mysqli_fetch_array($que2))
{
	$transamt = $res2['price'];
	$totalfee_trans = $totalfee_trans + $transamt;
}

$grandtotal = $totalfee_tocollect + $totalfee_trans + $totalfeediscount;

?>

<style>
		.progress{
			width: 70%;
			margin-left: 2px;
			height: 15px;
			background-color: #e7e7e7;
			position: relative;
		}
		/* Total Fee Discount */
		.value2{
			position: absolute;
			left: 0;
			top: 0;
			background-color: #112536;
			width: <?php echo $discper; ?>%;
			height: 100%;
		}
		.value2:after{
			content: '';
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(-45deg, 
               rgba(255,255,255,0.4) 33.33%,
               transparent 33.33%,
               transparent 66.66%,
               rgba(255,255,255,0.4) 66.66%
				);
			background-size: 30px 15px;
			animation: progress 10s infinite linear;
		}

		@keyframes progress{
			from{background-position: 0 0;}
			to{background-position: 100% 100%;}
		}
		
		
		/* Total Paid Fees */
		.value{
			position: absolute;
			left: 0;
			top: 0;
			background-color: #112536;
			width: <?php echo $per; ?>%;
			height: 100%;
		}
		.value:after{
			content: '';
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(-45deg, 
               rgba(255,255,255,0.4) 33.33%,
               transparent 33.33%,
               transparent 66.66%,
               rgba(255,255,255,0.4) 66.66%
				);
			background-size: 30px 15px;
			animation: progress 10s infinite linear;
		}

		@keyframes progress{
			from{background-position: 0 0;}
			to{background-position: 100% 100%;}
		}
		
		
		
		/* Total Paid Fees */	
		.value1{
			position: absolute;
			left: 0;
			top: 0;
			background-color: #112536;
			width: <?php echo $bper; ?>%;
			height: 100%;
		}
		.value1:after{
			content: '';
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(-45deg, 
               rgba(255,255,255,0.4) 33.33%,
               transparent 33.33%,
               transparent 66.66%,
               rgba(255,255,255,0.4) 66.66%
				);
			background-size: 30px 15px;
			animation: progress 10s infinite linear;
		}

		@keyframes progress{
			from{background-position: 0 0;}
			to{background-position: 100% 100%;}
		}
		
		
		
		h6{
			margin-left:5px;
			position:relative;
			top:45px;
			width:250px;
			
			
		}
		h6 span{
			padding-right:70px;
			margin-left:-5px;
		}
		
		.DUSTSTORM{background-color:#7D7471;}
		.MARIGOLD{background-color:#EDA334;}
		.CRAYOLA{background-color:#FF773D;}
		.METALLICSEAWEED{background-color:#1F7A8C;}
		.CYAN{background-color:#77A17E;}
		.ORIOLES{background-color:#2E4057;}		
</style>

<!-- Number Of students -->
<div class="col-sm-6 col-lg-4">
	<div class="card text-white DUSTSTORM">
		<div class="card-body pb-0" style="height:210px;">
			<?php 
			$qstu=mysqli_query($con,"select * from students where stu_status='0'");
			$rstu=mysqli_num_rows($qstu);
			?>
			<h4 class="mb-0">
				Students - <span class="count"><?php echo $rstu; ?></span>
			</h4><br>
			<p class="text-light">Total Number of Students</p>
			<!--<a href="dashboard.php?option=view_students" class="btn btn-warning"><i class="fa fa-info-circle"></i> View Details</a><br>-->
			<div class="chart-wrapper px-0" style="height:70px;" height="70">
					<!--<h6>80%</h6>
				<div class="progress">
						<div class="value"></div>
				</div> -->
				
			</div>
		</div>
	</div>
</div>
<!-- Number Of students -->

<div class="col-sm-6 col-lg-4">
	<div class="card text-white MARIGOLD">
		<div class="card-body pb-0" style="height:210px;">
		<?php
		$tamount=0;
		$sexp=mysqli_query($con,"select * from expense");
		while($rexp=mysqli_fetch_array($sexp))
		{
			$tamount+=$rexp['amount'];
		}
		?>
			<h4 class="mb-0">
			<i class="fa fa-rupee"></i> <span class="count"> <?php echo $tamount; ?></span>
			</h4><br>
			<p class="text-light">Total Expenses</p>
			<!--<a href="#" class="btn btn-danger"><i class="fa fa-info-circle"></i> View Details</a><br>-->
			<div class="chart-wrapper px-0" style="height:70px;" height="70">
			<!--	<h6>80%</h6>
				<div class="progress">
						<div class="value"></div>
				</div> -->
			</div>
		</div>
	</div>
</div>
          
<!--Total No of Students Paid -->
<div class="col-sm-6 col-lg-4">
	<div class="card text-white CRAYOLA">
		<div class="card-body pb-0" style="height:210px;">
			<h4 class="mb-0">
			<i class="fa fa-rupee"></i> 	<span class="count"><?php echo  "$grandtotal"; ?></span>
			</h4><br>
			<p class="text-light">Total Fees To Collect</p>
			<!--<a href="#" class="btn btn-info"><i class="fa fa-info-circle"></i> View Details</a><br>-->
			<div class="chart-wrapper px-0" style="height:70px;" height="70">
				<!--<h6>80%</h6>
				<div class="progress">
						<div class="value"></div>
				</div>-->
			</div>
		</div>
	</div>
</div>
<!--Total No of Students Paid -->



<!--Total Discount Fees -->
 <div class="col-sm-6 col-lg-4">
	<div class="card text-white METALLICSEAWEED">
		<div class="card-body pb-0" style="height:215px;">
			<h4 class="mb-0">
			<i class="fa fa-rupee"></i> <span class="count"><?php echo $totalfeediscount;?></span>
			</h4><br>		
			<p class="text-light">Total Fee Discount</p>
			<div class="chart-wrapper px-0" style="height:70px;" height="70">
				<h6><?php echo $discper;?>%</h6>
				<div class="progress">
						<div class="value2"></div>
				</div>
			</div>
			<a href="dashboard.php?option=view_discount_students" class="btn btn-primary btn-sm" style="margin-left:160px;"></i><i class="fa fa-info-circle"></i> View Details</a><br>
		</div>
	</div>
</div>
<!--Total Discount Fees -->


<!--Total No of Students Due -->
<div class="col-sm-6 col-lg-4">
	<div class="card text-white CYAN">
		<div class="card-body pb-0" style="height:215px;">
		<?php
		$que3=mysqli_query($con,"select * from student_due_fees");
		while($rque3=mysqli_fetch_array($que3))
		{
			$recdamt=$rque3['received_amount'];
			$tranamt=$rque3['transport_amount'];
			$arr = explode(',',$recdamt);
			
			foreach($arr as $k)
			{
			 $tpaidamt1 = $tpaidamt1 + $k ;
			}
			
			$trans = $trans + $tranamt;
			$tpaidamt = $tpaidamt1 + $trans;
		}

		?>
			<h4 class="mb-0">
			<i class="fa fa-rupee"></i> <span class="count"><?php echo $tpaidamt;?></span>
			</h4><br>
			<p class="text-light">Total Paid Fees</p>
			<!--<a href="#" class="btn btn-success"><i class="fa fa-info-circle"></i> View Details</a><br>-->
			<div class="chart-wrapper px-0" style="height:70px;" height="70">
				<h6><?php echo $per;?>%</h6>
				<!--<h6><span>Out Of 20000/- </span> 80%</h6>-->
				<div class="progress">
						<div class="value"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Total No of Students Due -->



<!-- Number Of students -->
<div class="col-sm-6 col-lg-4">
	<div class="card text-white ORIOLES">
		<div class="card-body pb-0" style="height:215px;">
		<?php
		$q1 = mysqli_query($con,"select * from student_wise_fees");
		while($r1 = mysqli_fetch_array($q1))
		{
			$dueamt = $dueamt + $r1['due_amount'];
		}
		?>
			<h4 class="mb-0">
			<i class="fa fa-rupee"></i> <span class="count"><?php echo $dueamt; ?></span>
			</h4><br>
			<p class="text-light">Total Due Fee</p>
			<!--<a href="#" class="btn btn-danger"><i class="fa fa-info-circle"></i> View Details</a><br>-->
			<div class="chart-wrapper px-0" style="height:70px;" height="70">
				<h6><?php echo $bper;?>%</h6>
				<div class="progress">
						<div class="value1"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Number Of students -->


<!--Total No of Students Paid -->
<div class="col-sm-6 col-lg-4">
	<div class="card text-white bg-flat-color-4">
		<div class="card-body pb-0" style="height:210px;">
			<?php 
			$qta=mysqli_query($con,"select * from student_route");
			$rta=mysqli_num_rows($qta);
			$transamt=0;
			while($res=mysqli_fetch_array($qta))
			{
			$transamt = $transamt + $res['price'];
			}
			?>
			<h4 class="mb-0">
				 <i class="fa fa-rupee"></i> <span class="count"><?php echo $transamt;?></span>
			</h4><br>
			<p class="text-light">Tranport Availed - <span class="count"><?php echo $rta;?></span></p>
			<br><a href="dashboard.php?option=view_route_to_student" class="btn btn-warning btn-sm" style="margin-left:160px;margin-bottom:20px"></i><i class="fa fa-info-circle"></i> View Details</a>
			<br><br><br>
		</div>
	</div>
</div>
<!--Total No of Students Paid -->

<!-- Total App Adoption -->
<div class="col-sm-6 col-lg-4">
	<div class="card text-white bg-flat-color-5">
		<div class="card-body pb-0" style="height:210px;">
			<?php 
			$qapp=mysqli_query($con,"select * from installed_app");
			$rapp=mysqli_num_rows($qapp);
			
			$qs = mysqli_query($con,"select * from students");
			$rs = mysqli_num_rows($qs);
					
			$appper = round($rapp/$rs*100,2);
					
			?>
			<h4 class="mb-0">
				Student App Adoption - <span class="count"><?php echo $rapp;?></span> / <span class="count"><?php echo $rs;?></span>
			</h4><br>
			<p class="text-light"> <span class="count"><?php echo $appper;?></span>% of Active Students</p>
			<br><a href="dashboard.php?option=view_appinstalled_detail" class="btn btn-warning btn-sm" style="margin-left:160px;margin-bottom:20px"></i><i class="fa fa-info-circle"></i> View Details</a>
			<br><br><br>
		</div>
	</div>
</div>
<!-- Total App Adoption -->

<!-- Total App Adoption -->
<div class="col-sm-6 col-lg-4">
	<div class="card text-white bg-info">
		<div class="card-body pb-0" style="height:210px;">
			<?php 
			$qfeed=mysqli_query($con,"select * from feedback");
			$rfeed=mysqli_num_rows($qfeed);
						
			?>
			<h4 class="mb-0">
				No of Feedback Submitted - <span class="count"><?php echo $rfeed;?></span> 
			</h4><br><br>
			<p></p>
			<br><a href="dashboard.php?option=view_feedback_response" class="btn btn-warning btn-sm" style="margin-left:160px;margin-bottom:20px"></i><i class="fa fa-info-circle"></i> View Details</a>
			<br><br><br>
		</div>
	</div>
</div>
<!-- Total App Adoption -->
