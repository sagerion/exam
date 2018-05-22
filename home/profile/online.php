<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_check($start);
$user_id=$_SESSION['id'];
$out='';$table='';$test=0;
$f=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id' "));
$class=$f['class'];
$sq=mysqli_query($con,"select * from test where class='$class' order by start ASC");
while ($y=mysqli_fetch_array($sq,MYSQLI_ASSOC)) {
    $test_id=$y['test_id'];
    $sql=(mysqli_query($con,"select test_id,score,date from test_score where user_id='$user_id' and test_id='$test_id' "));
    if(mysqli_num_rows($sql)==1){
    $test++;
    while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
        $test_id=$a['test_id'];
        $x=mysqli_fetch_array(mysqli_query($con,"select * from test where test_id='$test_id' "),MYSQLI_ASSOC);
        $total=$x['total'];$percent=floatval($a['score'])*100/floatval($total);
        $out.='["'.date("d/m/y",strtotime($a['date'])).'",'.$percent.'],';$grade='';
        if($percent>50){$text="font-green";}else{$text="font-red";}
        if($percent>=90){$grade='Excellent';}
        if($percent>=80 && $percent<90){$grade="Very Good";}
        if($percent>=70 && $percent<80){$grade="Good";}
        if($percent>=60 && $percent<70){$grade="Needs Improvement";}
        if($percent<60){$grade="Needs lot of effort";}
        $table.='
            <tr>
                <td>'.date("d/m/y H:i",strtotime($a['date'])).'</td>
                <td>'.$x['name'].'</td>
                <td class="bold">'.$a['score'].' / '.$x['total'].'</td>
                <td class="bold '.$text.'">'.number_format($percent,2,'.','').'%</td>
                <td>'.$grade.'</td>
            </tr>
        ';
    }}
    else{
        $out.='["'.date("d/m/y",strtotime($y['start'])).'",0],';
        $table.='
            <tr>
                <td>'.date("d/m/y H:i",strtotime($y['start'])).'</td>
                <td>'.$y['name'].'</td>
                <td>Absent</td>
                <td class="bold font-red">0%</td>
                <td></td>
            </tr>
        ';
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
      
        <?php include_global($start);include_theme($start);include_countup($start);include_echarts($start);include_datatable_base($start); ?>
        <link href="../../assets/pages/css/profile.min.css" rel="stylesheet" type="text/css">
    <style>
        .profile-userpic{font-size: 100px;text-align: center}
        th,td{text-align: center}
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
                        <div class="col-md-6">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">Online Tests</div>
                                </div>
                            <div class="portlet-body">
                                <div id="echarts_line" class="chart" style="height:450px"></div>
                            </div>
                            </div>
                        </div>  

                        <div class="col-md-6">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">Online Tests Statistics</div>
                                </div>
                                <div class="portlet-body ">
                                    <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-hover table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>Attempt Date</th>
                                                <th>Test Name</th>
                                                <th>Score</th>
                                                <th>Percent</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $table ?>
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
var data = [<?php echo $out ?>];

var dateList = data.map(function (item) {
    return item[0];
});
var valueList = data.map(function (item) {
    return item[1];
});
var testList = data.map(function (item) {
    return item[2];
});
</script>
<script src="main.js"></script>
<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(3).addClass('start open active');
      $("#datatable").dataTable({dom: 'Bfrtip',
        buttons:{
        buttons: [
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



</html>