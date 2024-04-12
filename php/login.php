



<?php 
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    

    if(!empty($email) && !empty($password)){
        //check user entered email && password matched to database
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");
        

        if(mysqli_num_rows($sql) > 0 ){ //if user credentials matched
            $result = mysqli_fetch_assoc($sql);

            //when user logged out ==? status ==> offline
            //when user logged in ==> again change status to active
            $status =  "Active now";
            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$result['unique_id']} ");

            if($sql2) {
                $_SESSION['unique_id'] = $result['unique_id']; //using session, we used user unique_id to other php file
                echo "success";
            }
          
           
        } else {
            echo "Email or Password is incorrect!";
        }

    }else {
        echo "All input fields are required";
    }
?> 