<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);

if(isset($_POST['search']))
{
    $class = $_POST['class'];
    $section = $_POST['section'];
	
	if($class!="" and $section!="")
	{
    // search in all table columns

		$query = "SELECT * FROM `students` WHERE `class_id`='$class' and section_id='$section' and stu_status='0'";
		$search_result = filterTable($query);
    }
	else if($class!="" and $section=="")
	{
		$query = "SELECT * FROM `students` WHERE `class_id`='$class' and stu_status='0'";
		$search_result = filterTable($query);
	}	
	else
	{
	$query = "SELECT * FROM `students` where stu_status='0'";
    $search_result = filterTable($query);
	}
}

 else {
    $query = "SELECT * FROM `students` where stu_status='0'";
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


<div id="right-panel" class="right-panel">
	<form method="post" action="dashboard.php?option=view_students" enctype="multipart/form-data">
        
		<?php
		if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
		{
		?>
		<div class="breadcrumbs" style="width:1200px">
            <div class="col-sm-4" style="padding:10px;">  
                <a href="dashboard.php?option=add_students" class="btn btn-outline-primary">Add Student</a>
            </div>
        </div>
		<?php
		}
		?>
		
        <div class="content mt-3" style="width:1200px">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                               
							   <div class="row" style="margin-top:20px;">
								<div class="col-md-1" style="margin-left:10px;">Class</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select name="class" class="form-control" onchange="search_sec(this.value)" autofocus required>
								<option selected="selected" disabled >---Select Class---</option>
								<?php
								$scls = "select * from class";
								$rcls = mysqli_query($con, $scls);
								while( $rescls = mysqli_fetch_array($rcls) ) {
								?>
								<option  <?php if($class==$rescls['class_id']){echo "selected";}?> value="<?php echo $rescls['class_id']; ?>"><?php echo $rescls['class_name']; ?>
								</option>
								<?php } ?>							
								</select>
								</div>
								</div>
								
								<div class="col-md-1" style="margin-left:50px;">Section</div>
								<div class="col-md-2">
								<div class="sorting-left">
								<select class="form-control" name="section" id="search_sect">
								<option value="" selected disabled>All</option>
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
								</div>
								
								<div class="col-md-1" style="margin-left:50px;">
								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>
								</div>
							    </div>
							   
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                             <th>Sr. No</th>
											 <th>Register No</th>
											 <th>Student Name</th>
											 <th>Father Name</th>
											 <th>Admission Date</th>
											 <th>Class</th>
											 <th>Section</th>
											 <th>Academic Year</th>
											 <th>Stu Phone</th>
											 <th>Parent Phone</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sr=1;
									//$query=mysqli_query($con,"select * from students where stu_status='0'");
									while($res=mysqli_fetch_array($search_result))
									{
									$id=$res['student_id'];
									$clid=$res['class_id'];
									$quec=mysqli_query($con,"select * from class where class_id='$clid'");
									$resc=mysqli_fetch_array($quec);
									
									$seid=$res['section_id'];
									$qse=mysqli_query($con,"select * from section where section_id='$seid'");
									$rsec=mysqli_fetch_array($qse);
									
									$date=$res['admission_date'];
									$admdate=date("d-m-y", strtotime($date));
									?>
									<tr>
										<td><?php echo $sr; ?></td>
										<td><?php echo $res['register_no']; ?></td>
										<td><?php echo $res['student_name']; ?></td>
										<td><?php echo $res['father_name']; ?></td>
										<td><?php echo $admdate ?></td>
										<td><?php echo $resc['class_name'];?></td>
										<td><?php echo $rsec['section_name'];?></td>
										<td><?php echo $res['academic_year']; ?></td>
										<td><?php echo $res['student_contact']; ?></td>
										<td><?php echo $res['parent_no']; ?></td>
										
										
										<td>
										<?php echo "<a href='dashboard.php?option=view_students_details&sid=$id' class='btn btn-outline-success btn-sm' title='View all details of student.'>View Details</a>";
											?>
										</td>
									</tr>
                                    <?php $sr++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
	</form>
</div><!-- /#right-panel -->
 <?php include('bootstrap_datatable_javascript_library.php'); ?>