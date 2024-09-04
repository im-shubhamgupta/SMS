<?php
include('../dbcontroller.php');  
// extract($_REQUEST);	

function login($email,$password)
{
	global $con;
	$data=array();
	$query = mysqli_query($con,"select * from users where email='$email' && pass='$password'");
	$row = mysqli_num_rows($query);
	if($row){

		$res = mysqli_fetch_assoc($query);
		@$temp = array();
	    $temp['user_id'] = $res['user_id']; 
	    $temp['username'] = $res['username']; 
	    $temp['roles'] = $res['roles']; 
	    $temp['phone'] = $res['phone']; 
	    $temp['email'] = $res['email']; 
	    $temp['profile_image'] = ($res['profile_image']) ? ($res['profile_image']) : "no_image.png" ; 
	    array_push($data,$temp);

		return $data;

	}else{
		return "";
	}
}


function profile($user_id, $sessionid){

	global $con;
	$data=array();
	$query = mysqli_query($con,"select * from users where user_id='$user_id'");
	$row = mysqli_num_rows($query);
	if($row)
	{		
		$res = mysqli_fetch_array($query);
		@$temp = array();
		// print_r($res);
		$temp['user_id'] = $res['user_id']; 
	    $temp['username'] = $res['username']; 
	    $temp['roles'] = $res['roles']; 
	    $temp['phone'] = $res['phone']; 
	    $temp['email'] = $res['email']; 
	    $temp['session_year'] =  getSessionByid($sessionid)['year']??''; 
	    $temp['status'] = ($res['status']=='1') ? 'Active' : 'Deactive'; 
	    $temp['profile_image'] = ($res['profile_image']) ? Call_Baseurl()."/images/admin/".$res['profile_image'] : Call_Baseurl()."/images/admin/"."no_image.png" ; 
		// array_push($data,$temp);

		return $temp;
	}
	else
	{
		return "";
	}
}

 function ClassNameById($class_id){
	 global $con;
	 $ClassQuery= $con->query("SELECT * FROM class WHERE class_id='$class_id'");
	 if($ClassQuery->num_rows>0){
		$ClassRow=  $ClassQuery->fetch_assoc();
		$class_name=$ClassRow['class_name'];
		return $class_name;
		 
	 }else{
		return '';
		  
		 
	 } 
 }
 
  function SectionNameById($section){
	 global $con;
	 $sectionQuery= $con->query("SELECT * FROM section WHERE section_id='$section'");
	 if($sectionQuery->num_rows>0){
		$SectionRow=  $sectionQuery->fetch_assoc();
		$section_name=$SectionRow['section_name'];
		return $section_name;
		 
	 }else{
		return '';
		  
		 
	 } 
 }

 function studentdetail($sessionid,$class_id,$student_id,$CurrentPage, $PerPage){
	 global $con;
	$data = array();

	$class=!empty($class_id) ? " AND `sr`.`class_id`= '$class_id'" : ""; 
	if(empty($class)){ 
		$student_id=!empty($student_id) ? " AND `sr`.`stu_id`= '$student_id' " : ""; 
	}else{
		$student_id='';
	}
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	
	$sql="select student_id,register_no,student_name,parent_no,msg_type_id,father_name,mother_name,due,gender,dob,sr.class_id,sr.roll_no,sr.section_id,stu_status from students as s join student_records as sr on s.student_id=sr.stu_id where 1 $class $student_id AND sr.session='$sessionid'  order by sr.roll_no ";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);

	$sql.=" LIMIT $c_page, $PerPage ";
	$q1=mysqli_query($con,$sql);
	// echo $sql;

	// $row=mysqli_num_rows($q1);
	if(mysqli_num_rows($q1)> 0)
	{	
		@$temp = array();
		while($r2 = mysqli_fetch_assoc($q1))
		{	
			// echo "<pre>";
			// print_r($r2);
			// echo "</pre>";

			$temp['student_id'] = $r2['student_id'];
			$temp['register_no'] = $r2['register_no'];
			$temp['roll_no'] = ($r2['roll_no']) ? ($r2['roll_no'])  : '0' ;
			$temp['student_name'] = $r2['student_name'];
			$temp['father_name'] = $r2['father_name'];
			$temp['mother_name'] = $r2['mother_name'];
			$temp['gender'] = $r2['gender'];
			$temp['dob'] = $r2['dob'];
			$temp['class_name'] = ClassNameById($r2['class_id']);
			// $temp['section']  = SectionNameById($r2['section_id']);
			$temp['section']  = GetSection($r2['section_id']);
			$temp['stu_image']=Call_Baseurl().'/'.getStudent_byStudent_id($r2['student_id'])['stu_image_path'] ?? '';
			$temp['parent_no']=$r2['parent_no'];
			$temp['due']=$r2['due'];

			$temp['status'] = ($r2['stu_status']=='0') ? 'Active' : 'Deactive'; 

			array_push($data, $temp);
		}
				
			$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data'] = $data;

			return $final;
			
	}else{
		   $final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data'] = [];
		return $final;
	}
	 
	 
	 
 }
 function studentdetail_byid($sessionid,$student_id){
	global $con;
   $data = array();

 
	   $student_id=!empty($student_id) ? " AND `sr`.`stu_id`= '$student_id' " : ""; 

   $sql="select admission_no,student_id,register_no,student_name,parent_no,msg_type_id,father_name,mother_name,due,gender,dob,blood_grp,aadhar_card,bus_facility,soc_cat_id,admission_date,nationality,village,caste,msg_type_id,stuaddress,present_address,password,admin_rte,sr.class_id,sr.section_id,sr.roll_no,stu_status from students as s join student_records as sr on s.student_id=sr.stu_id where 1 $student_id AND sr.session='$sessionid' order by sr.roll_no ";
 
   $q1=mysqli_query($con,$sql);

   $row=mysqli_num_rows($q1);
   if($row)
   {	
	   @$temp = array();
	   while($r2 = mysqli_fetch_array($q1))
	   {
		   // print_r($r2);
		   $temp['student_id'] = $r2['student_id'];
		   $temp['stu_image']=Call_Baseurl().'/'.getStudent_byStudent_id($r2['student_id'])['stu_image_path'] ?? '';
		   $temp['admission_no'] = $r2['admission_no'];
		   $temp['register_no'] = $r2['register_no'];
		   
		   $temp['student_name'] = $r2['student_name'];
		   $temp['father_name'] = $r2['father_name'];
		   $temp['mother_name'] = $r2['mother_name'];
		   $temp['class_name'] = ClassNameById($r2['class_id']);
		   $temp['section']  = SectionNameById($r2['section_id']);
		   $temp['roll_no'] =  ($r2['roll_no']) ? $r2['roll_no'] : '0'; 
		   $temp['gender'] = $r2['gender'];
		   $temp['dob'] = $r2['dob'];
		   $temp['password'] = $r2['password'];
		   $temp['due']=$r2['due'];
		   $temp['parent_no']=$r2['parent_no'];
		   $temp['blood_grp']=$r2['blood_grp'];
		   $temp['aadhar_card']=$r2['aadhar_card'];
		   $temp['bus_facility']=$r2['bus_facility'];
		   $temp['nationality']=$r2['nationality'];
		   $temp['village']=$r2['village'];
		   $temp['caste']=($r2['caste']) ? $r2['caste'] : 'N/A';
		   $temp['msg_type_id']=get_message_type($r2['msg_type_id']) ??'';
		   $temp['religion']=get_religion_name($r2['religion_id']) ??'';
		   $temp['soc_cat']=get_social_category_name($r2['soc_cat_id']) ??'';
		   $temp['admission_date']=date('d-m-Y',strtotime($r2['admission_date']));
		   $temp['admin_right']=$r2['admin_rte'];
		   $temp['stuaddress']=$r2['stuaddress'];
		   $temp['present_address']=$r2['present_address'];
		   $temp['status'] = ($r2['stu_status']=='0') ? 'Active' : 'Deactive'; 

		//    array_push($data, $temp);
		}
	   
		return $temp;
	}   
  
   else
   {
	   return "";
   }
	
	
	
}



function studentcount($sessionid)
{
	global $con;
	$data = array();
	// $q1=mysqli_query($con,"select * from students where stu_status='0' AND session='$sessionid'");
		$q1=mysqli_query($con,"select student_id,register_no,student_name,parent_no,msg_type_id,father_name,mother_name,gender,dob,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where stu_status='0' AND sr.session='$sessionid' ");
	$row=mysqli_num_rows($q1);
	if($row)
	{	
		@$temp = array();
		$temp['total_students'] = $row; 
		array_push($data, $temp);
		
		$q2 = mysqli_query($con,"select * from class");
		while($r2 = mysqli_fetch_array($q2))
		{
			
			$classid = $r2['class_id'];
			$classname = $r2['class_name'];

			// $q3 = mysqli_query($con,"select * from students where class_id='$classid'");
				$q3=mysqli_query($con,"select student_id,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where stu_status='0' AND  sr.class_id= '$classid' AND sr.session='$sessionid' ");
			$row3 = mysqli_num_rows($q3);
			if($row3)
			{
			@$temp = array();
			$temp['class_id'] = $classid;
			$temp['class_name'] = $classname;
			$temp['no_of_students'] = $row3;
			array_push($data, $temp);
			}
		}
		
			return $data;
	}
	else
	{
		return "";
	}
}


function Student_detailsById($student_id){
	global $con;
  // $Query= $con->query("select * from students where stu_status='0' AND  student_id= '$student_id'");
  	$Query=$con->query($con,"select student_id,register_no,`student_name`,parent_no,msg_type_id,father_name,mother_name,gender,dob,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where stu_status='0' AND  student_id= '$student_id'  ");// AND sr.session='$sessionid'
  if($Query->num_rows>0){
	$StudentData=  $Query->fetch_assoc();
   
     $data['student_name']= $StudentData['student_name'];
	  
	return $data;  
  }else{
	  
	 return ''; 
  }
	
	
}


