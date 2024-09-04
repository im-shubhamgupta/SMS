<?php   
	session_start();
	include_once('connection.php');
	include('myfunction.php');
	date_default_timezone_set('Asia/Kolkata');
	
   if(isset($_POST['CreateTest'])){
   	// echo "<pre>";
   	// print_r($_POST);
   	// die;
    $x=1;
	if(isset($_POST['term']) && !empty($_POST['term'])){
	
	$term=$_POST['term'];
	$testname=$_POST['testname_term'];
	$class=$_POST['class_term'];
	$section=$_POST['section_term'];
		
	}else{
		
	$term=0;
    $testname=$_POST['testname'];
	$class=$_POST['class'];
	$section=$_POST['section'];
	
	}
	
	$subject = $_REQUEST['subject'];

	$minmark = $_REQUEST['minmark'];

	$maxmark = $_REQUEST['maxmark'];
	
	$no_of_question = $_REQUEST['no_of_question'];

	$testdate = $_REQUEST['testdate'];

	$starttime = $_REQUEST['starttime'];

	$endtime = $_REQUEST['endtime'];

	$roomno = $_REQUEST['roomno'];
	$check = $_REQUEST['check'];
	$username=$_SESSION['user_roles'];
	

	$totalsub = sizeof($subject);
 
	$subname=array();
	
	$subname=array();
    $all_date_arr=array();
	for($i=0;$i<$totalsub;$i++)

	{

	$newsub = $subject[$i];	

	$newminmark = $minmark[$i];

	$newmaxmark = $maxmark[$i];
	
	$new_no_of_question=$no_of_question[$i];

	$newtestdate = $testdate[$i];

	$newstarttime = $starttime[$i];

	$newendtime = $endtime[$i];

	$newroomno = $roomno[$i];

	$ntestdate = $testdate[0];
	$all_date_arr[] = $testdate[$i];
	// $ntestdate = $testdate[$i];

	$nwdate = date("d-m-Y",strtotime($ntestdate));

		if(!empty($newsub)){

			$q1 = mysqli_query($con,"select * from test where test_name='$testname' && class_id='$class' && section_id='$section' && subject_id='$newsub' && session='".$_SESSION['session']."'");

			$r1 = mysqli_num_rows($q1);

			if(!$r1)

			{

			   $sqli="insert into test(parent_test_id,test_name,test_date,starttime,endtime,class_id,section_id,subject_id,no_of_question,min_marks,max_marks,room_no,session,create_date,modify_date)

				values ('$term','$testname','$newtestdate','$newstarttime','$newendtime','$class','$section','$newsub','$new_no_of_question','$newminmark',

				'$newmaxmark','$newroomno','".$_SESSION['session']."',now(),now())";  
			   
				$querysave = mysqli_query($con,$sqli);


				if(mysqli_error($con)){

					//echo "Error description :" .mysqli_error($con);
					$SMSG="Ops Somethings is Wrong";
					
					$Responce=array('status'=>'fail','msg'=>$SMSG);
					echo json_encode($Responce);

				}

			}else{

				$SMSG="Test Already Created";
				$Responce=array('status'=>'already','msg'=>$SMSG);
			    echo json_encode($Responce); die;

			}

		}

	
			// $subname[]=array();
			// $allsub='';
			$qsub = mysqli_query($con,"select * from subject where subject_id='$newsub'");

			$rsub = mysqli_fetch_array($qsub);

			$subname[] =  $rsub['subject_name'];
			$allsub = implode(" , ",$subname);
			 // $allsub = $rsub['subject_name'];

	}//close for loop
	

			$allsub = implode(",",$subname);

			//print_r($allsub);

			if($querysave){

			
           $SMSG="Test Created Successfuly";
			     $Responce=array('status'=>'success','msg'=>$SMSG);
			     echo json_encode($Responce);
					
				// commented part--------------------
				$query2 = mysqli_query($con,"select `student_id`,`parent_no`,`msg_type_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' ");
				// $x=1;
				if(!empty($check))
					{	
				while($res2 = mysqli_fetch_array($query2))

				{	
							// echo "<br>loop";


					$sset=mysqli_query($con,"select * from setting");  //school details

					$rsset=mysqli_fetch_array($sset);

					$sclname=$rsset['company_name'];

					$stuid=$res2['student_id'];

					$mobile=$res2['parent_no'];

					$msgtype=$res2['msg_type_id'];

					$messagetype = "create_test";

					$min_date2= min($all_date_arr);         //take only minimum date
				  $min_date = date("d-m-Y",strtotime($min_date2));

				
					// $nwdate
					$message="Dear Parent,%0a".$testname.", will be start from ".$min_date."  for ".$allsub."."."%0aPlease make your ward to prepare well.%0aAll the Best,%0aFrom%0a".$sclname.",";

					$nmessage="Dear Parent,<br>".$testname.", will be star from ".$min_date."  for ".$allsub."."."<br>Please make your ward to prepare well.<br>All the Best,<br>From<br>".$sclname.",";

				
						// echo "message sent";
						if($msgtype==1)  //whatsapp sms  

						{
							// echo "<br>insert msg";
							$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)

							values(3,'$stuid','$class','$section','$mobile','$nmessage',1,'$username',now(),now(),'".$_SESSION['session']."')");

							$msg = $message;

							sendwhatsappMessage($mobile, $msg, $messagetype);
						

						}elseif($msgtype==2){
							$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)
							values(3,'$stuid','$class','$section','$mobile','$nmessage',2,'$username',now(),now(),'".$_SESSION['session']."')");
							$msg =$nmessage; 
							sendtextMessage($mobile, $msg, $messagetype);

						}
							
					// }
					// else{					

					// 	if($msgtype==1){

					// 		$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date)

					// 		values(3,'$stuid','$class','$section','$mobile','$nmessage',1,'$username',now(),now())");

					// 	 $msg = $message;

						
					// 		sendwhatsappMessage($mobile, $msg, $messagetype);
						
						
					// 	}else if($msgtype==2){
							
					// 		$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date)

					// 		values(3,'$stuid','$class','$section','$mobile','$nmessage',2,'$username',now(),now())");

					// 		$msg =$message; 

					// 		sendtextMessage($mobile, $msg, $messagetype);
					// 	}

					// }

				}   //close while loop

			}

				

			}else{
				
			$SMSG="Oops Somethings is Wrong";
					
			$Responce=array('status'=>'fail','msg'=>$SMSG);
			echo json_encode($Responce);	
				
			}


   }
   
   
   if(isset($_POST['AssignTerm'])){
   	// echo "<pre>";
   	// print_r($_POST);
   	// die;
	   
      $class_id= $_POST['class'];
      $section= $_POST['section'];
      $term= $_POST['term'];
	  $test_name= $_POST['test'];
	  if(empty($test_name)){
	  	  $Responce['status']="not";
		    $Responce['message']="Please Select Test name"; 

         echo json_encode($Responce); die;

	  }
	  //$test_name=implode(',',$test_name);
	  
      if(!empty($term) && isset($term)){
	
		foreach($test_name as $test){
		$UpQuery= $con->query("UPDATE test SET `parent_test_id`='".$term."' , modify_date=now() WHERE test_name='".$test."' AND class_id='".$class_id."' AND section_id='".$section."' AND session='".$_SESSION['session']."'");
		}
		if($UpQuery){
		
         $Responce['status']="success";
		 $Responce['message']="Test Assing Successfuly";
		 
		 echo json_encode($Responce);
			
		}else{
			
		 $Responce['status']="error";
		 $Responce['message']="Somethings Went Wrong";	
		 echo json_encode($Responce);
		}
		 
		
	  }else{
		  
		 $Responce['status']="not";
		 $Responce['message']="Please Select Term"; 

         echo json_encode($Responce);		 
		  
	  }


     		  
	   
   }
   
   if(isset($_POST['LoadSubject'])){
	  
	   
     $testname=$_POST['testname'];
	 $class=$_POST['class'];
	 $section=$_POST['section'];
	$q = mysqli_query($con,"select * from test where test_name='$testname' && class_id='".$_POST['class']."' && section_id='".$_POST['section']."' && session='".$_SESSION['session']."'");


	$r = mysqli_num_rows($q);

	if($r)

	{

		echo "<script>alert('The Exam name already present. Please enter new exam name.')</script>";

	}

	else

	{

	$query="select * from subject where class_id='$class'";
	
	$filter_Result = mysqli_query($con, $query);

	} 
	  $i=1;

		while($res=mysqli_fetch_array($filter_Result)){	

			$subid = $res['subject_id'];

		    $subname = $res['subject_name'];
           ?>

									<tr>

									<!-- <td><?php echo $i; ?></td> -->
									<td><input type="checkbox" name="subject[]" id="<?php echo $subid;?>" checked="checked" value="<?php echo $subid;?>" onchange="savesub(this.id)"

									style="height:20px;width:20px;margin-left:18px;margin-top:10px;"></td>  

									<td style="font-size:14px;"><?php echo $subname; ?></td>

									<td><input type="number" name="minmark[]" id="minmark<?php echo $subid;?>" style="width:100px" class="form-control nonegative min" onchange="checkmarks(this.id)" required></td>

									

									<td><input type="number" name="maxmark[]" id="maxmark<?php echo $subid;?>" style="width:100px" class="form-control nonegative max" onchange="checkmarks(this.id)" required></td>

						            <td><input type="number" name="no_of_question[]" id="no_of_question<?php echo $subid;?>" style="width:100px" class="form-control nonegative max"  required></td>


									<td><input type="date" name="testdate[]" id="testdate<?php echo $subid;?>" style="width:180px" class="form-control dateval" min="<?=date('Y-m-d')?>" autocomplete="off" required></td>

									

									<td><input type="time" name="starttime[]" id="starttime<?php echo $subid;?>" style="width:140px" class="form-control" onchange="checktime(this.id)" required></td>

									

									<td><input type="time" name="endtime[]" id="endtime<?php echo $subid;?>" style="width:140px" class="form-control timeval" onchange="checktime(this.id)" required></td>

									

									<td><input type="text" name="roomno[]" id="roomno<?php echo $subid;?>" style="width:130px" class="form-control" required></td>

									

									

								

									</tr>

									<?php

									$i++;

									}

	
   }
  


 if(isset($_POST['CollectFee'])){

  $Responce=array();
  if(!isset($_POST['month'])){
    $Responce=array('m_error'=>'merror','msg'=>'Please Select Month');	
	echo json_encode($Responce); exit;
	   
   }else{
	 $month=$_POST['month'];  
   }
   
 
  if(!isset($_POST['paidby']) || empty($_POST['paidby'])){
	  $Responce=array('status'=>'perror','msg'=>'Please Select Paid By');	
	  echo json_encode($Responce); exit; 
	   
   }
  if($_POST['totalpaid'] > 0){	
   
   $totalpaid=$_POST['totalpaid'];  

   $paidby=$_POST['paidby'];

   
   $str = implode(',',$_POST['chkbox']);
   
   $No_of_Month=count($month);
   if(!empty($month)){	
   $month=implode(',',$month);	
   }	  
	if($_POST['paidby']=="2")
	{
		$paymentdetail = $_POST['chqno'];
		$bankname = $_POST['bankname1'];
		$remarks = $_POST['remarks1'];
	}
	else if($_POST['paidby']=="3")
	{
		$paymentdetail = $_POST['txnno'];
		$bankname = $_POST['bankname2'];
		$remarks = $_POST['remarks2'];
	}
	else if($paidby=="4")
	{
		$paymentdetail = $_POST['utrno'];
	}
	
	$amtdue=$_POST['amtdue'];
	// $fname=$_POST['fname'];
	$stuname=$_POST['stuname'];
	$gen=$_POST['gen'];
	
	$stuid=$_POST['stuid'];
	$clsid=$_POST['clsid'];
	$sectionid=$_POST['sectionid'];
	
	$nprevfee=$_POST['nprevfee'];
	$ntransfee=$_POST['ntransfee'];
	
	$Late_fees=$_POST['latefees'];
	$fee_title='School Fees';
	$issby=$_POST['issby'];
	$issdate=$_POST['issdate'];
	$issdate1=$_POST['issdate1'];
	$issby=$_POST['issby'];
	$session=$_SESSION['session'];
	
	$feestr = implode(',',$_POST['paidfee']);
	$feeidstr = implode(',',$_POST['paidfeeid']);	
	
	$qfee1 = $con->query("select * from student_wise_fees where student_id='$stuid' and session='".$_SESSION['session']."'");
	if($qfee1->num_rows>0){
	 $student_wise_fees=$qfee1->fetch_assoc();
	 $feehead = $student_wise_fees['fee_header_id'];
     $headarr = explode(',',$feehead);
						
    $feeamt = $student_wise_fees['fee_amount'];
	$amtarr = explode(',',$feeamt);
		
	$feeheadcount = sizeof($headarr);
	}
	$AmountToPaidFeeMonthly=0;
	$AmountToPaidFeeYearly=0;
	$YearlyRcvFee=0;
	for($i=0;$i<$feeheadcount;$i++){
		$feeid = $headarr[$i];
		$feeamount = $amtarr[$i];
		
	$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1') and session='".$_SESSION['session']."' ");
		$trecamt = 0;
		$tranamt = 0;
		$prevamt = 0;
		while($rfee2 = mysqli_fetch_array($qfee2)){
						
		$fhid = $rfee2['fee_header_id'];
		$fhidarr = explode(',',$fhid);
							
		$recamt = $rfee2['received_amount'];
							
		$paid_month = $rfee2['month'];
        $paid_months=count(explode(',',$paid_month));
		$recamtarr = explode(',',$recamt);
							
	  if(in_array($feeid,$fhidarr)){
		$pos = array_search($feeid,$fhidarr);
		$val = $recamtarr[$pos];	
		}

	 $trecamt = (int)$trecamt+intval($val);
							
	 $tranamt = (int)$tranamt+(int)$rfee2['transport_amount'];
	 $prevamt = (int)$prevamt+(int)$rfee2['previous_amount'];
	 
	 $prevamt = (int)$prevamt+(int)$rfee2['previous_amount'];
	}	
						
	$baltranfee = (int)$transamt - (int)$tranamt;
	$balprevfee = (int)$prevfees - (int)$prevamt;
							 	
   $Monthly_Query = mysqli_query($con,"select monthly_fee_due from student_due_fees where student_id='$stuid' && (status='0' || status='1') ORDER BY student_due_fee_id DESC LIMIT 1;");
	
	if($Monthly_Query->num_rows>0){	
	 $Monthly_Data=$Monthly_Query->fetch_assoc();
	 $monthly_fee_due =$Monthly_Data['monthly_fee_due'];
		
	}else{
		$monthly_fee_due=0;
	}
		
		
		
	$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
		 $r1 = mysqli_fetch_array($q1);
		 $fheadname = $r1['fee_header_name'];
		 $fheadtype = $r1['type'];
		 if($fheadtype=='1'){
		    $charge_type="Monthly";			
            $balfee = $feeamount;	
			$AmountToPaidFeeMonthly+=($feeamount*$No_of_Month);
			$AmountToRcvMonthly+=$_POST['paidfee'][$i];
			
			
			}else{
			 $charge_type="Yearly";
			 $balfee = $feeamount;
             $AmountToPaidFeeYearly+=((int)$balfee-(int)$trecamt);
			 $YearlyRcvFee+= $_POST['paidfee'][$i];
					
             						
		}
	}
	
	
	
	$AmountToPaidFee=0;
	$AmountToPaidFee=(int)$AmountToPaidFeeMonthly+(int)$monthly_fee_due;
    $YearlyDue=(int)$AmountToPaidFeeYearly-(int)$YearlyRcvFee;
    $AmountToRcvMonthly=(int)$AmountToRcvMonthly+(int)$nprevfee;
	
    $current_month_DueFee=(int)$AmountToPaidFee-(int)$AmountToRcvMonthly;
	
	$monthly_fee_due=$current_month_DueFee;
	if($monthly_fee_due<0){
		$monthly_fee_due=0;
	}
	if($current_month_DueFee<0){
		$current_month_DueFee=0;
	}
   

    $que= mysqli_query($con,"select `student_id`,`student_name`,`token_id`,`gender`,`due`,`parent_no`,`msg_type_id`,`father_name`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && s.stu_status='0' && sr.session='".$_SESSION['session']."' ");
	$res1=mysqli_fetch_array($que);
	
	$stuname=$res1['student_name'];
	$clsid=$res1['class_id'];
	$gender=$res1['gender'];
	$msgtype=$res1['msg_type_id'];
	$due=$res1['due'];
	$token_id=$res1['token_id'];
		
	if($gender=="FEMALE"){
	 $gen="Daughter";	
	}else{
	 $gen="Son";	
	}

    $fname=$res1['father_name'];
   
	$classid=$res1['class_id'];
	
		$qcls=mysqli_query($con,"select * from class where class_id='$classid'");
		if($qcls->num_rows > 0){
			$rcls=mysqli_fetch_array($qcls);
			$stuclass = $rcls['class_name'];
		}else{
			$stuclass = 0;
		}

		$sectionid=$res1['section_id'];
		$qsec=mysqli_query($con,"select * from section where section_id='$sectionid'");
		if($qsec->num_rows > 0){
			$rsec=mysqli_fetch_array($qsec);
			$stusec = $rsec['section_name'];
		}else{
			$stusec = 0;
		}

		$qprev = mysqli_query($con,"select * from previous_fees where student_id='$stuid' and session='".$_SESSION['session']."'");
		if($qprev->num_rows > 0){
			$rprev = mysqli_fetch_array($qprev);
			$prevfees = $rprev['previous_fees'];
		}else{
			$prevfees = 0;
		}

		if(!empty($nprevfee)){
			$nprevfee = $nprevfee;
		}else{
			$nprevfee = 0;
		}
		if(!empty($ntransfee)){
			$ntransfee = $ntransfee;
		}else{
			$ntransfee = 0;
		} 


		$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
	
	$s1=mysqli_query($con,"select * from sms_setting where sms_id=2  ");
	$r1=mysqli_fetch_array($s1);

	$status=$r1['status'];
	// $status=1;  //currently set sms status is 1 
	
	$issdate1 = date("Y-m-d",strtotime($issdate));
	
	
	
	$sset=mysqli_query($con,"select * from setting");
	$rsset=mysqli_fetch_array($sset);
	$sclname=$rsset['company_name'];
	
  $mobile=$res1['parent_no'];
  $messagetype = 'fee_paid';
	
  $totalpayble=$_REQUEST['totalpayble'];
  $amtdue=$_REQUEST['amtdue'];
					
	
	$query1="insert into student_due_fees (student_id,class_id,section_id,fee_header_id,received_amount,previous_amount,
	transport_amount,latefee,due_amount, month,paid_month_due,monthly_fee_due,yealy_due, payment_type_id,payment_detail,bank_name,remarks,issued_by,issue_date,date,session) 
	values ('$stuid','$clsid','$sectionid','$feeidstr','$feestr','$nprevfee','$ntransfee','$Late_fees','$amtdue','$month','$current_month_DueFee','$monthly_fee_due','$YearlyDue','$paidby','$paymentdetail',
	'$bankname','$remarks','$issby','$issdate','$issdate1','$session')";
  
    $querycheck = mysqli_query($con,$query1); 
        
    if( mysqli_error($con)){
        echo("Error description: " . mysqli_error($con));
		$Responce=array('status'=>'derror','msg'=>'Ops Somethings goes Wrong');		
	     echo json_encode($Responce);
    }
	
	
	
	if($querycheck){
		 
		 $Total_paid_month_due=$current_month_DueFee+$YearlyDue;
	
			if($paidby=="2"){
 
				$messagetype="fee-paid-by";
		
			  $msg = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." School Fees of Rs ".$totalpaid." has been received. The remaining amount ".$Total_paid_month_due." is Pending.%0aDetails%0aPayment Mode: Cheque,%0aCheque No: ".$paymentdetail."%0aBank: ".$bankname."%0aRemarks: ".$remarks.".%0aRegards,%0a".$sclname ."%0aISCTDT" ;
			}
			else
			{
				$messagetype="fee-paid";
				
		   $msg = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." School Fees of Rs ".$totalpaid." has been received. The remaining amount ".$Total_paid_month_due." is Pending.%0aRegards,%0a".$sclname."%0aISCTDT";	
			}	
			
			$msgn = "Dear Mr. ".$fname.",<br>Your ".$gen." ".$stuname." School Fees of Rs ".$totalpaid." has been received. The remaining amount ".$Total_paid_month_due." is Pending.<br>Regards,<br>".$sclname."%0aISCTDT";   
			  	// echo $msg; die;
						// $messagetype="";
						
				if($msgtype==1 ){

					$q1=$con->query("insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session)values(3,'$stuid','$clsid','$sectionid',0,'$mobile','$fee_title','$msgn','1','$issby','$issdate','$issdate1','".$_SESSION['session']."')");	

					 sendwhatsappMessage($mobile, $msg, $messagetype);


				}elseif($msgtype==2){
					$q1=$con->query("insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session)values(3,'$stuid','$clsid','$sectionid',0,'$mobile','$fee_title','$msgn','2','$issby','$issdate','$issdate1','".$_SESSION['session']."')");	

					sendtextMessage($mobile, $msg, $messagetype);

				}



		
	   if(mysqli_error($con)){
			echo("Error description: ".mysqli_error($con));
			$Responce=array('status'=>'derror','msg'=>'Ops Somethings goes Wrong');		
	        echo json_encode($Responce);
		}
		
	   mysqli_query($con,"update students set due='$amtdue' where student_id='$stuid' ");	 //$amtdue
	   mysqli_query($con,"update student_wise_fees set due_amount='$amtdue' where student_id='$stuid' and session='".$_SESSION['session']."'");//,current_due='$current_due'
		
	}
	
	  
     if(isset($_POST['print'])){
		 $que2=mysqli_query($con,"select * from student_due_fees order by student_due_fee_id desc" );
		$res2=mysqli_fetch_array($que2);
		$bid=$res2['student_due_fee_id'];
		 $url="/print_receipt.php?id=$bid&chk=$str";
		$Responce=array('status'=>'PSuceess','msg'=>'Fees Collect Successfuly','url'=>$url);	

		// -----------------send push notification for each parent----------------------	
			         
		if(!empty($token_id)){
			$msg_type='push_fee_collect';
			send_push_notification($msg_type, $token_id);
		}
						
	    // -----------------send push notification for each parent----------------------
				
		 echo json_encode($Responce);
	 
	 }else{
		 
		 $Responce=array('status'=>'Suceess','msg'=>'Fees Collect Successfuly');	
		 echo json_encode($Responce);
		
	 }
	
	 
	}
	else
	{
	  $Responce=array('status'=>'error','msg'=>'Please enter the fees details');		
	  echo json_encode($Responce);
	}


  }	


 if(isset($_POST['TakeAttendence'])){
// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// die;


	$atdate = $_REQUEST['atdate']; 

	$regno = $_REQUEST['regno'];

	$stuid = $_REQUEST['stuid'];

	$attendance = $_REQUEST['attend'];

	$reason=$_REQUEST['reason'];
	
	$class=$_REQUEST['class'];
	$section=$_REQUEST['section'];


	$totaluser=sizeof($regno);
	$querychk = mysqli_query($con,"select * from student_daily_attendance where class_id='$class' && section_id='$section' && 	date='$atdate' && session='".$_SESSION['session']."'");

	$ar_stuid=array();

	$row = mysqli_num_rows($querychk);
	if($row){
		// for update
		for($i=0;$i<$totaluser;$i++){

			$newreg=$regno[$i];
			$newstuid=$stuid[$i];
			$newattendance=$attendance[$i];
			$newreason=$reason[$i];

			$chkatt = mysqli_query($con,"select * from student_daily_attendance where class_id='$class' && section_id='$section' && 	date='$atdate' && session='".$_SESSION['session']."' && student_id='".$newstuid."'");
			$crow=mysqli_fetch_assoc($chkatt);

			if($newattendance!=$crow['type_of_attend']  || $newreason!=$crow['reason'] ){
			
				$q1=mysqli_query($con,"update student_daily_attendance set type_of_attend='$newattendance', reason='$newreason', modify_date=now() where date='$atdate' && student_id='$newstuid'");

				// $ar_stuid[]=$newstuid;
				$ar_stuid[]=$crow['student_att_id'];
				
				
			//$tempupdate=mysqli_query($con,"update temp_attendace set type_of_attend='$newattendance', reason='$newreason', modify_date=now() where date='$atdate' && student_id='$newstuid'");
	
				
				
			}
		}  

		
		 $Responce=array('status'=>'success','type'=>'update','result'=>$ar_stuid,'msg'=>'Attendence Updated successfully');	
		 echo json_encode($Responce);
		

	}else{

		for($i=0;$i<$totaluser;$i++){

			$newreg=$regno[$i];

			$newstuid=$stuid[$i];

			$newattendance=$attendance[$i];

			$newreason=$reason[$i];

			
		   $sql1="insert into student_daily_attendance (register_no,student_id,class_id,section_id,type_of_attend,reason,date,session,create_date,modify_date)values('$newreg','$newstuid','$class','$section','$newattendance','$newreason','$atdate','".$_SESSION['session']."',now(),now())";

			$q1=$con->query($sql1);

			
			// $tempSql="insert into temp_attendace (register_no,student_id,class_id,section_id,type_of_attend,reason,date,session,create_date,modify_date)values('$newreg','$newstuid','$class','$section','$newattendance','$newreason','$atdate','".$_SESSION['session']."',now(),now())";

			// $tempQury=$con->query($tempSql);

			if(mysqli_error($con)){
				 $Responce=array('status'=>'error','msg'=>'Somethings went wrong, Please try again');	
		        echo json_encode($Responce);

			}			

		}
		
		if($q1){
		
		 $Responce=array('status'=>'success','type'=>'insert','msg'=>'Attendence taken successfully');	
		 echo json_encode($Responce);
		 
		}
		

	}

	 // $query="select * from students where class_id='$class' && section_id='$section' and session='".$_SESSION['session']."' order by (student_id) DESC";
	 // $search_result = mysqli_query($con, $query);

 }

