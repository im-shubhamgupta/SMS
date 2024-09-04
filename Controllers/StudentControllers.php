<?php include('../myfunction.php');?>
<?php
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['Request_for_Promote'])){
// 	echo "<pre>";
// 	print_r($_POST);
// 	echo "</pre>";
// die;
	$chk=$_POST['chk']; //array 

	// $already=0;
	// $promote=0;
	// $error=0;

	if(!empty($_POST['class_id'])){
		$class_id=mysqli_real_escape_string($con,$_POST['class_id']);
	}else{
		$responce['type']='empty';						 
  		$responce['msg']='Please Select Class';
	}
	if(!empty($_POST['promote_class'])){
		$promote_class=mysqli_real_escape_string($con,$_POST['promote_class']);
	}else{
		$responce['type']='empty';						 
  		$responce['msg']='Please Select Promote Class';
	}
	if(!empty($_POST['promote_session'])){
		$promote_session=mysqli_real_escape_string($con,$_POST['promote_session']);
	}else{
		$responce['type']='empty';						 
  		$responce['msg']='Please Select Promote Session';	
	}
if($responce['type']=='empty'){
	echo json_encode($responce);die;
}

	
	$section_id=mysqli_real_escape_string($con,$_POST['section_id']);
	
	$promote_section=mysqli_real_escape_string($con,$_POST['promote_section']);
	

	// $nmsg=mysqli_real_escape_string($con,$_POST['message']);
	// $msg=$_POST['message'];
	$date=date('Y-m-d');

	

foreach($chk as $stuid){
	// $admissiondate=getStudent_byStudent_id($stuid)['admission_date'];
	$admissiondate=date('Y-m-d');
	// calculation for student_wise_fees-------------------------------------------------------
	$Admission_date= explode('-',$admissiondate);
              		   
   	$Admission_month=$Admission_date[1];		
    $Admission_Year=$Admission_date[0];		
    $Current_Year=date('Y');
    $startFeeMonth=4;	
    $months=12;  
               	
    $Admission_month=ltrim($Admission_month, "0");		
    // if($Admission_month>$startFeeMonth && $Admission_Year==$Current_Year){			
    //     $No_of_Month_FeeNo_Charge=$Admission_month-$startFeeMonth;	
	//     $St_wise_months=$months-$No_of_Month_FeeNo_Charge;	
    //     $ReIndexAddmission_Month=$Admission_month-4;	
    //     $fee_start_month=$Admission_month;	
	// }else{
	//     $current_fee_charge_Month=12; 	
	//     $St_wise_months=12;		
	// 	$fee_start_month=4;	
	// }	
	if(true){  //fixed to pay 12th months
		$current_fee_charge_Month=12; 	
	    $St_wise_months=12;		
		$fee_start_month=4;	
	}			
			
	$qfee = mysqli_query($con,"select * from assign_fee_class where class_id='$promote_class' and session='$promote_session' ");
    if($qfee->num_rows > 0){
        $rfee = mysqli_fetch_array($qfee);
        //change into array
        $feeids = $rfee['fee_header_id'];
        $feeamts = $rfee['fee_header_amount'];
    }else{
		$feeids ='';
        $feeamts = '';
    }   
         
    $feehead = explode(',',$feeids);	
    $feeamt = explode(',',$feeamts);	

	$Student_Wise_Total_Amount=0;			
    $DueStu_Amount=0;	
    if(!empty($feehead)){
     	// $NO_Of_Fee_Head= count($feehead);	
     	$NO_Of_Fee_Head= count($feehead);	
    }else{
     	$NO_Of_Fee_Head=0;
    }	
			 	 			
	for($i=0;$i<$NO_Of_Fee_Head;$i++){	
	  	$feeid = $feehead[$i]; 						
	  	$FHquery = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");			
		$FHRow = mysqli_fetch_array($FHquery);		
	  	$fheadtype = $FHRow['type'];	
	  		if($fheadtype=='1'){	
				$FeeHeadAmount=$feeamt[$i];	
				$Current_FeeHeadAmount=$feeamt[$i];		
				$FeeHeadAmount=$FeeHeadAmount*$St_wise_months;
				$Student_Wise_Total_Amount=$Student_Wise_Total_Amount+$FeeHeadAmount;	
	        }else{			
			 	$FeeHeadAmount=$feeamt[$i];
			    $Student_Wise_Total_Amount=$Student_Wise_Total_Amount+intval($FeeHeadAmount);	
			}				 	
	}
	 $DueStu_Amount=$Student_Wise_Total_Amount;		
             


	// end calculation for student_wise_fees--------------------------------------------------------------

	 
	$sql="SELECT * FROM `student_records` where `stu_id`='$stuid' and  `class_id`='$promote_class' `section_id`='$promote_section'   and `session` ='$promote_session' ";

	$create_date=date('Y-m-d H:i:s');
	$modify_date=date('Y-m-d H:i:s');

	$query=mysqli_query($con,$sql);
	if(!mysqli_num_rows($query) > 0){  //if already promote then ignore
		

	   $Isql="INSERT INTO `student_records`(`stu_id`, `class_id`, `section_id`,`roll_no`, `session`, `promote_status`, `create_at`, `modify_at`) VALUES ('".$stuid."','".$promote_class."','".$promote_section."','0','".$promote_session."','0','".$create_date."','".$modify_date."' )";

		$Iquery=mysqli_query($con,$Isql);	
		if($Iquery){
			
			 $Usql="UPDATE `student_records` SET `promote_status`='1', `modify_at`='$modify_date' WHERE  `stu_id`='$stuid' and session='".$_SESSION['session']."' ";
			
			$Uquery=mysqli_query($con,$Usql);

			//insert if assign fee class is ready
			$chk_assign_fee = mysqli_query($con,"select * from assign_fee_class where class_id='$promote_class' and session='".$promote_session."'");
					
			$StuFee= mysqli_query($con,"SELECT student_id FROM student_wise_fees WHERE student_id='".$stuid."' AND session='".$promote_session."'");
						    
		    if((mysqli_num_rows($chk_assign_fee) > 0)  && (mysqli_num_rows($StuFee)<1)){

			    $swsql="insert into student_wise_fees(student_id,class_id,section_id,fee_header_id,fee_amount,due_amount,no_of_months,fee_start_month,session,create_date,modify_date) values ('".$stuid."', '".$promote_class."', '".$promote_section."', '".$feeids."', '".$feeamts."', '".$DueStu_Amount."','$St_wise_months',$fee_start_month,'".$promote_session."', '".$create_date."', '".$modify_date."')";
				
				$query2 = mysqli_query($con,$swsql);
				// if( mysqli_error($con)){
                //     echo("Error description: " . mysqli_error($con));
                // }
                if($query2){
                	 mysqli_query($con,"UPDATE `students` SET `due`='$DueStu_Amount',`modify_date`=now()  WHERE `student_id`='$stuid'  "); //and `session`='$promote_session'
				    $responce['type']='success';						 
	                $responce['msg']='Sucessfully Promoted';	
			    }else{
				    $responce['type']='error';						 
	                $responce['msg']='Something went wrong'. mysqli_error($con);
			}

							
			}else{

				// if($Uquery){
				    $responce['type']='success';						 
	                $responce['msg']='Sucessfully Promoted';	
			    // }else{
				//     $responce['type']='error';						 
	            //     $responce['msg']='Something goes wrong, Please try again';
	            // }
			}
	               

		}else{
			
			$responce['type']='error';						 
	        $responce['msg']='Something went wrong, Please try again'. mysqli_error($con);	
		}
    }//num rows
    else{
    	$responce['type']='success';						 
	    $responce['msg']='Sucessfully Promoted';
	    $Usql="UPDATE `student_records` SET `promote_status`='1', `modify_at`='$modify_date' WHERE  `stu_id`='$stuid' and session='".$_SESSION['session']."' ";
		$Uquery=mysqli_query($con,$Usql);
    }
		    
}//for each
echo json_encode($responce);

}
if(isset($_POST['LeaveRequest'])){
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	// echo "</pre>";
	$student=mysqli_real_escape_string($con,$_POST['student']);
	$classid=mysqli_real_escape_string($con,$_POST['classid']);
	$sectionid=mysqli_real_escape_string($con,$_POST['sectionid']);
	$subdate=mysqli_real_escape_string($con,$_POST['subdate']);
	$fromdate=mysqli_real_escape_string($con,$_POST['fromdate']);
	$todate=mysqli_real_escape_string($con,$_POST['todate']);

	$leaveid=mysqli_real_escape_string($con,$_POST['leaveid']);
	$nodays=mysqli_real_escape_string($con,$_POST['nodays']);
	$reason=mysqli_real_escape_string($con,$_POST['reason']);
	$note=mysqli_real_escape_string($con,$_POST['note']);


	// echo $nodays=$todate-$fromdate;

	$img = $_FILES['file']['name'];

	if($img==""){

		$q1 = $con->query("insert into student_leave (student_id,class_id,section_id,submission_date,from_date,to_date,leave_id,total_days,reason,note,status,session,create_date,modify_date) values('$student','$classid','$sectionid','$subdate','$fromdate','$todate','$leaveid','$nodays','$reason','$note',0,'".$_SESSION['session']."',now(),now())");
		// if(mysqli_error($con)){
		// 	echo ("Error description : ". mysqli_error($con));

		// }
		if($q1){
			$responce['type']='success';						 
  		    $responce['msg']='Request Successfully';	
		}else{
			$responce['type']='error';						 
  		    $responce['msg']='Something went wrong, Please try again';
		}

	}else{	

		mkdir("../images/leave/$student");

		
		$name=explode('.',$img);
		$ext=pathinfo($img,PATHINFO_EXTENSION);
		// $num=substr($name[0],0,4);                   //take four letter only 
		$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;

		if(move_uploaded_file($_FILES['file']['tmp_name'],"../images/leave/$student/".$image_name)){


			$q1 = mysqli_query($con,"insert into student_leave (student_id,class_id,section_id,submission_date,from_date,to_date,leave_id,total_days,reason,note,attachment,status,session,create_date,modify_date)values('$student','$classid','$sectionid','$subdate','$fromdate','$todate','$leaveid','$nodays','$reason','$note',
			'$image_name',0,'".$_SESSION['session']."',now(),now())");

			if($q1){
				$responce['type']='success';						 
	  		    $responce['msg']='Request Successfully';	
			}else{
				$responce['type']='error';						 
	  		    $responce['msg']='Something went wrong, Please try again';
			}

	    }else{
	    	$responce['type']='error';						 
	  		$responce['msg']='Attachment not Uploaded, Please try again';

	    }

    }
echo json_encode($responce);
}

