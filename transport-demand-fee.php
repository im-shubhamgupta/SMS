<?php
include('connection.php');
extract($_REQUEST);
$stuid=$_REQUEST['student_id'];
$month=$_REQUEST['month'];
$session=$_SESSION['session'];
$monthArray= explode(',',$month);
$No_of_Month= count($monthArray);




 $current_month=date('m');
 $current_month=$current_month-3;
 $date1 = date('d');
 


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
$qstu=mysqli_query($con,"select `student_name`,`register_no`,`father_name`,`sr`.`roll_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where student_id='$stuid' && stu_status='0'  && `sr`.`session`='".$_SESSION['session']."'");
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

<style type="text/css" media="print">
		
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

				
</style>

<style>
	#printableArea p{
		color:#1c1515	
	}

</style>
		

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>  

<!-- ------------------------print serial no---------------------------- -->
<!-- no increment here only show receipt no -->
<?php
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

			$recptno = $key.str_pad(intval($count)+1, 6 , "0", STR_PAD_LEFT);  //increment removed
			
		}
		else
		{
			$recptno = $key."000001";
		}
		$recptno_sch=get_school_details()['company_short_name'].$recptno;
?>

<!-- ------------------------print serial no---------------------------- -->

<div class="container" id="printableArea">

   
  <div   CLASS="LEFT" STYLE="width:75%;border:1px solid gray;padding-left:8px;display:inline-block;margin-left:50px;">
	<div class="row form-group">   
	   <div class="col-md-12" style="margin-top:5px"><h3><center>Demand  Receipt</center></h3></div>
	</div>
	<hr style="margin-bottom:6px;">
	<div class="row">
		 
		  <div class="col-md-6">
		  	<span style="padding-left:16px;"> Sl no. :  <?=$recptno_sch?> </span>
		  </div>
		    <div class="col-md-6" align="right"  >
		    	<span style="padding-right:16px;" >Date : <?=date('d-m-Y')?></span>
		  </div>
	</div>
	
	<hr style="margin-top:6px;">
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-10px;">  
	<?php if(isset($registration_number)){ ?>	
	<div class="col-md-6"><span class="text-center"><small>Registration Number : <?php echo $registration_number;?></small></span></div>
	<?php } ?>	
	<?php if(isset($affiliation_number)){ ?>	
	<div class="col-md-6 text-center"><span class="text-center"><small>Affiliation No. / UDISE Code  : <?php echo $affiliation_number;?></small></span></div>
	<?php } ?>	   
	<div class="col-md-8">	
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;font-weight:bold;color:#1c1515"><?php echo $cname;?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;color:#1c1515">Address : <?php echo $cadd; ?></p></div></div>
<?php if(get_school_details()['show_number']=='1'){ ?>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;color:#1c1515">Contact Number : <?php echo $cno; ?></p></div></div>
<?php }?>
	</div>
	<div class="col-md-4">
	<div class="row form-group">
		<div class="col-md-12"><img src="images/profile/<?php echo $clogo;?>" style="width:120px;height:120px;color:#1c1515"></div></div>
	</div>
	</div>
	
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-20px;color:#1c1515">
	<div class="col-md-12"><center><p style="font-size:18px;font-weight:bold;color:#1c1515">Student Details</p></center></div>
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-20px;">
	<div class="col-md-6 col-lg-6 col-sm-6"><p style="align:left;align:left;font-size:18px;color:#1c1515">Name : <?php echo $stuname;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;color:#1c1515">Admission Number : <?php echo $stureg;?></p></div>	
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;color:#1c1515">Class : <?php echo $class;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;color:#1c1515">Section : <?php echo $section;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;color:#1c1515">Roll no. :<span>  <?=$roll_no?></span></p></div>
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-14px;margin-bottom:-25px;">
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px;color:#1c1515">Fees Particulars</p></center></div>
	</div>
	<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">				
		<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515"><b>Months :</b></p></div>	
		<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo monthname($month,$con);?></p></div>
	</div>	<hr>
	
		<?php
					$qfee1 = mysqli_query($con,"select * from student_transport_due_fees where student_id='$stuid' and session='$session'");
					$rfee1 = mysqli_fetch_array($qfee1);
					
					$PerMonthFee= $rfee1['trans_amount'];
					
					$TotalTranAmount= $PerMonthFee*$No_of_Month;
						
					?>

	
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;color:#1c1515">Total TransportFee :</p></div>
	<div class="col-md-5"><p style="align:left;font-size:18px;color:#1c1515"><?php echo $TotalTranAmount;?></p></div>
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
	  <div class="col-md-12"><p style="margin-right:50px;font-size:20px;height:50px;color:#1c1515">Signature</p></div>
  </div>

	
	</div>
	
</div>

	
   <!-- <input type="button" onclick="printDiv('printableArea')" class="btn btn-primary btn-md" value="Print" id="btn-hide" style="margin-left:350px;margin-top:15px;margin-bottom:15px;"/> -->
  <div class="row" STYLE="margin-top:15px;">
  	<div class="col-md-3" STYLE="margin-left:35px;">
  		 <a href="demand_print_fee.php?student_id=<?=$stuid?>&month=<?=$month?>&notify=0" target="_blank" name="print" value="Print" id="print" class="btn btn-info btn-md" style="margin-left:20px;">Print </a>
  	</div>
		   <!-- <div CLASS="LEFT" STYLE="padding:20px;margin-left:350px;"> -->
		   <div class="col-md-3">
				
			    <a href="demand_print_fee.php?student_id=<?=$stuid?>&month=<?=$month?>&notify=1" target="_blank" name="print" value="Print" id="print" class="btn btn-warning btn-md" style="margin-left:20px;">Print with Send notification </a>
			</div>
	</div>		
	

<br>
<br>

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

</script>
</script>