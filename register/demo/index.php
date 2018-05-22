<?php
include'../../config.php';
include'../../file.php';
$js='';
if(isset($_POST['register'])){
   $name=mysqli_real_escape_string($con,$_POST['name']);
   $email=mysqli_real_escape_string($con,$_POST['email']);
   $pswd=mysqli_real_escape_string($con,$_POST['pswd']);
   $contact=mysqli_real_escape_string($con,$_POST['contact']);
   $parent=mysqli_real_escape_string($con,$_POST['parent']);
   $class=mysqli_real_escape_string($con,$_POST['class']);
   $pswd=md5($pswd);

   $sql=mysqli_query($con,"select user_id from user where email='$email' ");
   if((mysqli_num_rows($sql))==1){
        $js='swal({title:"Email Already Registered!",text:"Please Use Other Email Account.", type:"error"},function(){window.location.href = "../demo/";});'; 
   }
   else{
        mysqli_query($con,"insert into user (name,email,pswd,contact,parent,class,status) values 
        ('$name','$email','$pswd','$contact','$parent','$class','d')");
      $js='swal({title:"Account Setup Complete!",text:"Your Account will be activated within 24 hrs.", type:"success"},function(){window.location.href = "../../";});';
    }
}


?>

<!DOCTYPE html>

<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>XYZ Tutorials | Register</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        
        <?php include_global(2);include_login(2);include_sweetalert(2); ?>
    </head>
    <body class=" login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(../../assets/pages/img/login/bg1.jpg)">
                        <img class="login-logo" src="../../assets/pages/img/login/logo.png" /> </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                    <div class="login-content">
                        <h1>Register <small class="font-blue-oleo">Demo Series</small></h1>
                        
                        <form action="" class="login-form" method="post">
                            <div class="row">
                                <div class="col-xs-12">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Full Name" name="name" maxlength="100" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="email" autocomplete="off" placeholder="Email" name="email" maxlength="150" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="pswd" maxlength="100" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" pattern="[0-9]{10,11}" maxlength="11" placeholder="Personal Contact Number" name="contact" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" pattern="[0-9]{10,11}" maxlength="11" placeholder="Parent Contact Number" name="parent" required/> </div>    
                                <div class="col-xs-12">
                                    <label>Class</label>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="class" value="9" checked /> 9<sup>th</sup> Standard&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="class" value="10"/> 10<sup>th</sup> Standard
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    
                                </div>
                                <div class="col-sm-8 text-right">
                                    <button class="btn green" type="submit" name="register">Sign Up</button>
                                </div>
                            </div>
                        </form>
                       
                    </div>
                   
                </div>
            </div>
        </div>
<script src="main.js"></script>
<script>
$(document).ready(function(){
    <?php echo $js ?>

})
$(document).ready(function(){
    $('.login-bg').backstretch([
                "../../assets/pages/img/login/bg1.jpg",
                "../../assets/pages/img/login/bg2.jpg",
                "../../assets/pages/img/login/bg3.jpg"
                ], {
                  fade: 1000,
                  duration: 8000
                }
            );
})
</script>
</body>

</html>