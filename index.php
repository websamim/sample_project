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

        <title>Title here</title>
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
                <div class="bg-dark ">
                    <div class="container-fluid m-b-30">
                        <div class="row">
                            <div class="text-white col-lg-8">
                                <div class="p-all-15">
                                    <div class="text-overline m-t-10 opacity-75">
                                        Your Total Sell Amount
                                    </div>
                                    <div class="d-md-flex m-t-20 align-items-center">
                                        <div class="avatar avatar-lg my-auto mr-2">
                                            <div class="avatar-title bg-warning rounded-circle">
                                                <?php echo $user->currency(); ?></i>
                                            </div>
                                        </div>
                                        <h1 class="display-4">
                                                    <?php 
                                                        echo $user->currency();
                                                        $user->query("SELECT SUM(amount) as amnt FROM deposit WHERE status = 'approved' AND user_id = :session_id");
                                                        $user->bind("session_id", $user->sessionID());
                                                        $sum = $user->fetchOne()['amnt'];
                                                        if($sum > 0){
                                                            echo ' '.$sum;
                                                        }else{
                                                            echo ' 0.00';
                                                        }
                                                    ?>
                                        </h1>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-12 p-b-60">
                                <div id="chart-09" class="chart-canvas invert-colors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row d-none  pull-up d-lg-flex">
                        <div class="col m-b-30">
                            <div class="card ">
                                <div class="card-body">
                                    
                                    <div class="text-center p-t-30 p-b-20">
                                        <div class="text-overline text-muted opacity-75">Deposit</div>
                                        <h1 class="text-success">
                                            <?php 
                                                echo $user->currency();
                                                $user->query("SELECT SUM(amount) as amnt FROM deposit WHERE status = 'approved' AND user_id = :session_id");
                                                $user->bind("session_id", $user->sessionID());
                                                $sum = $user->fetchOne()['amnt'];
                                                if($sum > 0){
                                                    echo ' '.$sum;
                                                }else{
                                                    echo ' 0.00';
                                                }
                                            ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col m-b-30">
                            <div class="card ">
                                <div class="card-body">
                                    
                                    <div class="text-center p-t-30 p-b-20">
                                        <div class="text-overline text-muted opacity-75">Withdrawal</div>
                                        <h1 class="text-danger">
                                                    <?php 
                                                        echo $user->currency();

                                                        $user->query("SELECT SUM(amount) as amnt FROM withdrawal WHERE status = 'approved' AND user_id = :session_id");
                                                        $user->bind("session_id", $user->sessionID());
                                                        $sum = $user->fetchOne()['amnt'];
                                                        if($sum > 0){
                                                            echo ' '.$sum;
                                                        }else{
                                                            echo ' 0.00';
                                                        }
                                                    ?>
                                        </h1>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col m-b-30">
                            <div class="card ">
                                <div class="card-body">
                                    
                                    <div class="text-center p-t-30 p-b-20">
                                        <div class="text-overline text-muted opacity-75">Matured Amount</div>
                                        <h1 class="text-danger">
                                                    <?php 
                                                        echo $user->currency();

                                                        $user->query("SELECT SUM(amount) as amnt FROM investments WHERE is_completed = 'released' AND user_id = :session_id");
                                                        $user->bind("session_id", $user->sessionID());
                                                        $sum = $user->fetchOne()['amnt'];
                                                        if($sum > 0){
                                                            echo ' '.$sum;
                                                        }else{
                                                            echo ' 0.00';
                                                        }
                                                    ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col m-b-30">
                            <div class="card ">
                                <div class="card-body">
                                    
                                    <div class="text-center p-t-30 p-b-20">
                                        <div class="text-overline text-muted opacity-75">Investment</div>
                                        <h1 class="text-danger">
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
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col m-b-30">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="card-controls">
                                        <a href="#" class="badge badge-soft-success"> <i class="mdi mdi-arrow-up"></i> 65 %</a>
                                    </div>
                                    <div class="text-center p-t-30 p-b-20">
                                        <div class="text-overline text-muted opacity-75">
                                            ripple
                                        </div>
                                        <h1 class="text-success">$ 14,540</h1>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col m-b-30">
                            <div class="card ">
                                <div class="card-body">
                                    
                                    <div class="text-center p-t-30 p-b-20">
                                        <div class="text-overline text-muted opacity-75">Wallet Transfer</div>
                                        <h1 class="text-danger">
                                                    <?php 
                                                        echo $user->currency();
                                                        $user->query("SELECT SUM(amount) as amnt FROM transfer_wallet WHERE status = 'approved' AND from_id = :from_id");
                                                        $user->bind("from_id", $user->sessionID());
                                                        $sum = $user->fetchOne()['amnt'];
                                                        if($sum > 0){
                                                            echo ' '.$sum;
                                                        }else{
                                                            echo ' 0.00';
                                                        }
                                                    ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-lg-6 m-b-30">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Pending Deposit</div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Time</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $user->query("SELECT amount, status, dtime FROM deposit WHERE status = 'pending' AND user_id = :session_id ORDER BY id DESC");
                                                $user->bind("session_id", $user->sessionID());
                                                $i = 1;
                                                foreach($user->fetchAll() as $row){
                                                    echo '<tr>
                                                        <td class="align-middle">'.$i.'</td>
                                                        <td class="align-middle">'.$user->currency().' '.$row['amount'].'</td>
                                                        <td class="align-middle"><span class=" text-dark"> <i class="mdi mdi-reload"></i> Pending</span></td>
                                                        <td class="align-middle">'.$user->dateFormat("d/m/Y h:i:s A", $row['dtime']).'</td>
                                                         <td class="text-center align-middle">
                                                            <a class="btn btn-primary btn-sm" href="deposit.php">View</a>
                                                        </td>
                                                    </tr>';
                                                    $i++;
                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 m-b-30">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Pending Withdrawal</div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm ">
                                        <thead>
                                            <tr>
                                                <th>Avatar</th>
                                                <th>E-mail</th>
                                                <th>Amount</th>
                                                <th>Time</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $user->query("SELECT amount, status, dtime FROM withdrawal WHERE status = 'pending' AND user_id = :session_id ORDER BY id DESC");
                                                $user->bind("session_id", $user->sessionID());
                                                $i = 1;
                                                foreach($user->fetchAll() as $row){
                                                    echo '<tr>
                                                        <td class="align-middle">'.$i.'</td>
                                                        <td class="align-middle">'.$user->currency().' '.$row['amount'].'</td>
                                                        <td class="align-middle"><span class=" text-dark"> <i class="mdi mdi-reload"></i> Pending</span></td>
                                                        <td class="align-middle">'.$user->dateFormat("d/m/Y h:i:s A", $row['dtime']).'</td>
                                                         <td class="text-center align-middle">
                                                            <a class="btn btn-primary btn-sm" href="withdrawal.php">View</a>
                                                        </td>
                                                    </tr>';
                                                    $i++;
                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
        <?php
            $days = array();
            $amount_arr = array();
            for ($i=1; $i <= date('d'); $i++) { 
                $days[] = date($i.'-M-Y');
                $date = date('Y-m-'.$i);

              $user->query("SELECT SUM(amount) AS amount FROM deposit WHERE user_id = :user_id AND DATE(dtime) = :dtime");
              $user->bind("user_id", $user->sessionID());
              $user->bind("dtime", $date);
              $amnt = $user->fetchOne();
              if($amnt['amount'] > 0){
                $amount = $amnt['amount'];
              }else{
                $amount = "0.00";
              }
                $amount_arr[] = $amount;
            }

        ?>
        <script src='assets/js/bundles/9556cd6744b0b19628598270bd385082cda6a269.js'></script>
        <!--page specific scripts for demo-->
        <!--Additional Page includes-->
        <script src='assets/vendor/apexchart/apexcharts.min.js'></script>
        <!--chart data for current dashboard-->
        <script>
            (function($) {
                "use strict";
                if($("#chart-09").length) {
                    var options= {
                        chart: {
                            height:350, type:"area", animations: {
                                enabled: true
                            }
                        }
                        , colors:"#fff", dataLabels: {
                            enabled: false
                        }
                        , stroke: {
                            colors: ["#fff"], curve: "straight", width: 3
                        }
                        , series:[ {
                            name: "Amount", data: <?php echo $user->json($amount_arr); ?>
                        }
                        ], grid: {
                            borderColor: "rgba(255,225,255,0.2)", strokeDashArray: "3"
                        }
                        , labels:<?php echo $user->json($days); ?>, xaxis: {
                            type: "datetime"
                        }
                        , yaxis: {}
                        , legend: {
                            horizontalAlign: "left"
                        }
                    }
                    ;
                    var chart=new ApexCharts(document.querySelector("#chart-09"), options);
                    chart.render()
                }
            }

            )(window.jQuery);
        </script>

    </body>
</html>