<?php 
include_once('myfunction.php');
date_default_timezone_set('Asia/Kolkata');
extract($_REQUEST); ?>
<div id="right-panel"  style="width:100%">
         
<nav class="breadcrumb">
  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
  <a class="breadcrumb-item" href="#">Student Panel</a>
  <a class="breadcrumb-item" href="#">Student</a>
  <span class="breadcrumb-item active">Import CSV Students</span>
</nav>
<?php
if (isset($_POST['upload'])) 
{
	if (($fp = fopen($_FILES['csvfile']['tmp_name'], "r")) !== FALSE) { 
		$chk_row=-1;
		while (($record = fgetcsv($fp)) !== FALSE) {
			$chk_row++;
		}
	  		$chk_row;
	  }
	
	$st1=mysqli_query($con,"select `student_id` from `students` as s join student_records as sr on s.student_id=sr.stu_id where  sr.session='".$_SESSION['session']."' ");
	$rst1=mysqli_num_rows($st1);
	
	$sr=mysqli_query($con,"select * from student_restrict where id='1'");
	$rsr=mysqli_fetch_array($sr);
	$tstu=$rsr['total_students'];
		
    $remain_stu=$tstu-$rst1;
	// if($rst1<$tstu)
	if($remain_stu>=$chk_row)
	{
		
		$csvfile = $_FILES['csvfile']['name'];
		$ext = pathinfo($csvfile, PATHINFO_EXTENSION);
		$base_name = pathinfo($csvfile, PATHINFO_BASENAME);

		if(!$_FILES['csvfile']['name'] == "")   
		{ 
		if($ext == "csv")
		{
		 
		 if(file_exists($base_name))
		{
			  echo "file already exist" . $base_name;
														  
		}	 
			else
		{
				
		if (is_uploaded_file($_FILES['csvfile']['tmp_name'])) 	 
		{
			
			// echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";
		 
			//readfile($_FILES['csvfile']['tmp_name']);
		}
				  $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
					
				  $headerLine = true;
				  fgetcsv($handle, 1000, ",");

			$count=0;
			$already=array();
			$not_upload=array();
			$success_upload=array();
			$error=0;
			$false_query=0;
				  
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
		{	

			$session='';

			$registerno = $con->real_escape_string(trim($data[0]));
            if(!empty($registerno)){
                $registerno=$registerno;
			}else{
				$registerno = '';
			}
			
			$studentname = $con->real_escape_string($data[1]);
            if(!empty($studentname)){
                $studentname=$studentname;
			}else{
				$studentname = '';
			}
			
			$fathername = $con->real_escape_string($data[2]);
            if(!empty($fathername)){
                $fathername=$fathername;
			}else{
				$fathername = '';
			}
			
			$mothername = $con->real_escape_string($data[3]);
            if(!empty($mothername)){
                $mothername=$mothername;
			}else{
				$mothername = '';
			}
			
			$gender = $con->real_escape_string($data[4]);
            if(!empty($gender)){
                $gender=$gender;
			}else{
				$gender = '';
			}
			
			$dob = $con->real_escape_string($data[5]);
            if(!empty($dob)){
                // $dob=$dob;
                $dob=date("Y-m-d", strtotime(str_replace('/','-',$dob)));
			}else{
				$dob = '';
			}
				// echo "Dob:".$dob=date("Y-m-d", strtotime($data[5]));

			
			$admission_dt = $con->real_escape_string($data[6]);
			if(!empty($admission_dt)){
				$admissiondate=date("Y-m-d", strtotime(str_replace('/','-',$admission_dt)));
			}else{
			
				$admissiondate = '';
			}
			
			$stucontact = $con->real_escape_string($data[7]);
            if(!empty($stucontact)){
                $stucontact=$stucontact;
			}else{
				$stucontact = '';
			}
			
			$clsname = $con->real_escape_string(trim($data[8]));
            if(!empty($clsname)){
            	$Uclsname=strtoupper($clsname);
				
                $qcls=mysqli_query($con,"select * from class where upper(class_name)='$Uclsname'");
                if(mysqli_num_rows($qcls)){
	                $rcls=mysqli_fetch_array($qcls);
	                $clsid=$rcls['class_id'];
	            }else{
	            	$clsid ='';
	            }    

            }else{
                $clsid ='';
            }
          
			
			$secname = $con->real_escape_string(trim($data[9]));

            if(!empty($secname) && !empty($clsid)){
            	$Usecname=strtoupper($secname);
                $qsec = mysqli_query($con,"select * from section where upper(section_name)='$Usecname' and class_id='$clsid'");
                if(mysqli_num_rows($qsec)){
	                $rsec = mysqli_fetch_array($qsec);
	                $secid = $rsec['section_id'];
	            }else{
	            	$secid = '';
	            }    
            }else{
                $secid = '';
            }	

            $academic_year=$con->real_escape_string(trim($data[15]));
			$acdyear=$academic_year;
			if(!empty($academic_year)){
				$aca=mysqli_query($con,"select `id` from session where year='$academic_year'");
				if(mysqli_num_rows($aca)){
					$aca1=mysqli_fetch_array($aca);
					$session=$aca1['id'];
				}else{
					$acdyear='';
				    $session='';
				}
			}else{
				$acdyear='';
				$session='';
			}
           

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
               // $current_fee_charge_Month=$Current_Month-$ReIndexAddmission_Month;		
                $fee_start_month=$Admission_month;	
			}else{

			    $current_fee_charge_Month=12; 	
			    $St_wise_months=12;		
				$fee_start_month=4;	
			}				
			
			$qfee = mysqli_query($con,"select * from assign_fee_class where class_id='$clsid' and session='$session' ");
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
             

			$parentno = $con->real_escape_string($data[10]);
			if(!empty($parentno)){
                $parentno=$parentno;
			}else{
				$parentno = '';
			}
			
			$password = $con->real_escape_string($data[11]);
			if(!empty($password)){
                $password=$password;
			}else{
				$password = '';
			}
			
			$address = $con->real_escape_string($data[12]);
			if(!empty($address)){
                $address=$address;
			}else{
				$address = '';
			}
			
			$admtype = $con->real_escape_string($data[13]);
            if(!empty($admtype)){
            	$Uadmtype=strtoupper($admtype);
                $qadm=mysqli_query($con,"select * from admission_type where upper(adm_type_name)='$Uadmtype'");
                if(mysqli_num_rows($qadm)){
	                $radm=mysqli_fetch_array($qadm);
	                $admtypeid=$radm['adm_type_id'];
	            }else{
	            	$admtypeid = '';
	            }
            }else{
                $admtypeid = '';
            }
			
			$msgtype=$con->real_escape_string($data[14]);
            if(!empty($msgtype)){
            	$Umsgtype=strtoupper($msgtype);
                $qmsg=mysqli_query($con,"select * from message_type where msg_name='$Umsgtype'");
                $rmsg=mysqli_fetch_array($qmsg);
                $msgtypeid=$rmsg['msg_type_id'];
            }else{
                $msgtypeid = 0;
            }
			
			
		

            /*$session=$academic_year;
			$aca=mysqli_query($con,"select * from session where id='$academic_year'");
			$aca1=mysqli_fetch_array($aca);
			$AcademicYear=$aca1['year'];

            $aca=mysqli_query($con,"select * from session where id='$session'");
			$aca1=mysqli_fetch_array($aca);
			$acdyear=$aca1['year'];*/

            // echo 'acdyear: '.$academic_year;
            // echo '<br>session: '.$session;
           

        
			$admrte=$con->real_escape_string($data[16]);
            if(!empty($admrte)){
                $admrte=$admrte;
            }else{
                $admrte = "No";
            }
			
			$regligion = $con->real_escape_string(trim($data[17]));
			// echo 'religion: '.$regligion;
            if(!empty($regligion)){
            	$Ureligion=strtoupper($regligion);
                $qreg=mysqli_query($con,"select * from religion where upper(religion_name)='$Ureligion'");
                $rreg=mysqli_fetch_array($qreg);
                $religionid = $rreg['religion_id'];
            }else{
                $religionid = 0;
            }
			
			$caste = $con->real_escape_string($data[18]);
            if(!empty($caste)){
                $caste=$caste;
            }else{
                $caste = "No";
            }
			
			$socialcat = $con->real_escape_string($data[19]);
            if(!empty($socialcat)){
            	$Usocialcat=strtoupper($socialcat);
                $qscat=mysqli_query($con,"select * from social_category where upper(soc_cat_name) = '$Usocialcat'");
                $rscat=mysqli_fetch_array($qscat);
                $socialcategory=$rscat['soc_cat_id'];
            }else{
                $socialcategory = 0;
            }
			
			$bloodgrp = $con->real_escape_string($data[20]);
            if(!empty($bloodgrp)){
                $bloodgrp=$bloodgrp;
            }else{
                $bloodgrp = '';
            }
			
			$mothertongue = $con->real_escape_string($data[21]);
            if(!empty($mothertongue)){
                $mothertongue=$mothertongue;
            }else{
                $mothertongue = '';
            }
			
			$stuaadhar = $con->real_escape_string($data[22]);
            if(!empty($stuaadhar)){
                $stuaadhar=$stuaadhar;
            }else{
                $stuaadhar = '';
            }
			
			$birthplace = $con->real_escape_string($data[23]);
            if(!empty($birthplace)){
                $birthplace=$birthplace;
            }else{
                $birthplace = '';
            }
			
			$village = $con->real_escape_string($data[24]);
            if(!empty($village)){
                $village=$village;
            }else{
                $village = '';
            }
			
			$fqualification = $con->real_escape_string($data[25]);
            if(!empty($fqualification)){
                $fqualification=$fqualification;
            }else{
                $fqualification = '';
            }
			
			$mqualification = $con->real_escape_string($data[26]);
            if(!empty($mqualification)){
                $mqualification=$mqualification;
            }else{
                $mqualification = '';
            }
			
			$foccupation = $con->real_escape_string($data[27]);
            if(!empty($foccupation)){
                $foccupation=$foccupation;
            }else{
                $foccupation = '';
            }
			
			$moccupation = $con->real_escape_string($data[28]);
            if(!empty($moccupation)){
                $moccupation=$moccupation;
            }else{
                $moccupation = '';
            }
			
			$fannual_income = $con->real_escape_string($data[29]);
            if(!empty($fannual_income)){
                $fannual_income=$fannual_income;
            }else{
                $fannual_income = 0;
            }

			$dependents = $con->real_escape_string($data[30]);
            if(!empty($dependents)){
                $dependents=$dependents;
            }else{
                $dependents = 0;
            }

			$guardian = $con->real_escape_string($data[31]);
            if(!empty($guardian)){
                $guardian=$guardian;
            }else{
                $guardian = '';
            }
			
			$nationality = $con->real_escape_string($data[32]);
            if(!empty($nationality)){
                $nationality=$nationality;
            }else{
                $nationality = '';
            }
			
			$subcaste = $con->real_escape_string($data[33]);
            if(!empty($subcaste)){
                $subcaste=$subcaste;
            }else{
                $subcaste = '';
            }
			
			$otherlang = $con->real_escape_string($data[34]);
            if(!empty($otherlang)){
                $otherlang=$otherlang;
            }else{
                $otherlang = '';
            }
			
			$presentadd = $con->real_escape_string($data[35]);
            if(!empty($presentadd)){
                $presentadd=$presentadd;
            }else{
                $presentadd = '';
            }
			
			$previousschool = $con->real_escape_string($data[36]);
            if(!empty($previousschool)){
                $previousschool=$previousschool;
            }else{
                $previousschool = '';
            }
			
			$fadhaar = $con->real_escape_string($data[37]);
            if(!empty($fadhaar)){
                $fadhaar=$fadhaar;
            }else{
                $fadhaar = '';
            }
			
			$madhaar = $con->real_escape_string($data[38]);
            if(!empty($madhaar)){
                $madhaar=$madhaar;
            }else{
                $madhaar = '';
            }
			
			$stubankacc = $con->real_escape_string($data[39]);
            if(!empty($stubankacc)){
                $stubankacc=$stubankacc;
            }else{
                $stubankacc = '';
            }
			
			$ifsccode = $con->real_escape_string($data[40]);
            if(!empty($ifsccode)){
                $ifsccode=$ifsccode;
            }else{
                $ifsccode = '';
            }
			
			$branch = $con->real_escape_string($data[41]);
            if(!empty($branch)){
                $branch=$branch;
            }else{
                $branch = '';
            }
			
			$busfacility = $con->real_escape_string($data[42]);
            if(!empty($busfacility)){
                $busfacility=$busfacility;
            }else{
                $busfacility = 'No';
            }
			
			$status = 0 ;

			// echo '<br>'.$registerno;
			// die;
			
			$CheckQuery = $con->query("SELECT `register_no` FROM `students` WHERE `register_no` = '".$registerno."' ");
			
			if($registerno=="" || $admissiondate=="" ||  $admissiondate=='1970-01-01' || $clsid=='' || $secid=='' || $regligion=='' || $session=='' || $admtypeid=='' || $dob=='' || $dob=='1970-01-01' ){
				$not_upload[]=$registerno;
				$error+=1;
				// echo "empty";
				continue;
			}else if($CheckQuery->num_rows > 0){
				
				$already[]=$registerno;
				$error+=1;
				continue;
			}else{		
				$create_date=date('Y-m-d H:i:s');
				$modify_date=date('Y-m-d H:i:s');

				$admssion_no=get_new_admission_no();
				// $admssion_no='';

				$import=mysqli_query($con,"INSERT INTO students(register_no,admission_no,student_name,father_name,mother_name,gender,dob,admission_date,student_contact,due,parent_no,password,stuaddress,adm_type_id,msg_type_id,admin_rte,religion_id,caste,soc_cat_id,blood_grp,mother_tongue,aadhar_card,birth_place,village,fqualification,mqualification,foccupation,moccupation,fannual_income,dependents,guardians,nationality,subcaste,other_language,present_address,previous_school,father_aadhar,mother_aadhar,student_bankacc,ifsc_code,branch,bus_facility,stu_status,create_date,modify_date)VALUES('".$registerno."','".$admssion_no."', '".$studentname."', '".$fathername."', '".$mothername."', '".$gender."', '".$dob."', '".$admissiondate."', '".$stucontact."', '".$DueStu_Amount."', '".$parentno."', '".$password."', '".$address."', '".$admtypeid."', '".$msgtypeid."', '".$admrte."', '".$religionid."', '".$caste."', '".$socialcategory."', '".$bloodgrp."', '".$mothertongue."', '".$stuaadhar."', '".$birthplace."', '".$village."', '".$fqualification."', '".$mqualification."', '".$foccupation."', '".$moccupation."', '".$fannual_income."', '".$dependents."', '".$guardian."', '".$nationality."', '".$subcaste."', '".$otherlang."', '".$presentadd."', '".$previousschool."', '".$fadhaar."', '".$madhaar."', '".$stubankacc."', '".$ifsccode."', '".$branch."', '".$busfacility."', '".$status."', '".$create_date."', '".$modify_date."')");
												
                if( mysqli_error($con)){
                    echo("Error description: " . mysqli_error($con));
                }
				 
				if($import){
						$stuid = mysqli_insert_id($con);

						$query3 = mysqli_query($con,"INSERT INTO `student_records`(`stu_id`, `class_id`, `section_id`,`session`,  `create_at`, `modify_at`) VALUES ('$stuid','$clsid','$secid','$session',now(),now())");
						if(mysqli_error($con)){
						echo("Error description: " . mysqli_error($con));
						}
						if($query3){
							$chk_assign_fee = mysqli_query($con,"select * from assign_fee_class where class_id='$clsid' and session='".$session."'");
	                        if($chk_assign_fee->num_rows > 0){                     
						
							    $StuFee= $con->query("SELECT student_id FROM student_wise_fees WHERE student_id='".$stuid."' AND session='".$session."'");
							    
								if($StuFee->num_rows<1){
							    $swsql="insert into student_wise_fees(student_id,class_id,section_id,fee_header_id,fee_amount,due_amount,no_of_months,fee_start_month,session,create_date,modify_date) values ('".$stuid."', '".$clsid."', '".$secid."', '".$feeids."', '".$feeamts."', '".$DueStu_Amount."','$St_wise_months',$fee_start_month,'".$session."', '".$create_date."', '".$modify_date."')";
								
								$query2 = mysqli_query($con,$swsql);
								
								}
							}	
					    }

						// if($query2){
							$success_upload[]=$registerno;
							$count+=1;
						// }else{

						// // mysqli_query($con," UPDATE `students` SET `stu_status`='1'  where `student_id`='".$stuid."'");
						// 	$false_query+=1;
						//     $not_upload[]=$registerno;
						// }


						
			 
						if(mysqli_error($con)){
						echo("Error description: " . mysqli_error($con));
						}
				}else{
						$false_query+=1;
						$not_upload[]=$registerno;
				}


						
			}//else
			
		 
		}//while

		// 	echo "<pre>";
		// 	print_r($already);
		// 	echo "</pre>";
		foreach($already as $k1 => $v1){
		 if(empty($v1)){
		  unset($already[$k1]);
		  }
		}
		foreach($not_upload as $k => $v){
		 if(empty($v)){
		  unset($not_upload[$k]);
		  }
		}

		// if($count>0){
			// if(!empty($not_upload)){
				$err_regisno=implode(', ', $not_upload);
				$err_already=implode(', ', $already);

				if(!empty($err_already) && !empty($err_regisno)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Students uploaded successfully. This Register no. has not been uploaded ('.$err_already.' )due to already exist & This Register no. has not been uploaded ( '.$err_regisno.' ) please check the given data. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

				}elseif(!empty($err_already)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Students uploaded successfully. This Register no. not uploaded ('.$err_already.') due to already exist. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

				}elseif(!empty($err_regisno)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Students uploaded successfully. This Register no. not uploaded ('.$err_regisno.') please check the given data. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';
				}elseif($count > 0){
					echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Students uploaded successfully. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

				}
				

			// }else{
				
			// }
			
		// }

		 
			// echo "<script>window.location='dashboard.php?option=view_students'</script>";
		}//file exist
		 
		}
		else{
		 echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>File Extension should be .csv, your file extension is .'.$ext.'</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
			   
		}
		 
		}  
		 
		else{
		  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>Please Upload File </h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
		 }
		
	}else{

		echo "<script>alert('Cannot Add more than $tstu Students. In this Session.')</script>";
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>Cannot Add more than '.$tstu.' Students. In this Session. </h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
	}	
		
	

}
?>



        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><a href="csv/upload_students.csv" class="btn btn-primary btn-sm">
								<i class="fa fa-download"></i> Download Format</a><br /><br /></strong>
                            </div>
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
<div class="row">
	<div class="col-md-12">
		<div class="panel-group">
			<div class="panel panel-default">
				
			<?php echo @$err; ?>	


		<div class="row">
			<div class="col-md-5">
				<div class="panel-body">
				<label>Upload Students</label>
<input class="form-control" type="file" required name="csvfile">
			
				</div>
			</div>
		</div><br>
			
		</div> <!-- End of section 1 row-->
			
													</div>
												</div>
											</div>
										</div>

<div class="card-footer">

	<button type="submit" value="Upload" class="btn btn-info btn-sm" name="upload">
	<i class="fa fa-upload"></i> Upload
	</button>
	
</div>
										
									</section>			
								</form>		
                            </div>
                            <div >

				    <strong ><h5>Instructions for uploading Csv file:-</h5></strong>
					<span>
					
					<ol style="margin-left:20px">
						<li>Register no must be unique of each students.</li>
						<li>Fees must be assign before Admission of those classes.</li>
						<li>D.o.b & Admission date format : (DD-MM-YYYY)</li>
						<li>Class name, Academic year, Religion, social category, Admission type, Message type these data must be match from our give CSV Format.</li>
					</ol>
				</span>

				</div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
