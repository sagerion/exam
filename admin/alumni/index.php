<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_admin($start);
$out='';





if(isset($_GET['status'])){
    $status=$_GET['status'];
    $id=$_GET['id'];

    if($status=='y'){
        mysqli_query($con,"update alumni set status='y' where id='$id'");
    }
    if($status=='delete'){
        $sq=mysqli_query($con,"select image from alumni where id='$id'");
        $a=mysqli_fetch_array($sq,MYSQLI_ASSOC);
        $image=$a['image'];
        unlink('../../../alumni/'.$a['image']);
        mysqli_query($con,"delete from alumni where id='$id'");

    }
}

$sql=mysqli_query($con,"select * from alumni ");
while($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)){
    $btn='';
    if($a['status']=='n'){
        $btn='<a class="btn btn-primary" href="./index.php?status=y&id='.$a['id'].'"><i class="fa fa-check"></i></a>';
    }
    $out.='
        <div class="col-md-4">
            <img src="../../../alumni/'.$a['image'].'" class="img-responsive" />
            <div class="btn-group" style="margin-top:-55px">
                '.$btn.'
                <a class="btn btn-danger" href="./index.php?status=delete&id='.$a['id'].'"><i class="fa fa-trash"></i></a>
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
      
        <?php include_global($start);include_theme($start);include_datatable_base($start);include_sweetalert($start) ?>
   <style>
   
   </style>     
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <h3 class="page-title">Alumni</h3>
                    <div class="row">
                        <?php echo $out ?>
                    </div>
                </div>
            </div>
        </div>         
    </body>




<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(6).addClass('start open active');
    $("table#fees").dataTable({"bFilter": false,"lengthChange": false,"iDisplayLength":-1,});
    $("table#accounts").dataTable({ dom: 'Bfrtip',
        buttons:{
        buttons: [
            {"extend": 'excel',"className": 'btn dark'},
            {"extend": 'print',"className": 'btn green'}
        ]},
        responsive:true,
    });
})

$(document).on("click",".action",function(){
    $(this).addClass('active-button');
    var data=$(this).attr('data-attr');
    var type=$(this).attr('data-type');
    $.ajax({
        type:"POST",
        url:"op.php",
        data:"data="+data+"&type="+type,
        cache:false,
        success:function(e){
            if(type=="ban"){
                $(".active-button").parent().parent().append('<label class="label label-danger"><i class="icon-close"> Banned</label>');
                 $(".active-button").parent().remove();
            }
            else if(type=="fees"){
                var k=$.parseJSON(e);
                $("input[name=user]").val(data);
                $("#total").html(k.total);$("#paid").html(k.paid);$("#pending").html(k.total-k.paid);
                $("#fees tbody").empty();$("#fees tbody").append(k.trans);
                $("#name").html(k.name);$("#class").html(k.class);
                $("#large").modal('show');
            }
            else if(type=="reset"){
                swal("Password Reset!", "Password Reset to 123456!", "success");
            }
            else{
                $(".active-button").parent().parent().append('<label class="label label-success"><i class="icon-check"></i> Approved</label>');
                $(".active-button").parent().remove();
            }
        }
    })
})
</script>

</html>