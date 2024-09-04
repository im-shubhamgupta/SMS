
<style type="text/css">
@media print{
   .noprint{
       display:none;
   }
}
</style>

 <aside id="left-panel" class="left-panel noprint">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="dashboard.php">Institute Management</a>
                <a class="navbar-brand hidden" href="dashboard.php">Institute Management</a>
            </div>
			
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    
					<li class="active">
                        <a href="dashboard.php"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>
				
		
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>	
					<h3 class="menu-title" data-toggle="collapse" data-target="#config">Configuration Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
					<div id="config" class="collapse">
            		<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Class</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_class">View Class</a></li>
                           
                        </ul>
                    </li>
					
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Section</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="dashboard.php?option=view_section">View Section</a></li>
                          
						<!--<li><i class="fa fa-table"></i><a href="dashboard.php?option=view_section">View Section</a></li>-->
                        </ul>
                    </li>
									
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-rupee"></i>Fees</a>
                        <ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=view_fees_header">View Fees Header</a></li>
							<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=view_assign_fees_to_class">View Assign Fees to Classes</a></li>
							<!--	<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=assign_fees_to_students">Assign Fees to Students</a></li>-->
						   
                        </ul>
                    </li>	
                    <li>
						<a href="dashboard.php?option=view_late_fee_assign_to_class"> <i class="menu-icon fa fa-rupee"></i>Late Fee Assign to Class </a>	
					</li>
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Institute Settings</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-cogs"></i><a href="dashboard.php?option=view_edit_inst_setting&smid=<?php echo '9';?>">View Institute Setting</a></li>
                        </ul>
                    </li>
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-envelope"></i>SMS Setting</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-envelope"></i><a href="dashboard.php?option=view_edit_smssetting&smid=<?php echo '10';?>">View SMS Setting</a></li>
                            <li><i class="menu-icon fa fa-envelope"></i><a href="dashboard.php?option=view_sms_wallet&smid=<?php echo '10';?>">SMS Wallet</a></li>
                        </ul>
                    </li>
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Expense Type</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-calendar"></i><a href="dashboard.php?option=view_expense_type">View Expense Type </a></li>
                           
                        </ul>
                    </li>
				
			
				<?php
				if($_SESSION['user_roles']=="superadmin")
				{
				?>
					    <li>
							<a href="dashboard.php?option=text_sms_templates"> <i class="menu-icon fa fa-envelope"></i> Text Sms Templates</a>	
						</li>	
						<li>
							<a href="dashboard.php?option=attendance_type&smid=<?php echo '14';?>"> <i class="menu-icon fa fa-clock-o"></i>Attendance Type </a>	
						</li>
						
						<li>
							<a href="dashboard.php?option=auto_birthday_message"> <i class="menu-icon fa fa-clock-o"></i>Auto Birthday Message </a>	
						</li>
						
						<li>
							<a href="dashboard.php?option=previous_fees_auth"> <i class="menu-icon fa fa-clock-o"></i>Previous Fees </a>	
						</li>
						
						<li>
							<a href="dashboard.php?option=route_student_auth"> <i class="menu-icon fa fa-clock-o"></i>Route to Student </a>	
						</li>
				<?php
				}
				?>
					</div>		
			<?php
			}
			?>
				

			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>	
					<h3 class="menu-title" data-toggle="collapse" data-target="#staff">Staff Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span> </h3>
					<!-- <span class="float-xs-right"><i class="fa fa-chevron-right"></i></span> -->
						<div id="staff" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Staff Management</a>
							 <ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_staff">View Staff </a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=upload_staff&smid=18">Import CSV Staff </a></li>
								<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=upload_partial_staff_details">Upload Partial Details</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=assign_classteacher&smid=19"> Assign Class Teacher</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_assign_classteacher"> View Assign Class Teacher</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_department">View Department </a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=assign_department">Assign Department</a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_assign_department">View Assign Department</a></li>
							 </ul>
						</li>
						
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Staff Subject Assignment</a>
							 <ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_subject">View Subject </a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=upload_subject">Import CSV Subject </a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=assign_subject">Assign Subject </a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=upload_assign_subject">Import CSV Assign Subject </a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_assign_subject">View Assign Subject</a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_allocated_subjects_staff">View Allocated Subjects to Staff</a></li>
							 </ul>
						</li>	
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Staff Time Table</a>
							 <ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=upload_staff_timetable">Import Staff Time Table</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_staff_timetable">View Staff Time Table</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_staff_leisure">View Staff Leisure</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_staff_leisure_periodwise">View Staff Leisure Period Wise</a></li>							 
							 </ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Syllabus Management</a>
							 <ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=assign_syllabus_staff">Assign Syllabus to Staff</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=upload_assign_syllabus_staff">Import Allocated Syllabus to Staff</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=update_allocated_syllabus_status">Update Allocated Syllabus Status</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_syllabus_allocated_staff">View Syllabus Allocated to Staff</a></li>
								<li><i class="menu-icon fa fa-file-text-o"></i><a href="dashboard.php?option=view_syllabus_allocation_chart">View Syllabus Allocation Chart</a></li>
							 </ul>
						</li>
					</div>
			<?php
			}
			?>	
				
					
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>	
					<h3 class="menu-title" data-toggle="collapse" data-target="#studentpanel">Student Panel <span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="studentpanel" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Student</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=view_students">View Student</a></li>
								
							<?php
							if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
							{
							?>	
								<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=upload_students">Import CSV Student</a></li>
								<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=upload_partial_student_details">Upload Partial Details</a></li>
							<?php
							}
							?>
							
							</ul>
						</li>
						<?php
							if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
							{
							?>
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Promote Students</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=promote_students">Promote Students</a></li>
							</ul>
						</li>
					    <?php 	}	?>
										
						
					<!--	<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Subject wise Attendance</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=subject_wise_attendance">Student Daily Attendance</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=studentwise_att_report">Student Wise Attendance Report</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=subjectwise_att_report">Subject Wise Attendance Report</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=classwise_att_report">Class Wise Attendance Report</a></li>-->
								<!--<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=subject_yearly_report">Subject Yearly Report</a></li>-->
								<!--<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_send_attendance">View & Send Attendance</a></li>-->
								
						<!--	</ul>
						</li>	-->
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Leave Management</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=leave_request">Leave Request</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=approve_leaves">Approve Leaves</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_leave_report">View Leave Report</a></li>
								
							</ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Time Table</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=create_timetable">Create Timetable</a>
								<li><i class="menu-icon fa fa-table"></i><a href="dashboard.php?option=view_timetable">View Timetable</a>
								<li><i class="menu-icon fa fa-table"></i><a href="dashboard.php?option=update_timetable">Update Timetable</a>
								<li><i class="menu-icon fa fa-table"></i><a href="dashboard.php?option=upload_timetable">Import CSV Timetable</a>
							</ul>
						</li>		
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Event Calendar</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=create_event">Create</a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_event_calendar">View Event Calendar</a></li>
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=upload_event_calendar">Import CSV Event Calendar</a></li>
							</ul>
						</li>
						</div>						
			<?php
			}
			?>


			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#communication">Communication Panel <span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="communication" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bell"></i>Student Communication</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=student_notification&smid=<?php echo '38';?>">Send Notification</a></li>
								<li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=student_scheduled_notification">Scheduled Notification</a></li>
								<li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=view_student_notification">View Notification</a></li>
								<li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=view_scheduled_notification">View Scheduled Messages</a></li>
								<li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=view_voice_message">View Voice Messages</a></li>
							   
							</ul>
						</li>	

						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bell"></i>Staff Communication</a>
							 <ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=send_staff_notification">Send Notification</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_staff_notification">View Staff Notification</a></li>
							 </ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bell"></i>Custom Communication</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=create_group">Create Group</a></li>
								<li><i class="menu-icon fa fa-eye"></i><a href="dashboard.php?option=view_group">View Group</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=assign_students_group"> Assign Students to Group</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_group_students">View Group Students</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=send_custome_notification"> Send Custom Note</a></li>
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_custome_notification">View Custom Notification</a></li>
								
							</ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bell"></i>Send Email</a>
							 <ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=send_email_notification">Send Email</a></li>
							 </ul>
						</li>
						</div>
			<?php
			}
			?>
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#attendance">Attendance Panel <span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="attendance" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Student Attendance</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=stu_daily_attendance">Student Daily Attendance</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=studentwise_daily_att_report">Student Wise Daily Attendance Report</a></li>
							
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=classwise_daily_att_report">Class Wise Daily Attendance Report</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=today_absentee_list">Today Absentees List</a></li>
								
								<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=yearly_report">Yearly Report</a></li>
								
							</ul>
						</li>		
			
						</div>
			<?php
			}
			?>
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#exam_result">Exam & Result Panel <span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="exam_result" class="collapse">
						<li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Exam & Result</a>
							<ul class="sub-menu children dropdown-menu">
							   
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=create_test">Create Test</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=update_test">View / Update Test</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=assign-test-to-term">Assign Test</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=delete_test">Delete Test</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=marks_entry">Marks Entry</a></li>
							<li> <i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=view_scholastic"> View Scholastic</a>				  <!-- Create Co-Scholastic	 -->
					      </li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=assign-scholastic-grade">Add and Update Scholastic Grade</a></li>
							
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=create_download_format">Create and Download Format</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=upload_marks">Import CSV Marks</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_report">View Report</a></li>
							
							<!-- <li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=assign_grade">Assign Grade</a></li> -->
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=upload_grade">Import CSV Grade</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_grade">View Grade</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=send_result">Send Result</a></li>
							</ul>
						</li>		
						</div>
			<?php
			}
			?>	
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser" or $_SESSION['user_roles']=="transport")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#transportpanel">Transport Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="transportpanel" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-truck"></i>Transport</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_driver">Driver & Cleaner</a></li>
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_vehicle">Vehicle Details</a></li>
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_assign_driver_route">View Assign Driver & Vehicle to Route</a></li>
							</ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-truck"></i>Route</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_transports">View Route</a></li>
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_route_to_student">View Route to Student</a></li>
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=upload_students_route">Import CSV Route to Student</a></li>
							</ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-truck"></i>Transport Expense</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_transport_expense_type">View Transport Expense Type </a></li>
							<li><i class="menu-icon fa fa-database"></i><a href="dashboard.php?option=view_transport_expense">View Transport Expense</a></li>
                        </ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-truck"></i>Previous Transport Fees</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_previous_transport_fees">View Previous Transport Fees</a></li>
								<!--<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=upload_previous_transport_fees">Import CSV Transport Fees</a></li>
								-->
							</ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-truck"></i>Collect Transport Fees</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_transport_fee_detail">Collect Fees</a></li>
							</ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-truck"></i>Report</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=paid_transport_report">Paid Transport Reports</a></li>
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=due_transport_report">Due Transport Reports</a></li>
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=deleted_transport_report">Deleted Reports</a></li>
								<!--<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=trans_exp_report">Expense Reports</a></li>
								<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=deleted_trans_exp_report">Deleted Expense Reports</a></li>-->
							</ul>
						</li>
						</div>
			<?php
			}
			?>	
				
					
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="account")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#accounts">Accounts Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="accounts" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-database"></i>Expense</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-database"></i><a href="dashboard.php?option=view_expense">View Expense</a></li>
					
							<!--	<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=dues_report">Due Students</a></li>
							-->
							</ul>
						</li>							
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Fees</a>
							<ul class="sub-menu children dropdown-menu">
								
								<!--<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=view_bill">View Fees Section</a></li>-->
								
								<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=view_student_fees_detail">Collect Fees</a></li>
								<!--<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=download_student_fees">Download Student Fees</a></li>
								<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=upload_student_fees">Import CSV Student Fees</a></li>-->
								<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=view_assign_fees_students">Update Fees to Students</a></li>
								<!--<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=view_student_history">Student History</a></li>-->
							</ul>
						</li>
						
						<li><a href="dashboard.php?option=reconcile_fees"><i class="menu-icon fa fa-money"></i> Reconcile Fees</a></li>
						
						<li><a href="dashboard.php?option=update_declined_fees"><i class="menu-icon fa fa-money"></i> Update Declined Fees</a></li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Previous Fees</a>
							 <ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=create_previous_fees&smid=<?php echo '34';?>">Create Previous Fees </a></li>
								<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=view_previous_fees">View Previous Fees </a></li>
								<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=upload_previous_fees"> Import CSV Previous Fees </a></li>
							 </ul>
						</li>
						</div>
			<?php
			}
			?>

			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
			{
			?>					
					<h3 class="menu-title" data-toggle="collapse" data-target="#administrationpanel">Administration Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3>
						<div id="administrationpanel" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file-text-o"></i>Feedback Management</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=create_feedback">Create Feedback </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=response_feedback">Response Feedback </a></li>
								<li><i class="menu-icon fa fa-file-text-o"></i><a href="dashboard.php?option=view_feedback_response">View Feedback </a></li>
							</ul>
						</li>
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil-square-o"></i>Remedy Management</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=create_remedy">Create Remedy </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_remedy">View Remedies </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=approve_remedy">Approve Remedies </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_approval_remedy">View Approval Remedies </a></li>
							</ul>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file-text-o"></i>Budget Management</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_budget_header">View Budget Header </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_allocate_budget">View Allocate Budget </a></li>
								<li><i class="menu-icon fa fa-file-text-o"></i><a href="dashboard.php?option=view_allocated_budget_expense">View Allocated Budget Expense </a></li>
							</ul>
						</li>
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file-text-o"></i>Budget Report</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-file-text-o"></i><a href="dashboard.php?option=allocated_budget_chart">Allocated Budget </a></li>
								<li><i class="menu-icon fa fa-file-text-o"></i><a href="dashboard.php?option=allocated_budget_expense_report">Allocated Budget Expense </a></li>
							</ul>
						</li>
						<li>
							<a href="dashboard.php?option=generate_hallticket"> <i class="menu-icon fa fa-file"></i>Hall Ticket </a>
						</li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil-square-o"></i>ID Card </a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_upload_student_image">View & Upload Student Images </a></li>
								
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_upload_faculty_image">View & Upload Faculty Images </a></li>
								
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=student_idcard">Student ID Card </a></li>
								
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=faculty_idcard">Faculty ID Card </a></li>
								
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=upload_signature">View & Upload Signature </a></li>
							</ul>
						</li>
						
						<li>
							<a href="dashboard.php?option=view_purge_data"> <i class="menu-icon fa fa-trash"></i>View Purge Data </a>
						</li>
						</div>
			<?php
			}
			?>
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser" or $_SESSION['user_roles']=="account")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#certificate">Certificate Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="certificate" class="collapse">
						<li>
						<a href="dashboard.php?option=create_cert1"> <i class="menu-icon fa fa-dashboard"></i>Custom Certificate </a>
                        </li>
						<li>
							<a href="dashboard.php?option=generate_certificate"> <i class="menu-icon fa fa-file"></i>Student Certificate </a>
						</li>
						</div>
			
			<?php
			}
			?>
			

			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser" or $_SESSION['user_roles']=="account")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#report">Report Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="report" class="collapse">
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Student Report</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=student_report">Student</a></li>
								<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=admission_report">Admission</a></li>
								<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=classwise_report">Classwise</a></li>
								<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=rte_report">RTE</a></li>
							</ul>
						</li>
					
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Fee Report</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=paidstudents_report">Paid Students</a></li>
								<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=duestudents_report">Due Students</a></li>
								<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=discountedfees_report">Discounted Fees</a></li>
								<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=deletedfees_report">Deleted Fees</a></li>
								<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=declinedfees_report">Declined Fees</a></li>
							</ul>
						</li>
						
						<li><a href="dashboard.php?option=reconcile_report"> <i class="menu-icon fa fa-file"></i>Reconcile Report </a></li>
						
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-database"></i>Expense Report</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-database"></i><a href="dashboard.php?option=expense_report">View Report</a></li>					
								<li><i class="menu-icon fa fa-database"></i><a href="dashboard.php?option=deleted_expenses">Deleted Expenses</a></li>
							</ul>
						</li>
						</div>
			<?php
			}
			?>
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser" or $_SESSION['user_roles']=="account")
			{
			?>
					<h3 class="menu-title" data-toggle="collapse" data-target="#security">Security Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
						<div id="security" class="collapse">
						<li>
							<a href="dashboard.php?option=view_logs"> <i class="menu-icon fa fa-file"></i>Deleted Fees Logs </a>
						</li>
						<li class="menu-item-has-children dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil-square-o"></i>Activity History</a>
							<ul class="sub-menu children dropdown-menu">
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_panel">View Panel </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_menu">View Menu </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_submenu">View Submenu </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=view_activity_history">View Activity </a></li>
								<li><i class="menu-icon fa fa-pencil-square-o"></i><a href="dashboard.php?option=search_activity_history">Search Activity </a></li>
							</ul>
						</li>
						</div>
			<?php
			}
			?>

			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
			{
			?>	
				<h3 class="menu-title" data-toggle="collapse" data-target="#setting">Setting Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
                    <div id="setting" class="collapse">
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>User Panel</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=add_user">Add User</a></li>
							<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=view_user">View User</a></li>
                        </ul>
                    </li>
				
					
					<li>
                        <a href="dashboard.php?option=update_sms_status"> <i class="menu-icon fa fa-envelope"></i>SMS Service </a>
                    </li>

			<?php
			if($_SESSION['user_roles']=="superadmin")
			{
			?>
					<li>
                        <a href="dashboard.php?option=student_restrict"> <i class="menu-icon fa fa-ban"></i>Student Restriction </a>
                    </li>
                    <li>
                        <a href="dashboard.php?option=sms_restrict"> <i class="menu-icon fa fa-ban"></i>SMS Restriction </a>
                    </li>
			<?php
			}
			?>
					</div>
			<?php
			}
			?>	
				
					
					
			<!--	<li>
                        <a href="dashboard.php?option=view_student_attendance"> <i class="menu-icon fa fa-users"></i>Staff Attendance </a>	
                    </li> -->
			
			<?php
			if($_SESSION['user_roles']=="superadmin")
			{
			?>
				<h3 class="menu-title" data-toggle="collapse" data-target="#cleardatabase">Clear Database <span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3>
					<div id="cleardatabase" class="collapse">
					<li><a href="dashboard.php?option=clear_student_details"> <i class="menu-icon fa fa-pencil-square-o"></i>Clear Student Details</a></li>
					
					<li><a href="dashboard.php?option=clear_full_database"> <i class="menu-icon fa fa-pencil-square-o"></i>Clear Full Database</a></li>
					
					<!--<li><a href="dashboard.php?option=clear_stock"> <i class="menu-icon fa fa-pencil-square-o"></i>Clear Stock</a></li>
					
					<li><a href="dashboard.php?option=clear_library"> <i class="menu-icon fa fa-pencil-square-o"></i>Clear Library</a></li>
					-->
					
				<!--	<li><a href="dashboard.php?option=multilevel_sidebar"> <i class="menu-icon fa fa-pencil-square-o"></i>Multilevel Sidebar</a></li>
				-->
					</div>
			<?php
			}
			?>	
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="stock")
			{
			?>							
				<h3 class="menu-title" data-toggle="collapse" data-target="#stockmanage">Stock Management<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3>
					<div id="stockmanage" class="collapse">
					<li><a href="dashboard.php?option=view_stock_type"> <i class="menu-icon fa fa-bars"></i>View Stock Type</a></li>
					<li><a href="dashboard.php?option=view_stock_vendor"><i class="menu-icon fa fa-bars"></i>View Vendor</a></li>
					
					<li class="menu-item-has-children dropdown">
                   		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bars"></i>Purchase Order</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-bars"></i><a href="dashboard.php?option=view_purchase_order">View Purchase Order</a></li>
                            <li><i class="menu-icon fa fa-bars"></i><a href="dashboard.php?option=upload_purchase_order">Import Purchase Order</a></li>
					
						</ul>
                    </li>
					
					<li><a href="dashboard.php?option=issue_order"> <i class="menu-icon fa fa-bars"></i>Issue Order</a></li>
					<li><a href="dashboard.php?option=stock_available"> <i class="menu-icon fa fa-bars"></i>Stock Availability</a></li>
					<li><a href="dashboard.php?option=return_stock"> <i class="menu-icon fa fa-bars"></i>Return Stock</a></li>
					<li><a href="dashboard.php?option=dead_stock"> <i class="menu-icon fa fa-bars"></i>Dead Stock</a></li>
					
					<li class="menu-item-has-children dropdown">
                   		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Stock Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-bars"></i><a href="dashboard.php?option=view_purchase_report">Purchase Order Report</a></li>
							<li><i class="menu-icon fa fa-bars"></i><a href="dashboard.php?option=view_issuedorder_report">Issued Order Report</a></li>
							<li><i class="menu-icon fa fa-bars"></i><a href="dashboard.php?option=view_return_stock_report">Return Stock Report</a></li>
							<li><i class="menu-icon fa fa-bars"></i><a href="dashboard.php?option=view_dead_stock_report">Dead Stock Report</a></li>
						</ul>
                    </li>
					</div>
			<?php
			}
			?>	
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="library")
			{
			?>	
				<h3 class="menu-title" data-toggle="collapse" data-target="#librarymanage">Library Management<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3>
					<div id="librarymanage" class="collapse">
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Configuration</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_book_type">Book Type</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_branch">Branch</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_vendor">Vendor</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_publisher">Publisher</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_books">Books</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_book_return_type">Book Return Type</a></li>
                        </ul>
					</li>
					
					<li class="menu-item-has-children dropdown">
                   		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Issue Book</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=issue_bookto_student">Student Book Issue</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=issue_bookto_faculty">Faculty Book Issue</a></li>
						</ul>
                    </li>
					
					<li><a href="dashboard.php?option=return_book"><i class="menu-icon fa fa-book"></i>Return Book</a></li>
					
					<li><a href="dashboard.php?option=book_available_detail"><i class="menu-icon fa fa-book"></i>Book Available Detail</a></li>
						
					<li class="menu-item-has-children dropdown">
                   		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list"></i>Student Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=issuedbook_student_detail">Issued Books Details</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=returnedbook_student_detail">Returned Books Detail</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=notreturnedbook_student_detail">Not Returned Books Detail</a></li>
						</ul>
                    </li>
					
					<li class="menu-item-has-children dropdown">
                   		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list"></i>Faculty Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=issuedbook_faculty_detail">Issued Books Details</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=returnedbook_faculty_detail">Returned Books Detail</a></li>
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=notreturnedbook_faculty_detail">Not Returned Books Detail</a></li>
						</ul>
                    </li>
					
					<li><a href="dashboard.php?option=penalty_collection"><i class="menu-icon fa fa-rupee"></i>Penalty Collection</a></li>
					
					<li><a href="dashboard.php?option=nodue_certificate"><i class="menu-icon fa fa-rupee"></i>No Due Certificate</a></li>
					</div>
			<?php	
			}
			?>
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>	
				<h3 class="menu-title" data-toggle="collapse" data-target="#admission">Admission Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3>
			        <div id="admission" class="collapse">
					<li><a href="dashboard.php?option=online_admission"><i class="menu-icon fa fa-dashboard"></i> Online Admission </a></li>
					<li><a href="dashboard.php?option=view_online_admission"><i class="menu-icon fa fa-dashboard"></i> View Online Admission</a></li>
					<li><a href="dashboard.php?option=view_requested_admission"><i class="menu-icon fa fa-dashboard"></i> View Requested Admission</a></li>
					<li><a href="dashboard.php?option=approve_reject_admission"><i class="menu-icon fa fa-dashboard"></i> Approve /Reject Admission</a></li>
					<!-- <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Approve / Reject Admission</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=search_with_reference">Search with Reference No</a></li>
							<li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=search_with_grade">Search with Requested Grade</a></li>
                        </ul>
                    </li> -->
					<li><a href="dashboard.php?option=view_accept_admission"><i class="menu-icon fa fa-dashboard"></i> View Accept Admission Details</a></li>
					<li><a href="dashboard.php?option=view_reject_admission"><i class="menu-icon fa fa-dashboard"></i> View Rejected Admission Details</a></li>
					<li><a href="dashboard.php?option=upload_online_admission"><i class="menu-icon fa fa-dashboard"></i> Import CSV Online Admission</a></li>
					</div>
			<?php
			}
			?>

			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>	
					<h3 class="menu-title" data-toggle="collapse" data-target="#dataanalysis">Data Analysis<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
            		<div id="dataanalysis" class="collapse">
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Student Analysis</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-users"></i><a href="dashboard.php?option=attendance_analysis">Attendance Analysis</a></li>
                            <li><i class="menu-icon fa fa-list"></i><a href="dashboard.php?option=exam_analysis">Exam Analysis</a></li>
							
                        </ul>
                    </li>
					
				<!--	<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Staff Analysis</a>
                        <ul class="sub-menu children dropdown-menu">
                            
                           
                        </ul>
                    </li>-->
					</div>
			<?php
			}
			?>
			
			
			<?php
			if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin" or $_SESSION['user_roles']=="systemuser")
			{
			?>	
					<h3 class="menu-title" data-toggle="collapse" data-target="#reportcard">Report Card Panel<span class="float-xs-right"><i class="side_arrow fa fa-chevron-right"></i></span></h3><!-- /.menu-title -->
					<div id="reportcard" class="collapse">
					
            		<li>
						<a href="dashboard.php?option=student_reportcard"> <i class="menu-icon fa fa-users"></i>Student Report Card </a>	
					</li>
					</div>
			<?php
			}
			?>
			
			<!--		<li><a href="dashboard.php?option=birthday"><i class="menu-icon fa fa-rupee"></i>Birthday Message</a></li>
					<li><a href="dashboard.php?option=scheduled_message"><i class="menu-icon fa fa-rupee"></i>Scheduled Message</a></li>
					<li><a href="dashboard.php?option=scheduled_payment_message"><i class="menu-icon fa fa-rupee"></i>Scheduled Message</a></li>
			-->		
					
					
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->