if(isset($_POST['TakeAttendence_sms'])){
	

 	$atdate = $_REQUEST['atdate']; 

	$regno = $_REQUEST['regno'];

	$stuid = $_REQUEST['stuid'];

	$attendance = $_REQUEST['attend'];
	$att_title = 'Attendance';

    $totaluser=count($stuid);
	$reason=$_REQUEST['reason'];
	$att_type=$_REQUEST['att_type'];
	$arr_att_stuid=explode(',',$_REQUEST['arr_stu']);
	$action_att='';

	$totaluser=sizeof($regno);
	$username=$_SESSION['user_roles'];
	$session=$_SESSION['session'];
  $date=date("d-m-Y",strtotime($atdate));

  $flag=true;
  $Wflag=true;
  $Tflag=true;
	
	// $textsmstype_pr_ab="attendance-pr-ab";
	// $textsmstype_leave="attendance-leave";
	
  $class=$_REQUEST['class'];
	$section=$_REQUEST['section'];
	$messagetype = "attendance-sms";

	 
	$wquery ="select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' and `msg_type_id`='1' ";

	 $wsearch_result = mysqli_query($con, $wquery);
	  $Wstudents=mysqli_num_rows($wsearch_result);

	 // $tquery="select * from students where class_id='$class' && section_id='$section' and session='".$_SESSION['session']."' and `msg_type_id`='2' ";
	  $tquery ="select `student_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && s.stu_status='0' && sr.session='".$_SESSION['session']."' and `msg_type_id`='2' ";
	 $tsearch_result = mysqli_query($con, $tquery);
	  $Tstudents=mysqli_num_rows($tsearch_result);

	$sset=mysqli_query($con,"select * from setting");

	$rsset=mysqli_fetch_array($sset);

	$sclname=$rsset['company_name'];

				//---------------------------Text sms format------------------------------------
				$presentmsg="Dear Parents,%0aYour son/daughter has been Present today.%0a".$date.".%0aRegards,%0a".$sclname."%0aISCTDT";

				$npresentmsg="Dear Parents,<br>Your son/daughter has been Present today.<br>".$date.".<br>Regards,<br>".$sclname."<br>ISCTDT";

				$absentmsg="Dear Parents,%0aYour son/daughter has been Absent today.%0a".$date.".%0aRegards,%0a".$sclname."%0aISCTDT";

				$nabsentmsg="Dear Parents,<br>Your son/daughter has been Absent today.<br>".$date.".<br>Regards,<br>".$sclname."<br>ISCTDT";

			  $leavemsg="Dear Parents,%0aYour son/daughter has been Leave on today.%0a".$date.".%0aRegards,%0a".$sclname."%0aISCTDT";

				$nleavemsg="Dear Parents,<br>Your son/daughter has been Leave on today.<br>".$date.".<br>Regards,<br>".$sclname."<br>ISCTDT";
			//end ---------------------------Text sms format------------------------------------
	$x=1;
	$PresentWhatsappmob=array();
	$AbsentWhatsappmob=array();
	$LeaveWhatsappmob=array();

	$PresentTextmob=array();
	$AbsentTextmob=array();
	$LeaveTextmob=array();

	//------------------------------------------------create sms validation--------------------------- 
	$Tcount = get_text_sms_count()['count_sms'];
	$Wcount = get_whatsapp_sms_count()['count_sms'];
	$Wstatus = get_whatsapp_sms_setting()['status'];
	$Tstatus = get_text_sms_setting()['status'];

	if (!($Wcount >= $Wstudents) && !($Tcount >= $Tstudents)) {
		$responce['status'] = "error";
		$responce['msg'] = "Sms not sent due to Insufficient SMS Limit<br>Whatsapp sms: " . $Wcount . " <br> Text sms: " . $Tcount . " ";
		$flag = false;
		$Tflag = false;
		$Wflag = false;
		// echo json_encode($responce); die;

	} elseif ($Wstatus == '0' && $Tstatus == '0') {
		$responce['status'] = "error";
		$responce['msg'] = "Sms not sent ,Please turn on your SMS service";
		$flag = false;
		$Tflag = false;
		$Wflag = false;
	} elseif (!($Wcount >= $Wstudents)) {
		$responce['status'] = "error";
		$responce['msg'] = "Whatsapp Sms not sent due to Insufficient SMS Limit<br>Whatsapp sms: " . $Wcount . " ";
		$Wflag = false;
	} elseif (!($Tcount >= $Tstudents)) {
		$responce['status'] = "error";
		$responce['msg'] = "Text Sms not sent due to Insufficient SMS Limit<br>Text sms: " . $Tcount . " ";

		$Tflag = false;
	} elseif ($Wstatus == '0') {
		$responce['status'] = "error";
		$responce['msg'] = "Sms not sent ,Please turn on your Whatsapp SMS service";
		$Wflag = false;
	} elseif ($Tstatus == '0') {
		$responce['status'] = "error";
		$responce['msg'] = "Text Sms not sent ,Please turn on your Textsms SMS service";
		$Tflag = false;
	} else {
		$responce = array('status' => 'success', 'msg' => 'Attendence taken successfully');
	}
	// 
	//-end -----------create sms validation-------------- 
	if($att_type=='insert'){		
		$responce = array('status' => 'success', 'msg' => 'Attendence taken with sms successfully');

		if ($flag) {
			for ($i = 0; $i < $totaluser; $i++) {

				$newreg = $regno[$i];

				$newstuid = $stuid[$i];

				$newattendance = $attendance[$i];

				$newreason = $reason[$i];
				$que1 = mysqli_query($con, "select `student_id`,`token_id`,`student_name`,`sr`.`class_id`,`sr`.`section_id`,`father_name`,`parent_no`,`gender`,`msg_type_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0' && sr.session='" . $_SESSION['session'] . "' and s.student_id='$newstuid'");

				$r1 = mysqli_fetch_array($que1);
              
				$name = $r1['student_name'];

				// $classid = $r1['class_id'];

				$section = $r1['section_id'];

				$mobile = $r1['parent_no'];
				$token_id = $r1['token_id'];

				$msgtype = $r1['msg_type_id'];

				$fathername = $r1['father_name'];

				$gender = $r1['gender'];
				$gen=($gender=="FEMALE") ? "Daughter" : "Son";


				if ($attendance[$i] == 1) {
					$Wmessage="Dear ".$fathername."%0aYour ".$gen." ".$name." is Present on ".$date.".%0aRegards,%0a".$sclname.",";
				  $Wnmessage="Dear ".$fathername."<br>Your ".$gen." ".$name." is Present on ".$date.".<br>Regards,<br>".$sclname.",";
				  
                  //IN Future Need to remove this
				  $msgtype=2;
				  
				  
				  
					// $action_att='Present';
					if ($msgtype == 1) {
					

						if ($Wflag) {
							$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$Wnmessage','1','$username',now(),'$atdate','$session')");
						}
					} elseif ($msgtype == 2) {
						if ($Tflag) {
							$PresentTextmob[] = getStudents_text_mobno($stuid[$i], $session)['parent_no'] ?? 0;

							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$npresentmsg','2','$username',now(),'$atdate','$session')");
						}
					}
				} elseif ($attendance[$i] == 2) {

					$Wmessage="Dear ".$fathername."%0aYour ".$gen." ".$name." is Absent on ".$date.".%0aRegards,%0a".$sclname.",";
				  $Wnmessage="Dear ".$fathername."<br>Your ".$gen." ".$name." is Absent on ".$date.".<br>Regards,<br>".$sclname.",";
					if ($msgtype == 1) {
					
						if ($Wflag) {
							$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
							// if($result=='success'){
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$Wnmessage','1','$username',now(),'$atdate','$session')");
						}
					} elseif ($msgtype == 2) {
						if ($Tflag) {
							$AbsentTextmob[] = getStudents_text_mobno($stuid[$i], $session)['parent_no'] ?? 0;
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$nabsentmsg','2','$username',now(),'$atdate','$session')");
						}
					}
				} elseif ($attendance[$i] == 3) {

					// $leavemob[]=getStudent_byStudent_id($stuid[$i])['parent_no'];
					$Wmessage="Dear ".$fathername."%0aYour ".$gen." ".$name." is Leave on ".$date.".%0aRegards,%0a".$sclname.",";
				  $Wnmessage="Dear ".$fathername."<br>Your ".$gen." ".$name." is Leave on ".$date.".<br>Regards,<br>".$sclname.",";
					if ($msgtype == 1) {
						if ($Wflag) {
							// $LeaveWhatsappmob[] = getStudents_whatsapp_mobno($stuid[$i], $session)['parent_no']  ?? 0;
							$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);

							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$Wnmessage','1','$username',now(),'$atdate','$session')");
						}
					} elseif ($msgtype == 2) {
						if ($Tflag) {
							$LeaveTextmob[] = getStudents_text_mobno($stuid[$i], $session)['parent_no'] ?? 0;
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,'heading',message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$nleavemsg','2','$username',now(),'$atdate','$session')");
						}
					}
				}
				// -----------------send push notification for each parent----------------------	
			         
					if(!empty($token_id)){
						$msg_type='push_attendance';
						send_push_notification($msg_type, $token_id);
					}
									
				// -----------------send push notification for each parent----------------------	
			} //close for loop

			if ($Tflag) {
				
				if (!empty($PresentTextmob)) {
					
					sendtextMessage($PresentTextmob, $presentmsg, $messagetype);
				}
				if (!empty($AbsentTextmob)) {
					sendtextMessage($AbsentTextmob, $absentmsg, $messagetype);
				}
				if (!empty($LeaveTextmob)) {
					sendtextMessage($LeaveTextmob, $leavemsg, $messagetype);
				}
			}
	
		} //flag
		echo json_encode($responce);
		die;
	} elseif($att_type=='update' && !empty($arr_att_stuid[0])) {
		//for update attendance only 
		$responce = array('status' => 'success', 'msg' => 'Attendence Update successfully');
		
		if($flag){
			
			$totaluser2=sizeof($arr_att_stuid);
			for ($i = 0; $i < $totaluser2; $i++) {

				// $newreg = $regno[$i];
				// print_r($arr_att_stuid);

				$new_att_stuid = trim($arr_att_stuid[$i]);
				$newstuid=get_stu_daily_attendence_byid($new_att_stuid)['student_id'];
				$type_of_attend=get_stu_daily_attendence_byid($new_att_stuid)['type_of_attend'];
				$newreason=get_stu_daily_attendence_byid($new_att_stuid)['reason'];

				// $newattendance = $attendance[$i];

				// $newreason = $reason[$i];
				$que1 = mysqli_query($con, "select `student_id`,`student_name`,`token_id`,`sr`.`class_id`,`sr`.`section_id`,`father_name`,`parent_no`,`gender`,`msg_type_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where  s.stu_status='0' && sr.session='" . $_SESSION['session'] . "' and s.student_id='$newstuid'");

				$r1 = mysqli_fetch_array($que1);

				$name = $r1['student_name'];

				$classid = $r1['class_id'];

				$section = $r1['section_id'];

				$mobile = $r1['parent_no'];
				$token_id = $r1['token_id'];

				$msgtype = $r1['msg_type_id'];

				$fathername = $r1['father_name'];

				$gender = $r1['gender'];
				$gen=($gender=="FEMALE") ? "Daughter" : "Son";



				if ($type_of_attend == 1) {
					$Wmessage="Dear ".$fathername."%0aYour ".$gen." ".$name." is Present on ".$date.".%0aRegards,%0a".$sclname.",";
				  $Wnmessage="Dear ".$fathername."<br>Your ".$gen." ".$name." is Present on ".$date.".<br>Regards,<br>".$sclname.",";

					if ($msgtype == 1) {
					
						if ($Wflag) {
							$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$Wnmessage','1','$username',now(),'$atdate','$session')");
						}
					} elseif ($msgtype == 2) {

						if ($Tflag) {
							$PresentTextmob[] = getStudents_text_mobno($newstuid, $session)['parent_no'] ?? 0;

							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$npresentmsg','2','$username',now(),'$atdate','$session')");
						}
					}
				} elseif ($type_of_attend == 2) {

				$Wmessage="Dear ".$fathername."%0aYour ".$gen." ".$name." is Absent on ".$date.".%0aRegards,%0a".$sclname.",";
				  $Wnmessage="Dear ".$fathername."<br>Your ".$gen." ".$name." is Absent on ".$date.".<br>Regards,<br>".$sclname.",";
					if ($msgtype == 1) {
						// $AbsentWhatsappmob[]=getStudents_whatsapp_mobno($stuid[$i],$session)['parent_no'] ?? 0;
						if ($Wflag) {
							$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);
							// if($result=='success'){
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$Wnmessage','1','$username',now(),'$atdate','$session')");
						}
					} elseif ($msgtype == 2) {
						if ($Tflag) {
							$AbsentTextmob[] = getStudents_text_mobno($newstuid, $session)['parent_no'] ?? 0;
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$nabsentmsg','2','$username',now(),'$atdate','$session')");
						}
					}
				} elseif ($type_of_attend == 3) {

					$Wmessage="Dear ".$fathername."%0aYour ".$gen." ".$name." is Leave on ".$date.".%0aRegards,%0a".$sclname.",";
				  $Wnmessage="Dear ".$fathername."<br>Your ".$gen." ".$name." is Leave on ".$date.".<br>Regards,<br>".$sclname.",";
					if ($msgtype == 1) {
						if ($Wflag) {
							// $LeaveWhatsappmob[] = getStudents_whatsapp_mobno($newstuid, $session)['parent_no']  ?? 0;
							$result = sendwhatsappMessage($mobile, $Wmessage, $messagetype);

							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$Wnmessage','1','$username',now(),'$atdate','$session')");
						}
					} elseif ($msgtype == 2) {
						if ($Tflag) {
							$LeaveTextmob[] = getStudents_text_mobno($newstuid, $session)['parent_no'] ?? 0;
							$que2 = mysqli_query($con, "insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,heading,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$newstuid','$class','$section',0,'$mobile','$att_title','$nleavemsg','2','$username',now(),'$atdate','$session')");
						}
					}
				}
				// -----------------send push notification for each parent----------------------	
			         
				if(!empty($token_id)){
					$msg_type='push_attendance_update';
					send_push_notification($msg_type, $token_id);
				}
								
			// -----------------send push notification for each parent----------------------
			} //close for loop

		
			if ($Tflag) {
				if (!empty($PresentTextmob)) {
					sendtextMessage($PresentTextmob, $presentmsg, $messagetype);
				}
				if (!empty($AbsentTextmob)) {
					sendtextMessage($AbsentTextmob, $absentmsg, $messagetype);
				}
				if (!empty($LeaveTextmob)) {
					sendtextMessage($LeaveTextmob, $leavemsg, $messagetype);
				}
			}
		
		} //flag
		echo json_encode($responce);
		die;
		
	}else{
	echo json_encode($responce);	
		
	}

	

}

 if(isset($_POST['scholastic-grade'])){

   $class = $_REQUEST['class'];
	$section = $_REQUEST['section'];
	$subject = $_REQUEST['subject'];
	$test = $_REQUEST['test'];
	$maxmark = $_REQUEST['max1'];
	$stuid = $_REQUEST['studid'];
	$grade = $_REQUEST['marks'];
	$totalstu = sizeof($stuid);
	for($i=0;$i<$totalstu;$i++)
	{
	
	$newstuid = $stuid[$i];
	$newgrade = $grade[$i];
	$q = mysqli_query($con,"select * from `scholastic-grade` where class_id='$class' && section_id='$section' && student_id='$newstuid' && term_id='$test' && subject_id='$subject' and session='".$_SESSION['session']."'");
	$r = mysqli_num_rows($q);
	if($r)
	{
		$re = mysqli_fetch_array($q);
		$grad_id = $re['id'];
		$querysave = mysqli_query($con,"update `scholastic-grade` set grade='$newgrade',modify_date=now() where id='$grad_id' and session='".$_SESSION['session']."' ");
		if($i==0){
		if($querysave){

		 $Responce=array('status'=>'success','msg'=>'Scholastic Grade Updated Successfuly');
		 echo json_encode($Responce);
		 
		}else{
		 $Responce=array('status'=>'error','msg'=>'Somethings is Wrong');
		 echo json_encode($Responce);		
		}
	  }
	}
	else
	{
		
		$querysave = mysqli_query($con,"insert into `scholastic-grade` (class_id,section_id,subject_id,term_id,student_id,grade,create_date,modify_date,session) values 
	    ('$class','$section','$subject','$test','$newstuid','$newgrade',now(),now(),'".$_SESSION['session']."')");
		if($i==0){
		if($querysave){
		
		$Responce=array('status'=>'success','msg'=>'Scholastic Grade Inserted Successfuly');
		 echo json_encode($Responce);
		 
		}else{
		 $Responce=array('status'=>'error','msg'=>'Somethings is Wrong');
		 echo json_encode($Responce);
		 }
		}
		
	   }
	
	  
		
	}




}	
if(isset($_POST['add_student'])){

	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	// echo "</pre>";
	date_default_timezone_set("Asia/Kolkata");
	$regisnumber=mysqli_real_escape_string($con,$_POST['regisnumber']);
	$stuname=mysqli_real_escape_string($con,$_POST['stuname']);
	$stufname=mysqli_real_escape_string($con,$_POST['stufname']);
	$stumname=mysqli_real_escape_string($con,$_POST['stumname']);
	$gender=mysqli_real_escape_string($con,$_POST['gender']);
	$dob=mysqli_real_escape_string($con,$_POST['dob']);
	$admissiondate=mysqli_real_escape_string($con,$_POST['admissiondate']);
	$stucontact=mysqli_real_escape_string($con,$_POST['stucontact']);
	$stuclass=mysqli_real_escape_string($con,$_POST['stuclass']);
	$stusection=mysqli_real_escape_string($con,$_POST['stusection']);
	$stuparentcontact=mysqli_real_escape_string($con,$_POST['stuparentcontact']);
	$password=mysqli_real_escape_string($con,$_POST['password']);
	$stuaddress=mysqli_real_escape_string($con,$_POST['stuaddress']);
	$present_address=mysqli_real_escape_string($con,$_POST['present_address']);
	$admtype=mysqli_real_escape_string($con,$_POST['admtype']);
	$msg_type=mysqli_real_escape_string($con,$_POST['msg_type']);
	$academic_year=mysqli_real_escape_string($con,$_POST['academic_year']);
	$Nationality=mysqli_real_escape_string($con,$_POST['Nationality']);
	$rte=mysqli_real_escape_string($con,$_POST['rte']);
	$religion=mysqli_real_escape_string($con,$_POST['religion']);
	$caste=mysqli_real_escape_string($con,$_POST['caste']);
	$category=mysqli_real_escape_string($con,$_POST['category']);
	$bldgrp=mysqli_real_escape_string($con,$_POST['bldgrp']);
	$lang=mysqli_real_escape_string($con,$_POST['lang']);
	
	$aadhar=mysqli_real_escape_string($con,$_POST['aadhar']);
	$birth_place=mysqli_real_escape_string($con,$_POST['birth_place']);
	$village=mysqli_real_escape_string($con,$_POST['village']);
	$fqualification=mysqli_real_escape_string($con,$_POST['fqualification']);
	$mqualification=mysqli_real_escape_string($con,$_POST['mqualification']);
	$foccupation=mysqli_real_escape_string($con,$_POST['foccupation']);
	$moccupation=mysqli_real_escape_string($con,$_POST['moccupation']);
	$fannual_income=mysqli_real_escape_string($con,$_POST['fannual_income']);
	$dependent=mysqli_real_escape_string($con,$_POST['dependent']);
	$guardians=mysqli_real_escape_string($con,$_POST['guardians']);
	$subcaste=mysqli_real_escape_string($con,$_POST['subcaste']);
	$other_language=mysqli_real_escape_string($con,$_POST['other_language']);
	$previous_school=mysqli_real_escape_string($con,$_POST['previous_school']);
	$f_aadhar=mysqli_real_escape_string($con,$_POST['f_aadhar']);
	$m_aadhar=mysqli_real_escape_string($con,$_POST['m_aadhar']);
	$bank_acc=mysqli_real_escape_string($con,$_POST['bank_acc']);
	$ifsc=mysqli_real_escape_string($con,$_POST['ifsc']);
	$branch=mysqli_real_escape_string($con,$_POST['branch']);
	$bus_facility=mysqli_real_escape_string($con,$_POST['bus_facility']);
	$responce=array();
	
	$admission_id=!empty($_POST['admission_id']) ? mysqli_real_escape_string($con,$_POST['admission_id']) : '0' ;	


		if(!empty($fannual_income)){
			$fannual_income=$fannual_income;
		}else{
			$fannual_income = 0;
		}

		if(!empty($dependent)){
			$dependent=$dependent;
		}else{
			$dependent = 0;
		}
		
		$stu_res="select `student_id`,sr.session from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.session='$academic_year' ";
		$st1=mysqli_query($con,$stu_res);
		$rst1=mysqli_num_rows($st1);
		
		$sr=mysqli_query($con,"select * from student_restrict where id='1'");
		$rsr=mysqli_fetch_array($sr);
		$tstu=$rsr['total_students'];

		
		$admission_no=get_new_admission_no();
		if(empty($admission_no)){
			$responce['type']='ERROR';
			$responce['message']='Oops, Please try again';
			echo json_encode($responce);die;
		}
		

		//------------------end -Admission no increment-------------------------------------------------------
		

		$session=$academic_year;
		$aca=mysqli_query($con,"select * from session where id='$academic_year'");
		$aca1=mysqli_fetch_array($aca);
		$AcademicYear=$aca1['year'];

        $Admission_date= explode('-',$admissiondate);
				$Admission_month=$Admission_date[1];
				
			    $Admission_Year=$Admission_date[0];
			    $Current_Year=date('Y');
				$startFeeMonth=4;
				$months=12;
                $Admission_month=ltrim($Admission_month, "0");	
						
                if($Admission_month>$startFeeMonth && $Admission_Year==$Current_Year){
				 $No_of_Month_FeeNo_Charge=$Admission_month-$startFeeMonth;
				 $St_wise_months=$months-$No_of_Month_FeeNo_Charge;
							
				$ReIndexAddmission_Month=$Admission_month-4;
				$current_fee_charge_Month=$Current_Month-$ReIndexAddmission_Month;
				$fee_start_month=$Admission_month;
							
							
				}else{
				$St_wise_months=12;
				$fee_start_month=4;
			   }
			
		
			

			$qfee = mysqli_query($con,"select * from assign_fee_class where class_id='$stuclass' and session='$session'");
             $FeeAssignNo=  $qfee->num_rows;
            if($qfee->num_rows > 0){

                $rfee = mysqli_fetch_array($qfee);

                $feeids = $rfee['fee_header_id'];
                $feeamts = $rfee['fee_header_amount'];

            }else{

				$feeids = 0;

                $feeamts = 0;

            }
          

            $feehead = explode(',',$feeids);

			$feeamt = explode(',',$feeamts);
			
			$NO_Of_Fee_Head= count($feehead);

			 $Student_Wise_Total_Amount=0;
			 $DueStu_Amount=0;
			 $NO_Of_Fee_Head= count($feehead);
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
					 $Student_Wise_Total_Amount=$Student_Wise_Total_Amount+$FeeHeadAmount;

				 }
				 
			 }
			
	     $DueStu_Amount=$Student_Wise_Total_Amount;
 
		
		
		$nstuaddress = mysqli_real_escape_string($con, $_POST['stuaddress']);
		$npresent_address = mysqli_real_escape_string($con, $_POST['present_address']);
					
		if($rst1<$tstu)
		{	
	
			$qcls = mysqli_query($con,"select * from assign_fee_class where class_id='$stuclass'  and session='$session'");
			$clsrow = mysqli_num_rows($qcls);
			if($clsrow)
			{
			
				$sql=mysqli_query($con,"select student_id,register_no,admission_no from students where register_no='$regisnumber' || `admission_no`='$admission_no' ");
				$res=mysqli_num_rows($sql);
				if($res>0)
				{
					// $err="<span id='err_notsuccessful'>[ This Register Number is Already Exists. ]</span>";	
					$responce['type']='ALREADY';
						$responce['message']='This Register no or Adm. Number is Already Exists.';
						echo json_encode($responce);die;
				}
				else 
				{	
			
					$img1=$_FILES['file1']['name'];
					
                   $regisnumber_img=str_replace('/','-',$regisnumber);
							
					if($img1=="")
					{
						// $sql1=;
						// $query=$con->query($sql1); '$stuclass','$stusection',
						$query=mysqli_query($con,"insert into students(register_no,admission_no,student_name,father_name,mother_name,gender,dob,admission_date,student_contact,due,parent_no,password,stuaddress,adm_type_id,msg_type_id,admin_rte,religion_id,caste,soc_cat_id,blood_grp,mother_tongue,aadhar_card,birth_place,village,fqualification,mqualification,foccupation,moccupation,fannual_income,dependents,guardians,nationality,subcaste,other_language,present_address,previous_school,father_aadhar,mother_aadhar,student_bankacc,ifsc_code,branch,bus_facility,stu_status,admission_id,create_date,modify_date) values ('$regisnumber','$admission_no','$stuname','$stufname','$stumname','$gender','$dob','$admissiondate','$stucontact','$DueStu_Amount','$stuparentcontact','$password','$nstuaddress','$admtype','$msg_type','$rte','$religion','$caste','$category','$bldgrp','$lang','$aadhar','$birth_place','$village','$fqualification','$mqualification','$foccupation','$moccupation','$fannual_income','$dependent','$guardians','$nationality','$subcaste','$other_language','$npresent_address','$previous_school','$f_aadhar','$m_aadhar','$bank_acc','$ifsc','$branch','$bus_facility','0' ,'$admission_id', now(),now())");
						
						if(mysqli_error($con)){
						// echo("Error description: " . mysqli_error($con));
							$responce['type']='ERROR';
						  $responce['message']='Error description:'.mysqli_error($con).'';
						  echo json_encode($responce);
						}
						
						// exit();
						if($query)
						{
							
						$stuid = mysqli_insert_id($con);
						// echo $srql=;
						$query3 = mysqli_query($con,"INSERT INTO `student_records`(`stu_id`, `class_id`, `section_id`,`session`, `create_at`, `modify_at`) VALUES ('$stuid','$stuclass','$stusection','$session',now(),now())");
						if($query3){
							if($FeeAssignNo>0){
							
							$query2 = mysqli_query($con,"insert into student_wise_fees (student_id,class_id,section_id,fee_header_id,
							fee_amount,due_amount,no_of_months,fee_start_month,session,create_date,modify_date) 
							values ('$stuid','$stuclass','$stusection','$feeids','$feeamts','$DueStu_Amount','$St_wise_months',$fee_start_month,'$session','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
							}

							if(!empty($admission_id)){
								 $AddSql="UPDATE `admission` SET `student_id`='$stuid' , `status`='4' , `modify_date`=now()  where `admission_id`='$admission_id'";
								mysqli_query($con,$AddSql);
							}
						}	
						
						}
						
					}
					else	
					{
						$query="insert into students(register_no,admission_no,student_name,father_name,mother_name,gender,dob,
						admission_date,student_contact,due,parent_no,password,stuaddress,adm_type_id,
						msg_type_id,admin_rte,religion_id,caste,soc_cat_id,blood_grp,mother_tongue,aadhar_card,
						stu_image,birth_place,village,fqualification,mqualification,foccupation,moccupation,fannual_income,dependents,
						guardians,nationality,subcaste,other_language,present_address,previous_school,father_aadhar,mother_aadhar,
						student_bankacc,ifsc_code,branch,bus_facility,stu_status,admission_id,create_date,modify_date) 
						values ('$regisnumber','$admission_no','$stuname','$stufname','$stumname','$gender','$dob','$admissiondate','$stucontact','$DueStu_Amount','$stuparentcontact','$password','$nstuaddress','$admtype','$msg_type',
						'$rte','$religion','$caste','$category','$bldgrp','$lang','$aadhar','$img1','$birth_place','$village','$fqualification','$mqualification','$foccupation','$moccupation',
						'$fannual_income','$dependent','$guardians','$nationality','$subcaste','$other_language','$npresent_address',
						'$previous_school','$f_aadhar','$m_aadhar','$bank_acc','$ifsc','$branch','$bus_facility','0','$admission_id', now(),now())";	
						
						
						if(mysqli_query($con,$query))
						{
							
						$stuid = mysqli_insert_id($con);
						 $ssql1="INSERT INTO `student_records`(`stu_id`, `class_id`, `section_id`,`session`,`create_at`, `modify_at`) VALUES ('$stuid','$stuclass','$stusection','$session',now(),now())";
						$query3 = mysqli_query($con,$ssql1);
						if($query3){

								if($FeeAssignNo>0){
								
								$query2 = mysqli_query($con,"insert into student_wise_fees (student_id,class_id,section_id,fee_header_id,
								fee_amount,due_amount,no_of_months,fee_start_month,session,create_date,modify_date) 
								values ('$stuid','$stuclass','$stusection','$feeids','$feeamts','$DueStu_Amount','$St_wise_months',$fee_start_month,'$session','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
								}
								if(!empty($admission_id)){
									$AddSql="UPDATE `admission` SET student_id='$stuid' , `status`='4' , `modify_date`=now() where `admission_id`='$admission_id'		 ";
									mysqli_query($con,$AddSql);
								}
								
					  }

						
						
						mkdir("images/student/$regisnumber_img");
						move_uploaded_file($_FILES['file1']['tmp_name'],"images/student/$regisnumber_img/".$_FILES['file1']['name']);
						}
					}
				
						// $err="<span id='err_successful'>[ Student Added Successfully ]</span>";
					if($query3){
						$responce['type']='SUCCESS';
						$responce['message']=' Student Added Successfully';
						echo json_encode($responce);
					}else{
						$responce['type']='ERROR';
						$responce['message']='Something error'.mysqli_error($con);
						echo json_encode($responce);

				  }
				}
			
			}
			else
			{
				// echo "<script>alert('Cannot Add Students to this Class. First Add Fees to the Class.')</script>";
				    $responce['type']='ADD_FEE';
						$responce['message']=' Cannot Add Students to this Class. First Add Fees to the Class.';
						echo json_encode($responce);
			}
		}
		else
		{
			// echo "<script>alert('Cannot Add more than $tstu Students.')</script>";
			      $responce['type']='MAX_STU';
						$responce['message']='Cannot Add more than '.$tstu.' Students.';
						echo json_encode($responce);
		}	

}
if(isset($_POST['update_student'])){
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	// echo "</pre>"; die;
		date_default_timezone_set("Asia/Kolkata");

	$regisno=mysqli_real_escape_string($con,$_POST['regisnumber']);
	$nstuname=mysqli_real_escape_string($con,$_POST['nstuname']);
	$sid=mysqli_real_escape_string($con,$_POST['sid']);
	$simg=mysqli_real_escape_string($con,$_POST['old_image']);
	$nstufname=mysqli_real_escape_string($con,$_POST['nstufname']);
	$nstumname=mysqli_real_escape_string($con,$_POST['nstumname']);
	$gender=mysqli_real_escape_string($con,$_POST['gender']);
	$ndob=mysqli_real_escape_string($con,$_POST['ndob']);
	$nadmissiondate=mysqli_real_escape_string($con,$_POST['nadmissiondate']);
	$nstucontact=mysqli_real_escape_string($con,$_POST['nstucontact']);
	$stuclass=mysqli_real_escape_string($con,$_POST['stuclass']);
	$stusection=mysqli_real_escape_string($con,$_POST['stusection']);
	$nstuparentcontact=mysqli_real_escape_string($con,$_POST['nstuparentcontact']);
	$npassword=mysqli_real_escape_string($con,$_POST['npassword']);
	$stuaddress=mysqli_real_escape_string($con,$_POST['stuaddress']);
	$present_address=mysqli_real_escape_string($con,$_POST['present_address']);
	$unewadm=mysqli_real_escape_string($con,$_POST['unewadm']);
	$msg_type=mysqli_real_escape_string($con,$_POST['msg_type']);
	$academic_year=mysqli_real_escape_string($con,$_POST['academic_year']);
	$nnationality=mysqli_real_escape_string($con,$_POST['nnationality']);
	$rte=mysqli_real_escape_string($con,$_POST['rte']);
	$religion=mysqli_real_escape_string($con,$_POST['religion']);
	$caste=mysqli_real_escape_string($con,$_POST['caste']);
	$category=mysqli_real_escape_string($con,$_POST['category']);
	$bldgrp=mysqli_real_escape_string($con,$_POST['bldgrp']);
	$lang=mysqli_real_escape_string($con,$_POST['lang']);

	$aadhar=mysqli_real_escape_string($con,$_POST['aadhar']);
	$birth_place=mysqli_real_escape_string($con,$_POST['birth_place']);
	$village=mysqli_real_escape_string($con,$_POST['village']);
	$fqualification=mysqli_real_escape_string($con,$_POST['fqualification']);
	$mqualification=mysqli_real_escape_string($con,$_POST['mqualification']);
	$foccupation=mysqli_real_escape_string($con,$_POST['foccupation']);
	$moccupation=mysqli_real_escape_string($con,$_POST['moccupation']);
	$fannual_income=mysqli_real_escape_string($con,$_POST['fannual_income']);
	$dependent=mysqli_real_escape_string($con,$_POST['dependent']);
	$guardians=mysqli_real_escape_string($con,$_POST['guardians']);
	$subcaste=mysqli_real_escape_string($con,$_POST['subcaste']);
	$other_language=mysqli_real_escape_string($con,$_POST['other_language']);
	$previous_school=mysqli_real_escape_string($con,$_POST['previous_school']);
	$f_aadhar=mysqli_real_escape_string($con,$_POST['f_aadhar']);
	$m_aadhar=mysqli_real_escape_string($con,$_POST['m_aadhar']);
	$bank_acc=mysqli_real_escape_string($con,$_POST['bank_acc']);
	$ifsc=mysqli_real_escape_string($con,$_POST['ifsc']);
	$branch=mysqli_real_escape_string($con,$_POST['branch']);
	$bus_facility=mysqli_real_escape_string($con,$_POST['bus_facility']);
	$roll_no=mysqli_real_escape_string($con,$_POST['roll_no']);
	$responce=array();
	
	if(!empty($roll_no)){
   $rsql="select `roll_no` from `student_records` where class_id='$stuclass' and section_id='$stusection' and session='".$_SESSION['session']."' and roll_no='$roll_no'  and stu_id!='$sid'";
   $rquery=mysqli_query($con,$rsql);
    if(mysqli_num_rows($rquery)>0 ){
   	    $responce['type']='ROLL_ERROR';   
				$responce['message']="This Roll no is Already assign in this Class";
				echo json_encode($responce); die;
				$res_arr[]="This Roll no is Already assign Please Try Again";
    }
  }else{
  	$roll_no=0;
  }  


    if(!isset($res_arr)){

			$img1=$_FILES['file1']['name'];
			$regisnumber_img=str_replace('/','-',$regisno);

			

			$nstuaddress = mysqli_real_escape_string($con, $_POST['stuaddress']);

			$npresent_address = mysqli_real_escape_string($con, $_POST['present_address']);

					
// class_id='$stuclass',section_id='$stusection',
			if($img1==""){
				 $sql1="update students set student_name='$nstuname',father_name='$nstufname',

				mother_name='$nstumname',gender='$gender',dob='$ndob',admission_date='$nadmissiondate',

				student_contact='$nstucontact',parent_no='$nstuparentcontact',

				password='$npassword',stuaddress='$nstuaddress',adm_type_id='$unewadm',msg_type_id='$msg_type',admin_rte='$rte',

				religion_id='$religion',caste='$caste',soc_cat_id='$category',blood_grp='$bldgrp',mother_tongue='$lang', 

				aadhar_card='$aadhar',birth_place='$birth_place',village='$village',fqualification='$fqualification',

				mqualification='$mqualification',foccupation='$foccupation',moccupation='$moccupation',

				fannual_income='$fannual_income',dependents='$dependent',guardians='$guardians',nationality='$nnationality',

				subcaste='$subcaste',other_language='$other_language',present_address='$npresent_address',

				previous_school='$previous_school',father_aadhar='$f_aadhar',mother_aadhar='$m_aadhar',student_bankacc='$bank_acc',

				ifsc_code='$ifsc',branch='$branch',bus_facility='$bus_facility',modify_date=now() where student_id='$sid'";
				

				$query=mysqli_query($con,$sql1);

				

				if($query)

				{
					$usql="UPDATE `student_records` SET `class_id`='$stuclass',`section_id`='$stusection',`roll_no`='$roll_no',`modify_at`=now() WHERE stu_id='$sid' and session='".$_SESSION['session']."' ";
					$uquery=mysqli_query($con,$usql);
					$responce['type']='SUCCESS';
					$responce['message']="Student Details Updated Successfully.";
					echo json_encode($responce);

				}else{
					$responce['type']='ERROR';
					$responce['message']="Something Went Wrong Please Try Again.".mysqli_error($con);
					echo json_encode($responce);

				}
			}else{

				if(file_exists("images/student/".$regisnumber_img))

				{

// class_id='$stuclass',section_id='$stusection',roll_no='$roll_no',
					$query=mysqli_query($con,"update students set student_name='$nstuname',father_name='$nstufname',

					mother_name='$nstumname',gender='$gender',dob='$ndob',admission_date='$nadmissiondate',

					student_contact='$nstucontact',parent_no='$nstuparentcontact',

					password='$npassword',stuaddress='$nstuaddress',adm_type_id='$unewadm',msg_type_id='$msg_type',

					admin_rte='$rte',religion_id='$religion',caste='$caste',soc_cat_id='$category',blood_grp='$bldgrp',

					mother_tongue='$lang',aadhar_card='$aadhar',stu_image='$img1',birth_place='$birth_place',village='$village',

					fqualification='$fqualification',mqualification='$mqualification',foccupation='$foccupation',

					moccupation='$moccupation',fannual_income='$fannual_income',dependents='$dependent',guardians='$guardians',

					nationality='$nnationality',subcaste='$subcaste',other_language='$other_language',

					present_address='$npresent_address',previous_school='$previous_school',father_aadhar='$f_aadhar',

					mother_aadhar='$m_aadhar',student_bankacc='$bank_acc',ifsc_code='$ifsc',branch='$branch',

					bus_facility='$bus_facility',modify_date=now() where student_id='$sid'");

					

					unlink("images/student/$regisnumber_img/$simg");

					move_uploaded_file($_FILES['file1']['tmp_name'],"images/student/$regisnumber_img/".$_FILES['file1']['name']);

					

					if($query)

					{

					$usql="UPDATE `student_records` SET `class_id`='$stuclass',`section_id`='$stusection',`roll_no`='$roll_no',`modify_at`=now() WHERE stu_id='$sid' and session='".$_SESSION['session']."' ";
					$uquery=mysqli_query($con,$usql);
					$responce['type']='SUCCESS';
					$responce['message']="Student Details Updated Successfully.";
					echo json_encode($responce);

						// echo "<script>window.location='dashboard.php?option=update_students&usid=$sid'</script>";

					}else{
						$responce['type']='ERROR';
					$responce['message']="Something Went Wrong Please Try Again".mysqli_error($con);
					echo json_encode($responce);


					}
				}

				else

				{

				

					$query=mysqli_query($con,"update students set student_name='$nstuname',father_name='$nstufname',

					mother_name='$nstumname',gender='$gender',dob='$ndob',admission_date='$nadmissiondate',

					student_contact='$nstucontact',parent_no='$nstuparentcontact',

					password='$npassword',stuaddress='$nstuaddress',adm_type_id='$unewadm',msg_type_id='$msg_type',

					admin_rte='$rte',religion_id='$religion',caste='$caste',soc_cat_id='$category',blood_grp='$bldgrp',

					mother_tongue='$lang',aadhar_card='$aadhar',stu_image='$img1',birth_place='$birth_place',village='$village',

					fqualification='$fqualification',mqualification='$mqualification',foccupation='$foccupation',

					moccupation='$moccupation',fannual_income='$fannual_income',dependents='$dependent',guardians='$guardians',

					nationality='$nnationality',subcaste='$subcaste',other_language='$other_language',

					present_address='$npresent_address',previous_school='$previous_school',father_aadhar='$f_aadhar',

					mother_aadhar='$m_aadhar',student_bankacc='$bank_acc',ifsc_code='$ifsc',branch='$branch',

					bus_facility='$bus_facility',modify_date=now() where student_id='$sid'");

					

					mkdir("images/student/$regisnumber_img");

					move_uploaded_file($_FILES['file1']['tmp_name'],"images/student/$regisnumber_img/".$_FILES['file1']['name']);

					

					if($query)

					{

					$usql="UPDATE `student_records` SET `class_id`='$stuclass',`section_id`='$stusection',`roll_no`='$roll_no',`modify_at`=now() WHERE stu_id='$sid' and session='".$_SESSION['session']."' ";
					$uquery=mysqli_query($con,$usql);
					$responce['type']='SUCCESS';
					$responce['message']="Student Details Updated Successfully.";
					echo json_encode($responce);

						// echo "<script>window.location='dashboard.php?option=update_students&usid=$sid'</script>";

					}else{
						$responce['type']='ERROR';
					$responce['message']="Something Went Wrong Please Try Again".mysqli_error($con);
					echo json_encode($responce);

					}
				}//else
			}//else
		}//error isset	
	}


if(isset($_POST["Add_Expense"])){

	date_default_timezone_set("Asia/Kolkata");
  $expensetype=mysqli_real_escape_string($con,$_POST['expensetype']);
  $expdetail=mysqli_real_escape_string($con,$_POST['expdetail']);
  $amount=mysqli_real_escape_string($con,$_POST['amount']);
  $poc=mysqli_real_escape_string($con,$_POST['poc']);
  $issdate=mysqli_real_escape_string($con,$_POST['issdate']);
  
   $roles=mysqli_real_escape_string($con,$_POST['roles']);
  $panelid=mysqli_real_escape_string($con,$_POST['panelid']);
  $menuid=mysqli_real_escape_string($con,$_POST['menuid']);
  $submenuname=mysqli_real_escape_string($con,$_POST['submenuname']);
  $machinename=mysqli_real_escape_string($con,$_POST['machinename']);
  $ExactBrowserNameBR=mysqli_real_escape_string($con,$_POST['ExactBrowserNameBR']);
  $currdt=mysqli_real_escape_string($con,$_POST['currdt']);

	

			$qe = mysqli_query($con,"select * from expense_type where expense_type_id ='$expensetype'");

			$re = mysqli_fetch_array($qe);

			$expname = $re['expense_type_name'];



			$file=$_FILES['proofs']['name'];

			

			if($file=="")

			{

			$query=$con->query("insert into expense (expense_type_id,expense_details,amount,proofs,point_of_contact,expensed_datetime,date,status,session,modify_date)

			values('$expensetype','$expdetail',$amount,'','$poc','$issdate',now(),'0','".$_SESSION['session']."',now())");	

			

			if(mysqli_error($con)){
			// echo("Error description1: " . mysqli_error($con));
			      $responce['type']='ERROR';
						$responce['message']="Error description1: " . mysqli_error($con);
						echo json_encode($responce);

			}

			

			if($query)

			{

				$action = "Expense for ".$expname." is Added"; 
				 $sql2="insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

				machine_name,browser,date)values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')";

				$q1 = mysqli_query($con,$sql2);

				

				// $err="<span id='err_successful'>[ Expense Add Successfully ]</span>";
				$responce['type']='SUCCESS';
				$responce['message']="Expense Add Successfully ";
				echo json_encode($responce);

			}

			}

			else

			{
				$name=explode('.',$_FILES['proofs']['name']);
		    $ext=pathinfo($_FILES['proofs']['name'],PATHINFO_EXTENSION);
		    $image_name=$name[0].date("-Ymd-His").'.'.$ext;

			$query="insert into expense (expense_type_id,expense_details,amount,proofs,point_of_contact,expensed_datetime,date,status,session,modify_date)		values('$expensetype','$expdetail',$amount,'$image_name','$poc','$issdate',now(),'0','".$_SESSION['session']."',now())";	

			

			if(mysqli_query($con,$query))

			{

				$action = "Expense for ".$expname." is Added"; 

				$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

				machine_name,browser,date) 

				values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

			

				move_uploaded_file($_FILES['proofs']['tmp_name'],"images/proof/".$image_name);

				// $err="<span id='err_successful'>[ Expense Add Successfully ]</span>";
				$responce['type']='SUCCESS';
				$responce['message']="Expense Add Successfully ";
				echo json_encode($responce);

				

			}	

			}

	}
if(isset($_POST['Update_Expense'])){

		date_default_timezone_set("Asia/Kolkata");
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
  $expensetype=mysqli_real_escape_string($con,$_POST['expensetype']);
  $expdetail=mysqli_real_escape_string($con,$_POST['expdetail']);
  $eid=mysqli_real_escape_string($con,$_POST['eid']);
  $amount=mysqli_real_escape_string($con,$_POST['amount']);
  $poc=mysqli_real_escape_string($con,$_POST['poc']);
  $issdate=mysqli_real_escape_string($con,$_POST['issdate']);
// die;
	$dt=$issdate;

	$newdt=date("Y-m-d",strtotime($dt));

	$pic=$_FILES['proofs']['name'];

	

	$qe = mysqli_query($con,"select * from expense_type where expense_type_id ='$expensetype'");

	$re = mysqli_fetch_array($qe);

	$expname = $re['expense_type_name'];

		

	if ($pic=="")

	{

		$qe = mysqli_query($con,"select * from expense_type where expense_type_id ='$expensetype'");

		$re = mysqli_fetch_array($qe);

		$expname = $re['expense_type_name'];

			

		 $que1="update expense set expense_type_id='$expensetype', expense_details='$expdetail',

		amount='$amount',point_of_contact='$poc',expensed_datetime='$issdate',modify_date=now() 

		where expense_id='$eid'";

		if(mysqli_query($con,$que1))

		{

			$action = "Expense for ".$expname." is edited"; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

			machine_name,browser,date) 

			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

			// echo "<script>window.location='dashboard.php?option=view_expense'</script>";
		    $responce['type']='SUCCESS';
				$responce['message']="Expense Updated Successfully ";
				echo json_encode($responce);

		}else{

		    $responce['type']='FAILED';
				$responce['message']="Something Went Wrong Please Try Again";
				echo json_encode($responce);

		}

	}else{

		 $name=explode('.',$_FILES['proofs']['name']);
		$ext=pathinfo($_FILES['proofs']['name'],PATHINFO_EXTENSION);
		$image_name=$name[0].date("-Ymd-His").'.'.$ext;

		if(move_uploaded_file($_FILES['proofs']['tmp_name'],"images/proof/".$image_name)){

		$que1="update expense set expense_type_id='$expensetype', expense_details='$expdetail',

		amount='$amount',proofs='$image_name',point_of_contact='$poc',expensed_datetime='$issdate',

		date='$newdt' where expense_id='$eid'";

		unlink ("images/proof/$oldproof");

		if(mysqli_query($con,$que1))

		{

			$action = "Expense for ".$expname." is edited"; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

			machine_name,browser,date) 

			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

			  $responce['type']='SUCCESS';
				$responce['message']="Expense Updated Successfully ";
				echo json_encode($responce);

		}else{
			  $responce['type']='FAILED';
				$responce['message']="Something Went Wrong Please Try Again";
				echo json_encode($responce);

		}
	}else{
				$responce['type']='Img_error';
				$responce['message']="Problem On Image Uploading ";
				echo json_encode($responce); 
	}		
		// echo "<script>window.location='dashboard.php?option=view_expense'</script>";
	}
}