function financedetail($session)
{
	global $con;
	$data = array();
		$session_sql=($session) ? " && session='$session' " : '';
	$swsql="select * from student_wise_fees where 1 $session_sql ";	 	
	$q1 = mysqli_query($con,$swsql);
	$row = mysqli_num_rows($q1);

	if($row)
	{
		
		$discamount = 0;
		$totalfee_tocollect = 0;
		while($res1 = mysqli_fetch_array($q1))
		{
			// print_r($res1);
			$discamount = $discamount + $res1['discount_amount'];
			
			$stramt = $res1['fee_amount'];
			$arramt = explode(',',$stramt);
			$strheader = $res1['fee_header_id'];
			$arrheader = explode(',',$strheader);
			$no_of_months = $res1['no_of_months'];
			
			$Student_Wise_Total_Amount = 0;
			for ($i = 0; $i < count($arrheader); $i++) {
				// echo $i."<br>";

				$chkyear=get_fee_header($arrheader[$i]);
				if($chkyear=='1'){
					$FeeHeadAmount = $arramt[$i];
			        $FeeHeadAmount = $FeeHeadAmount * $no_of_months;
					$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;
				}else{
					$FeeHeadAmount = $arramt[$i];
			        $Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;
				}
				
			}	
			$totalfee_tocollect += $Student_Wise_Total_Amount;
			// foreach($arramt as $k){
			// 	$totalfee_tocollect = $totalfee_tocollect + $k;
			// }		
		}
		
		
		$que3 = mysqli_query($con,"select * from previous_fees where 1 $session_sql");
		$totalpre_fee = 0;
		while($res3 = mysqli_fetch_array($que3))
		{
			$prevamt = $res3['previous_fees'];
			$totalpre_fee = $totalpre_fee + $prevamt;
		}
		// echo $totalpre_fee;
		
		$temp['header_name']= "Total Finance";
		$temp['amount']= $totalfee_tocollect+$discamount+$totalpre_fee; 
		array_push($data, $temp);

		$temp['header_name']= "Total Amount to Collect";
		$temp['amount']= $totalfee_tocollect+$totalpre_fee; 
		array_push($data, $temp);
		
		$que3=mysqli_query($con,"select * from student_due_fees where 1 $session_sql");
		// echo $row2 = mysqli_num_rows($que3);
		$tpaidamt = 0;
		$tpaidamt1 = 0;
		while($rque3=mysqli_fetch_array($que3))
		{
			$recdamt=$rque3['received_amount'];
			$tranamt=$rque3['transport_amount'];
			$arr = explode(',',$recdamt);
			
			foreach($arr as $k)
			{
			 $tpaidamt1 = $tpaidamt1 + floatval($k) ;
			}
			
			   $tpaidamt = $tpaidamt1;
		}
		// echo $tpaidamt;
			@$temp = array();
			$temp['header_name']= "Total Paid Amount";
			$temp['amount']= $tpaidamt; 
			array_push($data, $temp);
		
		
		$q1 = mysqli_query($con,"select * from student_wise_fees where 1 $session_sql");
		$dueamt = 0;
		
		while($r1 = mysqli_fetch_array($q1))
		{
			$dueamt = $dueamt + $r1['due_amount'];
		}
			@$temp = array();
			$temp['header_name']= "Total Due Amount";
			$temp['amount']= $dueamt; 
			array_push($data, $temp);
		
		
		@$temp = array();
		$temp['header_name']= "Total Discount Amount";
		$temp['amount']= $discamount;
		array_push($data, $temp);
		
		return $data;
	}
	else
	{
		return "";
	}
}


function expensename($sessionid)
{
	global $con;
	$data = array();
	$sql="select * from expense_type where 1 ";
	$q1=mysqli_query($con,$sql);
	$row=mysqli_num_rows($q1);
	if($row)
	{
			// $temp['expense_id'] = '0';
			// $temp['expense_name'] = "All";
			// array_push($data, $temp);
		
		while($r1 = mysqli_fetch_array($q1))
		{
			$expid = $r1['expense_type_id'];
			$expname = $r1['expense_type_name'];

			$temp['expense_id'] = $expid;
			$temp['expense_name'] = $expname;
			array_push($data, $temp);
			}
			
		    return $data;
	}
	else
	{
		return "";
	}
}


function expensedetail($fromdt,$todt,$expid,$sessionid,$CurrentPage,$PerPage){

	global $con;
	$data = array();
	$tot = array();

	if(!empty($fromdt) && !empty($todt)){
		$chgfrdt = date("Y-m-d", strtotime($fromdt));
	    $chgtodt = date("Y-m-d", strtotime($todt));

	    $datesql=" and  date between '$chgfrdt' AND '$chgtodt' ";


	}else{
		$datesql='';
	}
	$tot = 0;
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	$Sqlexpid=!empty($expid) ? " AND `expense_type_id`='$expid' " : '' ;
	$sql1="select * from expense where 1 $Sqlexpid $datesql group by expense_type_id";
	$q2=mysqli_query($con,$sql1);
	$TotalRecords = mysqli_num_rows($q2);
	$sql1.=" LIMIT $c_page, $PerPage ";
	$query = mysqli_query($con,$sql1);
	while($res = mysqli_fetch_assoc($query)){
		// print_r($res);
		$tot+= $res['amount'];
		
	}
	
		// $temp['total_expense'] = $tot;
		$final['total_expense'] = $tot;
		// array_push($data, $temp);
	
	
	// if($expid=="0"){  // 0 means all expense show
	if(empty($expid)){  // '' means all expense show
		
		
		$q1 = mysqli_query($con,"select * from expense_type");
		
		while($r1 = mysqli_fetch_array($q1))
		{
			$expenseid = $r1['expense_type_id'];
			$expensename = $r1['expense_type_name'];

			$sql="select SUM(`amount`) as `total_amt`,`expense_details`,`proofs`,`point_of_contact`,`expensed_datetime` from expense where expense_type_id='$expenseid' $datesql   having total_amt!='' "; 
			 $sql.=" LIMIT $c_page, $PerPage ";
			$q2 = mysqli_query($con,$sql);

			$row1 = mysqli_num_rows($q2);
			if($row1 > 0)
			{
				// echo "from to";
				$amount = 0;
				while($r2 = mysqli_fetch_array($q2))
				{
					$amount = $amount + $r2['amount'];
					@$temp = array();
					
					$temp['expense_name'] = ($expensename) ? $expensename : "NA" ;
					$temp['expense_amount'] = $r2['total_amt'];
					
					$temp['expense_details'] = $r2['expense_details'];
				
					$temp['proofs']=($r2['proofs']) ? Call_Baseurl()."/images/proof/".$r2['proofs'] : Call_Baseurl()."/images/no_image.png" ;
					$temp['point_of_contact']=$r2['point_of_contact'];
					$temp['expense_date'] = date('Y-m-d (H:i A)',strtotime($r2['expensed_datetime']));
					array_push($data, $temp);
				}
				// $temp['expense_amount'] = $amount ? ($amount) : "NA" ;
			    // array_push($data, $temp);
						
			}
		
		}
			
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;

		return $final;

		
	}else{
		// $sql="select * from expense where expense_type_id='$expid' $datesql ";
		$sql="select SUM(`amount`) as `total_amt`,`expense_details`,`proofs`,`point_of_contact`,`expensed_datetime` from expense where expense_type_id='$expid' $datesql   having total_amt!='' "; 
		$sql.=" LIMIT $c_page, $PerPage ";
		$q2 = mysqli_query($con,$sql);
		
		// if(mysqli_num_rows($q2) > 0){
			$tamount=0;
			$q3 = mysqli_query($con,"select * from expense_type where expense_type_id='$expid'");
			$r3 = mysqli_fetch_array($q3);
				
			$expname = $r3['expense_type_name'];
			while($r2 = mysqli_fetch_array($q2))
				{
					$amount = $amount + $r2['amount'];
					@$temp = array();
					
					$temp['expense_name'] = ($expname) ? $expname : "NA" ;
					$temp['expense_amount'] = $r2['total_amt'];
					
					$temp['expense_details'] = $r2['expense_details'];
				
					$temp['proofs']=($r2['proofs']) ? Call_Baseurl()."/images/proof/".$r2['proofs'] : Call_Baseurl()."/images/no_image.png" ;
					$temp['point_of_contact']=$r2['point_of_contact'];
					$temp['expense_date'] = date('Y-m-d (H:i A)',strtotime($r2['expensed_datetime']));
					array_push($data, $temp);
				}
			// while($r2 = mysqli_fetch_array($q2))
			// {
				
			// 	$tamount+=$r2['amount'];
			// }
				
			// @$temp = array();
			// $temp['expense_name'] = ($expname) ? ($expname) : "NA" ;
			// $temp['expense_amount'] = ($tamount) ? ($tamount) : "NA";
			// array_push($data, $temp);
				
				
			$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data'] = $data;

			return $final;

		// }else{
		// 	return '';
		// }	
		  
	}
}


