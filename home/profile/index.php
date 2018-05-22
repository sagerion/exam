<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_check($start);
$user_id=$_SESSION['id'];
$out='';$test=0;$out_offline='';$offline_test=0;
$f=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id' "));
$class=$f['class'];
$sq=mysqli_query($con,"select test_id,start,name from test where class='$class' order by start ASC");
while ($y=mysqli_fetch_array($sq,MYSQLI_ASSOC)) {
    $test_id=$y['test_id'];
    $sql=(mysqli_query($con,"select test_id,score,date from test_score where user_id='$user_id' and test_id='$test_id' "));
    if(mysqli_num_rows($sql)==1){
    $test++;
    while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
        $test_id=$a['test_id'];
        $x=mysqli_fetch_array(mysqli_query($con,"select * from test where test_id='$test_id' "),MYSQLI_ASSOC);
        $total=$x['total'];$percent=floatval($a['score'])*100/floatval($total);
        $out.='["'.date("d/m/y",strtotime($a['date'])).'",'.$percent.'],';
    }}
    else{
        $out.='["'.date("d/m/y",strtotime($y['start'])).'",0],';
    }
}

$sq=mysqli_query($con,"select test_id,date,test_name,outoff from offline where class='$class' order by date ASC");
while ($y=mysqli_fetch_array($sq,MYSQLI_ASSOC)) {
    $offline_test++;
    $test_id=$y['test_id'];
    $sql=(mysqli_query($con,"select test_id,score from offline_score where user_id='$user_id' and test_id='$test_id' "));
    if(mysqli_num_rows($sql)==1){
    while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
        $total=$y['outoff'];$percent=floatval($a['score'])*100/floatval($total);
        $out_offline.='["'.date("d/m/y",strtotime($y['date'])).'",'.$percent.'],';
    }}
    else{
        $out_offline.='["'.date("d/m/y",strtotime($y['date'])).'",0],';
    }
}
mysqli_close($con);
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start);include_countup($start);include_echarts($start) ?>
        <link href="../../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css">
    <style>
        .profile-userpic{font-size: 100px;text-align: center}
    </style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet ">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                        <i class="icon-user"></i> 
                                    </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name text-capitalize"><?php echo $f['name'] ?> </div>
                                        <div class="profile-usertitle-job"> <?php echo $f['class'] ?><sup>th</sup> Standard </div>
                                    </div>
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li class="active">
                                                <a href="#!">
                                                    <i class="icon-home"></i> Overview </a>
                                            </li>
                                            <li>
                                                <a href="setting.php">
                                                    <i class="icon-settings"></i> Account Settings </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <div class="row">
                                    <div class="col-md-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $test ?>"><?php echo $test ?></span></div>
                                            <div class="desc"> Test Taken </div>
                                        </div>
                                    </a>
                                    </div>
                                    <div class="col-md-12">
                                    <a class="dashboard-stat dashboard-stat-v2 dark" href="#">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo $offline_test ?>"><?php echo $offline_test ?></span></div>
                                            <div class="desc"> Offline Test </div>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">Online Tests</div>
                                                <div class="actions"><span class="btn btn-default btn-circle" onclick="location.href=('./online.php')">View Details</span></div>
                                            </div>
                                            <div class="portlet-body">
                                                <div id="echarts_line" class="chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="portlet light">
                                            <div class="portlet-title">
                                                <div class="caption">Offline Tests</div>
                                                <div class="actions"><span class="btn btn-default btn-circle" onclick="location.href=('./offline.php')">View Details</span></div>
                                            </div>
                                            <div class="portlet-body">
                                                <div id="echarts_line1" class="chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
    </body>
<script>
var data = [<?php echo $out ?>];

var dateList = data.map(function (item) {
    return item[0];
});
var valueList = data.map(function (item) {
    return item[1];
});
var data1 = [<?php echo $out_offline ?>];

var dateList1 = data1.map(function (item) {
    return item[0];
});
var valueList1 = data1.map(function (item) {
    return item[1];
});
</script>
<script src="main.js"></script>
<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(3).addClass('start open active');
})
</script>



</html>