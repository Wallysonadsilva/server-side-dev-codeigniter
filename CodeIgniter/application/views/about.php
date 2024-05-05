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
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
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
            margin-bottom: 5px;
        }

        .form-box input[type="email"],
        .form-box input[type="text"],
        .form-box input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }

        .form-box button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
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
            height: 50vh;
        }

        .register-login {
            padding: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar" style="background-color: rgba(0, 0, 0, 0.05);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TechQ&A</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="What's Your Question?" aria-label="Seach for">
                <button class="btn btn-secondary" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <div class="container">
        About
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="bg-body-tertiary text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="">TechQ&A.com</a>
        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>