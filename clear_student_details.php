<?php

error_reporting(1);
/*
include('connection.php');

extract($_REQUEST);

$query=mysqli_query($con,"select * table sms_setting");

$res=mysqli_fetch_array($query);





if(isset($clear))

	{

		$q1 = mysqli_query($con,"TRUNCATE table expense");

		$qr1 = mysqli_query($con,"ALTER TABLE expense AUTO_INCREMENT = 1");

		

		$q2 = mysqli_query($con,"TRUNCATE table installed_app");

		$qr2 = mysqli_query($con,"ALTER TABLE installed_app AUTO_INCREMENT = 1");

		

		$q3 = mysqli_query($con,"TRUNCATE table log");

		$qr3 = mysqli_query($con,"ALTER TABLE log AUTO_INCREMENT = 1");

		

		$q4 = mysqli_query($con,"TRUNCATE table marks");

		$qr4 = mysqli_query($con,"ALTER TABLE marks AUTO_INCREMENT = 1");

		

		$q5 = mysqli_query($con,"TRUNCATE table previous_fees");

		$qr5 = mysqli_query($con,"ALTER TABLE previous_fees AUTO_INCREMENT = 1");

		

		$q6 = mysqli_query($con,"TRUNCATE table remedy");

		$qr6 = mysqli_query($con,"ALTER TABLE remedy AUTO_INCREMENT = 1");

		

		$q7 = mysqli_query($con,"TRUNCATE table feedback");

		$qr7 = mysqli_query($con,"ALTER TABLE feedback AUTO_INCREMENT = 1");

		

		$q8 = mysqli_query($con,"TRUNCATE table students");

		$qr8 = mysqli_query($con,"ALTER TABLE students AUTO_INCREMENT = 1");

		

		$q9 = mysqli_query($con,"TRUNCATE table student_daily_attendance");

		$qr9 = mysqli_query($con,"ALTER TABLE student_daily_attendance AUTO_INCREMENT = 1");

		

		$q10 = mysqli_query($con,"TRUNCATE table student_due_fees");

		$qr10 = mysqli_query($con,"ALTER TABLE student_due_fees AUTO_INCREMENT = 1");

		

		$q11 = mysqli_query($con,"TRUNCATE table student_leave");

		$qr11 = mysqli_query($con,"ALTER TABLE student_leave AUTO_INCREMENT = 1");

		

		$q12 = mysqli_query($con,"TRUNCATE table student_notifications");

		$qr12 = mysqli_query($con,"ALTER TABLE student_notifications AUTO_INCREMENT = 1");

		

		$q13 = mysqli_query($con,"TRUNCATE table student_route");

		$qr13 = mysqli_query($con,"ALTER TABLE student_route AUTO_INCREMENT = 1");

		

		$q14 = mysqli_query($con,"TRUNCATE table student_wise_fees");

		$qr14 = mysqli_query($con,"ALTER TABLE student_wise_fees AUTO_INCREMENT = 1");

		

		$q15 = mysqli_query($con,"TRUNCATE table subjectwise_attendance");

		$qr15 = mysqli_query($con,"ALTER TABLE subjectwise_attendance AUTO_INCREMENT = 1");

		

		$q16 = mysqli_query($con,"TRUNCATE table assign_custome_group");

		$qr16 = mysqli_query($con,"ALTER TABLE assign_custome_group AUTO_INCREMENT = 1");

				

		echo "<script>alert('Database Cleared Successfully');window.location='dashboard.php?option=clear_student_details'</script>";

	}
*/
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