if(isset($_POST['add_staff'])){

	date_default_timezone_set("Asia/Kolkata");
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	// echo "</pre>";
  $name=mysqli_real_escape_string($con,$_POST['name']);
  $staffid=mysqli_real_escape_string($con,$_POST['staffid']);
  $gender=mysqli_real_escape_string($con,$_POST['gender']);
  $address=mysqli_real_escape_string($con,$_POST['address']);
  $mobno=mysqli_real_escape_string($con,$_POST['mobno']);
  $password=mysqli_real_escape_string($con,$_POST['password']);
  $altmobno=mysqli_real_escape_string($con,$_POST['altmobno']);
  $qualification=mysqli_real_escape_string($con,$_POST['qualification']);
  $skills=mysqli_real_escape_string($con,$_POST['skills']);
  $teachtype=mysqli_real_escape_string($con,$_POST['teachtype']);
  $others=mysqli_real_escape_string($con,$_POST['others']);
  $joindate=mysqli_real_escape_string($con,$_POST['joindate']);
  $designation=mysqli_real_escape_string($con,$_POST['designation']);
  $msg_type=mysqli_real_escape_string($con,$_POST['msg_type']);
  $aadharno=mysqli_real_escape_string($con,$_POST['aadharno']);
  $caste=mysqli_real_escape_string($con,$_POST['caste']);
  $session=$_SESSION['session'];

  $roles=mysqli_real_escape_string($con,$_POST['roles']);
  $panelid=mysqli_real_escape_string($con,$_POST['panelid']);
  $menuid=mysqli_real_escape_string($con,$_POST['menuid']);
  $submenuname=mysqli_real_escape_string($con,$_POST['submenuname']);
  $machinename=mysqli_real_escape_string($con,$_POST['machinename']);
  $ExactBrowserNameBR=mysqli_real_escape_string($con,$_POST['ExactBrowserNameBR']);
  $currdt=mysqli_real_escape_string($con,$_POST['currdt']);





		$q = mysqli_query($con,"select * from staff where staff_id='$staffid'");

		// $row = mysqli_num_rows($q);

		if(mysqli_num_rows($q) > 0)

		{
			// $err = "<span id='err_notsuccessful'>[ This Staff Already Exists ]</span>";
			$responce['type']='ALREADY';
			$responce['message']="This Staff Already Exists  ";
			echo json_encode($responce);die;

		}else{

			

			$image=$_FILES['propic']['name'];

			$resu=$_FILES['resume']['name'];

			//

			if(!empty($image)){
			  $namei=explode('.',$_FILES['propic']['name']);
		    $ext=pathinfo($_FILES['propic']['name'],PATHINFO_EXTENSION);
		    $image=$namei[0].date("Ymd-His").'.'.$ext;

				
			}

			if(!empty($resu)){

				$namer=explode('.',$_FILES['resume']['name']);
		    $ext=pathinfo($_FILES['resume']['name'],PATHINFO_EXTENSION);
		    $resu=$namer[0].date("Ymd-His").'.'.$ext;

			}

			$staffid_img=str_replace('/','-',$staffid);
			// $staffid_img=$staffid;
		

			if($teachtype=="Others")

			{

				if($image=="" and $resu=="")  //if both empty

				{

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,teaching_type_other,skills,joining_date,designation,msg_type_id,aadharno,caste,status,session,create_date,modify_date ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$others',

					'$skills','$joindate','$designation','$msg_type','$aadharno','$caste','1','$session',now(),now())";

					

					// $err="<span id='err_successful'>[ Staff Added Successfully ]</span>";
					// $responce['type']='SUCCESS';
			    // $responce['message']="Staff Added Successfully  ";
			    // echo json_encode($responce);

				}elseif($image==""){

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,teaching_type_other,skills,joining_date,designation,msg_type_id,aadharno,caste,resume,status,session,create_date,modify_date  ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$others',

					'$skills','$joindate','$designation','$msg_type','$aadharno','$caste','$resu','1','$session',now(),now())";

					

					mkdir("staff/$staffid_img");

					move_uploaded_file($_FILES['resume']['tmp_name'],"staff/$staffid_img/".$resu);

					/*if($query){

						// $err="<span id='err_successful'>[ Staff Added Successfully ]</span>";
						$responce['type']='SUCCESS';
			      $responce['message']="Staff Added Successfully  ";
			      echo json_encode($responce);

					}else{
						$responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);

					}*/

				}

				elseif($resu=="")

				{

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,teaching_type_other,skills,joining_date,designation,msg_type_id,aadharno,caste,image,status,session,create_date,modify_date  ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$others',

					'$skills','$joindate','$designation','$msg_type','$aadharno','$caste','$image','1','$session',now(),now())";

					

					mkdir("staff/$staffid_img");

					move_uploaded_file($_FILES['propic']['tmp_name'],"staff/$staffid_img/".$image);

					/*if($query){

						// $err="<span id='err_successful'>[ Staff Added Successfully ]</span>";
						$responce['type']='SUCCESS';
			      $responce['message']="Staff Added Successfully  ";
			      echo json_encode($responce);

					}else{
						$responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);

					}*/

				}elseif($image!="" and $resu!=""){  //if both image upload

				

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,teaching_type_other,skills,joining_date,designation,msg_type_id,aadharno,caste,image,resume,status,session,create_date,modify_date  ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$others',

					'$skills','$joindate','$designation','$msg_type','$aadharno','$caste','$image','$resu','1','$session',now(),now())";

					

					mkdir("staff/$staffid_img");

					move_uploaded_file($_FILES['propic']['tmp_name'],"staff/$staffid_img/".$image);

					move_uploaded_file($_FILES['resume']['tmp_name'],"staff/$staffid_img/".$resu);

					/*if($query)

					{

						// $err="<span id='err_successful'>[ Staff Added Successfully ]</span>";
						$responce['type']='SUCCESS';
			      $responce['message']="Staff Added Successfully  ";
			      echo json_encode($responce);

					}else{
						$responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);

					}*/

				}

				

				if(mysqli_query($con,$query)){

					$action = "Staff ".$name." is Added"; 

					$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

					machine_name,browser,date) 

					values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
					  $responce['type']='SUCCESS';
			      $responce['message']="Staff Added Successfully  ";
			      echo json_encode($responce);

				}else{
						$responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again".mysqli_error($con);
			      echo json_encode($responce);

				}

			}else{  //if others not

				if($image=="" and $resu=="")

				{

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,skills,joining_date,designation,msg_type_id,aadharno,caste,status,session,create_date,modify_date  ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$skills',

					'$joindate','$designation','$msg_type','$aadharno','$caste','1','$session',now(),now())";

					

					$err="<span id='err_successful'>[ Staff Added Successfully ]</span>";

				}			

				elseif($image==""){

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,skills,joining_date,designation,msg_type_id,aadharno,caste,resume,status,session,create_date,modify_date  ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$skills',

					'$joindate','$designation','$msg_type','$aadharno','$caste','$resu','1','$session',now(),now())";

					

					mkdir("staff/$staffid_img");

					move_uploaded_file($_FILES['resume']['tmp_name'],"staff/$staffid_img/".$resu);

					// if($query)

					// {

					// 	$err="<span id='err_successful'>[ Staff Added Successfully ]</span>";

					// }

				}elseif($resu==""){

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,skills,joining_date,designation,msg_type_id,aadharno,caste,image,status,session,create_date,modify_date  ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$skills',

					'$joindate','$designation','$msg_type','$aadharno','$caste','$image','1','$session',now(),now())";

					

					mkdir("staff/$staffid_img");

					move_uploaded_file($_FILES['propic']['tmp_name'],"staff/$staffid_img/".$image);

					// if($query)

					// {

					// 	$err="<span id='err_successful'>[ Staff Added Successfully ]</span>";

					// }

				}

				elseif($image!="" and $resu!="")  

				{

					$query="insert into staff (staff_name,staff_id,gender,mobno,password,alt_mobno,address,qualification,

					teaching_type,skills,joining_date,designation,msg_type_id,aadharno,caste,image,resume,status,session ,create_date,modify_date ) 

					values ('$name','$staffid','$gender','$mobno','$password','$altmobno','$address','$qualification','$teachtype','$skills',

					'$joindate','$designation','$msg_type','$aadharno','$caste','$image','$resu','1','$session',now(),now())";

					

					mkdir("staff/$staffid_img");

					move_uploaded_file($_FILES['propic']['tmp_name'],"staff/$staffid_img/".$image);

					move_uploaded_file($_FILES['resume']['tmp_name'],"staff/$staffid_img/".$resu);

					// if($query)

					// {

					// 	$err="<span id='err_successful'>[ Staff Added Successfully ]</span>";

					// }

				}	



				if(mysqli_query($con,$query))

				{

					$action = "Staff ".$name." is Added"; 

					$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

					machine_name,browser,date) 

					values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

					  $responce['type']='SUCCESS';
			      $responce['message']="Staff Added Successfully  ";
			      echo json_encode($responce);

				}else{
					  $responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again".mysqli_error($con);
			      echo json_encode($responce);
				}

			}
		}
}

