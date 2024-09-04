<?php
include('connection.php');
extract($_REQUEST);
$id=$_REQUEST['id'];
$qbill=mysqli_query($con,"select * from student_due_fees where student_due_fee_id='$id'");
$rbill=mysqli_fetch_array($qbill);

$que1=mysqli_query($con,"select * from setting");
$res1=mysqli_fetch_array($que1);
$cname=$res1['company_name'];
$cadd=$res1['company_address'];
$cemail=$res1['company_email'];
$cno=$res1['company_number'];	
$clogo=$res1['company_image'];

$rid=$rbill['student_due_fee_id'];
$stuid=$rbill['student_id'];
$qstu=mysqli_query($con,"select * from students where student_id='$stuid'");
$rstu=mysqli_fetch_array($qstu);
$stuname=$rstu['student_name'];
$stureg=$rstu['register_no'];
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

//$transamt = $rbill['transport_amount'];

$due=$rbill['due_amount'];
$paidby=$rbill['paidby'];
$challan_no=$rbill['challan_no'];
$issued_by=$rbill['issued_by'];
$issued_date=$rbill['issue_date'];
$ndate = date('d-m-y h:i:s',strtotime($issued_date));
$edate = date('d-m-Y',strtotime($issued_date));

$currentdate=date("d-m-Y");

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
							
</STYLE>

<link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">

<div class="container" id="printableArea">

	<div CLASS="LEFT" STYLE="width:45%;border:1px solid gray;padding-left:8px;display:inline-block;margin-left:15px;">
	<div class="row form-group">
	<div style="margin-left:380px;"><small>Office Copy</small></div>
	<div class="col-md-12" style="margin-top:5px"><h3><center>Payment Receipt</center></h3><hr></div>
	</div>
	
	<div class="row form-group" style="margin-top:-30px;margin-bottom:-20px;">
	<div class="col-md-6"><p style="align:left;font-size:16px">Receipt Number : <?php echo $rid;?></p></div>
	<div class="col-md-6"><p style="font-size:16px;margin-left:30px">Date : <?php echo $edate;?></p></div>
	
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-10px;">
	<div class="col-md-8">
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;font-weight:bold">Institute Name : <?php echo $cname;?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Address : <?php echo $cadd; ?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Contact Number : <?php echo $cno; ?></p></div></div>
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
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-14px;margin-bottom:-25px;">
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px">Fees Particulars</p></center></div>
	</div>
	<hr>
	
	<?php
	$tfee = 0;
	foreach($array as $k=>$v)
	{
		if(!empty($v))
		{	
		$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
		$r1 = mysqli_fetch_array($q1);
		$hname = $r1['fee_header_name'];
		
		$tfee = $tfee + $v;
			
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $hname;?> :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $v;?></p></div>
	</div>
	<hr>
	<?php
		}
		
		$gfee = $tfee + $prevamt + $transamt;
	}
	?>
	
	<?php
	if(!empty($prevamt))
		{
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Previous Fees Due:</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $prevamt;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	<!--<?php
	if(!empty($transamt))
		{
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Transport Fees :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $transamt;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>-->
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Total :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $gfee;?></p></div>
	</div>
	<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Due :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $due;?></p></div>
	</div>
	<hr>
	
	<!--
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued By :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $issued_by;?></p></div>
	</div>
	<hr>-->
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued Date :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $ndate;?></p></div>
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
	<div class="col-md-6"><p style="align:left;font-size:20px;">Amount In Words :</p></div>
	<div class="col-md-6"><p style="font-size:16px;"><?php echo $result. "Rupees Only";?></p></div>
	</div>
	<hr>
	
	<div class="row" align="right">
	<div class="col-md-12"><p style="margin-right:50px;font-size:20px;height:50px;">Signature</p></div>
	</div>
	</DIV>
	
	<DIV CLASS="LEFT" STYLE="width:45%;border:1px solid gray;padding-left:5px;float:left">
	<div class="row form-group">
	<div style="margin-left:380px;"><small>Student Copy</small></div>
	<div class="col-md-12" style="margin-top:5px"><h3><center>Payment Receipt</center></h3><hr></div>
	</div>
	
	<div class="row form-group" style="margin-top:-30px;margin-bottom:-20px;">
	<div class="col-md-6"><p style="align:left;font-size:16px">Receipt Number : <?php echo $rid;?></p></div>
	<div class="col-md-6"><p style="font-size:16px;margin-left:30px">Date : <?php echo $edate;?></p></div>
	
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-10px;margin-bottom:-10px;">
	<div class="col-md-8">
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;font-weight:bold">Institute Name : <?php echo $cname;?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Address : <?php echo $cadd; ?></p></div></div>
	<div class="row"><div class="col-md-12"><p style="align:left;font-size:18px;">Contact Number : <?php echo $cno; ?></p></div></div>
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
	</div>
	<hr>
	<div class="row form-group" style="margin-top:-14px;margin-bottom:-25px;">
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px">Fees Particulars</p></center></div>
	</div>
	<hr>
	
	<?php
	$tfee = 0;
	foreach($array as $k=>$v)
	{
		if(!empty($v))
		{
		$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
		$r1 = mysqli_fetch_array($q1);
		$hname = $r1['fee_header_name'];
		
		$tfee = $tfee + $v;
		
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $hname;?> :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $v;?></p></div>
	</div>
	<hr>
	
	<?php
		}
		
		$gfee = $tfee + $prevamt;
	}
	?>
	
	<?php
	if(!empty($prevamt))
		{
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Previous Fees Due:</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $prevamt;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	<!--<?php
	if(!empty($transamt))
		{
	?>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Transport Fees :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $transamt;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>-->
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Total :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $gfee;?></p></div>
	</div>
	<hr>
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Due :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $due;?></p></div>
	</div>
	<hr>
	<!--
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued By :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $issued_by;?></p></div>
	</div>
	<hr>-->
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued Date :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $ndate;?></p></div>
	</div>
	<hr>
	
	<div class="row" style="margin-top:-14px;margin-bottom:-27px;">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Amount In Words :</p></div>
	<div class="col-md-6"><p style="font-size:16px;"><?php echo $result. "Rupees Only";?></p></div>
	</div>
	<hr>
	
	<div class="row" align="right">
	<div class="col-md-12"><p style="margin-right:50px;font-size:20px;height:50px;">Signature</p></div>
	</div>
</DIV>



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
