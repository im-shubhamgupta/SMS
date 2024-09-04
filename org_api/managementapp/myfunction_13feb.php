<?php
include('../connection.php');
extract($_REQUEST);	

function login($email,$password)
{
	global $con;
	$query = mysqli_query($con,"select * from users where email='$email' && pass='$password'");
	$row = mysqli_num_rows($query);
	if($row)
	{
		$res = mysqli_fetch_assoc($query);
		@$temp = array();
	    $temp['user_id'] = $res['user_id']; 
	    $temp['username'] = $res['username']; 
		echo json_encode($temp);
	}
	else
	{
		return "Invalid Details";
	}
}


function profile($id)
{
	global $con;
	$query = mysqli_query($con,"select * from users where user_id='$id'");
	$row = mysqli_num_rows($query);
	if($row)
	{		
		$res = mysqli_fetch_array($query);
		@$temp = array();
		$temp['username'] = $res['username']; 
		$temp['roles'] = $res['roles']; 
		$temp['profile_image'] = $res['profile_image'];
		echo json_encode($temp);
	}
	else
	{
		return "Invalid Id";
	}
}


function studentdetail()
{
	global $con;
	$data = array();
	$q1=mysqli_query($con,"select * from students where stu_status='0'");
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

			$q3 = mysqli_query($con,"select * from students where class_id='$classid'");
			$row3 = mysqli_num_rows($q3);
			if($row3)
			{
			@$temp = array();
			$temp['class_name'] = $classname;
			$temp['no_of_students'] = $row3;
			array_push($data, $temp);
			}
		}
		
			echo json_encode($data);
	}
	else
	{
		return "Invalid Details";
	}
}


function financedetail()
{
	global $con;
	$data = array();
	$q1 = mysqli_query($con,"select * from student_wise_fees");
	$row = mysqli_num_rows($q1);
	if($row)
	{
		
		$discamount = 0;
		$totalfee_tocollect = 0;
		while($res1 = mysqli_fetch_array($q1))
		{
			$discamount = $discamount + $res1['discount_amount'];
			
			$stramt = $res1['fee_amount'];
			$arramt = explode(',',$stramt);
			foreach($arramt as $k)
			{
				$totalfee_tocollect = $totalfee_tocollect + $k;
			}		
		}

		
		$q2 = mysqli_query($con,"select * from student_route");
		$totalfee_trans = 0;
		$discfee_trans = 0;
		while($res2 = mysqli_fetch_array($q2))
		{
			$transamt = $res2['price'];
			$discount = $res2['discount'];
			$totalfee_trans = $totalfee_trans + $transamt;
			$discfee_trans = $discfee_trans + $discount;
			
		}
		$temp['header_name']= "Total Amount to Collect";
		$temp['amount']= $totalfee_tocollect+$discamount+$totalfee_trans+$discfee_trans; 
		array_push($data, $temp);	
		
		$que3=mysqli_query($con,"select * from student_due_fees");
		$tpaidamt = 0;
		$tpaidamt1 = 0;
		$trans = 0;
		while($rque3=mysqli_fetch_array($que3))
		{
			$recdamt=$rque3['received_amount'];
			$tranamt=$rque3['transport_amount'];
			$arr = explode(',',$recdamt);
			
			foreach($arr as $k)
			{
			 $tpaidamt1 = $tpaidamt1 + $k ;
			}
			
			$trans = $trans + $tranamt;
			$tpaidamt = $tpaidamt1 + $trans;
		}
			@$temp = array();
			$temp['header_name']= "Total Paid Amount";
			$temp['amount']= $tpaidamt; 
			array_push($data, $temp);
		
		
		$q1 = mysqli_query($con,"select * from student_wise_fees");
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
		$temp['amount']= $discamount + $discfee_trans;
		array_push($data, $temp);
		
		$que3=mysqli_query($con,"select * from student_due_fees");
		while($rque3=mysqli_fetch_array($que3))
		{
			$recdamt=$rque3['received_amount'];
			$tranamt=$rque3['transport_amount'];
			$arr = explode(',',$recdamt);
			
			foreach($arr as $k)
			{
			 $tpaidamt1 = $tpaidamt1 + $k ;
			}
			
			$trans = $trans + $tranamt;
			$tpaidamt = $tpaidamt1 + $trans;
		}
		
			@$temp = array();
			$temp['header_name']= "Total Transport Amount";
			$temp['amount']= $totalfee_trans; 
			array_push($data, $temp);
			
		
			
			echo json_encode($data);
	}
	else
	{
		return "Invalid Id";
	}
}


function expensename()
{
	global $con;
	$data = array();
	
	$q1=mysqli_query($con,"select * from expense_type");
	$row=mysqli_num_rows($q1);
	if($row)
	{
		while($r1 = mysqli_fetch_array($q1))
		{
			$expid = $r1['expense_type_id'];
			$expname = $r1['expense_type_name'];

			$temp['expense_id'] = $expid;
			$temp['expense_name'] = $expname;
			array_push($data, $temp);
			}
			
		echo json_encode($data);
	}
	else
	{
		return "No Expense";
	}
}


function expensedetail()
{
	global $con;
	$data = array();
	$q1=mysqli_query($con,"select * from expense");
	$row=mysqli_num_rows($q1);
	if($row)
	{
		@$temp = array();
		$tamount=0;
		while($r1=mysqli_fetch_array($q1))
		{
			$tamount+=$r1['amount'];
		}
		
		$temp['total_expense']= $tamount; 
		array_push($data, $temp);
		
		$q2 = mysqli_query($con,"select * from expense_type");
		while($r2 = mysqli_fetch_array($q2))
		{
			$expenseid = $r2['expense_type_id'];
			$expensename = $r2['expense_type_name'];

			$q3 = mysqli_query($con,"select * from expense where expense_type_id='$expenseid'");
			$row3 = mysqli_num_rows($q3);
			if($row3)
			{
				$amount = 0;
				while($r3 = mysqli_fetch_array($q3))
				{
					$amount = $amount + $r3['amount'];
				}
				
			@$temp = array();
			$temp['expense_name'] = $expensename;
			$temp['expense_amount'] = $amount;
			array_push($data, $temp);
			}
		}
		
		echo json_encode($data);
	}
	else
	{
		return "No Expense";
	}
}


function staffdetail()
{
	global $con;
	$data = array();
	
	$query = mysqli_query($con,"select * from staff");
	$row1 = mysqli_num_rows($query);
	if($row1)
	{
		@$temp = array();
		$temp['total_no_of_staff'] = $row1; 
		array_push($data, $temp);
	
	$q1 = mysqli_query($con,"select * from staff group by teaching_type");
	
	
	while($r1 = mysqli_fetch_array($q1))
	{
		$staff_name = $r1['teaching_type'];
		
		$q2 = mysqli_query($con,"select * from staff where teaching_type='$staff_name'");
		$row2 = mysqli_num_rows($q2);
		@$temp = array();
		$temp['staff_name'] = $staff_name; 
		$temp['no_of_staff'] = $row2; 
		array_push($data, $temp);
	
	}
	echo json_encode($data);
	}
	else
	{
		return "Invalid Data";
	}
	
}


?>