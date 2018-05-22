<?php 
include'../../../config.php';
include'../../../file.php';
$prefix='../../';$start=3;
session_admin($start);
date_default_timezone_set("Asia/Kolkata");
$js='';
$current=strtotime(date("Y-m-d H:i"));
$a='';$attempt='';$unattempt='';$attempt_no='';$outoff='';$percent='';
if(isset($_GET['id'])){
$id=$_GET['id'];
$sql=mysqli_query($con,"select * from test where test_id='$id'");
$a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
$class=$a['class'];

$outoff=mysqli_num_rows(mysqli_query($con,"select user_id from user where class='$class' and status='y' "));
$attempt_no=mysqli_num_rows(mysqli_query($con,"select user_id from test_score where test_id='$id'"));
if($outoff==0){$outoff=1;}
$percent=floatval($attempt_no)*100/floatval($outoff);


$sql=mysqli_query($con,"select user_id from user where class='$class' and status='y' ");
while($b=mysqli_fetch_array($sql,MYSQLI_ASSOC)){
    $user_id=$b['user_id'];
    $f=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id'"),MYSQLI_ASSOC);
    $count=mysqli_query($con,"select * from test_score where user_id='$user_id' and test_id='$id'");
    if((mysqli_num_rows($count))==1){
        $x=mysqli_fetch_array($count,MYSQLI_ASSOC);
        $percent=$x['score']*100/$a['total'];$grade='';
        if($percent>=90){$grade='Excellent';}
        if($percent>=80 && $percent<90){$grade="Very Good";}
        if($percent>=70 && $percent<80){$grade="Good";}
        if($percent>=60 && $percent<70){$grade="Needs Improvement";}
        if($percent<60){$grade="Needs lot of effort";}
        $attempt.='
            <tr>
                <td>'.date("d/m/y H:i",strtotime($x['date'])).'</td>
                <td class="link" onclick="location.href=(`../../student/?id='.$user_id.'`)">'.$f['name'].'</td>
                <td>'.$x['score'].'</td>
                <td>'.$x['attempt'].'</td>
                <td>'.number_format($percent,2,'.','').'%</td>
                <td>'.$grade.'</td>
            </tr>
        ';
    }
    else{
        $unattempt.='
        <tr>
            <td class="link" ><span onclick="location.href=(`../../student/?id='.$user_id.'`)">'.$f['name'].'</span></td>
            <td>'.$f['contact'].'</td>
            <td>'.$f['parent'].'</td>
        </tr>
        ';
    }
}

}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title><?php echo $a['name'] ?> [<?php echo date("d M, Y H:i",strtotime($a['start'])).' - '.date("d M, Y H:i",strtotime($a['end'])) ?>]</title>
    <?php include_global($start);include_theme($start);include_datatable_base($start); ?>
<style>
th,td{text-align: center}
.stats>div{background:#eef1f5;width:150px;}
.link{color:#3598DC}
.link:hover{cursor: pointer;text-decoration:underline;}
</style>       
</head>
    <body class=" page-sidebar-closed page-container-bg-solid">


    <div class="page-container">
        
        <div class="page-content-wrapper">
            <div class="page-content">
                <h1 class="page-title"><?php echo $a['name'] ?>  &nbsp;<small class="bold text-uppercase"><?php echo date("d M, Y H:i",strtotime($a['start'])).' - '.date("d M, Y H:i",strtotime($a['end'])) ?></small>
                    <span class="pull-right stats">
                        <div class="dashboard-stat2" style="padding:0;padding-bottom:10px">
                         <div class="progress-info">
                                <div class="progress">
                                    <span style="width: <?php echo $percent ?>%;" class="progress-bar progress-bar-success green-sharp">
                                        <span class="sr-only"><?php echo $percent ?>% Score</span>
                                    </span>
                                </div>
                                <div class="status">
                                    <div class="status-title">Attempted</div>
                                    <div class="status-number"> <?php echo $attempt_no ?> / <?php echo $outoff ?> </div>
                                </div>
                        </div>
                        </div>
                    </span></h1>
                <div class="row">
                    <div class="col-md-8">
                        <div class="portlet light ">
                            <div class="portlet-title border-green">
                                <div class="caption"><span class="caption-subject font-green">Attempted Student List</span>&nbsp<small style="font-size:14px" class="bold uppercase">Outoff : <?php echo $a['total'] ?></small></div>
                                <div class="actions"></div>
                            </div>
                            <div class="portlet-body ">
                                <table class="table table-striped table-bordered table-hover" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Score</th>
                                            <th>Attempt</th>
                                            <th>Percent</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $attempt ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="portlet light ">
                            <div class="portlet-title border-red">
                                <div class="caption"><span class="caption-subject font-red">Unattempted Student List</span></div>
                            </div>
                            <div class="portlet-body ">
                                <table class="table table-striped table-bordered table-hover" id="undatatable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Parent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $unattempt ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


<script>
$(document).ready(function(){
    $("#datatable,#undatatable").dataTable({dom: 'Bfrtip',
        buttons:{
        buttons: [

            {"extend": 'excel',"className": 'btn btn-outline dark'},
            {"extend": 'print',"className": 'btn btn-outline green'}
        ]},
         aLengthMenu: [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ],
        iDisplayLength: -1,
        responsive:true,
    });
   

})



</script>
</body>




</html>