<?php 
include'../config.php';
include'../file.php';
$prefix='';$start=1;
session_demo($start);
$id=$_SESSION['id'];
$v=mysqli_fetch_array(mysqli_query($con,"select class from user where user_id='$id'"),MYSQLI_ASSOC);



?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
      
        <?php include_global($start);include_theme($start); ?>
         <link href="../assets/pages/css/contact.min.css" rel="stylesheet" type="text/css" />
        <Style>
        .mt-element-ribbon:hover{box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 1px 5px 0 rgba(0,0,0,0.12), 0 3px 1px -2px rgba(0,0,0,0.2);cursor: pointer}
        </Style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <?php include $prefix.'menu.php'; ?>
        <div class="clearfix"> </div>

        <div class="page-container">
            <?php include $prefix.'sidebar.php' ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-12"><h2 class="page-title text-center bold">Upgrade To Pro</h2></div>
                        <div class="col-md-12">
                            <h4 class="bold text-center">Contact Us</h4>
                            <div class="c-content-contact-1 c-opt-1">
                                <div class="row" data-auto-height=".c-height">
                                    <div class="col-lg-8 col-md-6 c-desktop"></div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="c-body">
                                            <div class="c-section">
                                                <h3>XYZ TUTORIALS</h3>
                                            </div>
                                            <div class="c-section">
                                                <div class="c-content-label uppercase bg-dark">Address</div>
                                                <p>B-36, B-wing, A105, A-wing,<br/> 
                                                    Satyam Shopping Centre,<br/> M.G Road,
                                                    Ghatkopar-East.
                                                </p>
                                            </div>
                                            <div class="c-section">
                                                <div class="c-content-label uppercase bg-dark">Contacts</div>
                                                <p>
                                                    <strong>T</strong> +91 9820033103
                                                    <br/>
                                            </div>
                                            <div class="c-section">
                                                <div class="c-content-label uppercase bg-dark">Social</div>
                                                <br/>
                                                <ul class="c-content-iconlist-1 ">
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-twitter"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-facebook"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-linkedin"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <iframe id="gmapbg" class="c-content-contact-1-gmap" style="height: 615px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d942.6839687643242!2d72.9023548291514!3d19.075346999193023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c6263cb14b19%3A0x24eba07b311da230!2sSatyam+Shopping+Center!5e0!3m2!1sen!2sin!4v1501141724972"></iframe>
                            </div>
 
                        </div>

                    </div>
                </div>
            </div>
        </div>         
    </body>
<script>
$(document).ready(function(){
    $(".page-sidebar>ul>li").eq(0).addClass('start open active');
})
</script>


</html>