if(isset($_POST['update_staff'])){
	date_default_timezone_set("Asia/Kolkata");
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	// echo "</pre>";
	$stid=mysqli_real_escape_string($con,$_POST['stid']);
	$nname=mysqli_real_escape_string($con,$_POST['nname']);
  $nstaffid=mysqli_real_escape_string($con,$_POST['nstaffid']);
  $ngender=mysqli_real_escape_string($con,$_POST['ngender']);
  $naddress=mysqli_real_escape_string($con,$_POST['naddress']);
  $nmobno=mysqli_real_escape_string($con,$_POST['nmobno']);
  $npassword=mysqli_real_escape_string($con,$_POST['npassword']);
  $naltmobno=mysqli_real_escape_string($con,$_POST['naltmobno']);
  $nqualification=mysqli_real_escape_string($con,$_POST['nqualification']);
  $nskills=mysqli_real_escape_string($con,$_POST['nskills']);
  $nteachtype=mysqli_real_escape_string($con,$_POST['nteachtype']);
  $nothers=mysqli_real_escape_string($con,$_POST['nothers']);
  $njoindate=mysqli_real_escape_string($con,$_POST['njoindate']);
  $ndesignation=mysqli_real_escape_string($con,$_POST['ndesignation']);
  $msg_type=mysqli_real_escape_string($con,$_POST['msg_type']);
  $naadharno=mysqli_real_escape_string($con,$_POST['naadharno']);
  $ncaste=mysqli_real_escape_string($con,$_POST['ncaste']);

  $roles=mysqli_real_escape_string($con,$_POST['roles']);
  $panelid=mysqli_real_escape_string($con,$_POST['panelid']);
  $menuid=mysqli_real_escape_string($con,$_POST['menuid']);
  $submenuname=mysqli_real_escape_string($con,$_POST['submenuname']);
  $machinename=mysqli_real_escape_string($con,$_POST['machinename']);
  $ExactBrowserNameBR=mysqli_real_escape_string($con,$_POST['ExactBrowserNameBR']);
  $currdt=mysqli_real_escape_string($con,$_POST['currdt']);


	if($nteachtype=="Others")

	{

		$query="update staff set staff_name='$nname',gender='$ngender',

		mobno='$nmobno',password='$npassword',alt_mobno='$naltmobno',address='$naddress',qualification='$nqualification',

		skills='$nskills',teaching_type='$nteachtype',teaching_type_other='$nothers',joining_date='$njoindate',

		designation='$ndesignation',msg_type_id='$msg_type',aadharno='$naadharno',caste='$ncaste',modify_date=now() where st_id='$stid'";

	}		

	else{

		$query="update staff set staff_name='$nname',gender='$ngender',

		mobno='$nmobno',password='$npassword',alt_mobno='$naltmobno',address='$naddress',qualification='$nqualification',

		skills='$nskills',teaching_type='$nteachtype',teaching_type_other='',joining_date='$njoindate',

		designation='$ndesignation',msg_type_id='$msg_type',aadharno='$naadharno',caste='$ncaste',modify_date=now() where st_id='$stid'";

	}

		if(mysqli_query($con,$query)){

			$action = "Staff ".$nname." Details is edited"; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

			machine_name,browser,date) 

			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

			      $responce['type']='SUCCESS';
			      $responce['message']="Staff Updated Successfully  ";
			      echo json_encode($responce);

		}else{
				    $responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);
		}
		// echo "<script>window.location='dashboard.php?option=view_staff&smid=15'</script>";	

}