function staffdetail($sessionid,$staff_id,$CurrentPage, $PerPage)
{
	global $con;
	$data = array();

	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';	

	$sql="select * from staff where  1 "; //session='$sessionid'
	$q2 = mysqli_query($con,$sql);
	$TotalRecords= mysqli_num_rows($q2);
	$sql.=" LIMIT $c_page, $PerPage ";
	// echo $sql;	
	$q1 = mysqli_query($con,$sql);
	$row1 = mysqli_num_rows($q1);
	if($row1)
	{
	@$temp = array();
	while($r1 = mysqli_fetch_array($q1))
	{
	
		$temp['id'] = $r1['st_id']; 
		$temp['staff_image'] = !empty($r1['image']) ? Call_Baseurl()."/staff/".str_replace('/','-',$r1['staff_id'])."/".$r1['image'] : Call_Baseurl()."/images/no_image.png";
		$temp['staff_name'] = $r1['staff_name']; 
		$temp['staff_id'] = $r1['staff_id']; 
		$temp['gender'] = $r1['gender']; 
		$temp['mobno'] = $r1['mobno']; 
		$temp['address'] = $r1['address'];
        $temp['qualification'] = $r1['qualification'];
        $temp['teaching_type'] = $r1['teaching_type'];	
		$temp['skills'] = $r1['skills'];
		$temp['joining_date'] = $r1['joining_date'];
		$temp['designation'] = $r1['designation'];
		array_push($data, $temp);
	}
	// if(!empty($staff_id)){
	// 	return $temp; // return single data
	// }else{
	// 	return $data;  //return array data
	// }
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	 
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = [];
		return $final;
	}
	
}
function staffdetail_byid($sessionid,$staff_id)
{
	global $con;
	$data = array();
	if(!empty($staff_id)){
	  $staffQuery= " AND st_id='$staff_id'";
	}else{
		$staffQuery='';
	}
	
	$q1 = mysqli_query($con,"select * from staff where 1 $staffQuery  "); //session='$sessionid'
	$row1 = mysqli_num_rows($q1);
	if($row1)
	{
	@$temp = array();
	while($r1 = mysqli_fetch_array($q1))
	{
	
		$temp['id'] = $r1['st_id']; 
		$temp['staff_image'] = !empty($r1['image']) ? Call_Baseurl()."/staff/".str_replace('/','-',$r1['staff_id'])."/".$r1['image'] : Call_Baseurl()."/images/no_image.png";
		$temp['staff_name'] = $r1['staff_name']; 
		$temp['staff_id'] = $r1['staff_id']; 
		$temp['gender'] = $r1['gender']; 
		$temp['mobno'] = $r1['mobno']; 
		$temp['address'] = $r1['address'];
        $temp['qualification'] = $r1['qualification'];
        $temp['teaching_type'] = $r1['teaching_type'];	
		$temp['skills'] = $r1['skills'];
		$temp['joining_date'] = $r1['joining_date'];
		$temp['designation'] = $r1['designation'];
		array_push($data, $temp);
	}
	return $temp;
	// if(!empty($staff_id)){
	// 	return $temp; // return single data
	// }else{
	// 	return $data;  //return array data
	// }
	 
	}else{
		return "";
	}
	
}



function department()
{
	global $con;
	$data = array();
	$q1 = mysqli_query($con,"select * from department");
	
	if(mysqli_num_rows($q1)>0)
	{
		while($res = mysqli_fetch_assoc($q1))
		{
		@$temp = array();
	    $temp['department id'] = $res['dept_id'];
	    $temp['departmanet name'] = $res['dept_name'];
		array_push($data, $temp);
		}
		return $data;
	}
	else
	{
		return "";
	}

}


function staffcommunication($deptid,$message,$login_userid,$session)
{
	global $con;
	date_default_timezone_set("Asia/Kolkata");
	$username=profile($login_userid,$session)['0']['username'];
	$session=($session) ? $session : '0'; 
	$q1 = mysqli_query($con,"select * from assign_department where dept_id='$deptid'");
	$row = mysqli_num_rows($q1);
	if($row)	
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$staffid=$r1['staff_id'];
			$qu = mysqli_query($con,"select * from staff where st_id='$staffid'");
			$ru = mysqli_fetch_array($qu);
			$mobile=$ru['mobno'];
			$msgtype=$ru['msg_type_id'];
					
			if($msgtype==1)
			{
			    $q2=mysqli_query($con,"insert into staff_notifications(category,dept_id,staff_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)
			values(1,'$deptid','$staffid','$mobile','$message','1','$username',now(),now(),'$session')");
			}
			else if($msgtype==2)
			{
				$q3=mysqli_query($con,"insert into staff_notifications(category,dept_id,staff_id,selected_no,message,msg_type,loginuser,notice_datetime,date,session)
			     values(1,'$deptid','$staffid','$mobile','$message','2','$username',now(),now(),'$session')");
				// $set=mysqli_query($con,"select * from sms_setting");
				// $rset=mysqli_fetch_array($set);
				// $senderid=$rset['sender_id'];
				// $apiurl=$rset['api_url'];
				// $apikey=$rset['api_key'];
	
				
			}
			
		}
		if($q2 || $q3){
		    // return "Message Sent.";
		    return "success";
		}else{
			return "error";
		}
		
	}else{
		return "";
	}
	
}


function classname()
{
	global $con;
	$data = array();
	$query=mysqli_query($con,"select * from class");
	
	if(mysqli_num_rows($query)>0)
	{
	
			$temp2['class_id'] ='0';
			$temp2['class_name'] = 'All';
			array_push($data, $temp2);
		$i=1;
			while($res = mysqli_fetch_array($query)){
			@$temp = array();
			$temp['class_id'] = $res['class_id'];
			$temp['class_name'] = $res['class_name'];
			array_push($data, $temp);
			
			}
			
	    return $data;
	}
	else
	{
		return "";
	}
}


function sectionname($classid){
	global $con;
	$data = array();
	if(empty($classid)){
		$temp2['section_id'] ='0';
		$temp2['section_name'] = 'All';
		array_push($data, $temp2);
		return $data;
	}else{
		$query=mysqli_query($con,"select * from section where class_id='$classid'");
	
		if(mysqli_num_rows($query)>0){
				
				$i='1';
				
				while($res = mysqli_fetch_array($query))
				{
					$secid = $res['section_id'];
					$secname = $res['section_name'];
					@$temp = array();
					$temp['section_id'] = $secid;
					$temp['section_name'] = $secname;
					array_push($data, $temp);
					$i++;
				}
				
			return $data;
		}
		else
		{
			return "";
		}

	}
	
}


