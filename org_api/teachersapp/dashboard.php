<?php
	session_start();
	extract($_REQUEST);
	include('connection.php');
	if($_SESSION['user_logged_in']=="")
	{
		header('location:index.php');
	}
	require('connection.php');

	$sql=mysqli_query($con,"select * from users where email='".$_SESSION['user_logged_in']."'");
	
	$res=mysqli_fetch_array($sql);
	
	$roles=$_SESSION['user_roles'];
	
?>
<!doctype html>
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Institute Fees Management | Admin Dashboard</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="vendors/jqvmap/dist/jqvmap.min.css">
	<link rel="stylesheet" href="vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
	
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
</head>
<body>
   
   <?php include('sidebar.php')?>
   
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
		 <!-- Header-->
        <?php include('header.php'); ?>
        
        <div class="content mt-3">
			<?php 
			@$opt=$_GET['option'];
			switch($opt)
			{
			
			//View Section Starts Here	
			case 'view_class';
			include('view_class.php');
			break;	
				
			case 'view_section';
			include('view_section.php');
			break;	
			
			case 'view_route';
			include('view_route.php');
			break;	
				
			case 'view_transport';
			include('view_transport.php');
			break;

			case 'view_transports';
			include('view_transports.php');
			break;

			case 'view_route_to_student';
			include('view_route_to_student.php');
			break;

			case 'view_student';
			include('view_student.php');
			break;

			case 'view_students';
			include('view_students.php');
			break;			

			case 'view_student_details';
			include('view_student_details.php');
			break;	
			
			case 'view_students_details';
			include('view_students_details.php');
			break;	

			case 'view_fees_header';
			include('view_fees_header.php');
			break;

			case 'view_assign_fees_to_class';
			include('view_assign_fees_to_class.php');
			break;
			
			case 'view_assign_fees_students';
			include('view_assign_fees_students.php');
			break;
			
			case 'view_fees';
			include('view_fees.php');
			break;
			
			case 'view_student_fees_detail';
			include('view_student_fees_detail.php');
			break;
			
			case 'view_payment';
			include('view_payment.php');
			break;
			
			case 'view_setting';
			include('view_setting.php');
			break;
			
			case 'view_bill';
			include('view_bill.php');
			break;
			
			case 'view_student_history';
			include('view_student_history.php');
			break;
			
			case 'student_history';
			include('student_history.php');
			break;
			
			case 'view_user';
			include('view_user.php');
			break;
			
			case 'upload_students';
			include('upload_students.php');
			break;
			
			case 'upload_students_route';
			include('upload_students_route.php');
			break;
			
			case 'view_expense_type';
			include('view_expense_type.php');
			break;
			
			case 'view_expense';
			include('view_expense.php');
			break;
			
			case 'expense_report';
			include('expense_report.php');
			break;
			
			case 'view_notification';
			include('view_notification.php');
			break;
			
			case 'view_academic_yr';
			include('view_academic_yr.php');
			break;
			
			case 'view_logs';
			include('view_logs.php');
			break;
			
			case 'view_discount_students';
			include('view_discount_students.php');
			break; 
			
			case 'view_transport_availed';
			include('view_transport_availed.php');
			break;
			
			case 'view_subject';
			include('view_subject.php');
			break;
			
			case 'view_staff';
			include('view_staff.php');
			break;
			
			case 'assign_subject';
			include('assign_subject.php');
			break;
			
			case 'view_assign_subject';
			include('view_assign_subject.php');
			break;
			
			case 'edit_assigned_subject';
			include('edit_assigned_subject.php');
			break;
			
			case 'edit_assigned_classteacher';
			include('edit_assigned_classteacher.php');
			break;
			
			case 'assign_classteacher';
			include('assign_classteacher.php');
			break;
			
			case 'view_assign_classteacher';
			include('view_assign_classteacher.php');
			break;
			
			case 'view_student_attendance';
			include('view_student_attendance.php');
			break;
			
			case 'stu_daily_attendance';
			include('stu_daily_attendance.php');
			break;
			
			case 'student_notification';
			include('student_notification.php');
			break;
			
			case 'view_student_notification';
			include('view_student_notification.php');
			break;
			
			case 'studentwise_daily_att_report';
			include('studentwise_daily_att_report.php');
			break;
			
			case 'classwise_daily_att_report';
			include('classwise_daily_att_report.php');
			break;
			
			case 'yearly_report';
			include('yearly_report.php');
			break;
			
			case 'subject_yearly_report';
			include('subject_yearly_report.php');
			break;
			
			case 'studentwise_att_report';
			include('studentwise_att_report.php');
			break;
			
			case 'classwise_att_report';
			include('classwise_att_report.php');
			break;
			
			case 'subjectwise_att_report';
			include('subjectwise_att_report.php');
			break;
			
			case 'subject_wise_attendance';
			include('subject_wise_attendance.php');
			break;
			
			case 'view_send_attendance';
			include('view_send_attendance.php');
			break;
			
			case 'view_report';
			include('view_report.php');
			break;
			
			case 'assign_grade';
			include('assign_grade.php');
			break;
		
			case 'view_grade';
			include('view_grade.php');
			break;
			
			case 'student_notification_copy';
			include('student_notification_copy.php');
			break;
			
			case 'view_appinstalled_detail';
			include('view_appinstalled_detail.php');
			break;
			
			case 'leave_request';
			include('leave_request.php');
			break;
			
			case 'approve_leaves';
			include('approve_leaves.php');
			break;
			
			case 'view_leave_report';
			include('view_leave_report.php');
			break;
			
			case 'create_event';
			include('create_event.php');
			break;
			
			case 'view_event_calendar';
			include('view_event_calendar.php');
			break;
			
			case 'edit_event_calendar';
			include('edit_event_calendar.php');
			break;
			
			case 'delete_event';
			include('delete_event.php');
			break;
			
			case 'delete_assigned_subject';
			include('delete_assigned_subject.php');
			break;
			
			case 'delete_assigned_classteacher';
			include('delete_assigned_classteacher.php');
			break;
			
			case 'create_feedback';
			include('create_feedback.php');
			break;
			
			case 'response_feedback';
			include('response_feedback.php');
			break;
			
			case 'view_feedback_response';
			include('view_feedback_response.php');
			break;
			
			case 'create_previous_fees';
			include('create_previous_fees.php');
			break;
			
			case 'view_previous_fees';
			include('view_previous_fees.php');
			break;
			
			case 'edit_prev_fees';
			include('edit_prev_fees.php');
			break;
			
			case 'delete_prev_fees';
			include('delete_prev_fees.php');
			break;
			
			case 'upload_previous_fees';
			include('upload_previous_fees.php');
			break;
			
			case 'create_group';
			include('create_group.php');
			break;
			
			case 'view_group';
			include('view_group.php');
			break;
			
			case 'updategroup';
			include('updategroup.php');
			break;
			
			case 'assign_students_group';
			include('assign_students_group.php');
			break;
			
			case 'view_group_students';
			include('view_group_students.php');
			break;
			
			case 'send_custome_notification';
			include('send_custome_notification.php');
			break;
			
			case 'view_custome_notification';
			include('view_custome_notification.php');
			break;
			
			case 'view_scheduled_notification';
			include('view_scheduled_notification.php');
			break;
			
			case 'create_remedy';
			include('create_remedy.php');
			break;
			
			case 'view_remedy';
			include('view_remedy.php');
			break;
			
			case 'update_remedy';
			include('update_remedy.php');
			break;
			
			case 'approve_remedy';
			include('approve_remedy.php');
			break;
			
			case 'view_approval_remedy';
			include('view_approval_remedy.php');
			break;
			
			//View Section Close Here


			//Add Section Starts Here	
			case 'add_class';
			include('add_class.php');
			break;	
					
			case 'add_section';
			include('add_section.php');
			break;
			
			case 'add_route';
			include('add_route.php');
			break;
			
			case 'add_transports';
			include('add_transports.php');
			break;
			
			case 'add_transport';
			include('add_transport.php');
			break;
			
			case 'add_fees_header';
			include('add_fees_header.php');
			break;
			
			case 'assign_fees_to_class';
			include('assign_fees_to_class.php');
			break;
			
			case 'assign_fees_to_students';
			include('assign_fees_to_students.php');
			break;
			
			case 'assign_route_to_student';
			include('assign_route_to_student.php');
			break;
			
			case 'add_fees';
			include('add_fees.php');
			break;	
			
			case 'add_students';
			include('add_students.php');
			break;
			
			case 'add_user';
			include('add_user.php');
			break;
			
			case 'generate_bill';
			include('generate_bill.php');
			break;
			
			case 'add_expense';
			include('add_expense.php');
			break;
			
			case 'add_expense_type';
			include('add_expense_type.php');
			break;
			
			case 'send_notification';
			include('send_notification.php');
			break;
			
			case 'add_academic_yr';
			include('add_academic_yr.php');
			break;
			
			case 'add_subject';
			include('add_subject.php');
			break;
			
			case 'add_staff';
			include('add_staff.php');
			break;
			
			case 'create_test';
			include('create_test.php');
			break;
			
			case 'marks_entry';
			include('marks_entry.php');
			break;
			
			case 'create_timetable';
			include('create_timetable.php');
			break;
			
			case 'view_timetable';
			include('view_timetable.php');
			break;
			
			case 'update_timetable';
			include('update_timetable.php');
			break;
			//Add Section Close Here	
			
			//Update Section Starts Here
			case 'update_admin';
			include('update_admin.php');
			break;	
			
			case 'updateclass';
			include('updateclass.php');
			break;	
			
			case 'update_section';
			include('update_section.php');
			break;	

			case 'update_route';
			include('update_route.php');
			break;
			
			case 'update_fees_header';
			include('update_fees_header.php');
			break;
			
			case 'update_fees';
			include('update_fees.php');
			break;
			
			case 'update_assign_fees_to_class';
			include('update_assign_fees_to_class.php');
			break;
			
			case 'update_transport';
			include('update_transport.php');
			break;
			
			case 'update_transports';
			include('update_transports.php');
			break;

			case 'update_student';
			include('update_student.php');
			break;
			
			case 'update_students';
			include('update_students.php');
			break;
			
			case 'update_paidstudents';
			include('update_paidstudents.php');
			break;
			
			case 'view_edit_inst_setting';
			include('view_edit_inst_setting.php');
			break;
			
			case 'view_edit_smssetting';
			include('view_edit_smssetting.php');
			break;
			
			case 'update_sms_status';
			include('update_sms_status.php');
			break;
			
			case 'edit_sms_setting';
			include('edit_sms_setting.php');
			break;
			
			case 'edit_assign_fees_students';
			include('edit_assign_fees_students.php');
			break;
			
			case 'edit_assign_route_to_student';
			include('edit_assign_route_to_student.php');
			break;
			
			case 'update_user';
			include('update_user.php');
			break;
			
			case 'update_expense';
			include('update_expense.php');
			break;
			
			case 'updateexpense';
			include('updateexpense.php');
			break;
			
			case 'student_restrict';
			include('student_restrict.php');
			break;
			
			case 'update_academic_yr';
			include('update_academic_yr.php');
			break;
			
			case 'update_section';
			include('update_section.php');
			break;
			
			case 'update_subject';
			include('update_subject.php');
			break;	
			
			case 'update_staff';
			include('update_staff.php');
			break;

			case 'update_test';
			include('update_test.php');
			break;
			
			case 'attendance_type';
			include('attendance_type.php');
			break;

			case 'update_grade';
			include('update_grade.php');
			break;
			
			case 'update_leave_approve';
			include('update_leave_approve.php');
			break;
			
			case 'update_leave_disapprove';
			include('update_leave_disapprove.php');
			break;
			
			case 'clear_full_database';
			include('clear_full_database.php');
			break;
			
			case 'clear_student_details';
			include('clear_student_details.php');
			break;
			//Update Section Close Here	
			
			
			//Delete Section Starts Here	
			case 'delete_academic_yr';
			include('delete_academic_yr.php');
			break;
			
			case 'delete_test';
			include('delete_test.php');
			break;
			//Delete Section Close Here		
			
			
			//Report Section Starts Here
			
			case 'paidstudents_report';
			include('paidstudents_report.php');
			break;	
			
			case 'duestudents_report';
			include('duestudents_report.php');
			break;
			
			case 'duestudents_report';
			include('duestudents_report.php');
			break;

			case 'duestudents_leftjoin';
			include('duestudents_leftjoin.php');
			break;
			
			case 'dues_report';
			include('dues_report.php');
			break;
			
			case 'genbill';
			include('genbill.php');
			break;
			
			case 'genbillprint';
			include('genbillprint.php');
			break;
			
			
			
			//Report Section Starts Here	
					
			case '';
			include('reports.php');
			break;		
			}
			?>	
        </div> 
    </div>
	<!-- /#right-panel -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	
    <script>
        (function($) {
            "use strict";

            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#1de9b6', '#03a9f5'],
                normalizeFunction: 'polynomial'
            });
        })(jQuery);
    </script>
</body>
</html>