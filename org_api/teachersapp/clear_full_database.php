<?php
error_reporting(1);
include('connection.php');
extract($_REQUEST);
$query=mysqli_query($con,"select * from sms_setting");
$res=mysqli_fetch_array($query);


if(isset($clear))
	{
		$q1 = mysqli_query($con,"truncate from assign_clsteacher");
		$q2 = mysqli_query($con,"truncate from assign_custome_group");
		$q3 = mysqli_query($con,"truncate from assign_fee_class");
		$q4 = mysqli_query($con,"truncate from assign_subject");
		$q5 = mysqli_query($con,"truncate from custome_group");
		$q6 = mysqli_query($con,"truncate from events");
		$q7 = mysqli_query($con,"truncate from expense");
		$q8 = mysqli_query($con,"truncate from expense_type");
		$q9 = mysqli_query($con,"truncate from feedback");
		$q10 = mysqli_query($con,"truncate from fee_header");
		$q11 = mysqli_query($con,"truncate from grade");
		$q12 = mysqli_query($con,"truncate from installed_app");
		$q13 = mysqli_query($con,"truncate from log");
		$q14 = mysqli_query($con,"truncate from marks");
		$q15 = mysqli_query($con,"truncate from previous_fees");
		$q16 = mysqli_query($con,"truncate from remedy");
		$q17 = mysqli_query($con,"truncate from staff");		
		$q18 = mysqli_query($con,"truncate from students");
		$q19 = mysqli_query($con,"truncate from student_daily_attendance");
		$q20 = mysqli_query($con,"truncate from student_due_fees");
		$q21 = mysqli_query($con,"truncate from student_leave");
		$q22 = mysqli_query($con,"truncate from student_notifications");
		$q23 = mysqli_query($con,"truncate from student_restrict");
		$q24 = mysqli_query($con,"truncate from student_route");
		$q25 = mysqli_query($con,"truncate from student_wise_fees");
		$q26 = mysqli_query($con,"truncate from subject");
		$q27 = mysqli_query($con,"truncate from subjectwise_attendance");
		$q28 = mysqli_query($con,"truncate from test");
		$q29 = mysqli_query($con,"truncate from time_table");
		$q30 = mysqli_query($con,"truncate from transports");
		$q31= mysqli_query($con,"truncate from section");
		$q32 = mysqli_query($con,"truncate from class");
				
		echo "<script>alert('Database Cleared Successfully');window.location='dashboard.php?option=clear_database'</script>";
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
  <span class="breadcrumb-item active">Clear Full Database
</span>
</nav>
<!-- breadcrumb -->	
		
		  <div class="content mt-3">	
		 <div class="col-lg-6">
                    <div class="card"  style="width:500px;">
                      <div class="card-header">
                        <strong>Clear Full Database</strong>	
                      </div>
						<div class="card-body card-block">
                        <form method="post" enctype="multipart/form-data" class="form-horizontal" id="formElem">
                          						
							<div class="row form-group">
                            <div class="col-md-12">
							<input type="submit" name="clear" value="CLICK" class="btn btn-danger" style="width:100px;border-radius:20px;margin-left:10px;"/>
							<span style="color:red;font-weight:bold;margin-left:10px">Click To Clear Full Database</span>
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
