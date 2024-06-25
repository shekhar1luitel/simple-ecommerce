<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: logout.php');
    exit();
}
require('dbconnect.php');

$user_id = $_SESSION['user_id'];
$sql = "select count(*) from cart_items where user_id = $user_id ";
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
        .contact-info h2,
.contact-form h2 {
    margin-top: 50px;
    color :pink;
}

.contact-info p {
    color: #666;
}

.contact-details {
    margin-top: 20px;
}

.contact-detail {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.contact-detail i {
    margin-right: 10px;
    color: #333;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.contact-form textarea {
    height: 150px;
}

.contact-form button {
    background-color: #333;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
}

.contact-form button:hover {
    background-color: #555;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .nav-btns {
        display: none;
    }
    .list-items {
        display: none;
    }
    .main {
        flex-direction: column;
    }
    .main-left,
    .main-right {
        width: 100%;
        margin-bottom: 20px;
    }
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
        <div class="main" style="height:100%;">
            <div class="main-left">
                <div class="social-media">
                    <a href="#" class="s-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="s-btn"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="s-btn"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="banner">
                    <div class="f-text">
                        <h1>
                            FASHION
                            <br />
                            <span>MADE</span>
                            <br />
                            SIMPLE.
                        </h1>
                    </div>
                    <a href="#" class="btn">SHOP NOW</a>
                </div>
            </div>
            <div class="main-right">
            <div class="contact-info">
                <h2>Contact Us</h2>
                <p>We'd love to hear from you. Send us a message and we'll get back to you as soon as possible.</p>
                <div class="contact-details">
                    <div class="contact-detail">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Kathmandu, Lalitpur</p>
                    </div>
                    <div class="contact-detail">
                        <i class="fas fa-envelope"></i>
                        <p>hirashrestha886@gmail.com</p>
                    </div>
                    <div class="contact-detail">
                        <i class="fas fa-phone-alt"></i>
                        <p>9845208597</p>
                    </div>
                </div>
                <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="contact_process.php" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button class="btn" type="submit">Send Message</button>
                </form>
            </div>
            </div>
        </div>
    </header>
</body>


</html>
