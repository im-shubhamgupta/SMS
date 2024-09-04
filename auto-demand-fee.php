<?php
// include('connection.php');
include('myfunction.php');
date_default_timezone_set('Asia/Kolkata');

$month=date('m');
$month_name=date('M');

$Year=date('Y');


  if($month==1||$month==2|| $month==3){
	$PrevYear=$Year-1;	
	$sessiontext= $PrevYear.'-'.substr($Year,2,2);
		
	}else{
	$NextYear=$Year+1;	
	$sessiontext= $Year.'-'.substr($NextYear,2,2);
	}


$No_of_Month=1;


  $sql= "SELECT * From session where year='$sessiontext'";
  $Query= $con->query($sql);
  
  if($Query->num_rows>0){
	  
	$Row=$Query->fetch_assoc(); 
	$session = $Row['id'];
	  
  }
  

// $session=2;

  function monthname($id,$con){	
	  $Query=$con->query("select * from months where fee_order_month IN ($id)");		
	  if($Query->num_rows>0){	 
	  while($MonthRow=$Query->fetch_assoc()){		
	   $Responce[]=$MonthRow['month_name'];		 		
	   }      		 
	  }	 		
	  if(!empty($Responce)){	
	   $Responce=implode(', ',$Responce);		
	  }			
	   return $Responce;
	}	


$x=0;
$que1=mysqli_query($con,"select * from setting");
$res1=mysqli_fetch_array($que1);
$cname=$res1['company_name'];
$cadd=$res1['company_address'];
$cemail=$res1['company_email'];
$cno=$res1['company_number'];	
$clogo=$res1['company_image'];
$registration_number = $res1['registration_number'];
$affiliation_number = $res1['affiliation_number'];

$sql="select `student_name`,`register_no`,`s`.`student_id`,`father_name`,parent_no,`sr`.`roll_no`,`sr`.`class_id`,`sr`.`section_id` from students as `s` join student_records as `sr` ON `s`.`student_id`=`sr`.`stu_id` where  stu_status='0'  && `sr`.`session`='".$session."'";
$qstu=mysqli_query($con,$sql);
while($rstu=mysqli_fetch_array($qstu)){
	
$stuid=$rstu['student_id'];
$stuname=$rstu['student_name'];
$stureg=$rstu['register_no'];
$roll_no=$rstu['roll_no'];
$stucls=$rstu['class_id'];
$parent_no=$rstu['parent_no'];  
$father_name=$rstu['father_name']; 
$qcls=mysqli_query($con,"select * from class where class_id='$stucls'");
$rcls=mysqli_fetch_array($qcls);
$class=$rcls['class_name'];

$stusecid=$rstu['section_id'];
$qsec=mysqli_query($con,"select * from section where section_id='$stusecid'");
$rsec=mysqli_fetch_array($qsec);
$section=$rsec['section_name'];




					$qfee1 = mysqli_query($con,"select * from student_transport_due_fees where student_id='$stuid' and session='$session'");
					$rfee1 = mysqli_fetch_array($qfee1);
					
						$feehead = $rfee1['fee_header_id'];
						$headarr = explode(',',$feehead);
						
						
						$feeamt = $rfee1['fee_amount'];
						$amtarr = explode(',',$feeamt);				
						$feeheadcount = sizeof($headarr);
						$tbal = 0;
						$tcurrent_due=0;
						for($i=0;$i<$feeheadcount;$i++)
						{
						
						$feeid = $headarr[$i];
						$feeamount = $amtarr[$i]; 								
						
						$qfee2 = mysqli_query($con,"select * from student_due_fees where student_id='$stuid' && (status='0' || status='1') AND   session='$session'");
						$trecamt = 0;
						$tranamt = 0;
						$prevamt = 0;
						$no_of_paid_months=0;
						while($rfee2 = mysqli_fetch_array($qfee2))
						{
						
							$fhid = $rfee2['fee_header_id'];
							$fhidarr = explode(',',$fhid);
							
							$recamt = $rfee2['received_amount'];
							$no_of_paid_months=$no_of_paid_months+$paid_months;
							$recamtarr = explode(',',$recamt);
							
							if(in_array($feeid,$fhidarr))
							{
								$pos = array_search($feeid,$fhidarr);
								$val = $recamtarr[$pos];	
							}
							
							
							//$recamount = $recamtarr[$i];
							$trecamt = $trecamt+intval($val);
							
							$tranamt = $tranamt+$rfee2['transport_amount'];
							$prevamt = $prevamt+$rfee2['previous_amount'];
						}	
						
						
							
							
							$baltranfee = $transamt - $tranamt;
							$balprevfee = $prevfees - $prevamt;
							 
						
						$q1 = mysqli_query($con,"select * from fee_header where fee_header_id='$feeid'");
						$r1 = mysqli_fetch_array($q1);
						$fheadname = $r1['fee_header_name'];
						$fheadtype = $r1['type'];
						if($fheadtype=='1'){
						$charge_type="Monthly";
						
                        $balfee = $feeamount;
						
						$tbalfee=$feeamount*$No_of_Month;
						
						}else{
						$charge_type="Yearly";
						$balfee = $feeamount- $trecamt;
                        $tbalfee=$balfee;
                        $current_due=$feeamount- $trecamt;						
						}
					
					$tbal = $tbal + $tbalfee;
					$tcurrent_due=$tcurrent_due+$current_due;
				   }
					$totalbal = $tbal + $baltranfee + $balprevfee;
                    $tcurrent_due=$tcurrent_due+$baltranfee+$balprevfee;


                    $Total_Amount_To_Paid= $tbal+$monthly_fee_due+$Late_fee;

//send demand fee notification---------------------------------------------
if(true){
		$company_name= get_school_details()['company_name'];	
	
		// $only_month= monthname($month,$con);
		$only_year=getSessionByid($session)['only_year'];
		// echo "<br>reg: ".$stureg."<br>";
	
// echo "<br><br>".$x.' : '.
			 $Wmessage="Dear Mr. ".$father_name.",%0aThis is to inform you that the school fee of ".$stuname." is due for the month of ".$month_name."-".$only_year.". You are requested  to avoid additional late fees.%0aThe total due amount is ".$Total_Amount_To_Paid.".%0aIf fee is already paid Please ignore this. %0aRegards,%0a".$company_name."";
			$WNmessage="Dear Mr".$father_name.",<br>This is to inform you that the school fee of ".$stuname." is due for the month of ".$month_name."-".$only_year.". You are requested  to avoid additional late fees.<br>The total due amount is ".$Total_Amount_To_Paid.".<br><br>If fee is already paid Please ignore this. <br>Regards,<br>".$company_name."";

			$messagetype='demand-fee';

			
			 $nsql="insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,msg_type,loginuser,notice_datetime,date,session) values(3,'$stuid','$stucls','$stusecid',0,'$parent_no','$WNmessage','1','crown_job',now(),now(),'$session')";
			if($Total_Amount_To_Paid>0){
			   $que2 = mysqli_query($con, $nsql);
			
				$result = sendwhatsappMessage($parent_no, $Wmessage, $messagetype);
			

				if($que2){
					// echo "hello world";
				}else{
					echo "Error description:".mysqli_error($con);
				}
		  }
}               
	
//send demand fee notification---------------------------------------------				  
					  
$x++;					
}//while loop
if($x>0){
	// echo  "Total ".$x."students send message sucessfully";
}


