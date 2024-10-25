<?php
    include 'class/class.user.php';
    $user = new USER();

    $user_info = $user->user_data("users", $user->sessionID());
    if(!empty($user_info['profile_pic'])){
        $dp = "img/profile_pictures/".$user_info['profile_pic'];
    }else{
        $dp = 'https://www.w3schools.com/howto/img_avatar.png';
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
        <title>Users</title>
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
    <body class="sidebar-pinned ">
        <?php include 'inc/header.php'; ?>
            <!--site header ends -->    
            <section class="admin-content">
                <div class="bg-dark m-b-30">
                    <div class="container">
                        <div class="row p-b-60 p-t-60">
                            <div class="col-md-6 text-white p-b-30">
                                <div class="media">
                                    <div class="avatar mr-3  avatar-xl">
                                        <img src="<?php echo $dp; ?>" alt="Profile picture" class="avatar-img rounded-circle">
                                    </div>
                                    <div class="media-body m-auto">
                                        <h5 class="mt-0"><?php echo $user_info['fname'] . " " . $user_info['lname']; ?></h5>
                                        <div class="opacity-75">@<?php echo $user_info['username']; ?> | <?php echo $user->dateFormat("d/m/Y h:i:s A", $user_info['dtime']); ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 text-center m-b-30 ml-auto">
                                <div class="rounded text-white bg-white-translucent">
                                    <div class="p-all-15">
                                        <div class="row">
                                            <div class="col-md-12 my-2 m-md-0">
                                                <div class="text-overline opacity-75">Balance</div>
                                                <h3 class="m-0 text-success"><?php echo $user->currency(); ?> 
                                                    <?php echo $user_info['wallet']; ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="container pull-up">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Single post-->
                            <div class="card m-b-30">
                                <div class="card-header">
                                    <div class="media">
                                        <div class="media-body m-auto">
                                            <h5 class="m-0"> General Information </h5>

                                        </div>
                                    </div>
                                    <div class="card-controls">
                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon mdi  mdi-dots-vertical"></i> </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item" type="button"  data-toggle="modal" data-target="#editProfile" style="cursor: pointer;">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-raw">
                                    <div class="col-lg-12">
                                        <?php echo $user->get_alert(); ?>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-hover ">
                                            <tbody>
                                                <tr><th>Firstname</th><td><?php echo $user_info['fname']; ?></td></tr>
                                                <tr><th>Lastname</th><td><?php echo $user_info['lname']; ?></td></tr>
                                                <tr><th>Usrename</th><td><?php echo $user_info['username']; ?></td></tr>
                                                <tr><th>E-mail</th><td><?php echo $user_info['email']; ?></td></tr>
                                                <tr><th>Phone</th><td><?php echo $user_info['phone']; ?></td></tr>
                                                <tr><th>Address</th><td><?php echo $user_info['address']; ?></td></tr>
                                                <tr><th>Status</th><td><?php echo ($user_info['is_active'] == "true") ? '<span class=" text-success"> <i class="mdi mdi-check-circle "></i> Active</span>': '<span class=" text-danger"> <i class="mdi mdi-close"></i> Deactive</span>'; ?></td></tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    
                            
                                    <!-- / .row -->
                                </div>
                            </div>
                            <!-- Single post-->



                            

                            




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
                            <div class="list-group list  ">
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="m-r-20">
                                        <div class="avatar avatar-sm "><img class="avatar-img rounded-circle"   src="assets/img/users/user-3.jpg" alt="user-image"></div>
                                    </div>
                                    <div class="">
                                        <div class="name">Eric Chen</div>
                                        <div class="text-muted">Developer</div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="m-r-20">
                                        <div class="avatar avatar-sm "><img class="avatar-img rounded-circle"
                                            src="assets/img/users/user-4.jpg" alt="user-image"></div>
                                    </div>
                                    <div class="">
                                        <div class="name">Sean Valdez</div>
                                        <div class="text-muted">Marketing</div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="m-r-20">
                                        <div class="avatar avatar-sm "><img class="avatar-img rounded-circle"
                                            src="assets/img/users/user-8.jpg" alt="user-image"></div>
                                    </div>
                                    <div class="">
                                        <div class="name">Marie Arnold</div>
                                        <div class="text-muted">Developer</div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="m-r-20">
                                        <div class="avatar avatar-sm ">
                                            <div class="avatar-title bg-dark rounded"><i class="mdi mdi-24px mdi-file-pdf"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="name">SRS Document</div>
                                        <div class="text-muted">25.5 Mb</div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="m-r-20">
                                        <div class="avatar avatar-sm ">
                                            <div class="avatar-title bg-dark rounded"><i
                                                class="mdi mdi-24px mdi-file-document-box"></i></div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="name">Design Guide.pdf</div>
                                        <div class="text-muted">9 Mb</div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="m-r-20">
                                        <div class="avatar avatar-sm ">
                                            <div class="avatar avatar-sm  ">
                                                <div class="avatar-title bg-primary rounded"><i
                                                    class="mdi mdi-24px mdi-code-braces"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="name">response.json</div>
                                        <div class="text-muted">15 Kb</div>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex  align-items-center">
                                    <div class="m-r-20">
                                        <div class="avatar avatar-sm ">
                                            <div class="avatar avatar-sm ">
                                                <div class="avatar-title bg-info rounded"><i
                                                    class="mdi mdi-24px mdi-file-excel"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="name">June Accounts.xls</div>
                                        <div class="text-muted">6 Mb</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="editProfile" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-align-top-left" role="document">
                <div class="modal-content">
                    <form method="post" action="action/user.action.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Profile picture</label>
                                <input type="file" name="profile_pic" class="form-control" placeholder="Firstname">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Firstname</label>
                                <input type="text" name="fname" value="<?php echo $user_info['fname']; ?>" class="form-control" placeholder="Firstname">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Lastname</label>
                                <input type="text" name="lname" value="<?php echo $user_info['lname']; ?>" class="form-control" placeholder="Lastname">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Phone</label>
                                <input type="tel" name="phone" value="<?php echo $user_info['phone']; ?>" class="form-control" placeholder="Phone">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Address</label>
                                <textarea name="address" class="form-control" placeholder="Address"><?php echo $user_info['address']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" name="updateUser" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <script src='assets/js/bundles/9556cd6744b0b19628598270bd385082cda6a269.js'></script>
        <!--page specific scripts for demo-->
        <script>
            $('.remInvoice').on('click', function(event){
                var conf = confirm('Are you sure?');

                if (!conf) {
                    event.preventDefault();
                }
            });
        </script>
    </body>
</html>