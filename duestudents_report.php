<?php

error_reporting(1);

extract($_REQUEST);

$count_row='';

if(isset($_POST['search']))

{
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

    $class = $_POST['class'];

    $section = $_POST['section'];

    $range = $_POST['range'];

    $r1 = $_POST['r1'];

	$r2 = $_POST['r2'];

        

	$class = $_POST['class'];

	$c=mysqli_query($con,"select * from class where class_id='$class'");

	$rc=mysqli_fetch_array($c);

	$cls=$rc['class_name'];

	if($cls)

	{

		$clsn=$cls;

	}

	else

	{

		$clsn='Class All';

	}

	

    $section = $_POST['section'];

    $s=mysqli_query($con,"select * from section where section_id='$section'");

	$rs=mysqli_fetch_array($s);

	$se=$rs['section_name'];

	if($se)

	{

		$sec=$se;

	}else

	{

		$sec='All';

	}


		if($class!="" and $section!="")

		{

		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.status,sr.roll_no

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where and sr.class_id='$class' and sr.section_id='$section' and sr.session='".$_SESSION['session']."' ";			


		}		

		else if($class!="" and $section==""){

		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date, b.status,sr.roll_no

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where sr.class_id='$class'  and sr.session='".$_SESSION['session']."' ";					

	

		}	

		else if($class=="" and $section==""){
		$query="select a.student_id, a.student_name, a.register_no, a.father_name, a.parent_no, sr.class_id, sr.section_id, a.due,

				b.student_id, b.received_amount, b.transport_amount, b.due_amount, b.issue_date,sr.roll_no

				from students a

				LEFT JOIN student_due_fees b ON a.student_id = b.student_id and a.due = b.due_amount   join student_records as sr on  b.student_id = sr.stu_id 

				where 1   and sr.session='".$_SESSION['session']."' ";

	

		}

	// }
	if($range==1){
		$query.=" and a.due > 0 and a.due < '$r1' ";
	}elseif($range==2){
		$query.=" and a.due > '$r1' "; 
	}elseif($range==3){
		$query.=" and a.due between '$r1' and '$r2' "; 
	}
	$search_result = filterTable($query);
	$query.=" order by sr.roll_no asc ";
	$count_row=mysqli_num_rows($search_result);
	// echo "classid: ".$cls_id=$class;

}

	

// function to connect and execute the query

