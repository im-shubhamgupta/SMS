<?php 

include('connection.php');
date_default_timezone_set('Asia/Kolkata'); 
mysqli_set_charset("utf8"); 


    $test_name= $_POST['test'];
	$class=$_POST['class'];
	$section=$_POST['section'];
	$subject=$_POST['subject'];
	
	 $ExistQuery = $con->query("SELECT test_id FROM `test` where test_name='".$test_name."' and session='".$_SESSION['session']."'  and subject_id='".$subject."' and class_id='".$class."'");
	 $ExistRow=$ExistQuery->fetch_assoc();

	 
	 $no_of_question= $ExistRow['no_of_question'];
	 $test_id= $ExistRow['test_id'];
	 
	 
	 // Read Csv File
	 $csvfile = $_FILES['csvfile']['name'];
	 $ext = pathinfo($csvfile, PATHINFO_EXTENSION);
	 $base_name = pathinfo($csvfile, PATHINFO_BASENAME);
     $allowed_ext = ['csv'];
	   
	 $ExistQuestions = 0;  
	 if(in_array($ext, $allowed_ext))
    {
		$filename = $_FILES['csvfile']['tmp_name'];   
        $handle = fopen($filename, "r");
        if(!$handle){
             die ('Cannot open file for reading');
         }
		 
       

      $ExistProducts = 0;
      $TotalProducts = 0;
	  $data = fgetcsv($Open, 1000, ",");	
	  fgetcsv($handle);		
      $count = 0;
	  $no_of_question=10;
	  
      while (($row = fgetcsv($handle, 10000, ",")) !== FALSE){
	
            if($no_of_question > $count )
            {
                       
                        $ques_name = $con->real_escape_string(trim($row['0']));
						
                        $option1 = $con->real_escape_string($row['1']);
                        $option2 = $con->real_escape_string($row['2']);
                        $option3 = $con->real_escape_string($row['3']);
                        $option4 = $con->real_escape_string($row['4']);
                        $type = trim($row['5']);
                        $answer = trim($row['6']);
                       // $level = trim($row['']);
                        $type_Array[]=$type;
                        $chapter =$con->real_escape_string(trim($row['7']));

                        $optionformat = trim($row['8']);

                        $LangType = trim($row['9']);

                        $section = trim($row['10']);

                        $based_on = $row['11'];

                        $ExistQuery = $con->query("SELECT `id` FROM `question` WHERE  `class` = '".$class."' AND `subject` = '".$subject."' AND (`ques_name` = '".$ques_name."' AND `ques_name`='') AND `test_id`='".$test_id."', AND  `type` = '".$type."'");

		               

                        if($ExistQuery->num_rows > 0){
                
                            $ExistQuestions += 1;
                
                            continue;
                
                            }else{
                             $ques_name=$ques_name;
                         
                            $Query = "INSERT INTO `question`(
                                         `test_id`,
                                         `class`, 
                            
                                         `subject`, 
                            
                            
                                         `chapter`,
                            
                                        `section`,
                            
                                         `ques_name`,
                            
                                        `option1`,
                            
                                        `option2`,
                            
                                        `option3`,
                            
                                        `option4`,
                            
                                         `type`,
                            
                                        `answer`,
                            
                                         `optionformat`,

                                         `based_on`,
                            
                                         `date`,
                            
                                         `modify_date`,
                            
                                         `status`,
                            
                                         `LangType`) 
                            
                                         VALUES (                                        
                                         '".$test_id."',
                            
                                         '".$class."',
                            
                                         '".$subject."',
                            
                                         '".$chapter."',
                            
                                         '".$section."',
                            
                                         '".$ques_name."',
                            
                                         '".$option1."',
                            
                                         '".$option2."',
                            
                                         '".$option3."',
                            
                                         '".$option4."',
                            
                                         '".$type."',
                            
                                         '".$answer."',
                            
                                         '".$optionformat."',

                                         '".$based_on."',
                            
                                         '".date('Y-m-d H:i:s')."',
                            
                                         '".date('Y-m-d H:i:s')."',
                            
                                         '1',
                            
                                         '".$LangType."')
                            
                                    ";
									
								
                                     $Result=$con->query($Query); 
									 
									 
									 $Question_ids[]=$con->insert_id;
									 
									 $count++;
									 
                                  }
                       // $msg = true;                        
            }
            else
            {
                //$count = "1";
            }
        }
	
		 if(!empty($Question_ids)){
			 $Question_ids=implode(',',$Question_ids);
			// echo "UPDATE `qb_bank_set` SET `qid`='".$Question_ids."' where id='".$qbset_id."'"; die;
		    // $UpdateQuey=$db2->query("UPDATE `qb_bank_set` SET `qid`='".$Question_ids."' where id='".$qbset_id."'");
		 }
        if($Result){
			echo "<script>alert('$ExistQuestions Question(s) have not been uploaded  and Assigned To Test because there Image name, Class and Subject is already presents in database. And remainig Question(s) are successfully uploaded and Assigend ')</script>";
			//if(in_array('0',$type_Array)){
				
			//echo "<script>location.href='img-questions-upload.php?qb=$qbset_id'</script>";
			//}else{
				
			 echo "<script>location.href='dashboard.php?option=assign-question'</script>";	
			//}
		}else{
			echo "<script>alert('$ExistQuestions Question(s) have not been updated because there Image name, Class and Subject is already presents in database.')</script>";
			//if(in_array('0',$type_Array)){
				 
			//echo "<script>location.href='img-questions-upload.php?qb=$qbset_id'</script>";
			//}else{
			 echo "<script>location.href='dashboard.php?option=assign-question'</script>";	
			//}
		}
    }else{
        echo "<script>alert('Allowed only Excel')</script>";
	    echo "<script>location.href='dashboard.php?option=assign-question'</script>";
    }
