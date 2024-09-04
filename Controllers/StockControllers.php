<?php include('../myfunction.php')?>
<?php

if(isset($_POST['add_stock_type'])){
// echo "<pre>";
// print_r($_POST);

$stock=mysqli_real_escape_string($con,trim($_POST['stock']));

		$sql=mysqli_query($con,"select * from stock_type where stock_type_name='$stock'");

		$res=mysqli_num_rows($sql);

		if($res){

				$responce['status']='error';						 
	            $responce['message']='This Stock Type Is Already Exists ';

		}else{

			$query="insert into stock_type (stock_type_name,create_date,modify_date) values('$stock',now(),now())";	

			if(mysqli_query($con,$query)){
				$responce['status']='success';						 
	            $responce['message']='Stock Type Added Successfully';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}

		}
echo json_encode($responce);
}

if(isset($_POST['update_stock_type'])){
// echo "<pre>";
// print_r($_POST);

$stock=mysqli_real_escape_string($con,trim($_POST['stock']));
$eid=mysqli_real_escape_string($con,trim($_POST['eid']));


		$sql1=mysqli_query($con,"select * from stock_type where stock_type_name='$stock' and stock_type_id!='$eid' ");

		$res1=mysqli_num_rows($sql1);

		if($res1){

			$responce['status']='error';						 
	            $responce['message']='This Stock Type Is Already Exists ';
		}else{	

			$up=mysqli_query($con,"update stock_type set stock_type_name='$stock',modify_date=now() where stock_type_id='$eid'");		
	        if($up){
				$responce['status']='success';						 
	            $responce['message']='Stock Type updated Successfully';

			}else{
				$responce['status']='error';						 
	             $responce['message']='Something went wrong plesae try again ';

			}

		}	
echo json_encode($responce);
}

if(isset($_POST['add_stock_vendor'])){
// echo "<pre>";
// print_r($_POST);
$vendor=mysqli_real_escape_string($con,trim($_POST['vendor']));

		$sql=mysqli_query($con,"select * from stock_vendor where stock_vendor_name='$vendor'");

		$res=mysqli_num_rows($sql);

		if($res)

		{	
			$responce['status']='error';						 
	            $responce['message']='This Vendor Is Already Exists ';
		}

		else{

			$query=mysqli_query($con,"insert into stock_vendor (stock_vendor_name,create_date,modify_date) values('$vendor',now(),now())");	

			 if($query){
				$responce['status']='success';						 
	            $responce['message']=' Vendor Added Successfully';

			}else{
				$responce['status']='error';						 
	             $responce['message']='Something went wrong plesae try again ';

			}
		}
echo json_encode($responce);

}

if(isset($_POST['update_stock_vendor'])){
// echo "<pre>";
// print_r($_POST);

$vendor=mysqli_real_escape_string($con,trim($_POST['vendor']));
$eid=mysqli_real_escape_string($con,trim($_POST['eid']));

		
		$sql1=mysqli_query($con,"select * from stock_vendor where stock_vendor_name='$vendor' and stock_vendor_id!='$eid'");

		$res1=mysqli_num_rows($sql1);

		if($res1)

		{
			$responce['status']='error';						 
	        $responce['message']='This Vendor Is Already Exists ';

		}else{	

		$up=mysqli_query($con,"update stock_vendor set stock_vendor_name='$vendor',modify_date=now() where stock_vendor_id='$eid'");	
		 if($up){
				$responce['status']='success';						 
	            $responce['message']=' Vendor Updated Successfully';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}	
		}	
echo json_encode($responce);
}

