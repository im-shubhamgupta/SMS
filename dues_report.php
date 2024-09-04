<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

if(isset($_POST['search']))
{
	
	//echo $fromdt;echo $todt;die();
    $class = $_POST['class'];
    $section = $_POST['section'];
    $range = $_POST['range'];
    $r1 = $_POST['r1'];
    $r2 = $_POST['r2'];
    
	if($range == "1")
	{
		if($class!="" and $section!="")
		{
		/*$query="select a.student_id, a.student_name, a.register_no, a.father_name, 
				b.student_id, b.admfeepaid, b.tutionfeepaid, b.miscfeepaid, b.transfeepaid, b.issued_date
				from students a
				LEFT JOIN bill b ON a.student_id = b.student_id
				where a.stu_status='0' and a.class_id='$class' and a.section_id='$section' and b.due< '$r1'";*/	
			
			
			
		$query="select distinct student_id from bill where student_id IN 
				(select student_id from students where stu_status='0' and class_id='$class' and section_id='$section' and due < '$r1')";
		$search_result = filterTable($query);
		}
		
		else if($class!="" and $section=="")
		{
		$query="select distinct student_id from bill where student_id IN 
				(select student_id from students where stu_status='0' and class_id='$class' and due < '$r1')";		
		$search_result = filterTable($query);
		}
		
		else if($class=="" and $section=="")
		{
		$query="select distinct student_id from bill where student_id IN 
				(select student_id from students where stu_status='0' and due < '$r1')";		
		$search_result = filterTable($query);
		}
	}

}

 else {
    
	$query="select * from students a where stu_status='0'";
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
   <form method="post" action="dashboard.php?option=duestudents_report" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="margin-top:20px;">
								
							<!--<div class="col-md-1" style="font-size:14px;">From Date</div>
								<div class="col-md-2" style="margin-top:-8px;">
								<input type="date" name="fromdt" class="form-control" >
								</div>
								
								<div class="col-md-1" style="font-size:14px;">To Date</div>
								<div class="col-md-2" style="margin-top:-8px;">
								<input type="date" name="todt" class="form-control" >
								</div>-->
								
								<div class="col-md-1" style="font-size:14px;">Class</div>
								<div class="col-md-2" style="margin-top:-8px;">
								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
								<option selected="selected" disabled>All</option>
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
								<div class="col-md-2" style="margin-top:-8px;">
								<select class="form-control" name="section" id="search_sect" autofocus required>
								<option selected="selected" disabled>All</option>
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
							
						</div><br>
						
						<div class="row" style="margin-top:20px;">	
						
								<div class="col-md-1" style="font-size:14px;">Range</div>
								<div class="col-md-3" style="margin-top:-8px;">
								<select name="range" class="form-control" autofocus required>
								<option selected="selected" disabled>Select Range</option>
								<option value="1">Less than</option>
								<option value="2">Greater than</option>
								<option value="3">Between</option>
								</select>
								</div>
							
								<div class="col-md-2" style="margin-top:-8px;">
								<input type="number" name="r1" class="form-control" autofocus required>
								</div>
								
								<div class="col-md-2" style="margin-top:-8px;">
								<input type="number" name="r2" class="form-control">
								</div>
							
							
								<div class="col-md-2">
								<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:180px;margin-left:50px;" value="Submit"><br><br>
								</div>
							
						</div>
						
						
						
						
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
											 <th>Class</th>
											 <th>Section</th>
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
									
										$qst=mysqli_query($con,"select * from students where student_id='$stuid'");
										while($rst=mysqli_fetch_array($qst))
										{
										
										$sid=$rst['student_id'];
										$stuname=$rst['student_name'];
										$regno=$rst['register_no'];
										$fname=$rst['father_name'];
										$tunfeesdisc=$rst['tutionfee_disc'];
										$tranfeedisc=$rst['transfee_disc'];
										
										$cid=$rst['class_id'];
										$que1=mysqli_query($con,"select * from class where class_id='$cid'");
										$res1=mysqli_fetch_array($que1);
										
										$sectid=$rst['section_id'];
										$qsec=mysqli_query($con,"select * from section where section_id='$sectid' and class_id='$cid'");
										$rsec=mysqli_fetch_array($qsec);
																			
										$que2=mysqli_query($con,"select * from fees where class_id='$cid'");
										$res2=mysqli_fetch_array($que2);
										$admfee=$res2['admissionfees'];
										$tunfee=$res2['tutionfees'];
										$miscfee=$res2['misfees'];
										
										$tid=$rst['trans_id'];
										$que3=mysqli_query($con,"select * from transports where trans_id='$tid'");
										$res3=mysqli_fetch_array($que3);
										$price=$res3['price'];
										
											$qbill=mysqli_query($con,"select * from bill where student_id='$sid'");
											$rowbill=mysqli_num_rows($qbill);
											if($rowbill)
											{
												$tpaidamt=0;
												while($rbill=mysqli_fetch_array($qbill))
												{									
												$tpaidamt=$tpaidamt+$rbill['admfeepaid']+$rbill['tutionfeepaid']+$rbill['miscfeepaid']+$rbill['transfeepaid'];
												$due=$admfee+$tunfee+$miscfee+$price-$tunfeesdisc-$tranfeedisc-$tpaidamt;
												$issdt=$rbill['issued_date'];
												}
											}
											else
											{
												$tpaidamt=0;
												$due=$admfee+$tunfee+$miscfee+$price-$tunfeesdisc-$tranfeedisc-$tpaidamt;
												$issdt=0;
											}
										}
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $stuname; ?></td>
										<td><?php echo $regno; ?></td>
										<td><?php echo "Mr&nbsp;".$fname; ?></td>
										<td><?php echo $res1['class_name']; ?></td>
										<td><?php echo $rsec['section_name']; ?></td>
										<td><?php echo $tpaidamt; ?></td>
										<td><?php echo $due;?></td>																				
										<td><?php echo $issdt;?></td>										
									</tr>
									
                                    <?php
									$sr++;	
										
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
		
		<!--<a href="printpaid_students.php?class='.$class.'" class="btn btn-primary" style="margin-left:20px;">Print</a>-->
		
		<!--
		<button id="printbtn" class="btn btn-primary" onclick="window.print();">print</button>
		
		<input type="submit" name="sms" value="Send SMS" id="add" class="btn btn-primary btn-md"/>
		
		<a href="export_excel.php" class="btn btn-success" style="margin-left:20px;">Download To Excel</a> -->
		
		<!--<a href="dashboard.php?option=view_bill" class="btn btn-danger btn-md" style="margin-left:20px;">Cancel</a>-->
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 