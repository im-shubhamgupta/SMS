<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);



	$class = $_REQUEST['class'];

	$section = $_REQUEST['section'];

	$range = $_REQUEST['range'];

    $r1 = $_REQUEST['r1'];

    $r2 = $_REQUEST['r2'];

	

	$class = $_REQUEST['class'];

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

	

    $section = $_REQUEST['section'];

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

		


	
	if($range==1){
		$query.=" and a.due > 0 and a.due < '$r1' ";
	}elseif($range==2){
		$query.=" and a.due > '$r1' "; 
	}elseif($range==3){
		$query.=" and a.due between '$r1' and '$r2' "; 
	}
	$query.=" order by sr.roll_no asc ";
	$search_result = filterTable($query);



	

// function to connect and execute the query

function filterTable($query)

{

    include('connection.php');

    $filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}



?>



	<style>

	tr th{

		

		font-size:12px;

	}



	tr td{

		

		font-size:12px;

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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



<div id="right-panel" class="right-panel">

   <form method="post" action="dashboard.php?option=duestudents_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						

						$r=$range;

						if($r==1)

						{

								$show= "Less Than";

								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 </h3>" ;

								

						}

						else if($r==2)

						{

								$show= "Greater Than";

								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 </h3>" ;

						}

						else if($r==3)

						{

								$show= "Between";

								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec &nbsp; $show Rs: $r1 to $r2 </h3>" ;

						}

						else{

								echo "<h3 align='center'>Due Students Report for    $clsn ,Section $sec </h3>" ;

						

						}

						

						

						?>

						</div>						

						</div><br>

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

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

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						

							

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total Due amount for the Selected   $clsn ,Section $sec &nbsp; is : Rs $tdue </h5>" ;

						

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

		display: none;

				}

			}

		</style>

				

		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=duestudents_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 