if(isset($_POST['create_purchase_order'])){
// 	echo "<pre>";
// print_r($_POST);

$poid=mysqli_real_escape_string($con,$_POST['poid']);
$pur_ord_crt=mysqli_real_escape_string($con,$_POST['pur_ord_crt']);
$stockid=mysqli_real_escape_string($con,$_POST['stockid']);
$purdt=mysqli_real_escape_string($con,$_POST['purdt']);
$identno=mysqli_real_escape_string($con,$_POST['identno']);
$qty=mysqli_real_escape_string($con,$_POST['qty']);
$amt_item=mysqli_real_escape_string($con,trim($_POST['amt_item']));
$disc_item=mysqli_real_escape_string($con,trim($_POST['disc_item']));
$amount=mysqli_real_escape_string($con,trim($_POST['amount']));
$description=mysqli_real_escape_string($con,trim($_POST['description']));
$vendor=mysqli_real_escape_string($con,trim($_POST['vendor']));



	$img = $_FILES['file']['name'];

	

	if($img=="")

	{

	$q1 = mysqli_query($con,"insert into purchase_order (poid,stock_type_id,purchase_date,pur_ord_created,identification_no,

	quantity,amt_per_item,disc_per_item,description,stock_vendor_id,amount,session,create_date,modify_date) 

	values('$poid','$stockid','$purdt','$pur_ord_crt','$identno','$qty','$amt_item','$disc_item','$description','$vendor','$amount','".$_SESSION['session']."',now(),now())");

	}

	else

	{
		$name=explode('.',$img);
		$ext=pathinfo($img,PATHINFO_EXTENSION);
		$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
		$img_name=$image_name;

	$q1 = mysqli_query($con,"insert into purchase_order (poid,stock_type_id,purchase_date,pur_ord_created,identification_no,

	quantity,amt_per_item,disc_per_item,description,stock_vendor_id,amount,image,session,create_date,modify_date) 

	values('$poid','$stockid','$purdt','$pur_ord_crt','$identno','$qty','$amt_item','$disc_item','$description','$vendor','$amount','$img_name','".$_SESSION['session']."',now(),now())");

	move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/purchaseorder/".$img_name);

	}
	if($q1){
				$responce['status']='success';						 
	            $responce['message']='Purchase order created Successfully';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}
echo json_encode($responce);

}
if(isset($_POST['update_purchase_order'])){
// 	echo "<pre>";
// print_r($_POST);


$id=mysqli_real_escape_string($con,$_POST['id']);
$oldimg=mysqli_real_escape_string($con,trim($_POST['oldimg']));
// $poid=mysqli_real_escape_string($con,$_POST['poid']);
$pur_ord_crt=mysqli_real_escape_string($con,$_POST['pur_ord_crt']);
$nstockid=mysqli_real_escape_string($con,$_POST['nstockid']);
$npurdt=mysqli_real_escape_string($con,$_POST['npurdt']);
$nidentno=mysqli_real_escape_string($con,$_POST['nidentno']);
$nqty=mysqli_real_escape_string($con,$_POST['nqty']);
$namt_item=mysqli_real_escape_string($con,trim($_POST['namt_item']));
$ndisc_item=mysqli_real_escape_string($con,trim($_POST['ndisc_item']));
$namount=mysqli_real_escape_string($con,trim($_POST['namount']));
$ndescription=mysqli_real_escape_string($con,trim($_POST['ndescription']));
$nvendor=mysqli_real_escape_string($con,trim($_POST['nvendor']));

	

	$img1 = $_FILES['file1']['name'];

	if($img1==""){

		$up=mysqli_query($con,"update purchase_order set stock_type_id='$nstockid',purchase_date='$npurdt',

		identification_no='$nidentno',quantity='$nqty',amt_per_item='$namt_item',disc_per_item='$ndisc_item',

		description='$ndescription',stock_vendor_id='$nvendor',amount='$namount',modify_date=now() where pur_ord_id ='$id'");

	}else{	

		$name=explode('.',$img1);
		$ext=pathinfo($img1,PATHINFO_EXTENSION);
		$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;

		$up=mysqli_query($con,"update purchase_order set stock_type_id='$nstockid',purchase_date='$npurdt',

		identification_no='$nidentno',quantity='$nqty',amt_per_item='$namt_item',disc_per_item='$ndisc_item',

		description='$ndescription',stock_vendor_id='$nvendor',amount='$namount',image='$image_name',modify_date=now() where pur_ord_id ='$id'");

		// mysqli_query($con,"update purchase_order set image='$image_name',modify_date=now() where pur_ord_id ='$id'");
		if(!empty($oldimg) && file_exists('../gallery/purchaseorder/'.$oldimg)){
			unlink("gallery/purchaseorder/$oldimg");
		}
		move_uploaded_file($_FILES['file1']['tmp_name'],"../gallery/purchaseorder/$image_name");

	}
	if($up){
				$responce['status']='success';						 
	            $responce['message']='Purchase order updated Successfully';

			}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';

			}
echo json_encode($responce);

}	

	



if(isset($_POST['issue_order'])){
// 	echo "<pre>";
// print_r($_POST);

$ioid=mysqli_real_escape_string($con,$_POST['ioid']);
$stockid=mysqli_real_escape_string($con,$_POST['stockid']);
$purordr=mysqli_real_escape_string($con,$_POST['purordr']);
$venid=mysqli_real_escape_string($con,$_POST['venid']);
$issueddate=mysqli_real_escape_string($con,$_POST['issueddate']);
$issueddept=mysqli_real_escape_string($con,$_POST['issueddept']);
$issuedto=mysqli_real_escape_string($con,trim($_POST['issuedto']));
$identno=mysqli_real_escape_string($con,trim($_POST['identno']));
$qty=mysqli_real_escape_string($con,trim($_POST['qty']));
$avilable_qty=mysqli_real_escape_string($con,trim($_POST['avilable_qty']));
$description=mysqli_real_escape_string($con,trim($_POST['description']));
$incharge=mysqli_real_escape_string($con,trim($_POST['incharge']));
$issuedby=mysqli_real_escape_string($con,trim($_POST['issuedby']));
$amount_per_iem=mysqli_real_escape_string($con,trim($_POST['amount_per_iem']));
if(!empty($qty) && !empty($amount_per_iem)){
	$amount=$qty*$amount_per_iem; 
}else{
	$amount=0;
}	
if($qty<1){
	$responce['status']='error';						 
	$responce['message']="This quantity can't accept";

}elseif($qty>$avilable_qty){
 	$responce['status']='error';						 
	$responce['message']="Can't accept max quantity from Avilable quantity";

}else{

	$img = $_FILES['file']['name'];

	$sql1=mysqli_query($con,"select * from issue_order where ioid='$ioid' ");

	$res1=mysqli_num_rows($sql1);

	if($res1)

	{
		$responce['status']='error';						 
	    $responce['message']='This order Is Already Exists ';

	}else{		

		if($img==""){

		$q1 = mysqli_query($con,"insert into issue_order (issue_ord_id,ioid,issued_date,issued_department,issued_to_id,stock_type_id,pur_ord_id,Identification_no,quantity,description,item_incharge,stock_vendor_id,issued_by,session,create_date,modify_date) values('0','$ioid','$issueddate','$issueddept','$issuedto','$stockid','$purordr','$identno','$qty','$description','$incharge','$venid','$issuedby','".$_SESSION['session']."',now(),now())");

			// if(mysqli_error($con)){
			// echo("Error description: " . mysqli_error($con));
			// }
		}else{
				$name=explode('.',$img);
				$ext=pathinfo($img,PATHINFO_EXTENSION);
				$image_name=$name[0].'_'.date("Ymd-His").'.'.$ext;
				$img_name=$image_name;
			 $isql="insert into issue_order (issue_ord_id,ioid,issued_date,issued_department,issued_to_id,stock_type_id,pur_ord_id,Identification_no,quantity,amount,description,item_incharge,stock_vendor_id,issued_by,image,session,create_date,modify_date) values('0','$ioid','$issueddate','$issueddept','$issuedto','$stockid','$purordr','$identno','$qty','$amount','$description','$incharge','$venid','$issuedby','$img_name','".$_SESSION['session']."',now(),now())"; 	
			$q1 = mysqli_query($con,$isql);

			move_uploaded_file($_FILES['file']['tmp_name'],"../gallery/issuedorder/".$img_name);
		}
		    // if(mysqli_error($con)){
			//     echo("Error description: " . mysqli_error($con));
			// }
		    if($q1){
					$responce['status']='success';						 
		            $responce['message']='Issued order Successfully';

				}else{
					$responce['status']='error';						 
		            $responce['message']='Something went wrong plesae try again ';

				}
	}
}			
echo json_encode($responce);

}

if(isset($_POST['return_stock'])){
// 	echo "<pre>";
// print_r($_POST);
$returnid=mysqli_real_escape_string($con,$_POST['returnid']);
$issid=mysqli_real_escape_string($con,$_POST['issid']);
$stockid=mysqli_real_escape_string($con,$_POST['stockid']);
$vendorid=mysqli_real_escape_string($con,$_POST['vendorid']);
$purchaseid=mysqli_real_escape_string($con,$_POST['purchaseid']);
$returnqty=mysqli_real_escape_string($con,$_POST['returnqty']);
$issue_qty=mysqli_real_escape_string($con,$_POST['issue_qty']);
$identno=mysqli_real_escape_string($con,$_POST['identno']);
$returndt=mysqli_real_escape_string($con,$_POST['returndt']);
$returnedby=mysqli_real_escape_string($con,$_POST['returnedby']);
$returnedto=mysqli_real_escape_string($con,$_POST['returnedto']);
$description=mysqli_real_escape_string($con,$_POST['description']);

if($returnqty<1){
	$responce['status']='error';						 
	$responce['message']="This quantity can't accept";

}elseif($returnqty>$issue_qty){
 	$responce['status']='error';						 
	$responce['message']="Can't accept max quantity from Issue quantity";

}else{



	
	$q1 = mysqli_query($con,"insert into return_stock (roid,issue_ord_id,pur_ord_id,stock_type_id,vendor_id,return_qty,identification_no,returned_date,

	returned_by,returned_to,description,create_date,modify_date) 

	values('$returnid','$issid','$purchaseid','$stockid','$vendorid','$returnqty','$identno','$returndt','$returnedby','$returnedto','$description',now(),now())");

	// if(mysqli_error($con)){
	// echo("Error description: " . mysqli_error($con));
	// }
	if($q1){

		$q2 = mysqli_query($con,"select * from issue_order where issue_ord_id='$issid'");

		$r2 = mysqli_fetch_array($q2);

		$oldqty = $r2['quantity'];

		$newqty = $oldqty - $returnqty;

		$q3 = mysqli_query($con,"update issue_order set quantity='$newqty',modify_date=now() where issue_ord_id='$issid'");

		if($q3){
			$responce['status']='success';						 
	            $responce['message']='Return stock Successfully';
	    }else{
	    	$responce['status']='error';						 
	            $responce['message']='Something create issue ';

	    }  

	}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
			}
}			
echo json_encode($responce);			
}

