<?php
include('connection.php');
error_reporting(1);
extract($_REQUEST);
$email=$_SESSION['user_logged_in'];

  $baseurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);


  if(!empty($_SESSION['session']) && isset($_SESSION['session'])){	
	 $session= $_SESSION['session'];
	}else{	
	 $session='0';	
	}
	
    $username=$res['username'];

    $stuid=$_REQUEST['stuid'];
	
	$Monthly_Query = mysqli_query($con,"select monthly_fee_due,month from student_due_fees where student_id='$stuid' && (status='0' || status='1') ORDER BY student_due_fee_id DESC LIMIT 1;");
	
	if($Monthly_Query->num_rows>0){	
	 $Monthly_Data=$Monthly_Query->fetch_assoc();
	 $prevfees =$Monthly_Data['monthly_fee_due'];
	 
	 $Paid_Months =$Monthly_Data['month'];
		
	}else{
		$prevfees=0;
	}
    if(!empty($Paid_Months)){
		
	 $array_of_paid_months= explode(',',$Paid_Months);
	 $LastPaidMonth = end($array_of_paid_months);
	}else{
	 $CurrentDate=date('d-m-Y');	
		
	}
	
	
	
	/******************************* Late Fee ***************************************************************/

	 $Query= $con->query("Select late_fee_amount,late_fee_date FROM late_fee  Where student_id='".$stuid."' and session='".$session."'" );
 
	 if($Query->num_rows>0){
		
		$Row=$Query->fetch_assoc();
		
		$Late_Fee_Amount= $Row['late_fee_amount'];
		$Late_Fee_date= $Row['late_fee_date'];	
		 
		 
	 }else{
		$Late_Fee_date='1'; 
		 
	 }
	

	 
	  $current_month=date('m');
	  $no_of_LateFee_month=0;
	  $current_month=$current_month-3;
	  $LateFeeMonth=array();
	  $date1 = date('d');
	 
	  $date1 = ltrim($date1, "0"); 
	  
	  if(isset($LastPaidMonth)){
	  if($current_month>$LastPaidMonth && $date1>$Late_Fee_date ){
		  $no_of_LateFee_month=$current_month-$LastPaidMonth;
		  echo $no_of_LateFee_month;
	  }
	  }elseif($date1>$Late_Fee_date){
	     $no_of_LateFee_month=$no_of_LateFee_month+1;
	  }
	  
	
	 
	 
	  
	  
	  if(isset($no_of_LateFee_month)){
		 $Late_fee=$Late_Fee_Amount*$no_of_LateFee_month; 
	  }else{
		 $Late_fee='';    
	  }
	 
	
	/************************************END OF Late Fee ************************************************/
	
	// $que=mysqli_query($con,"select * from students where student_id='$stuid'  && session='".$_SESSION['session']."' ");
    $que=mysqli_query($con,"select `student_name`,`register_no`,`father_name`,`gender`,`msg_type_id`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."' ");
	$res1=mysqli_fetch_array($que);
	$stuname=$res1['student_name'];
	$clsid=$res1['class_id'];
	$gender=$res1['gender'];
	$msgtype=$res1['msg_type_id'];
		
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
	if($qcls->num_rows > 0){
		$rcls=mysqli_fetch_array($qcls);
		$stuclass = $rcls['class_name'];
	}else{
		$stuclass = 0;
	}

$sectionid=$res1['section_id'];
$qsec=mysqli_query($con,"select * from section where section_id='$sectionid'");
if($qsec->num_rows > 0){
    $rsec=mysqli_fetch_array($qsec);
    $stusec = $rsec['section_name'];
}else{
    $stusec = 0;
}


$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));


?>


<?php

?>



