<?php 

include('connection.php');

extract($_REQUEST);

?>
<div id="right-panel"  style="width:100%">

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Admission Panel</a>

  <span class="breadcrumb-item active">Import CSV Online Admission</span>

</nav>
<?php	
if (isset($_REQUEST['upload'])){

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);



if(!$_FILES['csvfile']['name'] == "")   

{ 



if($ext == "csv"){

 

 if(file_exists($base_name)){

      echo "file already exist" . $base_name;

}else{

	    

if (is_uploaded_file($_FILES['csvfile']['tmp_name'])){
	// echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";
	// readfile($_FILES['csvfile']['tmp_name']);

}

          $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
          fgetcsv($handle, 1000, ",");
		  $headerLine = true;
		  $count=0;
			$already=array();
			$not_upload=array();
			$success_upload=array();
			$error=0;
			$false_query=0;

while(($data = fgetcsv($handle, 1000, ","))!== FALSE){
	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";
	$calc_age='';
  $sr_no=mysqli_real_escape_string($con,trim($data[0]));
  $name=mysqli_real_escape_string($con,trim($data[1]));
  $fathername=mysqli_real_escape_string($con,$data[2]);
  $gender=mysqli_real_escape_string($con,$data[3]);
  $dob=mysqli_real_escape_string($con,$data[4]);
    if(!empty($dob)){
                // $dob=$dob;
        $dob=date("Y-m-d", strtotime(str_replace('/','-',$dob)));
          $date1=date_create($dob);
		$date2=date_create(date('Y-m-d'));
		$diff=date_diff($date1,$date2);
		$calc_age=$diff->format("%a ");
	}else{
		$dob = '';
	}
				

  $email=mysqli_real_escape_string($con,$data[5]);
  $phone=mysqli_real_escape_string($con,$data[6]);
  $aadhar=mysqli_real_escape_string($con,$data[7]);

  $qualification=mysqli_real_escape_string($con,trim($data[8]));
  if(!empty($qualification)){
    	$Uqualification=strtoupper($qualification);
        $qcls=mysqli_query($con,"select * from class where upper(class_name)='$Uqualification'");
        if(mysqli_num_rows($qcls)){
            $rcls=mysqli_fetch_array($qcls);
            $quali_id=$rcls['class_id'];
        }else{
        	$quali_id ='';
        }    
    }else{
        $quali_id ='';
    }

 
  $admission_at=mysqli_real_escape_string($con,$data[9]);
   if(!empty($admission_at)){
    	$Uadmission_at=strtoupper($admission_at);
        $qcls=mysqli_query($con,"select * from class where upper(class_name)='$Uadmission_at'");
        if(mysqli_num_rows($qcls)){
            $rcls=mysqli_fetch_array($qcls);
            $admiss_id=$rcls['class_id'];
        }else{
        	$admiss_id ='';
        }    
    }else{
        $admiss_id ='';
    }

 $address=mysqli_real_escape_string($con,trim($data[10]));
  $city=mysqli_real_escape_string($con,$data[11]);
  $state=mysqli_real_escape_string($con,$data[12]);
  $pincode=mysqli_real_escape_string($con,$data[13]);
  $regligion=mysqli_real_escape_string($con,trim($data[14]));
    if(!empty($regligion)){
    	$Ureligion=strtoupper($regligion);
        $qreg=mysqli_query($con,"select * from religion where upper(religion_name)='$Ureligion'");
        $rreg=mysqli_fetch_array($qreg);
        $religionid = $rreg['religion_id'];
    }else{
        $religionid = '';
    }
  $caste=mysqli_real_escape_string($con,$data[15]);
  $socialcat=mysqli_real_escape_string($con,$data[16]);
	if(!empty($socialcat)){
		$Usocialcat=strtoupper($socialcat);
	    $qscat=mysqli_query($con,"select * from social_category where upper(soc_cat_name) = '$Usocialcat'");
	    $rscat=mysqli_fetch_array($qscat);
	    $socialcategory=$rscat['soc_cat_id'];
	}else{
	    $socialcategory = '';
	}


 $previous_school=mysqli_real_escape_string($con,$data[17]);
  $previous_grade=mysqli_real_escape_string($con,$data[18]);

   if(!empty($previous_grade)){
    	$Uprevious_grade=strtoupper($previous_grade);
        $qcls=mysqli_query($con,"select * from grade where upper(grade_name)='$Uprevious_grade'");
        if(mysqli_num_rows($qcls)){
            $rcls=mysqli_fetch_array($qcls);
            $prev_grade_id=$rcls['grade_id'];
        }else{
        	$prev_grade_id ='';
        }    
    }else{
        $prev_grade_id ='0';
    }
  $previous_result=mysqli_real_escape_string($con,$data[19]);
  $previous_percentage=mysqli_real_escape_string($con,$data[20]);


  

	$que = mysqli_query($con,"select * from admission order by admission_id desc limit 1");
	$row = mysqli_num_rows($que);

	if($row){
		$res = mysqli_fetch_array($que);
		$refno = substr($res['reference_no'], 3); 
		$nerefno =$refno;
		$nerefno++;
		$newrefno = "ref".$nerefno;
	}else{
		$newrefno = "ref"."1";
	}

	// echo $chksql=;
	$CheckQuery = $con->query("SELECT `reference_no` FROM `admission` WHERE `phone` = '".$phone."' && `email`='".$email."' ");
			
			if($name=="" || $quali_id=='' || $admiss_id=='' || $religionid=='' || $socialcategory=='' || $prev_grade_id=='' || $dob=='' || $dob=='1970-01-01' || $sr_no=='' ){
				$not_upload[]=$sr_no;
				$error+=1;
	
				continue;
			}else if($CheckQuery->num_rows > 0){
				// print_r($already);
				$already[]=$sr_no;
				 // $not_upload[]=$sr_no;
				$error+=1;
				continue;
			}else{	

			$q1 = mysqli_query($con,"insert into admission (reference_no,name,fathername,gender,dob,age,email,phone,aadhar,qualification,grade,	address,city,state,pincode,religion,caste,category,previous_school,previous_grade,previous_result,previous_percentage,session,apply_date,modify_date) 	values ('$newrefno','$name','$fathername','$gender','$dob','$calc_age','$email','$phone','$aadhar','$quali_id','$admiss_id','$address',	'$city','$state','$pincode','$regligion','$caste','$category','$previous_school','$prev_grade_id','$previous_result','$previous_percentage','".$_SESSION['session']."',now(),now())");	

				if($q1){

					$success_upload[]=$sr_no;
					$count+=1;
				}else{

				
					$false_query+=1;
				    $not_upload[]=$sr_no;
				}

	       }
	}//while       

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
		 // $show_error = count($array) == 0;

        $err_already=implode(', ', $already);
        $err_regisno=implode(', ', $not_upload);

		if(!empty($err_already) && !empty($err_regisno)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Students uploaded successfully. This Sr no. has not been uploaded ( '.$err_regisno.' ) please check the given data & This Sr no. has not been uploaded ('.$err_already.' )due to already exist   </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

				}elseif(!empty($err_already)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Students uploaded successfully. This Sr no. not uploaded ('.$err_already.') due to already exist. </h4>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>';

				}elseif(!empty($err_regisno)){
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>('.$count.') Students uploaded successfully. This Sr no. not uploaded ('.$err_regisno.') please check the given data. </h4>
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
				
}

}else{

echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>File Extension should be .csv, your file extension is .'.$ext.'</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';
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

?>






        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">
                        	<div class="card-header">
                                <strong class="card-title"><a href="csv/upload_online_admission.csv" class="btn btn-primary btn-sm">
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

				<label>Upload Online Admission</label>

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
							<li>D.o.b & Admission date format : (DD-MM-YYYY)</li>
							<li>Class name, Academic year, Religion, social category these data must be match from our Format.</li>
						</ol>
					</span>

					</div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

