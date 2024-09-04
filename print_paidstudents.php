<?php

error_reporting(1);

include('connection.php');

extract($_REQUEST);

$fromdt = $_REQUEST['fromdt'];

$chg_fdate = date("d-m-Y", strtotime($fromdt));

	

$todt = $_REQUEST['todt'];

$chg_tdate = date("d-m-Y", strtotime($todt));



	$class = $_REQUEST['class'];

	$c=mysqli_query($con,"select * from class where class_id='$class'");

	$rc=mysqli_fetch_array($c);

	$cls=$rc['class_name'];

	if($cls)

	{

		$clsn=$cls;

	}else

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

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

			a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1 and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class' and sr.section_id='$section' and sr.session='".$_SESSION['session']."' ";	

	

	// $search_result = filterTable($query);
// 
    }

	

	else if($class!="" and $section=="")

	{

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

			a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1 and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class' and sr.session='".$_SESSION['session']."' ";					

	// $search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

	a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1  and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.session='".$_SESSION['session']."' ";					

	// $search_result = filterTable($query);

    }
 	if(!empty($fromdt) && !empty($todt)){
 		$query.=" and date between '$fromdt' AND '$todt' ";
 	}
 	$query.=" order by sr.roll_no asc ";
	$search_result = filterTable($query);
	

// function to connect and execute the query

function filterTable($query){

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

   <form method="post" action="dashboard.php?option=paidstudents_report" enctype="multipart/form-data">      

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

						<!--table starts from here-->

						<div class="card">

                            <div class="card-body">

								<h3 align="center">Paid Students For The <?php echo $clsn; ?> for Section <?php echo $sec; ?> </h3>

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

											 <th>Receipt No</th>

											<?php

												$q1 = mysqli_query($con,"select * from fee_header");

												while($r1 = mysqli_fetch_array($q1))

												{

													$headid = $r1['fee_header_id'];

													$headidarr[] = $headid;

												?>

												 <th><?php echo $r1['fee_header_name'];?></th>

												<?php

												}

											?>

											 <th>Previous Fee Due</th>

											 <th>Total Fee</th>

											 <th>Total Discount</th>

											 <th>Total Paid</th>

											 <th>Total Due</th>

											 <th>Paid By</th>

											 <th>Challan No</th>

											 <th>Issued By</th>

											 <th>Issued Date</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;

									$gtotal = 0;

									$totaldiscount = 0;

									while($res1=mysqli_fetch_array($search_result))

									{									

										

									$stuid=$res1['student_id'];

									

									// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0' and session='".$_SESSION['session']."'");
									$sql1="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and student_id='$stuid' and sr.session='".$_SESSION['session']."'";
										$que2=mysqli_query($con,$sql1);

									if(mysqli_num_rows($que2)>0){

									while($res2=mysqli_fetch_array($que2))

									{

									

									$cid=$res2['class_id'];

									$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

									$rcls=mysqli_fetch_array($qcls);

									

									$sectid=$res2['section_id'];

									$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

									$rsec=mysqli_fetch_array($qsec);

									

									$sfh=$res1['fee_header_id'];

									$sfharr = explode(',',$sfh);	

									

									$sfee=$res1['received_amount'];

									$sfeearr = explode(',',$sfee);	



									$prevfeepaid=$res1['previous_amount'];

									$ptid=$res1['payment_type_id'];

									$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");

									$rptid=mysqli_fetch_array($qptid);

									$paidby=$rptid['payment_type_name'];

									

									$pdetail=$res1['payment_detail'];

									$issby=$res1['issued_by'];

									$issdt=$res1['issue_date'];	

									$chgedate = date('d-m-Y h:i:s',strtotime($issdt));



									$qtf = mysqli_query($con,"select * from assign_fee_class where class_id='$cid'  and session='".$_SESSION['session']."' ");

									$rtf = mysqli_fetch_array($qtf);

									$totalfee = $rtf['total_amount'];

									

									$qtd = mysqli_query($con,"select * from student_wise_fees where student_id='$stuid'  and session='".$_SESSION['session']."'");

									$rtd = mysqli_fetch_array($qtd);

									$totaldiscount = $rtd['discount_amount'];									

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res2['student_name']; ?></td>

										<td><?php echo $res2['register_no']; ?></td>

										<td><?php echo "Mr&nbsp;".$res2['father_name']; ?></td>

										<td><?php echo $res2['parent_no']; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>
										<td><?= ($res1['roll_no']) ? $res1['roll_no'] : '0' ; ?></td>

										<td><?php echo $res1['student_due_fee_id']; ?></td>

										

										<?php

										

										$tfee1 = 0;

										$tfee2 = 0;

										

										foreach($headidarr as $v)

										{

											$val = 0;

											if(in_array($v,$sfharr))

											{

												$pos = array_search($v,$sfharr);

												$val = $sfeearr[$pos];

												$tfee1 = $tfee1 + $val;

												if($val=="")

												{

													$val = 0;

												}

											}

										?>

												

										<td><?php echo $val; ?></td>

												

										<?php

											

										}

											$tfee2 = $tfee1 + $prevfeepaid;

										?>

										

										<td><?php echo $prevfeepaid; ?></td>

										<td><?php echo $totalfee; ?></td>

										<td><?php echo $totaldiscount; ?></td>

										<td><?php echo $tfee2; ?></td>

										<td><?php echo $res2['due']; ?></td>

										<td><?php echo $paidby;?></td>										

										<td><?php echo $pdetail;?></td>										

										<td><?php echo $issby;?></td>										

										<td><?php echo $chgedate;?></td>	

									</tr>

									

                                    <?php

									$sr++;									

										}}

										$gtotal = $gtotal + $tfee2;

										}

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						<div class="row">

						<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">

						<?php 

						if($fromdt!="" and $todt!="" and $class!="" and $section!="")

						{

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total paid amount from &nbsp; $chg_fdate &nbsp; to &nbsp;$chg_tdate &nbsp; from &nbsp; $clsn , $sec &nbsp;Section is : Rs $gtotal. </h5>";

						}

						else

						{

						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total paid amount for All Classes and All Sections is : Rs $gtotal. </h5>" ;	

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

		display: none;

				}

			}

		</style>

		

		

		<button id="printbtn" class="btn btn-primary btn-md" onclick="window.print();" style="margin-top:20px;">print</button>

		

		

		<a href="dashboard.php?option=paidstudents_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 