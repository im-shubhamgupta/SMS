<?php include('../myfunction.php') ?>
<?php
date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['Add_Class'])) {
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_SESSION);

	$class = mysqli_real_escape_string($con, trim($_POST['class']));
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));


	$sql = mysqli_query($con, "select * from class where class_name='$class' and deletion_indicator='0' ");

	$res = mysqli_num_rows($sql);

	if ($res) {


		$responce['status'] = 'error';
		$responce['message'] = 'This Class Is Already Exists';
	} else {

		$query = "insert into `class` (`class_name`,`create_date`,`modify_date`)values('$class',now(),now())";



		if (mysqli_query($con, $query)) {

			$action = "Class " . $class . " is created";
			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values (
				'$user_roles','view class','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);


			$responce['status'] = 'success';
			$responce['message'] = 'Class Added Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}
	}
	echo json_encode($responce);
}

if (isset($_POST['Update_Class'])) {
	// echo "<pre>";
	// print_r($_POST);


	$class = mysqli_real_escape_string($con, trim($_POST['class']));
	$cid = mysqli_real_escape_string($con, $_POST['cid']);
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));


	$sql1 = mysqli_query($con, "select * from class where class_name='$class'  and class_id!='$cid' and deletion_indicator='0' ");

	$res1 = mysqli_num_rows($sql1);

	if ($res1) {

		$responce['status'] = 'error';
		$responce['message'] = 'This Class Is Already Exists';
	} else {

		$query = mysqli_query($con, "update class set class_name='$class',modify_date=now() where class_id='$cid' ");

		if ($query) {

			$action = "Class " . $cname . " is edited";

			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values (
				'$user_roles','view class','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);

			$responce['status'] = 'success';
			$responce['message'] = 'Class Updated Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}
		// echo "<script>window.location='dashboard.php?option=view_class&smid=2'</script>";	

	}
	echo json_encode($responce);
}

if (isset($_POST['Add_Section'])) {
	// echo "<pre>";
	// print_r($_POST);
	$class = mysqli_real_escape_string($con, trim($_POST['class']));
	$section = mysqli_real_escape_string($con, trim($_POST['section']));
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));





	$sql = mysqli_query($con, "select * from section where section_name='$section' && class_id='$class'  and deletion_indicator='0' ");

	$res1 = mysqli_num_rows($sql);

	if ($res1) {
		$responce['status'] = 'error';
		$responce['message'] = ' This Section is Already Exists';
	} else {

		$query1 = "insert into section(class_id,section_name,create_date,modify_date) values('$class','$section',now(),now())";

		if (mysqli_query($con, $query1)) {

			$qc = mysqli_query($con, "select * from class where class_id='$class'");

			$rc = mysqli_fetch_array($qc);

			$clsname = $rc['class_name'];

			$action = "Section " . $section . " for Class " . $clsname . " is created";

			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values (
				'$user_roles','view section','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);

			$responce['status'] = 'success';
			$responce['message'] = ' Section Added Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}
	}
	echo json_encode($responce);
}
if (isset($_POST['Update_Section'])) {
	// echo "<pre>";
	// print_r($_POST);
	$nclass = mysqli_real_escape_string($con, trim($_POST['nclass']));
	$nsection = mysqli_real_escape_string($con, trim($_POST['nsection']));
	$sid = mysqli_real_escape_string($con, $_POST['sid']);
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));

	$nsection = trim($nsection, " ");
	$que = mysqli_query($con, "select * from section where class_id='$nclass' && section_name='$nsection' and section_id!='$sid' and deletion_indicator='0'");

	$chk = mysqli_num_rows($que);

	if ($chk > 0) {
		$responce['status'] = 'error';
		$responce['message'] = ' This Section is Already Exists ';
	} else {

		$uqery = mysqli_query($con, "update section set section_name='$nsection', modify_date=now() where section_id='$sid'");
		if ($uqery) {
			$responce['status'] = 'success';
			$responce['message'] = ' Section Updated Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}
	}
	echo json_encode($responce);
}
if (isset($_POST['view_edit_inst_setting'])) {
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	
	
	$registration_no = mysqli_real_escape_string($con, trim($_POST['registration_no']));
	
	$watermark = mysqli_real_escape_string($con, trim($_POST['watermark']));
	
	$cname = mysqli_real_escape_string($con, trim($_POST['cname']));
	$short_name = mysqli_real_escape_string($con, trim(strtoupper($_POST['short_name'])));
	$Rnumber = mysqli_real_escape_string($con, trim($_POST['Rnumber']));
	$Anumber = mysqli_real_escape_string($con, $_POST['Anumber']);
	$nfont = mysqli_real_escape_string($con, $_POST['nfont']);
	$caddress = mysqli_real_escape_string($con, $_POST['caddress']);
	$nfont = mysqli_real_escape_string($con, trim($_POST['nfont']));
	$cmail = mysqli_real_escape_string($con, trim($_POST['cmail']));
	$cnumber = mysqli_real_escape_string($con, trim($_POST['cnumber']));
	$company_url = mysqli_real_escape_string($con, trim($_POST['company_url']));
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));
	$show_number= isset($_POST['show_number']) ?  $_POST['show_number'] : '0' ;
	$show_email = isset($_POST['show_email']) ?  $_POST['show_email'] : '0' ;
	$show_url = isset($_POST['show_url']) ?  $_POST['show_url'] : '0' ;
	
	
	$Logo= $_FILES['file']['name'];


	$q1 = mysqli_query($con, "select * from setting");
	$row1 = mysqli_num_rows($q1);
	if ($row1) {
		$pic1 = $_FILES['file']['name'];
		$pic= date('m-d-Y_His')."_".$_FILES['file']['name'];
		
		if ($pic1 == "") {
			$que = "update setting set company_name='$cname',company_short_name='$short_name',registration_number='$Rnumber',affiliation_number='$Anumber', font_style='$nfont', company_email='$cmail',watermark='$watermark', company_number='$cnumber',show_email='$show_email', show_number='$show_number', company_address='$caddress',company_url='$company_url',show_url='$show_url',modify_date=now() 
		 where company_id='1'";
		  
			mysqli_query($con, $que);
			
		} else {
			$que = "update setting set company_name='$cname',company_short_name='$short_name',registration_number='$Rnumber',affiliation_number='$Anumber', font_style='$nfont', company_email='$cmail',watermark='$watermark', company_number='$cnumber',show_email='$show_email', show_number='$show_number', company_address='$caddress', company_image='$pic',company_url='$company_url',show_url='$show_url',modify_date=now()
			 where company_id='1'";
			 
			$url=$_SERVER['DOCUMENT_ROOT'];
			$picture = $res['company_image'];
			
			
			$upload_file= date('m-d-Y_His')."_".$_FILES['file']['name'];
			
			if (!empty($picture) && file_exists('../images/profile/$picture')) {
				unlink("images/profile/$picture");
			}
			$upload_path="images/profile/" .$pic; 
			
			mysqli_query($con, $que);
			move_uploaded_file($_FILES['file']['tmp_name'], "../images/profile/" .$pic );
			
			//Logo in school details'
			move_uploaded_file($_FILES['file']['tmp_name'],$url."/schools/Logo/" . $pic);
			
			$schoolque = "update school_details set logo='$upload_path',watermark='$watermark' where registration_no='$registration_no'";
			
			mysqli_query($maindb, $schoolque);

			
			
		}

		if (mysqli_query($con, $que)) {
			$action = "The institute settings are updated.";
			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values (
			'$user_roles','Institute Setting','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);

			$responce['status'] = 'success';
			$responce['message'] = ' Updated Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.'.mysqli_error($con);
		}
	} else { //if not any data avilable in db

		//$pic = $_FILES['file']['name'];
		$pic= date('m-d-Y_His')."_".$_FILES['file']['name'];
		
		if ($pic == "") {
			$que = "insert into setting (company_name,company_short_name,registration_number,affiliation_number,font_style,company_email,watermark,company_number,`show_email`, `show_number`,company_address,company_url,show_url,create_date,modify_date) 
			values ('" . $cname . "','".$short_name."','" . $Rnumber . "','" . $Anumber . "', '" . $nfont . "', '" . $cmail . "','" . $watermark . "', '" . $cnumber . "', '".$show_email."', '".$show_number."','" . $caddress . "', '".$company_url."','" . $show_url . "',now(),now())";
		  
		} else {
			
			$upload_path="images/profile/" .$pic; 
			
			move_uploaded_file($_FILES['file']['tmp_name'], "../images/profile/" . $pic);
			
			$que = "insert into setting (company_name,company_short_name,registration_number,affiliation_number,company_email,watermark,company_number,`show_email`, `show_number`company_address,company_image,company_url,show_url,create_date,modify_date) 
			values ('$cname','".$short_name."','" . $Rnumber . "','" . $Anumber . "','$cmail', '".$show_email."','" . $watermark . "', '".$show_number."','$cnumber','$caddress','$pic', '".$company_url."','" . $show_url . "',now(),now())";
		  
		   //Logo in school details'
			
			
			move_uploaded_file($_FILES['file']['tmp_name'], $url."Logo/" . $_FILES['file']['name']);
			
			$schoolquery = "update school_details set llogo='$upload_path',watermark='$watermark' where registration_no='$registration_no'";
			mysqli_query($maindb, $schoolquery);
		
		}

		if (mysqli_query($con, $que)) {
			$action = "The institute settings are Inserted.";
			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values (
		'$user_roles','Institute Setting','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);
			$responce['status'] = 'success';
			$responce['message'] = 'Inserted Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.'.mysqli_error($con);
		}
	}
	echo json_encode($responce);
}
if(isset($_POST['UpdateEmergencyContacts'])){
	// echo "<pre>";
	// print_r($_POST);
	$mobile =$_POST['mobile'];
	$total=count($mobile);
	$i=1;
	$a=0;
	foreach($mobile as $m){
		$q1 = mysqli_query($con, "select * from `emergency_contact` where id='$i' ");
	    if(mysqli_num_rows($q1)>0){
			$schoolquery = "update emergency_contact set mobile='$mobile[$a]',modify_date=now(), create_date=now()  where id='$i' ";
			$Uquery=mysqli_query($con, $schoolquery);
		}else{
			$msql = "insert into emergency_contact (mobile,create_date,modify_date)values ('$mobile[$a]',now(),now())";
			$Iquery = mysqli_query($con, $msql);
		}
		$i++;
		$a++;
	}
	if ($Uquery) {
		$responce['status'] = 'success';
		$responce['message'] = 'Updated Successfully';
	}elseif($Iquery){
		$responce['status'] = 'success';
		$responce['message'] = 'Inserted Successfully';

	} else {
		$responce['status'] = 'error';
		$responce['message'] = 'Something went wrong, Please try again.'.mysqli_error($con);
	}

echo json_encode($responce);

}





if (isset($_POST['add_expense_type'])) {
	// echo "<pre>";
	// print_r($_POST);
	$expense = mysqli_real_escape_string($con, trim($_POST['expense']));
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));



	$sql = mysqli_query($con, "select * from expense_type where expense_type_name='$expense'");

	$res = mysqli_num_rows($sql);

	if ($res) {

		$responce['status'] = 'error';
		$responce['message'] = 'This Expense Type Is Already Exists ';
	} else {

		$query = "insert into expense_type (`expense_type_name`,`create_date`,`modify_date`,sessionid)values('$expense',now(),now(),'" . $_SESSION['session'] . "')";

		$nquery = mysqli_query($con, $query);

		// if( mysqli_error($con)){

		//     echo("Error description: " . mysqli_error($con));

		// }
		if ($nquery) {

			$action = "Expense type " . $expense . " is created";
			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values (
		        '$user_roles','Expense Type','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);

			$responce['status'] = 'success';
			$responce['message'] = 'Expense Type Added Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again' . mysqli_error($con);
		}
	}
	echo json_encode($responce);
}

