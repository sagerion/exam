<?php
include'../../config.php';


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
	












	echo '
		<div class="portlet-title">
	        <div class="caption" id="title">'.$a['name'].'</div>
	         <div class="actions" id="date">'.date("d M, Y H:i",strtotime($a['start'])).' - '.date("d M, Y H:i",strtotime($a['end'])).'</div><br/><br/>
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
	    <div class="row justify-content-xs-center">
		    <div class="col-xs-12">
		        <div class="mt-element-ribbon bg-grey-steel">
		            <div class="ribbon ribbon-color-primary uppercase">Instructions</div>
		            <p class="ribbon-content">Duis mollis, est non commodo luctus, nisi erat porttitor ligula</p>
		        </div>
		    </div>
		    <div class="col-sm-6 col-xs-10 col-xs-offset-1 col-sm-offset-3">
		        <div class="btn-group col-md-12 col-xs-12 btn-group-circle btn-group-md btn-group-solid margin-bottom-10">
		            <button type="button" class="btn green" style="width: 75%" id="start-test" data-attr="'.$test_id.'">Start Test</button>
		            <button type="button" class="btn dark" style="width:25%" id="close">Close</button>
		        </div>
		    </div>
		</div>
	';

}


?>