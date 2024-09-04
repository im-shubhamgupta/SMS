<?php include('../myfunction.php');?>
<?php
date_default_timezone_set("Asia/Kolkata");
$const['session']=$_SESSION['session'];



if(isset($_POST['Add_Vechicle'])){
// echo "<pre>";
// print_r($_POST);
	$create_date=date('Y-m-d H:i:s');
$modify_date=$create_date;
$session=$_SESSION['session'];
$name=mysqli_real_escape_string($con,$_POST['name']);
$vehicletype=mysqli_real_escape_string($con,$_POST['vehicletype']);
$vehicleno=mysqli_real_escape_string($con,$_POST['vehicleno']);
$chassisno=mysqli_real_escape_string($con,$_POST['chassisno']);
$purchasedyear=mysqli_real_escape_string($con,$_POST['purchasedyear']);
$vehicle_status=mysqli_real_escape_string($con,$_POST['vehicle_status']);
$preexp=mysqli_real_escape_string($con,$_POST['preexp']);
$aboutvehicle=mysqli_real_escape_string($con,$_POST['aboutvehicle']);
$description=mysqli_real_escape_string($con,$_POST['description']);

		 $sql="insert into vehicle (vehicle_name,vehicle_type,vehicle_number,chassis_no,purchased_year,vehicle_status,about_vehicle,prev_exp,description,status,create_date,modify_date,session ) 	values ('$name','$vehicletype','$vehicleno','$chassisno','$purchasedyear','$vehicle_status','$aboutvehicle','$preexp',	'$description','0','$create_date','$modify_date','$session')";

		$query=mysqli_query($con,$sql);

		if($query){
			$responce['type']='success';						 
	        $responce['msg']=' Vechicle Added Successfully';
		 

		}else{
			// 	if(mysqli_error($con)){
	    	// 		echo ("Error description :" .mysqli_error($con));
   			// }
   			$responce['type']='error';						 
		        $responce['msg']='Something went wrong, Please try again'.mysqli_error($con);
	
		}		

echo json_encode($responce);

}
if(isset($_POST['Update_Vechicle'])){
// echo "<pre>";
// print_r($_POST);
	$create_date=date('Y-m-d H:i:s');
$modify_date=$create_date;
$name=mysqli_real_escape_string($con,$_POST['name']);
$vehicletype=mysqli_real_escape_string($con,$_POST['vehicletype']);
$vehicleno=mysqli_real_escape_string($con,$_POST['vehicleno']);
$chassisno=mysqli_real_escape_string($con,$_POST['chassisno']);
$purchasedyear=mysqli_real_escape_string($con,$_POST['purchasedyear']);
$vehicle_status=mysqli_real_escape_string($con,$_POST['vehicle_status']);
$preexp=mysqli_real_escape_string($con,$_POST['preexp']);
$aboutvehicle=mysqli_real_escape_string($con,$_POST['aboutvehicle']);
$description=mysqli_real_escape_string($con,$_POST['description']);
$vid=mysqli_real_escape_string($con,$_POST['vid']);


	$sql=mysqli_query($con,"select * from vehicle where vehicle_id='$vid'");

	$res=mysqli_fetch_array($sql);

	
		$uquery=mysqli_query($con,"update vehicle set vehicle_name='$name', vehicle_type='$vehicletype', vehicle_number='$vehicleno', 

		chassis_no='$chassisno',purchased_year='$purchasedyear', vehicle_status='$vehicle_status', about_vehicle='$aboutvehicle', 

		prev_exp='$preexp', description='$description', modify_date='$modify_date' where vehicle_id ='$vid'");		

		if($uquery){
			$responce['type']='success';						 
	        $responce['msg']=' Vechicle Updated Successfully';
	
		}else{
			$responce['type']='error';						 
		    $responce['msg']='Something went wrong, Please try again';
		
		}   
	echo json_encode($responce);	

}	

if(isset($_POST['Assign_Driver_Route'])){
// echo "<pre>";
// print_r($_POST);
$driver_id=mysqli_real_escape_string($con,$_POST['driver_id']);
$vehicle_id=mysqli_real_escape_string($con,$_POST['vehicle_id']);
$vehicle_no=mysqli_real_escape_string($con,$_POST['vehicle_no']);
$route_id=mysqli_real_escape_string($con,$_POST['route_id']);
$description=mysqli_real_escape_string($con,$_POST['description']);


	$q1 = mysqli_query($con,"select * from assign_driver_route where vehicle_id='$vehicle_id' and session='".$_SESSION['session']."'");

	$row = mysqli_num_rows($q1);

	if($row){

		$responce['type']='error';						 
		$responce['msg']='Already Assign this Vehicle';


	}else{

		$que="insert into assign_driver_route(driver_id,vehicle_id,vehicle_no,route_id,description,status,session,date,modify_date) values ('$driver_id','$vehicle_id','$vehicle_no','$route_id','$description','0','".$_SESSION['session']."',now(),now())";

		if(mysqli_query($con,$que)){

			$responce['type']='success';						 
	        $responce['msg']=' Driver/ Vehicle Assigned to Route Successfully';

		}else{
			$responce['type']='error';						 
		    $responce['msg']='Something went wrong, Please try again';
		}


	}
    echo json_encode($responce);
}
if(isset($_POST['Update_Assign_Driver_Route'])){
// echo "<pre>";
// print_r($_POST);
$aid=mysqli_real_escape_string($con,$_POST['aid']);
$driver_id=mysqli_real_escape_string($con,$_POST['driver_id']);
$vehicle_id=mysqli_real_escape_string($con,$_POST['vehicle_id']);
$vehicle_no=mysqli_real_escape_string($con,$_POST['vehicle_no']);
$route_id=mysqli_real_escape_string($con,$_POST['route_id']);
$description=mysqli_real_escape_string($con,$_POST['description']);



	$q1 = mysqli_query($con,"select * from assign_driver_route where vehicle_id='$vehicle_id' and session='".$_SESSION['session']."' and  assign_id !='$aid'");

	$row = mysqli_num_rows($q1);

		

		if($row){

			// echo "<script>alert('Already Assign Vehicle.')</script>";
			$responce['type']='error';						 
		    $responce['msg']='Already Assign this Vehicle';

		}else{

		$uquery=mysqli_query($con,"update assign_driver_route set driver_id='$driver_id', vehicle_id='$vehicle_id', vehicle_no='$vehicle_no', 

		route_id='$route_id',description='$description' , modify_date=now() where assign_id ='$aid'");	

		if($uquery){

			$responce['type']='success';						 
	        $responce['msg']='Updated Successfully';

		}else{
			$responce['type']='error';						 
		    $responce['msg']='Something went wrong, Please try again';
		}
}	
   echo json_encode($responce);
		
}

if(isset($_POST['Add_Transport'])){
// echo "<pre>";
// print_r($_POST);
$route_name=mysqli_real_escape_string($con,$_POST['route_name']);
$price=mysqli_real_escape_string($con,$_POST['price']);



		$route_name = trim($route_name, " ");

		$price = trim($price, " ");

		

		$sql=mysqli_query($con,"select * from transports where route_name='$route_name' and session='".$_SESSION['session']."' ");

		$res=mysqli_num_rows($sql);

		if($res)

		{
			$responce['type']='error';						 
		    $responce['msg']='This Route Is Already Exists. Plaese Select Another Route';


		}else{

			$query="insert into transports (trans_id, route_name, price,status,session,create_date,modify_date) values('0','$route_name','$price','1','".$_SESSION['session']."',now(),now())";	

			if(mysqli_query($con,$query)){



				$responce['type']='success';						 
		        $responce['msg']=' Transport Added Successfully';

			}else{
					$responce['type']='error';						 
			        $responce['msg']='Something went wrong, Please try again';
			}
	    }
	     echo json_encode($responce);
}
if(isset($_POST['Update_Transport'])){
// echo "<pre>";
// print_r($_POST);
$tid=mysqli_real_escape_string($con,$_POST['tid']);	
$rname=mysqli_real_escape_string($con,$_POST['rname']);
$price=mysqli_real_escape_string($con,$_POST['price']);


	$rname = trim($rname, " ");

    $price = trim($price, " ");
    	 $usql="update transports set route_name='$rname', price='$price', modify_date=now() where trans_id='$tid'";
		$update=mysqli_query($con,$usql);		

		if($update){
			$responce['type']='success';						 
	        $responce['msg']=' Transport Updated Successfully';

		}else{
			$responce['type']='error';						 
	        $responce['msg']='Something went wrong, Please try again';
		}
echo json_encode($responce);

}

if(isset($_POST['Add_Transport_Expense_Type'])){
// echo "<pre>";
// print_r($_POST);
$expense=mysqli_real_escape_string($con,$_POST['expense']);	
	
		$expense = trim($expense, " ");
		$sql=mysqli_query($con,"select * from transport_expense_type where trans_expense_type_name='$expense' and session='".$_SESSION['session']."' ");

		$res=mysqli_num_rows($sql);

		if($res){
			
			$responce['type']='error';						 
	        $responce['msg']='This Expense Type Is Already Exists';

		}else{

			$query=mysqli_query($con,"insert into transport_expense_type (trans_expense_type_name,session,create_date,modify_date) values('$expense','".$_SESSION['session']."',now(),now())");	

			if($query){
			   $responce['type']='success';						 
	           $responce['msg']=' Expense Type Added Successfully ';

		    }else{
			   $responce['type']='error';	
			   $responce['msg']='Something went wrong, Please try again';					 
     		}


    	}

echo json_encode($responce);

}
if(isset($_POST['Update_Transport_Expense_Type'])){
// echo "<pre>";
// print_r($_POST);
$eid=mysqli_real_escape_string($con,$_POST['eid']);	
$expense=mysqli_real_escape_string($con,$_POST['expense']);	

		$expense = trim($expense," ");
		$sql="select * from transport_expense_type where trans_expense_type_name='$expense' and trans_expense_type_id !='$eid' and session='".$_SESSION['session']."' ";
		$sql1=mysqli_query($con,$sql);

		$res1=mysqli_num_rows($sql1);

		if($res1){
			$responce['type']='error';						 
	        $responce['msg']='This Expense Type Is Already Exists';

		}else{

			$query = mysqli_query($con,"update transport_expense_type set trans_expense_type_name='$expense',modify_date=now() where trans_expense_type_id ='$eid' ");

						

		    if($query){
			   $responce['type']='success';						 
	           $responce['msg']=' Updated Successfully ';

		    }else{
			   $responce['type']='error';	
			   $responce['msg']='Something went wrong, Please try again';					 
     		}

		}	

echo json_encode($responce);

}
if(isset($_POST['Add_Transport_Expense'])){
// echo "<pre>";
// print_r($_POST);
// print_r($_FILES);
$expdetail=mysqli_real_escape_string($con,$_POST['expdetail']);
$expensetype=mysqli_real_escape_string($con,$_POST['expensetype']);
$amount=mysqli_real_escape_string($con,$_POST['amount']);
$poc=mysqli_real_escape_string($con,$_POST['poc']);
$issdate=mysqli_real_escape_string($con,$_POST['issdate']);
			// $qe = mysqli_query($con,"select * from transport_expense_type where trans_expense_type_id ='$expensetype'");

			// $re = mysqli_fetch_array($qe);

			// $expname = $re['trans_expense_type_name'];
	$img=$file=$_FILES['proofs']['name'];
	if($img==""){

		$query=mysqli_query($con,"insert into transport_expense (trans_expense_type_id,trans_expense_details,amount,proofs,point_of_contact,expensed_datetime,date,status,session,create_date,modify_date) values('$expensetype','$expdetail',$amount,'','$poc','$issdate',now(),'0','".$_SESSION['session']."',now(),now())");	

		// if(mysqli_error($con)){
		// echo("Error description: " . mysqli_error($con));

			if($query){
			   $responce['type']='success';						 
	           $responce['msg']='Expense Added Successfully';

		    }else{
			   $responce['type']='error';	
			   $responce['msg']='Something went wrong, Please try again';					 
		        }

	}else{
		
		$name=explode('.',$img);
		$ext=pathinfo($img,PATHINFO_EXTENSION);
		// $num=substr($name[0],0,4);                   //take four letter only 
		$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;

		if(move_uploaded_file($_FILES['proofs']['tmp_name'],"../images/transport/".$image_name)){

			$isql="insert into transport_expense (trans_expense_type_id,trans_expense_details,amount,proofs,point_of_contact,expensed_datetime,date,status,session,create_date,modify_date)	values('$expensetype','$expdetail',$amount,'$image_name','$poc','$issdate',now(),'0','".$_SESSION['session']."',now(),now() )";
			$query=mysqli_query($con,$isql);	

			if($query){
			   $responce['type']='success';						 
	           $responce['msg']='Expense Added Successfully';

		    }else{
			   $responce['type']='error';	
			   $responce['msg']='Something went wrong, Please try again';					 
		        }


		}else{
			$responce['type']='error';	
	        $responce['msg']='Something Error, Attachment not Uploaded ';	

		}
	}
echo json_encode($responce);
}
if(isset($_POST['Update_Transport_Expense'])){
// echo "<pre>";
// print_r($_POST);
// print_r($_FILES);
$expdetail=mysqli_real_escape_string($con,$_POST['expdetail']);
$expensetype=mysqli_real_escape_string($con,$_POST['expensetype']);
$amount=mysqli_real_escape_string($con,$_POST['amount']);
$poc=mysqli_real_escape_string($con,$_POST['poc']);
$issdate=mysqli_real_escape_string($con,$_POST['issdate']);
$oldproof=mysqli_real_escape_string($con,$_POST['oldproof']);
$eid=mysqli_real_escape_string($con,$_POST['eid']);

	$dt=$issdate;

	$newdt=date("Y-m-d H:i:s",strtotime($dt));

	$pic=$_FILES['proofs']['name'];
	// $qe = mysqli_query($con,"select * from transport_expense_type where trans_expense_type_id ='$expensetype'");

	// $re = mysqli_fetch_array($qe);

	// $expname = $re['trans_expense_type_name'];
	if($pic==""){

		$que1=mysqli_query($con,"update transport_expense set trans_expense_type_id='$expensetype', trans_expense_details='$expdetail',	amount='$amount',point_of_contact='$poc',expensed_datetime='$issdate',date='$newdt' ,modify_date=now()	where trans_expense_id='$eid' and session='".$_SESSION['session']."'");

		if($que1){
			$responce['type']='success';						 
		            $responce['msg']='Expense Updated Successfully';

		}else{
			$responce['type']='error';	
        			$responce['msg']='Something went wrong, Please try again';

		}
		


	}else{
			$name=explode('.',$pic);
			$ext=pathinfo($pic,PATHINFO_EXTENSION);
			// $num=substr($name[0],0,4);                   //take four letter only 
			$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
			// echo $_FILES['proofs']['tmp_name'];
			if(move_uploaded_file($_FILES['proofs']['tmp_name'],"../images/transport/".$image_name)){

				$que1=mysqli_query($con,"update transport_expense set trans_expense_type_id='$expensetype', trans_expense_details='$expdetail',

				amount='$amount',proofs='$image_name',point_of_contact='$poc',expensed_datetime='$issdate',

				date='$newdt' ,modify_date=now() where trans_expense_id='$eid'  and session='".$_SESSION['session']."'");

				if($que1){

					if(!empty($oldproof) && file_exists('../images/transport/'.$oldproof.'')){
					    unlink ("images/transport/$oldproof");
				    }

					$responce['type']='success';						 
		            $responce['msg']='Expense Updated Successfully';
				}else{
					$responce['type']='error';	
        			$responce['msg']='Something went wrong, Please try again';
				}
	        }else{
	        	$responce['type']='error';	
	        $responce['msg']='Something Error, Attachment not Uploaded ';	
	        }
    }

    echo json_encode($responce);

  }  
if(isset($_POST['Create_Previous_transport_fees'])){
// echo "<pre>";
// return print_r($_POST);
$classid=mysqli_real_escape_string($con,$_POST['classid']);
$sectionid=mysqli_real_escape_string($con,$_POST['sectionid']);
$student=mysqli_real_escape_string($con,$_POST['student']);
$prevtransfee=mysqli_real_escape_string($con,$_POST['prevtransfee']);
$remark=mysqli_real_escape_string($con,$_POST['remark']);

$panelid=mysqli_real_escape_string($con,$_POST['panelid']);
$menuid=mysqli_real_escape_string($con,$_POST['menuid']);
$submenuname=mysqli_real_escape_string($con,$_POST['submenuname']);
$machinename=mysqli_real_escape_string($con,$_POST['machinename']);
$ExactBrowserNameBR=mysqli_real_escape_string($con,$_POST['ExactBrowserNameBR']);

	$roles=$_SESSION['user_roles'];
	$session=$_SESSION['session'];	
		$create_date=date('Y-m-d H:i:s');
$modify_date=$create_date;


	// $que = mysqli_query($con,"select * from students where student_id='$student' AND session='$session' ");
	$psql="select `student_id`,`student_name` from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$student' && stu_status='0'  && sr.session='".$_SESSION['session']."' ";
	$que = mysqli_query($con,$psql);

	$res = mysqli_fetch_array($que);

	$stuname = $res['student_name'];

	

	$q1 = mysqli_query($con,"select * from previous_transport_fees where student_id='$student' AND session='$session' ");

	$row = mysqli_num_rows($q1);

	if($row){
		$responce['type']='error';						 
		$responce['msg']='Previous Transport Fees Already Entered.';

	}else{

		$q2 = "insert into previous_transport_fees (student_id,class_id,section_id,previous_transport_fees,remarks,`session`,`create_date`,`modify_date`) 

		values('$student','$classid','$sectionid','$prevtransfee','$remark','$session','$create_date','$modify_date')";

		if(mysqli_query($con,$q2)){
			 // $usql="update `student_route` SET `due_amount`=(`due_amount` + '$prevtransfee' ) , `modify_date`='$modify_date'  where  `student_id`='$student' AND `class_id`='$classid' AND `session` ='$session' ";
		    // mysqli_query($con,$usql);

			$action = "Previous Transport Fees for ".$stuname." is Created"; 

			$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

			machine_name,browser,date,session) 

			values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$create_date','$session')");

			$responce['type']='success';						 
		    $responce['msg']='Previous Transport Fees Entered Successfully';



	    }else{
	    	$responce['type']='error';	
        			$responce['msg']='Something went wrong, Please try again';
	    }	

	}
echo json_encode($responce);
}	

if(isset($_POST['Assign_Route_to_Student'])){
// echo "<pre>";
// echo print_r($_POST);
$class=mysqli_real_escape_string($con,$_POST['class']);
$section=mysqli_real_escape_string($con,$_POST['section']);
$student=mysqli_real_escape_string($con,$_POST['student']);
$route=mysqli_real_escape_string($con,$_POST['route']);
$fmode=mysqli_real_escape_string($con,$_POST['fmode']);
$ramt=mysqli_real_escape_string($con,$_POST['ramt']);
$updatedfee=mysqli_real_escape_string($con,$_POST['updatedfee']);
$reason=mysqli_real_escape_string($con,$_POST['reason']);


$session=$_SESSION['session'];	


	$q1 = mysqli_query($con,"select * from transports where trans_id='$route'  ");

	$r1 = mysqli_fetch_array($q1);

	$ramt = $r1['price'];

	if($fmode=="1"){
		$routefee = $ramt;

		$discount = 0.00;

	}else{

		$routefee = $updatedfee;  //updated fee is discounted amount

		$discount = $ramt - $updatedfee;

	}
	// $newdue = $olddue + $routefee;

	$qchk = mysqli_query($con,"select * from student_route where student_id='$student' AND `session`='$session' ");

	if($row = mysqli_num_rows($qchk)){

		$responce['type']='error';						 
		$responce['msg']='Transport Fee already assigned to Student.';

	}else{
		


		$create_date=date('Y-m-d H:i:s');
     	$modify_date=$create_date;
		
        //$fee_start_month=date('m');
		$fee_start_month=$_POST['fee_start_month'];
       // $financial_month=get_months_byid($fee_start_month)['fee_order_month'];
        
        $no_of_months=(intval('12')-(int)($fee_start_month))+1;
        
        $total_due_amount=$routefee*$no_of_months;

		$que = mysqli_query($con,"insert into student_route (student_id,class_id,section_id,trans_id,fee_mode_id,price,discount,no_of_months,fee_start_month,reason,due_amount,status,session,create_date,modify_date) 

		values( '".$student."', '".$class."', '".$section."', '".$route."', '".$fmode."', '".$routefee."', '".$discount."','".$no_of_months."','".$fee_start_month."', '".$reason."', '".$total_due_amount."', 1, '$session', '$create_date', '$modify_date'  )");

		// if(mysqli_error($con)){	echo ("Error description :" .mysqli_error($con));  }
		if($que){
			
            $responce['type']='success';						 
            $responce['msg']='Assign Route Successfully ';
			   

		  
	    }else{
	    	$responce['type']='error';						 
		   $responce['msg']='Something went wrong, Please try again'.mysqli_error($con);
		
	    }

	}
	echo json_encode($responce);

}

if(isset($_POST['Update_Assign_Route_to_Student'])){
    // echo "<pre>";
    // echo print_r($_POST);
    // die;
  
    $id=mysqli_real_escape_string($con,$_POST['id']);
    $route=mysqli_real_escape_string($con,$_POST['route']);
    $fmode=mysqli_real_escape_string($con,$_POST['fmode']);
    $orgprice=mysqli_real_escape_string($con,$_POST['orgprice']);
    $actual_fee=mysqli_real_escape_string($con,$_POST['actual_fee']);
   
    $updatedfee=mysqli_real_escape_string($con,$_POST['updatedfee']);
    $reason=mysqli_real_escape_string($con,$_POST['reason']);
    $fee_start_month=mysqli_real_escape_string($con,$_POST['fee_start_month']);
    
    
    $session=$_SESSION['session'];	
    
if(!empty($id)){
        if($fmode=="1"){

            $routefee = $updatedfee;

            $discount = 0;

        }else{

            $routefee = $updatedfee;

            $discount = $actual_fee - $updatedfee;
        }
        $newdue = $routefee;
   
            
        
        $modify_date=date('Y-m-d H:i:s');
        if(!empty($fee_start_month)){
            $fee_start_month=$fee_start_month;
       
        
            $financial_month=get_months_byid($fee_start_month)['fee_order_month'];
            
            $no_of_months=(intval('12')-($financial_month))+1;
            
            $total_due_amount=$routefee*$no_of_months;

            $Usql=" ,due_amount='$total_due_amount' ,  no_of_months='$no_of_months', fee_start_month='$fee_start_month' ";

        }else{

            $Usql=" ,due_amount='$newdue' ";
            // $fee_start_month=date('m');
        }
        
//, due_amount='$newdue'
        $que = mysqli_query($con,"update student_route set trans_id='$route', fee_mode_id='$fmode', price='$routefee',

        discount='$discount', reason='$reason' $Usql , `modify_date`='$modify_date' where sturoute_id='$id' ");

        if($que){
            $responce['type']='success';						 
            $responce['msg']='Assign Route updated Successfully ';
        }else{
            $responce['type']='error';						 
            $responce['msg']='Something went wrong, Please try again'.mysqli_error($con);
        
        }
                

    
}else{
    $responce['type']='error';						 
	$responce['msg']='Something went wrong, Please try again'.mysqli_error($con);
		
}    
echo json_encode($responce);


}    


/*if(isset($_POST['Load_View_transport_fee_detail_Format'])){
// echo "<pre>";
// echo print_r($_POST);
	$class=mysqli_real_escape_string($con,$_POST['class']);
	$section=mysqli_real_escape_string($con,$_POST['section']);
	$session=$_SESSION['session'];
	if($class!="" and $section=="All"){
		$query = "SELECT * FROM `student_route` WHERE `class_id`='$class' and session='$session' ";

	 }elseif($class!="" and $section!="All"){

		$query = "SELECT * FROM `student_route` WHERE `class_id`='$class' and section_id='$section' and session='$session' ";

	}elseif(empty($class)){

		$query = "SELECT * FROM `student_route` WHERE 1 and session='$session'  ";
	}	

   $filter_Result = mysqli_query($con, $query);

	if(mysqli_num_rows($filter_Result) > 0){

	   
									$sr=1;

					while($res=mysqli_fetch_array($filter_Result)){

						$stuid=$res['student_id'];

						$dueamt=$res['due_amount'];

						$q1 = mysqli_query($con,"select * from students where student_id='$stuid' and session='$session' ");

						$r1 = mysqli_fetch_array($q1);

						$stuname=$r1['student_name'];

						$regno=$r1['register_no'];

						$fathername=$r1['father_name'];

						$contact=$r1['parent_no'];

													

						$clsid=$r1['class_id'];

						$q2 = mysqli_query($con,"select * from class where class_id='$clsid'");

						$r2 = mysqli_fetch_array($q2);

						$classname = $r2['class_name'];

						

						$secid=$r1['section_id'];

						$q3 = mysqli_query($con,"select * from section where section_id='$secid'");

						$r3 = mysqli_fetch_array($q3);

						$secname = $r3['section_name'];

						

						$transid = $res['trans_id'];

						$q4 = mysqli_query($con,"select * from transports where trans_id='$transid'");

						$r4 = mysqli_fetch_array($q4);

						$trans_amt = $r4['price'];

						

						$trans_disc = $res['discount'];

						

						$q5 = mysqli_query($con,"select * from previous_transport_fees where student_id='$stuid' and session='$session' ");

						$r5 = mysqli_fetch_array($q5);

						if(mysqli_num_rows($q5))

							{

							$pretransfee = $r5['previous_transport_fees'];

							}

							else

							{

								$pretransfee = 0;

							}

							

						$total_amount = $trans_amt + $pretransfee - $trans_disc; 

						

						$qfee2 = mysqli_query($con,"select * from student_transport_due_fees where student_id='$stuid' && (status='0' || status='1') and session='$session' ");

						$tramt = 0;

						$ptramt = 0;

						$total_amt_paid = 0;

						while($rfee2 = mysqli_fetch_array($qfee2)){

							$rectransamt = $rfee2['trans_amount'];
							$tramt = $tramt + $rectransamt;
							$prevtransamt = $rfee2['previous_trans_amount'];
							$ptramt = $ptramt + $prevtransamt;

						}	
							$total_amt_paid += $tramt + $ptramt;
						   $duefee = $trans_amt + $pretransfee - $trans_disc - $total_amt_paid;

						?>

					<!-- 	<tr>

							<td><?php echo $sr; ?></td>

							<td><?php echo $stuname; ?></td>

							<td><?php echo $regno; ?></td>

							<td><?php echo "Mr&nbsp;".$fathername; ?></td>

							<td><?php echo $classname; ?></td>

							<td><?php echo $secname; ?></td>

							<td><?php echo $contact; ?></td>

							<td><?php echo $trans_amt; ?></td> -->

						<!-- 	<td><?php echo $pretransfee; ?></td>

							<td><?php echo $trans_disc; ?></td>

							<td><?php echo $total_amount; ?></td>

							<td><?php echo $total_amt_paid; ?></td>

							<td><?php echo $duefee; ?></td>

							<td>
 -->
							<?php 

							//if($dueamt==0){										

							?>

							<!-- <button type="button" class="btn btn-outline-success btn-sm" disabled>Generate Bill</button> -->

							<?php

							// }

							// else

							// {

							// echo "<a href='dashboard.php?option=generate_transport_bill&stuid=$stuid&smid=29' class='btn btn-outline-success btn-sm' target='_blank' title='Generate Bill'>Generate Bill</a>";

							// }

							?>

							

							<?php

							?>

						<!-- 	</td>
							<td>

							<?php // "<a href='dashboard.php?option=view_transport_payment&stuid=$stuid' class='btn btn-outline-success btn-sm'  target='_blank' title='View all Payment History'>Payment History</a>";?>

							</td>
						</tr>
 -->
				<?php
						// $sr++;

						// 	}

	   // }else{
	   	// echo "<tr><td colspan=9>No Data Found</td></tr>";
	   // }

// }*/

// ---------------------------------------------Add_Transport_bill----------------------------------------------------
if(isset($_POST['Add_Transport_bill']) || isset($_POST['Add_Transport_bill_print']) ){

    if(isset($_POST['Add_Transport_bill_print'])){
        $sms_send=1;
    }else{
        $sms_send='';
    }
// echo "<pre>";    
// print_r($_POST);
// die;
$Tcount=get_text_sms_count()['count_sms'];
$Wcount=get_whatsapp_sms_count()['count_sms'];
$Wstatus=get_whatsapp_sms_setting()['status'];
$Tstatus=get_text_sms_setting()['status'];
	$ntransfee=mysqli_real_escape_string($con,$_POST['ntransfee']);
	$totalpaid=mysqli_real_escape_string($con,$_POST['totalpaid']);
	$amtdue=mysqli_real_escape_string($con,$_POST['amtdue']);
	$paidby=mysqli_real_escape_string($con,$_POST['paidby']);
	$chqno=mysqli_real_escape_string($con,$_POST['chqno']);
	$bankname1=mysqli_real_escape_string($con,$_POST['bankname1']);
	$remarks1=mysqli_real_escape_string($con,$_POST['remarks1']);
	$txnno=mysqli_real_escape_string($con,$_POST['txnno']);
	$bankname2=mysqli_real_escape_string($con,$_POST['bankname2']);
	$remarks2=mysqli_real_escape_string($con,$_POST['remarks2']);
	$utrno=mysqli_real_escape_string($con,$_POST['utrno']);
	$issby=mysqli_real_escape_string($con,$_POST['issby']);
	$issdate=mysqli_real_escape_string($con,$_POST['issdate']);
	$remarks2=mysqli_real_escape_string($con,$_POST['remarks2']);
	$stuid=mysqli_real_escape_string($con,$_POST['stuid']);
	$route_fee=mysqli_real_escape_string($con,$_POST['route_fee']);
	$fee_start_month=mysqli_real_escape_string($con,$_POST['fee_start_month']);
	$month=$_POST['month'];
	$username=$_SESSION['user_roles'];
    $trans_id=get_student_route_bystuid($stuid,$_SESSION['session'])['trans_id'];

	if(!empty($_POST['nprevfee'])){
		$nprevfee=mysqli_real_escape_string($con,$_POST['nprevfee']);
	}else{
		$nprevfee=0;
	}

	if($totalpaid > 0){

	if($paidby=="2"){

		$paymentdetail = $chqno;
		$bankname = $bankname1;
		$remarks = $remarks1;

	}elseif($paidby=="3"){

		$paymentdetail = $txnno;
		$bankname = $bankname2;
		$remarks = $remarks2;

	}elseif($paidby=="4"){

		$paymentdetail = $utrno;

	}elseif($paidby==""){
		   $responce['type']='error';						 
		   $responce['msg']='Please Select paid by';
         echo json_encode($responce); die;

	}
    if(!empty($month)){
       $no_of_mon=count($month);
       $chkamount=intval($route_fee)*$no_of_mon;  //validate
       $months=implode(',',$month);
    }else{
        $responce['type']='error';						 
		$responce['msg']='Please Select Month';
        echo json_encode($responce); die;
    }
    if(empty($trans_id)){
        $responce['type']='error';						 
		$responce['msg']='Somethig error Route not found';
        echo json_encode($responce); die;
    }
    //validation for amount
    if($chkamount!=$ntransfee){
        $responce['type']='error';						 
		$responce['msg']='Do not accept partial Amount ,Please Enter complete Amount ';
        echo json_encode($responce); die;

    }
  


	$issdate1 = date("Y-m-d",strtotime($issdate));
	// $feestr = implode(',',$paidfee);

	// $feeidstr = implode(',',$paidfeeid);	
	$sset=mysqli_query($con,"select * from setting");

	$rsset=mysqli_fetch_array($sset);

	$sclname=$rsset['company_name'];

	
	$que=mysqli_query($con,"select `student_id`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'") ;

	$res1=mysqli_fetch_array($que);
		$stuname=$res1['student_name'];
		$clsid=$res1['class_id'];
		$gender=$res1['gender'];
		if($gender=="FEMALE")
		{
		 $gen="Daughter";	
		}
		else
		{
		 $gen="Son";	
		}
		$fname=$res1['father_name'];
		$classid=$res1['class_id'];
			$mobile=$res1['parent_no'];
	$msgtype=$res1['msg_type_id'];

		$qcls=mysqli_query($con,"select * from class where class_id='$classid'");
	   $rcls=mysqli_fetch_array($qcls);
	   $stuclass=$rcls['class_name'];
	   $sectionid=$res1['section_id'];	

		$qsec=mysqli_query($con,"select * from section where section_id='$sectionid'");

		$rsec=mysqli_fetch_array($qsec);

	   $stusec=$rsec['section_name'];
	if($paidby=="2"){

	   $msg = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." Transport Fees of Rs ".$totalpaid." has been received. The remaining amount ".$amtdue." is Pending.%0aDetails%0aPayment Mode: Cheque,%0aCheque No: ".$paymentdetail."%0aBank: ".$bankname."%0aRemarks: ".$remarks.".%0aFrom,%0a".$sclname;

	}else{

	   $msg = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." Transport Fees of Rs ".$totalpaid." has been received. The remaining amount ".$amtdue." is Pending.%0aFrom,%0a".$sclname;	

	}		

	   $msgn = "Dear Mr. ".$fname."<br>Your ".$gen." ".$stuname." Transport Fees of Rs ".$totalpaid." has been received. The remaining amount ".$amtdue." is Pending.<br>From,<br>".$sclname;

	
		$create_date=date('Y-m-d H:i:s');
     	$modify_date=$create_date;

		 $query1="insert into student_transport_due_fees (student_id,class_id,section_id,trans_id,trans_amount,previous_trans_amount,due_amount,month,fee_start_month,payment_type_id,payment_detail,bank_name,remarks,issued_by,issue_date,date,loginuser,session,create_date,modify_date) values ('$stuid','$clsid','$sectionid','$trans_id','$ntransfee','$nprevfee','$amtdue','$months','$fee_start_month','$paidby','$paymentdetail',	'$bankname','$remarks','$issby','$issdate','$issdate1','$username','".$_SESSION['session']."','$create_date','$modify_date')";

		$querycheck = mysqli_query($con,$query1); 

		// if(mysqli_error($con)){
      //   echo("Error description: " . mysqli_error($con));
		// }

		if($querycheck){

			$uquery=mysqli_query($con,"update student_route set due_amount='$amtdue', modify_date='$modify_date' where student_id='$stuid' and session='".$_SESSION['session']."'");

			if($uquery){
                if($Wstatus=='1' &&  $Wcount >0 && $sms_send=='1' ){
                    $messagetype = 'transport_fee_paid';
                             $q1=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,msg_type,loginuser,notice_datetime,date,session)    
                     values(3,'$stuid','$clsid','$sectionid',0,'$mobile','$msgn','1','$issby','$issdate','$issdate1','".$_SESSION['session']."')");	
                         
                             if($msgtype==1 ){
                                 
                                 sendwhatsappMessage($mobile, $msg, $messagetype);
                             
                             }
                                    
                }
                if($sms_send=='1'){
                    $que2=mysqli_query($con,"select * from student_transport_due_fees order by student_trans_fee_id desc");

                             $res2=mysqli_fetch_array($que2);
         
                             $bid=$res2['student_trans_fee_id'];
         
                        $responce['type']='success';						 
                        $responce['msg']='Transport bill paid Successfully ';
                        $responce['url']='print_trans_receipt.php?id='.$bid.'';  
                }else{
                    $responce['type']='success';						 
                    $responce['msg']='Transport bill paid Successfully ';

                }
			  
		    }else{
		    	$responce['type']='error';						 
		       $responce['msg']='Something happened wrong, Please try again';
		    }
		}else{
			$responce['type']='error';						 
			       $responce['msg']='Something went wrong, Please try again'.mysqli_error($con);
		}
		  


	// echo "<script>window.location='dashboard.php?option=view_transport_fee_detail'</script>";
}else{
	   $responce['type']='error';						 
		$responce['msg']='Please enter the fees details';

}
echo json_encode($responce);

}
// ---------------------------------------Add_Transport_bill_print--------------------------------------------------
// if(isset($_POST['Add_Transport_bill_print'])){
// // echo "<pre>";
// // echo print_r($_POST);

// $Tcount=get_text_sms_count()['count_sms'];
// $Wcount=get_whatsapp_sms_count()['count_sms'];
// $Wstatus=get_whatsapp_sms_setting()['status'];
// $Tstatus=get_text_sms_setting()['status'];
// 	$ntransfee=mysqli_real_escape_string($con,$_POST['ntransfee']);
	
// 	$totalpaid=mysqli_real_escape_string($con,$_POST['totalpaid']);
// 	$amtdue=mysqli_real_escape_string($con,$_POST['amtdue']);
// 	$paidby=mysqli_real_escape_string($con,$_POST['paidby']);
// 	$chqno=mysqli_real_escape_string($con,$_POST['chqno']);
// 	$bankname1=mysqli_real_escape_string($con,$_POST['bankname1']);
// 	$remarks1=mysqli_real_escape_string($con,$_POST['remarks1']);
// 	$txnno=mysqli_real_escape_string($con,$_POST['txnno']);
// 	$bankname2=mysqli_real_escape_string($con,$_POST['bankname2']);
// 	$remarks2=mysqli_real_escape_string($con,$_POST['remarks2']);
// 	$utrno=mysqli_real_escape_string($con,$_POST['utrno']);
// 	$issby=mysqli_real_escape_string($con,$_POST['issby']);
// 	$issdate=mysqli_real_escape_string($con,$_POST['issdate']);
// 	$remarks2=mysqli_real_escape_string($con,$_POST['remarks2']);
// 	$stuid=mysqli_real_escape_string($con,$_POST['stuid']);
// 	$username=$_SESSION['user_roles'];

// 	if(!empty($_POST['nprevfee'])){
// 		$nprevfee=mysqli_real_escape_string($con,$_POST['nprevfee']);
// 	}else{
// 		$nprevfee=0;
// 	}

// 	if($totalpaid > 0){

		

// 	if($paidby=="2"){

// 		$paymentdetail = $chqno;

// 		$bankname = $bankname1;

// 		$remarks = $remarks1;

// 	}elseif($paidby=="3"){

// 		$paymentdetail = $txnno;

// 		$bankname = $bankname2;

// 		$remarks = $remarks2;

// 	}elseif($paidby=="4"){

// 		$paymentdetail = $utrno;

// 	}elseif($paidby==""){
// 		   $responce['type']='error';						 
// 		   $responce['msg']='Please Select paid by';
//          echo json_encode($responce); die;

// 	}

//    // $que=mysqli_query($con,"select * from students where student_id='$stuid'  && session='".$_SESSION['session']."'");
//    $que=mysqli_query($con,"select `student_id`,`student_name`,father_name,parent_no,gender,msg_type_id,sr.class_id,sr.section_id from students as s join student_records as sr ON s.student_id=sr.stu_id  where student_id='$stuid' && stu_status='0'  && sr.session='".$_SESSION['session']."'") ;


// 	$res1=mysqli_fetch_array($que);
// 		$stuname=$res1['student_name'];
// 		$clsid=$res1['class_id'];
// 		$gender=$res1['gender'];
// 		if($gender=="FEMALE"){
// 		   $gen="Daughter";	
// 		}else{
// 		   $gen="Son";	
// 		}
// 		$fname=$res1['father_name'];
// 		$classid=$res1['class_id'];

// 		$qcls=mysqli_query($con,"select * from class where class_id='$classid'");
// 	   $rcls=mysqli_fetch_array($qcls);
// 	   $stuclass=$rcls['class_name'];
// 	   $sectionid=$res1['section_id'];	

// 		$qsec=mysqli_query($con,"select * from section where section_id='$sectionid'");

// 		$rsec=mysqli_fetch_array($qsec);

// 	   $stusec=$rsec['section_name'];

	

// 	$issdate1 = date("Y-m-d",strtotime($issdate));

	

// 	$sset=mysqli_query($con,"select * from setting");
// 	$rsset=mysqli_fetch_array($sset);
// 	$sclname=$rsset['company_name'];

	

// 	$mobile=$res1['parent_no'];
// 	$msgtype=$res1['msg_type_id'];
//   $messagetype = 'transport_fee_paid';
	

// 	if($paidby=="2"){

// 	$msg = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." Transport Fees of Rs ".$totalpaid." has been received. The remaining amount ".$amtdue." is Pending.%0aDetails%0aPayment Mode: Cheque,%0aCheque No: ".$paymentdetail."%0aBank: ".$bankname."%0aRemarks: ".$remarks.".%0aFrom,%0a".$sclname;

// 	}else{

// 	$msg = "Dear Mr. ".$fname.",%0aYour ".$gen." ".$stuname." Transport Fees of Rs ".$totalpaid." has been received. The remaining amount ".$amtdue." is Pending.%0aFrom,%0a".$sclname;	

// 	}	

	

// 	$msgn = "Dear Mr. ".$fname.",<br>Your ".$gen." ".$stuname." Transport Fees of Rs ".$totalpaid." has been received. The remaining amount ".$amtdue." is Pending.<br>From,<br>".$sclname;

// 		// $totalpayble=$_REQUEST['totalpayble'];

// 		// $amtdue=$_REQUEST['amtdue'];
// 	   $create_date=date('Y-m-d H:i:s');
//      	$modify_date=$create_date;
	

// 	   $query1="insert into student_transport_due_fees (student_id,class_id,section_id,trans_amount,previous_trans_amount,due_amount,payment_type_id,payment_detail,bank_name,remarks,issued_by,issue_date,date,loginuser,session,create_date,modify_date) values ('$stuid','$clsid','$sectionid','$ntransfee','$nprevfee','$amtdue','$paidby','$paymentdetail','$bankname','$remarks','$issby','$issdate','$issdate1','$username','".$_SESSION['session']."','$create_date','$modify_date')";

		

// 	if(mysqli_query($con,$query1)){

// 		$uquery=mysqli_query($con,"update student_route set due_amount='$amtdue', modify_date='$modify_date' where student_id='$stuid' and session='".$_SESSION['session']."'");
// 		// $action = $stuname." Transport Fees of Rs ".$totalpaid." has been received."; 

// 		// $qa = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,machine_name,browser,date) values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

// 		   // if($Wstatus=='1' && $Tstatus=='1' && $Tcount >0 &&  $Wcount >0 ){
// 		   if($Wstatus=='1' &&  $Wcount >0 ){
// 		   	$messagetype = 'transport_fee_paid';
// 						$q1=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,selected_no,message,msg_type,loginuser,notice_datetime,date,session)

// 		    	values(3,'$stuid','$clsid','$sectionid',0,'$mobile','$msgn','1','$issby','$issdate','$issdate1','".$_SESSION['session']."')");	
					
// 						if($msgtype==1 ){
							
// 							sendwhatsappMessage($mobile, $msg, $messagetype);
						
// 							// sendtextMessage($mobile, $msgn, $messagetype);
// 						}
// 			}
//       if($uquery){
			  
// 			   	$que2=mysqli_query($con,"select * from student_transport_due_fees order by student_trans_fee_id desc");

// 					$res2=mysqli_fetch_array($que2);

// 					$bid=$res2['student_trans_fee_id'];

// 	         $responce['type']='success';						 
// 			   $responce['msg']='Transport bill paid Successfully ';
// 			   $responce['url']='print_trans_receipt.php?id='.$bid.'';
// 	   }else{
// 	    	$responce['type']='error';						 
// 	       $responce['msg']='Something happened wrong, Please try again';
// 	   }
// 	}else{
// 			$responce['type']='error';						 
// 			       $responce['msg']='Something went wrong, Please try again';
// 	}
// }else{
// 	   $responce['type']='error';						 
// 		$responce['msg']='Please enter the fees details';

// }
// echo json_encode($responce);
// }