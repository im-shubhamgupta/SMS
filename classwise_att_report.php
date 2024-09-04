<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<?php
error_reporting(1);
extract($_REQUEST);

if(isset($search))
{
	$query="select distinct(a.student_id),b.student_name from subjectwise_attendance a inner join students b on a.student_id=b.student_id where a.class_id='$class' && a.section_id='$section' && month(date)='$month' && 
	year(date)='$year'";
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
  <span class="breadcrumb-item active">Class Wise Attendance Report</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=classwise_att_report" enctype="multipart/form-data">      
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
							
							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Section </div>
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
							
							
													
						</div><br>
						
												
                        <div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="font-size:14px;">Month</div>
							<div class="col-md-2" style="margin-left:-50px;margin-top:-10px">
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
														
							
							<div class="col-md-2">
							<input type="submit" name="search" class="btn btn-primary btn-sm" style="margin-top:-80px;width:180px;margin-left:50px;" value="Load"><br><br>
							</div>
							
						</div><br>
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
										<th>Sl. No.</th>
										<th>Name</th>
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
										<th>Total Percentage</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php
									$i=1;
									$leave=0;
									while($res1=mysqli_fetch_array($search_result))
									{
									 $student=$res1['student_id'];
									?>
									<tr>
									<td><?php echo $i; ?></td>
									<td>
									
									<form action="dashboard.php?option=studentwise_att_report" method="post" id="frm<?=$student;?>">
									<input type="hidden" name="student" value="<?=$student;?>">
									<input type="hidden" name="month" value="<?=$month;?>">
									<input type="hidden" name="class" value="<?=$class;?>">
									<input type="hidden" name="section" value="<?=$section;?>">
									<input type="hidden" name="year" value="<?=$year;?>">
									<input type="hidden" name="search" value="search">
									</form>
									
									<a id="stu<?=$student;?>" href="javascript:void(0)" style="color:green;font-size:14px;">
									<?php echo $res1['student_name']; ?></a>
									
									<script>
									
									$('#stu<?=$student;?>').on('click', function() {
										//$("#frm<?=$student;?>").attr('target','_blank');
										$("#frm<?=$student;?>").submit();
									
									});
									</script>
									
									</td>
									
									<?php
									$present_all_subject = 0;
									$total_row=0;
									foreach($subid as $v)
									{  
									$query4=mysqli_query($con,"select * from subjectwise_attendance where student_id='$student' && subject_id='$v' && month(date)='$month' && year(date)='$year'");
									
									$trow=mysqli_num_rows($query4);
									
									$present_per_subject=0;
									
									while($res2 = mysqli_fetch_array($query4))
									{
										$spr = $res2['type_of_attend'];
										if($spr =="1")
										{
											$present_per_subject = $present_per_subject+1;
										}
																			
									}
									?>
									
									<td><?php echo $present_per_subject." (".$trow.")"; ?></td>
									<?php
									$total_row=$total_row+$trow;
									$present_all_subject = $present_all_subject+$present_per_subject;
									$total_percentage = round(($present_all_subject/$total_row)*100,2);
									}
									?>	
									<td><?php echo $total_percentage." %"; ?></td>
									</tr>
									<?php
									$i++;
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
		
		</div>
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 