<?php include('../myfunction.php')?>
<?php 
if(isset($_POST['LoadUpdateSubjectData'])){
    // echo "<pre>";
	// print_r($_POST);
		$class = mysqli_real_escape_string($con,$_POST['class']);
		$section = mysqli_real_escape_string($con,$_POST['section']);
		$test = mysqli_real_escape_string($con,$_POST['test']);
		$ntestname = mysqli_real_escape_string($con,$_POST['ntestname']);
	    $query="select * from test where class_id='$class' && section_id='$section' && test_name='$test' and session='".$_SESSION['session']."'";
	    $search_result = mysqli_query($con, $query);
		$i=1;
		while($res=mysqli_fetch_array($search_result))
		{						
		// echo "<pre>";			
		// echo "print_r('$res')";			
		$tid = $res['test_id'];
		$subid = $res['subject_id'];
		$qsub = mysqli_query($con,"select * from subject where subject_id='$subid'");
		$rsub = mysqli_fetch_array($qsub);
		$subname = $rsub['subject_name'];

			
		?>
		<tr>
		<!-- <td><?php echo $i; ?></td> -->
		<td><input type="checkbox" name="subject[]" id="<?php echo $subid;?>" checked="checked" value="<?php echo $subid;?>" onchange="savesub(this.id)"
		style="height:20px;width:20px;margin-left:20px;margin-top:10px;"></td>
		<td><?php echo $subname; ?></td>
		<input type="hidden" name="testid[]" id="testid<?php echo $subid;?>" value="<?php echo $tid;?>">
		
		<td><input type="text" name="minmark[]" id="minmark<?php echo $subid;?>" 
		value="<?php echo $res['min_marks'];?>" style="width:80px" class="form-control nonegative"></td>
		
		<td><input type="text" name="maxmark[]" id="maxmark<?php echo $subid;?>" 
		value="<?php echo $res['max_marks'];?>" style="width:80px" class="form-control nonegative"></td>
		
		<td><input type="text" name="no_of_question[]" id="no_of_question<?php echo $subid;?>" 
		value="<?php echo $res['no_of_question'];?>" style="width:80px" class="form-control nonegative"></td>
		
		<td><input type="date" name="testdate[]" id="testdate<?php echo $subid;?>" 
		value="<?php echo $res['test_date'];?>" style="width:180px" class="form-control dateval"></td>
		
		<td><input type="time" name="starttime[]" id="starttime<?php echo $subid;?>" 
		value="<?php echo $res['starttime'];?>" style="width:140px" class="form-control"></td>
		
		<td><input type="time" name="endtime[]" id="endtime<?php echo $subid;?>" 
		value="<?php echo $res['endtime'];?>" style="width:140px" class="form-control"></td>
											
		<td><input type="text" name="roomno[]" id="roomno<?php echo $subid;?>" 
		value="<?php echo $res['room_no'];?>" style="width:130px" class="form-control" ></td>
		
		<?php 
		 echo '<td><a style="color:#fff;font-size:15px;padding: 6px;
         border-radius: 3px;" class="btn-primary" target="_blank" href="pdf-questions.php?test='.base64_encode($tid).'&class='.base64_encode($class).'&subject='.base64_encode($subid).'">Questions</a>';
	     
		?>
		
											
		</tr>
	<?php
		$i++;
		}

		if( mysqli_error($con)){
             echo("Error description: " . mysqli_error($con));
         }
								



}	
if(isset($_POST['UpdateTest'])){
// 
	$x=1;
	// echo "<pre>";
		// print_r($_POST);
	// echo "</pre>";
	// die;
	$class = $_POST['class'];
	$section = $_POST['section'];
	$testname = $_POST['ntestname'];
	$subject = $_POST['subject'];
	$testdate = $_POST['testdate'];
	//$nwdate = date("d-m-Y",strtotime($testdate));
	$starttime = $_POST['starttime'];
	$endtime = $_POST['endtime'];
	$testid = $_POST['testid'];
	$minmark = $_POST['minmark'];
	$maxmark = $_POST['maxmark'];
	$roomno = $_POST['roomno'];
	$no_of_question = $_POST['no_of_question'];
	
	$check=$_POST['check'];
	$username=$_SESSION['user_roles'];
	$totalsub = sizeof($testid);
	$subname = array();

		
	for($i=0;$i<$totalsub;$i++)
	{
		
		// echo "<pre>";
		// print_r($_POST);die();
	$newsub = $subject[$i];	
	$newminmark = $minmark[$i];
	$newmaxmark = $maxmark[$i];
	$newtestdate = $testdate[$i];
	$newstarttime = $starttime[$i];
	$newendtime = $endtime[$i];
	$newroomno = $roomno[$i];
	$newtestid = $testid[$i];
	
	$new_no_of_question = $no_of_question[$i];
	
	$ntestdate = $testdate[0];
	$all_date_arr[] = $testdate[$i];

	$nwdate = date("d-m-Y",strtotime($ntestdate));

	// $q1 = mysqli_query($con,"select * from test where test_name='$testname' && class_id='$class' && section_id='$section' && subject_id='$newsub' && session='".$_SESSION['session']."' ");

	// 		$r1 = mysqli_num_rows($q1);
	
	if($newminmark=="" && $newmaxmark=="")
	{
	   $querydel = mysqli_query($con,"delete from test where test_id='$newtestid' and session='".$_SESSION['session']."' "); 
	}
	else
	{
	   $querysave = mysqli_query($con,"update test set test_name='$testname', test_date='$newtestdate',no_of_question='$new_no_of_question', starttime='$newstarttime', endtime='$newendtime', min_marks='$newminmark', max_marks='$newmaxmark', room_no='$newroomno', modify_date=now() where test_id='$newtestid' and session='".$_SESSION['session']."' ");
	}
		
			$qsub = mysqli_query($con,"select * from subject where subject_id='$newsub'");
			$rsub = mysqli_fetch_array($qsub);
			$subname[] =  $rsub['subject_name'];
	}
	
		$allsub = implode(" , ",$subname);
		
		if($querysave)
			{
				$SMSG="Test Updated Successfuly";
			     $Responce=array('status'=>'success','msg'=>$SMSG);
			     echo json_encode($Responce);
				
				// $x=1;
				// $query2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' && stu_status='0' && session='".$_SESSION['session']."' ");
				$asql="select `register_no`,`student_id`,`student_name`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section' and  s.stu_status='0'   && sr.session='".$_SESSION['session']."'";
		        $query2=mysqli_query($con,$asql);
				while($res2 = mysqli_fetch_array($query2))
				{
					
					$set=mysqli_query($con,"select * from sms_setting");
					$rset=mysqli_fetch_array($set);
					$senderid=$rset['sender_id'];
					$apiurl=$rset['api_url'];
					$apikey=$rset['api_key'];
					
					$sset=mysqli_query($con,"select * from setting");
					$rsset=mysqli_fetch_array($sset);
					$sclname=$rsset['company_name'];
					
					$stuid=$res2['student_id'];
					$mobile=$res2['parent_no'];
					$msgtype=$res2['msg_type_id'];
					$messagetype = "update_test";
					$min_date2= min($all_date_arr);         //take only minimum date
				    $min_date = date("d-m-Y",strtotime($min_date2));
					
					$message="Dear Parent,%0a".$testname.", will be start from ".$min_date."  for ".$allsub."."."%0aPlease make your ward to prepare well.%0aAll the Best,%0aFrom%0a".$sclname.",";
					$nmessage="Dear Parent,<br>".$testname.", will be star from ".$min_date."  for ".$allsub."."."<br>Please make your ward to prepare well.<br>All the Best,<br>From<br>".$sclname.",";
					
					if($check)
					{
						if($msgtype==1){

							$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)
							values(3,'$stuid','$class','$section','$mobile','$nmessage',1,'$username',now(),now(),'".$_SESSION['session']."')");
						
							//Send message via whatsapp
						    $msg = $message;
						   // die;

							sendwhatsappMessage($mobile, $msg, $messagetype);
							
						}elseif($msgtype==2){

							$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)
							values(3,'$stuid','$class','$section','$mobile','$nmessage',2,'$username',now(),now(),'".$_SESSION['session']."')");

							$msg = $message; 
							sendtextMessage($mobile, $msg, $messagetype);
						}
						
							
					}
					// else
					// {					
					// 	if($msgtype==1)
					// 	{
					// 		$que2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,selected_no,message,loginuser,notice_datetime,date)
					// 		values(3,'$stuid','$class','$section','$mobile','$nmessage','$username',now(),now())");
						
					// 		//Send message via whatsapp
					// 	    $msg = $message;
							

					// 		sendwhatsappMessage($mobile, $msg, $messagetype);
							
					// 	}
					// 	else if($msgtype==2)
					// 	{
					// 		//Send text message
					// 		// $msg = $nmessage; 
					// 		// sendtextMessage($mobile, $msg, $messagetype);
					// 		//Send text message
							
					// 	}
					// }
				
				}

				
			}else{
				$SMSG="Oops Somethings is Wrong";
					
			$Responce=array('status'=>'fail','msg'=>$SMSG);
			echo json_encode($Responce);	

			}
	
}
if(isset($_POST['LoadReportFormat'])){

// echo "<pre>";
// 		print_r($_POST);
	$class = $_POST['class'];
	$section = $_POST['section'];
	$test = $_POST['test'];
	// $subject = $_POST['subject'];


	?>
<table id="table-grid" class="table table-striped table-bordered">

							<thead >	
<tr>

			 <th>Sl No.</th>

			 <th>Student Name</th>
			 <th>Roll no.</th>

			 <?php

			 $que = mysqli_query($con,"select * from test where class_id='$class' && section_id='$section' && test_name='$test' and session='".$_SESSION['session']."'");

			 while($rque = mysqli_fetch_array($que))

			 {

				 $subid = $rque['subject_id'];

				 $subidarr[] = $rque['subject_id'];

				 $sque = mysqli_query($con,"select * from subject where subject_id='$subid'");

				 $rque = mysqli_fetch_array($sque);

			 ?>

			 <th><?php echo $rque['subject_name'];?></th>

			 <?php 

			 }

			 ?>

			 <th>Total</th>

			 <th>Percent</th>

			 <th>Grade</th>

		</tr>
	</thead>

		<tbody>

							<?php 

							// $que2 = mysqli_query($con,"select * from students where class_id='$class' && section_id='$section' and session='".$_SESSION['session']."'");
							$asql="select `register_no`,`student_id`,`student_name`,`msg_type_id`,`parent_no`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`roll_no` from students as s join student_records as sr ON s.student_id=sr.stu_id  where sr.class_id='$class' && sr.section_id='$section'  and  s.stu_status='0'   && sr.session='".$_SESSION['session']."' order by sr.roll_no asc";
		                    $que2=mysqli_query($con,$asql);

							$i=1;							

							while($res2=mysqli_fetch_array($que2))

							{									

							$stuid = $res2['student_id'];

							$stuname = $res2['student_name'];					

							?>

							<tr>

							<td><?php echo $i; ?></td>

							<td><?php echo $stuname; ?></td>
							<td><?= ($res2['roll_no']) ? $res2['roll_no'] : '0' ?></td>

							<input type="hidden" name="studid[]" value="<?php echo $stuid;?>">

							

							<?php

							$total = 0;

							$totalmarks = 0;

							$percent = 0;

							foreach($subidarr as $v)

							{

							$que3 = mysqli_query($con,"select * from marks where class_id='$class' && section_id='$section' && test_name='$test' && subject_id='$v' && student_id='$stuid' && session='".$_SESSION['session']."'");

							$res3 = mysqli_fetch_array($que3);

							$stumarks = $res3['marks'];

							if($stumarks)

							{

								$marks = $stumarks;

							}

							else

							{

								$marks = 0;

							}

							$tmarks = $res3['max_mark'];

							?>

							<td><?php echo $marks;?></td>

							<?php

							$total = $total+$marks;

							$totalmarks = $totalmarks+$tmarks;
							if($totalmarks==0 || $totalmarks==""){
								$totalmarks=1;
							}

							$per = round($total/$totalmarks*100,2);

							if(is_nan($percent))

							{

								$percent = 0;

							}

							else

							{

								$percent = $per;

							}

							

							

							$que4 = mysqli_query($con,"select * from grade where condition1 <='$percent' && condition2 >='$percent'");

							

							$row = mysqli_num_rows($que4);

							if($row)

							{

								$res4 = mysqli_fetch_array($que4);

								$gr = $res4['grade_name'];

							}

							

							}

							?>

							<td><?php echo $total." / ".$totalmarks;?></td>	

							<td><?php echo $percent." %";?></td>	

							<td><?php echo $gr;?></td>	

							</tr>

							<?php

							$i++;

							}

							?>					

						 	</tbody>
									 </table> 	
			<div class="row">

		<div class="col-md-12" align="center">

		<a href="export_view_report.php?class=<?php echo $class;?>&section=<?php echo $section;?>&test=<?php echo $test;?>" style="margin-left:20px;" class="btn btn-success">Download To Excel</a>

		</div>

		</div>						 
<?php
}





?>