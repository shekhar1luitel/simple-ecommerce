<?php
require('dbconnect.php');
session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $condition = "WHERE email = '" . $email . "'";
    $userData = readAll('users', $condition);

    if (empty($userData)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $data = [
            'email' => $email,
            'password' => $hashedPassword, // Store the hashed password
            'name' => $name,
            'age' => $age,
            'contact' => $contact,
            'gender' => $gender,
        ];
        $createUser = create('users', $data);

        if ($createUser) {
            $condition = "WHERE email = '".$email."'";
            $loginUser = read('users', $condition);
            $_SESSION['user_id'] = $loginUser['id'];
            header('Location: dashboard.php');
            exit();
        } else {
            $_SESSION['message'] = 'Register Failed';
            header('Location: register.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Email already exists';
        header('Location: register.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Fill the form';
    header('Location: register.php');
    exit();
}
