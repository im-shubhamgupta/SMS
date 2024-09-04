<?php include('../myfunction.php')?>
<?php

if(isset($_POST['Assign_classTeacher'])){
// echo "<pre>";
// print_r($_POST);

$class=$_POST['class'];
$section=$_POST['section'];
$faculty=$_POST['faculty'];

$q1 = mysqli_query($con,"select * from assign_clsteacher where class_id='$class' && section_id='$section' && session='".$_SESSION['session']."'");

if(mysqli_num_rows($q1)){
$r1 = mysqli_fetch_assoc($q1);
	$assign_clst_id=$r1['assign_clst_id'];

	 $Usql="UPDATE `assign_clsteacher` SET `class_id`='$class',`section_id`='$section' , `st_id`='$faculty',`modify_date`=now() WHERE `assign_clst_id`='$assign_clst_id'";

	$update=mysqli_query($con,$Usql);

	if($update){

		$responce['type']='success';						 
	    $responce['msg']='Class Teacher Updated Sucessfully';

	}else{
			$responce['type']='error';						 
  		    $responce['msg']='Something went wrong, Please try again';
	}

}else{

	  $que="insert into assign_clsteacher (class_id,section_id,st_id,session,create_date,modify_date)	values ('$class','$section','$faculty','".$_SESSION['session']."',now(),now())";

	if(mysqli_query($con,$que)){

		$q1 = mysqli_query($con,"select * from class where class_id='$class'");

		$r1 = mysqli_fetch_array($q1);

		$clsname = $r1['class_name'];

		

		$q2 = mysqli_query($con,"select * from section where section_id='$section'");

		$r2 = mysqli_fetch_array($q2);

		$secname = $r2['section_name'];

		

		$q3 = mysqli_query($con,"select * from staff where st_id='$faculty'");

		$r3 = mysqli_fetch_array($q3);

		$staffname = $r3['staff_name'];

		$action = "Class Teacher ".$staffname. " assigned to ".$clsname." ".$secname; 

		$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

		machine_name,browser,date) 

		values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

		$responce['type']='success';						 
	    $responce['msg']='Class Teacher Assigned Sucessfully';

	}else{
			$responce['type']='error';						 
  		    $responce['msg']='Something went wrong, Please try again';
	}
}
		echo json_encode($responce); 

	// echo "<script>window.location='dashboard.php?option=assign_classteacher&smid=19'</script>";

	

}

if(isset($_POST['Update_classTeacher'])){
// echo "<pre>";
// print_r($_POST);

$class=$_POST['class'];
$section=$_POST['section'];
$faculty=$_POST['faculty'];
$id=$_POST['id'];

	$que="update assign_clsteacher set class_id='$class', section_id='$section',

	st_id='$faculty',modify_date=now() where assign_clst_id='$id'";

	

	if(mysqli_query($con,$que)){

	


		$responce['type']='success';						 
	    $responce['msg']='Class Teacher Updated Sucessfully';

	}else{
		$responce['type']='error';						 
		$responce['msg']='Something went wrong, Please try again';


		
	}

	echo json_encode($responce);


	}