if (isset($_POST['update_expense_type'])) {
	// echo "<pre>";
	// print_r($_POST);
	$eid = mysqli_real_escape_string($con, trim($_POST['eid']));
	$expense = mysqli_real_escape_string($con, trim($_POST['expense']));
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));



	$sql1 = mysqli_query($con, "select * from expense_type where expense_type_name='$expense' and expense_type_id!='$eid' ");

	$res1 = mysqli_num_rows($sql1);

	if ($res1) {
		$responce['status'] = 'error';
		$responce['message'] = 'This Expense Type Is Already Exists ';
	} else {

		$query = "update expense_type set expense_type_name='$expense',modify_date=now() where expense_type_id='$eid'";

		if (mysqli_query($con, $query)) {

			$action = "Expense type " . $expname . " is edited";

			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values (
		        '$user_roles','Expense Type','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);


			$responce['status'] = 'success';
			$responce['message'] = 'Expense Type Updated Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}
	}
	echo json_encode($responce);
}

if (isset($_POST['add_fees_header'])) {
	// echo "<pre>";
	// print_r($_POST);
	$feehead = mysqli_real_escape_string($con, trim($_POST['feehead']));
	$type = mysqli_real_escape_string($con, $_POST['type']);
	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));


	$sql = mysqli_query($con, "select * from fee_header where fee_header_name='$feehead'  and deletion_indicator='0' ");
	$res = mysqli_num_rows($sql);
	if ($res) {

		$responce['status'] = 'error';
		$responce['message'] = 'This Fees Header is Already Exists.  ';
	} else {
		$query = "insert into fee_header(fee_header_name,type,create_date,modify_date) values('$feehead','$type',now(),now())";
		if (mysqli_query($con, $query)) {
			$action = "Fee Header " . $feehead . " is created";
			$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values ('$user_roles','view Fees Header','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
			$q1 = mysqli_query($con, $msql);
			$responce['status'] = 'success';
			$responce['message'] = ' Fees Header Added Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}
	}
	echo json_encode($responce);
}
if (isset($_POST['update_fees_header'])) {
	// echo "<pre>";
	// print_r($_POST);
	$nfee_name = mysqli_real_escape_string($con, trim($_POST['nfee_name']));
	$ftype = mysqli_real_escape_string($con, $_POST['ftype']);
	$fid = mysqli_real_escape_string($con, $_POST['fid']);

	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));



	$sql1 = mysqli_query($con, "select * from fee_header where fee_header_name='$nfee_name' and  type='$ftype' and fee_header_id!='$fid' and deletion_indicator='0' ");
	$res1 = mysqli_num_rows($sql1);
	if ($res1) {
		$responce['status'] = 'error';
		$responce['message'] = 'This Fees Header is Already Exists.  ';
	} else {
		$uquery = mysqli_query($con, "update fee_header set fee_header_name='$nfee_name' ,type='$ftype',modify_date=now() where fee_header_id='$fid'");

		if ($uquery) {

			$responce['status'] = 'success';
			$responce['message'] = ' Fees Header Updated Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}



		// echo "<script>window.location='dashboard.php?option=view_fees_header'</script>";	
	}
	echo json_encode($responce);
}

