<?php
include'config.php';
include'file.php';
$js='';
if(isset($_POST['email'])){
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $pswd_og=mysqli_real_escape_string($con,$_POST['pswd']);
    $pswd=md5($pswd_og);

    $sql=mysqli_query($con,"select user_id,status from user where email='$email' and pswd='$pswd'");
    $count=mysqli_num_rows($sql);
    if($count==1){
        $a=mysqli_fetch_array($sql,MYSQLI_ASSOC);
        $status=$a['status'];
        if($status=="b"){
            $js='swal({title:"Account Banned!",text:"Please contact admin for more detail.", type:"error"},function(){window.location.href = "./";});';
        }
        else if($status=="n"){
            $js='swal({title:"Account Activation Pending!",text:"Please contact admin for more detail.", type:"error"},function(){window.location.href = "./";});';
        }
        else if($status=="dy"){
            session_start();
            $_SESSION['email']=$email;
            $_SESSION['id']=$a['user_id'];
            header('location:./demo/');
        }
        else{
            session_start();
            $_SESSION['email']=$email;
            $_SESSION['id']=$a['user_id'];
            header('location:./home/');
        }
    }
    else{
        if($email=="admin" && $pswd_og=="admin"){
            session_start();
            $_SESSION['user']=$email;
            $_SESSION['pswd']=$pswd_og;
            header('location:./admin/');
        }
       $js='swal({title:"Error!",text:"Invalid Email and Password Combination.", type:"error"},function(){window.location.href = "./";});'; 
    }

}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>XYZ Tutorials | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?php include_global(0);include_login(0);include_sweetalert(0); ?>
    <style>
    .link{font-size: 14px;text-decoration: underline;color:#333;}
    .link:hover{color:#3598DC;}
    </style>
    </head>
    <body class="login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(assets/pages/img/login/bg1.jpg)">
                        <img class="login-logo" src=" assets/pages/img/login/logo.png" /> </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                    <div class="login-content">
                        <h1>Login Now</h1><br/><br/>
                        <form action="index.php" class="login-form" method="post">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Enter any username and password. </span>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" name="email" required/> </div>
                                <div class="col-md-6 col-xs-12">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="pswd" required/>
                                    <div class="pull-right" style="margin-top:-25px;margin-bottom:30px"><a href="./forgot.php" style="margin-top:-30px">Forgot Password?</a></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 text-left">
                                    <input type="submit" class="btn btn-circle green" name="check" value="Sign In"/>
                                </div>
                                <div class="col-sm-4 text-right" style="text-align:right">
                                    <a href="./register/" class="btn btn-circle text-uppercase" style="font-weight: bold;font-size: 16px;letter-spacing: 1.1px;text-decoration: underline;" >Register now</a>
                                </div>
                            </div>
                        </form>
                        
                       
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset">
                                <ul class="login-social">
                                    <li>
                                        <a href="register/demo">
                                           <span class="link">Sign Up for Demo</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
<script>
$(document).ready(function(){
    <?php echo $js ?>
})
</script>
</html>