if(isset($_POST['online_addmission'])){
	date_default_timezone_set("Asia/Kolkata");
	// echo "<pre>";
	// print_r($_POST);
	// print_r($_FILES);
	// echo "</pre>";
	// $stid=mysqli_real_escape_string($con,$_POST['stid']);
	$name=mysqli_real_escape_string($con,$_POST['name']);
  $fathername=mysqli_real_escape_string($con,$_POST['fathername']);
  $gender=mysqli_real_escape_string($con,$_POST['gender']);
  $dob=mysqli_real_escape_string($con,$_POST['dob']);
  $age=mysqli_real_escape_string($con,$_POST['age']);
  $email=mysqli_real_escape_string($con,$_POST['email']);
  $phone=mysqli_real_escape_string($con,$_POST['phone']);
  $aadhar=mysqli_real_escape_string($con,$_POST['aadhar']);
  $qualification=mysqli_real_escape_string($con,$_POST['qualification']);
  $grade=mysqli_real_escape_string($con,$_POST['grade']);
  $address=mysqli_real_escape_string($con,$_POST['address']);
  $city=mysqli_real_escape_string($con,$_POST['city']);
  $state=mysqli_real_escape_string($con,$_POST['state']);
  $pincode=mysqli_real_escape_string($con,$_POST['pincode']);
  $religion=mysqli_real_escape_string($con,$_POST['religion']);
  $caste=mysqli_real_escape_string($con,$_POST['caste']);
  $category=mysqli_real_escape_string($con,$_POST['category']);
  $previous_school=mysqli_real_escape_string($con,$_POST['previous_school']);
  $previous_grade=mysqli_real_escape_string($con,$_POST['previous_grade']);
  $previous_result=mysqli_real_escape_string($con,$_POST['previous_result']);
  $previous_percentage=mysqli_real_escape_string($con,$_POST['previous_percentage']);
  

	$que = mysqli_query($con,"select * from admission order by admission_id desc limit 1");

	$row = mysqli_num_rows($que);

	if($row)

	{

		$res = mysqli_fetch_array($que);
		// $refno = $res['reference_no'];

		$refno = substr($res['reference_no'], 3); 

		//$nrefno = preg_split('#(?=\d)(?<=[a-z])#i', "$refno");

		$nerefno =$refno;
		$nerefno++;

		$newrefno = "ref".$nerefno;
	}

	else{

		$newrefno = "ref"."1";

	}	
	$q1 = mysqli_query($con,"insert into admission (reference_no,name,fathername,gender,dob,age,email,phone,aadhar,qualification,grade,

	address,city,state,pincode,religion,caste,category,previous_school,previous_grade,previous_result,previous_percentage,apply_date,modify_date,session) 
	values ('$newrefno','$name','$fathername','$gender','$dob','$age','$email','$phone','$aadhar','$qualification','$grade','$address',

	'$city','$state','$pincode','$religion','$caste','$category','$previous_school','$previous_grade','$previous_result',

	'$previous_percentage',now(),now(),'".$_SESSION['session']."')");	

	
  if($q1){

			$sset=mysqli_query($con,"select * from setting");

			$rsset=mysqli_fetch_array($sset);

			$sclname=$rsset['company_name'];

			$q1 = mysqli_query($con,"select * from class where class_id='$grade'");

			$r1 = mysqli_fetch_array($q1);

			$clsname = $r1['class_name'];

			$msg = "Dear ".$name.",%0aThanks for showing interest for the Admission of ".$clsname.", Please find the reference number "

					.$refno.", Once we short listed, we will call for Admission.%0aRegards,%0a".$sclname;

			$messagetype="online_addmission";

			sendwhatsappMessage($phone, $msg, $messagetype);
			
			// sendtextMessage($phone, $msg, $messagetype);

		// echo "<script>alert('Online Admission Request Sucessfully')</script>";
			      $responce['type']='SUCCESS';
			      $responce['message']="Form Submitted Successfully  ";
			      echo json_encode($responce);
	}else{
						$responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);
	}
		

}
if(isset($_POST['add_driver'])){

		date_default_timezone_set('Asia/Kolkata');
		// echo "<pre>";
	  // print_r($_POST);
	  // print_r($_FILES);
	  // echo "</pre>";
	  $name=mysqli_real_escape_string($con,$_POST['name']);
	  $fathername=mysqli_real_escape_string($con,$_POST['fathername']);
	  $gender=mysqli_real_escape_string($con,$_POST['gender']);
	  $mobno=mysqli_real_escape_string($con,$_POST['mobno']);
	  $altmobno=mysqli_real_escape_string($con,$_POST['altmobno']);
	  $address=mysqli_real_escape_string($con,$_POST['address']);
	  $city=mysqli_real_escape_string($con,$_POST['city']);
	  $designation=mysqli_real_escape_string($con,$_POST['designation']);
	  $experience=mysqli_real_escape_string($con,$_POST['experience']);
	  $dlno=mysqli_real_escape_string($con,$_POST['dlno']);
	  $aadharno=mysqli_real_escape_string($con,$_POST['aadharno']);
	  $preexp=mysqli_real_escape_string($con,$_POST['preexp']);
	  $description=mysqli_real_escape_string($con,$_POST['description']);

  
		$create_date=date('Y-m-d H:i:s');
	  $modify_date=$create_date;
	  $session=$_SESSION['session'];


		$name=ucwords($name);


		$query=mysqli_query($con,"insert into driver (name,father_name,gender,mobile,alternate_no,address,city,designation,

		experience,dlno,aadhar_no,previous_exp,description,status,date,modify_date,session) 

		values ('$name','$fathername','$gender','$mobno','$altmobno','$address','$city','$designation','$experience','$dlno',

		'$aadharno','$preexp','$description','0','$create_date','$modify_date','$session' ) ") ;
  if($query){

  		$messagetype="Add_driver";
  		$sset=mysqli_query($con,"select * from setting");
			$rsset=mysqli_fetch_array($sset);

			$sclname=$rsset['company_name'];
			$set=mysqli_query($con,"select * from sms_setting where sms_id=2 ");

			$rset=mysqli_fetch_array($set);

			$status=$rset['status'];
				$msg="Dear ".$name.",%0aNow you are appoint as a  ".ucwords($designation)." in our school on the basis of your experience .%0aSo, Now you can join with us and do your job well.%0aRegards%0a".$sclname."  ";		
				$nmsg="Dear ".$name.",<br>Now you are appoint as a  ".ucwords($designation)." in our school on the basis of your experience .<br>So, Now you can join with us and do your job well.<br>Regards<br>".$sclname."  ";		

			if($status==1){
							sendwhatsappMessage($mobno, $msg, $messagetype);

			}else{
						sendtextMessage($mobno, $nmsg, $messagetype);

			}


  		// $err="<span id='err_successful'>[ ".$name." ".$designation." Added Successfully ]</span>";
  		      $responce['type']='SUCCESS';
			      $responce['message']="".$name." ".$designation." Added Successfully";
			      echo json_encode($responce);

  }else{
  		// $err="<span id='err_successful' style='color:red;'>[ Something Wrong Please Try Again ]</span>";
  		      $responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);
  }

	}

	if(isset($_POST['update_driver'])){
		// date_default_timezone_set('Asia/Kolkata');
		// 	echo "<pre>";
	  // print_r($_POST);
	  // print_r($_FILES);
	  // echo "</pre>";
	  $name=mysqli_real_escape_string($con,$_POST['name']);
	  $did=mysqli_real_escape_string($con,$_POST['did']);
	  $fathername=mysqli_real_escape_string($con,$_POST['fathername']);
	  $gender=mysqli_real_escape_string($con,$_POST['gender']);
	  $mobno=mysqli_real_escape_string($con,$_POST['mobno']);
	  $altmobno=mysqli_real_escape_string($con,$_POST['altmobno']);
	  $address=mysqli_real_escape_string($con,$_POST['address']);
	  $city=mysqli_real_escape_string($con,$_POST['city']);
	  $designation=mysqli_real_escape_string($con,$_POST['designation']);
	  $experience=mysqli_real_escape_string($con,$_POST['experience']);
	  $dlno=mysqli_real_escape_string($con,$_POST['dlno']);
	  $aadharno=mysqli_real_escape_string($con,$_POST['aadharno']);
	  $preexp=mysqli_real_escape_string($con,$_POST['preexp']);
	  $description=mysqli_real_escape_string($con,$_POST['description']);
	  $status=mysqli_real_escape_string($con,$_POST['status']);
	  $modify_date=date('Y-m-d H:i:s');
	 
		$name=ucwords($name);
		$sql1="update driver set name='$name', father_name='$fathername', gender='$gender', mobile='$mobno', 

		alternate_no='$altmobno', address='$address', city='$city', designation='$designation', experience='$experience',

		dlno='$dlno', aadhar_no='$aadharno', previous_exp='$preexp', description='$description', status='$status', modify_date='$modify_date' where id='$did'";
		$query=mysqli_query($con,$sql1);	

		if($query){	

	        $messagetype="Update_driver";
  		    $sset=mysqli_query($con,"select * from setting");
			    $rsset=mysqli_fetch_array($sset);

			$sclname=$rsset['company_name'];
			$set=mysqli_query($con,"select * from sms_setting where sms_id=2 ");

			$rset=mysqli_fetch_array($set);

			$wstatus=$rset['status'];
				$msg="Dear ".$name.",%0aYour profile updated sucessfully.%0aRegards%0a".$sclname."  ";		
				$nmsg="Dear ".$name.",<br>Your profile updated sucessfully.<br>Regards<br>".$sclname."  ";		

			if($wstatus==1){
					sendwhatsappMessage($mobno, $msg, $messagetype);
			}else{
					sendtextMessage($mobno, $nmsg, $messagetype);

			}

		    // echo "<script>window.location='dashboard.php?option=view_driver'</script>";	
		        $responce['type']='SUCCESS';
			      $responce['message']="".$name." ".$designation." Updated Successfully";
			      echo json_encode($responce);

		}else{
			// $err="<span id='err_successful' style='color:red;'>[ Something Wrong Please Try Again ]</span>";
			      $responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);
		}

	}	
