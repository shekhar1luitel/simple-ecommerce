<?php
require('dbconnect.php');
session_start();
if (isset($_POST['email']) and isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $condition = "where email = '" . $email . "'";
    $userData = readAll('users', $condition);

    if (empty($userData)) { // email uniqe xa ki nai
        // print_r( $userData);
        $data = [
            'email' => $email,
            'password' => $password,
        ];
        $createUser = create('users', $data);

        if ($createUser) {
            $condition = "where email = '".$email."'";
            $loginUser = read('users', $condition);
            $_SESSION['user_id'] = $loginUser['id'];
            header('Location: dashboard.php');
            exit();
        } else {
            $_SESSION['message'] = 'Register Failed ';
            header('Location: register.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Enter Valid Email';
        echo $_SESSION['message'];
        header('Location: register.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Fill the form';
    header('Location: register.php');
    exit();
}