function message($heading,$category,$classid,$sectionid,$message,$login_userid,$session,$template_id)
{
	global $con;
	date_default_timezone_set("Asia/Kolkata");
// echo $login_userid;
	$username=profile($login_userid,$session)['username'];
	
	$cond = '';
	$heading=($category=='5')? 'Important Information' : $heading;
	
	if(!empty($classid)){
		$cond.=" && sr.class_id=$classid";
	}else{
		$classid='0';
	}
	if(!empty($sectionid)){
		$cond.=" && sr.section_id=$sectionid";
	}else{
		$sectionid='0';
	}
	$session_sql=($session) ? " && sr.session=$session " : ''; 	
	$session=($session) ? $session : '0'; 	
	$sql="select student_id,register_no,student_name,parent_no,msg_type_id,father_name,mother_name,gender,dob,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where stu_status='0' $cond $session_sql  ";
	$q1=mysqli_query($con,$sql);
	$row = mysqli_num_rows($q1);
	if($row>0){
		while($r1 = mysqli_fetch_array($q1)){

			$studid=$r1['student_id'];
			$mobile=$r1['parent_no'];
			$allMobile[]=$r1['parent_no'];
			mysqli_set_charset($con, 'utf8');
			$q2=mysqli_query($con,"insert into student_notifications(category,student_id,class_id,section_id,subject,
			selected_no,heading,message,loginuser,notice_datetime,date,session)
			values('$category','$studid','$classid','$sectionid',0,'$mobile','$heading','$message','$username',now(),now(),$session)");
		}
	}
	/*send push notification*/
	$q2=mysqli_query($con,$sql);
	$row2 = mysqli_num_rows($q2);
	if($row2>0){
		while($r2 = mysqli_fetch_array($q2)){
			$token_id=$r2['token_id'];
			$parent_no=$r2['parent_no'];
			if(!empty($token_id) && !empty($message)){
				$title=$heading;
				$description=$message;
				push_notification_android($token_id, $title,$description);
			}	
				sendwhatsappMessage($parent_no,$message,'');
		}	
	}
	if($category=='5'){
		 $messagetype=get_textsms_templates_byid($template_id)['msg_type'];
		if (!empty($allMobile)) {
			sendtextMessage($allMobile, $message, $messagetype);
		}
	}

	if($q2){
		return "success";
	}else{
		return "error";
	}
	
	
}	
function message_list($classid, $sectionid,$category, $session, $login_user_id, $CurrentPage, $PerPage)
{
	global $con;
	$username=profile($login_user_id,$session)['username'];
	date_default_timezone_set("Asia/Kolkata");
	$data=array();
	$final=array();
	$cond = '';
	
	if(!empty($classid)){
		$cond.=" && class_id='$classid' ";
	}else{
		$classid='0';
	}
	if(!empty($sectionid)){
		$cond.=" && section_id='$sectionid'";
	}else{
		$sectionid='0';
	}
	$session_sql=($session) ? " && session=$session " : ''; 	
	$session=($session) ? $session : '0'; 	
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	
	$sql="select * FROM `student_notifications` where 1 AND `loginuser`='$username' $cond $session_sql and category='$category'  group by loginuser,date,message,heading ";
	mysqli_set_charset($con, 'utf8');
	$q1=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q1);
	$sql.= " Order by st_notification_id desc ";
	$sql .= " Limit $c_page, $PerPage ";
	// echo $sql;
	$q2=mysqli_query($con,$sql);
	$row = mysqli_num_rows($q2);

	if($row)	
	{
		while($r1 = mysqli_fetch_array($q2))
		{

			$temp['class_name']=GetClass($r1['class_id']) ?? '';
			$temp['section_name']=GetSection($r1['section_id']) ?? '';
			$temp['heading']=!empty($r1['heading']) ? $r1['heading'] : 'N/A';
			$temp['message']=!empty($r1['message']) ? $r1['message'] : 'N/A';
			$temp['date']=date('Y-m-d (H:i A)',strtotime($r1['date']));
			
			array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = [];
		return $final;
	}
}	
function staff_message($category,$heading,$message,$login_userid,$session,$template_id){
	global $con;
	date_default_timezone_set("Asia/Kolkata");
// echo $login_userid;
	$username=profile($login_userid,$session)['username'];
	$heading=($category=='5') ? 'Important Information' : $heading;
	$sql="select * From staff where status='1'  ";
	$q1=mysqli_query($con,$sql);
	$row = mysqli_num_rows($q1);
	if($row)	
	{
		while($r1 = mysqli_fetch_array($q1))
		{	
			// print_r($r1);
			$dept_id=0;
			// $dept_id=get_depart_bystaff($r1['staff_id'])??'';
			$staff_id=$r1['staff_id'];
			$mobile=$r1['mobno'];
			$allMobile[]=$r1['mobno'];
			$Isql="insert into staff_notifications(category,dept_id,staff_id,selected_no,heading,message,loginuser,notice_datetime,date,session)values('$category','$dept_id','$staff_id','$mobile','$heading','$message','$username',now(),now(),'$session')";
			mysqli_set_charset($con, 'utf8');
			$q2=mysqli_query($con,$Isql);
		}
	}
	/*send push notification*/
	$q2=mysqli_query($con,$sql);
	$row2 = mysqli_num_rows($q2);
	if($row2>0){
		while($r2 = mysqli_fetch_array($q2)){
			$token_id=$r2['token_id'];
			$mobno=$r2['mobno'];
			if(!empty($token_id) && !empty($message)){
				$title=$heading;
				$description=$message;
				push_notification_android($token_id, $title,$description);
			}	
				sendwhatsappMessage($mobno,$message,'');
		}	
	}
	if($category=='5'){
		// sendwhatsappMessage('7004083341',$message,'');
		$messagetype=get_textsms_templates_byid($template_id)['msg_type'];
		if (!empty($allMobile)) {
			sendtextMessage($allMobile, $message, $messagetype);
		}
	}

	if($q2){
		return "success";
	}else{
		return "error";
	}
	
}	
function staff_message_list($msgtype,$session,$login_userid, $CurrentPage, $PerPage){
	global $con;
	$username=profile($login_userid,$session)['username'];
	date_default_timezone_set("Asia/Kolkata");
	$data=array();
	$final=array();
	
	
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	
	$sql="select * FROM `staff_notifications` where 1 AND `loginuser`='$username'  and category='$msgtype' and session='$session' group by loginuser,date,message,heading ";
	mysqli_set_charset($con, 'utf8');
	$q1=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q1);
	$sql .= " Order by st_notification_id desc ";
	$sql .= " Limit $c_page, $PerPage ";

	$q2=mysqli_query($con,$sql);
	$row = mysqli_num_rows($q2);

	if($row)	
	{
		while($r1 = mysqli_fetch_array($q2)){
			$temp['heading']=!empty($r1['heading']) ? $r1['heading'] : 'N/A';
			$temp['message']=!empty($r1['message']) ? $r1['message'] : 'N/A';
			$temp['date']=date('Y-m-d (H:i A)',strtotime($r1['date']));
			
			array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = [];
		return $final;
	}

}
function sms_category_list($sessionid){
	global $con;
	$data=[];
	$sql="select * FROM `sms_category` where api_status='1' order by category_name ";
	$q2=mysqli_query($con,$sql);
	$row = mysqli_num_rows($q2);

	if($row)	
	{
		while($r1 = mysqli_fetch_array($q2)){
			// print_r($r1);
			$temp=array();
			$temp['id']=$r1['id'];
			$temp['category_name']=$r1['category_name'];
			array_push($data,$temp);
		}	
		// print_r($data);
		return $data;
	}else{
		return $data;
	}
}
function sms_templates($user_type,$sessionid){
	global $con;
	$data=[];
	 $tsql = "SELECT * FROM `textsms_templates` where `status`='1' and `msg_type`LIKE 'imp-inform%' and `user_type`='$user_type' ";
	mysqli_set_charset($con, 'utf8');
	$q2 = mysqli_query($con, $tsql);
	$row = mysqli_num_rows($q2);

	if($row)	
	{
		while($r1 = mysqli_fetch_array($q2)){
			$temp=array();
			$temp['template_id']=$r1['id'];
			$temp['title']=$r1['title'];
			$description=$r1['description'];
			
			$temp['description']=substr_replace($description, get_school_details()['company_name'].' ' ,-21,-6);

			array_push($data,$temp);
		}	
		
		return $data;
	}else{
		return $data;
	}
}
/*
function important_message_list($classid, $sectionid, $session, $login_user_id, $CurrentPage, $PerPage)
{
	global $con;
	$username=profile($login_user_id,$session)['username'];
	date_default_timezone_set("Asia/Kolkata");
	$data=array();
	$final=array();
	$cond = '';
	
	if(!empty($classid)){
		$cond.=" && class_id='$classid' ";
	}else{
		$classid='0';
	}
	if(!empty($sectionid)){
		$cond.=" && section_id='$sectionid'";
	}else{
		$sectionid='0';
	}
	$session_sql=($session) ? " && session=$session " : ''; 	
	$session=($session) ? $session : '0'; 	
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	
	$sql="select * FROM `student_notifications` where 1 AND `loginuser`='$username' $cond $session_sql and category='5' group by loginuser,date ";
	mysqli_set_charset($con, 'utf8');
	$q1=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q1);
	$sql.= " Order by st_notification_id desc ";
	$sql .= " Limit $c_page, $PerPage ";
	// echo $sql;
	$q2=mysqli_query($con,$sql);
	$row = mysqli_num_rows($q2);

	if($row)	
	{
		while($r1 = mysqli_fetch_array($q2))
		{

			$temp['class_name']=GetClass($r1['class_id']) ?? '';
			$temp['section_name']=GetSection($r1['section_id']) ?? '';
			$temp['heading']=!empty($r1['heading']) ? $r1['heading'] : 'N/A';
			$temp['message']=!empty($r1['message']) ? $r1['message'] : 'N/A';
			$temp['date']=date('Y-m-d (H:i A)',strtotime($r1['date']));
			
			array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = [];
		return $final;
	}
}	
*/


function changepassword($id,$currentpassword,$newpassword)   
{
	global $con;
	
	$data = array();
	$sql="select * from users where user_id='$id' && pass='$currentpassword'";
	$que = mysqli_query($con,$sql);
	$row = mysqli_num_rows($que);		
	if($row)
	{	
		// echo 1234;
		$que1 = mysqli_query($con,"update users set pass='$newpassword' where user_id='$id'");

		$temp['Response'] = "Updated";

		array_push($data,$temp);
		return $data;
	}
	else
	{
		// $temp['Response'] = "Invalid Details";
		// echo json_encode($temp);
		return "";
	}
}


function getClasswiseAttendance($class_id,$section_id,$session,$date,$CurrentPage,$PerPage){
	
	global $con;
	$data=array();
	$PerPage='20';
	$P=$A=$L=0;
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	$class_id=!empty($class_id)? " AND class_id='$class_id' " : '';
	$section_id=!empty($section_id)? " AND section_id='$section_id' " : '';

	$PALsql="select * from student_daily_attendance where 1 $class_id $section_id   AND  date='$date' and session='$session'";
	$PALQuery=$con->query($PALsql);
	if($PALQuery->num_rows>0){
		while($AtData= $PALQuery->fetch_assoc()){
			$temp=array();
			if($AtData['type_of_attend']=='1'){
			$P++;
			}
			if($AtData['type_of_attend']=='2'){
			$A++;
			}
			if($AtData['type_of_attend']=='3'){
			$L++;	
			}
		}
	}	
	$PALQuery->close();
	
	$sql="select * from student_daily_attendance where 1 $class_id $section_id   AND  date='$date' and session='$session'";
	$AtQuery2=$con->query($sql);
	$TotalRecords =$AtQuery2->num_rows;

	$sql.=" LIMIT $c_page, $PerPage ";
	
	$AtQuery=$con->query($sql);
	if($AtQuery->num_rows>0){
	 while($AtData= $AtQuery->fetch_assoc()){
		 
		$temp=array();
		if($AtData['type_of_attend']=='1'){
		  $Type="Present";
		}
		if($AtData['type_of_attend']=='2'){
		  $Type="Absent";
		}
		if($AtData['type_of_attend']=='3'){
		  $Type="Leave";	
		}
        
        $temp['register_no']= $AtData['register_no'];
        $temp['class_name']= GetClass($AtData['class_id']);
        $temp['section']=  GetSection($AtData['section_id']);
		// $temp['student_name']= Student_detailsById($AtData['student_id'])['student_name'];
		$RollNo=get_student_records_by_stuid($AtData['student_id'],$session)['roll_no'] ?? '0';
		$temp['roll_no']=!empty($RollNo)  ? $RollNo : '0' ;
		$temp['student_name']= getStudent_byStudent_id($AtData['student_id'])['student_name'];
		$temp['type_of_attend']= $Type;
		$temp['reason']= ($AtData['reason']) ? $AtData['reason'] : "NA" ; 
        $temp['date']= $AtData['date'];		
		
		array_push($data,$temp);
		 
	 }
	 	
	 
	 $final['current_page'] = $CurrentPage;
	 $final['per_page'] = $PerPage;
	 $final['total_page'] = ceil($TotalRecords / $PerPage);
	 $final['total_records'] = $TotalRecords;
	 $final['TotalPresent'] = $P;
	 $final['TotalAbsent'] = $A;
	 $final['TotalLeave'] = $L;
	 $final['data'] = $data;

	 return $final;

	}else{
		 	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
   
		return $final;
	
		
	}
}

 function getClasswiseExam($class_id,$section_id,$session_id){
   global $con;
   $data=array();
   $sql="select * from test where class_id='$class_id' && section_id='$section_id'  and session='".$session_id."'";
  
   $Query= $con->query($sql);
   if($Query->num_rows>0){
	while($TestData= $Query->fetch_assoc()){
     $temp=array();
    $subid = $TestData['subject_id'];
    $qsub = mysqli_query($con,"select subject_name from subject where subject_id='$subid'");
	$rsub = mysqli_fetch_array($qsub);
	$subname = $rsub['subject_name'];
	
    $temp['examname']=$TestData['test_name'];
	$temp['test_id']=$TestData['test_id'];
	$temp['subname']=$subname;
	$temp['exam_date']=$TestData['test_date'];
	$temp['starttime']=$TestData['starttime'];
	$temp['endtime']=$TestData['endtime'];
	
	array_push($data,$temp);
	
	}
  return $data;
   }else{
	return 	$data;  
	   
   }
 }

 function getDriverList($session_id,$driver_id){
	 $data=array();
	 global	$con;
	 if(!empty($driver_id)){
		$IdSQL=" AND  id='".$driver_id."'"; 
	 }else{
		$IdSQL=''; 
	 }
	 $Query=$con->query("select * from driver where session='".$session_id."' $IdSQL ORDER BY `modify_date` DESC ");
	 if($Query->num_rows>0){
	 while($res= $Query->fetch_assoc()){
		$temp=array();
		$temp['name']= $res['name'];
		$temp['father_name'] = $res['father_name'];
		$temp['gender'] = $res['gender'];
		$temp['mobile'] = $res['mobile'];
		 $temp['address']= $res['address'];
		 $temp['city']= $res['city'];
		 $temp['designation'] =$res['designation'];
		 $temp['dlno'] =$res['dlno'];
		 $temp['experience'] =$res['experience'];
		 $temp['experience'] =$res['experience'];
		 array_push($data,$temp);
		
	 }
	 return $data;
	 }else{
		 return $data; 
		 
	 }

 }

