<?php
    $username = $_POST['username'];
    $password = $_POST['password'];
//    $username = "tom";
//    $password = "12345";

    $con = new mysqli("localhost", "root", "Tsj123456+", "4p02_group_login_db");
    if($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    } else {
        $stmt = $con->prepare("select * from login where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            if($data['password'] === $password) {
                echo "Login success";
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "Invalid username or password";
        }
    }
?>