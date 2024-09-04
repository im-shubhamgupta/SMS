<?php
//error_reporting(1);
include('connection.php');
extract($_REQUEST);
$query=mysqli_query($con,"select * from stu_att_type");
$res=mysqli_fetch_array($query);
$attname=$res['stu_att_name'];

if(isset($update))
	{
		$que="update stu_att_type set stu_att_name='$atttype' where stu_att_id='1'";
		
		if(mysqli_query($con,$que))
		{
			$action = "Attendance type ".$attname." is edited"; 
			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,
			machine_name,browser,date) 
			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
		}
		
		echo "<script>window.location='dashboard.php?option=attendance_type&smid=14'</script>";
	}
?>
<!-- breadcrumb-->
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Configuration Panel</a>
  <span class="breadcrumb-item active">View & Update Attendance Type
</span>
</nav>
<!-- breadcrumb -->	
		
		 <div class="content mt-3">	
		 <div class="col-lg-6">
                  <div class="card"  style="width:800px;">
                      <div class="card-header">
                        <strong>Update</strong> Attendance Type
                      </div>
						
					  <div class="card-body card-block">
                        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">
                          	<div class="row form-group">
                            <div class="col col-md-6">							
							<input type="radio" name="atttype" value="daily" <?php if($attname=="daily"){echo "checked";}?> style="margin-left:25px;"> Daily Once
							<input type="radio" name="atttype" value="subjectwise" <?php if($attname=="subjectwise"){echo "checked";}?> style="margin-left:35px;"> Subject Wise
							</div>
							</div><br>
							
							<div class="row form-group">
							<div class="col col-md-6">	
							<input type="submit" name="update" value="Update" style="margin-left:30px;">
							</div>
							</div>
					  	</form>				  
					  </div>
	              </div>
	      </div>
		  </div>

<script>
function limit(element)
{
    var max_chars = 6;

    if(element.value.length > max_chars) {
        element.value = element.value.substr(0, max_chars);
    }
}
</script>
