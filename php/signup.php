<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){

        //check user email is valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //if email is valid
            //check email alreay exist in database or not
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){ //if email already exists
                echo "$email - This email already exist!";
            }else{
                //check user upload file or not
                if(isset($_FILES['image'])){ //if uploaded
                    $img_name = $_FILES['image']['name']; //get user uploaded img name
                    $img_type = $_FILES['image']['type']; //get type
                    $tmp_name = $_FILES['image']['tmp_name']; //get temporary  name
                    
                    //explode image and get extension 
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode); //here we get extension of user uploaded image
    
                    $extensions = ["jpeg", "png", "jpg"]; //creating array of extension that we permitted
                    if(in_array($img_ext, $extensions) === true){
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time(); //get current time
                            $new_img_name = $time.$img_name; //new img name = current time + name of image user

                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){ //if move upload img to folder successfully
                                $ran_id = rand(time(), 100000000);
                                $status = "Active now";
                              
                                $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");

                                //if data insetted
                                if($sql2){
                                    $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($sql3) > 0){
                                        $result = mysqli_fetch_assoc($sql3);
                                        $_SESSION['unique_id'] = $result['unique_id']; //using session, we used user unique_id to other php file
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>