if(isset($_POST['AssignDepartment'])){
// echo "<pre>";
// print_r($_POST);
$dept = $_POST['dept'];

$staffid = $_POST['to'];
foreach($staffid as $k){

$que2=mysqli_query($con,"insert into assign_department(dept_id,staff_id,date)

		values('$dept','$k',now())");

}

	if($que2){

		$responce['type']='success';						 
	    $responce['msg']='Department Assign Sucessfully';

	}else{
		$responce['type']='error';						 
		$responce['msg']='Something went wrong, Please try again';
	}

	echo json_encode($responce);

}

if(isset($_POST['AssignSubject'])){
// echo "<pre>";
// print_r($_POST);
$faculty = $_POST['faculty'];
$class = $_POST['class'];
$section = $_POST['section'];
$subject = $_POST['subject'];
	

	$qsub = mysqli_query($con,"select * from subject where subject_id='$subject'");

	$rsub = mysqli_fetch_array($qsub);

	$subname = $rsub['subject_name'];

	

	$qcls = mysqli_query($con,"select * from class where class_id='$class'");

	$rcls = mysqli_fetch_array($qcls);

	$clsname = $rcls['class_name'];

	

	$qsec = mysqli_query($con,"select * from section where section_id='$section'");

	$rsec = mysqli_fetch_array($qsec);

	$secname = $rsec['section_name'];	



	$q1 = mysqli_query($con,"select * from assign_subject where class_id='$class' && section_id='$section' && subject_id='$subject'");

	$row = mysqli_num_rows($q1);

	if($row){

		$responce['type']='error';						 
		$responce['msg']="The Subject ".$subname." for Class ".$clsname.", Section ".$secname." is already Assigned";

	}else{

		$que=mysqli_query($con,"insert into assign_subject (st_id,class_id,section_id,subject_id,create_date,modify_Date) 

		values ('$faculty','$class','$section','$subject',now(),now())");

		 
    if($que){

		$responce['type']='success';						 
	    $responce['msg']='Subject Assigned Sucessfully';

	}else{
		$responce['type']='error';						 
		$responce['msg']='Something went wrong, Please try again';
	}

	}

	echo json_encode($responce);

}

if(isset($_POST['UpdateAssignSubject'])){
// echo "<pre>";
// print_r($_POST);

$id = $_POST['id'];
$faculty = $_POST['faculty'];
$class = $_POST['class'];
$section = $_POST['section'];
$subject = $_POST['subject'];


 $usql="update assign_subject set st_id='$faculty', class_id='$class', 	section_id='$section', subject_id='$subject',modify_Date=now() where assign_sub_id='$id'";
	$que=mysqli_query($con,$usql);

	  if($que){

		$responce['type']='success';						 
	    $responce['msg']='Updated Sucessfully';

	}else{
		$responce['type']='error';						 
		$responce['msg']='Something went wrong, Please try again';
	}
	echo json_encode($responce);
}
if(isset($_POST['AssignSyllabus'])){
// echo "<pre>";
// print_r($_POST);

$id = $_POST['id'];
$chapter = $_POST['chapter'];
$days = $_POST['days'];
$fromdt = $_POST['fromdt'];
$todt = $_POST['todt'];
$description = $_POST['description'];

$q = mysqli_query($con,"select * from assign_subject where assign_sub_id='$id'");

$r = mysqli_fetch_array($q);


$stid = $r['st_id'];

$clid = $r['class_id'];

$secid = $r['section_id'];

$subid = $r['subject_id'];


	 $sql="insert into assign_syllabus_staff (staff_id,class_id,section_id,subject_id,chapter,from_dt,to_dt,days,description,status,session,creation_dt) values('$stid','$clid','$secid','$subid','$chapter','$fromdt','$todt','$days','$description','3','".$_SESSION['session']."',now())";
	$q1 = $con->query($sql);
	if($q1){
		$responce['type']='success';						 
	    $responce['msg']='Syllabus Assigned Sucessfully';
	}else{
		$responce['type']='error';						 
		$responce['msg']='Something went wrong, Please try again';
	}
	echo json_encode($responce);

	// if(mysqli_error($con)){

	// 	echo("Error description: " . mysqli_error($con));

	// }
}
if(isset($_POST['UpdateSyllabusStatus'])){
// echo "<pre>";
// print_r($_POST);
$id = $_POST['id'];
$status = $_POST['status'];
$completion_dt = $_POST['completion_dt'];
$comments = $_POST['comments'];
$username=$_SESSION['user_roles'];
	$usql="update assign_syllabus_staff set status='$status', completion_date='$completion_dt', comments='$comments', updated_dt=now(), updated_by='$username' where assign_syllabus_id='$id'";

	$q1 = mysqli_query($con,$usql);

	if($q1){
		$responce['type']='success';						 
	    $responce['msg']='Status Updated';
	}else{
		$responce['type']='error';						 
		$responce['msg']='Something went wrong, Please try again';
	}
	echo json_encode($responce);
}
if(isset($_POST['CreateDepartment'])){
// echo "<pre>";
// print_r($_POST);
$deptname = $_POST['deptname'];
$roles = $_POST['roles'];
$panelid = $_POST['panelid'];
$menuid = $_POST['menuid'];
$submenuname = $_POST['submenuname'];
$machinename = $_POST['machinename'];
$ExactBrowserNameBR = $_POST['ExactBrowserNameBR'];

		$sql=mysqli_query($con,"select * from department where dept_name='$deptname'");

		$row=mysqli_num_rows($sql);

		if($row){
			$responce['type']='error';						 
	        $responce['msg']='This Department Is Already Exists';

		}else{

			$query="insert into department values('0','$deptname')";	

			if(mysqli_query($con,$query))

			{

				$action = "Department ".$deptname." is created"; 

				$q1 = mysqli_query($con,"insert into activity_history (login_user,panel_id,menu_id,sub_menu,action_details,

				machine_name,browser,date) 

				values ('$roles','$panelid','$menuid','$submenuname','$action','$machinename','$ExactBrowserNameBR','$currdt')");

				$responce['type']='success';						 
	            $responce['msg']=' Department Added Successfully';

			}else{
				$responce['type']='error';						 
		        $responce['msg']='Something went wrong, Please try again';

			}

		}
	echo json_encode($responce);
}

if(isset($_POST['AddSubject'])){
// echo "<pre>";
// print_r($_POST);
$class = $_POST['class'];
$subject = $_POST['subject'];


		$sql=mysqli_query($con,"select * from subject where subject_name='$subject' && class_id='$class'");

		$res1=mysqli_num_rows($sql);

		if($res1)

		{

			$responce['type']='error';						 
	        $responce['msg']='This Subject Is Already Exists';	

		}

		else

		{

			$query1="insert into subject(subject_name,class_id,create_date,modify_Date) values('$subject','$class',now(),now())";	

			if(mysqli_query($con,$query1)){


				$responce['type']='success';						 
	            $responce['msg']='  Subject Added Successfully';

			}else{
				$responce['type']='error';						 
		        $responce['msg']='Something went wrong, Please try again';

			}
		}
echo json_encode($responce);

	}
if(isset($_POST['Load_Update_Allocated_Syllbus_Format'])){
// echo "<pre>";
// print_r($_POST);
$faculty = $_POST['faculty'];
$class = $_POST['class'];
$section = $_POST['section'];
$subject = $_POST['subject'];
$fromdt = $_POST['fromdt'];
$todt = $_POST['todt'];

	$cond = '';
	if($faculty!=''){
		$cond.="&& staff_id='$faculty'";

	}
	if($class!=''){

		$cond.="&& class_id='$class'";

	}

	if($section!=''){

		$cond.="&& section_id='$section' ";

	}
	if($subject!=''){

		$cond.=" && subject_id='$subject' ";

	}
	if(!empty($fromdt) && !empty($todt)){
		
		$cond.=" && from_dt>='$fromdt' && to_dt<='$todt' ";
	}
	$cond.=" && session='".$_SESSION['session']."' ";

	$query = mysqli_query($con,"SELECT * FROM `assign_syllabus_staff` WHERE  1  $cond ");


			$sr=1;
			if(mysqli_num_rows($query)){

			while($res=mysqli_fetch_array($query)){									

			

			$id = $res['assign_syllabus_id'];

			

			$staffid=$res['staff_id'];

			$qst=mysqli_query($con,"select * from staff where st_id='$staffid'");

			$rst=mysqli_fetch_array($qst);

			$stname=$rst['staff_name'];

			

			$clid=$res['class_id'];

			$qcls=mysqli_query($con,"select * from class where class_id='$clid'");

			$rcls=mysqli_fetch_array($qcls);

			$clsname=$rcls['class_name'];

			

			$secid=$res['section_id'];

			$qsec=mysqli_query($con,"select * from section where section_id='$secid'");

			$rsec=mysqli_fetch_array($qsec);

			$secname=$rsec['section_name'];

			$subid=$res['subject_id'];

			$qsub=mysqli_query($con,"select * from subject where subject_id='$subid'");

			$rsub=mysqli_fetch_array($qsub);

			$subname=$rsub['subject_name'];

			

			$frmdt = $res['from_dt'];

			$nfrmdt = date("d-m-Y",strtotime($frmdt));



			$todt = $res['to_dt'];

			$ntodt = date("d-m-Y",strtotime($todt));



			?>

			<tr>

				<td><?php echo $sr; ?></td>

				<td><?php echo $stname; ?></td>

				<td><?php echo $clsname; ?></td>

				<td><?php echo $secname; ?></td>

				<td><?php echo $subname;?></td>										

				<td><?php echo $res['chapter'];?></td>										

				<td><?php echo $nfrmdt;?></td>										

				<td><?php echo $ntodt;?></td>										

				<td><?php echo $res['days'];?></td>										

				<td><?php echo $res['description'];?></td>	

				<td>

				<?php echo "<a href='dashboard.php?option=update_syllabus_status&id=$id' class='btn btn-secondary btn-sm' target='_blank'> Update Status</a>";

					?>

				</td>

			</tr>
<?php
	$sr++;

	}//while
   }
}
		
