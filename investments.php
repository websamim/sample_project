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
            <section class="admin-content ">
                <div class="bg-dark m-b-30">
                    <div class="container">
                        <div class="row p-b-60 p-t-60">
                            <div class="col-md-6 text-white p-b-30">
                                <div class="media">
                                    <div class="avatar avatar mr-3">
                                        <div class="avatar-title bg-success rounded-circle mdi mdi-currency-inr">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h1>Investments </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center m-b-30 ml-auto">
                                <div class="rounded text-white bg-white-translucent">
                                    <div class="p-all-15">
                                        <div class="row">
                                            <div class="col-md-12 my-2 m-md-0">
                                                <div class="text-overline opacity-75">Total Investments</div>
                                                <h3 class="m-0 text-success">
                                                    <?php 
                                                        echo $user->currency();

                                                        $user->query("SELECT SUM(amount) as amnt FROM investments WHERE  user_id = :session_id");
                                                        $user->bind("session_id", $user->sessionID());
                                                        $sum = $user->fetchOne()['amnt'];
                                                        if($sum > 0){
                                                            echo ' '.$sum;
                                                        }else{
                                                            echo ' 0.00';
                                                        }
                                                    ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="pull-up">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row m-b-20">
                                            <div class="col-md-6 my-auto">
                                                <a href="javascript:void(0);" class="btn btn-lg m-b-15 mr-2 btn-outline-dark" data-toggle="modal" data-target="#newPayment"> <i class="mdi mdi-plus"></i> Fix Deposit</a>
                                            </div>
                                            <div class="col-md-12 p-0">
                                                <?php echo $user->get_alert(); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row ">
                                            <div class="col-md-12 p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">Id</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Commision %</th>
                                                                <th scope="col">Days</th>
                                                                <th scope="col">Maturity</th>
                                                                <th scope="col">Date Time</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $user->query("SELECT amount, commision, days, is_completed, dtime FROM investments WHERE user_id = :session_id ORDER BY id DESC");
                                                                $user->bind("session_id", $user->sessionID());
                                                                $i = 1;
                                                                foreach($user->fetchAll() as $row) {
                                                                    $expiry = $user->expiry_date("+".$row['days']. "days", $row['dtime']);
                                                                    $day_to_expire = $user->total_day($expiry);
                                                                    if($row['is_completed'] == "released"){
                                                                        $maturity = '<span class=" text-danger"> <i class="mdi mdi-close"></i> Released</span>';
                                                                    }else{
                                                                        if($day_to_expire < 1){
                                                                             $maturity = '<span class=" text-success"> <i class="mdi mdi-check-circle "></i> Completed</span>';
                                                                        }else{
                                                                            $maturity = '<span class=" text-dark"> <i class="mdi mdi-reload"></i> Processing</span>';
                                                                        }
                                                                    }

                                                                    $exp = ($day_to_expire <= 0) ? "0" : $day_to_expire;

                
                                                                    echo '<tr>
                                                                        <td class="align-middle">'.$i.'</td>
                                                                        <td class="align-middle">'.$user->currency().' '.$row['amount'].'</td>
                                                                        <td class="align-middle">'.$row['commision'].'</td>
                                                                        <td class="align-middle">Wihin '.$exp.' days</td>

                                                                        <td class="align-middle">'.$maturity.'</td>
                                                                        <td class="align-middle">'.$user->dateFormat("d/m/Y h:i:s A", $row['dtime']).'</td>
                                                                    </tr>';
                                                                }
                                                            ?>
                                                                
                                                            
                                                            

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-auto ml-auto">
                                                <div>
                                                    <nav class="">
                                                        <ul class="pagination">
                                                            <?php
                                                                /*if (isset($_GET['page'])) {
                                                                    unset($_GET['page']);
                                                                }

                                                                if ($page->previous_page>0) {
                                                                    echo '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$page->previous_page.'" tabindex="-1">Previous</a></li>';
                                                                }else{
                                                                    echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a></li>';
                                                                }


                                                                for($i = 4; $i >= 1; $i--){
                                                                    $n = $page->page-$i;
                                                                    if ($n > 0) {
                                                                        echo '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$n.'">'.$n.'</a></li>';
                                                                    }
                                                                }
                                                                echo '<li class="page-item active"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$page->page.'">'.$page->page.'</a></li>';

                                                                for($i = 1; $i <= 4; $i++){
                                                                    $n = $page->page+$i;
                                                                    if ($n<=$page->total_page) {
                                                                        echo '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$n.'">'.$n.'</a></li>';
                                                                    }
                                                                }

                                                                if ($page->next_page<=$page->total_page) {
                                                                    echo'<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$page->next_page.'">Next</a></li>';
                                                                }else{
                                                                    echo'<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
                                                                }*/

                                                            ?>
                                                        
                                                            
                                                        </ul>
                                                    </nav>
                                                    <?php
                                                        // echo'<div class="col-md-12">';
                                                        //     echo 'Showing 1 to 100 of 450 entries';
                                                        // echo '</div>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>


        <!-- Modal -->
        <div class="modal fade" id="newPayment" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-align-top-left" role="document">
                <div class="modal-content">
                    <form method="post" action="action/user.action.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Make a Investment</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="">Amount</label>
                                    <input type="text" name="amount" class="form-control" placeholder="Enter amount" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" name="fixedDeposit" class="btn btn-primary">Deposit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

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