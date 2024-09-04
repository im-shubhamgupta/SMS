
<div class="col-lg-6">
                    <div class="card" style="width:1000px;"> 
                        <div class="card-body">
                            <table class="table">
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col">Institute Name</th>
								  <th scope="col">Address</th>
                                  <th scope="col">Email Id</th>
								  <th scope="col">Contact</th>
								  <th scope="col">Logo</th> 
								  <th scope="col">Action</th>
								</tr>
                              </thead>
								
								<?php 
								$i=1;
								$query=mysqli_query($con,"select * from setting");
								while($res=mysqli_fetch_array($query))
								{
								$id=$res['company_id'];
								$image=$res['company_image'];
								?>
							  
                              <tbody>
                                <tr>
                                  <td><b><?php echo $res['company_name']; ?></b></td>
								  <td><b><?php  echo $res['company_address']; ?></b></td>
                                  <td><b><?php  echo $res['company_email']; ?></b></td>
								  <td><b><?php  echo $res['company_number']; ?></b></td>
								  
								 <td><img src="images/profile/<?php echo $image; ?>" width='50px' height='50px' style="border-radius:50%"/></td>
								
							<td style="width:100px;">
							<?php echo "<a href='dashboard.php?option=update_profile&cid=$id'><img src='images/update.png' height='30px' width='30px'/></a> " ; ?>
							</td>
							</tr>
							<?php $i++; } ?>
							</tbody>
                            </table>
                        </div>
                    </div>	
                </div>