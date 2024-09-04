<?php
error_reporting(1);
extract($_REQUEST);

if(isset($load))
{
	 $class = $_REQUEST['class'];
	 $section = $_REQUEST['section'];
	 $staff = $_REQUEST['faculty'];
	 $atttype = $_REQUEST['att_type'];
	 
	 $query="select * from students where class_id='$class' && section_id='$section'";
	 $search_result = filterTable($query);
	
	// function to connect and execute the query
	
}

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>	
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
   <span class="breadcrumb-item active">View Students Attendance</span>
</nav>
<!-- breadcrumb -->
   <form method="post" action="dashboard.php?option=view_student_attendance" id="devel-generate-content-form" enctype="multipart/form-data">      
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
						
                        <div class="row" style="margin-top:20px;">
								
								<div class="col-md-1"></div>
								<div class="col-md-1" style="font-size:14px;">Date <?php echo $cdate; ?></div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px;">
								<input type="date" name="atdate" value="<?php echo(date("Y-m-d")); ?>" class="form-control" style="width:175px;" autofocus required>
								</div>
								
								<div class="col-md-1" style="font-size:14px;margin-left:50px;">Class</div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select name="class" class="form-control" onchange="search_sec(this.value)" style="width:175px;" autofocus required>
								<option value="" selected="selected">Select Class</option>
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
								
							<script>
							function search_sec(str)
							{
							var xmlhttp= new XMLHttpRequest();	
							xmlhttp.open("get","search_ajax_section_att.php?cls_id="+str,true);
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
							
								<div class="col-md-1" style="font-size:14px;margin-left:50px;">Section </div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select class="form-control" name="section" id="search_sect" onchange="search_ass_teacher(this.value)" style="width:175px;" autofocus required>
								<option value="" selected="selected">Select Section</option>
								</select>	
								</div>
								<div class="col-md-1"></div><br><br>
						</div>
						
								
						<div class="row" style="margin-top:20px;">
						
						<script>
						function search_ass_teacher(str)
						{
						var xmlhttp= new XMLHttpRequest();	
						xmlhttp.open("get","search_asgn_teacher.php?secid="+str,true);
						xmlhttp.send();
						xmlhttp.onreadystatechange=function()
						{
						if(xmlhttp.status==200  && xmlhttp.readyState==4)
						{
						document.getElementById("faculty").innerHTML=xmlhttp.responseText;
						}
						} 
						}
						</script>
						
								<div class="col-md-1"></div>
								<div class="col-md-2" style="font-size:14px;">Attendance Taken BY :</div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select name="faculty" id="faculty" class="form-control" style="width:175px;" autofocus required>
								<option value="" selected="selected">Select Faculty</option>
								</select>
								</div>
											
								<div class="col-md-2" style="font-size:14px;margin-left:50px;">Type Of Attendance </div>
								<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
								<select class="form-control" name="att_type" id="search_sect" style="width:175px;" autofocus required>
								<option value="" selected="selected">Select Attendance</option>
								<?php
								$qat=mysqli_query($con,"select * from attendance_type");
								while($rqat=mysqli_fetch_array($qat))
								{
								?>
								<option value="<?php echo $rqat['att_type_id']; ?>"><?php echo $rqat['att_type_name'];?>
								</option>
								<?php 
								}
								?>							
								</select>	
								</div>
								
								<div class="col-md-2">
								<input type="submit" name="load" class="btn btn-primary btn-sm" style="margin-top:-10px;width:100px;margin-left:50px;" value="Load"><br><br>
								</div>
								<br>
								<br>
						</div>
						
						
						<!--table starts from here-->
						<div class="card">
                            <div class="card-body" style="width:1100px">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Student Name</th>
											 <th>Father Name</th>
											 <th>Parent Mobile Number</th>
											 <th>Selection</th>
										</tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									while($res1=mysqli_fetch_array($search_result))
									{									
									$stuid=$res1['student_id'];
									$stuname=$res1['student_name'];
									$stufathername=$res1['father_name'];
									$stuparentno=$res1['parent_no'];
														
									?>
									<tr>
								<td><?php echo $sr; ?></td>
								<td><?php echo $stuname; ?></td>
								<td><?php echo $stufathername; ?></td>
								<td><?php echo $stuparentno;?></td>										
								<td><input type="checkbox" class="form" name="dstaf[]" value="<?php echo $asclid;?>"></td>										
									</tr>
									
                                    <?php
									$sr++;									
									}
									?>
									
                                    </tbody>
                                </table>
                            </div>
                        </div><br><br>
					
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-2" style="font-size:14px;">Number of Presenties : </div>
							<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
							<input type="text" name="charcount" id="count-checked-checkboxes" class="form-control" id="charcount" style="margin-left:10px;" readonly>
							</div>
						</div><br><br>

						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-2" style="font-size:14px;">Number of Absenties : </div>
							<div class="col-md-2" style="margin-left:-20px;margin-top:-10px">
							<input type="text" name="charcount" class="form-control" id="charcount" style="margin-left:10px;" readonly>
							</div>
							
						</div>
						
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
		
	</form>	
    </div><!-- /#right-panel -->
	
<script>
$(document).ready(function(){

    var $checkboxes = $('#devel-generate-content-form td input[type="checkbox"]');
        
    $checkboxes.change(function(){
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $('#count-checked-checkboxes').text(countCheckedCheckboxes);
    });

});
</script>	
	
 <?php include('bootstrap_datatable_javascript_library.php'); ?>
 
 