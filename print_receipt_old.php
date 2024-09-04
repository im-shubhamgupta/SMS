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

$que2=mysqli_query($con,"select * from student_due_fees where student_due_fee_id='$id'");
$res2=mysqli_fetch_array($que2);
$feehead = $res2['fee_header_id'];
$feeharr = explode(',',$feehead);

$feeamt = $res2['received_amount'];
$feeaarr = explode(',',$feeamt);
$array = array_combine($feeharr,$feeaarr);

$prevamt = $res2['previous_amount'];

$transamt = $res2['transport_amount'];

$due=$res2['due_amount'];
$paidby=$res2['paidby'];
$challan_no=$res2['challan_no'];
$issued_by=$res2['issued_by'];
$issued_date=$res2['issue_date'];
$ndate = date('d-m-y h:i:s',strtotime($issued_date));

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
							margin-left:85px;
					}
					body{
						   padding-top: 32px;
							//padding-bottom: 30px 
					}
						 
				}		
					
</STYLE>

<link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">

<div class="container" id="printableArea">

	<DIV CLASS="LEFT" STYLE="width:45%;border:1px solid gray;padding-left:8px;display:inline-block;margin-left:15px;">
	<div class="row form-group">
	<div class="col-md-12" style="margin-top:50px"><h3><center>Payment Receipt</center></h3><hr></div>
	</div>
	
	<div class="row form-group">
	<div class="col-md-6"><p style="align:left;font-size:16px">Receipt Number : <?php echo $stuid;?></p></div>
	<div class="col-md-6"><p style="font-size:16px;margin-left:30px">Print Date : <?php echo $currentdate;?></p></div>
	
	</div>
	<hr>
	<div class="row form-group">
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
	
	<div class="row form-group">
	<div class="col-md-12"><center><p style="font-size:18px;font-weight:bold">Student Details</p></center></div>
	</div>
	<hr>
	<div class="row form-group">
	<div class="col-md-6 col-lg-6 col-sm-6"><p style="align:left;align:left;font-size:18px;">Name : <?php echo $stuname;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Register Number : <?php echo $stureg;?></p></div>	
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Class : <?php echo $class;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Section : <?php echo $section;?></p></div>
	</div>
	<hr>
	
	<div class="row form-group">
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px">Summary of Bill</p></center></div>
	</div>
	<hr>
	
	<?php
	$tfee = 0;
	foreach($array as $k=>$v)
	{
		$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
		$r1 = mysqli_fetch_array($q1);
		$hname = $r1['fee_header_name'];
		
		$tfee = $tfee + $v;
		$gfee = $tfee + $transamt;
	?>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $hname;?> :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $v;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Previous Fees Due:</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $prevamt;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Transport Fees :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $transamt;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Total :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $gfee;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Due :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $due;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued By :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $issued_by;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued Date :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $ndate;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;height:50px;">Signature :</p></div>
	
	</div>
	
	</DIV>
	
	<DIV CLASS="LEFT" STYLE="width:45%;border:1px solid gray;padding-left:5px;float:left">
	<div class="row form-group">
	<div class="col-md-12" style="margin-top:50px"><h3><center>Payment Receipt</center></h3><hr></div>
	</div>
	
	<div class="row form-group">
	<div class="col-md-6"><p style="align:left;font-size:16px">Receipt Number : <?php echo $stuid;?></p></div>
	<div class="col-md-6"><p style="font-size:16px;margin-left:30px">Print Date : <?php echo $currentdate;?></p></div>
	
	</div>
	<hr>
	<div class="row form-group">
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
	
	<div class="row form-group">
	<div class="col-md-12"><center><p style="font-size:18px;font-weight:bold">Student Details</p></center></div>
	</div>
	<hr>
	<div class="row form-group">
	<div class="col-md-6 col-lg-6 col-sm-6"><p style="align:left;align:left;font-size:18px;">Name : <?php echo $stuname;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Register Number : <?php echo $stureg;?></p></div>	
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Class : <?php echo $class;?></p></div>
	<div class="col-md-6 col-sm-6 col-lg-6"><p style="align:left;align:left;font-size:18px;">Section : <?php echo $section;?></p></div>
	</div>
	<hr>
	<div class="row form-group">
	<div class="col-md-12"><center><p style="font-weight:bold;font-size:18px">Summary of Bill</p></center></div>
	</div>
	<hr>
	
	<?php
	$tfee = 0;
	foreach($array as $k=>$v)
	{
		$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
		$r1 = mysqli_fetch_array($q1);
		$hname = $r1['fee_header_name'];
		
		$tfee = $tfee + $v;
		$gfee = $tfee + $transamt;
	?>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $hname;?> :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $v;?></p></div>
	</div>
	<hr>
	<?php
	}
	?>
	
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Previous Fees Due:</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $prevamt;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Transport Fees :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $transamt;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:18px;">Total :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:18px;"><?php echo $gfee;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Due :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $due;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued By :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $issued_by;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;">Issued Date :</p></div>
	<div class="col-md-6"><p style="align:left;font-size:20px;"><?php echo $ndate;?></p></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6"><p style="align:left;font-size:20px;height:50px;">Signature :</p></div>
	
	</div>
</DIV>



<input type="button" onclick="printDiv('printableArea')" class="btn btn-primary btn-md" value="Print" id="btn-hide" style="margin-left:470px;margin-top:15px;margin-bottom:15px;"/>


<a href="dashboard.php?option=generate_bill&stuid=<?php echo $stuid?>" class="btn btn-primary" id="btn-hide" style="margin-left:20px;">Back</a>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

</script>