<style>
	/* td{
		font-size: 11px;
	} */

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<div class="container">
<form method="post" id="collectfee" enctype="multipart/form-data">
  <div class="row row1">
	  <div class="col-md-4 row4" style="padding:10px;">Student Name : <?php echo $stuname;?> </div>
	  <div class="col-md-4 row4" style="padding:10px;">Class : <?php echo $stuclass;?> </div>
	  <div class="col-md-4" style="padding:10px;">Section : <?php echo $stusec;?> </div>
  </div>

  <div class="row row2">
	<?php
	$qf = mysqli_query($con,"select * from assign_fee_class where class_id='$classid'  and session='".$_SESSION['session']."' ");
	$rf = mysqli_fetch_array($qf);
	$oamt = $rf['fee_header_amount']; 
	$oamtarr = explode(',',$oamt);


	$qfee = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid' and session='".$_SESSION['session']."' ");
	$rfee = mysqli_fetch_array($qfee);
		$feehead = $rfee['fee_header_id'];
		$headarr = explode(',',$feehead);
		
		$feeamt = $rfee['fee_amount'];
		$amtarr = explode(',',$feeamt);
		$no_of_months=$rfee['no_of_months'];
		/************************************* Student Admission Month*************************************************************************/
		$fee_start_month=$rfee['fee_start_month'];
     /************************************* Student Admission Date*************************************************************************/
		$tdist = $rfee['discount_amount'];	
			
		$array=array_combine($headarr,$amtarr);
	//print_r($array);
		
		$stfee=0;
		foreach($array as $key=>$value)
		{
			
		$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$key'");
		$r1 = mysqli_fetch_array($q1);
		$fheadname = $r1['fee_header_name'];
		
		$row = sizeof($headarr);
		if($row<3)
		{
	
?>	

	<div class="col-md-6" style="padding:10px;">
	<?php echo $fheadname." : ".$value ;?> </div>

<?php	
	}
else
	{

?>

	<div class="col-md-4" style="padding:10px;"><?php echo $fheadname." : ".$value;?> </div>
	
<?php
	}
	}
	$paidmonth=array();
	$paidMonth = mysqli_query($con,"select month from student_due_fees where student_id='$stuid' and session='".$_SESSION['session']."' ");
	$row2 = mysqli_num_rows($paidMonth);	
	if($row2 > 0){
		while($paidMonthRow = mysqli_fetch_array($paidMonth)){
		$paidmonth[] = $paidMonthRow['month'];
		}
	}


	
	 $string_month= implode(',',$paidmonth);
	 $paid_month=explode(',',$string_month);
	 if($fee_start_month>4){
	 $fee_not_tobe_taken_month=$fee_start_month-4;
	 array_push($paid_month,$fee_not_tobe_taken_month);
	 $paid_month=array_filter($paid_month);
	 }
	 
	 //print_R(array_filter($paid_month));
	 $LastPaymentMonth= max($paid_month);
	 $Current_Month=date('m');
	 
	 /****************** Becuase We Start From April so We Take APRIL AS 1ST Month***************************/
	 if($Current_Month<4){
		$Current_Month= $Current_Month+9;
	 }else{
	  $Current_Month=$Current_Month-3;
	 }
	/*** Get due fee for monthly fee header*/

		if($Current_Month>$LastPaymentMonth){
		  $month_to_pay=$Current_Month-intval($LastPaymentMonth);

		}else{
			$month_to_pay=0;
		}
		
		//echo $month_to_pay;

	/*****************************************************************************/

	 
	 
	
	$q2 = mysqli_query($con,"select student_due_fee_id from student_due_fees  order by student_due_fee_id desc limit 1");
	$r2 = mysqli_fetch_array($q2);
	$row2 = mysqli_num_rows($q2);	
	if($row2 > 0)
	{
		$rno = $r2['student_due_fee_id'] + 1;
		$recptno = str_pad($rno, 4 , "0", STR_PAD_LEFT);
	}
	else
	{
		$recptno = "0001";
	}
	
	
