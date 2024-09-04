<?php
include('myfunction.php');
extract($_REQUEST);
$stuid=$_REQUEST['student_id'];
$month=$_REQUEST['month'];
$session=$_SESSION['session'];
$monthArray= explode(',',$month);
$No_of_Month= count($monthArray);


 $Query= $con->query("Select late_fee_amount,late_fee_date FROM late_fee  Where student_id='".$stuid."' and session='".$session."'" );
 // echo "Select late_fee_amount,late_fee_date FROM late_fee  Where student_id='".$stuid."' and session='".$session."'";
 if($Query->num_rows>0){
	
    $Row=$Query->fetch_assoc();
    
    $Late_Fee_Amount= $Row['late_fee_amount'];
    $Late_Fee_date= $Row['late_fee_date'];	
	 
	 
 }
 
 $Late_Fee_date='15';


 $current_month=date('m');
 $current_month=$current_month-3;
 $LateFeeMonth=array();
 $date1 = date('d');
 
	 foreach($monthArray as $value){
	  if($value<$current_month){
	   $LateFeeMonth[]=$value;
	  }elseif($value==$current_month && $date1>$Late_Fee_date){
	   $current_month=$value;
	   $LateFeeMonth[]=$value;
	  }
	 }
 
	
	
	
   $no_of_LateFee_month= count($LateFeeMonth);
   if(!empty($no_of_LateFee_month)){
   $Late_fee=$Late_Fee_Amount*$no_of_LateFee_month;
   }else{
	 $Late_fee='';  
   }


$session=$_SESSION['session'];
//$qbill=mysqli_query($con,"select * from student_due_fees where student_due_fee_id='$id'");
//$rbill=mysqli_fetch_array($qbill);

$que1=mysqli_query($con,"select * from setting");
$res1=mysqli_fetch_array($que1);
$cname=$res1['company_name'];
$cadd=$res1['company_address'];
$cemail=$res1['company_email'];
$cno=$res1['company_number'];	
$clogo=$res1['company_image'];
$registration_number = $res1['registration_number'];
$affiliation_number = $res1['affiliation_number'];

// $qstu=mysqli_query($con,"select * from students where student_id='$stuid'");
$qstu=mysqli_query($con,"select `student_name`,`register_no`,`father_name`,`parent_no`,`sr`.`roll_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
$rstu=mysqli_fetch_array($qstu);
$father_name=$rstu['father_name'];
$stuname=$rstu['student_name'];
$stureg=$rstu['register_no'];
$parent_no=$rstu['parent_no'];
$roll_no=$rstu['roll_no'];
$stucls=$rstu['class_id'];
$qcls=mysqli_query($con,"select * from class where class_id='$stucls'");
$rcls=mysqli_fetch_array($qcls);
$class=$rcls['class_name'];

$stusecid=$rstu['section_id'];
$qsec=mysqli_query($con,"select * from section where section_id='$stusecid'");
$rsec=mysqli_fetch_array($qsec);
$section=$rsec['section_name'];

$Monthly_Query = mysqli_query($con,"select monthly_fee_due from student_due_fees where student_id='$stuid' && (status='0' || status='1') ORDER BY student_due_fee_id DESC LIMIT 1;");
	
	if($Monthly_Query->num_rows>0){	
	 $Monthly_Data=$Monthly_Query->fetch_assoc();
	 $monthly_fee_due =$Monthly_Data['monthly_fee_due'];
		
	}else{
		$monthly_fee_due=0;
	}

	function monthname($id,$con){	
		 $Query=$con->query("select * from months where fee_order_month IN ($id)");		
		if($Query->num_rows>0){	
		 while($MonthRow=$Query->fetch_assoc()){	
		 $Responce[]=$MonthRow['month_name'];		 	
		 }  		
		}	 		
		 if(!empty($Responce)){	
		 $Responce=implode(', ',$Responce);	
		 }			
		 return $Responce;	
     }
?>
<STYLE type="text/css" media="print">
		
				@media print 
				{
					
					#btn-hide{
						display:none;
					}	
					@page {
						 size: auto;   /* auto is the initial value */
							margin: 0mm; 
							margin-left:80px;
					}
					body{
						   padding-top: 32px;
							//padding-bottom: 30px 
					}
						 
				}
			
				p{
					color:#1c1515	
				}