if(isset($_POST['update_sms_setting'])){

// 		echo "<pre>";
// print_r($_POST);
// echo "</pre>";

	$roles=mysqli_real_escape_string($con,$_POST['roles']);
  $panelid=mysqli_real_escape_string($con,$_POST['panelid']);
  $menuid=mysqli_real_escape_string($con,$_POST['menuid']);
  $submenuname=mysqli_real_escape_string($con,$_POST['submenuname']);
  $machinename=mysqli_real_escape_string($con,$_POST['machinename']);
  $ExactBrowserNameBR=mysqli_real_escape_string($con,$_POST['ExactBrowserNameBR']);
  $currdt=mysqli_real_escape_string($con,$_POST['currdt']);

  $Wsenderid=mysqli_real_escape_string($con,$_POST['Wsenderid']);
  $senderid=mysqli_real_escape_string($con,$_POST['senderid']);


		$type='';
		if(!empty($Wsenderid)){
			  $sqlsms=" AND sms_id=2";
		    $aid=$Wsenderid;
		    $type=" Whatsapp ";
		}elseif(!empty($senderid)){
			  $sqlsms=" AND sms_id=1";
			  $aid=$senderid;
			  $type="Text ";
		}

		$que="update sms_setting set `sender_id`='$aid',`work_status`='1' , `modify_date`='".date('Y-m-d H:i:s')."' where 1 $sqlsms  ";
		$query= mysqli_query($con,$que);

		 if($query)
			{
				// $err= "<span style='color:green;'><strong>[".$type." SMS Setting Updated Successfully ]</strong></span>";

				$action = "Sender ID $aid is updated."; 

				$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

				machine_name,browser,date) 

				values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");
				    $responce['type']='SUCCESS';
			      $responce['message']=" Updated Successfully";
			      echo json_encode($responce);

			}else{

				// $err= "<span style='color:red;'><strong>[ Something Wrong Please Try Again ]</strong></span>";
				    $responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);
			}

}

