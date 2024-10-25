<?php
    include 'class/class.user.php';
    $user = new USER();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">

        <title>Reset Password</title>
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
    <body class="sidebar-pinned">

        <?php include 'inc/header.php'; ?>
            <!--site header ends -->    
            <section class="admin-content">

                <div class="bg-dark">
                    <div class="container  m-b-30">
                        <div class="row">
                            <div class="col-12 text-white p-t-40 p-b-90">
                                <h4 class="">  Reset Password</h4>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="container pull-up">
                    <div class="row">
                        <div class="col-lg-12">


                            <form method="post" action="action/user.action.php">
                                <!--widget card begin-->
                                <div class="card m-b-30">
                                    <div class="card-header">
                                        <h5 class="m-b-0">
                                            Forms
                                        </h5>

                                    </div>
                                    <div class="card-body col-lg-6">
                                        <?php echo $user->get_alert(); ?>
                                        <div class="form-group">
                                            <label for="inputAddress">Old Password</label>
                                            <input type="password" name="oldPassword" class="form-control" id="inputAddress" placeholder="Old Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress2">New Password</label>
                                            <input type="password" name="newPassword" class="form-control" id="inputAddress2" placeholder="New Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress2">Confirm Password</label>
                                            <input type="password" name="confPassword" class="form-control" id="inputAddress2" placeholder="Confirm Password" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" name="resetPassword">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>      
                            
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <div class="modal modal-slide-left  fade" id="siteSearchModal" tabindex="-1" role="dialog" aria-labelledby="siteSearchModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-all-0" id="site-search">
                        <button type="button" class="close light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="form-dark bg-dark text-white p-t-60 p-b-20 bg-dots" >
                            <h3 class="text-uppercase    text-center  fw-300 "> Search</h3>
                            <div class="container-fluid">
                                <div class="col-md-10 p-t-10 m-auto">
                                    <input type="search" placeholder="Search Something"
                                        class=" search form-control form-control-lg">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="bg-dark text-muted container-fluid p-b-10 text-center text-overline">
                                results
                            </div>
                            <div class="list-group list">  
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src='assets/js/bundles/9556cd6744b0b19628598270bd385082cda6a269.js'></script>
        <!--page specific scripts for demo-->
    </body>
</html>