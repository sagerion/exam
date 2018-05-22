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



$sqq=mysqli_query($con,"select * from user where class='$class' and status='y' ");
while($b=mysqli_fetch_array($sqq,MYSQLI_ASSOC)){
    $user_id=$b['user_id'];
    $sql=mysqli_query($con,"select score from offline_score where user_id='$user_id' and test_id='$id'  ");
    $c=mysqli_fetch_array($sql,MYSQLI_ASSOC);$text='';
    if(($c['score']*100/$a['outoff'])<50){$text="font-red";}
    $attempt.='
            <tr>
                <td class="link" onclick="location.href=(`../student/?id='.$user_id.'`)">'.$b['name'].'</td>		
		<input type="hidden" name="user_id[]" value="'.$b['user_id'].'" />                
		<td><input type="text" name="score[]" class="form-control" value="'.$c['score'].'" /></td>
                <td class="'.$text.' bold">'.$c['score']*100/$a['outoff'].'%</td>
            </tr>
        ';
}

}

if(isset($_POST['save'])){
	$test_id=$_POST['test_id'];
	$user_id=$_POST['user_id'];
    	$test_name=$_POST['test_name'];
    	mysqli_query($con,"update offline set test_name='$test_name' where test_id='$test_id' ");
	$score=$_POST['score'];
	
	$lenn=sizeof($user_id);
	for($i=0;$i<$lenn;$i++){
		$sq=mysqli_query($con,"select score from offline_score where test_id='$test_id' and user_id='$user_id[$i]' ");
		if(mysqli_num_rows($sq)==1){
			mysqli_query($con,"update offline_score set score='$score[$i]' where test_id='$test_id' and user_id='$user_id[$i]'");
		}
		else{
			mysqli_query($con,"insert into offline_score (score,test_id,user_id) values ('$score[$i]','$test_id','$user_id[$i]') ");
		}
	}
	//echo mysqli_error($con);
	header('location:./index.php');
	
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
        <form method="post">
            <div class="page-content">
                <h1 class="page-title text-capitalize">
                    
                    <span class="tag bg-green-sharp bold pull-left">10 <sup>th</sup></span>
                      
                        <input type="text" name="test_name" class="form-control pull-left" value="<?php echo $a['test_name'] ?>"  style="width:200px"/>&nbsp;
                        <small class="bold text-uppercase"><?php echo date("d M, Y ",strtotime($a['date']))?></small>
                    <small style="font-size:14px" class="bold uppercase pull-right">Outoff : <?php echo $a['outoff'] ?></small>
                </h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title border-green">
                                <div class="caption"><span class="caption-subject font-green">Student List</span>&nbsp</div>
                                <div class="actions"></div>
                            </div>
                            <div class="portlet-body">
				<input type="hidden" name="test_id" value="<?php echo $_GET['id'] ?>"  />
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
				<input type="submit" name="save" class="btn btn-success btn-lg" value="Update" />
                            </div>
                        </div>
                    </div>
		
                </div>
            </div>
        </div>
        </form>
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