</style>
<?php

//<!-- ------------------------print serial no---------------------------- -->
		$type='demand-fee';
		$key='DF';

		$sql1="select * from generate_certificate where certificate_type LIKE '$type'  order by id desc limit 1";
		$q2 = mysqli_query($con,$sql1);
		$r2 = mysqli_fetch_assoc($q2);
		$row2 = mysqli_num_rows($q2);	
		if($row2 > 0){
			$Count2 = substr($r2['certificate_no'], 2);  //return character after 3 words
	        if(is_numeric($Count2)){
	        	$count=ltrim($Count2,'0');  
	        }

			$recptno = $key.str_pad(intval($count)+1, 6 , "0", STR_PAD_LEFT);  //increment remove
			$no=mysqli_query($con,"INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno','$stuid', '".$_SESSION['session']."',now())");
			if(!$no){
						die("Error_description: ".mysqli_error($con));
			}
		}
		else
		{
			$recptno = $key."000001";
			$sql="INSERT INTO `generate_certificate`( `certificate_type`, `certificate_no`,`student_id`, `session`, `create_date`) VALUES ('$type','$recptno', '$stuid','".$_SESSION['session']."',now())";
			$no=mysqli_query($con,$sql);	
			if(!$no){
						die("Error_desc: ".mysqli_error($con));
			}
		}
		$recptno_sch=get_school_details()['company_short_name'].$recptno;
?>

<!-- ------------------------print serial no---------------------------- -->
				
							

<link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">