if(isset($_POST['approve_student_leave'])){
$stu_leave_id=mysqli_real_escape_string($con,$_POST['stu_leave_id']);


 $sql="update `student_leave` set  status='1', modify_date=now() where stu_leave_id ='$stu_leave_id' and `session`='".$_SESSION['session']."'";

	$q1 = mysqli_query($con,$sql);	
	if($q1){
  		$responce['type']='success';						 
  		$responce['msg']='Approved Successfully';						 

	}else{
			$responce['type']='error';		

	}
	echo json_encode($responce);


}
if(isset($_POST['reject_student_leave'])){
	$stu_leave_id=mysqli_real_escape_string($con,$_POST['stu_leave_id']);


  $sql="update `student_leave` set  status='2', modify_date=now() where stu_leave_id ='$stu_leave_id'  and `session`='".$_SESSION['session']."'";

	$q1 = mysqli_query($con,$sql);	
	if($q1){
  		$responce['type']='success';						 
  		$responce['msg']='Decline Successfully';						 

	}else{
			$responce['type']='error';		

	}
	echo json_encode($responce);


}

if(isset($_POST['LoadTimeTableFormat'])){
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
$class=$_POST['class'];
$sectionid=$_POST['sectionid'];

if(!empty($_POST['tperiod'])){
	$tperiod=$_POST['tperiod'];
}else{
	$tperiod=0;
}

if(!empty($_POST['tbreak'])){
	$tbreak=$_POST['tbreak'];
}else{
	$tbreak=0;
}

$cday=$_POST['cday'];

// if(empty($tperiod)){
// 	echo 'empty_tperiod';	die;
// }


$sql="select * from time_table where class_id='$class' && section_id='$sectionid' && day='$cday'";
$que = mysqli_query($con,$sql);

		$row = mysqli_num_rows($que);

		if(!$row)

		{

		$trow = $tperiod + $tbreak;


?>
<table class="table table-striped table-bordered table-responsive">

                                    <thead>
                                        <tr>
                                             <th>Period</th>

											 <th>Start Period</th>

											 <th>End Period</th>

											 <th>Subject</th>

											 <th>Teacher</th>
										</tr>
                                    </thead>

                                    <tbody>

										<?php

										for($i=1; $i<=$trow; $i++)

										{

										?>

											<tr>

											<td><?php echo $i;?></td>

											<input type="hidden" name="period[]" value="<?php echo $i;?>"/>

											<td><input type="time" name="stperiod[]" class="form-control" style="width:200px"/></td>

											<td><input type="time" name="endperiod[]" class="form-control" style="width:200px"/></td>

											

											<td>

											<select name="subject[]" class="form-control" 

											onchange="test456(this.value,this.id)" style="width:200px;">

											<option value="" selected="selected" Disabled>Select Subject</option>

											<option value="Lunch" >Lunch</option>

											<option value="Break" >Break</option>

											<?php

											$qu=mysqli_query($con,"select * from subject where class_id='$class'");

											while($re=mysqli_fetch_array($qu))

											{										

											?>

											<option <?php if($subject==$re['subject_id']){echo "selected";}?> value="<?php echo $re['subject_id']; ?>"><?php echo $re['subject_name'];?></option>

											<?php

											}

											?>

											</select>

											</td>

											

											<td>

											<select name="teacher[]" class="form-control" 

											onchange="test456(this.value,this.id)" style="width:205px;">

											<option value="" selected="selected" Disabled>Select Teacher</option>

											<option value="Lunch" >Lunch</option>

											<option value="Break" >Break</option>

											<?php

											$qu=mysqli_query($con,"select * from staff");

											while($re=mysqli_fetch_array($qu))

											{

											?>

											<option <?php if($teacher==$re['st_id']){echo "selected";}?> value="<?php echo $re['st_id']; ?>"><?php echo $re['staff_name'];?></option>

											<?php

											}

											?>

											</select>

											</td>

											</tr>

										<?php

										}

										?>

                                    </tbody>

                                </table>

<?php

}else{
	    // $responce['status']='error';						 
  		// $responce['msg']='Already created';
  		echo 'already';	

}

}

