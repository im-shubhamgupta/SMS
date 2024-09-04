<?php
error_reporting(1);
extract($_REQUEST);

if(isset($_POST['search']))
{
	$fromdt1 = $_POST['fromdt'];
	$chg_fdate = date("d-m-Y", strtotime($fromdt1));
	
    $todt1 = $_POST['todt'];
	$chg_tdate = date("d-m-Y", strtotime($todt1));
	
    $class = $_POST['class'];
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
	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, a.status, b.student_id 
			from student_due_fees a, students b
			where date between '$fromdt' AND '$todt' and
			a.student_id = b.student_id and (a.status!='2' and a.status!='4') and b.stu_status='0' and b.class_id='$class' and b.section_id='$section'";	
	
	$search_result = filterTable($query);
    }
	
	else if($class!="" and $section=="")
	{
	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, b.student_id 
			from student_due_fees a, students b
			where date between '$fromdt' AND '$todt' and
			a.student_id = b.student_id and (a.status!='2' and a.status!='4') and b.stu_status='0' and b.class_id='$class'";					
	$search_result = filterTable($query);
    }
	
	else if($class=="" and $section=="")
	{
	$query="select a.student_id, a.fee_header_id, a.received_amount, a.previous_amount, a.transport_amount, a.due_amount, a.month, a.payment_type_id, a.payment_detail, a.issued_by, a.issue_date, b.student_id 
			from student_due_fees a, students b
			where date between '$fromdt' AND '$todt' and
			a.student_id = b.student_id and (a.status!='2' and a.status!='4') and b.stu_status='0'";					
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
								
								<div class="col-md-2" style="margin-left:20px;">From Date</div>
								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px;">
								<input type="date" name="fromdt" class="form-control" style="width:170px;" value="<?php echo $fromdt; ?>" autofocus required>
								</div>
								<div class="col-md-1"></div>
								<div class="col-md-2">To Date</div>
								<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
								<input type="date" name="todt" class="form-control" style="width:170px;" value="<?php echo $todt; ?>" autofocus required>
								</div>
							
						</div><br>
						
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
											<?php
											if(isset($search))
											{
												if($class!="")
												{
													$q1 = mysqli_query($con,"select * from assign_fee_class where class_id='$class'");
													$r1 = mysqli_fetch_array($q1);
													$feestr = $r1['fee_header_id'];
													$feearr = explode(',',$feestr);
													foreach ($feearr as $k)
													{
														$q2 = mysqli_query($con,"select * from fee_header where fee_header_id='$k'");
														$r2 = mysqli_fetch_array($q2);
														$headname = $r2['fee_header_name'];
													?>
													 <th><?php echo $headname;?></th>
													<?php
													}
											?>
												
											 <th>Previous Fee Due</th>
											 <th>Transport Fee</th>
											 <?php
												}
											}
											?>
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
									while($res1=mysqli_fetch_array($search_result))
										{									
										
										$stuid=$res1['student_id'];
									
									$que2=mysqli_query($con,"select * from students where student_id='$stuid' and stu_status='0'");
									while($res2=mysqli_fetch_array($que2))
									{
									
									$cid=$res2['class_id'];
									$qcls=mysqli_query($con,"select * from class where class_id='$cid'");
									$rcls=mysqli_fetch_array($qcls);
									
									$sectid=$res2['section_id'];
									$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");
									$rsec=mysqli_fetch_array($qsec);
									
										$sfee=$res1['received_amount'];
										$sfeearr = explode(',',$sfee);	

										$prevfeepaid=$res1['previous_amount'];
										$transfeepaid=$res1['transport_amount'];
										$ptid=$res1['payment_type_id'];
										$qptid=mysqli_query($con,"select * from payment_type where payment_type_id ='$ptid'");
										$rptid=mysqli_fetch_array($qptid);
										$paidby=$rptid['payment_type_name'];
										
										$pdetail=$res1['payment_detail'];
										$issby=$res1['issued_by'];
										$issdt=$res1['issue_date'];	
										$chgedate = date('d-m-Y h:i:s',strtotime($issdt));	
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res2['student_name']; ?></td>
										<td><?php echo $res2['register_no']; ?></td>
										<td><?php echo "Mr&nbsp;".$res2['father_name']; ?></td>
										<td><?php echo $res2['parent_no']; ?></td>
										<td><?php echo $rcls['class_name']; ?></td>
										<td><?php echo $rsec['section_name']; ?></td>
										
										<?php
										
											$tfee1 = 0;
											$tfee2 = 0;
											foreach($sfeearr as $v)
											{
												$tfee1 = $tfee1 + $v;
											
												if($class!="")
												{
												?>
												
												<td><?php echo $v; ?></td>
												
												<?php
												}
											}
											$tfee2 = $tfee1 + $transfeepaid + $prevfeepaid;
										?>
										
										<?php
										if($class!=="") 
										{
										?>	
											<td><?php echo $prevfeepaid; ?></td>
											<td><?php echo $transfeepaid; ?></td>
										<?php 
										}
										?>
										<td><?php echo $tfee2; ?></td>
										<td><?php echo $res2['due']; ?></td>
										<td><?php echo $paidby;?></td>										
										<td><?php echo $pdetail;?></td>										
										<td><?php echo $issby;?></td>										
										<td><?php echo $chgedate;?></td>	
									</tr>
									
                                    <?php
									$sr++;									
										}
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
						if(isset($search))
						{
						echo "<h5 style='border:1px solid grey;padding:10px;boder-radius:10px;'> The Total paid amount from &nbsp; $chg_fdate &nbsp; to &nbsp;$chg_tdate &nbsp; from &nbsp; $clsn , $sec &nbsp;Section is : Rs $gtotal. </h5>";
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
		
		<a href="print_paidstudents.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-primary btn-sm" style="margin-left:20px;"><i class="fa fa-print"></i> Print</a>
		
		<a href="export_paidstudent_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success btn-sm" style="margin-left:20px;"><i class="fa fa-download"></i> Download To Excel</a>
		
		<a href="dashboard.php?option=paidstudents_report" class="btn btn-info btn-sm" style="margin-left:20px;"><i class='fa fa-arrow-left'> </i> Back</a>
			
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 