<?php
//error_reporting(1);
include('connection.php');
extract($_REQUEST);

if(isset($_POST['search']))
{
	$fromdt = $_POST['fromdt'];
	$chg_fdate = date("d-m-Y", strtotime($fromdt));
	
    $todt = $_POST['todt'];
	$chg_tdate = date("d-m-Y", strtotime($todt));
	
	//echo $fromdt;echo $todt;die();
    $class = $_POST['class'];
    $section = $_POST['section'];
    
	
	if($class!="" and $section!="")
	{
    // search in all table columns

	$query="select a.student_id, a.student_name, a.father_name, a.register_no, a.tutionfee_disc, a.transfee_disc, a.class_id, a.section_id, a.trans_id, 
		b.student_id from students a, bill b 
		where a.stu_status='0' and a.class_id='$class' and a.section_id='$section' and a.student_id = b.student_id and 
		b.due='0' and b.issued_date between '$chg_fdate' AND '$chg_tdate'";
	$search_result = filterTable($query);
    }
	else if($class!="" and $section=="")
	{
    // search in all table columns

	$query="select a.student_id, a.student_name, a.father_name, a.register_no, a.tutionfee_disc, a.transfee_disc, a.class_id, a.section_id, a.trans_id, 
		b.student_id from students a, bill b 
		where a.stu_status='0' and a.class_id='$class' and a.student_id = b.student_id and 
		b.due='0' and b.issued_date between '$chg_fdate' AND '$chg_tdate'";
	$search_result = filterTable($query);
    }
	
}

 else {
    
	$query="select a.student_id, a.student_name, a.father_name, a.register_no, a.tutionfee_disc, a.transfee_disc, a.class_id, a.section_id, a.trans_id, 
			b.student_id from students a, bill b 
			where a.stu_status='0' and a.student_id = b.student_id and b.due='0'";
    $search_result = filterTable($query);
	  }
// function to connect and execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "school_billing");
    $filter_Result = mysqli_query($connect, $query);
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
   <form method="post" action="dashboard.php?option=paidstudents_report" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
							
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            								
								<div class="row" style="margin-top:20px;">
								
								<div class="col-md-1" style="font-size:14px;">From Date</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<input type="date" name="fromdt" class="form-control" autofocus required>
								</div>
								</div>
								
								<div class="col-md-1" style="font-size:14px;">To Date</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<input type="date" name="todt" class="form-control" autofocus required>
								</div>
								</div>
								
								<div class="col-md-1" style="font-size:14px;">Class</div>
								<div class="col-md-1">
								<div class="sorting-left">
								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
								<option selected="selected" disabled >All</option>
								<?php
								$scls = "select * from class";
								$rcls = mysqli_query($con, $scls);
								while( $rescls = mysqli_fetch_array($rcls) ) {
								?>
								<option value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								
								<div class="col-md-1" style="font-size:14px;">Section</div>
								<div class="col-md-1">
								<div class="sorting-left">
								<select class="form-control" name="section" id="search_sect">
								<option value="" selected disabled>All</option>
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
								
								<div class="col-md-2">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
								
							    </div>

					   
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export printbtn" class="table table-striped table-bordered">
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
											 <th>Total Paid</th>
											 <th>Paid By</th>
											 <th>Challan No</th>
											 <th>Issued By</th>
											 <th>Issued Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									//$query=mysqli_query($con,"select a.student_id, a.student_name, a.father_name, a.register_no, a.tutionfee_disc, a.transfee_disc, a.class_id, a.section_id, a.trans_id, 
									//b.student_id from students a, bill b 
									//where a.stu_status='0' and a.student_id = b.student_id and b.due='0'");
									while($res=mysqli_fetch_array($search_result))
									{
									
									$stuid=$res['student_id'];
									$regno=$res['register_no'];
									
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
									$tunfee=$res2['tutionfees']-$tunfeesdisc;
									$miscfee=$res2['misfees'];
									
									$tid=$res['trans_id'];
									$que3=mysqli_query($con,"select * from transports where trans_id='$tid'");
									$res3=mysqli_fetch_array($que3);
									$price=$res3['price']-$tranfeedisc;
									  	
									
										$ques=mysqli_query($con,"select * from bill where student_id='$stuid'");
										$tpaidamt=0;
										while($ress=mysqli_fetch_array($ques))
										{
										$admfeepaid=$ress['admfeepaid'];
										$tutionfeepaid=$ress['tutionfeepaid'];
										$miscfeepaid=$ress['miscfeepaid'];
										$transfeepaid=$ress['transfeepaid'];
										$paidby=$ress['paidby'];
										$challanno=$ress['challan_no'];
										$issby=$ress['issued_by'];
										$issdt=$ress['issued_date'];
										
										$tpaidamt=$tpaidamt+$admfeepaid+$tutionfeepaid+$miscfeepaid+$transfeepaid;
										$due=$admfee+$tunfee+$miscfee+$price-$tpaidamt;
								
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
										<td><?php echo $tpaidamt; ?></td>
										<td><?php echo $paidby;?></td>										
										<td><?php echo $challanno;?></td>										
										<td><?php echo $issby;?></td>										
										<td><?php echo $issdt;?></td>										
									</tr>
									
                                    <?php
										
									
									}
									?>
									
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
		
		<a href="printpaid_students.php?" class="btn btn-success" style="margin-left:20px;">Download To Excel</a>
		
		<!--
		<button id="printbtn" class="btn btn-primary" onclick="window.print();">print</button>
		
		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		
		<a href="export_excel.php" class="btn btn-success" style="margin-left:20px;">Download To Excel</a> -->
		
		<!--<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>-->
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 