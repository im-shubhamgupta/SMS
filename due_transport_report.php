<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{

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

	if($se){

		$sec=$se;

	}else{

		$sec='All';

	}

/*	

		

	if($range==1)

	{

		if($class!="" and $section!="")

		{		

		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > 0 and due_amount < '$r1'";

		// $search_result = filterTable($query);

		}

				

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' and due_amount > 0 and due_amount < '$r1'";					

		// $search_result = filterTable($query);

		}

			

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where due_amount > 0 and due_amount < '$r1'";

		// $search_result = filterTable($query);

		}

		

	}

	

	else if($range==2)

	{

		

		if($class!="" and $section!="")

		{

		$query="select * from student_route where class_id='$class' and section_id='$section' and due_amount > '$r1'";			

		// $search_result = filterTable($query);

		}

				

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' and due_amount > 0 and due_amount > '$r1'";					

		// $search_result = filterTable($query);

		}

			

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where due_amount > '$r1'";

		// $search_result = filterTable($query);

		}

		

	}
*/
		if($class!="" and $section!=""){

		$query="select * from student_route where class_id='$class' and section_id='$section' ";			

	

		}	

		else if($class!="" and $section=="")

		{

		$query="select * from student_route where class_id='$class' ";					

 
		}

		else if($class=="" and $section=="")

		{

		$query="select * from student_route where 1 ";
 
		}

		

	
	if(!empty($range)){
		if($range==1){
			$query.=" and due_amount > 0 and due_amount < '$r1'";

		}elseif($range==2){
			$query.="  and due_amount > 0 and due_amount > '$r1' ";
		}elseif($range==3){
			$query.=" and due_amount between '$r1' and '$r2' ";

		}
	}
	$query.=" and session='".$_SESSION['session']."' ";

	// echo $query;

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



<!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- --->

<?php

if(isset($sms))

{

	$qs1=mysqli_query($con,"select * from sms_setting");

	$rs1=mysqli_fetch_array($qs1);

	$status=$rs1['status'];

	if($status==0)

	{

	echo "<script>window.location='send_sms_duetransport.php?class=$class&section=$section&range=$range&r1=$r1&r2=$r2'</script>";

	}

	else

	{

	echo "<script>alert('No Permission to send SMS')</script>";	

	}



}



?>



<!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- ---> <!--- ---- SMS  ---- --->



<style>

	tr th{

		

		font-size:14px;

	}



	tr td{

		

		font-size:14px;

	}



</style>

<div id="right-panel" class="right-panel">

<!-- breadcrumb-->



<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Transport Panel</a>

  <a class="breadcrumb-item" href="#">Report</a>

  <span class="breadcrumb-item active">Due Transport Report</span>

</nav>

<!-- breadcrumb -->

   <form method="post" action="dashboard.php?option=due_transport_report" enctype="multipart/form-data">      

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


								

						</div>

							<span><small><u>(Optional Filters)</u></small></span>

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

                                <table id="table-grid" class="table table-striped table-bordered table-responsive">

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

											 <th>Transport Fee</th>

											 <th>Previous Transport Fee</th>

											 <th>Total Fee</th>

											 <th>Total Discount</th>

											 <th>Total Paid</th>

											 <th>Total Due</th>

											 <th>Last Paid Date</th>

                                        </tr>

                                    </thead>

                                    <tbody>

									<?php 

									if(isset($search_result))

									{

									$sr=1;

									while($res=mysqli_fetch_array($search_result))

									{



										$stuid=$res['student_id'];

										// $qst1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='".$_SESSION['session']."' ");
										$qst1=mysqli_query($con,"select `student_id`,`register_no`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id,sr.roll_no from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."' order by sr.roll_no asc");
										if(mysqli_num_rows($qst1)>0){

										$rst1 = mysqli_fetch_array($qst1);

										$stuname=$rst1['student_name'];

										$regno=$rst1['register_no'];

										$fname=$rst1['father_name'];

										$parentno=$rst1['parent_no'];

										

										$cid=$res['class_id'];

										$qcls=mysqli_query($con,"select * from class where class_id='$cid'");

										$rcls=mysqli_fetch_array($qcls);

										

										$sectid=$res['section_id'];

										$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");

										$rsec=mysqli_fetch_array($qsec);

																		

										$due=$res['due_amount'];

										$transid=$res['trans_id'];

										$qtd = mysqli_query($con,"select * from transports where trans_id ='$transid'");

										$rtd = mysqli_fetch_array($qtd);

										$transamt = $rtd['price'];

										$totaldiscount = $res['discount'];

										

										$qp = mysqli_query($con,"select * from previous_transport_fees where student_id ='$stuid' and session='".$_SESSION['session']."' ");

										$rp = mysqli_fetch_array($qp);

										

										if(mysqli_num_rows($qp))

										{

											$prevamt = $rp['previous_transport_fees'];

										}

										else

										{

											$prevamt = 0;

										}

										

										$totalfee = $transamt + $prevamt;

										

										$qt = mysqli_query($con,"select * from student_transport_due_fees where student_id ='$stuid' and status!='2' and status!='4' and session='".$_SESSION['session']."' ");

										$transfeepaid = 0;

										$prevfeepaid = 0;

										while($rt = mysqli_fetch_array($qt))

										{

										$transfeepaid += $rt['trans_amount'];

										$prevfeepaid += $rt['previous_trans_amount'];

										$issdt=$rt['issue_date'];	

										}

										

										if($issdt){

											$chgedate = date('d-m-Y h:i:s',strtotime($issdt));	

										}

										else

										{

											$chgedate = " ";

										}

										

										$tfeepaid = $transfeepaid + $prevfeepaid;

																																													

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $stuname; ?></td>

										<td><?php echo $regno; ?></td>

										<td><?php echo "Mr&nbsp;".$fname; ?></td>

										<td><?php echo $parentno; ?></td>

										<td><?php echo $rcls['class_name']; ?></td>

										<td><?php echo $rsec['section_name']; ?></td>
										<td><?php echo ($rst1['roll_no']) ? $rst1['roll_no'] : '0'; ?></td>

										<td><?php echo $transamt; ?></td>

										<td><?php echo $prevamt; ?></td>

										<td><?php echo $totalfee; ?></td>

										<td><?php echo $totaldiscount; ?></td>

										<td><?php echo $tfeepaid;?></td>								

										<td><?php echo $due;?></td>								

										<td><?php echo $chgedate;?></td>																

									</tr>

									

                                    <?php

									$sr++;	

									$tdue = $tdue + $due; 

									}
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

		

		<!-- <button type="submit" name="sms" id="add" class="btn btn-primary btn-sm"/><i class="fa fa-envelope"></i> Send SMS </button> -->

		

		<a href="print_duetransport.php?class=<?php echo $class;?>&section=<?php echo $section;?>&range=<?php echo $range;?>&r1=<?php echo $r1;?>&r2=<?php echo $r2;?>" target="_blank" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>

		

		<a href="export_duetransport_excel.php?class=<?php echo $class;?>&section=<?php echo $section;?>&range=<?php echo $range;?>&r1=<?php echo $r1;?>&r2=<?php echo $r2;?>" class="btn btn-success btn-sm" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>

		

		<a href="dashboard.php?option=due_transport_report" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class='fa fa-arrow-left'> </i> Back</a>

		

		</div>

		

	</form>	

    </div><!-- /#right-panel -->

 <?php //include('bootstrap_datatable_javascript_library.php'); ?>
  <?php include('datatable_links.php'); ?>
 <script>

 var dataTable = $("#table-grid").DataTable({
                    "lengthMenu": [ [10, 25, 50, 100, 500, 999999999], [10, 25, 50, 100, 500, 'All'] ],	
                    // 'order':[4,'DESC'],
                    dom: 'Blfrtip',

                    "pageLength":25,
					"scrollX": true,
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                });
</script>