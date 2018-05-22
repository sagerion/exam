<?php 
include'../config.php';
include'../file.php';
$prefix='';$start=1;
error_reporting(0);
session_check($start);
$id=$_SESSION['id'];
$v=mysqli_fetch_array(mysqli_query($con,"select class,level from user where user_id='$id'"),MYSQLI_ASSOC);
$class=$v['class'];$level=$v['level'];


$current=date("Y-m-d H:i");$out='';

$sqq=mysqli_query($con,"select * from test where class='$class' and (level='$level' or level='0') and ('$current' Between start and end OR start>'$current')  order by test_id ASC LIMIT 6");
if(mysqli_num_rows($sqq)>0){
while ($x=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
    $strcurrent=strtotime($current);
    $test_id=$x['test_id'];
    $starttime=strtotime($x['start']);$text='';
    if($starttime>$strcurrent){$text='default';}else{$text='success';}
    $f=mysqli_fetch_array(mysqli_query($con,"select * from test where test_id='$test_id'"),MYSQLI_ASSOC);
    $x=mysqli_fetch_array(mysqli_query($con,"select score from test_score where test_id='$test_id' and user_id='$id'"));
    $total=$f['total'];$score=$x['score'];$percent=floatval($score)*100/floatval($total);
    $out.='
          <div class=" col-md-6 col-xs-12" >
                            <div class="mt-element-ribbon bg-white" onclick="location.href=(`exam`)">
                            <span class="pull-right" style="padding-right:10px;padding-top:10px;color:#94A0B2;font-weight:600;font-size:12px">Score: '.$score.' / '.$total.'</span>
                                <div class="ribbon ribbon-vertical-left ribbon-color-'.$text.' uppercase">
                                    <i class="fa fa-star"></i>
                                </div>
                                
                                <p class="ribbon-content">
                                    <span class="bold">'.$f['name'].'</span><br/>
                                    <small>'.date("d/m/y H:i",strtotime($f['start'])).'</small>
                                </p>
                                <div class="progress-info">
                                    <div class="progress" style="margin-bottom:0;height:5px">
                                        <span style="width: '.$percent.'%;" class="progress-bar progress-bar-success green-sharp">
                                            <span class="sr-only">'.$percent.'% progress</span>
                                        </span>
                                    </div>
                                   
                                </div>
                            </div>

                        </div>
    ';
}}
else{
    $out='<p style="text-align:center">No Test Available.</p>';
}

$rank='';
$nu=0;
$current_date=date("Y-m-d H:i:s");
$start_date=$current_date;$end_date=$current_date;

$sql=mysqli_query($con,"select test_id,name,start,end from test where class='$class' and '$current_date' > end order by end DESC limit 1 ");
$count=mysqli_num_rows($sql);
if($count>0){
$sql=mysqli_fetch_array($sql,MYSQLI_ASSOC);
$test_id=$sql['test_id'];$test_name=$sql['name'];$start_date=$sql['start'];$end_date=$sql['end'];
$sql=mysqli_query($con,"select * from test_score where test_id='$test_id' order by score DESC");
while ($b=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $user_id=$b['user_id'];
    $a=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id'"),MYSQLI_ASSOC);
    $nu++;$color="";
    if($nu==1){$color="style='background:rgba(232, 126, 4,0.3)'";}
    if($nu==2){$color="style='background:rgba(191, 191, 191,0.3)'";}
     $rank.='
             <tr '.$color.'>
                <td class="fit"><i class="icon-user"></i><td><a href="#!" class="primary-link">'.$a['name'].'</a></td>
                <td> '.$b['attempt'].' </td>
                <td><span class="bold theme-font">'.$b['score'].'</span></td>
             </tr>
        ';
}}

mysqli_close($con);
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start); ?>
        <Style>
        .mt-element-ribbon{transition:0.3s all;-webkit-transition:0.3s all;-moz-transition:0.3s all;}
        .mt-element-ribbon:hover{box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2);cursor: pointer}
        </Style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="page-title">Test Schedule</h3>
                            <div class="row"><?php echo $out ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">Ranking <small class="uppercase bold" style="font-size:14px"><?php echo $test_name ?> [<?php echo date("d/m",strtotime($start_date)).' - '.date("d/m/Y",strtotime($end_date)) ?>]</small></div>
                                    <div class="actions">
                                        <a href="profile/online.php" class="btn btn-default btn-circle">View All</a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                            <div class="table-scrollable table-scrollable-borderless" style="height:400px;overflow-y: scroll;">
                                                <table class="table table-hover table-light">
                                                    <thead>
                                                        <tr class="uppercase">
                                                            <th colspan="2"> Name </th>
                                                            <th> Attempt </th>
                                                            <th> Total Score </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $rank; ?>
                                                    </tbody>
                                                </table>
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
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(0).addClass('start open active');
})
</script>



</html>