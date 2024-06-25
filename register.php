<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: rgba(43, 43, 91, 0.5);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
            text-align: center;
        }

        .login-form h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .login-form input {
            width: 96%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form select {
            width: 98.7%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form option {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form button {
            background-color: #253346;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #132432;
        }
        

        .login-form p {
            font-size: 14px;
            color: #213145;
            cursor: pointer;
        }

        a:link {
            text-decoration: none;

        }

        a:visited {
            color: white;
        }

        .mt-2 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form class="login-form" action="../registerControl.php" method="post">
            <h1>Register</h1>
            <?php
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
            ?>

                <p style="color: white; background-color:red;"><?= $message ?></p>

            <?php
                unset($_SESSION['message']);
            }
            ?>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="age" placeholder="Age" required>
            <input type="text" name="contact" placeholder="Contact" required>
            <select name="gender" id="">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <div class="mt-2">
                <span><a href="../login.php">Already have an account?</a></span>
            </div>
        </form>
    </div>
</body>

</html>
