<?php

include('myfunction.php');
if (isset($_GET['view_students_export_excel'])) {


  // $class = !empty($_REQUEST['class']) ? " and sr.class_id='" . $_REQUEST['class'] . "' " : '';
  $class = '';

  $section = '';
  // $section = !empty($_REQUEST['section']) ? " and sr.section_id='" . $_REQUEST['section'] . "' " : '';

  $users_qry = "select `student_id`,`admission_no`,`stuaddress`,`dob`,admission_date,`register_no`,`student_name`,`token_id`,`gender`,`due`,`student_contact`,`aadhar_card`,`parent_no`,`msg_type_id`,`father_name`,`mother_name`,`soc_cat_id`,`mother_tongue`,`sr`.`class_id`,`sr`.`section_id`,`sr`.`roll_no` from students as s join student_records as sr ON s.student_id=sr.stu_id  where   s.stu_status='0' $class $section && sr.session='" . $_SESSION['session'] . "' order by sr.class_id,sr.roll_no ";
  $users_result = mysqli_query($con, $users_qry);

  if (mysqli_num_rows($users_result) > 0) {

    // #stu_table table, th,td {border:1px solid #454545;   		}
    // div {border:1px solid black}

    $html = "
<html>
   <head>
   <meta http-equiv=\”Content-Type\” content=\”text/html; charset=utf-8\” />
      <style> 
       
       table {border-collapse:collapse;}
       table{ border:1px solid black; }
       th{height:20px;
       }

       </style>
   </head>";

    #73bcca
    $html .= " <table border=0 style='background-color:#79bdca;' >
        <tr>
          <th colspan=7 >Registration Number : " . get_school_details()['registration_number'] . "</th>
          <th colspan=8 >Affiliation No. / UDISE Code : " . get_school_details()['affiliation_number'] . "</th>
        </tr>
                        
                  <tr>
                      <td colspan=15  style='text-align:center;font-size:30px;'><b>" . get_school_details()['company_name'] . "</b></td>
                  </tr>
                  <tr>
                      <td colspan=15 ><center>" . get_school_details()['company_address'] . "</center></td>
                  </tr>
                  <tr>
                      
                      <td colspan=15 ><span>Session :  " . getSessionByid($_SESSION['session'])['year'] . " <center>" . get_school_details()['company_email'] . "</center><span></td>
                  </tr>
             
            </table>             
 ";
    $html .= "<div>
            <table id='stu_table' border=1 class='table table-striped table-bordered table-hover'>
              <thead  > 
                <tr>
                                  
                    <th>Grade/Class </th>	 
                    <th>SECTION</th>	 
                    <th>Roll no</th>	 
                    <th>Name of Student</th>
                    <th>Gender</th>	 
                    <th>DOB (DD-MM-YYYY)</th>	 
                    <th>MOTHER NAME</th>	 
                    <th>FATHER NAME</th>	 
                    <th>GUARDIAN NAME <span style='color:red'>(optional)</span></th>	
                    <th>Aadhar No of Child</th> 
                    <th>STUDENT NAME AS PER AADHAR</th>
                    <th>PRESENT ADDRESS</th>
                    <th>PINCODE</th>
                    <th>MOBILE NUMBER (of Student/Parent/Gardian)</th>
                    <th>ALTERNAME MOBILE NUMBER </th>
                    <th>EMAIL ID(Student/Parent) <span style='color:red;'>(optional)</span></th>
                    <th>MOTHER TONGUE</th>
                    <th>SOCIAL CATEGORY</th>
                    <th>MINORITY GROUP</th>
                    <th>Is BPL BANEFICIARY ?<span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>Whether Antyodaya Anna Yojana (AAY) beneficiary ? <span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>BELONGS TO EWS/DISADVANTAGED GROUP ?<span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>IS CWSN ? <span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>CWSN IMPAIRMENT TYPE <span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>CHILD IS INDIAN NATIONAL ? <span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>CHILD IS OUT-OF-SCHOOL-CHILD ? <span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>When the child is mainstreamed ? <span style='color:red;'> (Yes-1, No-2)</span></th>
                    <th>Admission Number</th>
                    <th>Admission Date (DD-MM-YYYY) </th>
                    <th>STUDENT STREAM (For higher secondary only)</th>
                    <th>PREVIOUS ACADEMIC YEAR SCHOOLING STATUS </th>
                    <th>CLASS STUDIES IN  PREVIOUS ACADEMIC YEAR </th>
                    <th>ADMITED/ENROLLED UNDER RTE/EWS ? <span style='color:red;'>(for private unaided only)</span> </th>
                    <th>APPEARED FOR EXAM IN PREVIOUS CLASS <span style='color:red;'>(1-Appeared, 2- Not Appeared)</span> </th>
                    <th>RESULT FOR PREVIOUS EXAM </th>
                    <th>MARKS % OF PREVIOUS EXAM</th>
                    <th>CLASS ATTENDED DAYS (Previous Year) </th>
                    <th>Facility Received Free Uniform <span style='color:red;'> (Previous Year) </span></th>
                    <th>Facility Received Free TextBook <span style='color:red;'> (Yes-1, No-2) </span></th>
                    <th>Received Central Scholarship <span style='color:red;'> (Yes-1, No-2) </span></th>
                    <th>Name of Central Scholarship (provide code only) <span style='color:red;'> (Yes-1, No-2) </span></th>
                    <th>Received State Scholarship  <span style='color:red;'> (Yes-1, No-2) </span></th>
                    <th>Received  Other Scholarship   <span style='color:red;'> (Yes-1, No-2) </span></th>
                    <th>Scholarship Amount  </th>
                    <th>Facility provided to the CWSN </th>
                    <th>Specific Learning Disability (SLD)  <span style='color:red;'>(Yes-1, No-2)</th>
                    <th>Type of Specific Learning Disability (SLD) </th>
                    <th>Autism Spectrum Disorder <span style='color:red;'>(Yes-1, No-2)</span></th>
                    <th>Attention Deficit Hyperactive Disorder (ADHD)<span style='color:red;'>(Yes-1, No-2)</span></th>
                    <th>Involved in extra curricular activity ?<span style='color:red;'>(Yes-1, No-2)</span></th>
                    <th>Vocational Courses <span style='color:red;'>(Yes-1, No-2)</span></th>
                    <th>Trade/Sector ID </th>
                    <th>Job Role ID   </th>
                    <th>Appeared for Examination in Previous Class for Vocational Subject  </th>
                
				  	 
                 
                </tr>
              </thead>
              <tbody>";

    $i = 1;
    foreach ($users_result as $s)
    // while ($s = mysqli_fetch_assoc($users_result))
    {
      
      $admission = str_pad(intval($s['admission_no']), 4, "0", STR_PAD_LEFT);
      $roll_no = !empty($s['roll_no']) ? $s['roll_no'] : '0';
      $html .= "<tr>
                        <td>" . get_class_byid($s['class_id'])['class_name'] . "</td>
                        <td>" . get_section_byid($s['section_id'])['section_name'] . "</td>
                        <td>" . $roll_no . "</td>
                        <td>" . $s['student_name'] . "</td>
                        <td>" . $s['gender'] . "</td>
                        <td>" . date('d-m-Y',strtotime($s['dob'])) . "</td>
                        
                        <td>" . $s['mother_name'] . "</td>
                        <td>" . $s['father_name'] . "</td>
                        <td></td>
                        <td>" . $s['aadhar_card'] . "</td>
                        <td></td>
                        <td>" . $s['stuaddress'] . "</td>
                        <td></td>
                        <td>" . $s['parent_no'] . "</td>
                        <td>" . $s['student_contact'] . "</td>
                        <td></td>
                        <td>".$s['mother_tongue']."</td>
                        <td> ".get_social_category_byid($s['soc_cat_id'])['soc_cat_name']."</td>
                       
                        <td></td>
                        
                        <td></td>
                        <td></td>
                        
                        <td></td>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> ".$admission."   </td>
                        <td>".date('d-m-Y',strtotime($s['admission_date']))."</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        
					     
				      </tr>";

      $i++;
    }

    $html .= '</tbody></table></div>';

    //  echo $html; die;	
    $filename = "Student_details_" . date('dmYHis') . ".xls";

    header("Content-type: application/octet-stream");
    header('Content-Disposition: attachment; filename=' . $filename);
    header("Pragma: no-cache");
    header("Expires: 0");
    $contents1 .= $html;
    echo $contents1;
    $contents1 .= "</body></html>";
  } else {
    echo "<script>window.history.back()</script>";
  }
}
die;
