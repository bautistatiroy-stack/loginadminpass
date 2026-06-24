<?php
session_start();

// Admin username + HASHED password
$ADMIN_USERNAME = "admin";
$ADMIN_PASSWORD_HASH = '$2y$10$llKVZoBuo9Zcr0XNyHR3R.8BDSyuxYWxg0xcWu7MKmnlqQOtHyT2y';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if (
        $username === $ADMIN_USERNAME &&
        password_verify($password, $ADMIN_PASSWORD_HASH)
    ) {
        $_SESSION["login"] = true;

        // redirect after login
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid login details";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>
        body{
            font-family: Arial;
            background: #f2f2f2;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .box{
            background:white;
            padding:30px;
            width:320px;
            border-radius:10px;
            box-shadow:0 0 15px rgba(0,0,0,0.2);
        }

        input{
            width:100%;
            padding:10px;
            margin:8px 0;
        }

        button{
            width:100%;
            padding:10px;
            background:#007bff;
            color:white;
            border:none;
            cursor:pointer;
        }

        .error{
            color:red;
            text-align:center;
        }
    </style>
</head>
<body>

<div class="box">

    <h2 style="text-align:center;">Admin Login</h2>

    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    </form>

</div>

</body>
</html>