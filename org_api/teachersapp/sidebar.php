
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
                    
					
					<h3 class="menu-title">Fees Section</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Fees</a>
                        <ul class="sub-menu children dropdown-menu">
							
							<!--<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=view_bill">View Fees Section</a></li>-->
							
							<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=view_student_fees_detail">View Fees Section</a></li>
							
						<!--	<li><i class="menu-icon fa fa-money"></i><a href="dashboard.php?option=view_student_history">Student History</a></li>-->
                        </ul>
                    </li>
					
					
					<h3 class="menu-title">Student Panel</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Student</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=view_students">View Student</a></li>
							
						<?php
						if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
						{
						?>	
							<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=upload_students">Import CSV Student</a></li>
                        <?php
						}
						?>
						
						</ul>
                    </li>
					
					
					<h3 class="menu-title">Notification Panel</h3><!-- /.menu-title -->
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bell"></i>Notification</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=student_notification">Send Notification</a></li>
							
							<li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=view_student_notification">View Notification</a></li>
                           
							<li><i class="menu-icon fa fa-bell"></i><a href="dashboard.php?option=view_scheduled_notification">View Scheduled Messages</a></li>
                           
                        </ul>
                    </li>	
					
					
					<h3 class="menu-title">Report Panel</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Fee Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=paidstudents_report">Paid Students</a></li>
							<li><i class="menu-icon fa fa-file"></i><a href="dashboard.php?option=duestudents_report">Due Students</a></li>
				
						<!--	<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=dues_report">Due Students</a></li>
						-->
                        </ul>
                    </li>
					 <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-database"></i>Expense Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-database"></i><a href="dashboard.php?option=expense_report">View Report</a></li>					
				
						<!--	<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=dues_report">Due Students</a></li>
						-->
                        </ul>
                    </li>				

					<h3 class="menu-title">Expense Panel</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-database"></i>Expense</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-database"></i><a href="dashboard.php?option=view_expense">View Expense</a></li>
				
						<!--	<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=dues_report">Due Students</a></li>
						-->
                        </ul>
                    </li>							
					
					<h3 class="menu-title">Configuration Panel</h3><!-- /.menu-title -->
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
                           
                        </ul>
                    </li>
					
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-rupee"></i>Fees</a>
                        <ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=view_fees_header">View Fees Header</a></li>
							<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=view_assign_fees_to_class">Assign Fees to Classes</a></li>
							<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=view_assign_fees_students">Assign Discount/Add/NA Fees to Students</a></li>
						<!--	<li><i class="menu-icon fa fa-rupee"></i><a href="dashboard.php?option=assign_fees_to_students">Assign Fees to Students</a></li>-->
						   
                        </ul>
                    </li>	
				
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-truck"></i>Transport</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_transports">View Transport</a></li>
							<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=view_route_to_student">View Route to Student</a></li>
							<li><i class="menu-icon fa fa-truck"></i><a href="dashboard.php?option=upload_students_route">Import CSV Route to Student</a></li>
                        </ul>
                    </li>
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Institute Settings</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-cogs"></i><a href="dashboard.php?option=view_edit_inst_setting">View setting</a></li>
                        </ul>
                    </li>
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-envelope"></i>SMS Setting</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-envelope"></i><a href="dashboard.php?option=view_edit_smssetting">View SMS Setting</a></li>
                        </ul>
                    </li>
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Expense Type</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-calendar"></i><a href="dashboard.php?option=view_expense_type">View Expense Type</a></li>
                           
                        </ul>
                    </li>
				
				<?php
				if($_SESSION['user_roles']=="superadmin")
				{
				?>
					<li>
                        <a href="dashboard.php?option=attendance_type"> <i class="menu-icon fa fa-clock-o"></i>Attendance Type </a>	
                    </li>
				<?php
				}
				?>				
					
					<!--<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Academic Year</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-calendar"></i><a href="dashboard.php?option=view_academic_yr">View Academic Year</a></li>
                        </ul>
						</li>-->
				
				
				<h3 class="menu-title" >Previous Fees Management</h3>
					
					<li><a href="dashboard.php?option=create_previous_fees"> <i class="menu-icon fa fa-money"></i>Create Previous Fees </a>
					
					<li><a href="dashboard.php?option=view_previous_fees"> <i class="menu-icon fa fa-money"></i>View Previous Fees </a>
					
					<li><a href="dashboard.php?option=upload_previous_fees"> <i class="menu-icon fa fa-money"></i>Import Previous Fees </a>
					
				
				<h3 class="menu-title">Staff Management Panel</h3>
					
					<li><a href="dashboard.php?option=view_subject"> <i class="menu-icon fa fa-book"></i>View Subject </a>
					   
					<li>
                        <a href="dashboard.php?option=view_staff"> <i class="menu-icon fa fa-users"></i>View Staff </a>	
                    </li>
					<li>
                        <a href="dashboard.php?option=assign_subject"> <i class="menu-icon fa fa-book"></i>Assign Subject </a>	
                    </li>
					<li>
                        <a href="dashboard.php?option=view_assign_subject"> <i class="menu-icon fa fa-book"></i>View Assign Subject </a>	
                    </li>
					<li>
                        <a href="dashboard.php?option=assign_classteacher"> <i class="menu-icon fa fa-users"></i>Assign Class Teacher </a>	
                    </li>
					<li>
                        <a href="dashboard.php?option=view_assign_classteacher"> <i class="menu-icon fa fa-users"></i>View Assign Class Teacher </a>	
                    </li>

				
				<h3 class="menu-title">Attendance Management</h3>
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Daily Attendance</a>
                        <ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=stu_daily_attendance">Student Daily Attendance</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=studentwise_daily_att_report">Student Wise Attendance Report</a></li>
						
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=classwise_daily_att_report">Class Wise Attendance Report</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=yearly_report">Yearly Report</a></li>
							
							<!--<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=subject_yearly_report">Subject Yearly Report</a></li>-->
                        </ul>
                    </li>		
					
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Subject wise Attendance</a>
                        <ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=subject_wise_attendance">Student Daily Attendance</a></li>
							
							<!--<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_send_attendance">View & Send Attendance</a></li>-->
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=studentwise_att_report">Student Wise Attendance Report</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=subjectwise_att_report">Subject Wise Attendance Report</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=classwise_att_report">Class Wise Attendance Report</a></li>
							
                        </ul>
                    </li>									
					
			<!--	<li>
                        <a href="dashboard.php?option=view_student_attendance"> <i class="menu-icon fa fa-users"></i>Staff Attendance </a>	
                    </li> -->
					
					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Leave Management</a>
                        <ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=leave_request">Leave Request</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=approve_leaves">Approve Leaves</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_leave_report">View Leave Report</a></li>
							
                        </ul>
                    </li>

					<li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Event Calendar</a>
                        <ul class="sub-menu children dropdown-menu">
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=create_event">Create</a></li>
							
							<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_event_calendar">View Event Calendar</a></li>
							
                        </ul>
                    </li>	
						
				
				<h3 class="menu-title" >Feedback Management</h3>
					
					<li><a href="dashboard.php?option=create_feedback"> <i class="menu-icon fa fa-pencil-square-o"></i>Create Feedback </a>
					
					<li><a href="dashboard.php?option=response_feedback"> <i class="menu-icon fa fa-pencil-square-o"></i>Response Feedback </a>
					
					<li><a href="dashboard.php?option=view_feedback_response"> <i class="menu-icon fa fa-file-text-o"></i>View Feedback </a>
					
				
				<h3 class="menu-title" >Remedies Management</h3>
					
					<li><a href="dashboard.php?option=create_remedy"> <i class="menu-icon fa fa-pencil-square-o"></i>Create Remedy </a>
					
					<li><a href="dashboard.php?option=view_remedy"> <i class="menu-icon fa fa-pencil-square-o"></i>View Remedies </a>
					
					<li><a href="dashboard.php?option=approve_remedy"> <i class="menu-icon fa fa-pencil-square-o"></i>Approve Remedies </a>
										
					<li><a href="dashboard.php?option=view_approval_remedy"> <i class="menu-icon fa fa-pencil-square-o"></i>View Approval Remedies </a>
					
				<?php
				if($_SESSION['user_roles']=="superadmin" or $_SESSION['user_roles']=="admin")
				{
				?>	
					<h3 class="menu-title">User Panel</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>User</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=add_user">Add User</a></li>
							<li><i class="menu-icon fa fa-user"></i><a href="dashboard.php?option=view_user">View User</a></li>
                        </ul>
                    </li>
				<?php
				}
				?>	
				
		<!--		<h3 class="menu-title">Notification Panel</h3>
					<li>
                        <a href="dashboard.php?option=send_notification"> <i class="menu-icon fa fa-bell"></i>Send Notification </a>	
                    </li>
					<li>
                        <a href="dashboard.php?option=view_notification"> <i class="menu-icon fa fa-bell"></i>View Notification </a>	
                    </li> -->
					
				<h3 class="menu-title">Services</h3>
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
				<?php
				}
				?>	
				
					<li>
                        <a href="dashboard.php?option=view_logs"> <i class="menu-icon fa fa-file"></i>Logs </a>
                    </li>
					
					
					
				<h3 class="menu-title">Examination Panel</h3>
				 <li class="menu-item-has-children dropdown">
				 <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clock-o"></i>Test</a>
				 <ul class="sub-menu children dropdown-menu">
				   
					<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=create_test">Create Test</a></li>
					
					<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=update_test">Update Test</a></li>
					
					<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=delete_test">Delete Test</a></li>
					
				 </ul>
				 </li>			
					
					
				<h3 class="menu-title">Marks Panel</h3>
				 <li class="menu-item-has-children dropdown">
				 <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-clock-o"></i>Marks</a>
				 <ul class="sub-menu children dropdown-menu">
				   
					<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=marks_entry">Marks Entry</a></li>
					
					<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_report">View Report</a></li>
					
					<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=assign_grade">Assign Grade</a></li>
					
					<li><i class="menu-icon fa fa-book"></i><a href="dashboard.php?option=view_grade">View Grade</a></li>

				 </ul>
				 </li>
					
				
				<h3 class="menu-title">Time Table Management</h3>
					
					<li><a href="dashboard.php?option=create_timetable"> <i class="menu-icon fa fa-pencil-square-o"></i>Create Timetable</a>
					
					<li><a href="dashboard.php?option=view_timetable"> <i class="menu-icon fa fa-table"></i>View Timetable</a>
										
					<li><a href="dashboard.php?option=update_timetable"> <i class="menu-icon fa fa-table"></i>Update Timetable</a>
				

				<h3 class="menu-title">Custome Group Management</h3>
					
					<li><a href="dashboard.php?option=create_group"> <i class="menu-icon fa fa-pencil-square-o"></i>Create Group</a>
					
					<li><a href="dashboard.php?option=view_group"> <i class="menu-icon fa fa-eye"></i>View Group</a>
					
					<li><a href="dashboard.php?option=assign_students_group"> <i class="menu-icon fa fa-users"></i>Assign Students to Group</a>
					
					<li><a href="dashboard.php?option=view_group_students"> <i class="menu-icon fa fa-users"></i>View Group Students</a>
					
					<li><a href="dashboard.php?option=send_custome_notification"> <i class="menu-icon fa fa-users"></i>Send Custome Note</a>
					
					<li><a href="dashboard.php?option=view_custome_notification"> <i class="menu-icon fa fa-users"></i>View Custome Notification</a>
					
				
				<h3 class="menu-title">Clear Database</h3>
					
					<li><a href="dashboard.php?option=clear_student_details"> <i class="menu-icon fa fa-pencil-square-o"></i>Clear Student Details</a>
					
					<li><a href="dashboard.php?option=clear_full_database"> <i class="menu-icon fa fa-pencil-square-o"></i>Clear Full Database</a>
					
					
					
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->