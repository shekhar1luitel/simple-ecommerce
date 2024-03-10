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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for product creation
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $contact = $_POST['contact'];

    // Validate input as needed

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "../product_image/";
        $imageFileName = uniqid('product_' . time()) . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $imageFileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Check if the image file is a actual image or fake image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['error'] = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES['image']['size'] > 500000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk === 1) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $_SESSION['message'] = "The file " . htmlspecialchars(basename($_FILES['image']['name'])) . " has been uploaded.";
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Proceed with product creation if image upload is successful or not required
    $data = [
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'contact' => $contact,
        'user_id' => $user_id,
        'image' => $imageFileName // Save the image filename in the database
    ];

    if (create('products', $data)) {
        $_SESSION['success'] = "Product created successfully.";
        header('Location: product.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to create product. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here -->
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

        table tr td {
            text-align: center;
        }

        body {
            background-color: whitesmoke;
        }

        .mt {
            margin-top: 5px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
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

        button {
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        p {
            color: white;
            background-color: red;
            padding: 10px;
            border-radius: 4px;
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
            <?php if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
            ?>

                <p style="color: white; background-color:red;"><?= $message ?></p>

            <?php
                unset($_SESSION['message']);
            }
            ?>
            <?php if (isset($_SESSION['error'])) {
                $error = $_SESSION['error'];
            ?>

                <p style="color: white; background-color:red;"><?= $error ?></p>

            <?php
                unset($_SESSION['error']);
            }
            ?>
            <div class="container">
                <form method="post" action="" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" name="title" required>

                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea>

                    <label for="price">Price:</label>
                    <input type="number" name="price" required>

                    <label for="price">Contact:</label>
                    <input type="number" name="contact" required>

                    <label for="image">Image:</label>
                    <input type="file" name="image" accept="image/*" required>

                    <button type="submit">Create Product</button>
                </form>
            </div>
        </div>
    </header>
</body>

</html>