if(isset($_POST['WhatsappSms_limit'])){
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

  $limit=mysqli_real_escape_string($con,$_POST['Wlimit']);

	  $que="update `log_sms_count` set `count_sms`=(`count_sms` + '$limit' ) ,`limit`='$limit', `modify_date`='".date('Y-m-d H:i:s')."' where `id`='1'
		 ";
		$query= mysqli_query($con,$que);

		 if($query)
			{
				    $responce['type']='SUCCESS';
			      $responce['message']=" Whatsapp Limit Updated";
			      echo json_encode($responce);
			}else{
				    $responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);
			}
}

if(isset($_POST['TextSms_limit'])){
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

  $limit=mysqli_real_escape_string($con,$_POST['Tlimit']);

		$que="update `log_sms_count` set `count_sms`=(`count_sms` + '$limit' ) , `limit`='$limit', `modify_date`='".date('Y-m-d H:i:s')."' where `id`='2'
		 ";
		$query= mysqli_query($con,$que);

		 if($query)
			{
				    $responce['type']='SUCCESS';
			      $responce['message']=" Textsms Limit Updated ";
			      echo json_encode($responce);
			}else{
				    $responce['type']='FAILED';
				    $responce['message']="Something Went Wrong, Please Try Again";
			      echo json_encode($responce);
			}
}




if(isset($_POST['getsection_by_classid'])){
// echo "hello world";
	$classid=$_POST['classid'];

	$c=mysqli_query($con,"select * from section where class_id='$classid'");
	echo "<option value=''> All</option>";
	while($s_res=mysqli_fetch_array($c)){



	echo "<option value=".$s_res['section_id'].">". $s_res['section_name']." </option>";

}
}