// -----------------------------------------  assign_fees_to_class --------------------------------------------------
if (isset($_POST['assign_fees_to_class'])) {
	// echo "<pre>";
	// print_r($_POST);
	// die;
	$class = mysqli_real_escape_string($con, trim($_POST['class']));
	$months = mysqli_real_escape_string($con, $_POST['months']);
	$tamount = mysqli_real_escape_string($con, $_POST['tamount']);
	$feehead = $_POST['feehead'];
	$feeamt = $_POST['feeamt'];

	$user_roles = mysqli_real_escape_string($con, trim($_SESSION['user_roles']));
	$machinename = mysqli_real_escape_string($con, trim($_SESSION['machinename']));
	$ExactBrowserNameBR = mysqli_real_escape_string($con, trim($_SESSION['ExactBrowserNameBR']));

	$q2 = mysqli_query($con, "select * from class where class_id='$class'");

	$r2 = mysqli_fetch_array($q2);

	$clsname = $r2['class_name'];

	$fhead = implode(',', $feehead);

	$famt = implode(',', $feeamt);

	$query = "insert into assign_fee_class(class_id,fee_header_id,fee_header_amount,total_amount,session,no_of_months)

	values('$class','$fhead','$famt','$tamount','" . $_SESSION['session'] . "','$months')";


	$Current_Month = date('m');
	$Current_Year = date('Y');

	/****************** Becuase We Start From April so We Take APRIL AS 1ST Month***************************/
	if ($Current_Month < 4) {
		$Current_Month = $Current_Month + 9;
	} else {
		$Current_Month = $Current_Month - 3;
	}
	// && sr.section_id='$section'
	// $stuQuery = mysqli_query($con,"select * from students where  class_id='$class' and session='".$_SESSION['session']."'");
	$fsql = "select `student_id`,`student_name`,`admission_date`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class'  && sr.session='" . $_SESSION['session'] . "'";
	$stuQuery = mysqli_query($con, $fsql);
	if (mysqli_num_rows($stuQuery) > 0) {

		while ($stude_data = mysqli_fetch_array($stuQuery)) {
			$St_wise_months = $months;
			$Admission_date = explode('-', $stude_data['admission_date']);

			$Admission_month = $Admission_date[1];
			$Admission_Year = $Admission_date[0];

			$Admission_month = ltrim($Admission_month, "0");
			$startFeeMonth = 4;
			if ($Admission_month > $startFeeMonth && $Admission_Year == $Current_Year) {


				$No_of_Month_FeeNo_Charge = $Admission_month - $startFeeMonth;
				$St_wise_months = $months - $No_of_Month_FeeNo_Charge;

				$ReIndexAddmission_Month = $Admission_month - 4;
				$current_fee_charge_Month = $Current_Month - $ReIndexAddmission_Month;
				$fee_start_month = $Admission_month;
			} else {
				$current_fee_charge_Month = 12;
				$St_wise_months = 12;
				$fee_start_month = 4;
			}



			$Student_Wise_Total_Amount = 0;
			$Student_Wise_Current_Due = 0;
			$TStu_Amount = 0;
			$NO_Of_Fee_Head = count($feehead);
			for ($i = 0; $i < $NO_Of_Fee_Head; $i++) {
				$feeid = $feehead[$i];

				$FHquery = mysqli_query($con, "select * from fee_header where fee_header_id='$feeid'");
				$FHRow = mysqli_fetch_array($FHquery);
				$fheadtype = $FHRow['type'];
				if ($fheadtype == '1') {
					$FeeHeadAmount = $feeamt[$i];
					$Current_FeeHeadAmount = $feeamt[$i];

					$FeeHeadAmount = $FeeHeadAmount * $St_wise_months;

					$Current_FeeHeadAmount = $Current_FeeHeadAmount * $current_fee_charge_Month;

					$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;

					$Student_Wise_Current_Due = $Student_Wise_Current_Due + $Current_FeeHeadAmount;
				} else {

					$FeeHeadAmount = $feeamt[$i];
					$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;

					//$Student_Wise_Current_Due=$Student_Wise_Current_Due+$FeeHeadAmount;
				}
			}

			$TStu_Amount = $Student_Wise_Total_Amount;

			// $Current_Stu_Amount=$Student_Wise_Current_Due;
			$create_date = date('Y-m-d H:i:s');
			$modify_date = $create_date;

			$query2 = "insert into student_wise_fees(student_id,class_id,section_id,fee_header_id,fee_amount,due_amount, no_of_months,fee_start_month,session,create_date,modify_date)  values('" . $stude_data['student_id'] . "','$class','" . $stude_data['section_id'] . "','$fhead','$famt','$TStu_Amount','$St_wise_months',$fee_start_month,'" . $_SESSION['session'] . "','$create_date','$modify_date')";
			mysqli_query($con, $query2);
			//echo "update students set due='$TStu_Amount' where class_id='$class'";die;

			mysqli_query($con, "update students set due='$TStu_Amount',modify_date='$modify_date' where student_id='" . $stude_data['student_id'] . "' ");
		} //while
	}

	if (mysqli_query($con, $query)) {

		$qc = mysqli_query($con, "select * from class where class_id='$class'");
		$rc = mysqli_fetch_array($qc);
		$clsname = $rc['class_name'];
		$action = "For Class " . $clsname . " Fee is assigned";

		$msql = "insert into activity_history (login_user,sub_menu,action_details,machine_name,browser,date,session)values ('$user_roles','view assign fees to classes','$action','$machinename','$ExactBrowserNameBR',now(),'" . $_SESSION['session'] . "')";
		$q1 = mysqli_query($con, $msql);


		$responce['status'] = 'success';
		$responce['message'] = 'Fees Assign Successfully';
	} else {
		$responce['status'] = 'error';
		$responce['message'] = 'Something went wrong, Please try again.';
	}
	echo json_encode($responce);
}

