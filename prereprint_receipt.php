<?php
include('connection.php');
extract($_REQUEST);
$id=$_REQUEST['id'];
$session= $_SESSION['session'];
$qbill=mysqli_query($con,"select * from student_due_fees where student_due_fee_id='$id' AND session='$session'");
$rbill=mysqli_fetch_array($qbill);

$que1=mysqli_query($con,"select * from setting");
$res1=mysqli_fetch_array($que1);
$cname=$res1['company_name'];
$cadd=$res1['company_address'];
$cemail=$res1['company_email'];
$cno=$res1['company_number'];	
$clogo=$res1['company_image'];
$registration_number = $res1['registration_number'];
$affiliation_number = $res1['affiliation_number'];

$rid=$rbill['student_due_fee_id'];
$stuid=$rbill['student_id'];
$month=$rbill['month'];
// $qstu=mysqli_query($con,"select * from students where student_id='$stuid'");
$qstu=mysqli_query($con,"select `student_name`,`register_no`,`sr`.`roll_no`,`father_name`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
$rstu=mysqli_fetch_array($qstu);
$stuname=$rstu['student_name'];
$stureg=$rstu['register_no'];
$roll_no=$rstu['roll_no'];
$stucls=$rstu['class_id'];
$qcls=mysqli_query($con,"select * from class where class_id='$stucls'");
$rcls=mysqli_fetch_array($qcls);
$class=$rcls['class_name'];

$stusecid=$rstu['section_id'];
$qsec=mysqli_query($con,"select * from section where section_id='$stusecid'");
$rsec=mysqli_fetch_array($qsec);
$section=$rsec['section_name'];

$feehead = $rbill['fee_header_id'];
$feeharr = explode(',',$feehead);

$feeamt = $rbill['received_amount'];
$feeaarr = explode(',',$feeamt);


$array = array_combine($feeharr,$feeaarr);

$prevamt = $rbill['previous_amount'];

$Late_fees = $rbill['latefee'];

$due=$rbill['due_amount'];
$current_due=$rbill['current_due'];

$paid_month_due=$rbill['paid_month_due'];
$yealy_due=$rbill['yealy_due'];
$paid_month_due=$paid_month_due+$yealy_due;

$paidby=$rbill['paidby'];
$challan_no=$rbill['challan_no'];
$issued_by=$rbill['issued_by'];
$issued_date=$rbill['issue_date'];
$ndate = date('d-m-y h:i:s',strtotime($issued_date));
$edate = date('d-m-Y',strtotime($issued_date));

$currentdate=date("d-m-Y");



 $Query=mysqli_query($con,"select * from student_wise_fees where student_id='$stuid' AND session='$session'");
 $StudentWiseFee=mysqli_fetch_assoc($Query);
 
 $AssignFeeHeader= $StudentWiseFee['fee_header_id'];
 
 $FeeHeaderAmount= $StudentWiseFee['fee_amount'];
 
 
 $AssignFeeHeader=explode(',',$AssignFeeHeader);
 
 $FeeHeaderAmount=explode(',',$FeeHeaderAmount);
 
 





if(isset($print))
{
	$str = implode(',',$chkbox);

	echo "<script>window.location='reprint_receipt.php?id=$id&chk=$str'</script>";
	
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


<style>
	p{
		color:#1c1515	
	}

</style>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<div class="container">
<form method="post" enctype="multipart/form-data">
   
  <div CLASS="LEFT" STYLE="width:75%;border:1px solid gray;padding-left:8px;display:inline-block;margin-left:50px;">
	<div class="row form-group">   
	<div class="col-md-12" style="margin-top:5px"><h3><center>Payment Receipt</center></h3><hr></div>
	</div>
	
	<div class="row form-group" style="margin-top:-30px;margin-bottom:-20px;">
	<div class="col-md-7 col-lg-7 col-sm-7"><p style="align:left;font-size:16px">Receipt Number : <?=get_school_details()['company_short_name']?><?php echo $rid;?></p></div>
	<div class="col-md-5 col-lg-5 col-sm-5"><p style="font-size:16px;margin-left:30px">Date : <?php echo $edate;?></p></div>
	
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-10px;">   <?php if(isset($registration_number)){ ?>	<div class="col-md-6"><span class="text-center"><small>Registration Number : <?php echo $registration_number;?></small></span></div>	<?php } ?>	<?php if(isset($affiliation_number)){ ?>	<div class="col-md-6 text-center"><span class="text-center"><small>Affiliation No. / UDISE Code  : <?php echo $affiliation_number;?></small></span></div>	<?php } ?>	   
	<div class="col-md-8 col-lg-8 col-sm-8">	
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;font-weight:bold"><?php echo $cname;?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Address : <?php echo $cadd; ?></p></div></div>
	<?php if(get_school_details()['show_number']=='1'){?>
		<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Contact Number : <?php echo $cno; ?></p></div></div>
    <?php } ?>
	</div>
	<div class="col-md-4 col-lg-4 col-sm-4">
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
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px"><u>Fees Particulars</u></p></center></div>
	</div>
	<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">			
		<!-- <div class="col-md-4"></div>	 -->
	
		<div class="col-md-12"><center><p style="align:left;font-size:18px;">Months :  <?php echo monthname($month,$con);?></p></center></div>	
		<!-- <div class="col-md-3"><p style="align:left;font-size:18px;"><u><?php echo monthname($month,$con);?></p></u></div> -->
		<!-- <div class="col-md-4"></div>	 -->
	</div>	
	<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">    
	<div class="col-md-1 col-lg-6 col-sm-6"></p></div>
	<div class="col-md-5 col-lg-5 col-sm-5"><p style="align:left;font-size:18px;"><b>Headers</b></p></div>
	<div class="col-md-3 col-lg-3 col-sm-3"><p style="align:left;font-size:18px;"><b>Total</b></p></div>
		<div class="col-md-3 col-lg-3 col-sm-3"><p style="align:left;font-size:18px;"><b>Paid</b></p></div>
	</div>
	<hr>
	
	<?php
	$tfee = 0;

	foreach($AssignFeeHeader as $k)
	{
		$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
		$r1 = mysqli_fetch_array($q1);
		$hname = $r1['fee_header_name'];
		
		$AssignPos = array_search($k, $AssignFeeHeader);
		$AssignAmount = $FeeHeaderAmount[$AssignPos];
		
		$pos = array_search($k, $feeharr);
		$hamt = $feeaarr[$pos];
		
		$type = $r1['type'];

		if(!empty($hname) && !empty($hamt))
		{
		$tfee = (int)$tfee + (int)$hamt;
			
	?>	
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">    
	<div class="col-md-1 col-lg-1 col-sm-1"><input type="checkbox" name="chkbox[]" class="check" checked value="<?php echo $k;?>"/></div>
	<div class="col-md-5 col-lg-5 col-sm-5"><p style="align:left;font-size:18px;"><?php echo $hname;?> :</p></div>
	<div class="col-md-3 col-lg-3 col-sm-3"><p style="align:left;font-size:18px;"><?php echo $AssignAmount;?></p></div>
		<div class="col-md-3 col-lg-3 col-sm-3"><p style="align:left;font-size:18px;"><?php echo $hamt;?></p></div>
	</div>

	<!-- <hr> -->
	<!-- <div class="row" style="margin-top:-14px;margin-bottom:-27px;">    
	<div class="col-md-1"><input type="checkbox" name="chkbox[]" class="check" checked value="<?php echo $k;?>"/></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo 'Paid '.$hname;?> :</p></div>
	<div class="col-md-5"><p style="align:left;font-size:18px;"><?php echo $hamt;?></p></div>
	</div> -->
	<hr>
	<?php
		}
		
		$gfee = (int)$tfee + (int)$prevamt + (int)$transamt+(int)$Late_fees;
	}
	?>
	
	<?php
	if(!empty($prevamt))
		{
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-1 col-lg-1 col-sm-1"></div>
	<div class="col-md-5 col-lg-5 col-sm-5"><p style="align:left;font-size:18px;">Previous Fees Due:</p></div>
	<div class="col-md-3 col-lg-3 col-sm-3"><p style="align:left;font-size:18px;"><?php echo $prevamt;?></div>
	<div class="col-md-3 col-lg-3 col-sm-3"><p style="align:left;font-size:18px;"><?php echo $prevamt;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	<?php
	if(!empty($Late_fees))
		{
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-1 col-lg-1 col-sm-1"></div>
	<div class="col-md-5  col-lg-5 col-sm-5"><p style="align:left;font-size:18px;">Late Fees :</p></div>
	<div class="col-md-3 col-lg-3 col-sm-3"></div>
	<div class="col-md-3 col-lg-3 col-sm-3"><p style="align:left;font-size:18px;"><?php echo $Late_fees;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-1 col-lg-1 col-sm-1"></div>
	<div class="col-md-5  col-lg-5 col-sm-5"><p style="align:left;font-size:18px;"><b>Total Paid Amount </b>:</p></div>
	<div class="col-md-3 col-lg-3 col-sm-3"></div>
	<div class="col-md-3 col-lg-3 col-sm-3" ><p style="align:left;font-size:18px; "><b><?php echo $gfee;?></b></p></div>
	</div>
	<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-1 col-lg-1 col-sm-1"></div>
	<div class="col-md-5 col-lg-5 col-sm-5"><p style="align:left;font-size:20px;"><b>Due</b> :</p></div>
	<div class="col-md-3  col-lg-3 col-sm-3"></p></div>
	<div class="col-md-3  col-lg-3 col-sm-3"><p style="align:left;font-size:20px;"><b><?php echo $paid_month_due;?></b></p></div>
	</div>
	<hr>
	
	<!--
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued By :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $issued_by;?></p></div>
	</div>
	<hr>-->
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6  col-lg-6 col-sm-6"><p style="align:left;font-size:20px;">Issued Date :</p></div>
	<div class="col-md-6  col-lg-6 col-sm-6"><p style="align:left;font-size:20px;"><?php echo $ndate;?></p></div>
	</div>
	<hr>
	
	<?php
	$number = $gfee;
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
	<div class="col-md-6  col-lg-6 col-sm-6"><p style="align:left;font-size:20px;">Amount In Words :</p></div>
	<div class="col-md-6  col-lg-6 col-sm-6"><p style="font-size:16px;"><?php echo $result. "Rupees Only";?></p></div>
	</div>
	<hr>
	
	<div class="row" align="right">
	<div class="col-md-12"><p style="margin-right:50px;font-size:20px;height:50px;">Signature</p></div>
	</div>
	</DIV>


	<div CLASS="LEFT" STYLE="padding:20px;margin-left:350px;">
	
	<input type="submit" name="print" value="Print" id="print" class="btn btn-warning btn-md" style="margin-left:20px;"/>
	
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
</script>