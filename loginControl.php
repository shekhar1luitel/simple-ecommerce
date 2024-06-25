<?php
require('dbconnect.php');
session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $condition = "WHERE email = '" . $email . "'";
    $userData = read('users', $condition);
    
    if (!empty($userData) && password_verify($password, $userData['password'])) {
        $_SESSION['user_id'] = $userData['id'];
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['message'] = 'Invalid email or password';
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Fill the login form';
    header('Location: login.php');
    exit();
}
