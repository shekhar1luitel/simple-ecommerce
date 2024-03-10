<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../logout.php');
    exit();
}
require('../dbconnect.php');

$user_id = $_SESSION['user_id'];
$userDetails = readUserById($user_id);
if ($userDetails['role'] != 'admin') {
    header('Location: /');
}
$allProduct = readAll('products');

$query = "SELECT products.*, users.email FROM products LEFT JOIN users ON products.user_id = users.id";
$allProduct = sql($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="../style.css" />
    <title>ADMIN Fashion</title>
    <style>
        .container {
            margin: 2%;
            border: 2px dashed #333;
            border-radius: 4%;
            padding: 2%;
        }

        .header {
            background-color: #aaa;
            padding: 1%;
            border-radius: 3px;
        }

        .header h2 {
            text-align: center;
            text-shadow: 1px 3px 8px #0b1544;
        }

        table {
            width: 100%;
            /* border-collapse: collapse; */
        }

        table tr td {
            text-align: center;
        }

        body {
            background-color: whitesmoke;
        }

        .mt {
            margin-top: 5px;
        }

        th,
        tr,
        table {
            border: 1px solid black;
        }

        td {
            border: 1px solid grey;
        }

        .btn-red {
            display: inline-block;
            padding: 8px 16px;
            margin-top: 10px;
            background-color: red;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-green {
            display: inline-block;
            padding: 8px 16px;
            margin-top: 10px;
            background-color: greenyellow;
            color: #000;
            text-decoration: none;
            border-radius: 4px;
        }

        .fa-plus {
            position: relative;
            bottom: 22px;
            left: 18px;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <h1>ADMIN FASHION</h1>
            </div>
            <ul class="list-items">
                <li><a href="users.php" class="link">USERS</a></li>
                <li><a href="product.php" class="link">PRODUCTS</a></li>
                <li><a href="order.php" class="link">ORDER</a></li>
            </ul>

            <div class="nav-btns">
                <a href="../logout.php" class="btn-nav-i"><i class="fas fa-sign-out-alt"></i></a>
                <a href="../" class="btn-nav-i"><i class="fas fa-house-user"></i></a>
            </div>
        </nav>
        <div class="main mt" style="height:100%;">
            <div class="container">
                <div class="header">
                    <h2> User Store</h2>
                    <a href="productCreate.php" class="btn-nav-i"><i class="fa fa-plus"></i></a>
                </div>
                <div class="content">
                    <?php if (isset($_SESSION['message'])) {
                        $message = $_SESSION['message'];
                    ?>

                        <p style="color: white; background-color:red;"><?= $message ?></p>

                    <?php
                        unset($_SESSION['message']);
                    }
                    ?>
                    <table>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($allProduct as $data) : ?>
                            <tr>
                                <td><?= $data['title'] ?></td>
                                <td>
                                    <?= truncateText($data['description'], 50) ?>
                                </td>
                                <td><img src="../product_image/<?= $data['image'] ?>" alt="product-image" style="height:110px;"></td>
                                <td><?= $data['price'] ?></td>
                                <td><?= $data['email'] ?></td>
                                <td>
                                    <a href="productDelete.php?id=<?= $data['id'] ?>"><button class="btn-red"> Delete </button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </header>
</body>


</html>