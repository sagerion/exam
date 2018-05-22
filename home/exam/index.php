<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_check($start);
$current=date("Y-m-d H:i");
$strcurrent=strtotime($current);
$id=$_SESSION['id'];$js='';
$ss=mysqli_fetch_array(mysqli_query($con,"select class,level from user where user_id='$id'"),MYSQLI_ASSOC);
$class=$ss['class'];$level=$ss['level'];

if(isset($_SESSION['status'])){
    $status=$_SESSION['status'];
    if($status=="upcoming_test"){
        $js='toastr.info("Test not available.","Upcoming Test!")';
    }
    if($status=="end_test"){
        $js='toastr.error("Test not available.","Test Ended!")';
    }

    if($status=="attempt_complete"){
        $js='toastr.error("Test not available.","Out Of Attempts!")';
    }
    unset($_SESSION['status']);
}


$out='';
$sql=mysqli_query($con,"select * from test where class='$class' and (level='$level' or level='0') and ('$current' Between start and end OR start>'$current') ");
$test_count=mysqli_num_rows($sql);
while($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $counter='';$text='';
    $test_id=$a['test_id'];
    $start_date=strtotime($a['start']);
    $end_date=strtotime($a['end']);
    if($start_date>$strcurrent){
        $text='grey-salsa';
        $counter=date("d M, Y H:i",strtotime($a['start'])).' - '.date("d M, Y H:i",strtotime($a['end']));
    }
    if($start_date<$strcurrent && $end_date>$strcurrent){$text='green-sharp';
        $counter='<span id="counter'.$test_id.'"></span>
                <script>
                $(document).ready(function(){
                    var newYear =new Date('.(strtotime($a['end'])*1000).');
                    $("#counter'.$test_id.'").countdown({until: newYear,compact: true}); 
                })</script>';
    }
    $total=$a['total'];$score=0;
    $s=mysqli_query($con,"select score from test_score where test_id='$test_id' and user_id='$id' ");
    if(mysqli_num_rows($s)==1){$s=mysqli_fetch_array($s,MYSQLI_ASSOC);$score=$s['score'];}
    $percent=floatval($score)*100/floatval($total);
    $out.='
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 test" data-attr="'.$a['test_id'].'">
                <div class="display">
                    <div class="number">
                        <h3 class="font-'.$text.'">
                            <span style="text-transform:capitalize" data-counter="counterup">'.$a['name'].'</span>
                        </h3>
                        <small>'.$counter.'</small>
                    </div>
                    <div class="icon">
                        <i class="icon-note font-'.$text.'"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: '.$percent.'%;" class="progress-bar progress-bar-success '.$text.'">
                            <span class="sr-only">'.$percent.'% Score</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title">Score</div>
                        <div class="status-number"> '.$score.' / '.$total.' </div>
                    </div>
                </div>
            </div>
        </div>

    ';
}
if($test_count==0){
    $out="<div class='col-md-12'>No test available</div>";
}

mysqli_close($con);
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start);include_countdown($start);include_blockui($start);include_toastr($start); ?>
        <link rel="stylesheet" href="main.css" type="text/css">
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <h1 class="page-title">Exam</h1>
                    <div class="row">
                        <?php echo $out ?>
                    </div>
                </div>
            </div>
        </div>         
<div class="test-info info-window portlet light">
<div class="title">Maths <span class="pull-right">Time Remaining - 15:00</span></div>
<div class="mt-element-list">
    <div class="mt-list-head list-simple font-dark bg-default">
        <div class="list-head-title-container">
            <div class="list-date">10 Questions</div>
            <h3 class="list-title">Test Details</h3>
        </div>
    </div>
    <div class="mt-list-container list-simple">
        <ul>
            <li class="mt-list-item">
                <div class="list-icon-container done"><i class="icon-check"></i></div>
                <div class="list-datetime"> 5 </div>
                <div class="list-item-content"><h3 class="uppercase"><a href="javascript:;">Chapter 1</a></h3></div>
            </li>
            <li class="mt-list-item">
                <div class="list-icon-container done"><i class="icon-check"></i></div>
                <div class="list-datetime"> 5 </div>
                <div class="list-item-content"><h3 class="uppercase"><a href="javascript:;">Chapter 2</a></h3></div>
            </li>
        </ul>
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
        <div class="btn-group col-md-12 btn-group-circle btn-group-md btn-group-solid margin-bottom-10">
            <button type="button" class="btn green" style="width: 75%" id="start-test">Start Test</button>
            <button type="button" class="btn dark" style="width:25%" id="close">Close</button>
        </div>
    </div>
</div>

</div>    
<div class="test-overlay">


</body>

<script src="main.js"></script>
<script>
toastr.options = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-bottom-center",
  "onclick": null,
  "showDuration": "1000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
$(document).ready(function(){
    <?php echo $js ?>
})
</script>

</html>