<?php
    include 'class/class.user.php';
    $user = new USER();

    if($user->isLogedin()){
        $user->redirect("index.php");
        exit();
    }

    if(isset($_POST['login'])){
        if($user->isServer()){
                if(isset($_POST['username']) && !empty($_POST['username'])){
                    if(isset($_POST['password']) && !empty($_POST['password'])){
                        $username = $user->escape($_POST['username']);
                        $password = $user->escape($_POST['password']);

                        $user->query("SELECT id, is_active, reason FROM users WHERE MD5(username) = :username AND MD5(password) = :password");
                        $user->bind("username", md5($username));
                        $user->bind("password", md5($password));
                        if($user->rowCount() > 0){
                            $row = $user->fetchOne();
                            if($row["is_active"] == "true"){
                                $user->create_session("user_id", $row['id']);
                                $user->redirect("index.php");
                            }else{
                                $error_msg = $row['reason'];
                            }
                        }else{
                            $error_msg = "Wrong Username or Password!";
                        }
                    }else{
                        $error_msg = "Please enter Password!";
                    }
                }else{
                    $error_msg = "Please enter Username!";
                }
        }else{
            $error_msg = "Can't recognize the request!";
        }
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

        <title>Login</title>
        <link rel="icon" type="image/x-icon" href="assets/img/logo.png"/>
        <link rel="icon" href="assets/img/logo.png" type="image/png" sizes="16x16">
        <link rel='stylesheet' href='assets/vendor/pace/pace.css'/>
        <script src='assets/vendor/pace/pace.min.js'></script>
        <!--vendors-->
        <link rel='stylesheet' type='text/css' href='assets/css/bundles/291bbeead57f19651f311362abe809b67adc3fb5.css'/>
        <link rel='stylesheet' href='assets/css/bundles/dcd1663bd4b40ee5b03564aeb0245515dd3277b0.css'/>
        <link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
        <link rel='stylesheet' href='assets/fonts/jost/jost.css'/>
        <!--Material Icons-->
        <link rel='stylesheet' type='text/css' href='assets/fonts/materialdesignicons/materialdesignicons.min.css'/>
        <!--Bootstrap + atmos Admin CSS-->
        <link rel='stylesheet' type='text/css' href='assets/css/atmos.min.css'/>
        <!-- Additional library for page -->
    </head>
    <body class="jumbo-page">
        <main class="admin-main  ">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-lg-4  bg-white">
                        <div class="row align-items-center m-h-100">
                            <div class="mx-auto col-md-8">
                                <div class="p-b-20 text-center">
                                    <p>
                                        <img src="assets/img/logo.png" width="80" alt="">
                                    </p>
                                    <p class="admin-brand-content">
                                        SOFTNIC FINANCE
                                    </p>
                                </div>
                                <h3 class="text-center p-b-20 fw-400">User Login</h3>
                                <?php
                                    if (isset($error_msg)) {
                                        echo '<div class="alert alert-danger alert-dismissible">
                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                          <strong>'.$error_msg.'</strong>
                                        </div>';
                                    }
                                ?>
                                <form class="needs-validation" action="login.php" method="post">
                                    <div class="form-row">
                                        <div class="form-group floating-label col-md-12">
                                            <label>Username</label>
                                            <input type="text" name="username" required class="form-control">
                                        </div>
                                        <div class="form-group floating-label col-md-12">
                                            <label>Password</label>
                                            <input type="password" name="password" required class="form-control "  >
                                        </div>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary btn-block btn-lg">Login</button>
                                </form>
                                <p class="text-right p-t-10">
                                    <a href="forget_password.php" class="text-underline">Forgot Password?</a> | <a href="register.php" class="text-underline">Don't have nay account?</a>
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
    </body>
</html>