function view_driver($session_id){
global $con;
$data=array();
if(!empty($session_id)){
		$IdSQL=" AND  session='".$session_id."'"; 
	 }else{
		$IdSQL=''; 
	 }
    $sql="select * from driver where status='0' $IdSQL";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['name']=$res['name'];
				$temp['father_name']=$res['father_name'];
				$temp['gender']=$res['gender'];
				$temp['mobile']=$res['mobile'];
				$temp['alternate_no']=$res['alternate_no'];
				$temp['address']=$res['address'];
				$temp['city']=$res['city'];
				$temp['designation']=$res['designation'];
				$temp['experience']=$res['experience'];
				$temp['dlno']=$res['dlno'];
				$temp['aadhar_no']=$res['aadhar_no'];
				$temp['previous_exp ']=$res['previous_exp'];
				$temp['description ']=$res['description'];
				$temp['date ']=date("d-m-Y H:i:s ", strtotime($res['date']));
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function view_vehicle($session_id){
global $con;
$data=array();
// if(!empty($session_id)){
// 		$IdSQL=" AND  session='".$session_id."'"; 
// 	 }else{
// 		$IdSQL=''; 
// 	 }
    $sql="select * from `vehicle` where  status='0'  and session='$session_id' " ;
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['vehicle_name']=$res['vehicle_name'];
				$temp['vehicle_type']=$res['vehicle_type'];
				$temp['vehicle_number']=$res['vehicle_number'];
				$temp['chassis_no']=$res['chassis_no'];
				$temp['purchased_year']=$res['purchased_year'];
				$temp['vehicle_status']=$res['vehicle_status'];
				$temp['about_vehicle']=$res['about_vehicle'];
				$temp['prev_exp']=$res['prev_exp'];
				$temp['description']=$res['description'];
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function view_transports($session_id, $CurrentPage, $PerPage){
global $con;
$data=array();
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
    $sql="select * from `transports` where status='1' and `session`='$session_id' ";
	$nquery=mysqli_query($con,$sql);
    $TotalRecords=mysqli_num_rows($nquery);
	$sql.=" LIMIT $c_page, $PerPage";

    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['route_name']=$res['route_name'];
				$temp['price']=$res['price'];
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				
				array_push($data,$temp);
			}
			$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data'] = $data;

			return $final;
		}else{
			$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data'] = $data;
			return $final;
		}	
}

function fee_mode(){
	global $con;
	$data=array();
	$query=mysqli_query($con,"select * from fee_mode WHERE 1 ");
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_array($query)){
			$temp=array();
			$temp['fee_mode_id']=$res['fee_mode_id'];
			$temp['fee_mode_name']=$res['fee_mode_name'];
			array_push($data,$temp);
	  }
	 return $data;
	}else{
			return $data;
	}	 
}

function view_route_to_student($class_id,$section_id,$session_id){
global $con;
$IdSQL='';
$data=array();
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}

  $sql="select * from student_route WHERE 1 $IdSQL";
  $query=mysqli_query($con,$sql);
  if(mysqli_num_rows($query)>0){
	 while($res=mysqli_fetch_array($query)){
	 		$temp=array();
			$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'];
			$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
			$temp['section_name']=get_section_byid($res['section_id'])['section_name'];
			$temp['route_name']=get_transports_byid($res['trans_id'])['route_name'];
			$temp['price']=get_transports_byid($res['trans_id'])['price'];;
			$temp['due_amount']=$res['due_amount'];
			$temp['fee_mode_name']=get_fee_mode_byid($res['fee_mode_id'])['fee_mode_name'];
			$temp['reason']=($res['reason']) ? $res['reason'] : "NA";
			$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
			array_push($data,$temp);
   }
  		return $data;
		}else{
			return $data;
		}
}

function view_assign_driver_route($session_id){
	global $con;
$data=array();
  // if(!empty($session_id)){	// 	$IdSQL=" AND  session='".$session_id."'"; 
    $sql="select * from assign_driver_route where status='0'  AND  session='".$session_id."' ";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['assign_id']=$res['assign_id'];
				$temp['name']=get_driver_byid($res['driver_id'])['name'];
				$temp['vehicle_name']=get_vehicle_byid($res['vehicle_id'])['vehicle_name'];
				$temp['vehicle_number']=get_vehicle_byid($res['vehicle_id'])['vehicle_number'];
				$temp['route_id']=get_transports_byid($res['route_id'])['route_name'];
				$temp['description']=$res['description'];
				$temp['date']=date("d-m-Y H:i:s ", strtotime($res['date']));
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}
function view_driver_by_id($assign_id,$session){
	global $con;
$data=array();
  
  $sql="select d.name,d.description,d.gender,d.mobile,d.address,d.city,d.designation,d.aadhar_no,d.date as
`join_date`,adr.driver_id,adr.date as assign_date,adr.vehicle_id,adr.vehicle_no,adr.route_id from assign_driver_route as adr join driver
as d on adr.driver_id=d.id where d.status='0' AND assign_id='$assign_id' "; //AND adr.session='$session'
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				
				$temp['vehicle_name']=get_vehicle_byid($res['vehicle_id'])['vehicle_name'];
				$temp['vehicle_number']=get_vehicle_byid($res['vehicle_id'])['vehicle_number'];
				$temp['route_id']=get_transports_byid($res['route_id'])['route_name'];
				$temp['image']=Call_Baseurl()."/images/"."no_image.png";
				$temp['name']=get_driver_byid($res['driver_id'])['name'];
				$temp['description']=$res['description'];
				$temp['gender']=$res['gender'];
				$temp['mobile']=$res['mobile'];
				$temp['address']=$res['address'];
				$temp['city']=$res['city'];
				$temp['designation']=$res['designation'];
				$temp['aadhar_no']=$res['aadhar_no'];
				$temp['assign_date']=date("d-m-Y (H:i A) ", strtotime($res['assign_date']));
				$temp['join_date']=date("d-m-Y (H:i A) ", strtotime($res['join_date']));
				// array_push($data,$temp);
			}
				return $temp;
		}else{
			return $data;
		}	
}

function view_transport_expense($session_id,$CurrentPage, $PerPage){
	global $con;
$data=array();
  if(!empty($session_id)){
   	$IdSQL=" AND  session='".$session_id."'"; 
  }else{
  	$IdSQL="";
  } 	
  $PerPage='20';
  $c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
  $total_expense=0;
   $sql="select  `amount`from transport_expense where status='0' $IdSQL  ";
    $nquery=mysqli_query($con,$sql);
	$TotalRecords=mysqli_num_rows($nquery);
	$sql.=" LIMIT $c_page, $PerPage ";
    // echo $sql;
    $query=mysqli_query($con,$sql);


    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$total_expense+=$res['amount'];
		  }
		  	// $temp['total_expense']=$total_expense;
		  	$final['total_expense']=$total_expense;
		    // array_push($data,$temp);
		}
  $sql2="select  `trans_expense_type_id`, `trans_expense_details`, `amount`, `proofs`, `point_of_contact`, `expensed_datetime`  from transport_expense where status='0' $IdSQL  ";
  $sql2.=" LIMIT $c_page, $PerPage ";
  
    $query=mysqli_query($con,$sql2);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['trans_expense_type_name']=get_transport_expense_type_byid($res['trans_expense_type_id'])['trans_expense_type_name'];
				$temp['trans_expense_details']=$res['trans_expense_details'];
				$temp['expense_amount']=$res['amount'];
				$temp['proofs']=($res['proofs']) ? Call_Baseurl()."/images/transport/".$res['proofs'] : "NA" ;
				$temp['point_of_contact']=$res['point_of_contact'];
				$temp['expensed_datetime']=date("d-m-Y (H:i A) ", strtotime($res['expensed_datetime']));
				// $temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				array_push($data,$temp);
				
			}
			$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data']=$data;
			return $final;
		}else{
			$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data']=[];
			return $final;
		}	
}


function view_expense($session_id,$fromdt,$todt){
global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($from_date) && !empty($to_date)){
		$IdSQL.=" AND  between $from_date and $to_date"; 
	}
	  $sql="select * from expense where status='0' $IdSQL ";
    $query=mysqli_query($con,$sql);
    if(mysqli_num_rows($query)>0){
			while($res=mysqli_fetch_array($query)){
				$temp=array();
				$temp['expense_type_name']=get_expense_type_byid($res['expense_type_id'])['expense_type_name'];
				$temp['expense_details']=$res['expense_details'];
				$temp['amount']=$res['amount'];
				$temp['proofs']=$res['proofs'];
				$temp['point_of_contact']=$res['point_of_contact'];
				$temp['expensed_datetime']=date("d-m-Y H:i:s ", strtotime($res['expensed_datetime']));;
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['date']));
				array_push($data,$temp);
			}
				return $data;
		}else{
			return $data;
		}	
}

