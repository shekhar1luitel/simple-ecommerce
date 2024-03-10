<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: logout.php');
    exit();
}

require('../dbconnect.php');

$user_id = $_SESSION['user_id'];
$userDetails = readUserById($user_id);

// Check if the user has admin role
if ($userDetails['role'] != 'admin') {
    header('Location: ../');
    exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id == null || !is_numeric($id)) {
    $_SESSION['error'] = "Invalid user ID.";
    header('Location: ../admin/users.php');
    exit();
}

$GETUser = readUserById($_GET['id']);


if ($GETUser['role'] == 'user') {
    $data = array();
    $data = ['role' => 'admin'];
} elseif ($GETUser['role'] == 'admin') {
    $data = array();
    $data = ['role' => 'user'];
}

$condition = 'where id = ' . $id;
if (update('users', $data, $condition)) {
    $_SESSION['message'] = "User account with ID $id has been updated successfully.";
    header('Location: ../admin/users.php');
    exit();
} else {
    $_SESSION['error'] = "Failed to update user account with ID $id.";
    header('Location: ../admin/users.php');
    exit();
}
?>
