<?php include('../myfunction.php')?>
<?php
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['add_book_type'])){
// echo "<pre>";
// print_r($_POST);
$book=mysqli_real_escape_string($con,ucwords(trim($_POST['book'])));
		$sql=mysqli_query($con,"select * from book_type where book_type_name='$book'");

		$res=mysqli_num_rows($sql);

		if($res){
			$responce['status']='error';						 
	            $responce['message']=' This Book Type Is Already Exists  ';

		}else{

			$query="insert into book_type (book_type_name,create_date,modify_date) values('$book',now(),now())";	

			if(mysqli_query($con,$query)){
				$responce['status']='success';						 
	            $responce['message']='Book Type Added Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}

		}
echo json_encode($responce);
}

if(isset($_POST['update_book_type'])){
// echo "<pre>";
// print_r($_POST);
$eid=mysqli_real_escape_string($con,$_POST['eid']);
$book=mysqli_real_escape_string($con,ucwords(trim($_POST['book'])));

		$sql1=mysqli_query($con,"select * from book_type where book_type_name='$book' and book_type_id!='$eid'");

		$res1=mysqli_num_rows($sql1);

		if($res1)

		{
                $responce['status']='error';						 
	            $responce['message']=' This Book Type Is Already Exists  ';	

		}else{
		$up=mysqli_query($con,"update book_type set book_type_name='$book',modify_date=now() where book_type_id='$eid'");		

		if($up){
				$responce['status']='success';						 
	            $responce['message']='Book Type updated Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
			}
		}	
echo json_encode($responce);
	}



if(isset($_POST['add_branch'])){
// echo "<pre>";
// print_r($_POST);
$branch=mysqli_real_escape_string($con,ucwords(trim($_POST['branch'])));

		$sql=mysqli_query($con,"select * from branch where branch_name='$branch'");

		$res=mysqli_num_rows($sql);

		if($res){
			$responce['status']='error';						 
	            $responce['message']=' This Branch Is Already Exists  ';
		}else{

			$query=mysqli_query($con,"insert into branch (branch_name,create_date,modify_date) values('$branch',now(),now())");	

			if($query){
				$responce['status']='success';						 
	            $responce['message']='Branch Added Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}
		}
echo json_encode($responce);

	}

if(isset($_POST['update_branch'])){
// echo "<pre>";
// print_r($_POST);
$eid=mysqli_real_escape_string($con,$_POST['eid']);
$branch=mysqli_real_escape_string($con,ucwords(trim($_POST['branch'])));
		$branch = trim($branch," ");

		$sql1=mysqli_query($con,"select * from branch where branch_name='$branch' and branch_id!='$eid'");

		$res1=mysqli_num_rows($sql1);

		if($res1){
			$responce['status']='error';						 
	            $responce['message']=' This Branch Is Already Exists  ';
		}else{

		$query=mysqli_query($con,"update branch set branch_name='$branch',modify_date=now() where branch_id='$eid'");		

		if($query){
				$responce['status']='success';						 
	            $responce['message']='Branch Updated Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}
		}	
echo json_encode($responce);
}



if(isset($_POST['add_vendor'])){
// echo "<pre>";
// print_r($_POST);	
$vendor=mysqli_real_escape_string($con,ucwords(trim($_POST['vendor'])));

		$sql=mysqli_query($con,"select * from vendor where vendor_name='$vendor'");

		$res=mysqli_num_rows($sql);

		if($res){
				$responce['status']='error';						 
	            $responce['message']='This Vendor Is Already Exists  ';
		}else{

			$query=mysqli_query($con,"insert into vendor (vendor_name,create_date,modify_date) values('$vendor',now(),now())");	

			if($query){
				$responce['status']='success';						 
	            $responce['message']='Vendor Added Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}
		}
echo json_encode($responce);

}


if(isset($_POST['update_vendor'])){
// echo "<pre>";
// print_r($_POST);	
$eid=mysqli_real_escape_string($con,($_POST['eid']));
$vendor=mysqli_real_escape_string($con,ucwords(trim($_POST['vendor'])));


		$sql1=mysqli_query($con,"select * from vendor where vendor_name='$vendor' and vendor_id!='$eid'");

		$res1=mysqli_num_rows($sql1);

		if($res1)

		{
			$responce['status']='error';						 
	            $responce['message']='This Vendor Is Already Exists  ';

		}else{	

		$query=mysqli_query($con,"update vendor set vendor_name='$vendor',modify_date=now() where vendor_id='$eid'");		

		if($query){
				$responce['status']='success';						 
	            $responce['message']='Vendor Updated Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
			}
		}	
echo json_encode($responce);
}


if(isset($_POST['add_publisher'])){		
// echo "<pre>";
// print_r($_POST);	
$publisher=mysqli_real_escape_string($con,ucwords(trim($_POST['publisher'])));

		$sql=mysqli_query($con,"select * from publisher where publisher_name='$publisher'");

		$res=mysqli_num_rows($sql);

		if($res){
			$responce['status']='error';						 
	            $responce['message']=' This Publisher Is Already Exists  ';	

		}else{

			$query=mysqli_query($con,"insert into publisher (publisher_name,create_date,modify_date) values('$publisher',now(),now())");	

			if($query){
				$responce['status']='success';						 
	            $responce['message']='Publisher Added Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
			}
		}
echo json_encode($responce);
}


if(isset($_POST['update_publisher'])){		
// echo "<pre>";
// print_r($_POST);	
$eid=mysqli_real_escape_string($con,$_POST['eid']);
$publisher=mysqli_real_escape_string($con,ucwords(trim($_POST['publisher'])));


		$sql1=mysqli_query($con,"select * from publisher where publisher_name='$publisher' and publisher_id!='$eid'");

		$res1=mysqli_num_rows($sql1);

		if($res1)

		{

			$responce['status']='error';						 
	            $responce['message']=' This Publisher Is Already Exists  ';		

		}

		else{

			

		$query=mysqli_query($con,"update publisher set publisher_name='$publisher',modify_date=now() where publisher_id='$eid'");		

		if($query){
				$responce['status']='success';						 
	            $responce['message']='Publisher updated Successfully ';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
			}

		}	
echo json_encode($responce);
	}




if(isset($_POST['add_books'])){
// echo "<pre>";
// print_r($_POST);	
$bookname=mysqli_real_escape_string($con,ucwords(trim($_POST['bookname'])));
$bookisbn=mysqli_real_escape_string($con,trim($_POST['bookisbn']));
$author=mysqli_real_escape_string($con,ucwords(trim($_POST['author'])));
$publisherid=mysqli_real_escape_string($con,trim($_POST['publisherid']));
$booktypeid=mysqli_real_escape_string($con,trim($_POST['booktypeid']));
$qty=mysqli_real_escape_string($con,trim($_POST['qty']));
$amount=mysqli_real_escape_string($con,trim($_POST['amount']));
$vendorid=mysqli_real_escape_string($con,trim($_POST['vendorid']));
$branchid=mysqli_real_escape_string($con,trim($_POST['branchid']));


	$sql=mysqli_query($con,"select * from books where book_isbn='$bookisbn'");

	$res=mysqli_num_rows($sql);

	if($res){

		$responce['status']='error';						 
	            $responce['message']=' This Book Is Already Exists  ';	

	}else{

		$query=mysqli_query($con,"insert into books values('0','$bookname','$bookisbn','$author','$publisherid',

		'$booktypeid','$qty','$amount','$vendorid','$branchid',now(),now())");

		if($query){
				$responce['status']='success';						 
	            $responce['message']='Book Added Successfully ';

		}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
		}
		// if(mysqli_error($con)){
		// 	echo ("Error description :" .mysqli_error($con));
		// }
	}
echo json_encode($responce);
}
if(isset($_POST['update_books'])){
// echo "<pre>";
// print_r($_POST);	
// die;
$bookname=mysqli_real_escape_string($con,ucwords(trim($_POST['bookname'])));
$bookisbn=mysqli_real_escape_string($con,trim($_POST['bookisbn']));
$author=mysqli_real_escape_string($con,ucwords(trim($_POST['author'])));
$publisherid=mysqli_real_escape_string($con,trim($_POST['publisherid']));
$booktypeid=mysqli_real_escape_string($con,trim($_POST['booktypeid']));
$quantity=mysqli_real_escape_string($con,trim($_POST['quantity']));
$price=mysqli_real_escape_string($con,trim($_POST['price']));
$vendorid=mysqli_real_escape_string($con,trim($_POST['vendorid']));
$branchid=mysqli_real_escape_string($con,trim($_POST['branchid']));
$eid=mysqli_real_escape_string($con,trim($_POST['eid']));

	if(!empty($eid)){

		$sql=mysqli_query($con,"select * from books where book_isbn='$bookisbn' and book_id!='$eid'");

		$res=mysqli_num_rows($sql);

		if($res){

			$responce['status']='error';						 
		            $responce['message']=' This Book Is Already Exists  ';	

		}else{
			$query=mysqli_query($con,"update books set book_name='$bookname', book_isbn='$bookisbn', author='$author', publisher_id='$publisherid',

			book_type_id='$booktypeid', quantity='$quantity', price='$price', vendor_id='$vendorid', branch_id='$branchid',modify_date=now()	where book_id='$eid'");
		}	

		if($query){
				$responce['status']='success';						 
	            $responce['message']='Book Updated Successfully ';

		}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
		}
	}else{
		$responce['status']='error';						 
	            $responce['message']='Something goes wrong plesae try again ';
	}
echo json_encode($responce);				

	}

if(isset($_POST['add_book_return_type'])){
// echo "<pre>";
// print_r($_POST);	
$return_name=mysqli_real_escape_string($con,ucwords(trim($_POST['return_name'])));
$return_days=mysqli_real_escape_string($con,trim($_POST['return_days']));
$book_fine=mysqli_real_escape_string($con,trim($_POST['book_fine']));
$remark=mysqli_real_escape_string($con,trim($_POST['remark']));



	$sql=mysqli_query($con,"select * from book_return_type where book_return_type_name='$return_name'");

	$res=mysqli_num_rows($sql);

	if($res){

			$responce['status']='error';						 
	            $responce['message']=' This Book Return Type Is Already Exists  ';		

	}else{

		$query=mysqli_query($con,"insert into book_return_type values('0','$return_name','$return_days','$book_fine',

		'$remark',now(),now())");	
		if($query){
				$responce['status']='success';						 
	            $responce['message']='Book Return Type Added Successfully';

		}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
		}
    }
echo json_encode($responce);
}
if(isset($_POST['update_book_return_type'])){
// echo "<pre>";
// print_r($_POST);	
$return_name=mysqli_real_escape_string($con,ucwords(trim($_POST['return_name'])));
$return_days=mysqli_real_escape_string($con,trim($_POST['return_days']));
$book_fine=mysqli_real_escape_string($con,trim($_POST['book_fine']));
$remark=mysqli_real_escape_string($con,trim($_POST['remark']));
$eid=mysqli_real_escape_string($con,trim($_POST['eid']));

		$query=mysqli_query($con,"update book_return_type set book_return_type_name='$return_name', return_type_days='$return_days', 

		book_fine_per_day='$book_fine', remarks='$remark',modify_date=now() where book_return_type_id='$eid'");		
		if($query){
				$responce['status']='success';						 
	            $responce['message']='Book Return Type Updated Successfully';

		}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
		}
echo json_encode($responce);
}

if(isset($_POST['issue_bookto_student'])){
// echo "<pre>";
// print_r($_POST);
// die;
$class=mysqli_real_escape_string($con,trim($_POST['class']));
$section=mysqli_real_escape_string($con,trim($_POST['section']));
$student=mysqli_real_escape_string($con,trim($_POST['student']));
$regno=mysqli_real_escape_string($con,trim($_POST['regno']));
$fathername=mysqli_real_escape_string($con,trim($_POST['fathername']));
$mobile=mysqli_real_escape_string($con,trim($_POST['mobile']));
$branch=mysqli_real_escape_string($con,trim($_POST['branch']));
$remark=mysqli_real_escape_string($con,trim($_POST['remark']));
$returntype=mysqli_real_escape_string($con,trim($_POST['returntype']));
$issuedt=mysqli_real_escape_string($con,trim($_POST['issuedt']));
$issuedt=mysqli_real_escape_string($con,trim($_POST['issuedt']));
$book_id=$_POST['bookid'];

	 if(empty($book_id)){

		 $responce['status']='error';						 
	            $responce['message']='Please Select Book ';

	 }else{

		$qret = mysqli_query($con,"select * from book_return_type where book_return_type_id='$returntype'");

		$rret = mysqli_fetch_array($qret);

		$retdays = $rret['return_type_days'];

		$newretdt = date("Y-m-d",strtotime("$issuedt +$retdays day")); 

		  foreach($book_id as $val){

		 $que=mysqli_query($con,"insert into issue_bookto_students (book_id,class_id,section_id,student_id,register_no,father_name,mobile,
		 branch_id,remark,return_type_id,issue_date,return_date,return_status,session,create_date,modify_date) 
		 values ('$val','$class','$section','$student','$regno','$fathername','$mobile','$branch','$remark','$returntype','$issuedt','$newretdt','0','".$_SESSION['session']."',now(),now())");

		 }
		 if($que){
				$responce['status']='success';						 
	            $responce['message']='Book issue Successfully';

		}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
		}
	 }	 
echo json_encode($responce);
}

if(isset($_POST['issue_bookto_faculty'])){
// echo "<pre>";
// print_r($_POST);
$faculty=mysqli_real_escape_string($con,trim($_POST['faculty']));
$branch=mysqli_real_escape_string($con,trim($_POST['branch']));
$remark=mysqli_real_escape_string($con,trim($_POST['remark']));
$returntype=mysqli_real_escape_string($con,trim($_POST['returntype']));
$issuedt=mysqli_real_escape_string($con,trim($_POST['issuedt']));


	 $book_id=$_POST['bookid'];

	 

	 if($book_id=="")

	 {

		 $responce['status']='error';						 
	            $responce['message']='Please Select Book ';

	 }else{

		

		$qret = mysqli_query($con,"select * from book_return_type where book_return_type_id='$returntype'");

		$rret = mysqli_fetch_array($qret);

		$retdays = $rret['return_type_days'];

				

		$newretdt = date("Y-m-d",strtotime("$issuedt +$retdays day")); 

		

		  foreach($book_id as $val)

		 {

		 $que=mysqli_query($con,"insert into issue_bookto_faculty (book_id,st_id,branch_id,remark,return_type_id,issue_date,	 return_date,return_status,session,create_date,modify_date) 

		 values ('$val','$faculty','$branch','$remark','$returntype','$issuedt','$newretdt','0','".$_SESSION['session']."',now(),now())");

		 }

		  if($que){
				$responce['status']='success';						 
	            $responce['message']='Book issue Successfully';

		}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
		}
	 }	 
echo json_encode($responce);
}

if(isset($_POST['return_book'])){
// echo "<pre>";
// print_r($_POST);

// die;
// $option=mysqli_real_escape_string($con,trim($_POST['option']));
$rettype=mysqli_real_escape_string($con,trim($_POST['returntype']));
// $class=mysqli_real_escape_string($con,trim($_POST['class']));
// $section=mysqli_real_escape_string($con,trim($_POST['section']));
// $student=mysqli_real_escape_string($con,trim($_POST['student']));
// $fathername=mysqli_real_escape_string($con,trim($_POST['fathername']));
$retdt1=mysqli_real_escape_string($con,trim($_POST['returndt1']));
$retdt2=mysqli_real_escape_string($con,trim($_POST['returndt2']));
		$id=$_POST['issid'];

if($id==""){

 $responce['status']='error';						 
        $responce['message']='No any book to Return ';

}else{


	if($rettype=="stu"){

		foreach($id as $val){
				$que=mysqli_query($con,"update issue_bookto_students set return_status='1', returned_date='$retdt1',modify_date=now() where issue_id='$val'");

				}

	}else if($rettype=="fac"){

		foreach($id as $val){
			 $sql="update issue_bookto_faculty set return_status='1', returned_date='$retdt2',modify_date=now() where faculty_issue_id='$val'";
				$que=mysqli_query($con,$sql);
				}
	}		 	 
	if($que){
			$responce['status']='success';						 
            $responce['message']='Return Book Successfully';

	}else{
			$responce['status']='error';						 
            $responce['message']='Something went wrong plesae try again ';
	}
}			
echo json_encode($responce);
}

if(isset($_POST['library_payment'])){
// echo "<pre>";
// print_r($_POST);

$penaltyamt=mysqli_real_escape_string($con,trim($_POST['penaltyamt']));
$paidamt=mysqli_real_escape_string($con,trim($_POST['paidamt']));
$dueamt=mysqli_real_escape_string($con,trim($_POST['dueamt']));
$stuid=mysqli_real_escape_string($con,trim($_POST['stuid']));
$issid=mysqli_real_escape_string($con,trim($_POST['issid']));

if($penaltyamt>0){



	 $sql="insert into library_payment (issue_id,student_id,penalty_amount,paid_amount,due_amount,issue_date,date) values('$issid','$stuid','$penaltyamt','$paidamt','$dueamt',now(),now())";
	$query= mysqli_query($con,$sql);

	if($query){
	     $responce['status']='success';						 
            $responce['message']='Payment Successfully Received';

	}else{
			$responce['status']='error';						 
            $responce['message']='Something went wrong plesae try again ';
	}
}else{
	$responce['status']='error';						 
            $responce['message']='No amount to pay ';

}	
echo json_encode($responce);
}