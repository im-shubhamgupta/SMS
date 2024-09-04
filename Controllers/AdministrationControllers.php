<?php include('../myfunction.php')?>
<?php
date_default_timezone_set('Asia/Kolkata');


if(isset($_POST['create_feedback'])){
// echo "<pre>";
// print_r($_POST);
$submissiondate=mysqli_real_escape_string($con,trim($_POST['submissiondate']));
$classid=mysqli_real_escape_string($con,trim($_POST['classid']));
$sectionid=mysqli_real_escape_string($con,trim($_POST['sectionid']));
$student=mysqli_real_escape_string($con,trim($_POST['student']));
$requestid=mysqli_real_escape_string($con,trim($_POST['requestid']));
$raisedfor=mysqli_real_escape_string($con,trim($_POST['raisedfor']));
$title=mysqli_real_escape_string($con,trim($_POST['title']));
$description=mysqli_real_escape_string($con,trim($_POST['description']));
if(!empty($_POST['staffid'])){
	$staffid=mysqli_real_escape_string($con,trim($_POST['staffid']));
}else{
	$staffid='0';
}
	$sql="insert into feedback (class_id,section_id,submission_date,student_id,request_id,raised_for,staff_id,title,description,status,session,create_date,modify_date)
		values('$classid','$sectionid','$submissiondate','$student','$requestid','$raisedfor','$staffid','$title','$description',0,'".$_SESSION['session']."',now(),now())"; 
	$q1 = mysqli_query($con,$sql);
	if($q1){
	        $responce['status']='success';						 
		    $responce['message']='Feedback created Successfully';	

		}else{
			$responce['status']='error';						 
		        $responce['message']='Something went wrong, Please try again.'.mysqli_error($con);

		}
	// if(mysqli_error($con)){
    //  	echo("Error description: " . mysqli_error($con));
	// }
echo json_encode($responce);
}

if(isset($_POST['create_remedy'])){
// echo "<pre>";
// print_r($_POST);

$classid=mysqli_real_escape_string($con,trim($_POST['classid']));
$sectionid=mysqli_real_escape_string($con,trim($_POST['sectionid']));
$staffid=mysqli_real_escape_string($con,trim($_POST['staffid']));
$student=mysqli_real_escape_string($con,trim($_POST['student']));
$observe=mysqli_real_escape_string($con,trim($_POST['observe']));
$remedy=mysqli_real_escape_string($con,trim($_POST['remedy']));
$duration=mysqli_real_escape_string($con,trim($_POST['duration']));
$startdate=mysqli_real_escape_string($con,trim($_POST['startdate']));
$enddate=mysqli_real_escape_string($con,trim($_POST['enddate']));
$newrid=mysqli_real_escape_string($con,trim($_POST['newrid']));
$user=$_SESSION['user_roles'];


	$img = $_FILES['file']['name'];
	$name=explode('.',$img);
	$ext=pathinfo($img,PATHINFO_EXTENSION);
	// $num=substr($name[0],0,4);             
	$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;

	$create_date=date('Y-m-d H:i:s');
	$modify_date=$create_date;

	$q1 = mysqli_query($con,"insert into remedy (rid,class_id,section_id,student_id,staff_id,observations,

	observations_proof,remedies_taken,duration,start_date,end_date,status,session,create_date,modify_date) 

	values('$newrid','$classid','$sectionid','$student','$staffid','$observe','$image_name','$remedy','$duration',

	'$startdate','$enddate',0,'".$_SESSION['session']."','$create_date','$modify_date')");

	// if(mysqli_error($con)){  	echo("Error description: " . mysqli_error($con)); }
	if($q1){

		move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/remedy/".$image_name);

		// $q2 = mysqli_query($con,"select * from students where student_id='$student' and session='".$_SESSION['session']."'");
		$asql="select `register_no`,`student_id`,`student_name`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.student_id='$student' and  s.stu_status='0'   && sr.session='".$_SESSION['session']."'";
		$q2=mysqli_query($con,$asql);

		$responce['status']='success';						 
		    $responce['message']='Remedy created Successfully';	

		$r2 = mysqli_fetch_array($q2);

		$name = $r2['student_name'];

		$mobile = $r2['parent_no'];

		$msgtype=$r2['msg_type_id'];

		$q3 = mysqli_query($con,"select * from staff where st_id='$staffid'");

		$r3 = mysqli_fetch_array($q3);

		$stname = $r3['staff_name'];

		$sset=mysqli_query($con,"select * from setting");
		$rsset=mysqli_fetch_array($sset);
		$sclname=$rsset['company_name'];

		$nstdate = date("d-m-Y", strtotime($startdate));

		$nenddate = date("d-m-Y", strtotime($enddate));

        $Wcount=get_whatsapp_sms_count()['count_sms'];
		$Wstatus=get_whatsapp_sms_setting()['status'];

		

		$msg = "Hi,%0aThe Remedy is created for your ward, Please find the details:%0aRemedy for: ".$name.

		"%0aObservations: ".$observe."%0aAssigned to: ".$stname."%0aDuration: ".$duration."%0aStart date: "

		.$nstdate."%0aEnd Date: ".$nenddate."%0aFrom%0a".$sclname." ";

		$messagetype = 'remedy_message';

		if($Wstatus==1 && $Wcount>0){

			if($msgtype==1){

				$q4=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,

				subject,selected_no,message,msg_type,loginuser,notice_datetime,date,session)

				values(3,'$student','$classid','$sectionid',0,'$mobile','$msg','1','$user',now(),now(),'".$_SESSION['session']."')");

				sendwhatsappMessage($mobile, $msg, $messagetype);
			}
		}
	}else{
			$responce['status']='error';						 
		        $responce['message']='Something went wrong, Please try again.'.mysqli_error($con);

	}
