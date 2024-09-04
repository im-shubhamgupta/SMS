<?php

require('fpdf/fpdf.php');

include('connection.php');

extract($_REQUEST);



$lastid = $_REQUEST['id'];

$q1 = mysqli_query($con,"select * from certificate_download where id='$lastid'");

$r1 = mysqli_fetch_array($q1);

if(!empty($r1['cert_name'])){
$image = $r1['cert_name'];
$filename = basename($image,".jpg");
}else{
    $image ='';
    $filename ='';
}






$pdf=new FPDF('P','mm','A4');

$pdf->AddPage();

if(!empty($image) && file_exists("pic/certificates/".$image)){
$pdf->Image('pic/certificates/'.$image,0,0,210,150);
$pdf->Output('pic/certificates/'.$filename.'.pdf','F');
}



?>





<style>

.spanname

{

font-size:12px;

font-weight:bold;

text-align: center;

}



</style>





<form method="post">

<!-- breadcrumb-->

<nav class="breadcrumb">

  <a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Certificate Panel</a>

  <a class="breadcrumb-item" href="dashboard.php?option=create_cert1">Create Certificate</a>

  <span class="breadcrumb-item active">Download Certificate</span>

</nav>

<!-- breadcrumb -->

<div id="right-panel" class="right-panel">

		

        <div class="content mt-3" style="width:1000px">

            <div class="animated fadeIn">

                <div class="row">

					<div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">Download Certificate</strong>

                            </div>

                            <div class="card-body">

                                <div class="row">

								<div class="col-sm-12">

								<img src="<?php echo 'pic/certificates/'.$image;?>" width="850px" height="500px" style="margin:25px;"/>

								</div>

								</div>

                            </div>

							

							<div class="card-footer">

							<a href="cert_pdf.php?id=<?php echo $lastid;?>" class="btn btn-success btn-sm">

								 Download</a>

							</div>

														

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

    </div><!-- /#right-panel -->

	</form>

 <?php include('bootstrap_datatable_javascript_library.php'); ?>