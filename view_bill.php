<?php
error_reporting(1);
extract($_REQUEST);

if(isset($_POST['search']))
{
    $class = $_POST['class'];
    $section = $_POST['section'];
	
	if($class!="" and $section!="")
	{
    // search in all table columns

		$query = "SELECT * FROM `students` WHERE `class_id`='$class' and section_id='$section' and stu_status='0'";
		$search_result = filterTable($query);
    }
	else if($class!="" and $section=="")
	{
		$query = "SELECT * FROM `students` WHERE `class_id`='$class' and stu_status='0'";
		$search_result = filterTable($query);
	}	
	else
	{
	$query = "SELECT * FROM `students` where stu_status='0'";
    $search_result = filterTable($query);
	}
}

 else {
    $query = "SELECT * FROM `students` where stu_status='0'";
    $search_result = filterTable($query);
}
// function to connect and execute the query
function filterTable($query)
{
	include('connection.php');
    $filter_Result = mysqli_query($con, $query);
    return $filter_Result;
}


/*
if(isset($sms))
{
	$sset=mysqli_query($con,"select * from setting");
	$rsset=mysqli_fetch_array($sset);
	$sclname=$rsset['company_name'];
	
	$set=mysqli_query($con,"select * from sms_setting");
	$rset=mysqli_fetch_array($set);
	$senderid=$rset['sender_id'];
	$apiurl=$rset['api_url'];
	$apikey=$rset['api_key'];
	
$que=mysqli_query($con,"select * from students where stu_status='0'");
while($res1=mysqli_fetch_array($que))
{
$stuid=$res1['student_id'];
$stuname=$res1['student_name'];
$mobile=$res1['parent_no'];
	
$gender=$res1['gender'];
if($gender=="Female")
{
 $gen="Daughter";	
}
else
{
 $gen="Son";	
}

$fname=$res1['father_name'];
$tutdisc=$res1['tutionfee_disc'];
$transdisc=$res1['transfee_disc'];

$classid=$res1['class_id'];
$qfee=mysqli_query($con,"select * from fees where class_id='$classid'");
$rfee=mysqli_fetch_array($qfee);
$admfee=$rfee['admissionfees'];
$tufee=$rfee['tutionfees'];
$miscfee=$rfee['misfees'];

$transid=$res1['trans_id'];
$qtra=mysqli_query($con,"select * from transports where trans_id='$transid'");
$rtra=mysqli_fetch_array($qtra);
$transfee=$rtra['price'];

$total=$admfee+$tufee+$miscfee+$transfee-$tutdisc-$transdisc;

$qbill=mysqli_query($con,"select * from bill where student_id='$stuid'");

while($rbill=mysqli_fetch_array($qbill))
$paidadmfee=0;
$paidtutionfee=0;
$paidmiscfee=0;
$paidtransfee=0;
{
$paidadmfee+=$rbill['admfeepaid'];
$paidtutionfee+=$rbill['tutionfeepaid'];
$paidmiscfee+=$rbill['miscfeepaid'];
$paidtransfee+=$rbill['transfeepaid'];
}
$dueamount=$total-$paidadmfee-$paidtutionfee-$paidmiscfee-$paidtransfee;

		
	//Send sms to sender and reciever
	$senderId = "$senderid";
		$route = 4;
		$campaign = "OTP";
		$sms = array(
			'message' => "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." fees of Rs ".$dueamount." is Pending. Please pay the full or partial amount on or before within 10 days.%0a From,%0a".$sclname,
			'to' => array($mobile)
		);
		//Prepare you post parameters
		$postData = array(
			'sender' => $senderId,
			'campaign' => $campaign,
			'route' => $route,
			'sms' => array($sms)
		);
		$postDataJson = json_encode($postData);

		$url="$apiurl";

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "$url",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $postDataJson,
			CURLOPT_HTTPHEADER => array(
				"authkey:"."$apikey",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
	//Send sms to sender and reciever
	
}
}
*/
?>

	<style>
	tr th{
		
		font-size:11px;
	}

	tr td{
		
		font-size:11px;
	}

	</style>
	
<script type="text/javascript">
$(document).ready(function(){
    $(".menu a").each(function(){
        if($(this).hasClass("disabled")){
            $(this).removeAttr("href");
        }
    });
});
</script>
<div id="right-panel" class="right-panel">

<style>
.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
	margin-left:-18px;
	margin-top:-17px;
    background-color: #237791;
    border-radius: .25rem;
	font-size:19px;
}
.breadcrumb-item{
	color:#fff;
}
.breadcrumb-item .fa fa-home{
	color:#fff;
}
.breadcrumb-item.active {
    color: #eff7ff;
}
.breadcrumb-item+.breadcrumb-item::before {
    display: inline-block;
    padding-right: .5rem;
    color: #eff4f9;
    content: "/";
} 

