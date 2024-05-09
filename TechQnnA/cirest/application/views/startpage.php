<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>TechQ&A</title>
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
            background-color: #FFA500;
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex: 1;
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
            width: 80vh;
            background-color: #FFA500;
            border-radius: 5px;
            padding: 20px;
        }

        .register-login {
            padding: 10px;
            color: #5D3FD3;
        }

        .form-control {
            border-radius: 20px;
            text-align: center;
        }

        .alert {
            margin: 10px;
            display: none;
        }

        .webpage-name {
            color: #5D3FD3;
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
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('homepage'); ?>" style="font-weight: bold; color:#5D3FD3;">TechQ&A</a>
            <form class="d-flex" id="searchForm">
                <input class="form-control me-2" type="search" id="searchInput" placeholder="Search for questions" aria-label="Search">
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
                        <form id="register-form" action="javascript:void(0);">
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
                        <form id="login-form" action="javascript:void(0);">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" name="email" required>
                            <label for="login-password">Password</label>
                            <input type="password" id="login-password" name="password" required>
                            <button type="submit">Login</button>
                            <a href="">Forgot password?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert" id="alert"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Display alert messages
            function showAlert(message, type = 'danger') {
                $('#alert').removeClass('alert-success alert-danger').addClass(`alert-${type}`).html(message).show();
                setTimeout(function() {
                    $('#alert').fadeOut();
                }, 5000); // Hide after 5 seconds
            }

            // Registration form
            $('#register-form').on('submit', function() {
                $.ajax({
                    url: "<?= site_url('auth/register'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: $('#email').val(),
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert(response.message, 'success');
                            $('#register-form')[0].reset();
                        } else {
                            showAlert(response.message);
                        }
                    },
                    error: function() {
                        showAlert('Error during registration. Please try again.');
                    }
                });
            });

            // Login form
            $('#login-form').on('submit', function() {
                $.ajax({
                    url: "<?= site_url('auth/login'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        email: $('#login-email').val(),
                        password: $('#login-password').val()
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = response.redirect;
                        } else {
                            showAlert(response.message);
                        }
                    },
                    error: function() {
                        showAlert('Error loggin in. Please try again.');
                    }
                });
            });

            //Search bar feature, it Checks if user is logged checking for session before the search
            $('#searchForm').submit(function(e) {
                if (!<?= $this->session->userdata('user_id') ? 'true' : 'false' ?>) {
                    e.preventDefault();
                    showAlert('Please login first.');
                }
            });
        });
    </script>

    <footer class="bg-body-tertiary text-center text-lg-start">
        <div class="text-center p-3">
            © 2024 Copyright:
            <a class="text-body" href="">TechQ&A.com</a>
        </div>
    </footer>
</body>

</html>