<body  onload="printDiv('printableArea')" >
<div class="container" id="printableArea">

	<div CLASS="LEFT" STYLE="width:45%;border:1px solid gray;padding-left:5px;display:inline-block;margin-left:15px;">
	<div class="row form-group">    
	<div style="margin-left:330px;"><small>Office Copy</small></div>     
	<div class="col-md-12"><h3><center>Demand Receipt</center></h3></div>
	</div>
	
	<!-- <div class="row form-group" style="margin-top:-30px;margin-bottom:-20px;">
	<div class="col-md-6"><p style="align:left;font-size:16px">Receipt Number : <?php echo $rid;?></p></div>
	<div class="col-md-6"><p style="font-size:16px;margin-left:30px">Date : <?php echo $edate;?></p></div>
	
	</div> -->
	<!-- <hr> -->
	<hr style="margin-bottom:6px;">
	<div class="row">
		  <div class="col-md-7">
		  	<span style="padding-left:16px;"> Sl no. :  <?=$recptno_sch?> </span>
		  </div>
		  <div class="col-md-5" align="right"  >
		    <span style="padding-right:16px;" >Date : <?=date('d-m-Y')?></span>
		  </div>
	</div>
	<hr style="margin-top:6px;">

	<div class="row form-group" style="margin-top:-10px;margin-bottom:-10px;">   
	<?php if(!empty($registration_number)){ ?>	
	<div class="col-md-6"><span class="text-center"><small>Registration Number : <?php echo $registration_number;?></small></span></div>	
	<?php } ?>	<?php if(!empty($affiliation_number)){ ?>
	<div class="col-md-6 "><span class="text-center"><small>Affiliation No. / UDISE Code : <?php echo $affiliation_number;?></small></span></div>	<?php } ?>
	<div class="col-md-8">
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;font-weight:bold"><?php echo $cname;?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Address : <?php echo $cadd; ?></p></div></div>
	<?php if(get_school_details()['show_number']=='1'){ ?>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Contact Number : <?php echo $cno; ?></p></div></div>
	<?php } ?>
	</div>
	<div class="col-md-4">
	<div class="row form-group">
		<div class="col-md-12"><img src="images/profile/<?php echo $clogo;?>" style="width:120px;height:120px;"></div></div>
	</div>
	</div>
	
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-20px;">
	<div class="col-md-12"><center><p style="font-size:18px;font-weight:bold">Student Details</p></center></div>
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-20px;">
	<div class="col-md-6 col-lg-6 col-sm-6"><p style="align:left;align:left;font-size:18px;">Name : <?php echo $stuname;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Admission Number : <?php echo $stureg;?></p></div>	
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Class : <?php echo $class;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Section : <?php echo $section;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Roll no. :<span>  <?=$roll_no?></span></p></div>
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-14px;margin-bottom:-25px;">
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px">Fees Particulars</p></center></div>
	</div>
		<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">				
		<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515"><b>Months :</b></p></div>	
		<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo monthname($month,$con);?></p></div>
	</div>	<hr>
	
		<?php
					$qfee1 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");
					$rfee1 = mysqli_fetch_array($qfee1);
					
						$feehead = $rfee1['fee_header_id'];
						$headarr = explode(',',$feehead);
						
						
						$feeamt = $rfee1['fee_amount'];
						$amtarr = explode(',',$feeamt);				
						$feeheadcount = sizeof($headarr);
						$tbal = 0;
						$tcurrent_due=0;
						for($i=0;$i<$feeheadcount;$i++)
						{
						
						$feeid = $headarr[$i];
						$feeamount = $amtarr[$i]; 								
						
						$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1')");
						$trecamt = 0;
						$tranamt = 0;
						$prevamt = 0;
						$no_of_paid_months=0;
						while($rfee2 = mysqli_fetch_array($qfee2))
						{
						
							$fhid = $rfee2['fee_header_id'];
							$fhidarr = explode(',',$fhid);
							
							$recamt = $rfee2['received_amount'];
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
						
						
							
							
							$baltranfee = $transamt - $tranamt;
							$balprevfee = $prevfees - $prevamt;
							 
						
						$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
						$r1 = mysqli_fetch_array($q1);
						$fheadname = $r1['fee_header_name'];
						$fheadtype = $r1['type'];
						if($fheadtype=='1'){
						$charge_type="Monthly";
						
                        $balfee = $feeamount;
						
						$tbalfee=$feeamount*$No_of_Month;
						
						}else{
						$charge_type="Yearly";
						$balfee = $feeamount- $trecamt;
                        $tbalfee=$balfee;
                        $current_due=$feeamount- $trecamt;						
						}
										
					?>
					
				
					<div class="row" style="margin-top:-14px;margin-bottom:-27px;">    
						<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515"><?php echo $fheadname;?> :</p></div>
						<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo $tbalfee;?></p></div>
						</div>
						<hr>
					
					
				
					<?php
					$tbal = $tbal + $tbalfee;
					$tcurrent_due=$tcurrent_due+$current_due;
				   }
					$totalbal = $tbal + $baltranfee + $balprevfee;
                    $tcurrent_due=$tcurrent_due+$baltranfee+$balprevfee;				
					?>
	
	

	
	<?php
	if(!empty($monthly_fee_due)){
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Previous Fees Due:</p></div>
	<div class="col-md-5"><p style="align:left;font-size:18px;"><?php echo $monthly_fee_due;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	<?php
	if(!empty($Late_fee)){
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Late Fees:</p></div>
	<div class="col-md-5"><p style="align:left;font-size:18px;"><?php echo $Late_fee;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515">Total :</p></div>
	<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo $tbal+intval($monthly_fee_due)+intval($Late_fee);?></p></div>
	</div>
	<hr>

	
	<?php
	
	$number = $tbal+$monthly_fee_due;
   $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';

	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;color:#1c1515">Amount In Words :</p></div>
	<div class="col-md-6"><p style="font-size:16px;color:#1c1515"><?php echo $result. "Rupees Only";?></p></div>
	</div>
	<hr>
	
	
	<div class="row" align="right">
	  <div class="col-md-12"><p style="margin-right:50px;font-size:20px;height:50px;">Signature</p></div>
	</div>
	<div class="row">
	  <div class="col-md-12"><footer><b>Note: </b><small>Dues paid before 15 per month, after 15 it will be charge late fine.   </small> </footer></div>
	</div>	
	</DIV>
	
	<DIV CLASS="LEFT" STYLE="width:45%;border:1px solid gray;padding-left:5px;float:left">
	<div class="row form-group">    
	<div style="margin-left:330px;"><small>Student Copy</small></div>   
	<div class="col-md-12"><h3><center>Demand Receipt</center></h3></div>
	</div>
	
	<!-- <div class="row form-group" style="margin-top:-30px;margin-bottom:-20px;">
	<div class="col-md-6"><p style="align:left;font-size:16px">Receipt Number : <?php echo $rid;?></p></div>
	<div class="col-md-6"><p style="font-size:16px;margin-left:30px">Date : <?php echo $edate;?></p></div>
	
	</div> -->
	<!-- <hr> -->
	<hr style="margin-bottom:6px;">
	<div class="row">
		  <div class="col-md-7">
		  	<span style="padding-left:16px;"> Sl no. :  <?=$recptno_sch;?> </span>
		  </div>
		    <div class="col-md-5" align="right"  >
		    	<span style="padding-right:16px;" >Date : <?=date('d-m-Y')?></span>
		  </div>
	</div>
	<hr style="margin-top:6px;">

	<div class="row form-group" style="margin-top:-10px;margin-bottom:-10px;">   
	<?php if(isset($registration_number)){ ?>	
	<div class="col-md-6"><span class="text-center"><small>Registration Number : <?php echo $registration_number;?></small></span></div>	<?php } ?>	
	<?php if(isset($affiliation_number)){ ?>	
	<div class="col-md-6 "><span class="text-center"><small>Affiliation No. / UDISE Code : <?php echo $affiliation_number;?></small></span></div>	<?php } ?>
	<div class="col-md-8">
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;font-weight:bold"><?php echo $cname;?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Address : <?php echo $cadd; ?></p></div></div>
	<?php if(get_school_details()['show_number']=='1'){ ?>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Contact Number : <?php echo $cno; ?></p></div></div>
	<?php }?>
	</div>
	<div class="col-md-4">
	<div class="row form-group">
		<div class="col-md-12"><img src="images/profile/<?php echo $clogo;?>" style="width:120px;height:120px;"></div></div>
	</div>
	</div>
	
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-20px;">
	<div class="col-md-12"><center><p style="font-size:18px;font-weight:bold">Student Details</p></center></div>
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-20px;">
	<div class="col-md-6 col-lg-6 col-sm-6"><p style="align:left;align:left;font-size:18px;">Name : <?php echo $stuname;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Admission Number : <?php echo $stureg;?></p></div>	
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Class : <?php echo $class;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Section : <?php echo $section;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Roll no. :<span>  <?=$roll_no?></span></p></div>
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-14px;margin-bottom:-25px;">
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px">Fees Particulars</p></center></div>
	</div>
		<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">				
		<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515"><b>Months :</b></p></div>	
		<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo monthname($month,$con);?></p></div>
	</div>	<hr>
	
		<?php
					$qfee1 = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");
					$rfee1 = mysqli_fetch_array($qfee1);
					
						$feehead = $rfee1['fee_header_id'];
						$headarr = explode(',',$feehead);
						
						
						$feeamt = $rfee1['fee_amount'];
						$amtarr = explode(',',$feeamt);				
						$feeheadcount = sizeof($headarr);
						$tbal = 0;
						$tcurrent_due=0;
						for($i=0;$i<$feeheadcount;$i++)
						{
						
						$feeid = $headarr[$i];
						$feeamount = $amtarr[$i]; 								
						
						$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1')");
						$trecamt = 0;
						$tranamt = 0;
						$prevamt = 0;
						$no_of_paid_months=0;
						while($rfee2 = mysqli_fetch_array($qfee2))
						{
						
							$fhid = $rfee2['fee_header_id'];
							$fhidarr = explode(',',$fhid);
							
							$recamt = $rfee2['received_amount'];
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
						
						
							
							
							$baltranfee = $transamt - $tranamt;
							$balprevfee = $prevfees - $prevamt;
							 
						
						$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
						$r1 = mysqli_fetch_array($q1);
						$fheadname = $r1['fee_header_name'];
						$fheadtype = $r1['type'];
						if($fheadtype=='1'){
						$charge_type="Monthly";
						
                        $balfee = $feeamount;
						
						$tbalfee=$feeamount*$No_of_Month;
						
						}else{
						$charge_type="Yearly";
						$balfee = $feeamount- $trecamt;
                        $tbalfee=$balfee;
                        $current_due=$feeamount- $trecamt;						
						}
										
					?>
					
				
					<div class="row" style="margin-top:-14px;margin-bottom:-27px;">    
						<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515"><?php echo $fheadname;?> :</p></div>
						<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo $tbalfee;?></p></div>
						</div>
						<hr>
					
					
				
					<?php
					$tbal = $tbal + $tbalfee;
					$tcurrent_due=$tcurrent_due+$current_due;
				   }
					$totalbal = $tbal + $baltranfee + $balprevfee;
                    $tcurrent_due=$tcurrent_due+$baltranfee+$balprevfee;				
					?>
	
	

	
	<?php
	if(!empty($monthly_fee_due)){
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Previous Fees Due:</p></div>
	<div class="col-md-5"><p style="align:left;font-size:18px;"><?php echo $monthly_fee_due;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	<?php
	if(!empty($Late_fee)){
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Late Fees:</p></div>
	<div class="col-md-5"><p style="align:left;font-size:18px;"><?php echo $Late_fee;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515">Total :</p></div>
	<?php
	$final_total= $tbal+intval($monthly_fee_due)+intval($Late_fee);
	?>
	<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo $final_total ;?></p></div>
	</div>
	<hr>

	
	<?php
	
	$number = $tbal+$monthly_fee_due;
   $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';

	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;color:#1c1515">Amount In Words :</p></div>
	<div class="col-md-6"><p style="font-size:16px;color:#1c1515"><?php echo $result. "Rupees Only";?></p></div>
	</div>
	<hr>
	
	
	<div class="row" align="right">
	  <div class="col-md-12"><p style="margin-right:50px;font-size:20px;height:50px;">Signature</p></div>
	</div>
	<div class="row">
	  <div class="col-md-12"><footer><b>Note: </b><small>Dues paid before 15 per month, after 15 it will be charge late fine.    </small></footer></div>
	</div>
</DIV>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<?php
//send demand fee notification---------------------------------------------
 
if($_REQUEST['notify']=='1'){
$company_name= get_school_details()['company_name'];	
$only_month=monthname($month,$con);
$only_year=getSessionByid($_SESSION['session'])['only_year'];

	$Wmessage="Dear Mr. ".$father_name.",%0aThis is to inform you that the school fee of ".$stuname." is due for the month of ".$only_month."-".$only_year.". You are requested  to avoid additional late fees.%0aThe total due amount is ".$final_total.".%0aRegards,%0a".$company_name."";
	$WNmessage="Dear Mr".$father_name.",<br>This is to inform you that the school fee of ".$stuname." is due for the month of ".$only_month."-".$only_year.". You are requested  to avoid additional late fees.<br>The total due amount is ".$final_total.".<br>Regards,<br>".$company_name."";

	$messagetype='demand-fee';

	$result = sendwhatsappMessage($parent_no, $Wmessage, $messagetype);
	 $nsql="insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$stuid','$class','$section',0,'$parent_no','$WNmessage','1','".$_SESSION['user_roles']."',now(),now(),'".$_SESSION['session']."')";
	$que2 = mysqli_query($con, $nsql);
	if($result){?>
		 <script>toastr.success('Notification sent Successfuly');
	<?php }


}

//send demand fee notification---------------------------------------------
?>

<input type="button" onclick="printDiv('printableArea')" class="btn btn-primary btn-md" value="Print" id="btn-hide" style="margin-left:470px;margin-top:15px;margin-bottom:15px;"/>


<a href="dashboard.php?option=view_payment&stuid=<?php echo $stuid?>" class="btn btn-primary" id="btn-hide" style="margin-left:20px;">Back</a>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

</script>
