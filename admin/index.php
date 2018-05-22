<?php 
include'../config.php';
include'../file.php';
$prefix='';$start=1;
session_admin($start);


$students=mysqli_num_rows(mysqli_query($con,"select user_id from user where status='y'"));
$ban=mysqli_num_rows(mysqli_query($con,"select user_id from user where status='b'"));
$pending=mysqli_num_rows(mysqli_query($con,"select user_id from user where status='n'"));
$test=mysqli_num_rows(mysqli_query($con,"select test_id from test"));

$current=date("Y-m-d H:i");$out='';
$sqq=mysqli_query($con,"select * from test where '$current' Between start and end OR start>'$current'  order by test_id ASC LIMIT 6");
while ($x=mysqli_fetch_array($sqq,MYSQLI_ASSOC)) {
    $strcurrent=strtotime($current);
    $test_id=$x['test_id'];
    $starttime=strtotime($x['start']);$text='';
    if($starttime>$strcurrent){$text='default';}else{$text='success';}
    $f=mysqli_fetch_array(mysqli_query($con,"select * from test where test_id='$test_id'"),MYSQLI_ASSOC);
    $class=$f['class'];
    $level=$f['level'];
    if($class==9){
        if($level==1){$level='Fatima High School';}
        if($level==2){$level='Vidya Bhavan';}
        if($level==3){$level='M.D.Bhatia';}
        if($level==4){$level='Holy Family';}
        if($level==5){$level='Gurukul';}
        if($level==6){$level='St.Anthony';}
        if($level==7){$level='Swami Vivekanand';}
        if($level==8){$level='SVDD';}
        if($level==9){$level='Others';}    
    }
    $out.='
          <div class=" col-md-6 col-xs-12">
                            <div class="mt-element-ribbon bg-white" onclick="location.href=(`exam`)">
                                <div class="ribbon ribbon-vertical-left ribbon-color-'.$text.' uppercase">
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="pull-right badge" style="margin-top: 10px;margin-right: 10px">'.$f['class'].'</div>
                                <p class="ribbon-content">
                                    <span class="bold">'.$f['name'].'</span><br/>
                                    <small>'.date("d/m/y H:i",strtotime($f['start'])).'</small><br/>
                                    <small>Level/school : '.$level.'</small>
                                </p>

                            </div>
                        </div>
    ';
}

$rank='';
if(isset($_GET['action'])){
    $action=$_GET['action'];
    $sql=mysqli_query($con,"select user_id from user where status='y'");
    while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
        $user_id=$a['user_id'];
        $a=mysqli_fetch_array(mysqli_query($con,"select SUM(score) as total,count(score) as attempt from test_score where user_id='$user_id' "),MYSQLI_ASSOC);
        mysqli_query($con,"update user set score=".$a['total'].",attempt=".$a['attempt']." where user_id='$user_id' ");
        header('location:./index.php');
    }
}

$nu=0;
$current_date=date("Y-m-d H:i:s");
$sql=mysqli_fetch_array(mysqli_query($con,"select test_id,name from test where class='10' and '$current_date' > end order by end DESC limit 1 "),MYSQLI_ASSOC);
$test_id=$sql['test_id'];$test_name=$sql['name'];
$sql=mysqli_query($con,"select * from test_score where test_id='$test_id' order by score DESC");
while ($b=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $user_id=$b['user_id'];
    $a=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id'"),MYSQLI_ASSOC);
    $nu++;$color="";
    if($nu==1){$color="style='background:rgba(232, 126, 4,0.3)'";}
    if($nu==2){$color="style='background:rgba(191, 191, 191,0.3)'";}
     $rank.='
             <tr '.$color.'>
                <td class="fit"><i class="icon-user"></i><td><a href="student/?id='.$a['user_id'].'" class="primary-link">'.$a['name'].'</a></td>
                <td> '.$b['attempt'].' </td>
                <td><span class="bold theme-font">'.$b['score'].'</span></td>
             </tr>
        ';
}

$nu=0;$rank9='';
$sql=mysqli_fetch_array(mysqli_query($con,"select test_id,name from test where class='9' and '$current_date' > end order by end DESC limit 1 "),MYSQLI_ASSOC);
$test_id=$sql['test_id'];$test_name9=$sql['name'];
$sql=mysqli_query($con,"select * from test_score where test_id='$test_id' order by score DESC");
while ($b=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $user_id=$b['user_id'];
    $a=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id'"),MYSQLI_ASSOC);
    $nu++;$color="";
    if($nu==1){$color="style='background:rgba(232, 126, 4,0.3)'";}
    if($nu==2){$color="style='background:rgba(191, 191, 191,0.3)'";}
     $rank9.='
             <tr '.$color.'>
                <td class="fit"><i class="icon-user"></i><td><a href="student/?id='.$a['user_id'].'" class="primary-link">'.$a['name'].'</a></td>
                <td> '.$b['attempt'].' </td>
                <td><span class="bold theme-font">'.$b['score'].'</span></td>
             </tr>
        ';
}
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start);include_countup($start) ?>
        <Style>
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
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="account">
                                <div class="visual">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $students ?>"></span>
                                    </div>
                                    <div class="desc"> Active Students </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="account">
                                <div class="visual">
                                    <i class="fa fa-ban"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $ban ?>"></span>
                                    </div>
                                    <div class="desc"> Banned Students </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="account">
                                <div class="visual">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $pending ?>"></span>
                                    </div>
                                    <div class="desc"> Pending Students </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 purple" href="exam">
                                <div class="visual">
                                    <i class="fa fa-language"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $test ?>"></span>
                                    </div>
                                    <div class="desc"> Test Created </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><h3>Test Schedule</h3>
                            <div class="row"><?php echo $out ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">Ranking</div>
                                    <div class="actions" style="padding:0">
                                        <ul class="nav nav-tabs pull-left" style="margin-bottom:0;margin-right: 10px">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true"> <?php echo $test_name ?> (10) </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false"><?php echo $test_name9 ?> (9) </a>
                                            </li>
                                        </ul>
                                    </div> 
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_1_1">
                                            <div class="table-scrollable table-scrollable-borderless" style="height:300px;overflow-y: scroll;">
                                                <table class="table table-hover table-light">
                                                    <thead>
                                                        <tr class="uppercase">
                                                            <th colspan="2"> Name </th>
                                                            <th> Attempt </th>
                                                            <th> Score </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $rank; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab_1_2">
                                            <div class="table-scrollable table-scrollable-borderless" style="height:300px;overflow-y: scroll;">
                                                <table class="table table-hover table-light">
                                                    <thead>
                                                        <tr class="uppercase">
                                                             <th colspan="2"> Name </th>
                                                            <th> Test Attempt </th>
                                                            <th> Score </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $rank9; ?>
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
        </div>         
    </body>



<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(0).addClass('start open active');

})
</script>

</html>