<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);
$query=mysqli_query($con,"select * table sms_setting");
$res=mysqli_fetch_array($query);


if(isset($clear))
	{
		$q1 = mysqli_query($con,"TRUNCATE table expense");
		$q2 = mysqli_query($con,"TRUNCATE table installed_app");
		$q3 = mysqli_query($con,"TRUNCATE table log");
		$q4 = mysqli_query($con,"TRUNCATE table marks");
		$q5 = mysqli_query($con,"TRUNCATE table previous_fees");
		$q6 = mysqli_query($con,"TRUNCATE table remedy");
		$q7 = mysqli_query($con,"TRUNCATE table feedback");
		$q8 = mysqli_query($con,"TRUNCATE table students");
		$q9 = mysqli_query($con,"TRUNCATE table student_daily_attendance");
		$q10 = mysqli_query($con,"TRUNCATE table student_due_fees");
		$q11 = mysqli_query($con,"TRUNCATE table student_leave");
		$q12 = mysqli_query($con,"TRUNCATE table student_notifications");
		$q13 = mysqli_query($con,"TRUNCATE table student_route");
		$q14 = mysqli_query($con,"TRUNCATE table student_wise_fees");
		$q15 = mysqli_query($con,"TRUNCATE table subjectwise_attendance");
		$q16 = mysqli_query($con,"TRUNCATE table assign_custome_group");
				
		echo "<script>alert('Database Cleared Successfully');window.location='dashboard.php?option=clear_student_details'</script>";
	}
?>
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
  <span class="breadcrumb-item active">Clear Student Details
</span>
</nav>
<!-- breadcrumb -->	
		
		 <div class="content mt-3">	
		 <div class="col-lg-6">
                    <div class="card"  style="width:500px;">
                      <div class="card-header">
                        <strong>Clear Student Details</strong>	
                      </div>
						<div class="card-body card-block">
                        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">
                          						
							<div class="row form-group">
                            <div class="col-md-12">
							<input type="submit" name="clear" value="CLICK" class="btn btn-danger" style="width:100px;border-radius:20px;margin-left:10px;"/>
							<span style="color:red;font-weight:bold;margin-left:10px">Click To Clear Student Details</span>
							</div>
													
							</div><br>
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
