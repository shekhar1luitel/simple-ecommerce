<?php
session_start();
require('dbconnect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: logout.php');
    exit();
}
$user_id = $_SESSION['user_id'];
// $condition = "where user_id =" . $user_id . "";

$condition = "SELECT cart_items.*, products.title, products.description, products.image, products.price, users.email
FROM cart_items
JOIN products ON cart_items.product_id = products.id
JOIN users ON cart_items.user_id = users.id
WHERE cart_items.user_id = $user_id";
$cartProduct = sql($condition);

$sql = "select count(*) from cart_items where user_id = $user_id";
$count = sql($sql);
$count = $count[0]['count(*)'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Fashion</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .product {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            text-align: center;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        input,
        textarea,
        button,
        select {
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>


<body>
    <header>
        <nav>
            <div class="logo">
                <h1>FASHION</h1>
            </div>
            <ul class="list-items">
                <li><a href="/dashboard.php" class="link">HOME</a></li>
                <li><a href="collection.php" class="link">COLLECTION</a></li>
                <li><a href="./contact.php" class="link">CONTACT US</a></li>
                <li><a href="./about.php" class="link">ABOUT US</a></li>
            </ul>

            <div class="nav-btns">
                <a href="logout.php" class="btn-nav-i"><i class="fas fa-sign-out-alt"></i></a>
                <a href="cart.php" class="btn-nav-i"><i class="fas fa-cart-plus"><span><?=$count?></span></i></a>
                <a href="user.php" class="btn-nav-i"><i class="fas fa-user"></i></a>
            </div>
        </nav>
        <div class="main">
        <?php if (isset($_SESSION['message'])) {
                        $message = $_SESSION['message'];
                    ?>

                        <p style="color: white; background-color:red;"><?= $message ?></p>

                    <?php
                        unset($_SESSION['message']);
                    }
                    ?>
            <hr>
            <h1 style="text-align: center">Cart</h1>
            <hr>
            <div class="row">
                <!-- Product items with Add to Cart button -->
                <?php foreach ($cartProduct as $data) : ?>
                    <?php if ($data['status'] === 'in_cart') : ?>
                        <div class="product">
                            <h2><?= $data['title'] ?></h2>
                            <!-- <p><?= $data['description'] ?></p> -->
                            <img class="img" src="/product_image/<?= $data['image'] ?>" alt="">
                            <p>Quantity: 2</p>
                            <p>Price: RS<?= $data['price'] ?></p>
                            <a href="/product.php?product=<?= $data['product_id'] ?>">
                                <button><i class="fas fa-eye"></i> View</button>
                            </a>
                            <form action="update_cart.php" method="post">
                                <input type="hidden" name="cart_item" value="<?= $data['id'] ?>">
                                <button type="submit" name="remove_item"><i class="fas fa-trash"></i> Remove</button>
                                <button type="submit" name="order_item"><i class="fas fa-shopping-cart"></i> Order</button>
                                <input type="text" name="client_contact" placeholder="Order Contact" value="">
                            </form>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        <hr>
        <h1 style="text-align: center">Order</h1>
        <hr>
        <div class="row">
            <?php foreach ($cartProduct as $data) : ?>
                <?php if ($data['status'] === 'ordered' || $data['status'] === 'delivering' ) : ?>
                    <div class="product">

                        <h2><?= $data['title'] ?></h2>
                        <!-- <p><?= $data['description'] ?></p> -->
                        <img class="img" src="/product_image/<?= $data['image'] ?>" alt="">
                        <p>Quantity: <?= $data['quantity'] ?></p>
                        <p>Price: RS <?= $data['price'] ?></p>
                        <p>Total Price: RS <?= $data['quantity'] * $data['price'] ?></p>
                        <a href="/product.php?product=<?= $data['product_id'] ?>">
                            <button><i class="fas fa-eye"></i> View</button>
                        </a>
                        <?php if($data['status'] === 'delivering' ){?>
                            <button><i class="fas fa-cart-plus"></i> Delivering</button>
                            
                        <?php }else{?>
                        <form action="update_cart.php" method="post">
                            <input type="hidden" name="cart_item" value="<?= $data['id'] ?>">
                            <button type="submit" name="remove_item"><i class="fas fa-trash"></i> Remove</button>
                        </form>
                        <?php } ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </header>
</body>

</html>
