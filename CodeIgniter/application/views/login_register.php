<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>Login and Registration</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }

        .navbar {
            padding: 20px 0;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.05);
            color: gray;
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }

        .container {
            display: flex;
            margin-top: -10%;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex: 1;
        }

        .logo,
        .webpage-name {
            margin: 10px;
        }

        .forms-container {
            display: flex;
            justify-content: space-around;
            width: 100%;
        }

        .form-box {
            background-color: #f0f0f0;
            padding: 20px;
            margin: 10px;
            width: 30%;
            border-radius: 5px;
        }

        .form-box form {
            display: flex;
            flex-direction: column;
        }

        .form-box label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            margin-left: 10px;
            color: #5D3FD3;
        }

        .form-box input[type="email"],
        .form-box input[type="text"],
        .form-box input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 40px;
        }

        .form-box button {
            background-color: #5D3FD3;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 40px;
            width: 50%;
            margin: 10px auto;
        }

        .form-box button:hover {
            background-color: #45a049;
        }

        .form-box a {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: blue;
            text-decoration: none;
        }

        .form-box a:hover {
            text-decoration: underline;
        }

        .card-body {
            width: 100vh;
            height: 45vh;
            background-color: #FFA500;
            border-radius: 5px;
        }

        .register-login {
            padding: 10px;
        }

        .webpage-name {
            color: #45a049;
        }

        .register-login {
            color: #5D3FD3;
        }

        .form-control {
            border-radius: 20px;
            text-align: center;
        }

        .btn {
            background-color: #5D3FD3;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <nav class="navbar" style="background-color:  #FFA500;">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('home'); ?>" style="font-weight: bold; color:#45a049;">TechQ&A</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="What's Your Question?" aria-label="Seach for">
                <button class="btn btn-secondary" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="card text-center">
            <div class="card-body">
                <div class="webpage-name">
                    <h1>TechQ&A</h1>
                </div>
                <div class="forms-container">
                    <div class="form-box">
                        <div class="register-login">
                            <h3>Register</h3>
                        </div>
                        <?php if ($this->session->flashdata('register_error')) : ?>
                            <p style="color: red;"><?php echo $this->session->flashdata('register_error'); ?></p>
                        <?php endif; ?>
                        <form action="<?= site_url('account/register') ?>" method="post">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required>
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                            <button type="submit">Sign up</button>
                        </form>
                    </div>
                    <div class="form-box">
                        <div class="register-login">
                            <h3>Login</h3>
                        </div>
                        <?php if (!empty($errors)) : ?>
                            <p style="color: red;"><?= $errors ?></p>
                        <?php endif; ?>
                        <form action="<?= site_url('account/login') ?>" method="post">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" name="email" required>
                            <label for="login-password">Password</label>
                            <input type="password" id="login-password" name="password" required>
                            <button type="submit">Login</button>
                            <a href="/account/forgotpassword">Forgot password?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="bg-body-tertiary text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3">
            © 2024 Copyright:
            <a class="text-body" href="">TechQ&A.com</a>
        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>