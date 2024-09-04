<?php

error_reporting(1);

extract($_REQUEST);



if(isset($_POST['search']))

{

    $branch = $_POST['branch'];

	$book = $_POST['book'];

    $fromdt = $_POST['frmdt'];

    $todt = $_POST['todt'];

	

	if($branch!="" and $book=="All" and $fromdt!="" and $todt!=="")

	{

    // search in all table columns



		$query = "SELECT * FROM `issue_bookto_faculty` WHERE `branch_id`='$branch' and return_status='1' and issue_date between '$fromdt' AND '$todt'";

		$search_result = filterTable($query);

    }

	else if($branch!="" and $book!="All" and $fromdt!="" and $todt!=="")

	{

    // search in all table columns



		$query = "SELECT * FROM `issue_bookto_faculty` WHERE `branch_id`='$branch' and return_status='1' and book_id='$book' and issue_date between '$fromdt' AND '$todt'";

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

  <a class="breadcrumb-item" href="#">Faculty Report</a>

  <span class="breadcrumb-item active">Returned Book Detail</span>

</nav>



	<form method="post" action="dashboard.php?option=returnedbook_faculty_detail" enctype="multipart/form-data">

        

		<h5>Returned Book Detail</h5>

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

								<select name="branch" class="form-control" style="width:180px;" onchange="showbook(this.value)" 

								autofocus required>

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

								

								<script>

								function showbook(str)

								{

								var xmlhttp= new XMLHttpRequest();	

								xmlhttp.open("get","search_ajax_book.php?br_id="+str,true);

								xmlhttp.send();

								xmlhttp.onreadystatechange=function()

								{

								if(xmlhttp.status==200  && xmlhttp.readyState==4)

								{

								document.getElementById("book").innerHTML=xmlhttp.responseText;

								}

								} 

								}

								</script>

								

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-3" style="margin-left:40px;">Book Name</div>

								<div class="col-md-6" style="margin-left:20px;">

								<select name="book" id="book" class="form-control" style="width:180px;" autofocus required>

								<option value="All" selected="selected">All</option>

								<?php

								$sbk = mysqli_query($con,"select * from books where branch_id='$branch'");

								while( $rbk = mysqli_fetch_array($sbk) ) {

								?>

								<option <?php if($book==$rbk['book_id']){echo "selected";}?> value="<?php echo $rbk['book_id']; ?>"><?php echo $rbk['book_name']; ?>

								</option>

								<?php } ?>							

								</select>

								</div>

								</div>

								</div>

							</div><br>

							

							<div class="row" style="margin-top:20px;">

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-4" style="margin-left:30px;">From Date</div>

								<div class="col-md-6" style="margin-left:20px;">

								<input type="date" name="frmdt" value="<?php echo $frmdt;?>" class="form-control" style="width:180px;" autofocus required>

								</div>

								</div>

								</div>

								

								<div class="col-md-5">

								<div class="row">

								<div class="col-md-3" style="margin-left:40px;">To Date</div>

								<div class="col-md-6" style="margin-left:20px;">

								<input type="date" name="todt" value="<?php echo $todt;?>" class="form-control" style="width:180px;" autofocus required>

								</div>

								</div>

								</div>

								

								

								<div class="col-md-2">

								<div class="row">

								<div class="col-md-12">

								<input type="submit" name="search" class="btn btn-primary btn-sm" value="Submit"><br><br>

								</div>

								</div>

								</div>

							   							

							</div>

                            </div>

							

                            <div class="card-body">

                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">

                                    <thead>

                                        <tr>

                                             <th>Sr. No</th>

											 <th>Faculty Name</th>

											 <th>Faculty ID</th>

											 <th>Faculty No</th>

											 <th>Book Name</th>

											 <th>Book Author</th>

											 <th>Book ISBN</th>

											 <th>Publisher Name</th>

											 <th>Issued Date</th>

											 <th>Return Date</th>

											 <th>Returned Date</th>

										</tr>

                                    </thead>

                                    <tbody>

									<?php 

									$sr=1;
											if(isset($search_result) && mysqli_num_rows($search_result)>0){
									while($res=mysqli_fetch_array($search_result))

									{

										$stid=$res['st_id'];

										$q1=mysqli_query($con,"select * from staff where st_id='$stid'");

										$r1=mysqli_fetch_array($q1);

										$stname=$r1['staff_name'];

										$staffid=$r1['staff_id'];

										$mobno=$r1['mobno'];

										

										$bkid=$res['book_id'];

										$q2=mysqli_query($con,"select * from books where book_id='$bkid'");

										$r2=mysqli_fetch_array($q2);

										$bkname=$r2['book_name'];

										$author=$r2['author'];

										$bkisbn=$r2['book_isbn'];

										$pubid=$r2['publisher_id'];

										$q=mysqli_query($con,"select * from publisher where publisher_id='$pubid'");

										$r=mysqli_fetch_array($q);

										$pubname=$r['publisher_name'];

										

										$issdt=$res['issue_date'];

										$issuedt=date("d-m-Y", strtotime($issdt));

										$retdt = $res['return_date'];

										$returndt=date("d-m-Y", strtotime($retdt));

										$retddt = $res['returned_date'];

										$returneddt=date("d-m-Y", strtotime($retddt));

									?>

									<tr>

										<td><?php echo $sr; ?></td>

										<td><?php echo $stname; ?></td>

										<td><?php echo $staffid;?></td>								

										<td><?php echo $mobno;?></td>								

										<td><?php echo $bkname;?></td>								

										<td><?php echo $author;?></td>								

										<td><?php echo $bkisbn;?></td>

										<td><?php echo $pubname;?></td>										

										<td><?php echo $issuedt;?></td>								

										<td><?php echo $returndt;?></td>								

										<td><?php echo $returneddt;?></td>								

										

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

		

		<a href="export_returnedbook_faculty_excel.php?branchid=<?php echo $branch;?>&bookid=<?php echo $book;?>&fromdt=<?php echo $fromdt;?>&todt=<?php echo $todt;?>" class="btn btn-success btn-sm" style="margin-left:20px;"> <i class="fa fa-download"></i> Download To Excel</a>

		

		</div>

		

		

	</form>

</div><!-- /#right-panel -->

 <?php include('bootstrap_datatable_javascript_library.php'); ?>