if(isset($_POST['CreateTimeTable'])){
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// // die;

	$classid = $_POST['class']; 

	$sectionid = $_POST['sectionid']; 

	$tperiod = $_POST['tperiod']; 
	if(!empty($_POST['tbreak'])){
			$tbreak = $_POST['tbreak']; 
	}else{
		$tbreak ='0';
	}


	$cday = $_POST['cday']; 

	$period = $_POST['period'];

	$stperiod = $_POST['stperiod'];

	$endperiod = $_POST['endperiod'];

	$subject = $_POST['subject'];

	$teacher = $_POST['teacher'];

	

	$count = sizeof($period);
	$qcls = mysqli_query($con,"select * from class where class_id='$classid'");

	$rcls = mysqli_fetch_array($qcls);

	$clsname = $rcls['class_name'];

	

	for($i=0; $i<$count; $i++)

	{

		$nperiod = $period[$i];

		$nstperiod = $stperiod[$i];

		$nendperiod = $endperiod[$i];

		$nsubject = $subject[$i];

		$nteacher = $teacher[$i];

		
		 $sql="insert into time_table (class_id,section_id,tperiod,tbreak,day,period,start_period,end_period,subject_id,staff_id,session,create_date,modify_date) values('$classid','$sectionid','$tperiod','$tbreak','$cday','$nperiod','$nstperiod','$nendperiod','$nsubject','$nteacher','".$_SESSION['session']."',now(),now())";
		$q1=mysqli_query($con,$sql);

	}
	
		if($q1){
  		    $responce['status']='success';						 
  		    $responce['msg']='Time table created Successfully';						 

	    }else{
			$responce['status']='error';
			$responce['msg']='Something went wrong plesae try again';		

	    }	
	  echo json_encode($responce);  	
		// if(mysqli_error($con)){

		// 	echo ("Error description :" . mysqli_error($con));

		// }

	}

