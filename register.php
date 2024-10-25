<?php
    include 'class/class.user.php';
    $user = new USER();

    if(isset($_GET['refid']) && !empty($_GET['refid']) ){
        $refer_input = '<input type="hidden" name="referal_code" class="form-control" value="'.$user->escape($_GET['refid']).'">';
    }else{
        $refer_input = '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta content="" name="author"/>
<meta content="atlas is Bootstrap 4 based admin panel.It comes with 100's widgets,charts and icons" name="description"/>
<meta property="og:locale" content="en_US"/>
<meta property="og:type" content="website"/>
<meta property="og:title"
      content="atlas is Bootstrap 4 based admin panel.It comes with 100's widgets,charts and icons"/>
<meta property="og:description"
      content="atlas is Bootstrap 4 based admin panel.It comes with 100's widgets,charts and icons"/>
<meta property="og:image"
      content="https://cdn.dribbble.com/users/180706/screenshots/5424805/the_sceens_-_mobile_perspective_mockup_3_-_by_tranmautritam.jpg"/>
<meta property="og:site_name" content="atlas "/>
<title>Atmos Admin Panel- Bootstrap 4 Based Admin Panel</title>
<link rel="icon" type="image/x-icon" href="assets/img/logo.png"/>
<link rel="icon" href="assets/img/logo.png" type="image/png" sizes="16x16">
<link rel='stylesheet' href='https://d33wubrfki0l68.cloudfront.net/css/478ccdc1892151837f9e7163badb055b8a1833a5/light/assets/vendor/pace/pace.css'/>
<script src='https://d33wubrfki0l68.cloudfront.net/js/3d1965f9e8e63c62b671967aafcad6603deec90c/jquery/pace.min.js'></script>
<!--vendors-->
<link rel='stylesheet' type='text/css' href='https://d33wubrfki0l68.cloudfront.net/bundles/291bbeead57f19651f311362abe809b67adc3fb5.css'/>

<link rel='stylesheet' href='https://d33wubrfki0l68.cloudfront.net/bundles/fc681442cee6ccf717f33ccc57ebf17a4e0792e1.css'/>



<link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
<link rel='stylesheet' href='https://d33wubrfki0l68.cloudfront.net/css/04cc97dcdd1c8f6e5b9420845f0fac26b54dab84/default/assets/fonts/jost/jost.css'/>
<!--Material Icons-->
<link rel='stylesheet' type='text/css' href='https://d33wubrfki0l68.cloudfront.net/css/548117a22d5d22545a0ab2dddf8940a2e32c04ed/default/assets/fonts/materialdesignicons/materialdesignicons.min.css'/>
<!--Bootstrap + atmos Admin CSS-->
<link rel='stylesheet' type='text/css' href='https://d33wubrfki0l68.cloudfront.net/css/ed18bd005cf8b05f329fad0688d122e0515499ff/default/assets/css/atmos.min.css'/>
<!-- Additional library for page -->

</head>
<body class="jumbo-page">

<main class="admin-main  ">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-4  bg-white">
                <div class="row align-items-center m-h-100">
                    <div class="mx-auto col-md-8">
                        <form class="needs-validation" action="action/register.action.php" method="POST">
                            <div class="p-b-20 text-center">
                                <p>
                                    <img src="assets/img/logo.svg" width="80" alt="">

                                </p>
                                <p class="admin-brand-content">
                                    atmos
                                </p>
                            </div>
                            <h3 class="text-center p-b-20 fw-400">Register</h3>
                            <?php echo $user->get_alert(); ?>
                            <div class="form-row">

                                <div class="form-group floating-label col-md-12">
                                    <label>Email</label>
                                    <input type="email" name="email" required class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group floating-label col-md-12">
                                    <label>Username</label>
                                    <input type="text" name="username" required class="form-control" placeholder="Username">
                                </div>

                                <div class="form-group floating-label col-md-12">
                                    <label>Phone</label>
                                    <input type="text" name="phone" required class="form-control" placeholder="Mobile no">
                                </div>

                                <div class="form-group floating-label col-md-12">
                                    <label>Password</label>
                                    <input type="password" name="password" required class="form-control " id="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group floating-label">
                                <label>Password Again</label>
                                <input type="password" name="con_password" class="form-control" required id="confirm_password" placeholder="Password Again">
                            </div>
                            <div class="form-row">
                                <div class="form-group floating-label col-md-6">
                                    <label>Firstname</label>
                                    <input type="text" name="fname" class="form-control" placeholder="Fisrtname">
                                </div>

                                <div class="form-group floating-label col-md-6">
                                    <label>Lastname</label>
                                    <input type="text" name="lname" class="form-control" placeholder="Lastname">
                                </div>
                            </div>
                            <div class="form-group floating-label">
                                <label>Address</label>
                                <textarea class="form-control" name="address" rows="6" placeholder="Address"></textarea>
                            </div>
                            <?php echo $refer_input; ?>

  <!--                           <p class="">
                                <label class="cstm-switch">
                                    <input type="checkbox" checked name="option" value="1" class="cstm-switch-input">
                                    <span class="cstm-switch-indicator "></span>
                                    <span class="cstm-switch-description">  I agree to the Terms and Privacy. </span>
                                </label>


                            </p> -->

                            <button type="submit" name="register" class="btn btn-primary btn-block btn-lg">Create Account</button>

                        </form>
                        <p class="text-right p-t-10">
                            <a href="login.php" class="text-underline">Already a user?</a>
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 d-none d-md-block bg-cover" style="background-image: url('assets/img/login.jpg');">

            </div>
        </div>
    </div>
</main>


<script src='assets/js/bundles/9556cd6744b0b19628598270bd385082cda6a269.js'></script>
<!--page specific scripts for demo-->
</html>