function fees_paid_students($session_id,$class_id,$section_id,$CurrentPage,$PerPage){
	global $con;
	$IdSQL= $SeSQL = '';
	// $total_fee_amount=0;
	// $total_paid_amount=0;
	// $total_dues_amount=0;
	$totalfee_tocollect=array();
	$total_fee_amount=array();
	$total_paid_amount=array();
	$total_dues_amount=array();
	$previousfee=0;
	$totaldiscount=0;
	$totalfee=0;
	$data=array();
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
    if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	 if(!empty($section_id)){
		$SeSQL.=" AND  section_id='".$section_id."'"; 
	}
	//find total fee
	// $asfSql="select * from assign_fee_class where 1 $IdSQL  ";
	// $qtf = mysqli_query($con,$asfSql);

	// $rtf = mysqli_fetch_assoc($qtf);
	// $totalfee = $rtf['total_amount'] + $previousfee - $totaldiscount;
		
	//end find total fee				
	$TotalPaidSql = "SELECT * FROM `student_wise_fees` WHERE 1 $IdSQL  $SeSQL";
	
	$nquery=mysqli_query($con,$TotalPaidSql);
	$TotalRecords=mysqli_num_rows($nquery);
	//calculate the total Student Fee before pagination start------------------------------------------
	if($TotalRecords>0){
			
		$discamount = 0;
		// $totalfee_tocollect = 0;
		while($res1 = mysqli_fetch_array($nquery)){
			$discamount = $discamount + $res1['discount_amount'];
			$stramt = $res1['fee_amount'];
			$arramt = explode(',',$stramt);
			$strheader = $res1['fee_header_id'];
			$arrheader = explode(',',$strheader);
			$no_of_months = $res1['no_of_months'];
			
			$Student_Wise_Total_Amount = 0;
			for ($i = 0; $i < count($arrheader); $i++) {
				$chkyear=get_fee_header($arrheader[$i]);
				if($chkyear=='1'){
					$FeeHeadAmount = $arramt[$i];
					$FeeHeadAmount = $FeeHeadAmount * $no_of_months;
					$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;
				}else{
					$FeeHeadAmount = $arramt[$i];
					$Student_Wise_Total_Amount = $Student_Wise_Total_Amount + $FeeHeadAmount;
				}
			}	
			$totalfee_tocollect[] = $Student_Wise_Total_Amount;
		}
	}
	//end calculation of total student Fee----------------------------
	// Total paid Fees by class---------------------------------------
	$que3=mysqli_query($con,"select * from student_due_fees where 1  $IdSQL  $SeSQL ");
		// echo $row2 = mysqli_num_rows($que3);
		$tpaidamt = 0;
		$tpaidamt1 = 0;
		while($rque3=mysqli_fetch_array($que3))
		{
			$recdamt=$rque3['received_amount'];
			$tranamt=$rque3['transport_amount'];
			$arr = explode(',',$recdamt);
			
			foreach($arr as $k)
			{
			 $tpaidamt1 = $tpaidamt1 + floatval($k) ;
			}
			
			   $tpaidamt = $tpaidamt1;
		}
	//End Total paid Fees by class---------------------------------------
	//total due by class-------------------
	$q1 = mysqli_query($con,"select * from student_wise_fees where 1  $IdSQL  $SeSQL ");
		$dueamt = 0;
		
		while($r1 = mysqli_fetch_array($q1))
		{
			$dueamt = $dueamt + $r1['due_amount'];
		}
	//End total due by class-------------------		



	
	    $sql = "SELECT * FROM `student_wise_fees` WHERE 1 $IdSQL  $SeSQL";
		$sql.=" Limit $c_page, $PerPage ";
		// echo $sql;
		$query=mysqli_query($con,$sql);
		if(mysqli_num_rows($query)>0){
				while($res=mysqli_fetch_array($query)){
					$temp=array();
					
					$sql2="select student_id,register_no,student_name,parent_no,msg_type_id,father_name,mother_name,gender,dob,sr.class_id,sr.section_id from students as s join student_records as sr on s.student_id=sr.stu_id where stu_status='0' and `student_id`='".$res['student_id']."' and `sr`.`session`='$session_id'  "; //and sr.class_id='".$rtf['class_id']."'
						// die;

					$query2=mysqli_query($con,$sql2);
					if(mysqli_num_rows($query2)>0){
								$total_fee=get_assign_fee_class($res['class_id'],$session_id)['total_amount']??'0';
								$RollNo=get_student_records_by_stuid($res['student_id'],$session_id)['roll_no'] ?? '0';
								$temp['roll_no']=!empty($RollNo)  ? $RollNo : '0' ;
								$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'];
								$temp['register_no']=getStudent_byStudent_id($res['student_id'])['register_no'];
								
								$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
								$temp['section_name']=get_section_byid($res['section_id'])['section_name'] ?? 'NA';
								// $temp['total_fee']=$totalfee;
								$temp['total_fee']=$total_fee;
						//find total paid amount
						$sdfSql="select * from student_due_fees where student_id='".$res['student_id']."' && (status='0' || status='1') && session='$session_id' ";
						$q4 = mysqli_query($con,$sdfSql);
										$pamt = 0;
										$totalpaidamt = 0;
										while($r4 = mysqli_fetch_assoc($q4)){

											$recdamt = $r4['received_amount'];
											$prevamt = $r4['previous_amount'];
											$late_fee = $r4['late_fee'];
											$ramtarr = explode(',',$recdamt);
											foreach($ramtarr as $a1){
												$pamt = $pamt+ $a1;      //show error use intval()
											}
											$totalpaidamt = $pamt + $prevamt+$late_fee;
										}
								$temp['total_paid']=$totalpaidamt;
						
								// $temp['total_due']=getStudent_byStudent_id($res['student_id'])['due'];
								$temp['total_due']=$total_fee-$totalpaidamt;
								
								// $total_paid_amount[]=$totalpaidamt;
								// $total_dues_amount[]=$temp['total_due'];
								array_push($data,$temp);
					}
				}//while
				
				// array_unshift($data, $final);
				// array_push($data,$final);
				$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			// $final['total_fee_amount']=array_sum($total_fee_amount);
			// $final['total_paid_amount']=array_sum($total_paid_amount);
			// $final['total_dues_amount']=array_sum($total_dues_amount);
			
			$final['total_fee_amount']=array_sum($totalfee_tocollect);
			$final['total_paid_amount']=$tpaidamt;
			$final['total_dues_amount']=$dueamt;
			
			$final['data']=$data;
	

				return $final;
		}else{
			return $data;
		}	
	        

}

function transport_fees_paid_students($session_id,$class_id,$section_id,$CurrentPage,$PerPage){
	global $con;
$IdSQL='';
$total_fee_amount = $total_paid_amount = $total_dues_amount = 0;

$PerPage='20';
$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';

$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}

	$sql = "SELECT * FROM `student_route` WHERE 1 $IdSQL ";
	$nquery=mysqli_query($con,$sql);
	$TotalRecords=mysqli_num_rows($nquery);
	$sql.=" Limit $c_page, $PerPage ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$RollNo=get_student_records_by_stuid($res['student_id'],$session_id)['roll_no'] ?? '0';
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'];
				$temp['register_no']=getStudent_byStudent_id($res['student_id'])['register_no'];
				$temp['roll_no']=!empty($RollNo)  ? $RollNo : '0' ;
				$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
				$temp['section_name']=get_section_byid($res['section_id'])['section_name'] ?? 'NA';
				$temp['route_name']=get_transports_byid($res['trans_id'])['route_name'];

				$price=get_transports_byid($res['trans_id'])['price'];
				// $temp['due_amount']=$res['due_amount'];

				//get previous transport fees due
			  $sql5="select * from previous_transport_fees where student_id='".$res['student_id']."' and session='$session_id' ";
				$q5 = mysqli_query($con,$sql5);
				if(mysqli_num_rows($q5)){
				   $r5 = mysqli_fetch_array($q5);
					 $pretransfee = $r5['previous_transport_fees'];
				}else{
						$pretransfee = 0;
				}
				$total_amount = $price + $pretransfee - $res['discount'];    //total given amount with previous amt & discount
				//get current transport fees due & payment
				$qfee2 = mysqli_query($con,"select * from student_transport_due_fees where 1 && (status='0' || status='1')  and student_id='".$res['student_id']."' and session='$session_id' ");

					$tramt = 0;
					$ptramt = 0;
					$total_amt_paid = 0;

					while($rfee2 = mysqli_fetch_array($qfee2)){

						$rectransamt = $rfee2['trans_amount'];
						$tramt = $tramt + $rectransamt;
						$prevtransamt = $rfee2['previous_trans_amount'];
						$ptramt = $ptramt + $prevtransamt;
					}	
					$total_amt_paid += $tramt + $ptramt;  //till total amount paid
				  $duefee = $price + $pretransfee - $res['discount'] - $total_amt_paid;  //remainig dues 

				  $temp['total_fee']=$total_amount;
				  $temp['total_amt_paid']=$total_amt_paid;
				  $temp['total_due']=$duefee;
				
				    $total_fee_amount+=$total_amount;
						$total_paid_amount+=$total_amt_paid;
						$total_dues_amount+=$duefee;
						array_push($data,$temp);

		}//while	
		    $final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			
		    $final['total_fee_amount']=$total_fee_amount;
			$final['total_paid_amount']=$total_paid_amount;
			$final['total_dues_amount']=$total_dues_amount;

				// array_unshift($data, $final);
			$final['data']=$data;	

		
		return $final;
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data']=[];	
		return $final;
	}	

}
function view_test($session_id,$class_id,$section_id,$CurrentPage,$PerPage){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
	
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	
	$sql = "SELECT `test_id`,`parent_test_id`,`test_name` FROM `test` WHERE 1 $IdSQL  Group by `test_name` ";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);

	$sql.=" LIMIT $c_page, $PerPage ";
	
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['test_id']=$res['test_id'];
				$temp['parent_test_id']=$res['parent_test_id'];
				$temp['test_name']=$res['test_name'];
				array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}else{
		return $data;
	}		
}