// -----------------------------------update_assign_fees_to_class----------------------------------------------

if (isset($_POST['update_assign_fees_to_class'])) {
	// echo "<pre>";
	// print_r($_POST);
	// die;
	// $class=mysqli_real_escape_string($con,trim($_POST['class']));
	$months = mysqli_real_escape_string($con, $_POST['months']);
	$tamount = mysqli_real_escape_string($con, $_POST['tamount']);
	$assid = mysqli_real_escape_string($con, $_POST['assid']);
	$cls_id = mysqli_real_escape_string($con, $_POST['cls_id']);
	$feehead = $_POST['feehead'];
	$feeamt = $_POST['feeamt'];
	$create_date = date('Y-m-d H:i:s');
	$modify_date = $create_date;

	$fhead = implode(',', $feehead);
	$famt = implode(',', $feeamt);

	$Current_Month = date('m');
	$Current_Year = date('Y');
	/****************** Becuase We Start From April so We Take APRIL AS 1ST Month***************************/
	if ($Current_Month < 4) {
		$Current_Month = $Current_Month + 9;
	} else {
		$Current_Month = $Current_Month - 3;
	}


	foreach ($feeamt as $k) {
		@$due = $due + $k;
	}

	$q1 = mysqli_query($con, "select * from student_due_fees where class_id='$cls_id' and  session='" . $_SESSION['session'] . "' and ( fee_header_status='0' || fee_header_status='' ) ");
	$row = mysqli_num_rows($q1);
	if ($row) {
		// echo "<script>alert('Cannot Edit ".$clsname." Fee Details.')</script>";
		$responce['status'] = 'error';
		$responce['message'] = 'Cannot Edit ' . $clsname . ' Fee Details.';
		echo json_encode($responce);
		die;
	} else {
		$query = mysqli_query($con, "update assign_fee_class set fee_header_id='$fhead', no_of_months='$months', fee_header_amount='$famt', total_amount='$tamount', modify_date='$modify_date'
		where class_id='$cls_id' and  session='" . $_SESSION['session'] . "'");

		if ($query) {

			// $stuQuery = mysqli_query($con,"select * from students where  class_id='$cls_id' and  session='".$_SESSION['session']."'");
			$fsql2 = "select `student_id`,`admission_date`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$cls_id' && sr.session='" . $_SESSION['session'] . "'";
			$stuQuery = mysqli_query($con, $fsql2);

			if (mysqli_num_rows($stuQuery) > 0) {
				while ($stude_data = mysqli_fetch_array($stuQuery)) {
					$St_wise_months = $months;
					$Admission_date = explode('-', $stude_data['admission_date']);

					$Admission_month = $Admission_date[1];
					$Admission_Year = $Admission_date[0];

					$Admission_month = ltrim($Admission_month, "0");
					$startFeeMonth = 4;
					if ($Admission_month > $startFeeMonth && $Admission_Year == $Current_Year) {


						$No_of_Month_FeeNo_Charge = $Admission_month - $startFeeMonth;
						$St_wise_months = $months - $No_of_Month_FeeNo_Charge;

						$ReIndexAddmission_Month = $Admission_month - 4;
						$current_fee_charge_Month = $Current_Month - $ReIndexAddmission_Month;
						$fee_start_month = $Admission_month;
					} else {
						$current_fee_charge_Month = 12;
						$St_wise_months = 12;
						$fee_start_month = 4;
					}



					$Student_Wise_Total_Amount = 0;
					$Student_Wise_Current_Due = 0;
					$TStu_Amount = 0;
					$NO_Of_Fee_Head = count($feehead);
					for ($i = 0; $i < $NO_Of_Fee_Head; $i++) {
						$feeid = $feehead[$i];

						$FHquery = mysqli_query($con, "select * from fee_header where fee_header_id='$feeid'");
						$FHRow = mysqli_fetch_array($FHquery);
						$fheadtype = $FHRow['type'];
						if ($fheadtype == '1') {
							$FeeHeadAmount = $feeamt[$i];
							$Current_FeeHeadAmount = $feeamt[$i];

							$FeeHeadAmount = $FeeHeadAmount * $St_wise_months;

							$Current_FeeHeadAmount = $Current_FeeHeadAmount * $current_fee_charge_Month;

							$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;

							$Student_Wise_Current_Due = $Student_Wise_Current_Due + $Current_FeeHeadAmount;
						} else {

							$FeeHeadAmount = $feeamt[$i];
							$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;

							//$Student_Wise_Current_Due=$Student_Wise_Current_Due+$FeeHeadAmount;
						}
					}

					$TStu_Amount = $Student_Wise_Total_Amount;



					mysqli_query($con, "update student_wise_fees set fee_header_id='$fhead', no_of_months='$St_wise_months', fee_start_month='$fee_start_month',  fee_amount='$famt', due_amount='$TStu_Amount',modify_date='$modify_date' 
						where class_id='$cls_id' and  session='" . $_SESSION['session'] . "'");

					// mysqli_query($con,"update students set due='$TStu_Amount',modify_date='$modify_date'  where class_id='$cls_id' and  session='".$_SESSION['session']."'");
					mysqli_query($con, "update students as s join student_records as sr set due='$TStu_Amount',modify_date='$modify_date'  where sr.class_id='$cls_id' and  sr.session='" . $_SESSION['session'] . "'");
				} //while
			} //if

			$responce['status'] = 'success';
			$responce['message'] = 'Fees updated Successfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something went wrong, Please try again.';
		}

		// echo "<script>window.location='dashboard.php?option=view_assign_fees_to_class'</script>";	
	} //else
	echo json_encode($responce);
}

if (isset($_POST['assign_late_fee_to_class'])) {
	// echo "<pre>";
	// print_r($_POST);
	$classid = mysqli_real_escape_string($con, trim($_POST['classid']));
	$late_fee_amt = mysqli_real_escape_string($con, trim($_POST['late_fee_amt']));
	$late_fee_days = mysqli_real_escape_string($con, trim($_POST['late_fee_days']));

	if (empty($classid)) {
		$error = 'Please Choose Class';
	} elseif (empty($late_fee_amt)) {
		$error = 'Please Enter Late Fee Amount';
	} elseif (empty($late_fee_days)) {
		$error = 'Please Enter Days of Late Fee';
	}
	if (isset($error)) {
		$responce['status'] = 'error';
		$responce['message'] = $error;
		echo json_encode($responce);
		die;
	}

	if (!isset($error)) {

		$fsql = "select `student_id`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`session` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$classid'  && sr.session='" . $_SESSION['session'] . "'";
		$stuQuery = mysqli_query($con, $fsql);
		if (mysqli_num_rows($stuQuery) > 0) {
			while ($s = mysqli_fetch_assoc($stuQuery)) {
				// print_r($s);

				$chkQuery = mysqli_query($con, "SELECT * FROM `late_fee` WHERE student_id='" . $s['student_id'] . "' and session='" . $_SESSION['session'] . "'");
				if (!mysqli_num_rows($chkQuery) > 0) {

					$Lsql = "INSERT INTO `late_fee`( `class_id`, `section_id`, `student_id`, `late_fee_amount`, `late_fee_date`, `session`, `create_date`, `modify_date`) VALUES ('" . $s['class_id'] . "','" . $s['section_id'] . "','" . $s['student_id'] . "','" . $late_fee_amt . "','" . $late_fee_days . "','" . $_SESSION['session'] . "',now(),now())";
					$LQuery = mysqli_query($con, $Lsql);
				}
			} //while
			if ($LQuery) {
				$responce['status'] = 'success';
				$responce['message'] = 'Late Fee Assign Sucessfully';
			} else {
				$responce['status'] = 'error';
				$responce['message'] = 'Already Assign Late Fees to this Class.';
			}
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'No any Student in this class';
		}
		echo json_encode($responce);
	}
}

// if(isset($_POST['update_late_fee_detail'])){  //currently not in use
// // echo "<pre>";
// // print_r($_POST);
// $id=mysqli_real_escape_string($con,trim($_POST['lid']));
// if(!empty($_POST['late_amt'])){
//     $late_fee_amt=mysqli_real_escape_string($con,trim($_POST['late_amt']));
// }else{
// 	$late_fee_amt='0';
// }
// if(!empty($_POST['late_days'])){
// $late_fee_days=mysqli_real_escape_string($con,trim($_POST['late_days']));
// }else{
// 	$late_fee_days='0';
// }

// if(empty($id)){
// 		$error='Something Error Please try again';
// }

// if(isset($error)){
// 	$responce['status']='error';						 
// 	$responce['message']=$error;
// echo json_encode($responce); die;
// }

// if(!isset($error)){

// 	    $usql="UPDATE `late_fee` SET `late_fee_amount`='$late_fee_amt',`late_fee_date`='$late_fee_days',`modify_date`=now() WHERE id='$id' and session='".$_SESSION['session']."'";
// 		$LQuery = mysqli_query($con,$usql);

// 		if($LQuery){
// 			$responce['status']='success';						 
// 			        $responce['message']='Update Sucessfully';
// 		}else{
// 			$responce['status']='error';						 
// 			$responce['message']='Something Went wrong please try again';

// 		}
//     echo json_encode($responce);	
// }			
// }
if (isset($_POST['update_late_fee'])) {  //currently not in use
	// echo "<pre>";
	// print_r($_POST);

	$class_id = mysqli_real_escape_string($con, trim($_POST['class_id']));
	$section_id = mysqli_real_escape_string($con, trim($_POST['section_id']));
	$late_id = $_POST['late_id'];
	// $stuid=$_POST['stuid'];
	$late_amt = $_POST['late_amt'];
	$late_days = $_POST['late_days'];
	$x = 0;
	$y = 0;
	foreach ($late_id as $late_fee_id) {

		$late_fee_amount = $late_amt[$x];
		$late_fee_date = $late_days[$x];

		if (!empty($late_fee_id)) {
			$chkQuery = mysqli_query($con, "SELECT * FROM `late_fee` WHERE id='$late_fee_id' and session='" . $_SESSION['session'] . "'");
			$crow = mysqli_fetch_assoc($chkQuery);
			if ($late_fee_amount != $crow['late_fee_amount']  || $late_fee_date != $crow['late_fee_date']) {
				$usql = "UPDATE `late_fee` SET `late_fee_amount`='$late_fee_amount',`late_fee_date`='$late_fee_date',`modify_date`=now() WHERE id='$late_fee_id' and session='" . $_SESSION['session'] . "'";
				$LQuery = mysqli_query($con, $usql);
				if ($LQuery) {
					$y++;
				}
			}
		}

		$x++;
	}
	if ($LQuery || $y > 0) {
		$responce['status'] = 'success';
		$responce['message'] = $y . ' Records Update Sucessfully';
	} else {
		$responce['status'] = 'error';
		$responce['message'] = 'No any Records for update';
	}

	echo json_encode($responce);
	die;
}

if (isset($_POST['Add_text_sms_templates'])) {
	// echo "<pre>";
	// print_r($_POST);
	$language = mysqli_real_escape_string($con, trim($_POST['language']));

	$title = mysqli_real_escape_string($con, trim($_POST['title']));
	$msg_type = mysqli_real_escape_string($con, trim($_POST['msg_type']));
	$temp_id = mysqli_real_escape_string($con, trim($_POST['temp_id']));
	$text_sms = mysqli_real_escape_string($con, trim($_POST['text_sms']));
	$sample_sms = mysqli_real_escape_string($con, trim($_POST['sample_sms']));
	$staus = mysqli_real_escape_string($con, trim($_POST['status']));

	$sql = "SELECT * FROM `textsms_templates` where `temp_id`='$temp_id' ";
	$query = mysqli_query($con, $sql);
	$sql2 = "SELECT * FROM `textsms_templates` where `msg_type`='$msg_type' ";
	$query2 = mysqli_query($con, $sql2);
	if (mysqli_num_rows($query) > 0) {
		$responce['status'] = 'error';
		$responce['message'] = "Temp id Already Exists";
		echo json_encode($responce);
		die;
	} elseif (mysqli_num_rows($query2) > 0) {
		$responce['status'] = 'error';
		$responce['message'] = "Slug Already Exists";
		echo json_encode($responce);
		die;
	} else {
		$Tsql = "INSERT INTO `textsms_templates`( `msg_type`, `temp_id`, `title`, `description`, `dummy_sms`, `lang_type`, `create_date`, `modify_date`, `status`) VALUES ('$msg_type','$temp_id','$title','$text_sms','$sample_sms','$language',now(),now(),'$staus')";
		mysqli_set_charset($con, 'utf8');
		$LQuery = mysqli_query($con, $Tsql);

		if ($LQuery) {
			$responce['status'] = 'success';
			$responce['message'] = 'Template Added Sucessfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something Went wrong please try again' . mysqli_error($con);
		}
		echo json_encode($responce);
	}
}


if (isset($_POST['Update_text_sms_templates'])) {
	// echo "<pre>";
	// print_r($_POST);
	$language = mysqli_real_escape_string($con, trim($_POST['language']));
	$id = mysqli_real_escape_string($con, trim($_POST['id']));

	$title = mysqli_real_escape_string($con, trim($_POST['title']));
	$msg_type = mysqli_real_escape_string($con, trim($_POST['msg_type']));
	$temp_id = mysqli_real_escape_string($con, trim($_POST['temp_id']));
	$text_sms = mysqli_real_escape_string($con, trim($_POST['text_sms']));
	$sample_sms = mysqli_real_escape_string($con, trim($_POST['sample_sms']));
	$staus = mysqli_real_escape_string($con, trim($_POST['status']));

	$sql = "SELECT * FROM `textsms_templates` where `temp_id`='$temp_id' and id!='$id' ";
	$query = mysqli_query($con, $sql);
	if (empty($id)) {
		$error = 'Something Error Please try again';
	} elseif (mysqli_num_rows($query) > 0) {
		$error = "Temp id Already Exists";
	}
	if (isset($error)) {
		$responce['status'] = 'error';
		$responce['message'] = $error;
		echo json_encode($responce);
		die;
	}

	if (!isset($error)) {

		$Tsql = "UPDATE `textsms_templates` SET `msg_type`='$msg_type',`temp_id`='$temp_id',`title`='$title',`description`='$text_sms',`dummy_sms`='$sample_sms',`lang_type`='$language',`modify_date`=now(),`status`='$staus' WHERE `id`='$id'";
		mysqli_set_charset($con, 'utf8');
		$LQuery = mysqli_query($con, $Tsql);

		if ($LQuery) {
			$responce['status'] = 'success';
			$responce['message'] = 'Update Sucessfully';
		} else {
			$responce['status'] = 'error';
			$responce['message'] = 'Something Went wrong please try again' . mysqli_error($con);
		}
		echo json_encode($responce);
	}
}
