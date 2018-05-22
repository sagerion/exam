<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_admin($start);
$js='';
if(isset($_GET['action'])){
    $action=$_GET['action'];
    $id=$_GET['id'];
    if($action=="delete"){
        mysqli_query($con,"delete from test_score where test_id='$id'");
        mysqli_query($con,"delete from test_prep where test_id='$id'");
        mysqli_query($con,"delete from test where test_id='$id'");
        header('location:./');
    }
}

if(isset($_SESSION['status'])){
    $status=$_SESSION['status'];
    if($status=="new_test"){
        $js='toastr.success("Test Database Updated", "New Test Added.");';
    }
    unset($_SESSION['status']);
}
$out=array("","","","");
$class9=mysqli_num_rows(mysqli_query($con,"select user_id from user where class='9' and status='y' "));
$class10=mysqli_num_rows(mysqli_query($con,"select user_id from user where class='10' and status='y' "));
$current=strtotime(date("Y-m-d H:i"));
$sql=mysqli_query($con,"select * from test");
while($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $test_id=$a['test_id'];$counter='';
    $index='';$text='';$outoff='';
    $start_date=strtotime($a['start']);
    $end_date=strtotime($a['end']);
    if($start_date>$current){
        $index=3;$text='grey-salsa';
        $counter=date("d M, Y H:i",strtotime($a['start'])).' - '.date("d M, Y H:i",strtotime($a['end']));
    }
    if($start_date<$current && $end_date>$current){
        $index=2;$text='green-sharp';
        $counter='<span id="counter'.$test_id.'"></span>
                <script>
                $(document).ready(function(){
                    var newYear =new Date('.(strtotime($a['end'])*1000).');
                    $("#counter'.$test_id.'").countdown({until: newYear,compact: true}); 
                })</script>';
    }
    if($end_date<$current){
        $index=1;$text='red-haze';
        $counter=date("d M, Y H:i",strtotime($a['start'])).' - '.date("d M, Y H:i",strtotime($a['end']));
    }
    if($a['class']==9){$outoff=$class9;}else{$outoff=$class10;}
    $attempt=mysqli_num_rows(mysqli_query($con,"select user_id from test_score where test_id='$test_id'"));
    if($outoff==0){$outoff=1;}
    $percent=floatval($attempt)*100/floatval($outoff);
    $class=$a['class'];
    $level=$a['level'];
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
    $out[$index].='
        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 " style="padding-left:0;padding-right:0">
            <div class="dashboard-stat2 test" data-attr="'.$a['test_id'].'" style="border-bottom:1px solid #eee">
                <div class="display">
                    <div class="number">
                        <h3 class="font-'.$text.'">
                            <span class="tag bg-'.$text.'">'.$a['class'].'<sup>th</sup> </span>
                            <span style="text-transform:capitalize">'.$a['name'].'</span>
                        </h3>
                        <small style="font-size:13px;margin-left:30px;color:#333">'.$counter.'</small><br/>
                        <small style="font-size:13px;margin-left:30px;text-transform:capitalize">Level/School: '.$level.'</small>
                    </div>
                    <div class="icon ">
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
                        <div class="status-title">Attempted</div>
                        <div class="status-number"> '.$attempt.' / '.$outoff.' </div>
                    </div>
                </div>
            </div>
        </div>

    ';
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
      
    <?php include_global($start);include_theme($start);include_datepicker($start);include_select2($start);include_toastr($start);include_blockui($start);include_countdown($start); ?>
    <link rel="stylesheet" type="text/css" href="main.css" />
<style>
.portlet-body .test{-webkit-transition:0.3s;-moz-transition:0.3s;transition:0.3s;}
.portlet-body .test:hover{background:#eee;cursor: pointer}
.tag{margin-left: -20px;color:#fff;font-size: 14px;padding:5px;padding-top: 7px;padding-bottom: 7px;border-radius: 0 50% 50% 0}



.overlay{background:rgba(47,53,59,0.5);position: fixed;top:0;left:0;z-index: 9996;width:100%;height:100%;display:none;}
</style>       
</head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

    <?php include $prefix.'menu.php'; ?>
    <div class="clearfix"> </div>

    <div class="page-container">
        <?php include $prefix.'sidebar.php' ?>
        <div class="page-content-wrapper">
            <div class="page-content">
                <h1 class="page-title">Test  
                    <a class="btn btn-default btn-circle pull-right" data-toggle="modal" href="#class" style="margin-left:10px"><i class="icon-pie-chart"></i>&nbsp;Overall Report</a>
                    <span class="btn btn-default btn-circle pull-right create-test"><i class="icon-plus"></i>&nbsp;Create Test</span>
                </h1>
                <div class="row">
                    <h4 class="col-md-4">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption"><span class="caption-subject font-green bold">Active Test</span></div>
                            </div>
                            <div class="portlet-body row">
                                 <?php echo $out[2] ?>
                            </div>
                        </div>
                    </h4>
                   <h4 class="col-md-4">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption"><span class="caption-subject font-grey-salsa bold">Upcoming Test</span></div>
                            </div>
                            <div class="portlet-body row">
                                 <?php echo $out[3] ?>
                            </div>
                        </div>
                    </h4>
                    <h4 class="col-md-4">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption"><span class="caption-subject font-red-haze bold">Past Test</span></div>
                            </div>
                            <div class="portlet-body row">
                                 <?php echo $out[1] ?>
                            </div>
                        </div>
                    </h4>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade bs-modal-sm" id="class" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <form method="GET" action="overall.php">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Overall Online Test Report</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="radio" name="class" value="10"> 10<sup>th</sup> Standard<br/>
                                                        <input type="radio" name="class" value="9"> 9<sup>th</sup> Standard
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-success" value="Check" />
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
<div class="info-window portlet light">

</div>
<div class="overlay"></div>
<?php include'exam.php'; ?>
<script src="main.js"></script>
<script>
$(document).ready(function(){
    <?php echo $js ?>
   

})



</script>
</body>




</html>