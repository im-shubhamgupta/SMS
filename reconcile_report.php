<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{	

    $class = $_POST['class'];

	$c=mysqli_query($con,"select * from class where class_id='$class'");

	$rc=mysqli_fetch_array($c);

	$cls=$rc['class_name'];

	if($cls)

	{

		$clsn=$cls;

	}else

	{

		$clsn='All';

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

	

	$status = $_POST['status'];

	if($status)

	{

		$sta=$status;

	}else

	{

		$sta='All';

	}

	

	if($class!="" and $section!="" and $status!="")

	{

	$query="select a.student_id, a.payment_detail, a.received_amount, a.date, a.status, b.student_id 

			from student_due_fees as a join students as b on a.student_id = b.student_id join student_records as sr on b.student_id = sr.stu_id

			where 1 and sr.class_id='$class' and sr.section_id='$section' and a.status='$status' and sr.session ='".$_SESSION['session']."' ";	

	

	$search_result = filterTable($query);

    }

	

	else if($class!="" and $section!="" and $status=="")

	{

	$query="select a.student_id, a.payment_detail, a.received_amount, a.date, a.status, b.student_id 

			from student_due_fees as a join students as b on a.student_id = b.student_id join student_records as sr on b.student_id = sr.stu_id


			where  sr.class_id='$class' and sr.section_id='$section' and a.status!='0' and a.status!='4' and sr.session ='".$_SESSION['session']."'";	

	$search_result = filterTable($query);

    }

	

	else if($class!="" and $section=="" and $status=="")

	{

	$query="select a.student_id, a.payment_detail, a.received_amount, a.date, a.status, b.student_id  

			from student_due_fees as a join students as b on a.student_id = b.student_id join student_records as sr on b.student_id = sr.stu_id


			where  sr.class_id='$class' and a.status!='0' and a.status!='4' and sr.session ='".$_SESSION['session']."' ";	

	$search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="" and $status=="")

	{

	$query="select a.student_id, a.payment_detail, a.received_amount, a.date, a.status, b.student_id 

			from student_due_fees as a join students as b on a.student_id = b.student_id join student_records as sr on b.student_id = sr.stu_id


			where  a.status!='0' and a.status!='4' and sr.session ='".$_SESSION['session']."' ";	

	$search_result = filterTable($query);

    }

	

	else if($class=="" and $section=="" and $status!="")

	{

	$query="select a.student_id, a.payment_detail, a.received_amount, a.date, a.status, b.student_id 

			from student_due_fees as a join students as b on a.student_id = b.student_id join student_records as sr on b.student_id = sr.stu_id


			where a.status='$status' and sr.session ='".$_SESSION['session']."'";	

	$search_result = filterTable($query);

    }

	

	

		

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

  <span class="breadcrumb-item active">Reconcile Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=reconcile_report" enctype="multipart/form-data">      

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

											

						<div class="row" style="margin-top:20px;">	

						

							<div class="col-md-2" style="margin-left:40px;">Class</div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:170px;">

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

											

							<div class="col-md-2" style="font-size:14px;margin-left:40px;">Section </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

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

							</div>

							

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

							

							<div class="col-md-2" style="font-size:14px;margin-left:40px;">Status </div>

							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px">

							<select class="form-control" name="status" style="width:170px;">

							<option value="" selected="selected">All</option>					

							<option value="1">Approved</option>						

							<option value="2">Declined</option>						

							<option value="3">Paid</option>						

													

							</select>	

							</div>	

						</div><br>

						

						<div class="row" style="margin-top:20px;">

							<div class="col-md-2">

							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:120px;margin-left:350px;" value="Submit"><br><br>

							</div>

						</div>

						

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

											 <th>Class</th>

											 <th>Section</th>

											 <th>Chq / DD /Txn. No</th>

											 <th>Payment Date</th>

											 <th>Amount Paid</th>

											 <th>Reconciled Status</th>

											 

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									if(isset($search))

									{

									$sr=1;

									while($res1=mysqli_fetch_array($search_result))

										{									

										

										$stuid=$res1['student_id'];

									

									// $que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0'");
									$sql1="select `student_id`,religion_id,caste,soc_cat_id,adm_type_id,dob,`register_no`,stuaddress,`student_name`,father_name,mother_tongue,admin_rte,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where stu_status='0' and student_id='$stuid' and sr.session='".$_SESSION['session']."'";
									$que2=mysqli_query($con,$sql1);


									while($res2=mysqli_fetch_array($que2))

									{

										$cid=$res2['class_id'];

										$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

										$rcls=mysqli_fetch_array($qcls);

										

										$sectid=$res2['section_id'];

										$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

										$rsec=mysqli_fetch_array($qsec);

									

										$issdt = $res1['date'];

										$chgedate = date('d-m-Y',strtotime($issdt));

										

										$sfee=$res1['received_amount'];

										$sfeearr = explode(',',$sfee);	

										$tfee1 = 0;

										foreach($sfeearr as $v)

										{

											$tfee1 = $tfee1 + $v;

										

										}

										

										$st = $res1['status'];

										if($st=='1')

										{

											$nstatus = "Approved";

										}

										else if($st=='2')

										{

											$nstatus = "Declined";

										}

										else if($st=='3')

										{

											$nstatus = "Paid";

										}

										

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $res2['student_name']; ?></td>

										<td><?php echo $res2['register_no']; ?></td>

										<td><?php echo "Mr&nbsp;".$res2['father_name']; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>

										<td><?php echo $res1['payment_detail']; ?></td>

										<td><?php echo $chgedate; ?></td>

										<td><?php echo $tfee1; ?></td>

										<td><?php echo $nstatus; ?></td>

																				

									</tr>

									

                                    <?php

									$sr++;									

									}

										}

									}

									?>

									

                                    </tbody>

                                </table>

                            </div>

                        </div>

						

						<br>

						

						

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

		<!--

		<a href="export_paidstudent_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success" style="margin-left:20px;">Download To Excel</a>

		-->

		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>

 

 