echo json_encode($responce);
}


if(isset($_POST['update_remedy'])){
// echo "<pre>";
// print_r($_POST);

$classid=mysqli_real_escape_string($con,trim($_POST['classid']));
$sectionid=mysqli_real_escape_string($con,trim($_POST['sectionid']));
$nstaffid=mysqli_real_escape_string($con,trim($_POST['nstaffid']));
$student=mysqli_real_escape_string($con,trim($_POST['student']));
$nobserve=mysqli_real_escape_string($con,trim($_POST['nobserve']));
$nremedy=mysqli_real_escape_string($con,trim($_POST['nremedy']));
$nduration=mysqli_real_escape_string($con,trim($_POST['nduration']));
$nstartdate=mysqli_real_escape_string($con,trim($_POST['nstartdate']));
$nenddate=mysqli_real_escape_string($con,trim($_POST['nenddate']));
$rid=mysqli_real_escape_string($con,trim($_POST['id']));
$user=$_SESSION['user_roles'];

$rid = $_REQUEST['id'];

$que = mysqli_query($con,"select * from remedy where remedy_id='$rid'");
$res = mysqli_fetch_array($que);
$clsid = $res['class_id'];

$q1 = mysqli_query($con,"select * from class where class_id='$clsid'");
$r1 = mysqli_fetch_array($q1);
$clsname = $r1['class_name'];
$secid = $res['section_id']; 

$q2 = mysqli_query($con,"select * from section where section_id='$secid'");
$r2 = mysqli_fetch_array($q2);
$secname = $r2['section_name'];
$stuid = $res['student_id']; 

// $q3 = mysqli_query($con,"select * from students where student_id='$stuid' ");
$asql="select `register_no`,`student_id`,`student_name`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.student_id='$stuid' and  s.stu_status='0'  "; // && sr.session='".$_SESSION['session']."'
$q3=mysqli_query($con,$asql);
$r3 = mysqli_fetch_array($q3);
$stuname = $r3['student_name'];
$staff = $res['staff_id']; 
$proof=$res['observations_proof'];


	$nimg = $_FILES['file']['name'];
	if(!empty($nimg)){
			$name=explode('.',$nimg);
			$ext=pathinfo($nimg,PATHINFO_EXTENSION);
			// $num=substr($name[0],0,4);             
			$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
	}

	if($nimg==""){

		$query = mysqli_query($con,"update remedy set staff_id='$nstaffid', observations='$nobserve', 

		remedies_taken='$nremedy', duration='$nduration', start_date='$nstartdate', end_date='$nenddate',modify_date=now() 

		where remedy_id='$rid'");

	}else{
		// echo $sql=;
		$query = mysqli_query($con,"update remedy set staff_id='$nstaffid', observations='$nobserve', 

		observations_proof='$image_name', remedies_taken='$nremedy', duration='$nduration', 

		start_date='$nstartdate', end_date='$nenddate',modify_date=now() where remedy_id='$rid'");
		

		if(move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/remedy/".$image_name)){
			if(!empty($proof) && file_exists('../gallery/remedy/'.$proof)){
		        unlink("../gallery/remedy/$proof");
            }

		}
		
	}	
	if($query){
	        $responce['status']='success';						 
		    $responce['message']='Update Remedy Successfully';	

		}else{
			$responce['status']='error';						 
		        $responce['message']='Something went wrong, Please try again.';
		}
echo json_encode($responce);

}

if(isset($_POST['approve_remedy'])){
// echo "<pre>";
// print_r($_POST);

$remedyno=mysqli_real_escape_string($con,trim($_POST['remedyno']));
$improvement=mysqli_real_escape_string($con,trim($_POST['improvement']));
$approvedby=mysqli_real_escape_string($con,trim($_POST['approvedby']));
	$img = $_FILES['file']['name'];
	$name=explode('.',$img);
	$ext=pathinfo($img,PATHINFO_EXTENSION);
	$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
	

	$que = mysqli_query($con,"update remedy set improvement='$improvement', improvement_proof='$image_name', 

	approved_by='$approvedby', status=1,modify_date=now() where remedy_id='$remedyno'");

	

	if($que){

		move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/remedy/".$image_name);

		$responce['status']='success';						 
		    $responce['message']='Remedy Approved Successfully';
		

		$q1 = mysqli_query($con,"select * from remedy where remedy_id='$remedyno'");

		$r1 = mysqli_fetch_array($q1);

		

		$student = $r1['student_id'];

		// $q2 = mysqli_query($con,"select * from students where student_id='$student'");
		$asql="select `register_no`,`student_id`,`student_name`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where s.student_id='$student' and  s.stu_status='0'  ";// && sr.session='".$_SESSION['session']."'
		$q2=mysqli_query($con,$asql);

		$r2 = mysqli_fetch_array($q2);

		$name = $r2['student_name'];

		$classid = $r2['class_id'];

		$sectionid = $r2['section_id'];

		$mobile = $r2['parent_no'];
		$msgtype=$r2['msg_type_id'];
		$observe = $r1['observations'];
		$staffid = $r1['staff_id'];		

		$q3 = mysqli_query($con,"select * from staff where st_id='$staffid'");

		$r3 = mysqli_fetch_array($q3);

		$stname = $r3['staff_name'];

		$duration = $r1['duration'];
		$startdate = $r1['start_date'];

		$nstdate = date("d-m-Y", strtotime($startdate));

		$enddate = $r1['end_date'];

		$nenddate = date("d-m-Y", strtotime($enddate));
		 $Wcount=get_whatsapp_sms_count()['count_sms'];
		$Wstatus=get_whatsapp_sms_setting()['status'];

				$msg = "Hi,%0aThe Remedy is Approved for your ward, Please find the details:%0aRemedy for: ".$name.

				"%0aObservations: ".$observe."%0aAssigned to: ".$stname."%0aDuration: ".$duration."%0aStart date: "

				.$nstdate."%0aEnd Date: ".$nenddate."%0aImproved Comments: ".$improvement."%0aApproved By :".$approvedby."%0aFrom%0a".$sclname." ";
				

				$msgn = "Hi,<br>The Remedy is Approved for your ward, Please find the details:<br>Remedy for: ".$name.

				"<br>Observations: ".$observe."<br>Assigned to: ".$stname."<br>Duration: ".$duration."<br>Start date: "

				.$nstdate."<br>End Date: ".$nenddate."<br>Improved Comments: ".$improvement."<br>Approved By :".$approvedby."%0aFrom%0a".$sclname." ";

		if($Wstatus==1 && $Wcount>0){

		if($msgtype==1){

				$q4=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,

				subject,selected_no,message,msg_type,loginuser,notice_datetime,date,session)

				values(3,'$student','$classid','$sectionid',0,'$mobile','$msgn','1','$user',now(),now(),'".$_SESSION['session']."')");
				sendwhatsappMessage($mobile, $msg, $messagetype);
		    }
	    }
	
    }else{
    	$responce['status']='error';						 
		        $responce['message']='Something went wrong, Please try again.';
	}	        
echo json_encode($responce);
}


if(isset($_POST['add_budget_header'])){
// echo "<pre>";
// print_r($_POST);

$header=mysqli_real_escape_string($con,trim($_POST['header']));


		$sql=mysqli_query($con,"select * from budget_header where budget_header_name='$header'");

		$res=mysqli_num_rows($sql);

		if($res){

			$responce['status']='error';						 
		        $responce['message']='This Budget Header Is Already Exists';	

		}

		else

		{

			$query=mysqli_query($con,"insert into budget_header (budget_header_name,create_date,modify_date) values('$header',now(),now())");	
			if($query){
	        $responce['status']='success';						 
		    $responce['message']='Budget Header Added Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.'.mysqli_error($con);
			}
		}
echo json_encode($responce);

}

if(isset($_POST['update_budget_header'])){
// echo "<pre>";
// print_r($_POST);
$id=mysqli_real_escape_string($con,trim($_POST['id']));
$header=mysqli_real_escape_string($con,trim($_POST['header']));

	$sql=mysqli_query($con,"select * from budget_header where budget_header_name='$header' and budget_header_id !='$id'");

		$res=mysqli_num_rows($sql);

		if($res){

			$responce['status']='error';						 
		        $responce['message']='This Budget Header Is Already Exists';	

		}else{
			$query=mysqli_query($con,"update budget_header set budget_header_name='$header',modify_date=now() where budget_header_id ='$id'");
		}

	if($query){
	        $responce['status']='success';						 
		    $responce['message']='Budget Header updated Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.';
			}
echo json_encode($responce);	

}

if(isset($_POST['add_budget_expense'])){
// 	echo "<pre>";
// print_r($_POST);
$expid=mysqli_real_escape_string($con,trim($_POST['expid']));
$allocateto=mysqli_real_escape_string($con,trim($_POST['allocateto']));
$allocated_amt=mysqli_real_escape_string($con,trim($_POST['allocated_amt']));
$available_amt=mysqli_real_escape_string($con,trim($_POST['available_amt']));
$expensed_amt=mysqli_real_escape_string($con,trim($_POST['expensed_amt']));
$exp_dt=mysqli_real_escape_string($con,trim($_POST['exp_dt']));
$description=mysqli_real_escape_string($con,trim($_POST['description']));
$remaining_amt=mysqli_real_escape_string($con,trim($_POST['remaining_amt']));

$img = $_FILES['file']['name'];

	$name=explode('.',$img);
	$ext=pathinfo($img,PATHINFO_EXTENSION);
	$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
	$create_date=date('Y-m-d H:i:s');
	$modify_date=$create_date;
	if($img=="")

	{

	$q1 = mysqli_query($con,"insert into allocate_budget_expense (expense_id,budget_header_id,allocated_amount,

	available_amount,expensed_amount,expense_date,description,amount_remaining,session,create_date,modify_date) 

	values('$expid','$allocateto','$allocated_amt','$available_amt','$expensed_amt','$exp_dt','$description','$remaining_amt','".$_SESSION['session']."','$create_date','$create_date')");

	}else{

	$q1 = mysqli_query($con,"insert into allocate_budget_expense (expense_id,budget_header_id,allocated_amount,

	available_amount,expensed_amount,expense_date,description,attachment,amount_remaining,session,create_date,modify_date) 

	values('$expid','$allocateto','$allocated_amt','$available_amt','$expensed_amt','$exp_dt','$description','$image_name','$remaining_amt','".$_SESSION['session']."','$create_date','$create_date')");

	move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/budgetexp/".$image_name);

	}

	if($q1){
		$q2 = mysqli_query($con,"update allocate_budget set available_amount='$remaining_amt',modify_date='$modify_date' where budget_header_id='$allocateto'");

	        $responce['status']='success';						 
		    $responce['message']='Add Budget expense Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.'.mysqli_error($con);
	}
echo json_encode($responce);	
}



if(isset($_POST['update_budget_expense'])){
// 	echo "<pre>";
// print_r($_POST);
// die;
$id=mysqli_real_escape_string($con,trim($_POST['id']));
$hid=mysqli_real_escape_string($con,trim($_POST['hid']));
$expid=mysqli_real_escape_string($con,trim($_POST['expid']));
$allocateto=mysqli_real_escape_string($con,trim($_POST['allocateto']));
$allocated_amt=mysqli_real_escape_string($con,trim($_POST['allocated_amt']));
$available_amt=mysqli_real_escape_string($con,trim($_POST['available_amt']));
$expensed_amt=mysqli_real_escape_string($con,trim($_POST['expensed_amt']));
$exp_dt=mysqli_real_escape_string($con,trim($_POST['exp_dt']));
$description=mysqli_real_escape_string($con,trim($_POST['description']));
$remaining_amt=mysqli_real_escape_string($con,trim($_POST['remaining_amt']));
	// $old_exp_amt =mysqli_real_escape_string($con,trim($res['expensed_amount']));

$que = mysqli_query($con,"select * from allocate_budget_expense where id='$id'");
$res = mysqli_fetch_array($que);
$old_exp_amt = $res['expensed_amount'];
$old_img = $res['attachment'];

    $img = $_FILES['file']['name'];
if(!empty($img)){
	$name=explode('.',$img);
	$ext=pathinfo($img,PATHINFO_EXTENSION);
	$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;

	$img_sql=" ,attachment='$image_name' ";
}else{
	$img_sql='';
}
	

if($expensed_amt>$old_exp_amt){

		$up=mysqli_query($con,"update allocate_budget_expense set expensed_amount='$expensed_amt',expense_date='$exp_dt',

		description='$description',amount_remaining='$remaining_amt',modify_date=now() $img_sql where id ='$id'  and session='".$_SESSION['session']."'");
		if(!empty($img)){
		   if(move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/budgetexp/".$image_name)){

			    if(!empty($old_img) && file_exists('../gallery/budgetexp/'.$old_img)){
					unlink("../gallery/budgetexp/$old_img");
			    }
		    }

	    }
		// id >'$id'
		// $q2 = mysqli_query($con,"select * from allocate_budget_expense where budget_header_id='$hid' && session='".$_SESSION['session']."'");

		// while($r2=mysqli_fetch_array($q2))

		// {

		// 	$nid = $r2['id'];

		// 	$amt = $expensed_amt - $old_exp_amt;

		// 	$oldrem_amt = $r2['amount_remaining'];

		// 	$newrem_amt = $oldrem_amt - $amt;

		// 	$up=mysqli_query($con,"update allocate_budget_expense set amount_remaining='$newrem_amt',modify_date=now() where id='$nid'  and session='".$_SESSION['session']."'");

		// }
// newrem_amt
		$up=mysqli_query($con,"update allocate_budget set available_amount='$remaining_amt',modify_date=now() where budget_header_id ='$hid'  and session='".$_SESSION['session']."'");

}elseif($expensed_amt<$old_exp_amt){

		$up=mysqli_query($con,"update allocate_budget_expense set expensed_amount='$expensed_amt',expense_date='$exp_dt',

		description='$description',amount_remaining='$remaining_amt',modify_date=now()  $img_sql where id ='$id'  and session='".$_SESSION['session']."'");
		if(!empty($img)){
		    if(move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/budgetexp/".$image_name)){
		    if(!empty($old_img) && file_exists('../gallery/budgetexp/'.$old_img)){
				unlink("../gallery/budgetexp/$old_img");
		    }
		    }
	    }
		// && id >'$id'
		// $q2 = mysqli_query($con,"select * from allocate_budget_expense where budget_header_id='$hid'  && session='".$_SESSION['session']."'");
		// while($r2=mysqli_fetch_array($q2)){
		// 	$nid = $r2['id'];

		// 	$amt = $old_exp_amt - $expensed_amt;

		// 	$oldrem_amt = $r2['amount_remaining'];

		// 	$newrem_amt = $oldrem_amt + $amt;

			

		// 	$up=mysqli_query($con,"update allocate_budget_expense set amount_remaining='$newrem_amt',modify_date=now() where id='$nid'");

		// }

		// newrem_amt

		$up=mysqli_query($con,"update allocate_budget set available_amount='$remaining_amt',modify_date=now() where budget_header_id ='$hid' and session='".$_SESSION['session']."'");

	}elseif($expensed_amt==$old_exp_amt){
		$up=mysqli_query($con,"update allocate_budget_expense set expensed_amount='$expensed_amt',expense_date='$exp_dt',

		description='$description',amount_remaining='$remaining_amt',modify_date=now()  $img_sql where id ='$id'  and session='".$_SESSION['session']."'");
		if(!empty($img)){
		    if(move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/budgetexp/".$image_name)){
		    if(!empty($old_img) && file_exists('../gallery/budgetexp/'.$old_img)){
				unlink("../gallery/budgetexp/$old_img");
		    }
		    }
		}
	}

	if($up){
	        $responce['status']='success';						 
		    $responce['message']='Update Budget expense Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.';
	}
echo json_encode($responce);
}

if(isset($_POST['allocate_budget'])){
// 	echo "<pre>";
// print_r($_POST);
$header=mysqli_real_escape_string($con,trim($_POST['header']));
$allocate_amt=mysqli_real_escape_string($con,trim($_POST['allocate_amt']));

	$q1 = mysqli_query($con,"select * from allocate_budget where budget_header_id='$header' and session='".$_SESSION['session']."' ");

	$row = mysqli_num_rows($q1);

	if($row)

	{	$responce['status']='error';						 
			        $responce['message']='Amount already allocated to this header.';

	}else{

	$q2 = mysqli_query($con,"insert into allocate_budget (budget_header_id,allocate_amount,available_amount,session,create_date,modify_date) values('$header','$allocate_amt','$allocate_amt','".$_SESSION['session']."',now(),now())");
	if($q2){
	     $responce['status']='success';						 
		    $responce['message']='Allocate Budget Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.'.mysqli_error($con);
	}

	}
echo json_encode($responce);
}


if(isset($_POST['update_allocate_budget'])){
// 	echo "<pre>";
// print_r($_POST);
$amount=mysqli_real_escape_string($con,trim($_POST['amount']));
$id=mysqli_real_escape_string($con,trim($_POST['id']));
// ,available_amount='$amount' 

	$up=mysqli_query($con,"update allocate_budget set allocate_amount='$amount', modify_date=now() where allocate_budget_id ='$id'");
	if($up){
	     $responce['status']='success';						 
		    $responce['message']='Updated Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.';
	}

	
echo json_encode($responce);
	


}


if(isset($_POST['add_purge_data'])){
// 	echo "<pre>";
// print_r($_POST);
$purgedate=mysqli_real_escape_string($con,trim($_POST['purgedate']));
$description=mysqli_real_escape_string($con,trim($_POST['description']));

	$q1 = mysqli_query($con,"insert into purge_data (purge_date,description,session,create_date,modify_date) 

	values('$purgedate','$description','".$_SESSION['session']."',now(),now())");

	if($q1){
	     $responce['status']='success';						 
		    $responce['message']='Added Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.';
	}

		
echo json_encode($responce);
}

if(isset($_POST['update_purgedata'])){
// 	echo "<pre>";
// print_r($_POST);
$pid=mysqli_real_escape_string($con,trim($_POST['pid']));
$npurgedate=mysqli_real_escape_string($con,trim($_POST['npurgedate']));
$ndescription=mysqli_real_escape_string($con,trim($_POST['ndescription']));

		$query = mysqli_query($con,"update purge_data set purge_date='$npurgedate', description='$ndescription',modify_date=now() where purge_id ='$pid'");	

		if($query){
	     $responce['status']='success';						 
		    $responce['message']='Updated Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.';
	}	
echo json_encode($responce);
	}

// if(isset($_POST['upload_image'])){
// // 	echo "<pre>";
// // print_r($_POST);
// // print_r($_FILES);
// // die;
// $class=mysqli_real_escape_string($con,trim($_POST['class']));
// $section=mysqli_real_escape_string($con,trim($_POST['section']));
// $flag=false;



// 	$qcls = mysqli_query($con,"select * from class where class_id='$class'");

// 	$rcls = mysqli_fetch_array($qcls);

// 	$clsid = $rcls['class_id'];

// 	$clsname = $rcls['class_name'];



// 	$qsec = mysqli_query($con,"select * from section where section_id='$section'");

// 	$rsec = mysqli_fetch_array($qsec);

// 	$secid = $rsec['section_id'];

// 	$secname = $rsec['section_name'];



// 	if(!file_exists("gallery/idcard/".$clsname))

// 	{

// 		mkdir("gallery/idcard/$clsname");

// 		mkdir("gallery/idcard/$clsname/$secname");

// 	}



	

// 	$error=array();

// 	$extension=array("jpeg","jpg","png","gif");

// 	foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) 

// 	{

// 		$file_name=$_FILES["files"]["name"][$key];

		

// 		if(file_exists("../gallery/idcard/".$clsname."/".$secname."/".$file_name))

// 		{	

// 			$regno = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

// 			$q1 = mysqli_query($con,"select * from idcard where regno='$regno'");

// 			$r1 = mysqli_fetch_array($q1);

// 			$id = $r1['id'];

// 			$oldpic = $r1['pic'];

			

// 			unlink("../gallery/idcard/$clsname/$secname/$oldpic");

			

// 			if(move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"../gallery/idcard/".$clsname."/".$secname."/".$file_name)){
// 				$flag=true;
// 			}else{
// 					$flag=flase;
// 			}

			

// 		}

// 		else

// 		{

// 			$file_tmp=$_FILES["files"]["tmp_name"][$key];

// 			$ext=pathinfo($file_name,PATHINFO_EXTENSION);



// 			if(in_array($ext,$extension))

// 			{

// 				$regno = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);

				

// 				$q1 = "insert into idcard (class_id,section_id,regno,pic) values ('$clsid','$secid','$regno','$file_name')";

// 				if(mysqli_query($con,$q1))

// 				{

// 				if(move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"../gallery/idcard/".$clsname."/".$secname."/".$file_name)){

// 						$flag=true;
// 				}else{
// 						$flag=flase;
// 				}

// 				}

// 			}

// 			else

// 			{

// 				array_push($error,"$file_name, ");

// 			}

// 		}

// 	}
// 	if($flag){
// 	   $responce['status']='success';						 
// 	   $responce['message']='Upload Image Successfully';	

// 	}else{
// 	   $responce['status']='error';						 
// 	   $responce['message']='Something went wrong, Please try again.';
// 	}	
// echo json_encode($responce);
// 	// echo "<script>window.location='dashboard.php?option=upload_image'</script>";

// }
