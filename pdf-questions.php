<?php
include_once 'connection.php';
require("mpdf/autoload.php");	
	mysqli_set_charset( $con, 'utf8');
// Question ID wise Question Name Section
function QID_QName($QID, $con){

    $QuQuery = $con->query("SELECT * FROM `question` WHERE `id`=".$QID."");

    $Row = $QuQuery->fetch_assoc();

	extract($Row);	
    
    $response = array();

    if($type==0){
       
            if(!empty($based_on)){
                $ImgLink ="<center><span style='font-size:10px;'>(As on ".$based_on.")</span></center>";
            }
            $ImgLink .= "<img class='Qimg' src='assets/question/".$subject."/".$class."/".$ques_name."'/>";
        
        $response['Q_Name'] = $ImgLink;
       
    }else{
      
     	
            $que = $ques_name." ";
            if(!empty($based_on)){
                $que .="<span style='font-size:10px;'>(As on ".$based_on.")</span>";
            }
            $que .="<br><br>";
            $que .="(1)"." $option1"." "."(2)"." $option2"." "."(3)"." $option3"." "."(4)"." $option4";				
       
        $response['Q_Name'] = $que;
        //return $que;		
    }
    $response['based_on'] = $based_on;
    return $response;
}

function LangTypeDetails($Type, $db2){
    
    $LangQuery = $db2->query("SELECT * FROM `languages` WHERE `title` = '".$Type."' ");
    if($LangQuery->num_rows > 0){
        $LangRow = $LangQuery->fetch_assoc();
        return $LangRow['detail'];
    }else{
        return $Type;
    }
}


