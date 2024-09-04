<?php include('../myfunction.php')?>
<?php
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['add_user'])){
// echo "<pre>";
// print_r($_POST);
// print_r($_SESSION);
// die;
$username=mysqli_real_escape_string($con,trim($_POST['username']));
$designation=mysqli_real_escape_string($con,trim($_POST['designation']));
$phone=mysqli_real_escape_string($con,trim($_POST['phone']));
$email=mysqli_real_escape_string($con,trim($_POST['email']));
$password=mysqli_real_escape_string($con,trim($_POST['password']));

// $user_logged_in=mysqli_real_escape_string($con,trim($_SESSION['user_logged_in']));
// $user_roles=mysqli_real_escape_string($con,trim($_SESSION['user_roles']));
$machinename=mysqli_real_escape_string($con,trim($_SESSION['machinename']));
$ExactBrowserNameBR=mysqli_real_escape_string($con,trim($_SESSION['ExactBrowserNameBR']));

	$sql=mysqli_query($con,"select * from users where username='$username' || email='$email' ");
	$res=mysqli_num_rows($sql);
	$sql2=mysqli_query($con,"select phone from users where phone='$phone' and `roles` != 'superadmin' ");
	$chk_phone=mysqli_num_rows($sql2);


		if($res){
			$responce['status']='error';						 
  		    $responce['message']='This Username / Email Already Exists';	

		}elseif($chk_phone){
			$responce['status']='error';						 
		    $responce['message']='This phone no. Already Exists';	

		}else{	
			$img=$_FILES['file']['name'];

			if($img==""){

			$query=mysqli_query($con,"insert into users(username,roles,phone,email,pass,status,create_date,modify_date) values	('$username','$designation','$phone','$email','$password','1',now(),now())");
			// echo mysqli_error($con);

			}else{
				$name=explode('.',$img);
				$ext=pathinfo($img,PATHINFO_EXTENSION);
				$num=substr($name[0],0,4);                   //take four letter only 
				$image_name=$num.'_'.date("Ymd-His").'.'.$ext;

				move_uploaded_file($_FILES['file']['tmp_name'],"../images/admin/".$image_name);

				$query=mysqli_query($con,"insert into users(username,roles,phone,email,pass,profile_image,status,create_date,modify_date) values

				('$username','$designation','$phone','$email','$password','$image_name','1',now(),now())");
			}

				if($query){
	                $responce['status']='success';						 
	  		        $responce['message']='User Added Successfully';	

				}else{
					$responce['status']='error';						 
	  		        $responce['message']='Something went wrong, Please try again.';
				}
		}
echo json_encode($responce);
}

if(isset($_POST['update_user'])){
// echo "<pre>";
// print_r($_POST);
$id=mysqli_real_escape_string($con,trim($_POST['id']));
$username=mysqli_real_escape_string($con,trim($_POST['username']));
$designation=mysqli_real_escape_string($con,trim($_POST['designation']));
$phone=mysqli_real_escape_string($con,trim($_POST['phone']));
$email=mysqli_real_escape_string($con,trim($_POST['email']));
$password=mysqli_real_escape_string($con,trim($_POST['password']));
$status=mysqli_real_escape_string($con,trim($_POST['status']));
	//$npass=md5($password);
$flag=false;
if(!empty($id)){
$flag=true;
}else{
		$responce['status']='error';						 
	    $responce['message']='Something went wrong,Id not found';
}
if($flag){
	$sql=mysqli_query($con,"select * from users where user_id!='$id' and `roles` != 'superadmin'");
	// $row=mysqli_num_rows($sql);
	while($chk_data=mysqli_fetch_array($sql)){
	// echo "<pre>";
	// print_r($chk_data);
		if($chk_data['phone']==$phone){
			$responce['status']='error';						 
		    $responce['message']='This phone no is Already Exists';

		}elseif($chk_data['email']==$email){
			$responce['status']='error';						 
		    $responce['message']='This Email id is Already Exists';
		}
    }

	if($responce['status']!='error'){
		$query=mysqli_query($con,"select * from users where user_id='$id'");
	    $res=mysqli_fetch_array($query);
	    $picture=$res['profile_image'];
		$pic=$_FILES['file']['name'];

		if ($pic==""){

			$que="update users set roles='$designation', phone='$phone', email='$email', pass='$password',status='$status',modify_date=now() where user_id='$id'";

			$chk=mysqli_query($con,$que);

			

		}else{
			    $name=explode('.',$pic);
				$ext=pathinfo($pic,PATHINFO_EXTENSION);
				$num=substr($name[0],0,4);                   //take four letter only 
				$image_name=$num.'_'.date("Ymd-His").'.'.$ext;

			$que="update users set roles='$designation', phone='$phone', email='$email', pass='$password', profile_image='$image_name',status='$status',modify_date=now() where user_id='$id'";

			$chk=mysqli_query($con,$que);

			move_uploaded_file($_FILES['file']['tmp_name'],"../images/admin/".$image_name);
			if(!empty($picture) && file_exists('../images/admin/$picture')){
			      unlink ("images/admin/$picture");
		    }
		}
		    if($chk){
	                $responce['status']='success';						 
	  		        $responce['message']='User Updated Successfully';	

			}else{
				$responce['status']='error';						 
			        $responce['message']='Something went wrong, Please try again.';
			}
    }
}//flag
echo json_encode($responce);

}

