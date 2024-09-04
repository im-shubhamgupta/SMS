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

	$query="select a.student_id, a.trans_amount, a.previous_trans_amount, a.due_amount, 

			a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_trans_fee_id , a.status, b.student_id ,sr.roll_no

			from student_transport_due_fees as a join  students as b on a.student_id = b.student_id join student_records as sr  on a.student_id = sr.stu_id  

			where 1 

			 and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class' and sr.section_id='$section'";	

	

	// $search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select a.student_id, a.trans_amount, a.previous_trans_amount, a.due_amount, 

			a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_trans_fee_id , a.status, b.student_id ,sr.roll_no

			from student_transport_due_fees as a join  students as b on a.student_id = b.student_id join student_records as sr  on a.student_id = sr.stu_id  

			where 1 and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class'";					

	// $search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select a.student_id, a.trans_amount, a.previous_trans_amount, a.due_amount, 

			a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_trans_fee_id , a.status, b.student_id ,sr.roll_no

			from student_transport_due_fees as a join  students as b on a.student_id = b.student_id join student_records as sr  on a.student_id = sr.stu_id  

			where 1  and (a.status!='2' and a.status!='4') and b.stu_status='0'";					

	// $search_result = filterTable($query);

    }

    if(!empty($frontdt) && !empty($todt)){
    	$query.=" and date between '$fromdt' AND '$todt'";

    }

    $query.=" and sr.session='".$_SESSION['session']."' ";
    $query.=" order by sr.roll_no asc";

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

											 <th>Transport Fee</th>

											 <th>Previous Transport Fee</th>

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
									if(mysqli_num_rows($search_result)>0){

									while($res1=mysqli_fetch_array($search_result))

									{									

										

										$stuid=$res1['student_id'];

									

										// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0' and session='".$_SESSION['session']."'");
										$que2=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'");
										if(mysqli_num_rows($que2)>0){
										while($res2=mysqli_fetch_array($que2)){

									

										$cid=$res2['class_id'];

										$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

										$rcls=mysqli_fetch_array($qcls);

										

										$sectid=$res2['section_id'];

										$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

										$rsec=mysqli_fetch_array($qsec);

										

										$transfeepaid=$res1['trans_amount'];

										$prevfeepaid=$res1['previous_trans_amount'];

										

										$ptid=$res1['payment_type_id'];

										$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");

										$rptid=mysqli_fetch_array($qptid);

										$paidby=$rptid['payment_type_name'];

										

										$pdetail=$res1['payment_detail'];

										$issby=$res1['issued_by'];

										$issdt=$res1['issue_date'];	

										$chgedate = date('d-m-Y h:i:s',strtotime($issdt));	

										

										$qt = mysqli_query($con,"select * from student_route where student_id ='$stuid'");

										$rt= mysqli_fetch_array($qt);

										$transid = $rt['trans_id'];

										$totaldiscount = $rt['discount'];

										

										$qtd = mysqli_query($con,"select * from transports where trans_id ='$transid'");

										$rtd = mysqli_fetch_array($qtd);

										$transamt = $rtd['price'];

										

										$qp = mysqli_query($con,"select * from previous_transport_fees where student_id ='$stuid'");

										$rp = mysqli_fetch_array($qp);

										$prevamt = $rp['previous_transport_fees'];

										

										$totalfee = $transamt + $prevamt;

										

										$tfeepaid = $transfeepaid + $prevfeepaid;									

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res2['student_name']; ?></td>

										<td><?php echo $res2['register_no']; ?></td>

										<td><?php echo "Mr&nbsp;".$res2['father_name']; ?></td>

										<td><?php echo $res2['parent_no']; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>
										<td><?php echo ($res1['roll_no']) ? $res1['roll_no'] : '0'; ?></td>

										<td><?php echo $res1['student_trans_fee_id']; ?></td>

										<td><?php echo $transfeepaid; ?></td>

										<td><?php echo $prevfeepaid; ?></td>

										<td><?php echo $totalfee; ?></td>

										<td><?php echo $totaldiscount; ?></td>

										<td><?php echo $tfeepaid; ?></td>

										<td><?php echo $res1['due_amount'];; ?></td>

										<td><?php echo $paidby;?></td>										

										<td><?php echo $pdetail;?></td>										

										<td><?php echo $issby;?></td>										

										<td><?php echo $chgedate;?></td>	

									</tr>

									

                                    <?php

									$sr++;									

										}
									}
										$gtotal = $gtotal + $tfeepaid;

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

		

		

		<a href="dashboard.php?option=paid_transport_report" id="printbtn" class="btn btn-primary" style="margin-left:20px;margin-top:18px">Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->



 