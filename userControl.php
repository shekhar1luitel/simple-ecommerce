<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: logout.php');
    exit();
}

require('dbconnect.php');

$user_id = $_SESSION['user_id'];
$user = readUserById($user_id);
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'update' button is clicked
    if (isset($_POST['update'])) {
        handleUpdateProfile($user_id);
    }
    // Check if the 'delete' button is clicked
    elseif (isset($_POST['delete'])) {
        handleDeleteAccount();
    }
}

function handleUpdateProfile($user_id)
{
    $newPassword = $_POST['password'];
    $newEmail = $_POST['email'];

    $userDetail = readUserById($user_id);

    if (!empty($newEmail) && $newEmail !== $userDetail['email']) {
        // Check if the new email already exists in the database
        $existingUser = read('users', "WHERE email = '$newEmail' AND id != $user_id");

        if (empty($existingUser)) {
            $data = ['email' => $newEmail];

            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the new password
                $data['password'] = $hashedPassword;
            }

            $condition = "WHERE id = $user_id";

            if (update('users', $data, $condition)) {
                header('Location: /user.php');
                exit();
            } else {
                $error = "Failed to update profile. Please try again.";
                $_SESSION['message'] = $error;
                header('Location: /user.php');
                exit();
            }
        } else {
            $error = "Email already exists. Please try again with a different email.";
            $_SESSION['message'] = $error;
            header('Location: /user.php');
            exit();
        }
    } elseif (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the new password
        $data = ['password' => $hashedPassword];
        $condition = "WHERE id = $user_id";

        if (update('users', $data, $condition)) {
            header('Location: /user.php');
            exit();
        } else {
            $error = "Failed to update profile. Please try again.";
            $_SESSION['message'] = $error;
            header('Location: /user.php');
            exit();
        }
    }
    $error = "Failed to update profile. Please try again.";
    $_SESSION['message'] = $error;
    header('Location: /user.php');
    exit();
}

function handleDeleteAccount()
{
    $user_id = $_SESSION['user_id'];

    // Delete the user account from the database
    $condition = 'where id = ' . $user_id;
    if (delete('users', $condition)) {
        header('Location: logout.php');
        exit();
    } else {
        $error = "Failed to delete account. Please try again.";
        $_SESSION['message'] = $error;
        header('Location: /user.php');
        exit();
    }
}