if(isset($_POST['dead_stock'])){
// 	echo "<pre>";
// print_r($_POST);
$deadstockid=mysqli_real_escape_string($con,$_POST['deadstockid']);
$issid=mysqli_real_escape_string($con,$_POST['issid']);
$stockid=mysqli_real_escape_string($con,$_POST['stockid']);
$vendorid=mysqli_real_escape_string($con,$_POST['vendorid']);
$purchaseid=mysqli_real_escape_string($con,$_POST['purchaseid']);
$deadqty=mysqli_real_escape_string($con,$_POST['deadqty']);
$issue_qty=mysqli_real_escape_string($con,$_POST['issue_qty']);
$identno=mysqli_real_escape_string($con,$_POST['identno']);
$returndt=mysqli_real_escape_string($con,$_POST['returndt']);
$returnedby=mysqli_real_escape_string($con,$_POST['returnedby']);
$returnedto=mysqli_real_escape_string($con,$_POST['returnedto']);
$description=mysqli_real_escape_string($con,$_POST['description']);

if($deadqty<1){
	$responce['status']='error';						 
	$responce['message']="This quantity can't accept";

}elseif($deadqty>$issue_qty){
 	$responce['status']='error';						 
	$responce['message']="Can't accept max quantity from Issue quantity";

}else{

	$q1 = $con->query("insert into dead_stock (dsid,issue_ord_id,pur_ord_id,stock_type_id,vendor_id,dead_stock_qty,identification_no,returned_date,

	returned_by,returned_to,description,create_date,modify_date) values('$deadstockid','$issid','$purchaseid','$stockid','$vendorid','$deadqty','$identno','$returndt','$returnedby','$returnedto','$description',now(),now())");
	// if(mysqli_error($con)){
	// echo("Error description: " . mysqli_error($con));
	// }
	if($q1){

		$q2 = mysqli_query($con,"select * from issue_order where issue_ord_id='$issid'");

		$r2 = mysqli_fetch_array($q2);

		$oldqty = $r2['quantity'];

		$newqty = $oldqty - $deadqty;

		$q3 = mysqli_query($con,"update issue_order set quantity='$newqty',modify_date=now() where issue_ord_id='$issid'");

		if($q3){
			$responce['status']='success';						 
	            $responce['message']='Dead stock Successfully';
	    }else{
	    	$responce['status']='error';						 
	            $responce['message']='Something create issue ';

	    }        
			
	}else{
				$responce['status']='error';						 
	            $responce['message']='Something went wrong plesae try again ';
	}
}	
echo json_encode($responce);

}
