<?php
include_once "php/config.php";

// Kiểm tra xác thực người dùng và lấy thông tin người dùng từ CSDL
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
}

$user_id = $_SESSION['unique_id'];
$query = "SELECT * FROM users WHERE unique_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "User not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_password'])) {
        // Xử lý cập nhật mật khẩu
    } elseif (isset($_FILES['new_image']) && isset($_FILES['new_image']['tmp_name']) && $_FILES['new_image']['tmp_name'] != '') {
        // Xử lý tải lên hình ảnh mới
    } elseif (isset($_POST['new_fname']) && isset($_POST['new_lname'])) {
        // Xử lý cập nhật fname và lname
        $new_fname = $_POST['new_fname'];
        $new_lname = $_POST['new_lname'];

        $update_query = "UPDATE users SET fname = '$new_fname', lname = '$new_lname' WHERE unique_id = $user_id";
        if (mysqli_query($conn, $update_query)) {
            echo "<div class='success'>Tên đã được cập nhật thành công.</div>";
            // Cập nhật lại thông tin người dùng sau khi cập nhật
            $query = "SELECT * FROM users WHERE unique_id = $user_id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
            }
        } else {
            echo "<div class='error'>Đã xảy ra lỗi khi cập nhật tên.</div>";
        }
    }
}
// Xử lý khi form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_password'])) {
        // Xử lý cập nhật mật khẩu
    } elseif (isset($_FILES['new_image']) && isset($_FILES['new_image']['tmp_name']) && $_FILES['new_image']['tmp_name'] != '') {
        // Xử lý tải lên hình ảnh mới
        $target_dir = "php/images/";
        $target_file = $target_dir . basename($_FILES["new_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra kích thước tệp
        if ($_FILES["new_image"]["size"] > 500000) {
            echo "Xin lỗi, tệp của bạn quá lớn.";
            $uploadOk = 0;
        }

        // Cho phép một số định dạng hình ảnh nhất định
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Xin lỗi, chỉ các tệp JPG, JPEG, PNG & GIF được phép.";
            $uploadOk = 0;
        }

        // Kiểm tra xem $uploadOk có được đặt thành 0 không bởi lỗi
        if ($uploadOk == 0) {
            echo "Xin lỗi, tệp của bạn không được tải lên.";
        } else {
            // Nếu mọi thứ đều ổn, cố gắng tải lên tệp
            if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
                // Cập nhật đường dẫn hình ảnh trong CSDL
                $update_query = "UPDATE users SET img = '$target_file' WHERE unique_id = $user_id";
                if (mysqli_query($conn, $update_query)) {
                    echo "<div class='success'>Hình ảnh đã được cập nhật thành công.</div>";
                } else {
                    echo "<div class='error'>Đã xảy ra lỗi khi cập nhật hình ảnh.</div>";
                }
            } else {
                echo "Xin lỗi, đã xảy ra lỗi khi tải tệp của bạn lên máy chủ.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <!-- Link CSS của Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh CSS */
        .form-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Thông tin người dùng</h2>
        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong>Tên:</strong> <?php echo $user_data['fname'] . " " . $user_data['lname']; ?></p>
            </div>
        </div>

        <!-- Form cập nhật tên -->
        <div class="row form-container mt-3">
            <div class="col-md-6">
                <button class="btn btn-primary" id="changeNameBtn">Thay đổi tên</button>
                <form id="nameForm" method="post" style="display: none;">
                    <div class="form-group">
                        <label for="new_fname">Tên mới:</label>
                        <input type="text" class="form-control" id="new_fname" name="new_fname" required>
                    </div>
                    <div class="form-group">
                        <label for="new_lname">Họ mới:</label>
                        <input type="text" class="form-control" id="new_lname" name="new_lname" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>

        <!-- Các form và nút button khác -->
        <div class="row form-container mt-3">
            <div class="col-md-6">
                <button class="btn btn-primary" id="changePasswordBtn">Thay đổi mật khẩu</button>
                <form id="passwordForm" method="post" style="display: none;">
                    <div class="form-group">
                        <label for="old_password">Mật khẩu cũ:</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Mật khẩu mới:</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                </form>
            </div>
        </div>

        <div class="row form-container mt-3">
            <div class="col-md-6">
                <button class="btn btn-primary" id="changeImageBtn">Thay đổi hình ảnh</button>
                <form id="imageForm" method="post" enctype="multipart/form-data" style="display: none;">
                    <div class="form-group">
                        <label for="new_image">Chọn hình ảnh mới:</label>
                        <input type="file" class="form-control-file" id="new_image" name="new_image" required accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật hình ảnh</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script để hiển thị form cập nhật tên khi click button -->
    <script>
        document.getElementById("changePasswordBtn").addEventListener("click", function() {
            document.getElementById("passwordForm").style.display = "block";
        });

        document.getElementById("changeImageBtn").addEventListener("click", function() {
            document.getElementById("imageForm").style.display = "block";
        });

        document.getElementById("changeNameBtn").addEventListener("click", function() {
            document.getElementById("nameForm").style.display = "block";
        });
    </script>

    <!-- Link tới các file script của Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>