function filterTable($query){

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



?>



<!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- --->

<?php

if(isset($sms))

{
	$count_total=$_POST['count_total']; 
	// echo $;
	// echo "hello";die;

	// $qs1=mysqli_query($con,"select * from sms_setting where sms_id='2' ");

	// $rs1=mysqli_fetch_array($qs1);

	// $status=$rs1['status'];

	// if($status==1)
	$Wcount=get_whatsapp_sms_count()['count_sms'];
	$Wstatus=get_whatsapp_sms_setting()['status'];

	if(!($Wcount >= $count_total)){

		echo "<script>alert('!!! Insufficient SMS Limit !!!')</script>";	
	

	}elseif($Wstatus!=1){
		echo "<script>alert('No Permission to send SMS')</script>";	

	}else{

		echo "<script>window.location='send_sms_duestudents.php?class=$class&section=$section&range=$range&r1=$r1&r2=$r2'</script>";

	}



}



?>



<!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- --->



<style>

	tr th{

		

		font-size:11px;

	}



	tr td{

		

		font-size:11px;

	}



</style>

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Report Panel</a>

  <a class="breadcrumb-item" href="#">Fee Report</a>

  <span class="breadcrumb-item active">Due Student Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=duestudents_report" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

                        <div class="row" style="margin-top:20px;">

								

								<div class="col-md-1" style="margin-left:20px;">Class</div>

								<div class="col-md-3" style="margin-top:-8px;">

								<select name="class" class="form-control" onchange="search_sec(this.value)">

								<option value="" selected="selected">All</option>

								<?php

								$scls = "select * from class";

								$rcls = mysqli_query($con, $scls);

								while( $rescls = mysqli_fetch_array($rcls) ) {

								?>

								<option <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								

								<div class="col-md-1" style="font-size:14px;">Section </div>

								<div class="col-md-3" style="margin-top:-8px;">

								<select class="form-control" name="section" id="search_sect">

								<option value="" selected="selected" disabled>All</option>

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

								xmlhttp.open("get","search_ajax_section_without_all.php?cls_id="+str,true);

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
								<div class="col-md-2">

								<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:30px;" value="Submit"><br><br>

								</div>

								

								<!--<div class="col-md-2" style="font-size:14px;margin-left:20px;">Next Payment</div>

								<div class="col-md-2" style="margin-top:-8px;">

								<select name="nextpay" class="form-control">

								<option value="" selected="selected">All</option>

								<?php

								$smon = "select * from months";

								$rmon = mysqli_query($con, $smon);

								while( $resmon = mysqli_fetch_array($rmon) ) {

								?>

								<option <?php if($nextpay==$resmon['month_id']){echo "selected";}?> value="<?php echo $resmon['month_id']; ?>"><?php echo $resmon['month_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>-->

								

							

						</div>
						<span><small><u>(optional filters)</u> </small></span>

						

						<div class="row" style="margin-top:20px;">	

						

								<div class="col-md-1" style="margin-left:20px;">Range</div>

								<div class="col-md-3" style="margin-top:-8px;">

								<select name="range" id="range" class="form-control"   onchange="disableTxt()">

								<option value="" selected="selected" disabled>Select Range</option>

								<option <?php if($range=="1"){echo "selected";}?> value="1">Less than</option>

								<option <?php if($range=="2"){echo "selected";}?> value="2">Greater than</option>

								<option <?php if($range=="3"){echo "selected";}?> value="3">Between</option>

								</select>

								</div>
								<input type="hidden" name="count_total" value="<?=$count_row?>">
								<script>

								function disableTxt(){ 

								var chk=document.getElementById("range").value;

								if(chk==3)

								{

								  document.getElementById("range1").disabled = false;

								  

								}

								else

								{

								  document.getElementById("range1").disabled = true;

								  document.getElementById("range1").value = "";

								}

								}



								</script>

								<div class="col-md-2" style="margin-top:-8px;">

								<input type="number" name="r1" class="form-control" value="<?php echo $r1;?>" >

								</div>

								

								<div class="col-md-2" style="margin-top:-8px;">

								<input type="number" name="r2" class="form-control" value="<?php echo $r2;?>" id="range1" <?php if($range!="3")echo "disabled";?>>

								</div>
							

						</div><br>

						

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Name</th>

											 <th>Reg No</th>

											 <th>Father Name</th>

											 <th>Parent Contact</th>

											 <th>Class</th>

											 <th>Section</th>
											 <th>Roll no.</th>

											<?php

												$q1 = mysqli_query($con,"select * from fee_header");

												while($re1 = mysqli_fetch_array($q1))

												{

													$headid = $re1['fee_header_id'];

													$headidarr[] = $headid;

												?>

												 <th><?php echo $re1['fee_header_name'];?></th>

												<?php

												}

											?>

											 <th>Previous Fee Due</th>

											 <th>Total Fee</th>

											 <th>Total Discount</th>

											 <th>Total Paid</th>

											 <th>Total Due</th>

											 <th>Last Paid Date</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									if(isset($search))

									{

									$sr=1;

									while($res=mysqli_fetch_array($search_result))

									{

										$stuid=$res['student_id'];

										$stuname=$res['student_name'];

										$regno=$res['register_no'];

										$fname=$res['father_name'];

										$parentno=$res['parent_no'];

										$due=$res['due'];

																																													

										$cid=$res['class_id'];

										$que1=mysqli_query($con,"select * from class where class_id='$cid'");

										$res1=mysqli_fetch_array($que1);

										

										$sectid=$res['section_id'];

										$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

										$rsec=mysqli_fetch_array($qsec);

																													

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $regno; ?></td>

										<td><?php echo "Mr&nbsp;".$fname; ?></td>

										<td><?php echo $parentno; ?></td>

										<td><?php echo $res1['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>
										<td><?= ($res['roll_no']) ? $res['roll_no'] : '0' ; ?></td>
										

									<?php

									

										$qbill=mysqli_query($con,"select * from student_due_fees where student_id='$stuid' and status='0' || status='1' || status='3'");

										$rowbill=mysqli_num_rows($qbill);

											

											if($rowbill)

											{	

												$tpaidamt1 = 0;

												$prev = 0;

												

												while($b=mysqli_fetch_array($qbill))	

												{	

												$recdamt=$b['received_amount'];

												$arr = explode(',',$recdamt);

		

												$prevamt=$b['previous_amount'];

												

												foreach($arr as $k)

												{

												 $tpaidamt1 = $tpaidamt1 + $k;

												}

												

												

												$prev = $prev + $prevamt;

												$tpaidamt = $tpaidamt1 + $prev;

												$issdt=$res['issue_date'];

												$chgdate = date('d-m-y h:i:s',strtotime($issdt));

												}

																					

											}

											else

											{

												$tpaidamt = 0;

												$chgdate="";

											}

									

										$qtf = mysqli_query($con,"select * from assign_fee_class where class_id='$cid'");

										$rtf = mysqli_fetch_array($qtf);

										$totalfee = $rtf['total_amount'];

										$feestr1 = $rtf['fee_header_id'];

										$feearr1 = explode(',',$feestr1);

										

										$feeamt = $rtf['fee_header_amount'];

										$feeamtarr = explode(',',$feeamt);

										

										$qtd = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'");

										$rtd = mysqli_fetch_array($qtd);

										$totaldiscount = $rtd['discount_amount'];

										

										foreach($headidarr as $k)

										{

																					

											$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' and status='0' || status='1' || status='3'");

											$val = 0;

											$prevamt = 0;

											while($rfee2 = mysqli_fetch_array($qfee2))

											{

												$fhid=$rfee2['fee_header_id'];

												$fhidarr = explode(',',$fhid);

												

												$recdamt=$rfee2['received_amount'];

												$recdarr = explode(',',$recdamt);

											

												if(in_array($k,$fhidarr))

												{

													$pos = array_search($k,$fhidarr);

													$val += $recdarr[$pos];	

													

													$apos = array_search($k,$feearr1);

													$famt = $feeamtarr[$apos];	

													

													$balfee = $famt - $val;

												}

												else

												{

													$balfee = 0;

												}

													

												$prevamt = $prevamt+$rfee2['previous_amount'];

											}

										

									?>

										<td><?php echo $balfee; ?></td>

									<?php

										}									

									?>

										<td><?php echo $prevamt; ?></td>

										<td><?php echo $totalfee; ?></td>

										<td><?php echo $totaldiscount; ?></td>

										<td><?php echo $tpaidamt;?></td>								

										<td><?php echo $due;?></td>								

										<td><?php echo $chgdate;?></td>																

									</tr>

									

                                    <?php

									$sr++;	

									$tdue = $tdue + $due; 

									}

									}

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						

							

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						if(isset($search))

						{

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Due amount for the Selected  $clsn, Section $sec &nbsp;is : Rs $tdue </h5>" ;

						}

						?>

						</div>						

						</div><br>

						

						

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

		

		<div style="text-align:center">

		<style>

			

		@media print{

		#printbtn{

		display: block;

				}

			}

		</style>

		

		<button type="submit" name="sms" onclick="return confirm('Do you want to send sms.')" id="add" class="btn btn-primary btn-sm"/><i class="fa fa-envelope"></i> Send SMS </button>
		<!-- <button type="submit" name="sms" onclick="send_sms()" id="add" class="btn btn-primary btn-sm"/><i class="fa fa-envelope"></i> Send SMS </button> -->

		

		<a href="print_duestudents.php?class=<?php echo $class;?>&section=<?php echo $section;?>&range=<?php echo $range;?>&r1=<?php echo $r1;?>&r2=<?php echo $r2;?>" target="_blank" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>

		

		<a href="export_duestudent_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&range=<?php echo $range;?>&r1=<?php echo $r1;?>&r2=<?php echo $r2;?>" class="btn btn-success btn-sm" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>

		

		<a href="dashboard.php?option=duestudents_report" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class='fa fa-arrow-left'> </i> Back</a>

		

		</div>

		

	</form>	
	<script>
		// function send_sms(){
		// 	// alert(1);
		// 	var Wcount="<?=get_whatsapp_sms_count()['count_sms']?>";
		// 	var Wstatus="<?=get_whatsapp_sms_setting()['status']?>";

		// 	var count ="<?=$count_row?>";

		// 	// if(!(Wcount >= count)){

		// 	// 	alert('!!! Insufficient SMS Limit !!!');
		// 	// }else if(Wstatus!=1){
		// 	//     alert('No Permission to send SMS');

		// 	// }else{
		// 	// alert('<?php echo $class;?>');
		// 		// window.location='send_sms_duestudents.php?class=<?=$class?>&section=<?=$section?>&range=<?=$range?>&r1=<?=$r1?>&r2=<?=$r2?>';
		// 		window.location='send_sms_duestudents.php';

	    //     // }


		// }
	</script>

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>