if(isset($_POST['UpdateTimeTable'])){

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
	$id = $_POST['id'];

	$endperiod = $_POST['endperiod'];

	$subject = $_POST['subject'];

	$teacher = $_POST['teacher'];

	

	$count = sizeof($id);

	

	for($i=0; $i<$count; $i++)

	{

		$nid = $id[$i];

		$nstperiod = $stperiod[$i];

		$nendperiod = $endperiod[$i];

		$nsubject = $subject[$i];

		$nteacher = $teacher[$i];

		

		$q1=mysqli_query($con,"update time_table set start_period='$nstperiod', end_period='$nendperiod', 

		subject_id='$nsubject', staff_id='$nteacher' where tt_id='$nid' and session='".$_SESSION['session']."'");



	

	}
if($q1){
  		    $responce['status']='success';						 
  		    $responce['msg']='Time table updated Successfully';						 

	    }else{
			$responce['status']='error';
			$responce['msg']='Something went wrong plesae try again';		

	    }	
	  echo json_encode($responce);  

}

if(isset($_POST['CreteEvent'])){
// echo "<pre>";
// print_r($_POST);
	
	$creationdate = $_POST['creationdate'];
	$nodays = $_POST['nodays'];
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$eventfor = $_POST['eventfor'];
	// if($eventfor=='2'){
	// 	$classid='';
	// 	$sectionid='';
	// }else{
		$classid = $_POST['classid'];
	    $sectionid = $_POST['sectionid'];

	// }
	if(empty($sectionid)){
		$sectionid ="All";
	}    
	$eventhead = mysqli_real_escape_string($con,$_POST['eventhead']);
	$description = mysqli_real_escape_string($con,$_POST['description']);

	$q1 = $con->query("insert into events (class_id,section_id,creation_date,from_date,to_date,event_for,no_of_days,event_heading,description,status,session,create_date,modify_date) values('$classid','$sectionid','$creationdate','$fromdate','$todate','$eventfor','$nodays','$eventhead','$description',0,'".$_SESSION['session']."',now(),now())");

	// if(mysqli_error($con)){

	// 	echo ("Error description :" .mysqli_error($con)); 		

	// }
    if($q1){
  		    $responce['status']='success';						 
  		    $responce['msg']='Create Event Successfully';						 

	    }else{
			$responce['status']='error';
			$responce['msg']='Something went wrong plesae try again';		

	    }	
	  echo json_encode($responce);  
   
}
if(isset($_POST['UpdateEvent'])){
// echo "<pre>";
// print_r($_POST);
    $ncreationdate = $_POST['ncreationdate'];
	$nnodays = $_POST['nnodays'];
	$nfromdate = $_POST['nfromdate'];
	$ntodate = $_POST['ntodate'];
	$neventfor = $_POST['neventfor'];
	
	$nclassid = $_POST['nclassid'];
    $nsectionid = $_POST['nsectionid'];
	$neventhead = mysqli_real_escape_string($con,$_POST['neventhead']);
	$ndescription = mysqli_real_escape_string($con,$_POST['ndescription']);

	if(empty($nsectionid)){
		$nsectionid ="All";
	}    

	$id = $_POST['id'];

	$usql="update events set class_id='$nclassid', section_id='$nsectionid', 	creation_date='$ncreationdate', from_date='$nfromdate', to_date='$ntodate', event_for='$neventfor',	no_of_days='$nnodays', event_heading='$neventhead', description='$ndescription',modify_date=now() where event_id='$id' and session='".$_SESSION['session']."'";

	$query = mysqli_query($con,$usql);

	if($query){
  		    $responce['status']='success';						 
  		    $responce['msg']='Event Updated Successfully';						 

	    }else{
			$responce['status']='error';
			$responce['msg']='Something went wrong plesae try again';		

	    }	
	  echo json_encode($responce);
	

	


}











