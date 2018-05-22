<?php 
include'../../config.php';
include'../../file.php';
$prefix='../';$start=2;
session_admin($start);
$out='';
$sql=mysqli_query($con,"select * from user");
while ($a=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
    $status=$a['status'];$btn='';$txt='';$link='';$link_class='';
    if($status=="n" || $status=='b'){
        $btn='
        <div class="btn-group btn-group-circle btn-xs">
            <button type="button" class="btn btn-xs btn-default green action" data-type="accept" data-attr="'.$a['user_id'].'"><i class="icon-check"></i> Accept</button>
            <button type="button" class="btn btn-xs btn-default red action" data-type="decline" data-attr="'.$a['user_id'].'"><i class="icon-close"></i> Decline</button>
        </div>
        ';
    }
    if($status=="y"){
        $btn='
        <div class="btn-group btn-group-circle btn-xs">
           <button type="button" class="btn btn-xs btn-default red action" data-type="ban" data-attr="'.$a['user_id'].'"><i class="icon-ban"></i> Ban</button>
           <button type="button" class="btn btn-xs btn-default blue action" data-type="fees" data-attr="'.$a['user_id'].'"><i class="icon-diamond"></i> Fees/Level</button>
           <button type="button" class="btn btn-xs btn-default action" data-type="reset" data-attr="'.$a['user_id'].'"><i class="icon-lock"></i> Reset Password</button>
            
        </div>
        ';
        $link='onclick="location.href=(`../student/?id='.$a['user_id'].'`)"';$link_class="link";
    }
    if($status=='b'){
        $txt='class="tooltips" data-title="Banned"';
    }
    if($status=='d'){
        $txt='class="tooltips demo" data-title="Demo Request"';
        $link_class="bg-grey-silver bg-font-grey-cararra";
        $btn='
        <div class="btn-group btn-group-circle btn-xs">
            <button type="button" class="btn btn-xs btn-default green action" data-type="accept_demo" data-attr="'.$a['user_id'].'"><i class="icon-check"></i> Accept</button>
            <button type="button" class="btn btn-xs btn-default red action" data-type="decline" data-attr="'.$a['user_id'].'"><i class="icon-close"></i> Decline</button>    
        </div>
        ';
    }
    if($status=="dy"){
        $txt='class="tooltips demo" data-title="Demo Student"';
        $btn='
        <div class="btn-group btn-group-circle btn-xs">
            <button type="button" class="btn btn-xs btn-default green action" data-type="promote_demo" data-attr="'.$a['user_id'].'"><i class="icon-check"></i> Upgrade Pro</button>
            <button type="button" class="btn btn-xs btn-default red action" data-type="decline" data-attr="'.$a['user_id'].'"><i class="icon-close"></i> Remove</button>    
        </div>
        ';
    }
    $level=$a['level'];
    $class=$a['class'];
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
        <tr '.$txt.'>
            <td class="text-center '.$link_class.'"><div '.$link.'>'.$a['name'].'</div></td>           
            <td class="text-center">'.$a['contact'].'</td>
            <td class="text-center">'.$a['parent'].'</td>
            <td class="text-center">'.$a['class'].'</td>
            <td class="text-center">'.$level.'</td>
            <td class="text-left">'.$btn.'</td>
            <td class="text-center">'.$a['email'].'</td>
            <td class="text-center">'.($a['amount']-$a['paid']).'</td>
        </tr>
    ';
}

if(isset($_GET['action'])){
    $action=$_GET['action'];$id=$_GET['id'];
    if($action=="delete"){
        $s=mysqli_fetch_array(mysqli_query($con,"select * from fees where fees_id='$id' "),MYSQLI_ASSOC);
        $user_id=$s['user_id'];$amt=$s['amt'];
        mysqli_query($con,"update user set paid=paid-".$amt." where user_id='$user_id' ");
        mysqli_query($con,"delete from fees where fees_id='$id' ");
        header('location:./');
    }
}

if(isset($_POST['total_fees'])){
    $user=$_POST['user'];$total=$_POST['total'];
    mysqli_query($con,"update user set amount='$total' where user_id='$user' ");
    header('location:./');
}


