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

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id == null) {
    $_SESSION['message'] = "Invalid product ID.";
    header('Location: ../admin/product.php');
    exit();
}

$condition = 'where id = ' . $id;
$productDetails = read('products', $condition);
$imageFileName = $productDetails['image'];
$imageFilePath = '../product_image/' . $imageFileName;
    if (file_exists($imageFilePath)) {
        unlink($imageFilePath);
    }
if (delete('products', $condition)) {
    $_SESSION['message'] = "Product with ID $id has been deleted successfully.";
    header('Location: ../admin/product.php');
    exit();
} else {
    $_SESSION['message'] = "Failed to delete product. Please try again.";
    header('Location: ../admin/product.php');
    exit();
}
?>
