<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_admin($start);

$js='';
$current=strtotime(date("Y-m-d H:i"));
$a='';$attempt='';$unattempt='';$attempt_no='';$outoff='';$percent='';
if(isset($_GET['id'])){
$id=$_GET['id'];
$sql=mysqli_query($con,"select * from offline where test_id='$id'");
$a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
$class=$a['class'];


$sqq=mysqli_query($con,"select * from offline_score where test_id='$id'");
while($c=mysqli_fetch_array($sqq,MYSQLI_ASSOC)){
    $user_id=$c['user_id'];
    $sql=mysqli_query($con,"select user_id from user where class='$class' and status='y' ");
    $b=mysqli_fetch_array($sql,MYSQLI_ASSOC);$text='';
    if(($c['score']*100/$a['outoff'])<50){$text="font-red";}
    $f=mysqli_fetch_array(mysqli_query($con,"select * from user where user_id='$user_id'"),MYSQLI_ASSOC);
    $attempt.='
            <tr>
                <td class="link" onclick="location.href=(`../student/?id='.$user_id.'`)">'.$f['name'].'</td>
                <td>'.$c['score'].'</td>
                <td class="'.$text.' bold">'.$c['score']*100/$a['outoff'].'%</td>
            </tr>
        ';
}

}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title><?php echo $a['test_name'] ?> [<?php echo date("d M, Y ",strtotime($a['date'])) ?>]</title>
    <?php include_global($start);include_theme($start);include_datatable_base($start); ?>
<style>
th,td{text-align: center}
.stats>div{background:#eef1f5;width:150px;}
.link{color:#3598DC}
.link:hover{cursor: pointer;text-decoration:underline;}
.tag{color:#fff;font-size: 16px;padding:5px;padding-top: 7px;padding-bottom: 7px;padding-right:10px;border-radius: 0 50% 50% 0}
</style>       
</head>
    <body class=" page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">


        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>
    <div class="page-container">
        <?php include $prefix.'sidebar.php' ?>
        <div class="page-content-wrapper">
            <div class="page-content">
                <h1 class="page-title text-capitalize">
                    <span class="tag bg-green-sharp bold">10 <sup>th</sup></span>
                    <?php echo $a['test_name'] ?>  &nbsp;<small class="bold text-uppercase"><?php echo date("d M, Y ",strtotime($a['date']))?></small>
                    <small style="font-size:14px" class="bold uppercase pull-right">Outoff : <?php echo $a['outoff'] ?></small>
                </h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title border-green">
                                <div class="caption"><span class="caption-subject font-green">Student List</span>&nbsp</div>
                                <div class="actions"></div>
                            </div>
                            <div class="portlet-body ">
                                <table class="table table-striped table-bordered table-hover" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Score</th>
                                            <th>Percent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $attempt ?>
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
$(document).ready(function(){$(".page-sidebar>ul>li").eq(5).addClass('start open active');
    $("#datatable,#undatatable").dataTable({
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