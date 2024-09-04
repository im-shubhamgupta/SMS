<?php

//error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{

    $branch = $_POST['branch'];

   

	if($branch!="")

	{

    // search in all table columns



		$query="select * from books where branch_id='$branch'";

		$search_result = filterTable($query);

    }

}



// function to connect and execute the query

function filterTable($query)

{

    include('connection.php');

	$filter_Result = mysqli_query($con, $query);

    return $filter_Result;

}







?>

<style>



/* Media Query  */

@media only screen and (max-width: 600px)

{

	.col-md-3{

		width:400px;

		

	}

	

}



</style>





<div id="right-panel" class=" right-panel">

<nav class="breadcrumb">

<a class="breadcrumb-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>

  <a class="breadcrumb-item" href="#">Library Management</a>

  <span class="breadcrumb-item active">Book Available Detail</span>

</nav>



	<form method="post" action="dashboard.php?option=book_available_detail" enctype="multipart/form-data">

        

		<h5>Available Book Detail</h5>

		<br>

		

        <div class="content mt-3" style="width:1000px;">

            <div class="animated fadeIn">

                <div class="row">



                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                               

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-4" style="margin-left:30px;">Branch</div>

								<div class="col-md-6" style="margin-left:20px;">

								<select name="branch" class="form-control" style="width:180px;" autofocus required>

								<option value="" selected="selected" disabled >Select Branch</option>

								<?php

								$sbr = mysqli_query($con,"select * from branch");

								while( $rbr = mysqli_fetch_array($sbr) ) {

								?>

								<option <?php if($branch==$rbr['branch_id']){echo "selected";}?> value="<?php echo $rbr['branch_id']; ?>"><?php echo $rbr['branch_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								</div>

								

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-12" style="margin-left:40px;">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

								</div>

								</div>

							</div><br>

														

                            </div>

							

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive" >

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Book Name</th>

											 <th>Publisher Name</th>

											 <th>Total No. of Books </th>

											 <th>Issued Book</th>

											 <th>Returned Book</th>

											 <th>Available Book</th>

											

										</tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;
									if(isset($search_result) && mysqli_num_rows($search_result)>0){

									while($res1=mysqli_fetch_array($search_result))

									{

										$bkid=$res1['book_id'];

										$bkname=$res1['book_name'];

										$pubid=$res1['publisher_id'];

										$tbkqty=$res1['quantity'];

									

										$q=mysqli_query($con,"select * from publisher where publisher_id='$pubid'");

										$r=mysqli_fetch_array($q);

										$pubname=$r['publisher_name'];

										

										$q2=mysqli_query($con,"select * from issue_bookto_students where book_id ='$bkid'");

										$stuissueqty=mysqli_num_rows($q2);

										$q3=mysqli_query($con,"select * from issue_bookto_faculty where book_id ='$bkid'");

										$facissueqty=mysqli_num_rows($q3);	



										$q4=mysqli_query($con,"select * from issue_bookto_students where book_id ='$bkid' && return_status='1'");

										$stureturnqty=mysqli_num_rows($q4);

										$q5=mysqli_query($con,"select * from issue_bookto_faculty where book_id ='$bkid' && return_status='1'");

										$facreturnqty=mysqli_num_rows($q5);	

										

										$total_book_issue=$stuissueqty+$facissueqty;

										$total_book_return=$stureturnqty+$facreturnqty;

										$balbook=$tbkqty-$total_book_issue+$total_book_return;

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $bkname; ?></td>

										<td><?php echo $pubname; ?></td>

										<td><?php echo $tbkqty; ?></td>

										<td><?php echo $total_book_issue; ?></td>

										<td><?php echo $total_book_return; ?></td>

										<td><?php echo $balbook; ?></td>

										

									</tr>

                                    <?php $sr++; } }?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- .animated -->

        </div><!-- .content -->

				

		<div style="text-align:center">

		

		<a href="export_available_book_excel.php?branchid=<?php echo $branch;?>&fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>" class="btn btn-success btn-sm"> <i class="fa fa-download"></i> Download To Excel</a>

		

		</div>

		

		

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>