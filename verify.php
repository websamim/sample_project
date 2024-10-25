<?php
    include 'class/class.user.php';
    $user = new USER();
    if(isset($_GET['auth']) && !empty($_GET['auth']) && isset($_GET['token']) && !empty($_GET['token'])){
        $auth = $user->escape($_GET['auth']);
        $token = $user->escape($_GET['token']);
        $user->query("SELECT reg_id FROM register_verify WHERE MD5(id) = :id AND token = :token");
        $user->bind("id", $auth);
        $user->bind("token", $token);
        if($user->rowCount() > 0){
            $update_id = $user->fetchOne()['reg_id'];
            $user->query("UPDATE users SET reason = '', is_active = 'true' WHERE id = :id");
            $user->bind("id", $update_id);
            if($user->execute()){
                $user->query("DELETE FROM register_verify WHERE MD5(id) = :id AND token = :token");
                $user->bind("id", $auth);
                $user->bind("token", $token);
                if($user->execute()){
                    echo "<center><h2>Email verified successfully</h2><br><a href='login.php'>Login Now</a></center>";
                }
            }
        }else{
            echo "Wrong Auth or Token";
        }

    }else{
        echo "Missing Auth or Token!";
    }
?>