function getSubject($sub_id, $con){
    $SubQuery = $con->query("SELECT subject_name FROM `subject` WHERE `subject_id` = '".$sub_id."' ");
    if($SubQuery->num_rows > 0){
        $SubRow = $SubQuery->fetch_assoc();
        return $SubRow['subject_name'];
    }else{
        return '';
    }
}

    if(isset($_GET['test']) && isset($_GET['class']) && isset($_GET['subject'])){
        $test = base64_decode($_GET['test']);
        $class = base64_decode($_GET['class']);
        $subject = base64_decode($_GET['subject']);
        $qQuery = $con->query("SELECT * FROM `test` WHERE `test_id`='" . $test . "'");
        if($qQuery->num_rows>0){
            $Count = 1;
            $QBankRow = $qQuery->fetch_assoc();
		    $TotalQb = $QBankRow['no_of_question'];
	
		$Language ='Eng';
		$html = '
		<html><head><meta http-equiv="Content-Type" content="text/html; charset="windows-1252">
		<title>Question_'.$test.'_'.$class.'_'.$subject.'</title>
		<style>
        .gradient {
             border:0.1mm solid #220044;
             background-color: #f0f2ff;
             background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
			 
        }
        h4 {
             font-family: sans;
             font-weight: bold;
             margin-top: 1em;
             margin-bottom: 0.5em;
        }
        .divimg {
             padding:0.5em;
             margin-bottom: 0.5em;
             text-align:justify;
        }
        .divclass {
             padding:0.5em;
             margin-bottom: 0.5em;
             text-align:justify;
        }
        .myfixed1 {
             position: absolute;
             overflow: visible;
             left: 0;
             bottom: 0;
             border: 1px solid #880000;
             background-color: #FFEEDD;
             background-gradient: linear #dec7cd #fff0f2 0 1 0 0.5;
             padding: 0.5em;
             font-family:sans;
             margin: 0;
        }
        .myfixed2 {
             position: fixed;
             overflow: auto;
             right: 0;
             bottom: 0mm;
             width: 65mm;
             border: 1px solid #880000;
             background-color: #FFEEDD;
             background-gradient: linear #dec7cd #fff0f2 0 1 0 0.5;
             padding: 0.5em;
             font-family:sans;
             margin: 0;
             rotate: 90;
        }
        .Qimg{
            width:560px;
             height:370px;
             margin:0;
            padding:0;
            "
        }
        #Qtable{
             border: 1px solid #595959;
             border-collapse: collapse;
        }
        #Qtable td{
             border: 1px solid #595959;
             border-collapse: collapse;
             padding: 3px;
             width: 30px;
             height: 20px;
        }
        #Qtable td th {
             border: 1px solid #595959;
             border-collapse: collapse;
             padding: 1px;
             width: 30px;
             height: 25px;
        }
        /* td, th {
             padding: 3px;
             width: 30px;
             height: 25px;
        }
         */
        th {
             background: #f0e6cc;
        }
        .even {
             background: #fbf8f0;
        }
        .odd {
             background: #fefcf9;
        }
        p, td {
             font-family: frutiger,sun-extA;
        }
 		</style>

		</head>

		<body>
		<div class="divimg">
			<img src="https://ehfworld.in/demo/ehf/ERP/Admin/assets/images/logo_2.jpg" />
		</div>
		<div class="divclass" style="float: right; width: 40%; margin-bottom: 0pt; ">
			<table>
				<tbody>
                    <tr>
                        <td>Total Questions:</td>
                        <td>'.$TotalQb.'</td>
                    </tr>
                    <tr>
                        <td>Time: 30 Min</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Roll No:</td>
                        <td>_________________________</td>
                    </tr>
				</tbody>
			</table>
		</div>
		<div class="divclass" style="float: left; width: 44%; margin-bottom: 0pt; ">
            <table>
                <tbody>
                    <tr>
                        <td>Class:</td>
                        <td>'.$class.'</td>
                    </tr>
                    <tr>
                        <td>Subject:</td>
                        <td>'.getSubject($subject,$con).' ('.$Language.')</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td>_________________________</td>
                    </tr>
                </tbody>
            </table>
		</div>
		<div style="clear: both; margin: 0pt; padding: 0pt; "></div>
		<div class="divclass">
			<table autosize="1" repeat_header="1" id="Qtable" align="center" width="100%">
			<tbody>
			<tr>
			<td align="center"><b>No.</b></td>
			<td align="center"><b>Question</b></td>
            <td align="center"><b>No.</b></td>
			<td align="center"><b>Question</b></td>
			</tr>';
            
            $i=0;
            $html .='<tr>';
			 $QuQuery = $con->query("SELECT * FROM `question` WHERE `test_id`=".$test."");
			 while($Row = $QuQuery->fetch_assoc()){
				 
                if($Count%2 == 1){
                    $html .='<tr>';
                }
                $html .='
                     <td valign="top"><b>Q.'.$Count.'</b></td>
                     <td valign="top" align="center" >';						 
                $html .= QID_QName($Row['id'] ,$con)['Q_Name'];
                $html .='</td>';

                /*$html .='<td valign="top"><b>Q.'.$Count.'</b></td>
                     <td valign="top" align="center" >';  
                $html .= QID_QName($Q_ID[$i], $db2);
                $html .='</td>';*/
                $i++;
                if($Count%2==0){
                    $html .= '</tr>';
                }
                $Count++;
            }				
			$html .='</tbody>
					</table>
					</div>';

			$footer ='<div class="divclass" style="float: right; width: 20%; margin: 0pt; padding: 0pt; ">'.$test.'</div>
					  <div class="divclass" style="float: left; width: 54%; margin: 0pt; padding: 0pt; "></div>
					  <div style="clear: both; margin: 0pt; padding: 0pt; "></div>';			

			$fileName = 'Question_'.$test.'_'.$class.'_'.getSubject($subject,$con);
			//$mpdf     = new mPDF('c', 'A4', '', '', 0, 0, 3, 0, 0, 0);			
			//$mpdf = new mPDF('utf-8', 'A4-C','', '', 0, 0, 3, 0, 0, 0);
			$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4',
			            'margin_left' => 0,
						'margin_right' => 0,
						'margin_top' => 3,
						'margin_bottom' => 0,
						'margin_header' => 0,
						'margin_footer' => 0
				]);
			  
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
			$mpdf->shrink_tables_to_fit =1 ;
			$mpdf->SetHTMLFooter($footer);
			$mpdf->WriteHTML($html);
			//$mpdf->Output();
			$mpdf->Output(''.$fileName.'.pdf','i');
          
		}
    }


?> 

