<?php 

include('connection.php');

extract($_REQUEST);?>


<div id="right-panel"  style="width:100%">

    

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Stock Management</a>

  <a class="breadcrumb-item" href="#">Purchase Order</a>

  <span class="breadcrumb-item active"> Import Purchase Order</span>

</nav>

<?php
if (isset($_POST['upload'])) 

{

$csvfile = $_FILES['csvfile']['name'];

$ext = pathinfo($csvfile, PATHINFO_EXTENSION);

$base_name = pathinfo($csvfile, PATHINFO_BASENAME);



if(!$_FILES['csvfile']['name'] == "")   

{ 

if($ext == "csv")

{

 

 if(file_exists($base_name))

{

      echo "file already exist" . $base_name;

                                                  

}else{

	    

if (is_uploaded_file($_FILES['csvfile']['tmp_name'])){
	// echo "<h1>" . "File ". $_FILES['csvfile']['name'] ." uploaded successfully." . "</h1>";

 

	// readfile($_FILES['csvfile']['tmp_name']);

}

          $handle = fopen($_FILES['csvfile']['tmp_name'], "r");
          fgetcsv($handle, 1000, ",");
		  $headerLine = true;

		$count=0;
			// $already=array();
			$not_upload=array();
			$success_upload=array();
			$error=0;
			$false_query=0;		

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 

{	

	

	$que = mysqli_query($con,"select * from purchase_order order by poid desc limit 1");

	$row = mysqli_num_rows($que);

	if($row)

	{

		$r2 = mysqli_fetch_array($que);

		$pid = $r2['poid'];

		$npid = preg_split('#(?=\d)(?<=[a-z])#i', "$pid");

		$npoid = $npid[1]; 

		$pid++;

		$newpoid = $pid++;

	}

	else

	{

		$newpoid  = "PO1";

	}



	$sr_no=mysqli_real_escape_string($con,trim($data[0]));
	$stocktype=mysqli_real_escape_string($con,$data[1]);
	if(!empty($stocktype)){
			$stocktype=strtoupper($stocktype);
			$q1=mysqli_query($con,"select * from stock_type where upper(stock_type_name)='$stocktype'");

			$r1=mysqli_fetch_array($q1);

			$stockid=$r1['stock_type_id'];
	}else{
			$stockid='';
	}
	
	

	$purdt=mysqli_real_escape_string($con,trim($data[2]));
	if(!empty($purdt)){
		$npurdt =date("Y-m-d", strtotime(str_replace('/','-',$purdt)));
	}else{
		$npurdt='';
	}
	
	$identification_no=mysqli_real_escape_string($con,$data[3]);	
	$quantity=mysqli_real_escape_string($con,$data[4]);	
	$amt_per_item=mysqli_real_escape_string($con,$data[5]);	
	$disc_per_item=mysqli_real_escape_string($con,$data[6]);	
	$amount=mysqli_real_escape_string($con,$data[7]);	
	$description=mysqli_real_escape_string($con,$data[8]);	

	$pur_ord_crt = date('Y-m-d h:i');

	

	$stock_vendor=mysqli_real_escape_string($con,trim($data[9]));
	if(!empty($stock_vendor)){
		$stock_vendor=strtoupper($stock_vendor);
		$q2=mysqli_query($con,"select * from stock_vendor where upper(stock_vendor_name)='$stock_vendor'");

		$r2=mysqli_fetch_array($q2);

		$stock_vendorid=$r2['stock_vendor_id'];
	}else{
		$stock_vendorid='';
	}
	

	// if($headerLine) { $headerLine = false; }
	// echo '<br>new: '.$npurdt;
	if(empty($newpoid)  || empty($stockid)  || empty($npurdt) || $npurdt=='1970-01-01' || empty($stock_vendorid)){
		$not_upload[]=$sr_no;
		$error+=1;


	}else{
		// echo 'hello12';
		$import=mysqli_query($con,"insert into purchase_order (poid,stock_type_id,purchase_date,pur_ord_created,identification_no,
			quantity,amt_per_item,disc_per_item,amount,description,stock_vendor_id,session,create_date,modify_date) 
			values('$newpoid','$stockid','$npurdt','$pur_ord_crt','$identification_no','$quantity','$amt_per_item','$disc_per_item','$amount','$description','$stock_vendorid','".$_SESSION['session']."',now(),now())");
		if($import){
			$success_upload[]=$sr_no;
							$count+=1;

		}else{
			$false_query+=1;
						$not_upload[]=$sr_no;
		}

							

	}

}//while
	foreach($not_upload as $k => $v){
		 if(empty($v)){
		  unset($not_upload[$k]);
		  }
		}
	$err_regisno=implode(', ', $not_upload);

	if(!empty($err_regisno)){
		echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Purchase order uploaded successfully. This Sr no. not uploaded ('.$err_regisno.') please check the given data. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
		
	}elseif($count > 0){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   		<h4>('.$count.') Purchase order uploaded successfully. </h4>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>';
		
	}
					



}

 

}else

{

echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>File Extension should be .csv, your file extension is .'.$ext.'</h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';

	   

}

 

}  

 

else

 {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			   		<h4>Please Upload File </h4>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>';

 }

}

?>





        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title"><a href="csv/upload_purchase_order.csv" class="btn btn-primary btn-sm">

								<i class="fa fa-download"></i> Download Format</a><br/><br/></strong>

                            </div>

                            <div class="card-body">

                                <form method="post" enctype="multipart/form-data">

<div class="row">

	<div class="col-md-12">

		<div class="panel-group">

			<div class="panel panel-default">

				

			<?php echo @$err; ?>



		<div class="row">

			<div class="col-md-12">

				<div class="panel-body">

				<label>Upload Purchase Order</label>

<input class="form-control" type="file" required name="csvfile">

			

				</div>

			</div>

		</div><br>

			

			<div>

			

			</div>

			

			

		</div> <!-- End of section 1 row-->

			

		</div>

												</div>

											</div>

										</div>	



					<div class="card-footer">

					<button type="submit" value="Upload" class="btn btn-info btn-sm" name="upload">

					<i class="fa fa-upload"></i> Upload

					</button>

					</div>

		

									</section>			

								</form>		

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

