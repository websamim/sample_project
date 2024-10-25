<?php
    include 'class/class.user.php';
    $user = new USER();

    $user->query("SELECT referral_code FROM users WHERE id = :session_id");
    $user->bind("session_id", $user->sessionID());
    $referal_code = $user->fetchOne()['referral_code'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">

        <title>Refer and Earn</title>
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
                                        <h1>Referal Code </h1>
                                    </div>
                                </div>
                            </div>

                                <div class="col-md-4 text-center m-b-30 ml-auto">
                                <div class="rounded text-white bg-white-translucent">
                                    <div class="p-all-15">
                                        <div class="row">
                                            <div class="col-md-12 my-2 m-md-0">
                                                <div class="text-overline opacity-75">Referal Amount</div>
                                                <h3 class="m-0 text-success">
                                                    <?php 
                                                        echo $user->currency();

                                                        $user->query("SELECT referral_wallet FROM users WHERE id = :session_id");
                                                        $user->bind("session_id", $user->sessionID());
                                                        $sum = $user->fetchOne()['referral_wallet'];
                                                            echo ' '.$sum;

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
                <section class="pull-up">
                    <div class="container">
                        <div class="row ">
                            <div class="col-lg-8 mx-auto  mt-2">
                                <div class="card py-3 m-b-30">
                                    <div class="card-body">
                                            <h3 class="">Referal Code</h3>
                                            <?php $user->get_alert()?>
                                            <div class="form-row">
                                                 <div class="input-group">
                                                    <input type="text" value="<?php echo $user->get_domain().'/register.php?refid='.$referal_code ?>" class="form-control" placeholder="<?php echo $user->get_domain().'/register.php?refid='.$referal_code ?>" id="api">
                                                    <div class="input-group-btn">
                                                      <button class="btn btn-default" id="copy" style="background: blue; color: white;">
                                                        Copy
                                                      </button>
                                                    </div>
                                                  </div>
                                                  <br>
                                                  <br>
                                                  <form action="action/user.action.php" method="post">
                                                    <input type="hidden" name="referal_to_wallet" value="referal_to_wallet">
                                                    <?php
                                                        $user->query("SELECT id FROM ref_transfer_request WHERE user_id = :user_id AND status = :status");
                                                        $user->bind("user_id", $user->sessionId());
                                                        $user->bind("status", "pending");

                                                        if($user->rowCount() > 0){
                                                            echo '<button  class="btn btn-primary" style="background: blue; color: white; cursor: not-allowed;" disabled>Transfer To Wallt</button>';
                                                        }else{
                                                            echo '<button name="submit" name="referal_to_wallet" class="btn btn-primary" style="background: blue; color: white;">Transfer To Wallt</button>';
                                                        }
                                                    ?>
                                                  
                                              </form>
                                            </div>   
                                        <div class="row ">
                                            <div class="col-md-12 p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">Id</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Date Time</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $user->query("SELECT amount, status, dtime FROM ref_transfer_request WHERE user_id = :session_id ORDER BY id DESC");
                                                                $user->bind("session_id", $user->sessionID());
                                                                $i = 1;
                                                                foreach($user->fetchAll() as $row){

                                                                    if($row['status'] == "pending"){
                                                                        $status = '<span class=" text-dark"> <i class="mdi mdi-reload"></i> Pending</span>';
                                                                    }elseif($row['status'] == "transfered"){
                                                                        $status = '<span class=" text-success"> <i class="mdi mdi-check-circle "></i> Approved</span>';
                                                                    }

                                                                    echo '<tr>
                                                                        <td class="align-middle">'.$i.'</td>
                                                                        <td class="align-middle">'.$user->currency().' '.$row['amount'].'</td>
                                                                        <td class="align-middle">'.$status.'</td>
                                                                        <td class="align-middle">'.$user->dateFormat("d/m/Y h:i:s A", $row['dtime']).'</td>
                                                                    </tr>';
                                                                    $i++;
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
                </section>
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

        <script type="text/javascript">
            $("#copy").click(function(){
                $("#api").select();
                document.execCommand('copy');
                $(this).text("Copid");
            });
        </script>
    </body>
</html>