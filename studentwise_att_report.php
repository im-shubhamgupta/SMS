<?php
error_reporting(1);
extract($_REQUEST);
if(isset($search))
{
	$query="select distinct(date) from subjectwise_attendance where class_id='$class' && section_id='$section' && 
	month(date)='$month' && year(date)='$year' && student_id='$student'";
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
<style>
.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
	margin-left:-18px;
	margin-top:-17px;
    background-color: #237791;
    border-radius: .25rem;
	font-size:19px;
}
.breadcrumb-item{
	color:#fff;
}
.breadcrumb-item .fa fa-home{
	color:#fff;
}
.breadcrumb-item.active {
    color: #eff7ff;
}
.breadcrumb-item+.breadcrumb-item::before {
    display: inline-block;
    padding-right: .5rem;
    color: #eff4f9;
    content: "/";
} 

</style>
<nav class="breadcrumb" style="width:1200px">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Attendance Report</a>
  <span class="breadcrumb-item active">Student Wise Attendance Report</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=studentwise_att_report" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1200px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	
						
							<div class="col-md-2" style="font-size:14px;">Class</div>
							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">
							<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:175px;" autofocus required>
							<option value="" selected="selected" disabled>Select Class</option>
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
							
							<div class="col-md-2" style="font-size:14px;margin-left:10px;">Section </div>
							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">
							<select class="form-control" name="section" id="search_sect" onchange="searchstudent(this.value)"   style="width:175px;" autofocus required>
							<option value="" selected="selected" disabled>Select Section</option>
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
							xmlhttp.open("get","search_ajax_section_report.php?cls_id="+str,true);
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
							
							<script>
							function searchstudent(str)
							{
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_ajax_student_report.php?sec_id="+str,true);
							xmlhttp.send();
							xmlhttp.onreadystatechange=function()
							{
							if(xmlhttp.status==200  && xmlhttp.readyState==4)
							{
							document.getElementById("student").innerHTML=xmlhttp.responseText;
							}
							}
							}
							</script>
							
							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Month </div>
							<div class="col-md-2" style="margin-left:0px;margin-top:-10px">
							<select class="form-control" name="month" style="width:175px;margin-left:-50px;" autofocus required>
							<option value="" selected="selected" disabled>Select Month</option>
							<?php
							$qmon=mysqli_query($con,"select * from att_report_month");
							while($rmon=mysqli_fetch_array($qmon))
							{
							$monthid=$rmon['month_id'];
							?>
							<option <?php if($month==$rmon['month_id']){echo "selected";}?> value="<?php echo $rmon['month_id']; ?>"><?php echo $rmon['month_name'];?>
							</option>
							<?php 
							}
							?>							
							</select>	
							</div>							
						</div><br>
						
												
                        <div class="row" style="margin-top:20px;">
								
							<div class="col-md-2" style="font-size:14px;">Year </div>
							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
							<select class="form-control" name="year" style="width:175px;margin-left:-50px;" autofocus required>
							<option value="" selected="selected" disabled>Select Year</option>
							<?php
							$qyear=mysqli_query($con,"select * from year");
							while($ryear=mysqli_fetch_array($qyear))
							{
							?>
							<option <?php if($year==$ryear['year_name']){echo "selected";}?> value="<?php echo $ryear['year_name'];?>"><?php echo $ryear['year_name'];?>
							</option>
							<?php 
							}
							?>							
							</select>
							</div>
								
							<div class="col-md-2" style="font-size:14px;margin-left:20px;">Student Name </div>
							<div class="col-md-2" style="margin-left:0px;margin-top:-10px">
							<select class="form-control" name="student" id="student" style="width:175px;margin-left:-50px;" autofocus required>
							<option value="" selected="selected" disabled>Select Student</option>
							<?php
							$qstu=mysqli_query($con,"select * from students");
							while($rstu=mysqli_fetch_array($qstu))
							{
							?>
							<option <?php if($student==$rstu['student_id']){echo "selected";}?> value="<?php echo $rstu['student_id']; ?>"><?php echo $rstu['student_name'];?>
							</option>
							<?php 
							}
							?>							
							</select>	
							</div>								
							
							<div class="col-md-2">
							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-10px;width:180px;margin-left:50px;" value="Load"><br><br>
							</div>
							
						</div><br>
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
										<th>Sl. No.</th>
										<th>Attendance Date</th>
										<?php
										$quesub=mysqli_query($con,"select * from subject where class_id='$class'");
										while($res=mysqli_fetch_array($quesub))
										{			
											$subid[]=$res['subject_id'];
										?>
										
										<th><?php echo $res['subject_name'];?></th>
										<?php
										}
										?>										
										</tr>
                                    </thead>
                                    <tbody>
									<?php
									$i=1;
									$absent=0;
									$leave=0;
									$rowcount=mysqli_num_rows($search_result);
									while($res1=mysqli_fetch_array($search_result))
									{
									 $ndate=$res1['date'];
									 $chgdate=date('d-m-Y',strtotime($ndate));
									?>
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $chgdate; ?></td>
									
									<?php
									
									foreach($subid as $v)
									{
									   
									$query4=mysqli_query($con,"select * from subjectwise_attendance where student_id='$student' && subject_id='$v' && date='$ndate'");
									$r2=mysqli_fetch_array($query4);
									$attend=$r2['type_of_attend'];
									$queatt=mysqli_query($con,"select * from attendance_type where att_type_id='$attend'");
									$ratt=mysqli_fetch_array($queatt);
									$attname=$ratt['short_name'];
									if($attend==2)
									{
										$absent=$absent+1;
									}
									if($attend==3)
									{
										$leave=$leave+1;
									}
									
									?>
									
									<td><?php echo $attname; ?></td>
									<?php
									}
									?>								
									</tr>
									<?php
									$i++;
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
	$att_per=0;
	$present=$rowcount-$leave;
	$att_per = (($present+$leave)/$rowcount*100)."%";
	
	echo "<p style='font-size:18px;color:black;padding:10px;'> Attendance Taken : $rowcount Days<br/>
			Leave : $leave Days<br/>
			Attendance Percentage : $att_per</p>";
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
		
		<!--
		<a href="print_paidstudents.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-primary" style="margin-left:20px;">Print</a>
		
		<a href="export_paidstudent_excel.php?fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>&class=<?php echo $class;?>&section=<?php echo $section;?>" class="btn btn-success" style="margin-left:20px;">Download To Excel</a>
		
		<a href="dashboard.php?option=paidstudents_report" class="btn btn-primary" style="margin-left:20px;">Back</a>
			-->
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 