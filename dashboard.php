<?php
ini_set('display_errors', 1);
	    ini_set('display_startup_errors', 1);
	    error_reporting(E_ALL);
session_start();	
	extract($_REQUEST);
	include('connection.php');
	include('myfunction.php');
	
	if($_SESSION['user_logged_in']=="")
	{
		header('location:index.php');
	}
	
	//For Activity History//
	
	date_default_timezone_set('Asia/Kolkata');
	$currdt = date("Y-m-d H:i:s");
	
	$sql=mysqli_query($con,"select * from users where email='".$_SESSION['user_logged_in']."'");
	
	$res=mysqli_fetch_array($sql);
	
	$roles=$_SESSION['user_roles'];
	
	$submenuid = $_REQUEST['smid'];
	$q = mysqli_query($con,"select * from sub_menu where sub_menu_id='$submenuid'");
	$r = mysqli_fetch_array($q);
	// print_r($r);
	$submenuname = $r['sub_menu_name'];
	
	$menuid = $r['menu_id'];
	if(!empty($menuid)){
		$menuid = $menuid;
	}else{
		$menuid = 0;
	}
	$panelid = $r['panel_id'];
	if(!empty($panelid)){
		$panelid = $panelid;
	}else{
		$panelid = 0;
	}
	$machinename = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];
	if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
		// OPERA
		$ExactBrowserNameBR="Opera";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
		// CHROME
		$ExactBrowserNameBR="Chrome";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
		// INTERNET EXPLORER
		$ExactBrowserNameBR="Internet Explorer";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
		// FIREFOX
		$ExactBrowserNameBR="Firefox";
	} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
		// SAFARI
		$ExactBrowserNameBR="Safari";
	} else {
		// OUT OF DATA
		$ExactBrowserNameBR="OUT OF DATA";
	};
	if(!isset($_SESSION['machinename']) ){
		$_SESSION['machinename']=$machinename;
	}
	if(!isset($_SESSION['ExactBrowserNameBR']) ){
		$_SESSION['ExactBrowserNameBR']=$ExactBrowserNameBR;
	}
	//For Activity History//
?>
<!doctype html>
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <!-- <title>Institute Fees Management | Admin Dashboard</title> -->
    <title><?= get_school_details()['company_name']?? ''?> | Admin Dashboard</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
    <link rel="apple-touch-icon" href="apple-icon.png">
    <!-- <link rel="shortcut icon" href="favicon.ico"> -->
    <link rel="shortcut icon" href="images/profile/<?=get_school_details()['company_image']?? ''?>">
	<link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
	<!-- upgrade to new bootstrap 5  -->
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
	<!--end upgrade to new bootstrap 5  -->
    <!-- <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="vendors/jqvmap/dist/jqvmap.min.css">


	<!-- <link rel="stylesheet" href="vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"> -->




	<link rel="stylesheet" href="vendors/datatables.net-bs4/css/dataTables.bootstrap5.min.css">
     <link rel="stylesheet" href="vendors/datatables.net-buttons-bs4/css/buttons.bootstrap5.min.css">



    <link rel="stylesheet"  type="text/css" href="assets/css/style.css">
	<link rel="stylesheet"  type="text/css" href="assets/css/custom_style.css">
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
	
	<link href="datejquery/jquery.datepicker2.css" rel="stylesheet">
	<!-- show adds -->
<!-- <script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js"></script> 	 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">     


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<!-- External Stylesheet -->
	<link rel="stylesheet" type="text/css" href="vendors/style.css">
	
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}



</style>
    
</head>

<script>
	$(document).ready(function() {
	// $("#fromdate,#todate").datepicker({  
  	// maxDate: new Date(),
  	// dateFormat: 'dd-mm-yy',
	// changeYear:true,
	// changeMonth:true,
	// });
  
  // $('.fa-calendar').click(function() {
    // $("#datepicker").focus();
  // });
  
	});
</script>
  
