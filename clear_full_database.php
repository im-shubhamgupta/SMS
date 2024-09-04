<?php

//error_reporting(1);

//include('connection.php');

// extract($_REQUEST);



// if(isset($clear))

// 	{

	/*	

		$q1 = mysqli_query($con,"TRUNCATE table assign_clsteacher");

		$qr1 = mysqli_query($con,"ALTER TABLE assign_clsteacher AUTO_INCREMENT = 1");

		

		$q2 = mysqli_query($con,"TRUNCATE table assign_custome_group");

		$qr2 = mysqli_query($con,"ALTER TABLE assign_custome_group AUTO_INCREMENT = 1");

		

		$q3 = mysqli_query($con,"TRUNCATE table assign_fee_class");

		$qr3 = mysqli_query($con,"ALTER TABLE assign_fee_class AUTO_INCREMENT = 1");

		

		$q4 = mysqli_query($con,"TRUNCATE table assign_subject");

		$qr4 = mysqli_query($con,"ALTER TABLE assign_subject AUTO_INCREMENT = 1");

		

		$q5 = mysqli_query($con,"TRUNCATE table custome_group");

		$qr5 = mysqli_query($con,"ALTER TABLE custome_group AUTO_INCREMENT = 1");

		

		$q6 = mysqli_query($con,"TRUNCATE table events");

		$qr6 = mysqli_query($con,"ALTER TABLE events AUTO_INCREMENT = 1");

		

		$q7 = mysqli_query($con,"TRUNCATE table expense");

		$qr7 = mysqli_query($con,"ALTER TABLE expense AUTO_INCREMENT = 1");

		

		$q8 = mysqli_query($con,"TRUNCATE table expense_type");

		$qr8 = mysqli_query($con,"ALTER TABLE expense_type AUTO_INCREMENT = 1");

		

		$q9 = mysqli_query($con,"TRUNCATE table feedback");

		$qr9 = mysqli_query($con,"ALTER TABLE feedback AUTO_INCREMENT = 1");

		

		$q10 = mysqli_query($con,"TRUNCATE table fee_header");

		$qr10 = mysqli_query($con,"ALTER TABLE fee_header AUTO_INCREMENT = 1");

		

		$q11 = mysqli_query($con,"TRUNCATE table grade");

		$qr11 = mysqli_query($con,"ALTER TABLE grade AUTO_INCREMENT = 1");

		

		$q12 = mysqli_query($con,"TRUNCATE table installed_app");

		$qr12 = mysqli_query($con,"ALTER TABLE installed_app AUTO_INCREMENT = 1");

		

		$q13 = mysqli_query($con,"TRUNCATE table log");

		$qr13 = mysqli_query($con,"ALTER TABLE log AUTO_INCREMENT = 1");

		

		$q14 = mysqli_query($con,"TRUNCATE table marks");

		$qr14 = mysqli_query($con,"ALTER TABLE marks AUTO_INCREMENT = 1");

		

		$q15 = mysqli_query($con,"TRUNCATE table previous_fees");

		$qr15 = mysqli_query($con,"ALTER TABLE previous_fees AUTO_INCREMENT = 1");

		

		$q16 = mysqli_query($con,"TRUNCATE table remedy");

		$qr16 = mysqli_query($con,"ALTER TABLE remedy AUTO_INCREMENT = 1");

		

		$q17 = mysqli_query($con,"TRUNCATE table students");

		$qr17 = mysqli_query($con,"ALTER TABLE students AUTO_INCREMENT = 1");

		

		$q18 = mysqli_query($con,"TRUNCATE table student_daily_attendance");

		$qr18 = mysqli_query($con,"ALTER TABLE student_daily_attendance AUTO_INCREMENT = 1");

		

		$q19 = mysqli_query($con,"TRUNCATE table student_due_fees");

		$qr19 = mysqli_query($con,"ALTER TABLE student_due_fees AUTO_INCREMENT = 1");

		

		$q20 = mysqli_query($con,"TRUNCATE table student_leave");

		$qr20 = mysqli_query($con,"ALTER TABLE student_leave AUTO_INCREMENT = 1");

		

		$q21 = mysqli_query($con,"TRUNCATE table student_notifications");

		$qr21 = mysqli_query($con,"ALTER TABLE student_notifications AUTO_INCREMENT = 1");

		

		$q22 = mysqli_query($con,"update student_restrict set total_students='0'");

		$qr22 = mysqli_query($con,"ALTER TABLE student_restrict AUTO_INCREMENT = 1");

		

		$q23 = mysqli_query($con,"TRUNCATE table student_route");

		$qr23 = mysqli_query($con,"ALTER TABLE student_route AUTO_INCREMENT = 1");

		

		$q24 = mysqli_query($con,"TRUNCATE table student_wise_fees");

		$qr24 = mysqli_query($con,"ALTER TABLE student_wise_fees AUTO_INCREMENT = 1");

		

		$q25 = mysqli_query($con,"TRUNCATE table subjectwise_attendance");

		$qr25 = mysqli_query($con,"ALTER TABLE subjectwise_attendance AUTO_INCREMENT = 1");

		

		$q26 = mysqli_query($con,"TRUNCATE table test");

		$qr26 = mysqli_query($con,"ALTER TABLE test AUTO_INCREMENT = 1");

		

		$q27 = mysqli_query($con,"TRUNCATE table time_table");

		$qr27 = mysqli_query($con,"ALTER TABLE time_table AUTO_INCREMENT = 1");

		

		$q28 = mysqli_query($con,"TRUNCATE table transports");

		$qr28 = mysqli_query($con,"ALTER TABLE transports AUTO_INCREMENT = 1");

		

		$q29 = mysqli_query($con,"TRUNCATE table setting");

		$qr29 = mysqli_query($con,"ALTER TABLE setting AUTO_INCREMENT = 1");

		

		$q30 = mysqli_query($con,"TRUNCATE table assign_department");

		$qr30 = mysqli_query($con,"ALTER TABLE assign_department AUTO_INCREMENT = 1");

		

		$q31 = mysqli_query($con,"TRUNCATE table department");

		$qr31 = mysqli_query($con,"ALTER TABLE department AUTO_INCREMENT = 1");

		

		$q32 = mysqli_query($con,"delete from staff");		

		$qr32 = mysqli_query($con,"ALTER TABLE staff AUTO_INCREMENT = 1");

		

		$q33 = mysqli_query($con,"delete from subject");

		$qr33 = mysqli_query($con,"ALTER TABLE subject AUTO_INCREMENT = 1");

		

		$q34 = mysqli_query($con,"delete from section");

		$qr34 = mysqli_query($con,"ALTER TABLE section AUTO_INCREMENT = 1");

		

		$q35 = mysqli_query($con,"delete from class");

		$qr35 = mysqli_query($con,"ALTER TABLE class AUTO_INCREMENT = 1");

		

		$q36 = mysqli_query($con,"TRUNCATE table stock_type");

		$qr36 = mysqli_query($con,"ALTER TABLE stock_type AUTO_INCREMENT = 1");

		

		$q37 = mysqli_query($con,"TRUNCATE table stock_vendor");

		$qr37 = mysqli_query($con,"ALTER TABLE stock_vendor AUTO_INCREMENT = 1");

		

		$q38 = mysqli_query($con,"TRUNCATE table purchase_order");

		$qr38 = mysqli_query($con,"ALTER TABLE purchase_order AUTO_INCREMENT = 1");

		

		$q39 = mysqli_query($con,"TRUNCATE table issue_order");

		$qr39 = mysqli_query($con,"ALTER TABLE issue_order AUTO_INCREMENT = 1");

		

		$q40 = mysqli_query($con,"TRUNCATE table return_stock");

		$qr40 = mysqli_query($con,"ALTER TABLE return_stock AUTO_INCREMENT = 1");

		

		$q41 = mysqli_query($con,"TRUNCATE table book_type");

		$qr41 = mysqli_query($con,"ALTER TABLE book_type AUTO_INCREMENT = 1");

		

		$q42 = mysqli_query($con,"TRUNCATE table branch");

		$qr42 = mysqli_query($con,"ALTER TABLE branch AUTO_INCREMENT = 1");

		

		$q43 = mysqli_query($con,"TRUNCATE table vendor");

		$qr43 = mysqli_query($con,"ALTER TABLE vendor AUTO_INCREMENT = 1");

		

		$q44 = mysqli_query($con,"TRUNCATE table publisher");

		$qr44 = mysqli_query($con,"ALTER TABLE publisher AUTO_INCREMENT = 1");

		

		$q45 = mysqli_query($con,"TRUNCATE table books");

		$qr45 = mysqli_query($con,"ALTER TABLE books AUTO_INCREMENT = 1");

		

		$q46 = mysqli_query($con,"TRUNCATE table book_return_type");

		$qr46 = mysqli_query($con,"ALTER TABLE book_return_type AUTO_INCREMENT = 1");

		

		$q47 = mysqli_query($con,"delete from issue_bookto_students");

		$qr47 = mysqli_query($con,"ALTER TABLE issue_bookto_students AUTO_INCREMENT = 1");

		

		$q48 = mysqli_query($con,"delete from issue_bookto_faculty");

		$qr48 = mysqli_query($con,"ALTER TABLE issue_bookto_faculty AUTO_INCREMENT = 1");

		

		$q49 = mysqli_query($con,"delete from library_payment");

		$qr49 = mysqli_query($con,"ALTER TABLE library_payment AUTO_INCREMENT = 1");

		

		$q50 = mysqli_query($con,"TRUNCATE table allocate_budget_expense");

		$qr50 = mysqli_query($con,"ALTER TABLE allocate_budget_expense AUTO_INCREMENT = 1");

		

		$q51 = mysqli_query($con,"TRUNCATE table allocate_budget");

		$qr51 = mysqli_query($con,"ALTER TABLE allocate_budget AUTO_INCREMENT = 1");

		

		$q52 = mysqli_query($con,"TRUNCATE table budget_header");

		$qr52 = mysqli_query($con,"ALTER TABLE budget_header AUTO_INCREMENT = 1");

		

		$q53 = mysqli_query($con,"TRUNCATE table driver");

		$qr53 = mysqli_query($con,"ALTER TABLE driver AUTO_INCREMENT = 1");

		

		$q54 = mysqli_query($con,"TRUNCATE table vehicle");

		$qr54 = mysqli_query($con,"ALTER TABLE vehicle AUTO_INCREMENT = 1");

		

		$q55 = mysqli_query($con,"TRUNCATE table activity_history");

		$qr55 = mysqli_query($con,"ALTER TABLE activity_history AUTO_INCREMENT = 1");

		

		$q56 = mysqli_query($con,"TRUNCATE table admission");

		$qr56 = mysqli_query($con,"ALTER TABLE admission AUTO_INCREMENT = 1");

		

		$q57 = mysqli_query($con,"TRUNCATE table assign_driver_route");

		$qr57 = mysqli_query($con,"ALTER TABLE assign_driver_route AUTO_INCREMENT = 1");

		

		$q58 = mysqli_query($con,"TRUNCATE table assign_syllabus_staff");

		$qr58 = mysqli_query($con,"ALTER TABLE assign_syllabus_staff AUTO_INCREMENT = 1");

		

		$q59 = mysqli_query($con,"TRUNCATE table certificate_download");

		$qr59 = mysqli_query($con,"ALTER TABLE certificate_download AUTO_INCREMENT = 1");

		

		$q60 = mysqli_query($con,"TRUNCATE table previous_transport_fees");

		$qr60 = mysqli_query($con,"ALTER TABLE previous_transport_fees AUTO_INCREMENT = 1");

		

		$q61 = mysqli_query($con,"TRUNCATE table purge_data");

		$qr61 = mysqli_query($con,"ALTER TABLE purge_data AUTO_INCREMENT = 1");

		

		$q62 = mysqli_query($con,"TRUNCATE table staff_notifications");

		$qr62 = mysqli_query($con,"ALTER TABLE staff_notifications AUTO_INCREMENT = 1");

		

		$q63 = mysqli_query($con,"TRUNCATE table staff_timetable");

		$qr63 = mysqli_query($con,"ALTER TABLE staff_timetable AUTO_INCREMENT = 1");

		

		$q64 = mysqli_query($con,"TRUNCATE table student_transport_due_fees");

		$qr64 = mysqli_query($con,"ALTER TABLE student_transport_due_fees AUTO_INCREMENT = 1");

		

		$q65 = mysqli_query($con,"TRUNCATE table voice_message");

		$qr65 = mysqli_query($con,"ALTER TABLE voice_message AUTO_INCREMENT = 1");

				
*/
		

		

		//SET FOREIGN_KEY_CHECKS = 1;		

	// 	echo "<script>alert('Database Cleared Successfully');window.location='dashboard.php?option=clear_full_database'</script>";

	// }

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