?>	
  </div>
  
  <div class="row row3" style="margin-bottom:10px;">
	  <div class="col-md-4 row4" style="padding:10px;">Previous  Dues: <?php echo $prevfees;?> </div>
	  <!--<div class="col-md-3 row4" style="padding:10px;">Transport Fee : <?php echo $transamt;?> </div>-->
	  <div class="col-md-4 row4" style="padding:10px;">Total Discount : <?php echo $tdist;?> </div>
	  <div class="col-md-4" style="padding:10px;color:red;">Receipt No : <?php echo $recptno;?> </div>
  </div>
  <?php   

  $months = array(1=> 'April', 2 => 'May',  3=> 'June', 4 => 'July', 5 => 'August', 6 => 'September', 7 => 'October', 8 => 'November', 9=> 'December',10 => 'January', 11=> 'February', 12 => 'March', ); 
  ?>
  
    <div class="row"> 
			<div class="col-md-6 offset-1">
				<label for="month" style="color:blue;"> Choose Month</label>
				<select data-placeholder="Choose Month ..." multiple class="chosen-select" id="month" name="month[]" required >	
					<option value=""></option>	
					<?php foreach($months as $key=>$value){
						if(!in_array($key,$paid_month)){
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
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" id="top-amt-pay" style="margin-right:30px;width:260px">
				<table class="table table-striped">
					<tr align="center"><th colspan="2">Paid Details</th></tr>
					<?php
					$qfee1 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'  and session='".$_SESSION['session']."'");
					$rfee1 = mysqli_fetch_array($qfee1);
					
						$feehead = $rfee1['fee_header_id'];
						$headarr = explode(',',$feehead);
						
						$feeamt = $rfee1['fee_amount'];
						$amtarr = explode(',',$feeamt);
														
						$feeheadcount = sizeof($headarr);
						$tbal = 0;
						for($i=0;$i<$feeheadcount;$i++)
						{
						
						$feeid = $headarr[$i];
						$feeamount = $amtarr[$i]; 								
						
						$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1')  && session='".$_SESSION['session']."'");
						$trecamt = 0;
						$tranamt = 0;
						$prevamt = 0;
						$no_of_paid_months=0;
						while($rfee2 = mysqli_fetch_array($qfee2))
						{
							$fhid = $rfee2['fee_header_id'];
							$fhidarr = explode(',',$fhid);
							
							$recamt = $rfee2['received_amount'];
							$recamtarr = explode(',',$recamt);
							
							$paid_month = $rfee2['month'];
                            $paid_months=count(explode(',',$paid_month));
							$no_of_paid_months=$no_of_paid_months+$paid_months;
							
							if(in_array($feeid,$fhidarr))
							{
								$pos = array_search($feeid,$fhidarr);
								$val = $recamtarr[$pos];	
							}
							
							
							// $recamount = $recamtarr[$i];
							$trecamt = $trecamt+intval($val);
							
							$tranamt = $tranamt+$rfee2['transport_amount'];
							$prevamt = $prevamt+$rfee2['previous_amount'];
						}	
						
						$total_amt_paid += $trecamt;
							
						$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
						$r1 = mysqli_fetch_array($q1);
						$fheadname = $r1['fee_header_name'];
															
					?>
					
					<tr style="height:20px"><td><?php echo $fheadname;?> :</td> <td><?php echo $trecamt;?></td></tr>
									
					<?php
						}
						
						$total_amt_paid +=$prevamt;
                   
					
						
					?>
					<tr><td><?php echo "No. Of Months ";?> :</td> <td><?php echo $no_of_paid_months;?></td></tr>
					<tr><td><?php echo "Previous Fee";?> :</td> <td><?php echo $prevamt;?></td></tr>
					<!--<tr><td><?php echo "Transport Fee";?> :</td> <td><?php echo $tranamt;?></td></tr>-->
					<tr><td><?php echo "Total";?> :</td> <td><?php echo $total_amt_paid;?></td></tr>
				</table>
				</div>
	
			
	
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" id="top-amt-pay" style="margin-right:30px;width:300px;">
				<table class="table table-striped">
					<tr align="center"><th colspan="2">Amount to Pay</th></tr>
								
					<?php
					$qfee1 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'  and session='".$_SESSION['session']."'");
					$rfee1 = mysqli_fetch_array($qfee1);
					
						$feehead = $rfee1['fee_header_id'];
						$headarr = explode(',',$feehead);
						
						
						$feeamt = $rfee1['fee_amount'];
						$amtarr = explode(',',$feeamt);
						$No_of_months=$rfee1['no_of_months'];				
						$feeheadcount = sizeof($headarr);
						$tbal = 0;
						$tcurrent_due=0;
						
						for($i=0;$i<$feeheadcount;$i++)
						{
						
						$feeid = $headarr[$i];
						$feeamount = $amtarr[$i]; 								
						
						$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1')  and session='".$_SESSION['session']."' ");
						$trecamt = 0;
						$tranamt = 0;
						$prevamt = 0;
						$no_of_paid_months=0;
						while($rfee2 = mysqli_fetch_array($qfee2))
						{
						
							$fhid = $rfee2['fee_header_id'];
							$fhidarr = explode(',',$fhid);
							
							$recamt = $rfee2['received_amount'];
							
							$paid_month = $rfee2['month'];
                            $paid_months=count(explode(',',$paid_month));
							$no_of_paid_months=$no_of_paid_months+$paid_months;
							$recamtarr = explode(',',$recamt);
							
							if(in_array($feeid,$fhidarr))
							{
								$pos = array_search($feeid,$fhidarr);
								$val = $recamtarr[$pos];	
							}
							
							
							//$recamount = $recamtarr[$i];
							$trecamt = $trecamt+intval($val);
							
							$tranamt = $tranamt+$rfee2['transport_amount'];
							$prevamt = $prevamt+$rfee2['previous_amount'];
						}	
						
						
						
						$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
						$r1 = mysqli_fetch_array($q1);
						$fheadname = $r1['fee_header_name'];
						$fheadtype = $r1['type'];
						if($fheadtype=='1'){
						$charge_type="Monthly";
						
                        $balfee = $feeamount;	
						
						$tbalfee=($feeamount*$No_of_months) - $trecamt;
						if($month_to_pay>0){
						$current_due=$feeamount*$month_to_pay;
						}else{
							$current_due=0;
						}
						}else{
						$charge_type="Yearly";
						$balfee = $feeamount- $trecamt;
                        $tbalfee=$balfee;
                        $current_due=$feeamount- $trecamt;						
						}
									
					?>
					
					<tr><td><?php echo $fheadname. ' (  <b>'.$charge_type.'</b>)';?> : </td> <td><span id="fht<?=$feeid;?>"><?php echo $balfee;?></span>
					<input type="hidden" id="baladmfee<?php echo $feeid;?>" name="baladmfee" value="<?php echo $baladmfee;?>"/>
					
					<input type="hidden" id="check<?php echo $feeid;?>"  value="<?php echo $tbalfee;?>"/>
					</td></tr>
					
					
					
				
					<?php
					$tbal = $tbal + $tbalfee;
					$tcurrent_due=$tcurrent_due+$current_due;
					
				   }
				   
					$totalbal = $tbal + $baltranfee + $balprevfee-$prevamt+$Late_fee;
					
                    $tcurrent_due=$tcurrent_due+$baltranfee+$balprevfee+$Late_fee;				
					?>	

                     <tr><td>No. of Remaining Months : </td><td> <?php echo ($No_of_months-$no_of_paid_months);?></td></tr>	
                     <?php if(!empty($Late_fee)){?>
                     <tr><td>Late Fees: </td><td> <?php echo $Late_fee ;?></td></tr>						 
					 <?php } ?>
					<tr><td>Previous  Dues : </td> <td><span id="balprevfee"> <?php echo $prevfees;?></span></label>
					<input type="hidden" name="bal_prevfee" id="bal_prevfee" value="<?php echo $prevfees;?>"/>
					</td></tr>
													
				
					
					<tr><td>Total : </td> <td><span id="totalpayble1"><?php echo $totalbal;?></span></label>
					<input type="hidden" id="totalpayble" name="totalpayble" value="<?php echo $totalamt;?>"/>
					
					
					
					
					</td></tr>
								
				</table>
				</div>
				
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" id="top-amt-pay" style="margin-right:30px;width:320px;">								
				<table class="table table-striped">
					<tr align="center"><th colspan="2">Paying Amount</th></tr>
					
					<?php
					$qfee1 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'  and session='".$_SESSION['session']."'");
					$rfee1 = mysqli_fetch_array($qfee1);
					
						$feehead = $rfee1['fee_header_id'];
						$headarr = explode(',',$feehead);
						
						
						$feeamt = $rfee1['fee_amount'];
						$amtarr = explode(',',$feeamt);
						$No_of_months=$rfee1['no_of_months'];				
						$feeheadcount = sizeof($headarr);
						$tbal = 0;
						$tcurrent_due=0;
						
						for($i=0;$i<$feeheadcount;$i++)
						{
						
						$feeid = $headarr[$i];
						$feeamount = $amtarr[$i]; 								
						
						$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1')  and session='".$_SESSION['session']."' ");
						$trecamt = 0;
						$tranamt = 0;
						$prevamt = 0;
						$no_of_paid_months=0;
						while($rfee2 = mysqli_fetch_array($qfee2))
						{
						
							$fhid = $rfee2['fee_header_id'];
							$fhidarr = explode(',',$fhid);
							
							$recamt = $rfee2['received_amount'];
							
							$paid_month = $rfee2['month'];
                            $paid_months=count(explode(',',$paid_month));
							$no_of_paid_months=$no_of_paid_months+$paid_months;
							$recamtarr = explode(',',$recamt);
							
							if(in_array($feeid,$fhidarr))
							{
								$pos = array_search($feeid,$fhidarr);
								$val = $recamtarr[$pos];	
							}
							
							
							//$recamount = $recamtarr[$i];
							$trecamt = $trecamt+intval($val);
							
							$tranamt = $tranamt+$rfee2['transport_amount'];
							$prevamt = $prevamt+$rfee2['previous_amount'];
						}	
						
						
						
						$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
						$r1 = mysqli_fetch_array($q1);
						$fheadname = $r1['fee_header_name'];
						$fheadtype = $r1['type'];
						if($fheadtype=='1'){
						$charge_type="Monthly";
						
                        $balfee = $feeamount;	
						
						$tbalfee=($feeamount*$No_of_months) - $trecamt;
						if($month_to_pay>0){
						$current_due=$feeamount*$month_to_pay;
						}else{
							$current_due=0;
						}
						}else{
						$charge_type="Yearly";
						$balfee = $feeamount- $trecamt;
                        $tbalfee=$balfee;
                        $current_due=$feeamount- $trecamt;						
						}
									
					?>
					
					
				
					
					<tr id="chk">
						<td>
						<input type="checkbox" name="chkbox[]" class="check" checked value="<?php echo $feeid;?>"/>
						<?php echo $fheadname;?> :
						<input type="hidden" name="paidfeeid[]" id="paidfeeid<?php echo $feeid;?>" value="<?php echo $feeid;?>" class="form-control"/>
						</td>
						<td>
						<input type="number" name="paidfee[]" value="<?=$balfee;?>" id="<?php echo $feeid;?>" class="form-control form-control-sm fhp tot"/>
						</td>
					</tr>
				
					<?php
						}
					?>									 
					
					<tr id="chk">
						<td>
						<input type="checkbox" name="chkbox[]" id="prevfeedue"  />
						Previous  Dues :</td>
						<td><input type="number" name="nprevfee" id="nprevfee"   readonly class="form-control form-control-sm prevp tot"/></td>
					</tr>	

                     <?php if(!empty($Late_fee)){?>
						 <tr id="chk">
						 <td><input type="checkbox" name="chkbox[]" id="latefee"  />
						 Late Fees: </td>
						 <td><input type="number" name="latefees" id="latefees"  value="<?=$Late_fee;?>" readonly class="form-control form-control-sm latefees tot"/></td>
					 					 
					 <?php } ?>					
					
					<tr id="chk">
						<td>Total :</td>
						<td><input type="number" name="totalpaid" id="totalpaid" readonly class="form-control form-control-sm"/></td>
					</tr>
					<tr id="chk">
						<td>Amount Due : </td>
						<td><input type="number" name="amtdue" id="amtdue" readonly class="form-control form-control-sm"/></td>
					</tr>
					
					<tr id="chk">
						<td>Paid By :</td>
						<td>
						<select name="paidby" id="paidby" class="form-select form-select-sm" onchange="test456()" required> 
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
					<table class="table table-striped">
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
			document.getElementById("utrno").required = false;
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
								
								<div class="col-md-6"><b>Note :</b> <span style="font-size:14px">Unchecked Fees Header will not be shown in the Fees Receipt.</span>
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
 




        <!--Hidden Fields------------------------------->
		
		<input type="hidden" name="stuid" value="<?=$stuid;?>">
		<div style="text-align:center">
		<input type="submit" name="add" value="Save Bill" id="add" class="btn btn-primary btn-md"/>
		
		<a href="dashboard.php?option=view_student_fees_detail" class="btn btn-danger btn-md" style="margin-left:20px;">Back</a>
		
		<input type="submit" name="addprint" value="Save & Print" id="addprint" class="btn btn-warning btn-md" style="margin-left:20px;"/>
		
		</div>
		
</form>
</div>
<br>
<br>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

<script>

var URL="<?php echo $baseurl."/dashboard.php?option=view_student_fees_detail";?>";
	

 $(document).ready(function(){
		toastr.options = {
		"closeButton": true, 
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-bottom-right",	
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",	
		"hideDuration": "1000",	
		"timeOut": "5000",	
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
		baseulr+'/dashboard.php?option=demandfee&student_id='+student_id+'&month='+month,
	  '_blank' 
	   );
	});



$(document).ready(function(){
  $(".fhp").keyup(function(){
    
	 var paidfee = $(this).val();
	 $a=parseInt($('#check'+$(this).attr('id')).val());
	 
	 if($(this).val() ==''){
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
$('#prevfeedue').change(function() {
	if(this.checked){
	 $("#nprevfee").attr("readonly", false); 	
	}else{
	$("#nprevfee").attr("readonly", true); 	
	}
 });
 
  $('#latefee').change(function() {
	if(this.checked){
	 $("#latefees").attr("readonly", false); 	
	}else{
	$("#latefees").attr("readonly", true); 	
	}
 });

});



</script>

<script>
$(document).ready(function(){
	$(".tranp").keyup(function(){
	var paidtranfee = $(this).val();
	$b = parseInt($('#baltransfee').html());
	
	if($(this).val() == ''){
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
	var sum = 0;
	var bal = 0;
	$('.tot').each(function()
	{
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
	
	
	$(".tot").blur(function(){
	var sum = 0;
	var bal = 0;
	$('.tot').each(function()
	{
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
	
	});
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

 $("#add").on('click', function(e){
	 
	 $("input[name='print']").remove();

	 var action = 'CollectFee'; 
	  $(this).append('<input type="hidden" name="'+ action+'"/>'); 
	  $("input[name='add']").attr("value", "Sending, please wait...");        
	 $("input[type='submit']").attr("disabled", true);
	 var formData =new FormData($('#collectfee')[0]);
  $.ajax({	
		type: "POST",
		url:'AjaxHandler.php',
		data:formData,
		contentType: false, 
		cache: false, 
		processData:false, 
		success: function (responce) {
		 var response = JSON.parse(responce); 
		  if(response.m_error=='merror') { 
		 
			 toastr.error(response.msg); 
			  $('#month').focus();
			  $("input[name='add']").attr("value", "Save Bill");
              $("input[type='submit']").attr("disabled", false);			   			 

			}else if(response.status=='error'){
				 
				 toastr.error(response.msg); 
			  $("input[name='add']").attr("value", "Save Bill");
              $("input[type='submit']").attr("disabled", false);
			}else if(response.status=='perror'){
				 
			  toastr.error(response.msg); 
			  $("input[name='add']").attr("value", "Save Bill");
              $("input[type='submit']").attr("disabled", false);
			  
			 }else if(response.status=='derror'){
			   toastr.error(response.msg);
               $("input[name='add']").attr("value", "Save Bill");
              $("input[type='submit']").attr("disabled", false);
			  
               			   
			 }else if(response.status=='Suceess'){
			   toastr.success(response.msg);	
			   setInterval(function(){
                  window.location.href=URL;
                 },3000);
			   
			   
			 }

		}		 
	  
		});
		
		e.preventDefault(); 
 });
 
 
 
 
 $("#addprint").on('click', function(e){
	 var action = 'CollectFee'; 
	 var print='print';
	  $(this).append('<input type="hidden" name="'+ action+'"/>'); 
	   $(this).append('<input type="hidden" name="'+ print+'"/>'); 
	  $("input[name='addprint']").attr("value", "Sending, please wait...");        
	 $("input[type='submit']").attr("disabled", true);
	 var formData =new FormData($('#collectfee')[0]);
  $.ajax({	
		type: "POST",
		url:'AjaxHandler.php',
		data:formData,
		contentType: false, 
		cache: false, 
		processData:false, 
		success: function (responce) {
		 var response = JSON.parse(responce); 
		  if(response.m_error=='merror') { 
		 
			 toastr.error(response.msg); 
			  $('#month').focus();
			  $("input[name='addprint']").attr("value", "Save & Print");
              $("input[type='submit']").attr("disabled", false);			   			 

			}else if(response.status=='error'){
				 
				 toastr.error(response.msg); 
			  $("input[name='addprint']").attr("value", "Save & Print");
              $("input[type='submit']").attr("disabled", false);
			}else if(response.status=='perror'){
				 
			  toastr.error(response.msg); 
			  $("input[name='addprint']").attr("value", "Save & Print");
              $("input[type='submit']").attr("disabled", false);
			  
			 }else if(response.status=='derror'){
			   toastr.error(response.msg);
               $("input[name='addprint']").attr("value", "Save & Print");
              $("input[type='submit']").attr("disabled", false);
			  
               			   
			 }else if(response.status=='PSuceess'){
				var url="<?php echo $baseurl;?>";
			   toastr.success(response.msg);	
			   // toastr.options.onHidden = function() { window.open(url+response.url, '_blank');    }
				// debounce(function(event) {window.open(url+response.url, '_blank'); },2000)();				     
			   setInterval(function(){ window.location.href=url+response.url;  },3000);
			   // setInterval(function(){ window.open(url+response.url, '_blank');  },3000);
			   // setTimeout(function(){ window.open(url+response.url, '_blank');  },3000);
			   
			 }

		}		 
	  
		});
		
		e.preventDefault(); 
 });




</script>