</style>
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <span class="breadcrumb-item active">View Fees Section</span>
</nav>


   <form method="post" action="dashboard.php?option=view_bill" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
							
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                              
								<div class="row" style="margin-top:20px;">
								<div class="col-md-1" style="margin-left:10px;">Class</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
								<option selected="selected" disabled >---Select Class---</option>
								<?php
								$scls = "select * from class";
								$rcls = mysqli_query($con, $scls);
								while( $rescls = mysqli_fetch_array($rcls) ) {
								?>
								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								
								<div class="col-md-1" style="margin-left:50px;">Section</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select class="form-control" name="section" id="search_sect">
								<option value="" selected disabled>All</option>
								<?php
								$qsec=mysqli_query($con,"select * from section where class_id='$class'");
								while($rsec=mysqli_fetch_array($qsec))
								{
								$secname=$rsec['section_name'];
								?>
								<option <?php if($section==$rsec['section_id']){echo "selected";}?> value="<?php echo $rsec['section_id']; ?>"><?php echo $rsec['section_name'];?>
								</option>
								<?php 
								}
								?>	
								</select>
								<script>
								function search_sec(str)
								{
								var xmlhttp= new XMLHttpRequest();	
								xmlhttp.open("get","search_ajax_section.php?cls_id="+str,true);
								xmlhttp.send();
								xmlhttp.onreadystatechange=function()
								{
								if(xmlhttp.status==200  && xmlhttp.readyState==4)
								{
								document.getElementById("search_sect").innerHTML=xmlhttp.responseText;
								}
								} 
								}
								</script>
								
								</div>
								</div>
								
								<div class="col-md-1" style="margin-left:50px;">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
							    </div>
 
                            </div>
							
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Name</th>
											 <th>Reg No</th>
											 <th>Father Name</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Adm Fee</th>
											 <th>Tuition Fee</th>
											 <th>Misc Fee</th>
											 <th>Transport Fee</th>
											 <th>Tution Fee Discount</th>
											 <th>Transport Fee Discount</th>
											 <th>Total Paid Amount</th>
											 <th>Total Due</th>
											 <th>Generate EBill</th>
											 <th>View Payments</th>
											 <!--<th>Print</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									//$query=mysqli_query($con,"select * from students where stu_status='0'");
									while($res=mysqli_fetch_array($search_result))
									{
									$stuid=$res['student_id'];
									$regno=$res['register_no'];
									$date=$res['dob'];
									
									$tunfeesdisc=$res['tutionfee_disc'];
									$tranfeedisc=$res['transfee_disc'];
									
									$cid=$res['class_id'];
									$que1=mysqli_query($con,"select * from class where class_id='$cid'");
									$res1=mysqli_fetch_array($que1);
									
									$sectid=$res['section_id'];
									$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");
									$rsec=mysqli_fetch_array($qsec);
																		
									$que2=mysqli_query($con,"select * from fees where class_id='$cid'");
									$res2=mysqli_fetch_array($que2);
									$admfee=$res2['admissionfees'];
									$tunfee=$res2['tutionfees'];
									$miscfee=$res2['misfees'];
									
									$tid=$res['trans_id'];
									$que3=mysqli_query($con,"select * from transports where trans_id='$tid'");
									$res3=mysqli_fetch_array($que3);
									$price=$res3['price'];
									
									$chgdate=date("d-m-y", strtotime($date));
									
									$queb=mysqli_query($con,"select * from bill where student_id='$stuid'");
									$rowb=mysqli_num_rows($queb);
									$tpaidamt=0;
									$due=0;
									if($rowb)
									{
										while($resb=mysqli_fetch_array($queb))
										{
										$admfeepaid=$resb['admfeepaid'];
										$tutionfeepaid=$resb['tutionfeepaid'];
										$miscfeepaid=$resb['miscfeepaid'];
										$transfeepaid=$resb['transfeepaid'];
										
										$tpaidamt=$tpaidamt+$admfeepaid+$tutionfeepaid+$miscfeepaid+$transfeepaid;
										$due=$admfee+$tunfee+$miscfee+$price-$tunfeesdisc-$tranfeedisc-$tpaidamt;
										}
										
									}	
									else
									{
										$tpayble=$admfee+$tunfee+$miscfee+$price-$tunfeesdisc-$tranfeedisc;
										$tpaidamt=$tpaidamt;
										$due=$tpayble;
									}	
									
										
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo "Mr&nbsp;".$res['father_name']; ?></td>
										<td><?php echo $res1['class_name']; ?></td>
										<td><?php echo $rsec['section_name']; ?></td>
										<td><?php echo $admfee; ?></td>
										<td><?php echo $tunfee; ?></td>
										<td><?php echo $miscfee; ?></td>
										<td><?php echo $price; ?></td>
										<td><?php echo $tunfeesdisc; ?></td>
										<td><?php echo $tranfeedisc; ?></td>
										<td><?php echo $tpaidamt; ?></td>
										<td><?php echo $due; ?></td>										
										<td>
										<?php 
										if($due==0)
										{
										echo "<a href='dashboard.php?option=generate_bill&stuid=$stuid' style='color: #666;
        border-color:#666;' class='btn btn-outline-success btn-sm disabled' title='View all details of student.'>Generate Bill</a>";
										}
										else
										{
										echo "<a href='dashboard.php?option=generate_bill&stuid=$stuid' class='btn btn-outline-success btn-sm' title='Generate Bill'>Generate Bill</a>";
										}
										?>
																				
										</td>
										
										<!--<td>
										<?php echo "<a href='export_excel.php' class='btn btn-outline-success btn-sm' title='Download Excel'>Download to Excel</a>";?>
										</td>-->
										
										
										
										<td>
										<?php echo "<a href='dashboard.php?option=view_payment&stuid=$stuid' class='btn btn-outline-success btn-sm' title='View all Payment History'>Payment History</a>";?>
										</td>
										
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		<div style="text-align:center">
		<!--
		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		
		<a href="export_excel.php" class="btn btn-success" style="margin-left:20px;">Download To Excel</a> -->
		
		<!--<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>-->
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 