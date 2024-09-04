
<?php
error_reporting(1);
extract($_REQUEST);

if(isset($save))
{
	
	$qu1 = mysqli_query($con,"select * from student_wise_fees where student_id='$student' && status='1'");
	$q2 = mysqli_query($con,"select * from students where student_id='$student'");
	$r2 = mysqli_fetch_array($q2);
	$stuname = $r2['student_name'];
	$olddue = $r2['due'];
	
	$row1 = mysqli_num_rows($qu1);
	if($row1)
	{	
		echo "<script>alert('Already assigned fees to ".$stuname."')</script>";	
	}
	else
	{	
		
	$strhid = implode(',',$headid);
	$strmode = implode(',',$fmode);
	$strhamt = implode(',',$updatedfee);
	$strreason = implode(',',$reason);
	 
	$q1 = mysqli_query($con,"select * from assign_fee_class where class_id='$class'");
	$r1 = mysqli_fetch_array($q1);
	$orgamtstr = $r1['fee_header_amount'];
	
	$orgamtarr = explode(',',$orgamtstr);
	
	$newarr = array_combine($orgamtarr,$updatedfee);
	//print_r($newarr);die();
	
	foreach($newarr as $k1=> $v1)
	{
		$disc = 0;
		$extra = 0;
		if($v1==$k1)
		{
			$disc = 0;
			$extra = 0;
		}
		else if($k1 > $v1)
		{
			$disc = $k1 - $v1;
		}
		else if($k1 < $v1)
		{
			$extra = $v1 - $k1;
		}
		
		$tdisc = $tdisc + $disc;
		$textra = $textra + $extra;
		
	}	
	
		$due = $olddue - $tdisc + $textra;
	
	$que1 = mysqli_query($con,"update student_wise_fees set fee_header_id='$strhid', fee_mode='$strmode', 
	fee_amount='$strhamt', due_amount='$due', discount_amount='$tdisc', extra_amount='$textra', reason='$strreason', 
	status='1' where student_id='$student'");
	
	$que2 = mysqli_query($con,"update students set due='$due' where student_id='$student'");
	echo "<script>window.location='dashboard.php?option=assign_fees_to_students'</script>";
		
	}
	
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
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Accounts Panel</a>
  <a class="breadcrumb-item" href="#">Fees</a>
  <a class="breadcrumb-item" href="dashboard.php?option=view_assign_fees_students">View Assign Fees Student</a>
  <span class="breadcrumb-item active">Assign Fees to Student</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=assign_fees_to_students" enctype="multipart/form-data">      
        <div class="content mt-3" style="width:1000px">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">

						<div class="row" style="margin-top:20px;">	
						
							<div class="col-md-1" style="font-size:14px;margin-left:180px;">Class</div>
							<div class="col-md-3" style="margin-top:-10px">
							<select name="class" class="form-control" style="width:175px;" 
							onchange="search_sec(this.value);headerdetail(this.value);"  autofocus required>
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
							
							<div class="col-md-2" style="font-size:14px;margin-left:-20px;">Section </div>
							<div class="col-md-2" style="margin-left:-100px;margin-top:-10px">
							<select class="form-control" name="section" id="search_sect" style="width:175px;" 
							onchange="searchstudent(this.value);" autofocus required>
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
													
						</div><br>
							
							<script>
							function headerdetail(str)
							{
								$.ajax({
									url:'get_ajax_header_details.php?cls_id='+str,
									type:'get',
									success:function(data) {
										$('#clasHeadDetails').html(data);
									}
									
								});
							}
							</script>
							
							<script>
							function checkstuassign(str)
							{
								$.ajax({
									url:'get_ajax_assign_students_detail.php?stu_id='+str,
									type:'get',
									success:function(data) {
										if(!data=='')	
										{
										alert('Already Assigned Fees to '+data);
										$('#student').prop('selectedIndex',0);
										}
									}
									
								});
							}
							</script>
												
                        <div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="font-size:14px;margin-left:300px;">Student Name </div>
							<div class="col-md-2" style="margin-left:0px;margin-top:-10px">
							<select class="form-control" name="student" id="student" onchange="checkstuassign(this.value)" 
							style="width:175px;margin-left:-50px;" autofocus required>
							<option value="" selected="selected" disabled>Select Student</option>
							<?php
							$qstu=mysqli_query($con,"select * from students where class_id='$class' && section_id='$section'");
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
						</div><br>
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
										<th>Fees Header</th>
										<th>Mode</th>
										<th>Actual Fees</th>
										<th>Updated Fees</th>
										<th>Reason</th>
                                    </thead>
                                    <tbody id="clasHeadDetails">
																										
                                    </tbody>
                                </table>
                            </div>
                        </div>
					
	<div class="row">
	<div class="col-md-10" style="font-size:16px;margin-left:50px;boder:1px solid black">
	
		<div class="row" style="margin-top:20px;">
			<div class="col-md-2">
			<input type="submit" name="save" class="btn btn-primary btn-sm" value="Save" style="width:120px;height:35px;margin-left:350px;">
			</div>
			<div class="col-md-2">
			<input type="reset" class="btn btn-info btn-sm" value="Cancel" style="width:120px;height:35px;margin-left:350px;">
			</div>
		</div>
	
	</div>						
	</div><br>
						
						
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
		
	</form>	
    </div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 