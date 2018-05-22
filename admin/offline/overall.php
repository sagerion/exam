<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_admin($start);
$js='';$rows='';$table='';
if(isset($_GET['class'])){
$class=$_GET['class'];
$sql=mysqli_query($con,"select * from offline where class='$class' order by date ASC");
    while($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)){
        $rows.='<th>'.$a['test_name'].' ('.$a['outoff'].')</th>';   
}



$sq=mysqli_query($con,"select * from user where status='y' and class='$class' order by user_id ASC");
    while ($b=mysqli_fetch_array($sq,MYSQLI_ASSOC)) {
    $user_id=$b['user_id'];
    $table.='<tr><td>'.$b['name'].'</td><td>'.$b['class'].'</td>';
    $sql=mysqli_query($con,"select * from offline where class='$class' order by date ASC");
    while($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)){
        $test_id=$a['test_id'];
        $c=mysqli_query($con,"select score from offline_score where test_id='$test_id' and user_id='$user_id' ");
        if(mysqli_num_rows($c)==1){
            $c=mysqli_fetch_array($c,MYSQLI_ASSOC);
            $table.='<td>'.$c['score'].'</td>';
        }
        else{
             $table.='<td> </td>';
        }   
    }
    $table.='</tr>';
}
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Offline Test Report</title>
    <?php include_global($start);include_theme($start);include_datatable_base($start); ?>

<style>
.portlet-body .test{-webkit-transition:0.3s;-moz-transition:0.3s;transition:0.3s;}
.portlet-body .test:hover{background:#eee;cursor: pointer}
.tag{margin-left: -20px;color:#fff;font-size: 14px;padding:5px;padding-top: 7px;padding-bottom: 7px;border-radius: 0 50% 50% 0}
.info-window{position: fixed;z-index: 9997;width:40vw;height:100%;top:0;left:0;background:#fff;box-shadow: 0 3px 9px rgba(0,0,0,.5);border-radius: 0;-webkit-transition:0.3s;-moz-transition:0.3s;transition:0.3s;-webkit-transform:translateX(-100%);-moz-transform:translateX(-100%);transform:translateX(-100%);}


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
               <h1 class="page-title">Offline Test Report</h1>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <?php echo $rows ?>
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

<div class="overlay"></div>
<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(5).addClass('start open active');
  $("#datatable").dataTable({responsive: true,
         aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            'iDisplayLength': -1,
            dom: 'Bfrtip',
        buttons:{
        buttons: [

            {"extend": 'excel',"className": 'btn btn-outline dark'},
            {"extend": 'print',"className": 'btn btn-outline green'}
        ]}
    });

})



</script>
</body>




</html>