if(isset($_POST['getAttendenceDetails'])){
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
$responce=array();
$classid=$_POST['classid'];
$sectionid=$_POST['sectionid'];
$fromdt=$_POST['fromdt'];
$todt=$_POST['todt'];
	$i=1;

	$present=0;

	$absent=0;

	$leave=0;

	$sql="select * from student_daily_attendance where 1 AND `session`= '".$_SESSION['session']."'  ";

	if(!empty($_POST['classid']) && !empty($_POST['sectionid']) ){

	 $sql.=" AND `class_id` ='".$classid."' AND `section_id`='".$sectionid."'  ";

	}else{
		$sql.=" AND `class_id` ='".$classid."' ";
	}

	// elseif(!empty($_POST['classid']) && empty($_POST['sectionid'])){
	//  $sql.=" AND `class_id` ='".$classid."' ";	
	// }

	if(!empty($_POST['fromdt']) &&  !empty($_POST['todt'])){
		$sql.=" AND date between '".$fromdt."' and '".$todt."' ";
	}

	if(!empty($_POST['fromdt']) && empty($_POST['todt'])){
		$sql.=" AND date='$fromdt' ";

	}
	// echo $sql;
	$query=mysqli_query($con,$sql);
	$rowcount=mysqli_num_rows($query);


	if($rowcount>0){
	while($res1=mysqli_fetch_assoc($query)){
		 $ndate=$res1['date'];

									 $chgdate=date('d-m-Y',strtotime($ndate));



									 $attend=$res1['type_of_attend'];
									 $student_id=$res1['student_id'];

									 if($attend==1){

										$present=$present+1; 

									 }elseif($attend==2){

										 $absent=$absent+1;

									 }elseif($attend==3)

									 {

										 $leave=$leave+1;

									 }

	}
		$percent = round(($present+$leave)/$rowcount*100,2)."%";		
							 
			$responce['type']='success';						 
			$responce['total']=$rowcount;						 
			$responce['present']=$present;						 
			$responce['absent']=$absent;						 
			$responce['leave']=$leave;	
			$responce['percent']=$percent;	

	
}else{
			$responce['total']=0;		
	    $responce['type']='success';
    	$responce['present']=0;						 
			$responce['absent']=0;						 
			$responce['leave']=0;	
			$responce['percent']=0;	

}
echo json_encode($responce);


}

if(isset($_POST['approve_Student'])){
	$admid=mysqli_real_escape_string($con,$_POST['id']);

 $sql="update admission set status='2', accept_decline_date=now(),modify_date=now() where admission_id='$admid'";
	$q1 = mysqli_query($con,$sql);	
	if($q1){
  		$responce['type']='success';						 
  		$responce['msg']='Approved Successfully';						 

	}else{
			$responce['type']='error';		

	}
	echo json_encode($responce);


}
if(isset($_POST['reject_Student'])){
	$admid=mysqli_real_escape_string($con,$_POST['id']);
	$reason=mysqli_real_escape_string($con,$_POST['reason']);

 $sql="update admission set status='3', decline_reason='$reason', accept_decline_date=now(),modify_date=now() where admission_id='$admid'";

	$q1 = mysqli_query($con,$sql);	
	if($q1){
  		$responce['type']='success';						 
  		$responce['msg']='Reject Successfully';						 

	}else{
			$responce['type']='error';		

	}
	echo json_encode($responce);


}
if(isset($_POST['Request_for_Admission'])){
// echo "<pre>";
// print_r($_POST);
// echo "</pre>"; 


$message=mysqli_real_escape_string($con,$_POST['message']);
$sendmsg=$_POST['message'];
$chk=$_POST['chk'];


	foreach($chk as $k){

		$q1 = mysqli_query($con,"update `admission` set status='1', requested_message='$message', requested_date=now(),modify_date=now() where admission_id='$k'");

		if($q1){


				$phone = get_admission_byid($k)['phone'];

					
				$messagetype='request_addmission';
				$encod=urlencode($sendmsg);
			  // echo $msg=$encod;
			

				sendwhatsappMessage($phone, $encod, $messagetype);

   
   }
  }  
  if($q1){
  	  $responce['type']='success';						 
  		$responce['msg']='Request Successfully';	

  }else{
  	$responce['type']='error';	
  }

  echo json_encode($responce);
}
if(isset($_POST['LoadMarksFormat'])){
// echo "<pre>";
// 	print_r($_POST);
// 	echo "</pre>";

$class=mysqli_real_escape_string($con,$_POST['class']);
$section=mysqli_real_escape_string($con,$_POST['section']);
$test=mysqli_real_escape_string($con,$_POST['test']);
$subject=mysqli_real_escape_string($con,$_POST['subject']);

$classname=get_class_byid($class)['class_name'] ?? "NA";
$sectionname=get_section_byid($section)['section_name'];
$subjectname=get_subject_byid($subject)['subject_name'];

  $query="select * from test where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$subject' && session='".$_SESSION['session']."' ";
		$filter_Result = mysqli_query($con, $query);
			$res=mysqli_fetch_array($filter_Result);
  $mmax = $res['max_marks'];


?>
<div class="card">
						<div class="card-body">
						<p>MARKS ENTRY</p>
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="margin-left:50px;">Class : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-80px">
							<input type="text" value="<?php echo $classname;?>" class="form-control" style="width:175px;" disabled>
							</div>
							
														
							<div class="col-md-2" style="margin-left:80px;">Section : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-60px;">
							<input type="text" value="<?php echo $sectionname ?>" class="form-control" style="width:175px;" disabled>
							</div>
						</div><br>
						<div class="row" style="margin-top:20px;">
							<div class="col-md-2" style="margin-left:50px;">Subject : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-80px;">
							<input type="text" value="<?php echo $subjectname ;?>" class="form-control" style="width:175px;" disabled>
							</div>
							
							<div class="col-md-2" style="margin-left:80px;">Test Name : </div>
							<div class="col-md-2" style="margin-top:-10px;margin-left:-60px;">
							<input type="text" value="<?php echo $test;?>" class="form-control" style="width:175px;" disabled>
							</div>
						</div><br><br>	
								
						<p>STUDENT DETAILS</p><br>
						<div class="row">
							<div class="col-md-2" style="font-size:14px;margin-left:50px;">Max Marks : </div>
							<div class="col-md-2" style="margin-left:-80px;margin-top:-10px;">
							<input type="number" name="max1" id="max1" value="<?php echo $mmax;?>" class="form-control" style="width:175px;" readonly>
							</div>
						</div><br>
						
					    <table id="table" class="table table-striped table-bordered">
							<thead>
								<tr>
									 <th>Sl No.</th>
									 <th>Roll No.</th>
									 <th>Student Name</th>
									 <th>Gender</th>
									 <th>Marks</th>
								</tr>
							</thead>
							<tbody >
											
						 
<?php 
						$sql="select `student_id`,`student_name`,`gender`,`sr`.`roll_no` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' && stu_status='0'  && sr.session='".$_SESSION['session']."'  order by sr.roll_no ";
							$que2 = mysqli_query($con,$sql);
							$i=1;							
							while($res1=mysqli_fetch_array($que2))
							{									
							$stuid = $res1['student_id'];
							$roll_no = ($res1['roll_no']) ? $res1['roll_no'] : '0' ;
							$stuname = $res1['student_name'];
							$gender = $res1['gender'];
									
							$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && student_id='$stuid' && test_name='$test' && subject_id='$subject'  && session='".$_SESSION['session']."' ");
							$res3 = mysqli_fetch_array($que3);
							$stumarks = $res3['marks'];
							?>
							<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $roll_no; ?></td>
							<td><?php echo $stuname; ?></td>
							<input type="hidden" name="studid[]" value="<?php echo $stuid;?>">
							
							<td><?php echo $gender;?></td> 
							
							<td><input type="text" name="marks[]" id="marks" value="<?php echo $stumarks;?>" style="width:100px" class="form-control marks" autofocus ></td>
																
							</tr>
							<?php
							$i++;
							}?>
						</tbody>
						</table>
						</div>	
						</div><br>	
<?php
}



if(isset($_POST['marks_entry'])){
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";  


	$class = $_POST['class'];
	$section = $_POST['section'];
	$subject = $_POST['subject'];
	$test = $_POST['test'];
	$maxmark = $_POST['max1'];
	$stuid = $_POST['studid'];
	$marks = $_POST['marks'];
	
	$totalstu = sizeof($stuid);
	for($i=0;$i<$totalstu;$i++)
	{
	
	$newstuid = $stuid[$i];
	if(!empty($marks[$i] )){
		$newmarks = $marks[$i];
	}else{
		$newmarks ='0';
	}
	

	
		$q = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && student_id='$newstuid' && test_name='$test' && subject_id='$subject' && session='".$_SESSION['session']."' ");
		$r = mysqli_num_rows($q);
		if($r){


			$re = mysqli_fetch_array($q);
			$markid = $re['mark_id'];
			// echo "<br>".
			$sql1="update marks set marks='$newmarks', modify_date=now() where mark_id='$markid' && session='".$_SESSION['session']."'  ";
			$queryupdate = mysqli_query($con,$sql1);

				if($queryupdate){
					$responce['type']='success';						 
			  	$responce['msg']='Marks Updated Successfully';


				}else{
					$responce['type']='error';						 
			  	$responce['msg']='Something Went wrong, Please try again';

				}

		}else{

			$sql="insert into marks (class_id,section_id,subject_id,test_name,student_id,marks,max_mark,session,date,modify_date) values 
		    ('$class','$section','$subject','$test','$newstuid','$newmarks','$maxmark','".$_SESSION['session']."',now(),now())";

			$queryinsert = mysqli_query($con,$sql);
			if($queryinsert){
				$responce['type']='success';						 
		  	$responce['msg']='Marks Inserted Successfully';

			}else{
				$responce['type']='error';						 
		  	$responce['msg']='Something Went wrong, Please try again';

			}
		}
		
	}//for loop

	

	echo json_encode($responce);
}


if(isset($_POST['AssignGrade'])){

	$grade=mysqli_real_escape_string($con,$_POST['grade']);
	$value1=mysqli_real_escape_string($con,$_POST['value1']);
	$value2=mysqli_real_escape_string($con,$_POST['value2']);
	
	$query = mysqli_query($con,"select * from grade where grade_name='$grade'");

	$row = mysqli_num_rows($query);

	if($row)

	{

		// echo "<script>alert('This Grade is already Exists.')</script>";
		$responce['type']='already';						 
  		$responce['message']='This Grade is already Exists.';						 
  			echo json_encode($responce); die;

	}else{

		$query = mysqli_query($con,"insert into grade (grade_id,grade_name,condition1,condition2,create_date,modify_date) values (0,'$grade','$value1',$value2,now(),now())");

		// if(mysqli_error($con)){
		// 	echo ("Error description :" .mysqli_error($con));
		// }

	}	

	if($query){
  		$responce['type']='success';						 
  		$responce['message']='Assign Grade Successfully';						 

	}else{
			$responce['type']='error';		
  		$responce['message']='Something Error :'.mysqli_error($con) ;						 


	}
	echo json_encode($responce);


}
if(isset($_POST['UpdateGrade'])){

// 	echo "<pre>";
// print_r($_POST);
// echo "</pre>";  

	$grade_id=mysqli_real_escape_string($con,$_POST['grade_id']);
	$grade=mysqli_real_escape_string($con,$_POST['grade']);
	$value1=mysqli_real_escape_string($con,$_POST['value1']);
	$value2=mysqli_real_escape_string($con,$_POST['value2']);
	
	$query = mysqli_query($con,"select * from grade where grade_name='$grade' and grade_id!='$grade_id' ");

	$row = mysqli_num_rows($query);

	if($row)

	{

		// echo "<script>alert('This Grade is already Exists.')</script>";
		  $responce['type']='already';						 
  		$responce['message']='This Grade is already Exists.';						 
  		echo json_encode($responce); die;

	}else{

			$query = mysqli_query($con,"update grade set grade_name='$grade', condition1='$value1', condition2='$value2',modify_date=now() where grade_id='$grade_id'");
		// if(mysqli_error($con)){
		// 	echo ("Error description :" .mysqli_error($con));
		// }

	}	
	if($query){
  		$responce['type']='success';						 
  		$responce['message']='Update Successfully';						 
	}else{
			$responce['type']='error';		
  		$responce['message']='Something Error :'.mysqli_error($con) ;						 
	}
	echo json_encode($responce);
}
if(isset($_POST['AddScholasticHeader'])){
// 	echo "<pre>";
// print_r($_POST);
// echo "</pre>";

	$schhead=mysqli_real_escape_string($con,$_POST['schhead']);


		$sql=mysqli_query($con,"select * from co_scholastic where scholastic_name='$schhead'");

		$res=mysqli_num_rows($sql);

		if($res){
			$responce['type']='already';						 
  		$responce['message']=' This Header is Already Exists.';						 
  		echo json_encode($responce); die;

		}else{

			$query=mysqli_query($con,"insert into co_scholastic(scholastic_name,status,session,create_date,modify_date) values('$schhead','1','".$_SESSION['session']."',now(),now())");	

		}

	if($query){
  		$responce['type']='success';						 
  		$responce['message']='Scholastic Heading Added Successfully';						 

	}else{
			$responce['type']='error';		
  		$responce['message']='Something Error :'.mysqli_error($con) ;						 
	}
	echo json_encode($responce);

}
if(isset($_POST['UpdateScholasticHeader'])){
// 	echo "<pre>";
// print_r($_POST);
// echo "</pre>";

	$scholastic_id=mysqli_real_escape_string($con,$_POST['scholastic_id']);
	$sch_name=mysqli_real_escape_string($con,$_POST['sch_name']);

	// $sql=;

			$sql1=mysqli_query($con,"select * from co_scholastic where scholastic_name='$sch_name' and scholastic_id!='$scholastic_id' ");
			$res1=mysqli_num_rows($sql1);

			if($res1){
				$responce['type']='already';						 
	  		$responce['message']=' This Header is Already Exists.';						 
	  		echo json_encode($responce); die;

			}else{

				$query=mysqli_query($con,"update co_scholastic set scholastic_name='$sch_name',modify_date=now()  where scholastic_id='$scholastic_id'");		

				// echo "<script>window.location='dashboard.php?option=view_scholastic'</script>";	
			}	

	if($query){
  		$responce['type']='success';						 
  		$responce['message']='Scholastic Heading Updated Successfully';						 

	}else{
			$responce['type']='error';		
  		$responce['message']='Something Error :'.mysqli_error($con) ;						 
	}
	echo json_encode($responce);


}
	
 ?>