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
            background-color: #FFA500;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.05);
            color: gray;
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }

        h2,
        h3,
        h5 {
            color: #5D3FD3;
            font-weight: bolder;
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

        .card-body {
            width: 100vh;
            height: 50vh;
        }

        .register-login {
            padding: 10px;
        }

        #user-name {
            font-weight: bold;
            color: #5D3FD3;
        }

        #menulist {
            font-weight: bold;
            color: #5D3FD3;
        }

        .btn {
            background-color: #5D3FD3;
        }

        .btn:hover {
            background-color: #45a049;
        }


        .sidebar {
            margin-top: 20px;
            height: auto;
            overflow-y: auto;
            background-color: #FFA500;
        }

        .sidebar a {
            color: white;
        }

        .sidebar a:hover {
            color: #5D3FD3;
        }


        .question-container {
            background-color: #f0f0f0;
            padding: 20px;
            margin: 10px auto;
            width: 65%;
            border-radius: 5px;
        }

        .trending-container {
            background-color: #FFA500;
            margin: 10px auto;
            padding: 20PX;
            width: 25%;
            border-radius: 5px;
        }


        /* Hover effect for the questions list */
        .questions-list .list-group-item-action:hover {
            background-color: #FFA500;
            /* Example color */
            color: white;
            opacity: 0.8;
            text-decoration: none;
        }

        /* Hover effect for the trending questions list */
        .trending-list .list-group-item-action:hover {
            background-color: #5D3FD3;
            color: white;
            opacity: 0.8;
            text-decoration: none;
        }

        .trending-list .list-group-item-action:hover h5 {
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('home'); ?>" style="font-weight: bold; color:#5D3FD3;">TechQ&A</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="What's Your Question?" aria-label="Seach for">
                <button class="btn btn-secondary" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
                <div class="sidebar d-flex flex-column align-items-center align-items-sm-start px-3 pt-2">
                    <span class="fs-5 d-none d-sm-inline" id="menulist">Menu</span>

                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="<?= site_url('home'); ?>" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href=" <?= site_url('askquestion'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Question ?</span></a>
                        </li>
                        <li>
                            <a href="<?= site_url('about'); ?>" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">About</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('contact'); ?>" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Contact</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.shutterstock.com/image-vector/default-avatar-profile-icon-social-600nw-1677509740.jpg" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1" id="user-name">User Name</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= site_url('account/logout'); ?>">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3 min-vh-100">
                <!-- Start of the main content area -->
                <div class="row flex-nowrap">
                    <!-- Computer Science Section -->
                    <div class="question-container">
                        <h2>Computer Science</h2>
                        <div class="list-group questions-list">
                            <!-- Loop through each question and display -->
                            <?php foreach ($questions as $question) : ?>
                                <a href="<?= site_url('questions/view_question/' . $question->id); ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><?= htmlspecialchars($question->title); ?></h5>
                                        <small><?= date('F j, Y', strtotime($question->created_at)); ?></small>
                                    </div>
                                    <p class="mb-1"><?= nl2br(htmlspecialchars($question->description)); ?></p>
                                    <div class="d-flex w-100 justify-content-between">
                                        <small class="text-muted"><?= htmlspecialchars($question->tags); ?></small>
                                        <small class="text-muted"><?= $question->answer_count; ?> answers</small>
                                    </div>
                                </a>
                                <br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Trending Questions Section -->
                    <div class="trending-container">
                        <h3>Trending Questions</h3>
                        <div class="list-group trending-list">
                            <?php foreach ($trending_questions as $question) : ?>
                                <a href="<?= site_url('questions/view_question/' . $question->id); ?>" class="list-group-item list-group-item-action">
                                    <h5 class="mb-1"><?= htmlspecialchars($question->title); ?></h5>
                                    <small class="text-muted"><?= $question->like_count; ?> likes</small>
                                </a>
                                <br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- End of the main content area -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Your Custom Script -->
    <script>
        $(document).ready(function() {
            // Your AJAX code to fetch user data
            $.ajax({
                url: "<?= site_url('account/get_user_info'); ?>",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.username) {
                        $('#user-name').text(response.username);
                        console.log('Username fetched:', response.username);
                    } else {
                        $('#user-name').text('Guest');
                    }
                },
                error: function() {
                    alert('Error loading user data');
                }
            });
        });
    </script>

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