function view_test_details($session_id,$class_id,$section_id,$test_id,$CurrentPage,$PerPage){
	global $con;
$IdSQL='';
$data=array();
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
	if(!empty($test_id)){
		$test_name=get_test_byid($test_id)['test_name'] ?? '';
		if(!empty($test_name)){
			// $Gsql=" Group by '".$test_name."' ";
			$IdSQL.=" AND  test_name LIKE '".$test_name."'"; 
		}	
	}  
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0'; 
	$sql = "SELECT * FROM `test` WHERE `class_id`='".$class_id."' and  session='".$session_id."'  $IdSQL  ";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);
	
	$sql.=" LIMIT $c_page, $PerPage ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$temp['test_name']=$res['test_name'];
				$temp['test_date']=$res['test_date'];
				$temp['starttime']=$res['starttime'];
				$temp['endtime']=$res['endtime'];
				$temp['subject_name']=get_subject_byid($res['subject_id'])['subject_name'];
				$temp['min_marks']=$res['min_marks'];
				$temp['max_marks']=$res['max_marks'];
				$temp['room_no']=$res['room_no'];
				$temp['create_date']=date("d-m-Y H:i:s ", strtotime($res['create_date']));
				array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}		
}

function view_feedback($session_id,$CurrentPage,$PerPage){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0'; 
	$sql = "SELECT * FROM `feedback` WHERE 1  $IdSQL  order by `modify_date` desc ";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);
	
	$sql.=" LIMIT $c_page, $PerPage ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$RollNo=get_student_records_by_stuid($res['student_id'],$session_id)['roll_no'] ?? '0';
				$temp['title']=$res['title'];
				$temp['description']=($res['description'])  ? $res['description'] : "NA";
				$temp['raised_for']=$res['raised_for'];
				$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
				$temp['section_name']=get_section_byid($res['section_id'])['section_name'];
				
				$temp['roll_no']=!empty($RollNo)  ? $RollNo : '0' ;
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
				$temp['request_name']=get_request_type_byid($res['request_id'])['request_name'] ?? '';
				$temp['response']=($res['response']) ? $res['response'] : "NA";
				$temp['submission_date']=date("d-m-Y (H:i A) ", strtotime($res['create_date']));
				array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	}		
}
function view_remedy($session_id,$CurrentPage,$PerPage, $class_id, $section_id){
	global $con;
$IdSQL='';
$data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0'; 
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
	$sql = "SELECT * FROM `remedy` WHERE 1  $IdSQL  ";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);
	
	$sql.=" LIMIT $c_page, $PerPage ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$temp['rid']=$res['rid'];
				$RollNo=get_student_records_by_stuid($res['student_id'],$session_id)['roll_no'] ?? '0';
				$temp['roll_no']=!empty($RollNo) ? $RollNo : '0' ;
				$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
				$temp['section_name']=get_section_byid($res['section_id'])['section_name'];
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
				$temp['staff_name']=get_staff_byid($res['staff_id'])['staff_name'] ?? '';
				$temp['observations']=$res['observations'];
				$temp['observations_proof']=!empty($res['observations_proof']) ? Call_Baseurl()."/gallery/remedy/".$res['observations_proof'] : "" ;
				$temp['observations']=$res['remedies_taken'];
				$temp['approved_by']=($res['approved_by']) ? $res['approved_by'] : "NA";
				$temp['start_date']=date("d-m-Y ", strtotime($res['start_date']));
				$temp['end_date']=date("d-m-Y ", strtotime($res['end_date']));
				array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
		return $final;
	
	}		
}
function view_allocate_budget($session_id){
	global $con;
$IdSQL='';
$total_allocate_amount=0;
$data=array();
$data_amt=array();
$result=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	$sql = "select * from allocate_budget where 1  $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$header_id=$res['budget_header_id'];
				$q1 = mysqli_query($con,"select * from budget_header where budget_header_id='$header_id'");
				$r1 = mysqli_fetch_array($q1);
				$temp['budget_header_id']=$r1['budget_header_id'];
				$temp['budget_header_name']=$r1['budget_header_name'];
				$temp['allocate_amount']=$res['allocate_amount'];	
				$total_allocate_amount+=$res['allocate_amount'];	
				array_push($data,$temp);
		}	

		// $final['total_allocate_amount']=$total_allocate_amount;
		// array_unshift($data_amt,$final);
		$result['data']=$data;
		$result['total_allocate_amount']=$total_allocate_amount;
		return $result;
	}else{
		return $data;  
	}		
}
function view_allocate_budget_expense($header_id,$session_id,$CurrentPage,$PerPage){
	global $con;
$IdSQL='';
$total_allocate_amount = $total_avilable_amount = $total_expensed_amount =$total_amount_remaining = 0;
$data=array();
$res=array();
$final=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0'; 
	$sql = "select * from allocate_budget_expense where 1 AND `budget_header_id`='$header_id' $IdSQL  ";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);
	
	$sql.=" LIMIT $c_page, $PerPage ";
	
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$expense_id=$res['expense_id'];
				$temp['budget_header_name']=get_budget_header_byid($res['budget_header_id'])['budget_header_name'] ?? '';
				$temp['allocated_amount']=$res['allocated_amount'];	
				$temp['available_amount']=$res['available_amount'];	
				$temp['expensed_amount']=$res['expensed_amount'];	
				$temp['description']=$res['description'];	
				if(!empty($res['attachment'])){
					$temp['attachment']=Call_Baseurl()."/gallery/budgetexp/".$res['attachment'];	
				}else{
					$temp['attachment']=Call_Baseurl()."/gallery/no_image.png";	
				}
				$temp['amount_remaining']=$res['amount_remaining'];
				$temp['expense_date']=date("d-m-Y ", strtotime($res['expense_date']));	
				$total_allocate_amount += $res['allocated_amount'];	
				$total_avilable_amount += $res['available_amount'];	
				$total_expensed_amount += $res['expensed_amount'];	
				$total_amount_remaining += $res['amount_remaining'];
				array_push($data,$temp);
		}//while	
			$final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['total_allocate_amount']=$total_allocate_amount;
			$final['total_avilable_amount']=$total_avilable_amount;
			$final['total_expensed_amount']=$total_expensed_amount;
			$final['total_amount_remaining']=$total_amount_remaining;
		
		$final['data'] = $data;
		return $final;
	}else{
		    $final['current_page'] = $CurrentPage;
			$final['per_page'] = $PerPage;
			$final['total_page'] = ceil($TotalRecords / $PerPage);
			$final['total_records'] = $TotalRecords;
			$final['data'] = $data;
		return $final;
	}		
}

function view_stock_vendor(){
	global $con;
$IdSQL='';
$data=array();
  // if(!empty($session_id)){ 		$IdSQL.=" AND  session='".$session_id."'"; 	}
	$sql = "select * from stock_vendor where 1 ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['stock_vendor_id']=$res['stock_vendor_id'] ;
				$temp['stock_vendor_name']=$res['stock_vendor_name'];	
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}		
}
function view_purchase_order($session_id){
	global $con;
	$data=array();
	$IdSQL='';
  $data=array();
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}	
  $sql = "select * from purchase_order where 1 $IdSQL  order by modify_date desc";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['poid']=$res['poid'] ;
				$temp['stock_vendor_name']=get_stock_type_byid($res['stock_type_id'])['stock_type_name'] ?? '';
				$temp['purchase_date']=$res['purchase_date'] ;
				$temp['quantity']=$res['quantity'] ;
				$temp['amt_per_item']=$res['amt_per_item'] ;
				$temp['disc_per_item']=$res['disc_per_item'] ;
				$temp['description']=$res['description'] ;
				$temp['total_amount']=$res['amount'];
				$temp['stock_vendor_name']=get_stock_vendor_byid($res['stock_vendor_id'])['stock_vendor_name'] ?? ''; 
				$temp['image']=($res['image']) ? "../../gallery/purchaseorder/".$res['image']  :  "../../gallery/purchaseorder/no_image.png";
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}		
}

