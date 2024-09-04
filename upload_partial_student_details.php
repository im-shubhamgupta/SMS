<?php 

include('connection.php');

extract($_REQUEST);

// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";
?>
<div id="right-panel"  style="width:100%">

         

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Student Panel</a>

  <a class="breadcrumb-item" href="#">Student</a>

  <span class="breadcrumb-item active">Import Partial Students Detail</span>

</nav>

<?php

if (isset($_POST['upload'])) 

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

 

	// readfile($_FILES['csvfile']['tmp_name']);

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
			

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){	

	
	if(!empty($data[0])){
		$regno=$con->real_escape_string(trim($data[0]));
	}else{
		$regno='';
	}
	$stuname=$con->real_escape_string(trim($data[1]));
	$father_name=$con->real_escape_string(trim($data[2]));
	$mother_name=$con->real_escape_string(trim($data[3]));
	$gender=$con->real_escape_string(trim($data[4]));
	$dob = $con->real_escape_string($data[5]);
	    if(!empty($dob)){
	        $dob=date("Y-m-d", strtotime(str_replace('/','-',$dob)));
		}else{
			$dob = '';
		}
	$admission_dt = $con->real_escape_string($data[6]);
		if(!empty($admission_dt)){
			$admissiondate=date("Y-m-d", strtotime(str_replace('/','-',$admission_dt)));
		}else{
		
			$admissiondate = '';
		}	
	$stucontact = $con->real_escape_string($data[7]);
       
	$parentno=$con->real_escape_string(trim($data[8]));
	$password=$con->real_escape_string(trim($data[9]));
	$stuaddress=$con->real_escape_string(trim($data[10]));

// echo "<br>regno: ".$regno;
	// $clsid=getStudent_byRegister_no($regno)['class_id'];
	$sql="select `register_no`,sr.class_id,sr.section_id from `students` as s join student_records as sr on s.student_id=sr.stu_id where `register_no`='$regno' and sr.session='".$_SESSION['session']."' ";


	$quec=$con->query($sql);
	if($quec->num_rows > 0){
		$resc=$quec->fetch_assoc();
		$clsid=$resc['class_id'];
	}else{
		$clsid='';
	}	
	

	// echo "<br>classid: ".$clsid;
	$admtype=$con->real_escape_string(trim($data[11]));
 
	
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
	
	

	$msgtype=$con->real_escape_string(trim($data[12]));
            if(!empty($msgtype)){
            	$Umsgtype=strtoupper($msgtype);
                $qmsg=mysqli_query($con,"select * from message_type where msg_name='$Umsgtype'");
                $rmsg=mysqli_fetch_array($qmsg);
                $msgtypeid=$rmsg['msg_type_id'];
            }else{
                $msgtypeid = '';
                $msgtype='';
            }
    $acdyear=$con->real_escape_string($data[13]);
        if(!empty($acdyear)){
			$aca=mysqli_query($con,"select * from session where year='$acdyear'");
			if(mysqli_num_rows($aca)){
				$aca1=mysqli_fetch_array($aca);
			    $session=$aca1['id'];
			}else{
				 $session='';
				 $acdyear='';
			}
        }else{
            $acdyear ='';
            $session='';
        }        
	
    $admrte=$con->real_escape_string(trim($data[14]));    
	$regligion = $con->real_escape_string(trim($data[15]));
			
    if(!empty($regligion)){
    	$Ureligion=strtoupper($regligion);
        $qreg=mysqli_query($con,"select * from religion where upper(religion_name)='$Ureligion'");
        $rreg=mysqli_fetch_array($qreg);
        $religionid = $rreg['religion_id'];
    }else{
        $religionid = 0;
    }

	
	 $caste=$con->real_escape_string(trim($data[16]));  

	$socialcat = $con->real_escape_string($data[17]);
    if(!empty($socialcat)){
    	$Usocialcat=strtoupper($socialcat);
        $qscat=mysqli_query($con,"select * from social_category where upper(soc_cat_name) = '$Usocialcat'");
        $rscat=mysqli_fetch_array($qscat);
        $socialcategory=$rscat['soc_cat_id'];
    }else{
        $socialcategory = '';
    }
    	 $bldgrp=$con->real_escape_string(trim($data[18]));  
    	 $mothertongue=$con->real_escape_string(trim($data[19]));  
    	 $aadharno=$con->real_escape_string(trim($data[20]));  
    	 $birthplace=$con->real_escape_string(trim($data[21]));  
    	 $village=$con->real_escape_string(trim($data[22]));  
    	 $father_qual=$con->real_escape_string(trim($data[23]));  
    	 $mother_qual=$con->real_escape_string(trim($data[24])); 
    	 $father_occu=$con->real_escape_string(trim($data[25])); 
    	 $mother_occu=$con->real_escape_string(trim($data[26])); 
    	 $father_incom=$con->real_escape_string(trim($data[27])); 
    	 $depend=$con->real_escape_string(trim($data[28]));  
    	 $guardians=$con->real_escape_string(trim($data[29]));  
    	 $nationality=$con->real_escape_string(trim($data[30])); 

    	 $subcaste=$con->real_escape_string(trim($data[31]));  
    	 $olanguage=$con->real_escape_string(trim($data[32]));  
    	 $present_address=$con->real_escape_string(trim($data[33]));  
    	 $prev_school=$con->real_escape_string(trim($data[34]));  
    	 $father_aadhar=$con->real_escape_string(trim($data[35]));  
    	 $mother_aadhar=$con->real_escape_string(trim($data[36]));  
    	 $account_no=$con->real_escape_string(trim($data[37]));  
    	 $ifsc_code=$con->real_escape_string(trim($data[38]));  
    	 $branch=$con->real_escape_string(trim($data[39]));  
    	 $bus=$con->real_escape_string(trim($data[40]));  

	// if($headerLine) { $headerLine = false; }
    	 // echo "<br>admtypeid".$admtypeid;

    if($regno=="" || $admissiondate=="" ||  $admissiondate=='1970-01-01' || $clsid==''  || $regligion=='' || $admtypeid=='' || $dob=='' || $dob=='1970-01-01' || $socialcat=='' || $msgtypeid==''  || $socialcategory==''){

				$not_upload[]=$regno;
				$error+=1;
				continue;	 

	}else{
		// academic_year='$acdyear',session='$session',   ,admission_date='$admissiondate'

		$query=mysqli_query($con,"update students set student_name='$stuname',father_name='$father_name',mother_name='$mother_name',
			gender='$gender',dob='$dob',student_contact='$stucontact',parent_no='$parentno',password='$password',
			stuaddress='$stuaddress',adm_type_id='$admtypeid',msg_type_id='$msgtypeid',	admin_rte='$admrte',
			religion_id='$religionid',caste='$caste',soc_cat_id='$socialcategory',blood_grp='$bldgrp',mother_tongue='$mothertongue',aadhar_card='$aadharno',birth_place='$birthplace',village='$village',	fqualification='$father_qual',mqualification='$mother_qual',foccupation='$father_occu',moccupation='$mother_occu',	fannual_income='$father_incom',dependents='$depend',guardians='$guardians',nationality='$nationality',subcaste='$subcaste',other_language='$olanguage',present_address='$present_address',previous_school='$prev_school',father_aadhar='$father_aadhar',	mother_aadhar='$mother_aadhar',student_bankacc='$account_no',ifsc_code='$ifsc_code',branch='$branch',bus_facility='$bus',modify_date=now()	where register_no='$regno'");
		if($query){
			$success_upload[]=$regno;
			$count+=1;

		}else{
			$false_query+=1;
		    $not_upload[]=$regno;
		}
	}




 

}//while
		//remove empty array key
		foreach($not_upload as $k => $v){
		 if(empty($v)){
		  unset($not_upload[$k]);
		  }
		}
		 // $show_error = count($array) == 0;

        $err_regisno=implode(', ', $not_upload);
		if(!empty($not_upload)){
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	   		<h4>('.$count.') Students Updated Successfully. This Register no. not updated ('.$err_regisno.') please check the given data. </h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
		}else{
			echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
	   		<h4>('.$count.') Students Updated Successfully. </h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';

		}

	// echo "<script>window.location='dashboard.php?option=view_students'</script>";

}

 

}else{

	 echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>File Extension should be .csv, your file extension is .'.$ext.'</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
// echo " Check Extension. your extension is ." . $ext;

}

 

}else{

    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>Please Upload File </h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';

 }
}

	// mysqli_query($con,"update students set student_name='$data[1]',father_name='$data[2]',mother_name='$data[3]',	gender='$data[4]',dob='$dob',admission_date='$admdt',student_contact='$data[7]',due='$due',parent_no='$data[8]',password='$data[9]',stuaddress='$nstuaddress',adm_type_id='$admtypeid',msg_type_id='$msgtypeid',academic_year='$data[13]',	admin_rte='$data[14]',religion_id='$religionid',caste='$data[16]',soc_cat_id='$socialcategory',blood_grp='$data[18]',mother_tongue='$data[19]',aadhar_card='$data[20]',birth_place='$data[21]',village='$data[22]',	fqualification='$data[23]',mqualification='$data[24]',foccupation='$data[25]',moccupation='$data[26]',	fannual_income='$data[27]',dependents='$data[28]',guardians='$data[29]',nationality='$data[30]',subcaste='$data[31]',

		// other_language='$data[32]',present_address='$npresent_address',previous_school='$data[34]',father_aadhar='$data[35]',	mother_aadhar='$data[36]',student_bankacc='$data[37]',ifsc_code='$data[38]',branch='$data[39]',bus_facility='$data[40]'	where register_no='$data[0]'");

?>






        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title"><a href="csv/upload_partial_student_details.csv" class="btn btn-primary btn-sm">

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
		<li>Session can't be updated.</li>
		<li>D.o.b & Admission date format : (DD-MM-YYYY)</li>
		<li>Class name, Academic year, Religion, social category, Admission type, Message type these data must be match from our Format.</li>
	</ol>
</span>

</div>	
</div>
                           

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

