<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search'])){

	$fromdt1 = $_POST['fromdt'];
	if(!empty($fromdt1)){
			$chg_fdate = date("d-m-Y", strtotime($fromdt1));
	}else{
			$chg_fdate ='';
	}

    $todt1 = $_POST['todt'];

    if(!empty($todt1)){
		$chg_tdate = date("d-m-Y", strtotime($todt1));
	}else{
		$chg_tdate ='';
	}

	

    $class = $_POST['class'];

	$c=mysqli_query($con,"select * from class where class_id='$class'");

	$rc=mysqli_fetch_array($c);

	$cls=$rc['class_name'];

	if($cls){

		$clsn=$cls;

	}else{

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

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

			a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1 and
			 (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class' and sr.section_id='$section'  and sr.session='".$_SESSION['session']."' ";	

	// $search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="")

	{

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no from
	student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 
	  where 1  and (a.status!='2' and a.status!='4') and b.stu_status='0' and sr.class_id='$class' and sr.session='".$_SESSION['session']."' ";					

	// $search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="")

	{

	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, 

			a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.student_due_fee_id, a.status, b.student_id ,sr.roll_no

			from student_due_fees as a join students as b on a.student_id = b.student_id  join student_records as sr on  b.student_id = sr.stu_id 

			where 1 and	 (a.status!='2' and a.status!='4') and b.stu_status='0'  and sr.session='".$_SESSION['session']."' ";					

	

    }
 
 	if(!empty($fromdt) && !empty($todt)){
 		$query.=" and date between '$fromdt' AND '$todt' ";
 	}
 	$query.=" order by sr.roll_no asc ";
	$search_result = filterTable($query);	

}





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

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Report Panel</a>

  <a class="breadcrumb-item" href="#">Fee Report</a>

  <span class="breadcrumb-item active">Paid Student Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=paidstudents_report" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

						

                        

						

						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="margin-left:20px;">Class</div>

							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

							

							<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:170px;" autofocus>

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

							

							<div class="col-md-1"></div>

											

							<div class="col-md-2" style="font-size:14px;">Section </div>

							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

							<select class="form-control" name="section" id="search_sect" style="width:170px;">

							<option value="" selected="selected">All</option>

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

							xmlhttp.open("get","search_ajax_section_withall_report.php?cls_id="+str,true);

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

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:50px;" value="Submit"><br><br>

							</div>

							

						</div>
						<span><small><u>(option filters)</u></small></span>
						<div class="row" style="margin-top:20px;">

								

								<div class="col-md-2" style="margin-left:20px;">From Date</div>

								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">

								<input type="date" name="fromdt" class="form-control" style="width:170px;" value="<?php echo $fromdt; ?>" autofocus >

								</div>

								<div class="col-md-1"></div>

								<div class="col-md-2">To Date</div>

								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">

								<input type="date" name="todt" class="form-control" style="width:170px;" value="<?php echo $todt; ?>" autofocus >

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

									if(isset($search))

									{

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

										

										$qtf = mysqli_query($con,"select * from assign_fee_class where class_id='$cid'  and session='".$_SESSION['session']."'");

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

												$tfee1 = $tfee1 + floatval($val);

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

									}

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						<div class="row">

						<div class="col-md-10">

						<?php 

						if(isset($search)){
							if(!empty($fromdt) && !empty($todt)){

						        echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total paid amount from &nbsp; $chg_fdate &nbsp; to &nbsp;$chg_tdate &nbsp; from &nbsp; $clsn , $sec &nbsp;Section is : Rs $gtotal. </h5>";
						    }else{
						    	echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total paid amount of $clsn , $sec &nbsp;Section is : Rs $gtotal. </h5>";

						    }    

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

		

		<a href="print_paidstudents.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&class=<?php echo $class;?>&section=<?php echo $section;?>" target="_blank" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>

		

		<a href="export_paidstudent_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success btn-sm" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>

		

		<a href="dashboard.php?option=paidstudents_report" class="btn btn-info btn-sm" style="margin-left:20px;"><i class='fa fa-arrow-left'> </i> Back</a>

			

		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 