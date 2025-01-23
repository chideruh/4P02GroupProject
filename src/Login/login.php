<?php
$email = $_POST['email'];
$password = $_POST['password'];

$con = new mysqli("localhost", "root", "Tsj123456+", "4p02_group_login_db");
if($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    $stmt = $con->prepare("select * from login where email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        if($data['password'] === $password) {
            echo "Login success";
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }
}
?>