<?php
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
    exit();
}

if (strlen($password) <= 6) {
    echo "<script>alert('Password must be greater than 6 characters.'); window.history.back();</script>";
    exit();
}

if (!preg_match('/[A-Z]/', $password)) {
    echo "<script>alert('Password must contain at least one uppercase letter.'); window.history.back();</script>";
    exit();
}

$con = new mysqli("localhost", "root", "Tsj123456+", "4p02_group_login_db");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    $stmt = $con->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if ($stmt_result->num_rows > 0) {
        echo "Username already exists.";
    } else {
        $stmt = $con->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            header("Location: ../Login/index.html");
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
