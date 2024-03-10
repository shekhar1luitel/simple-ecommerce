<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../logout.php');
    exit();
}

require('../dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartItemId = $_POST['cart_item_id'];

    try {
        if (isset($_POST['delivery'])) {
            $condition = "WHERE id = $cartItemId";
            $data = array();
            $data = [
                'status' => 'delivering',
            ];
            $update = update('cart_items', $data, $condition);
            $_SESSION['message'] = 'Delivery stage changed successfully.';
            header('Location: ../admin/order.php');
            exit();
        } elseif (isset($_POST['remove'])) {
            $condition = "WHERE id = $cartItemId";
            $delete = delete('cart_items', $condition);
            $_SESSION['message'] = 'Order Removed successfully.';
            header('Location: ../admin/order.php');
            exit();
        }
        header('Location: order.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error: ' . $e->getMessage();
        header('Location: ../admin/order.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Error: ' . $e->getMessage();
    header('Location: ../admin/order.php');
    exit();
}