<body>
   
   <?php


    include('sidebar.php')?>
   <?php
   // echo "<pre>";print_r($_SESSION);  echo "</pre>";
   ?>
    <!-- Right Panel -->
    <div id="right-view" class="right-panel">
		 <!-- Header-->
        <?php include('header.php'); ?>
          
        <div class="content mt-3">
		
		
		
			<?php 
			  @$opt=$_GET['option'];
			switch($opt)
			{
			
			case 'certificate';
			include('certificate.php');
			break;
			
			case 'create_cert1';
			include('create_cert1.php');
			break;
			
			case 'create_cert2';
			include('create_cert2.php');
			break;
			
			case 'create_cert3';
			include('create_cert3.php');
			break;
			
			case 'download_cert';
			include('download_cert.php');
			break;
			
			case 'cert_pdf';
			include('cert_pdf.php');
			break;
		
			
			//View Section Starts Here	
			case 'view_class';
			include('view_class.php');
			break;	
				
			case 'view_section';
			include('view_section.php');
			break;	
			
			// case 'view_route';
			// include('view_route.php');
			// break;	
			
			//Transport	
			case 'view_driver';
			include('view_driver.php');
			break;
			
			case 'add_driver';
			include('add_driver.php');
			break;
			
			case 'update_driver';
			include('update_driver.php');
			break;
			
			case 'view_vehicle';
			include('view_vehicle.php');
			break;
			
			case 'add_vehicle';
			include('add_vehicle.php');
			break;
			
			case 'update_vehicle';
			include('update_vehicle.php');
			break;
			
			case 'view_assign_driver_route';
			include('view_assign_driver_route.php');
			break;
			
			case 'assign_driver_route';
			include('assign_driver_route.php');
			break;
			
			case 'update_assign_driver_route';
			include('update_assign_driver_route.php');
			break;
			
			case 'delete_assigned_driver';
			include('delete_assigned_driver.php');
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
			
			case 'view_transport_fee_detail';
			include('view_transport_fee_detail.php');
			break;
			
			case 'view_transport_payment';
			include('view_transport_payment.php');
			break;
			
			case 'paid_transport_report';
			include('paid_transport_report.php');
			break;
			
			case 'due_transport_report';
			include('due_transport_report.php');
			break;
			
			case 'deleted_transport_report';
			include('deleted_transport_report.php');
			break;

			case 'view_transport_expense_type';
			include('view_transport_expense_type.php');
			break;

			case 'add_transport_expense_type';
			include('add_transport_expense_type.php');
			break;

			case 'update_trans_expense_type';
			include('update_trans_expense_type.php');
			break;

			case 'view_transport_expense';
			include('view_transport_expense.php');
			break;

			case 'add_transport_expense';
			include('add_transport_expense.php');
			break;

			case 'update_trans_expense';
			include('update_trans_expense.php');
			break;
			
			case 'trans_exp_report';
			include('trans_exp_report.php');
			break;
			//Transport	
			
			
			
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

			case 'edit_assign_fees_to_class';
			include('edit_assign_fees_to_class.php');
			break;

			case 'view_late_fee_assign_to_class';
			include('view_late_fee_assign_to_class.php');
			break;

			case 'assign_late_fee_to_class';
			include('assign_late_fee_to_class.php');
			break;
			
			case 'view_assign_fees_students';
			include('view_assign_fees_students.php');
			break;
			
			case 'view_fees';
			include('view_fees.php');
			break;
			
			case 'download_student_fees';
			include('download_student_fees.php');
			break;
			
			case 'upload_student_fees';
			include('upload_student_fees.php');
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
			
			case 'upload_partial_student_details';
			include('upload_partial_student_details.php');
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
			
			case 'deleted_expenses';
			include('deleted_expenses.php');
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
			
			case 'view_activity_history';
			include('view_activity_history.php');
			break;
			
			case 'search_activity_history';
			include('search_activity_history.php');
			break;
			
			case 'view_panel';
			include('view_panel.php');
			break;
			
			case 'add_panel';
			include('add_panel.php');
			break;
			
			case 'view_menu';
			include('view_menu.php');
			break;
			
			case 'add_menu';
			include('add_menu.php');
			break;
			
			case 'view_submenu';
			include('view_submenu.php');
			break;
			
			case 'add_submenu';
			include('add_submenu.php');
			break;
			
			case 'generate_certificate';
			include('generate_certificate.php');
			break;
			
			case 'generate_hallticket';
			include('generate_hallticket.php');
			break;
			
			case 'view_purge_data';
			include('view_purge_data.php');
			break;
			
			case 'add_purge_data';
			include('add_purge_data.php');
			break;
			
			case 'update_purgedata';
			include('update_purgedata.php');
			break;
									
			case 'view_upload_student_image';
			include('view_upload_student_image.php');
			break;
			
			case 'upload_image';
			include('upload_image.php');
			break;
						
			case 'update_upload_student_image';
			include('update_upload_student_image.php');
			break;
			
			case 'view_upload_faculty_image';
			include('view_upload_faculty_image.php');
			break;
			
			case 'upload_faculty_image';
			include('upload_faculty_image.php');
			break;
			
			case 'update_upload_faculty_image';
			include('update_upload_faculty_image.php');
			break;
			
			case 'generate_idcard';
			include('generate_idcard.php');
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
			
			case 'upload_partial_staff_details';
			include('upload_partial_staff_details.php');
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
			
			case 'view_allocated_subjects_staff';
			include('view_allocated_subjects_staff.php');
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
			
			case 'view_voice_message';
			include('view_voice_message.php');
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
			
			case 'send_result';
			include('send_result.php');
			break;
			
			case 'assign_grade';
			include('assign_grade.php');
			break;
			
			case 'upload_grade';
			include('upload_grade.php');
			break;
		
			case 'view_grade';
			include('view_grade.php');
			break;
			
			case 'student_notification_copy';
			include('student_notification_copy.php');
			break;
			
			case 'student_scheduled_notification';
			include('student_scheduled_notification.php');
			break;
			
			case 'view_appinstalled_detail';
			include('view_appinstalled_detail.php');
			break;
			
			case 'view_appadoption_detail';
			include('view_appadoption_detail.php');
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
			
			//Administration Panel//
			
			case 'view_budget_header';
			include('view_budget_header.php');
			break;
			
			case 'add_budget_header';
			include('add_budget_header.php');
			break;
			
			case 'update_budget_header';
			include('update_budget_header.php');
			break;
			
			case 'view_allocate_budget';
			include('view_allocate_budget.php');
			break;
			
			case 'allocate_budget';
			include('allocate_budget.php');
			break;
			
			case 'update_allocate_budget';
			include('update_allocate_budget.php');
			break;
			
			case 'view_allocated_budget_expense';
			include('view_allocated_budget_expense.php');
			break;
			
			case 'add_budget_expense';
			include('add_budget_expense.php');
			break;
			
			case 'update_budget_expense';
			include('update_budget_expense.php');
			break;
			
			case 'allocated_budget_chart';
			include('allocated_budget_chart.php');
			break;
			
			case 'allocated_budget_expense_report';
			include('allocated_budget_expense_report.php');
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
			
			//Administration Panel//
			
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
			
			case 'view_previous_transport_fees';
			include('view_previous_transport_fees.php');
			break;
			
			case 'create_previous_transport_fees';
			include('create_previous_transport_fees.php');
			break;
			
			case 'generate_transport_bill';
			include('generate_transport_bill.php');
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
			
			case 'create_department';
			include('create_department.php');
			break;
			
			case 'view_department';
			include('view_department.php');
			break;
			
			case 'updatedepartment';
			include('updatedepartment.php');
			break;
			
			case 'assign_department';
			include('assign_department.php');
			break;
			
			case 'view_assign_department';
			include('view_assign_department.php');
			break;
			
			case 'send_staff_notification';
			include('send_staff_notification.php');
			break;
			
			case 'view_staff_notification';
			include('view_staff_notification.php');
			break;
			
			case 'upload_staff_timetable';
			include('upload_staff_timetable.php');
			break;
			
			case 'view_staff_timetable';
			include('view_staff_timetable.php');
			break;
			
			case 'view_staff_leisure';
			include('view_staff_leisure.php');
			break;
			
			case 'view_staff_leisure_periodwise';
			include('view_staff_leisure_periodwise.php');
			break;
			
			case 'assign_syllabus_staff';
			include('assign_syllabus_staff.php');
			break;
			
			case 'assign_syllabus';
			include('assign_syllabus.php');
			break;
			
			case 'upload_assign_syllabus_staff';
			include('upload_assign_syllabus_staff.php');
			break;
			
			case 'update_allocated_syllabus_status';
			include('update_allocated_syllabus_status.php');
			break;
			
			case 'update_syllabus_status';
			include('update_syllabus_status.php');
			break;
			
			case 'view_syllabus_allocated_staff';
			include('view_syllabus_allocated_staff.php');
			break;
			
			case 'update_allocated_syllabus';
			include('update_allocated_syllabus.php');
			break;
			
			case 'view_syllabus_allocation_chart';
			include('view_syllabus_allocation_chart.php');
			break;
			
			case 'view_stock_type';
			include('view_stock_type.php');
			break;
			
			case 'add_stock_type';
			include('add_stock_type.php');
			break;
			
			case 'update_stock_type';
			include('update_stock_type.php');
			break;
			
			case 'view_stock_vendor';
			include('view_stock_vendor.php');
			break;
			
			case 'add_stock_vendor';
			include('add_stock_vendor.php');
			break;
			
			case 'update_stock_vendor';
			include('update_stock_vendor.php');
			break;
			
			case 'view_purchase_order';
			include('view_purchase_order.php');
			break;
			
			case 'create_purchase_order';
			include('create_purchase_order.php');
			break;
			
			case 'update_purchase_order';
			include('update_purchase_order.php');
			break;
			
			case 'upload_purchase_order';
			include('upload_purchase_order.php');
			break;
			
			case 'issue_order';
			include('issue_order.php');
			break;
			
			case 'view_purchase_report';
			include('view_purchase_report.php');
			break;
			
			case 'view_issuedorder_report';
			include('view_issuedorder_report.php');
			break;
			
			case 'stock_available';
			include('stock_available.php');
			break;
			
			case 'return_stock';
			include('return_stock.php');
			break;

			case 'view_return_stock_report';
			include('view_return_stock_report.php');
			break;
			
			case 'dead_stock';
			include('dead_stock.php');
			break;
			
			case 'view_dead_stock_report';
			include('view_dead_stock_report.php');
			break;
			//Stock Management//
			
			//Library Management//
			
			case 'view_book_type';
			include('view_book_type.php');
			break;
			
			case 'add_book_type';
			include('add_book_type.php');
			break;
			
			case 'update_book_type';
			include('update_book_type.php');
			break;
			
			case 'view_branch';
			include('view_branch.php');
			break;
			
			case 'add_branch';
			include('add_branch.php');
			break;
			
			case 'update_branch';
			include('update_branch.php');
			break;
			
			case 'view_vendor';
			include('view_vendor.php');
			break;
			
			case 'add_vendor';
			include('add_vendor.php');
			break;
			
			case 'update_vendor';
			include('update_vendor.php');
			break;
			
			case 'view_publisher';
			include('view_publisher.php');
			break;
			
			case 'add_publisher';
			include('add_publisher.php');
			break;
			
			case 'update_publisher';
			include('update_publisher.php');
			break;
			
			case 'view_books';
			include('view_books.php');
			break;
			
			case 'add_books';
			include('add_books.php');
			break;
			
			case 'update_books';
			include('update_books.php');
			break;
			
			case 'view_book_return_type';
			include('view_book_return_type.php');
			break;
			
			case 'add_book_return_type';
			include('add_book_return_type.php');
			break;
			
			case 'update_book_return_type';
			include('update_book_return_type.php');
			break;
			
			case 'issue_bookto_student';
			include('issue_bookto_student.php');
			break;
			
			case 'issue_bookto_faculty';
			include('issue_bookto_faculty.php');
			break;
			
			case 'return_book';
			include('return_book.php');
			break;
			
			case 'book_available_detail';
			include('book_available_detail.php');
			break;
			
			case 'issuedbook_student_detail';
			include('issuedbook_student_detail.php');
			break;
			
			case 'returnedbook_student_detail';
			include('returnedbook_student_detail.php');
			break;
			
			case 'notreturnedbook_student_detail';
			include('notreturnedbook_student_detail.php');
			break;
			
			case 'issuedbook_faculty_detail';
			include('issuedbook_faculty_detail.php');
			break;
			
			case 'returnedbook_faculty_detail';
			include('returnedbook_faculty_detail.php');
			break;
			
			case 'notreturnedbook_faculty_detail';
			include('notreturnedbook_faculty_detail.php');
			break;
			
			case 'penalty_collection';
			include('penalty_collection.php');
			break;
			
			case 'library_payment';
			include('library_payment.php');
			break;
			
			case 'lib_payment_history';
			include('lib_payment_history.php');
			break;
			
			case 'nodue_certificate';
			include('nodue_certificate.php');
			break;
			
			case 'audio';
			include('audio.php');
			break;
			
			//Library Management//
			
			
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

			// case 'add_ref_students';
			// include('add_ref_students.php');
			// break;
			
			case 'add_user';
			include('add_user.php');
			break;
			
			case 'generate_bill';
			include('generate_bill.php');
			break;
			
			case 'prereprint_receipt';
			include('prereprint_receipt.php');
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
			
			case 'send_email_notification';
			include('send_email_notification.php');
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
			
			case 'create_download_format';
			include('create_download_format.php');
			break;
			
			case 'upload_marks';
			include('upload_marks.php');
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
			
			case 'upload_timetable';
			include('upload_timetable.php');
			break;
						
			case 'upload_staff';
			include('upload_staff.php');
			break;
			
			case 'upload_subject';
			include('upload_subject.php');
			break;
			
			case 'upload_assign_subject';
			include('upload_assign_subject.php');
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

			case 'view_sms_wallet';
			include('view_sms_wallet.php');
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

			case 'sms_restrict';
			include('sms_restrict.php');
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
			
			case 'auto_birthday_message';
			include('auto_birthday_message.php');
			break;
			
			case 'edit_auto_birthday';
			include('edit_auto_birthday.php');
			break;
			
			case 'previous_fees_auth';
			include('previous_fees_auth.php');
			break;
			
			case 'edit_previous_fees_auth';
			include('edit_previous_fees_auth.php');
			break;

			case 'route_student_auth';
			include('route_student_auth.php');
			break;
			
			case 'edit_route_student_auth';
			include('edit_route_student_auth.php');
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
			
			case 'clear_stock';
			include('clear_stock.php');
			break;
			
			case 'clear_library';
			include('clear_library.php');
			break;
			
			case 'clear_student_details';
			include('clear_student_details.php');
			break;
			
			case 'upload_event_calendar';
			include('upload_event_calendar.php');
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
			
			case 'discountedfees_report';
			include('discountedfees_report.php');
			break;
			
			case 'deletedfees_report';
			include('deletedfees_report.php');
			break;
			
			case 'declinedfees_report';
			include('declinedfees_report.php');
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
			
			case 'reconcile_fees';
			include('reconcile_fees.php');
			break;
			
			case 'update_declined_fees';
			include('update_declined_fees.php');
			break;
			
			case 'update_declined_fees_status';
			include('update_declined_fees_status.php');
			break;
			
			case 'approve_reconcile_fees';
			include('approve_reconcile_fees.php');
			break;
			
			case 'decline_reconcile_fees';
			include('decline_reconcile_fees.php');
			break;
			
			case 'reconcile_report';
			include('reconcile_report.php');
			break;
			
			case 'multilevel_sidebar';
			include('multilevel_sidebar.php');
			break;
			
			case 'student_report';
			include('student_report.php');
			break;
			
			case 'admission_report';
			include('admission_report.php');
			break;
			
			case 'rte_report';
			include('rte_report.php');
			break;
			
			case 'classwise_report';
			include('classwise_report.php');
			break;
			
			case 'birthday';
			include('birthday.php');
			break;
			
			case 'scheduled_message';
			include('scheduled_message.php');
			break;
			
			case 'scheduled_payment_message';
			include('scheduled_payment_message.php');
			break;
			
			case 'today_absentee_list';
			include('today_absentee_list.php');
			break;
			
			//Report Section Ends Here	
			
			//Id cards
			case 'faculty_idcard';
			include('faculty_idcard.php');
			break;
			
			case 'print_faculty_idcard';
			include('print_faculty_idcard.php');
			break;
			
			case 'student_idcard';
			include('student_idcard.php');
			break;
			
			case 'upload_signature';
			include('upload_signature.php');
			break;
			//Id cards ends
			
			//Online Admission
			case 'online_admission';
			include('online_admission.php');
			break;
			
			case 'view_online_admission';
			include('view_online_admission.php');
			break;
			
			case 'view_requested_admission';
			include('view_requested_admission.php');
			break;
			
			case 'search_with_reference';
			include('search_with_reference.php');
			break;

			case 'approve_reject_admission';
			include('approve_reject_admission.php');
			break;
			
			case 'update_admission_accept';
			include('update_admission_accept.php');
			break;
			
			case 'search_with_grade';
			include('search_with_grade.php');
			break;
			
			case 'view_accept_admission';
			include('view_accept_admission.php');
			break;
			
			case 'view_reject_admission';
			include('view_reject_admission.php');
			break;
			
			case 'upload_online_admission';
			include('upload_online_admission.php');
			break;
			//Online Admission
			
			//Data Analysis
			case 'attendance_analysis';
			include('attendance_analysis.php');
			break;
			
			case 'exam_analysis';
			include('exam_analysis.php');
			break;
			
			//Data Analysis
			
			//Student Report Card
			case 'student_reportcard';
			include('student_reportcard.php');
			break;
			
			case 'generate_student_reportcard';
			include('generate_student_reportcard.php');
			break;	
			
			case 'view_scholastic';
			include('view_scholastic.php');
			break;
			
			case 'add_scholastic_header';
			include('add_scholastic_header.php');
			break;
			
			case 'update_scholastic_heading';
			include('update_scholastic_heading.php');
			break;
			
			case 'birthday';
			include('birthday.php');
			break;
			
			case 'weeks';
			include('weeks.php');
			break;
			
			case 'assign-test-to-term';
			include('assign-exam-to-term.php');
			break;
			
			case 'assign-scholastic-grade';
			include('Scholastic-grade.php');
			break;
			
			case'assign-feest-to-students';
			include 'assign-fees-to-class-student.php';
			 break;
			 
			case'demandfee';
			include 'demandfee.php';
			break;
			
			
			case'transport-demandfee';
			include 'transport-demand-fee.php';
			break;

			case'promote_students';
			include 'promote_students.php';
			break;

			case'text_sms_templates';
			include 'text_sms_templates.php';
			break;

			case'add_text_sms_template';
			include 'add_text_sms_template.php';
			break;
			
			case'assign-question';
			include 'assign-question.php';
			break;
			
			
			//Student Report Card


			
			
			case '';
			include('reports.php');
			break;		
			}
			?>	
        </div> 
    </div>
	<!-- /#right-panel -->
	
	<!-- my script -->
	<script type="text/javascript" src="js/myscript.js"></script>
	
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
	
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- upgrade to new -->
    <!-- <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
	<!-- end upgrade to new -->
    <script src="assets/js/main.js"></script>

    <script src="vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="vendors/jqvmap/dist/jquery.vmap.min.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <!-- <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> -->
    <script type="text/css" src="vendors/datatables.net-bs4/js/dataTables.bootstrap5.js"></script>

    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	
	
	
	
	<script>

	$(document).ready(function () {
		$("input[type='text']").each(function () {
		$(this).keydown(function (e) {
        if(e.keyCode == 188)
		{
            e.preventDefault();
        }
				});
			});
		});

	</script>
	<script>
		$('.menu-title').on('click', function() {
			$(this).find('span  > i ').toggleClass('fa-rotate-90');
		});
	</script>

<script>
$("#contact1").keydown(function(event) { k = event.which; if ((k >= 96 && k <= 105) || k == 8 || k == 9 || (k >= 48 && k <= 57)) { if ($(this).val().length == 10) { if (k == 8 || k == 9) { return true; } else { event.preventDefault(); return false; } } } else { event.preventDefault(); return false; } });
</script>

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