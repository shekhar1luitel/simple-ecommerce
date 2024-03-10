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
if ($userDetails['role'] != 'admin') {
    header('Location: ../');
}

$userDetails = readUserById($user_id);

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id == null) {
    $_SESSION['error'] = "Invalid user ID.";
    header('Location: ../admin/users.php');
    exit();
}

$condition = 'where id = ' . $id;

if (delete('users', $condition)) {

    if ($id == $_SESSION['user_id']) {
        $_SESSION['error'] = "Your account has been deleted successfully. You have been logged out.";
        header('Location: ../logout.php');
        exit();
    } else {
        $_SESSION['error'] = "User account with ID $id has been deleted successfully.";
        header('Location: ../admin/users.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Failed to delete account. Please try again.";
    header('Location: ../admin/users.php');
    exit();
}
?>
