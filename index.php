

<?php 
  session_start();
  if(isset($_SESSION['unique_id'])) { //nếu user đã log in  ==> redirect to users page
      header("location: users.php");
  }
?>



<?php 
    include_once "header.php";
?>
    <div class="wrapper">
        <section class="form signup">
            <header>Realtime Chat App</header>
            <form action="#" enctype="multipart/form-data">
                <div class="error-txt"></div>
                <div class="name-details">
                      <div class="field input">
                        <label>First Name</label>
                        <input name="fname" type="text" placeholder="First Name" required>
                      </div>  
                      <div class="field input">
                        <label>Last Name</label>
                        <input name="lname" type="text" placeholder="Last Name" required>
                      </div>  
                    </div>
                      <div class="field input">
                        <label>Email Address</label>
                        <input name="email" type="text" placeholder="Enter your email" required>
                      </div>  
                      <div class="field input">
                        <label>Password</label>
                        <input name="password" type="password" placeholder="Enter new password" required>
                        <i class="fas fa-eye"></i>
                      </div>  
                      <div class="field image">
                        <label>Select Image</label>
                        <input name="image" type="file" required>
                      </div>  
                      <div class="field button">
                        <input type="submit" value="Continue to Chat">
                      </div>
            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>

    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>
</body>
</html>