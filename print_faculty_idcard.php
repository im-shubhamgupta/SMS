<!DOCTYPE html> 
<?php
error_reporting(1);
extract($_REQUEST);
include('connection.php');
$uid = $_REQUEST['uid'];

?>

<html> 
<head> 
	<title>Card</title> 
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script type='text/javascript'>window.print();</script>

<style>

 @media print {
	
	.card{
		width:29rem!important;
		margin-top:100px;
		margin-bottom:100px;
		
		
	} 
	
	div   { page-break-inside:avoid; }
	
	h6{
		font-size:19px!important;
	}
	
	.add{
		font-size:12px!important;
	}
 }

</style>


</head> 
<body>

<?php
$qset = mysqli_query($con,"select * from setting");
$rset = mysqli_fetch_array($qset);
$sclname = $rset['company_name'];
$scllogo = $rset['company_image'];
$scladd = $rset['company_address'];
$sclmob = $rset['company_number'];
$sclemail = $rset['company_email'];

$userarr = explode(',',$uid);
foreach($userarr as $val)
{
	$quser = mysqli_query($con,"select * from users where user_id='$val'");
	$ruser= mysqli_fetch_array($quser);
	$userpic = $ruser['profile_image'];
	
	$username = $ruser['username'];
	$roles = $ruser['roles'];
	$phone = $ruser['phone'];
	$email = $ruser['email'];
	
	
?>

<div class="container">
    <div class="row py-3 pl-3 d-flex" style="float:left;margin-top:20px;">
	<div class="col-md-10">
	<div class="row">
        <div class="col-10 col-md-10 col-lg-10">
            <div class="card" style="width:32rem;border-radius:10px; border:3px solid #95C750; border-top:15px solid #95C750;">
			<div class="top_head mt-2 pb-2 " style="border-bottom:2px solid #000;">
			<div class="row">
			<div class="col-md-3 col-3">
			<img src="images/profile/<?php echo $scllogo;?>" class="img-fluid logo text-center ml-3" style="width:100px;height:70px">
             </div>	
			<div class="col-md-9 col-9">			 
			<h6 class="text-center text-dark font-weight-bold" style="font-size:20px;" ><?php echo $sclname;?></h6>
			<p class="text-center pl-4 font-weight-bold add" style="font-size:13px; "><?php echo $scladd;?> <span class="pl-3"> Phone: 079 26826799</span></p>
				     
			</div>	
			</div>
			</div>
			
			<div class="card-body">
			<div class="row">
						
			<div class="col-3 col-lg-3 col-md-3" style="width:100px;height:100px">
				<img src="images/admin/<?php echo $userpic;?>" alt="" class="img-fluid" style="width:100px;height:100px">
			</div>
							
			<div class="col-9 col-lg-9 col-md-9">
			<table class="table-sm">
			  <tbody>
				<tr>
				  <td>Name :</td>
				  <td><?php echo $username; ?></td>
				</tr>
				<tr>
				  <td>Designation :</td>
				  <td><?php echo $roles; ?></td>
				</tr>
				<tr>
				  <td>Mobile :</td>
				  <td><?php echo $phone; ?></td>
				</tr>
			  </tbody>
			</table>                      
			</div>
							
			<div class="col-12 col-lg-12 col-md-12">
			<table class="table-sm">
			  <tbody>
				<tr>
				  <td>Email :</td>
				  <td><?php echo $email; ?></td>
				</tr>
				<tr>
				  <td>Valid-through :</td>
				  <td>Mar 2021</td>
				</tr>
			  </tbody>
			</table>
			</div>
			
			<?php
				$q1 = mysqli_query($con,"select * from upload_sign where sign_id='1'");
				$r1 = mysqli_fetch_array($q1);
				$designation = $r1['designation'];
				$signature = $r1['signature'];
			?>
			<div class="col-sm-12" style="margin-top:10px;">
			<div class="row" style="margin-left:10px;">
			<div class="col-sm-6">
			<img src="images/signature/<?php echo $signature;?>" alt="" class="img-fluid m-auto" style="width:100px;height:50px">
			<p><?php echo $designation; ?></p> 
			</div>
			</div>
			</div>
						
			<br/>
			<br/>
			<br/>
			<!--/col-->
			</div>
			<!--/row-->
			</div>
			<!--/card-block-->
			</div>
        </div>
	</div>
	</div>
	</div>

</div>

</body> 

<?php
}
?>

</html>