if(isset($_POST['add_fees'])){
    $user=$_POST['user'];$amount=$_POST['amount'];$date=$_POST['date'];
    mysqli_query($con,"insert into fees (date,user_id,amt) values ('$date','$user','$amount')");
    mysqli_query($con,"update user set paid=paid+".$amount." where user_id='$user' ");
    header('location:./');
}

if(isset($_POST['change_level'])){
    $user=$_POST['user'];$level=$_POST['level'];
    mysqli_query($con,"update user set level='$level' where user_id='$user' ");
    header('location:./');
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
   tr.tooltips>td:first-child{border-left: 10px solid #E7505A !important}
   tr.tooltips.demo>td:first-child{border-left: 10px solid #3598DC !important}
   .link{color:#3598DC}
    .link:hover{cursor: pointer;text-decoration:underline;}
   </style>     
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <h3 class="page-title">Account Management</h3>
                    <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed" id="accounts">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Parent Contact</th>
                                <th>Class</th>
                                <th>Level/School</th>
                                <th style="min-width: 250px">Action</th>
                                <th>Email</th>
                                <th>Pending </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $out ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>         
    </body>

<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Fees / Level Info </h4>
            </div>
            <div class="modal-body">
                <div  class="text-capitalize" >Name: <span id="name" style="font-size:18px;padding-right:50px"></span> Class: <span id="class" style="font-size:18px;"></span><sup>th</sup> &nbsp;&nbsp;&nbsp; Level/School: <span id="level" style="font-size:18px"></span></div>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <label>Paid :<br/> <span style="font-size: 20px" id="paid"></span></label>
                    </div>
                    <div class="col-md-2">
                         <label>Total Fees :<br/> <span style="font-size: 20px" id="total"></span></label>
                    </div>
                    <div class="col-md-2">
                         <label>Pending :<br/> <span style="font-size: 20px" id="pending"></span></label>
                    </div>
                    <div class="col-md-6 pull-right">
                         <button class="btn blue" data-toggle="modal" href="#change_level">Change Level/School</button>
                        <button class="btn green" data-toggle="modal" href="#add_installment">Add Installment</button>
                        <button class="btn dark" data-toggle="modal" href="#update">Update Total</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="fees" class="table table-bordered col-md-12">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-md" id="add_installment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Installment</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="user">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" autocomplete="off" required> 
                    </div>
                     <div class="col-md-4">
                        <label class="control-label">Amount</label>
                        <input type="text" name="amount" class="form-control" autocomplete="off" required > 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="add_fees" value="Save" class="btn btn-success" />
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bs-modal-md" id="update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Total Fee Amount</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="user">
                        <input type="text" class="form-control" name="total" autocomplete="off" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Save" name="total_fees" />
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-md" id="change_level" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Change Level</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="user">
                        <input type="text" class="form-control" name="level" autocomplete="off" placeholder="enter level" />
                        <p class="school">School Codes for 9th Standard<br/>
                            1 - Fatima High School<br/>
                            2 - Vidya Bhavan<br/>
                            3 - M.D.Bhatia<br/>
                            4 - Holy Family<br/>
                            5 - Gurukul<br/>
                            6 - St.Anthony<br/>
                            7 - Swami Vivekanand<br/>
                            8 - SVDD<br/>
                            9 - Others
                        </p>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Save" name="change_level" />
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(4).addClass('start open active');
    $("table#fees").dataTable({"bFilter": false,"lengthChange": false,"iDisplayLength":-1,});
    $("table#accounts").dataTable({ dom: 'Bfrtip',
        buttons:{
        buttons: [
            {"extend": 'excel',"className": 'btn dark'},
            {"extend": 'print',"className": 'btn green'}
        ]},
         aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: -1,
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
                var level=k.level;
                if(k.class==9){
                    $("p.school").show();
                    if(level==1){level='Fatima High School';}
                    if(level==2){level='Vidya Bhavan';}
                    if(level==3){level='M.D.Bhatia';}
                    if(level==4){level='Holy Family';}
                    if(level==5){level='Gurukul';}
                    if(level==6){level='St.Anthony';}
                    if(level==7){level='Swami Vivekanand';}
                    if(level==8){level='SVDD';}
                    if(level==9){level='Others';}    
                }
                if(k.class==10){$("p.school").hide();}
                $("#level").html(level);
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