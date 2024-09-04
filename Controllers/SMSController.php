<?php include('../myfunction.php')?>
<?php


if(isset($_POST['update_sms_status'])){

// echo "<pre>";
// print_r($_POST);

if(isset($_POST['text'])){

	if($_POST['text']==1){

		$row=mysqli_query($con,"update sms_setting set status='1' where sms_id='1'");	

	}elseif($_POST['text']==0){

		$row=mysqli_query($con,"update sms_setting set status='0' where sms_id='1'");	
	}
	if($row){
  		$responce['type']='success';						 
  		$responce['message']='Status Updated';						 

	}else{
		$responce['type']='error';		
  		$responce['message']='Something went wrong plesae try again';						 
	}
	echo json_encode($responce); die;

}elseif(isset($_POST['whatsapp'])){


    if($_POST['whatsapp']==1){

		$row=mysqli_query($con,"update sms_setting set status='1' where sms_id='2'");	


	}elseif($_POST['whatsapp']==0){

		$row=mysqli_query($con,"update sms_setting set status='0' where sms_id='2'");	

	}
	if($row){
  		$responce['type']='success';						 
  		$responce['message']='Status Updated';						 

	}else{
			$responce['type']='error';		
  		$responce['message']='Something went wrong plesae try again';						 
	}
	echo json_encode($responce); die;

}




}