

<?php
    session_start();

    //user da login thi moi duoc logout
    if(isset($_SESSION['unique_id'])) {
        include_once "config.php";

        //lay logout_id tren url
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);

        if(isset($logout_id)) { //if logout id is set
            $status = "Offline now";

            //when user logout ==> update status to offline 
            //and in the login form ==> update again status to active now if user logged in successfully
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id} ");
            
            if($sql) {
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }


        } else {
            header("location: ../login.php");
        }

    } else {
        header("location: ../login.php");
    }
?>