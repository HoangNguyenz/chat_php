

<?php
session_start();
include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];

//lấy tất cả  user trừ user hiện tại 
$sql  = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id}");
$output = "";

if (mysqli_num_rows($sql) == 1) {
    $output .= "No users are available to chat"; //if one row in database ==> just a current user ==> no other users to chat with
} elseif (mysqli_num_rows($sql) > 0) {
    include "data.php"; //search user code
}
echo $output;
?>