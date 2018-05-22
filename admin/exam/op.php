<?php
include'../../config.php';
include'../../file.php';
$start=2;
session_admin($start);

if(isset($_GET['test'])){
	$test_id=$_GET['test'];$count=0;$list='';$text='';
	$current=strtotime(date("Y-m-d H:i"));
	$sql=mysqli_query($con,"select * from test where test_id='$test_id'");
	$a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
	$ss=mysqli_query($con,"select * from test_prep where test_id='$test_id' ");
	while ($b=mysqli_fetch_array($ss,MYSQLI_ASSOC)) {
		$chapter_id=$b['chapter_id'];
		$type=$b['type'];
		if($type=="tf"){$type='True/False';}
		$c=mysqli_fetch_array(mysqli_query($con,"select chapter_name from chapter where chapter_id='$chapter_id'"),MYSQLI_ASSOC);
		$count+=$b['num'];
		$list.='
			<li class="mt-list-item">
	            <div class="list-icon-container done"><i class="icon-check"></i></div>
	            <div class="list-datetime"> '.$b['num'].' </div>
	            <div class="list-item-content"><h3 class="uppercase"><a href="javascript:;">'.$c['chapter_name'].' - '.$type.'</a></h3></div>
	        </li>

		';
	}
	$start_date=strtotime($a['start']);
    $end_date=strtotime($a['end']);
    if($start_date>$current){$index=3;$text='blue-chambray';}
    if($start_date<$current && $end_date>$current){$index=2;$text='green-sharp';}
    if($end_date<$current){$index=1;$text='red-haze';}
	$class=$a['class'];
	$outoff=mysqli_num_rows(mysqli_query($con,"select user_id from user where class='$class' and status='y' "));
	$attempt=mysqli_num_rows(mysqli_query($con,"select user_id from test_score where test_id='$test_id'"));
	if($outoff==0){$outoff=1;}
    $percent=floatval($attempt)*100/floatval($outoff);












	echo '
		<div class="portlet-title">
	        <div class="caption" id="title">'.$a['name'].'</div>
	         <div class="actions" id="date">'.date("d M, Y H:i",strtotime($a['start'])).' - '.date("d M, Y H:i",strtotime($a['end'])).'</div><br/><br/>
	         <div class="dashboard-stat2" style="padding:0;padding-top:20px;padding-bottom:10px">
	         <div class="progress-info">
                    <div class="progress">
                        <span style="width: '.$percent.'%;" class="progress-bar progress-bar-success '.$text.'">
                            <span class="sr-only">'.$percent.'% Score</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title">Attempted</div>
                        <div class="status-number"> '.$attempt.' / '.$outoff.' </div>
                    </div>
            </div>
            </div>
	    </div>
	    <div class="portlet-body">
	        <div class="mt-element-list">
	            <div class="mt-list-head list-simple font-dark bg-default">
	                <div class="list-head-title-container">
	                    <div class="list-date">'.$count.' Questions</div>
	                    <h3 class="list-title">Test Details</h3>
	                </div>
	            </div>
	            <div class="mt-list-container list-simple">
	                <ul>
	                  	'.$list.'
	                </ul>
	            </div>
	        </div>
	    </div>
	    <div class="portlet-footer text-center" style="padding-top:10px">
	    	<a onclick="location.href=(`./extend/?id='.$test_id.'`)" class="icon-btn" data-attr="'.$test_id.'" id="student_list">
                <i class="fa fa-calendar"></i>
                <div> Extend Date </div>
            </a>            
	    	<a onclick="window.open(`./student/?id='.$test_id.'`)" class="icon-btn" data-attr="'.$test_id.'" id="student_list">
                <i class="fa fa-group"></i>
                <div> Student List </div>
            </a>
            <a href="javascript:;" class="icon-btn" data-attr="'.$test_id.'" id="delete_test">
                <i class="fa fa-trash"></i>
                <div> Delete </div>
            </a>
	   		<a href="javascript:;" class="icon-btn" id="close-tab">
                <i class="fa fa-close"></i>
                <div> Close </div>
            </a>
	    </div>
	';

}


?>