function view_stock_avilable($CurrentPage,$PerPage){
	global $con;
	$data=array();
	$IdSQL='';
  $data=array();
    $PerPage='20';
    $c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
  // if(!empty($session_id)){ 	$IdSQL.=" AND  session='".$session_id."'"; 	}	
    $sql = "select * from purchase_order where 1 $IdSQL  order by modify_date desc";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);

	$sql.=" LIMIT $c_page, $PerPage ";
	
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
			  $id=$res['pur_ord_id'];
			  $stockid=$res['stock_type_id'];
			  $quantity = $res['quantity'];
				$temp=array();
				$temp['poid']=$res['poid'] ;
				$temp['stock_vendor_name']=get_stock_type_byid($res['stock_type_id'])['stock_type_name'] ?? '';
				$temp['purchase_date']=$res['purchase_date'];
				$temp['total_quantity']=$res['quantity'];

				//find total issued quantity
				$q3 = mysqli_query($con,"select `quantity` from issue_order where pur_ord_id='$id'");
				$tissue_qty = 0;
				$issdet = "";
				while($r3 = mysqli_fetch_assoc($q3)){
					$tissue_qty += $r3['quantity'];
				}
				//find total dead stock
				$q5 = mysqli_query($con,"select * from dead_stock where pur_ord_id='$id'");
				$tdead_qty = 0;
				while($r5 = mysqli_fetch_array($q5)){
					$tdead_qty += $r5['dead_stock_qty'];
				}
				// $qret6 = mysqli_query($con,"select * from return_stock where pur_ord_id='$id'");
				// $return_qty = 0;
				// while($r6 = mysqli_fetch_array($qret6)){
				// 	$return_qty += $r6['return_qty'];
				// }
				$tbal_qty = $quantity - $tissue_qty - $tdead_qty;
				$temp['avilable_qty']=$tbal_qty;
				$temp['issue_qty']=$tissue_qty;
				// $temp['return_qty']=$return_qty;
				$temp['dead_qty']=$tdead_qty ;
				$temp['total_amount']=$res['amount'];
				$temp['stock_vendor_name']=get_stock_vendor_byid($res['stock_vendor_id'])['stock_vendor_name'] ?? ''; 
				$temp['image']=($res['image']) ? Call_Baseurl()."/gallery/purchaseorder/".$res['image']  :  Call_Baseurl()."/gallery/purchaseorder/no_image.png";
				array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
	return $final;
	
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = [];
	return $final;
	}		
}
function view_books($CurrentPage,$PerPage){
	global $con;
	$data=array();
	$PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
	$sql = "select * from books where 1 order by modify_date desc";
	$q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);

	$sql.=" LIMIT $c_page, $PerPage ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
			  $temp['book_id']=$res['book_id'];
			  $temp['book_name']=$res['book_name'];
			  $temp['book_isbn']=$res['book_isbn'];
			  $temp['author']= $res['author'];
			  $temp['quantity']= $res['quantity'];
			  $temp['price']=  $res['price'];
			  $temp['publisher_name']= get_publisher_byid($res['publisher_id'])['publisher_name'];
			  $temp['book_type_name']= get_book_type_byid($res['book_type_id'])['book_type_name'];
			  $temp['vendor_name']= get_vendor_byid($res['vendor_id'])['vendor_name'];
			  $temp['branch_name']=  get_branch_byid($res['branch_id'])['branch_name'];
				array_push($data,$temp);
		}	
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = $data;
     	return $final;
		
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data'] = [];
	return $final;
	}	
}
function library_fees_report($session_id,$class_id,$section_id){
	global $con;
	$data=array();
	$final=array();
	$IdSQL='';
		$total_penalty_amount = $total_paid_amount = $total_dues_amount = 0;
  if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
	if(!empty($class_id)){
		$IdSQL.=" AND  class_id='".$class_id."'"; 
	}
	if(!empty($section_id)){
		$IdSQL.=" AND  section_id='".$section_id."'"; 
	}
	$sql = "SELECT * FROM `issue_bookto_students` WHERE 1 and return_status='0' $IdSQL";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
			$temp=array();
			$id=$res['issue_id'];
			$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
			$temp['class_name']=get_class_byid($res['class_id'])['class_name'];
			$temp['section_name']=get_section_byid($res['section_id'])['section_name']?? '';

			$retdt = $res['return_date'];
			$curdate = date("Y-m-d");
			$date1=date_create($curdate);
			$date2=date_create($retdt);
			$diff=date_diff($date2,$date1);
			$tdays = $diff->format("%R%a days");
			$rettypeid=$res['return_type_id'];

			$q3=mysqli_query($con,"select * from book_return_type where book_return_type_id ='$rettypeid'");
			$r3=mysqli_fetch_array($q3);
			$amt=$r3['book_fine_per_day'];
			if($tdays > 0){
				$tpenalty = $tdays * $amt;
			}else{
				$tpenalty = 0;
			}
			$q4 = mysqli_query($con,"select * from library_payment where issue_id='$id'");
			$tpaid = 0;
			while($r4 = mysqli_fetch_array($q4)){
				$tpaid += $r4['paid_amount']; 
			}
			$tdue = $tpenalty - $tpaid;
			$temp['total_penalty']=$tpenalty;
			$temp['total_paid']=$tpaid;
			$temp['total_due']=$tdue;

			$total_penalty_amount+=$tpenalty;
			$total_paid_amount+=$tpaid;
			$total_dues_amount+=$tdue;
			array_push($data,$temp);
		}//while	
	        $final['total_penalty_amount']=$total_penalty_amount;
			$final['total_paid_amount']=$total_paid_amount;
			$final['total_dues_amount']=$total_dues_amount;
			// array_unshift($data,$final);

			$final['data']=$data;
		// return $data;
		return $final;
	}else{
		return $data;  
	}	
}
function view_branch(){
	global $con;
	$data=array();
	$sql = "select * from branch where 1 order by branch_name";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
			  $temp['branch_id']=$res['branch_id'];
			  $temp['branch_name']=$res['branch_name'];
				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;  
	}	
}
function issue_book_to_students($branch_id,$book_id){
	global $con;
  $IdSQL='';
  $data=array();
  if(!empty($branch_id)){
		$IdSQL.=" AND  branch_id='".$branch_id."'"; 
	}
	if(!empty($book_id)){
		$IdSQL.=" AND  book_id='".$book_id."'"; 
	}

	$sql = "SELECT *	 FROM `issue_bookto_students` WHERE 1 $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['student_name']=getStudent_byStudent_id($res['student_id'])['student_name'] ?? '';
				$temp['register_no']=getStudent_byStudent_id($res['student_id'])['register_no'] ?? '';
			  $temp['class_name']=get_class_byid($res['class_id'])['class_name'];
			  $temp['section_name']=get_section_byid($res['section_id'])['section_name']?? '';
			  $temp['issue_date']=date("d-m-Y ", strtotime($res['issue_date']));
			  $temp['return_date']=date("d-m-Y ", strtotime($res['return_date']));
			  if(!empty($res['returned_date'])){
			  		$temp['returned_date']=date("d-m-Y ", strtotime($res['returned_date']));
			  }else{
			  	$temp['returned_date']="NA";
			  }
			  
			  $temp['mobile']=$res['mobile'];

				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}
function issue_book_to_faculty($branch_id,$book_id){
	global $con;
  $IdSQL='';
  $data=array();
  if(!empty($branch_id)){
		$IdSQL.=" AND  branch_id='".$branch_id."'"; 
	}
	if(!empty($book_id)){
		$IdSQL.=" AND  book_id='".$book_id."'"; 
	}

	$sql = "SELECT *	 FROM `issue_bookto_faculty` WHERE 1 $IdSQL  ";
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				$temp['staff_name']=get_staff_byid($res['st_id'])['staff_name'];
				$temp['staff_id']=get_staff_byid($res['st_id'])['staff_id'];
				
			  $temp['issue_date']=date("d-m-Y ", strtotime($res['issue_date']));
			  $temp['return_date']=date("d-m-Y ", strtotime($res['return_date']));
			  if(!empty($res['returned_date'])){
			  		$temp['returned_date']=date("d-m-Y ", strtotime($res['returned_date']));
			  }else{
			  	$temp['returned_date']="NA";
			  }
			  
			

				array_push($data,$temp);
		}	
		return $data;
	}else{
		return $data;
	}		
}
function view_online_admission($class_id,$session_id,$CurrentPage, $PerPage){
	global $con;
  $IdSQL='';
  $data=array();
  $final=array();
    $PerPage='20';
	$c_page =(!empty($CurrentPage)) ?  $PerPage * ($CurrentPage - 1) : '0';
  $total_applied=$total_requested=$total_approved=$total_decline=0;
  if(!empty($class_id)){
		$IdSQL.=" AND  grade='".$class_id."'"; 
	}
	if(!empty($session_id)){
		$IdSQL.=" AND  session='".$session_id."'"; 
	}
  $sql = "SELECT *	 FROM `admission` WHERE 1 $IdSQL  ";
  $q2=mysqli_query($con,$sql);
	$TotalRecords = mysqli_num_rows($q2);

	$sql.=" LIMIT $c_page, $PerPage ";
	
	$query=mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		while($res=mysqli_fetch_assoc($query)){
				$temp=array();
				// print_r($res);
				$temp['reference_no']=$res['reference_no'];
				$temp['name']=$res['name'];
				$temp['fathername']=$res['fathername'];
				$temp['gender']=$res['gender'];
				$temp['dob']=date("d-m-Y ", strtotime($res['dob']));
				$temp['class_name']= get_class_byid($res['grade'])['class_name'];
				$temp['phone']=$res['phone'];
				// $temp['qualification']=$res['qualification'];
				$temp['city']=$res['city'];
				$temp['pincode']=$res['pincode'];
				$temp['address']=$res['address'];
				$temp['caste']=$res['caste'];
				$temp['apply_date']=date("d-m-Y ", strtotime($res['apply_date']));
				if($res['status']=='0'){
					$temp['status']='Applied';
					$total_applied++;
				}elseif($res['status']=='1'){
					$temp['status']='Requested';
					$total_requested++;
				}elseif($res['status']=='2'){
					$temp['status']='Approve';
					$total_approved++;
				}elseif($res['status']=='3'){
					$temp['status']='Decline';
					$total_decline++;
				}else{
					$temp['status']='';
				}	
				//   $final['total_applied']=$total_applied;
				//   $final['total_requested']=$total_requested;
				//   $final['total_approved']=$total_approved;
				//   $final['total_decline']=$total_decline;
				array_push($data,$temp);
		}	
		// array_unshift($data,$final);
			
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
	
		$final['total_applied']=$total_applied;
		$final['total_requested']=$total_requested;
		$final['total_approved']=$total_approved;
		$final['total_decline']=$total_decline;
		$final['data']=$data;
		return $final;
	}else{
		$final['current_page'] = $CurrentPage;
		$final['per_page'] = $PerPage;
		$final['total_page'] = ceil($TotalRecords / $PerPage);
		$final['total_records'] = $TotalRecords;
		$final['data']=[];
		return $final;
	}		
}
function view_sms_details(){
global $con;
$Wtemp=array();
$Ttemp=array();
$data=array();
$final=array();
	//whatsapp sms details
  $query1=mysqli_query($con,"select * from `log_sms_count` where id='1' ");
  if(mysqli_num_rows($query1)){
  	$Wrow=mysqli_fetch_assoc($query1);
  		$Wtemp=array();
				$Wtemp['Whatsapp_sms_limit']=$Wrow['limit'];
				$Wtemp['remaining_sms']=$Wrow['count_sms'];
				$Wtemp['this_month_send_sms']=($Wrow['curr_month']) ? $Wrow['curr_month'] : '0' ;
				$Wtemp['last_month_send_sms']=($Wrow['prev_month']) ? $Wrow['prev_month'] : '0' ;
				$Wtemp['total_send_sms']=$Wrow['total_send'];
				array_push($data,$Wtemp);
  }
  $query2=mysqli_query($con,"select * from `log_sms_count` where id='2' ");
  if(mysqli_num_rows($query2)){
  	$Trow=mysqli_fetch_assoc($query2);
  		$Ttemp=array();
				$Ttemp['Text_sms_limit']=$Trow['limit'];
				$Ttemp['remaining_sms']=$Trow['count_sms'];
				$Ttemp['this_month_send_sms']=($Trow['curr_month']) ? $Trow['curr_month'] : '0' ;
				$Ttemp['last_month_send_sms']=($Trow['prev_month']) ? $Trow['prev_month'] : '0' ;
				$Ttemp['total_send_sms']=$Trow['total_send'];
  			array_push($data,$Ttemp);
  }
  $final['whatsapp']=$data[0];
  $final['text']=$data[1];
  return $final;
}
?>