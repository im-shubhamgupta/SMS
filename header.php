<?php

error_reporting(1);

include('connection.php');

$queset=mysqli_query($con,"select * from setting where company_id='1'");

$resset=mysqli_fetch_array($queset);

$companyname=$resset['company_name'];

$fontstyle = $resset['font_style'];

?>


<!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<style type="text/css">

@media print{

   .noprint{

       display:none;

   }
}
#notify_id {
    color: white;
    background-color: red;
    padding: 3px;
/*    border-radius: 50%;*/
    font-size: 14px;
}


</style>

<!-- Header-->
<?php 
        $Wleft=get_whatsapp_sms_count()['count_sms'];
        $Tleft=get_text_sms_count()['count_sms'];
?>

        <header id="header" class="header noprint">

			<div class="row">

				<div class="col-sm-12">

				<marquee width="100%" direction="left" behavior="alternate" ><span style="font-size:38px;font-weight:bold;color:#1F7A8C;font-family:<?php echo $fontstyle?>;"><?php echo $companyname;?></span>

				</marquee>

				</div>

			</div>

			<div class="row">
				<div class="col-md-4">

					<h6 style='top:0;width:auto;'><span style="font-size:18px;color:green;font-weight:bold;top:0;">Academic Year : <?=getSessionByid($_SESSION['session'])['year']?>  </span></h6>

				</div>
				<div class="col-md-4">
					<?php 
					  $Squery2=mysqli_query($con,"select * from sms_setting where sms_id='2' ");
					  $Sres2=mysqli_fetch_array($Squery2);?>
					    <div style="" >
				              	<?php  if($Sres2['work_status']=='0'){
				              			echo "<h6 style='top:0;width:auto;'><span style='color:red;'> ( Instance Id Expired )</span></h6>";

				              		  }else{
				              		  	// echo "<span style='color:green;'> Sms Working </span";
				              		  }
				              	?>
				        </div>
				</div>	
				
				<div class="col-md-4">

				<div class="user-area dropdown float-right">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

						<span  class="message media-body" style="font-size:18px;color:green;font-weight:bold">Welcome Back : &nbsp;&nbsp;</span>

						<span 

						class="message media-body"  style="margin-left:-10px;font-size:18px;color:grey;"> <?php echo $res['username'];?></span>
						
						<!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->

                            <img class="user-avatar rounded-circle" src="images/admin/<?php echo $res['profile_image']; ?>">
                            <?php
                      
                            $i=1;
                            if($Wleft<500 && $Tleft>=500){
                            	echo '<sup><span class=" rounded-circle"  id="notify_id">'.$i.'</span></sup>';
                            }elseif($Tleft<500 && $Wleft>=500){
                            	echo '<sup><span class=" rounded-circle"  id="notify_id">'.$i.'</span></sup>';
                            }elseif(($Wleft<500) && ($Tleft<500) ){

                            	echo '<sup><span class=" rounded-circle"  id="notify_id"> 2 </span></sup>';

                            }
                         
                            

                            ?>

                        </a>



                        <div class="user-menu dropdown-menu">

                        <!--  <a class="nav-link" href="dashboard.php?option=update_admin"><i class="fa fa-user"></i> My Profile</a>
                        	// echo '<i class="fa fa-sms"></i>';
                            	// <i class="fa-solid fa-message-sms"></i>

							-->                        
							  <?php
                        
                            $i=1;
                            if($Wleft<500){
                            	echo '<a class="nav-link" href="dashboard.php?option=view_sms_wallet&smid=10" title="Remaining whatsapp sms"><i class="fa fa-whatsapp"></i> Whatsapp  : <b style="color:red;">  '.$Wleft.'</b></a>';

                            }
                            if($Tleft<500){
                            	echo '<a class="nav-link" href="dashboard.php?option=view_sms_wallet&smid=10" title="Remaining text sms"><i class="fa fa-envelope"></i> Text SMS : <b style="color:red;">  '.$Tleft.'</b></a>';

                            	 // far fa-comment-dots
                            }
                            




                            ?>
                            
                            <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>

                        </div>

                    </div>

				</div>

			</div>

		

		

		

		

            <!--<div class="header-menu" style="border:1px solid yellow;height:10px">



                <div class="col-sm-7">

                    hvjhgjkk

                </div>

				

                <div class="col-sm-5"><span style="margin-left:-440px;font-size:38px;font-weight:bold;color:grey;font-family:'lobster', cursive;"><?php echo $companyname;?></span>

                    <div class="user-area dropdown float-right">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

						<span  class="message media-body" style="font-size:18px;color:green;font-weight:bold">Welcome Back : &nbsp;&nbsp;</span>

						<span 

						class="message media-body"  style="margin-left:-10px;font-size:18px;color:grey;"> <?php echo $res['username'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <img class="user-avatar rounded-circle" src="images/admin/<?php echo $res['profile_image']; ?>" alt="Admin">

                        </a>



                        <div class="user-menu dropdown-menu">

                           <!-- <a class="nav-link" href="dashboard.php?option=update_admin"><i class="fa fa-user"></i> My Profile</a>

							-->

                        

						<!-- <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>

                        </div>

                    </div>



                </div>

            </div>-->



        </header><!-- /header -->

        <!-- Header-->

