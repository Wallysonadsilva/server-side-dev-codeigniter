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

        #user-name {
            font-weight: bold;
            color: #5D3FD3;
        }

        #menulist {
            font-weight: bold;
            color: #5D3FD3;
        }

        .sidebar {
            margin-top: 20px;
            height: auto;
            overflow-y: auto;
            background-color: #FFA500;
            border-radius: 5px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            color: #5D3FD3;
        }

        .textarea-answer {
            width: 100%;
            height: 100px;
            resize: none;
        }



        .btn-answer {
            padding: 10px 20px;
            background-color: #5D3FD3;
            color: white;
            border: none;
            cursor: pointer;
            width: 40%;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .btn-answer:hover,
        .btn:hover {
            background-color: #45a049;
        }

        #questionDesc {
            width: 100%;
            height: 100px;
            resize: none;
        }


        .list-group-item {
            margin-bottom: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
        }

        .question-container {
            background-color: #f0f0f0;
            /* Light background for the form */
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            /* Space between this section and others */
        }

        .question-container form {
            margin-top: 10px;
        }

        .question-container label {
            font-weight: bold;
        }


        .list-group-item-action:hover {
            background-color: #5D3FD3;
            /* Light grey background on hover */
            color: white;
            /* Darker text color for better contrast */
            text-decoration: none;
            /* Optional: Removes underline from links */
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('home'); ?>" style="font-weight: bold; color:#5D3FD3;">TechQ&A</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="What's Your Question?" aria-label="Search for">
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
                            <a href="<?= site_url('home'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('askquestion'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Question?</span></a>
                        </li>
                        <li>
                            <a href="<?= site_url('about'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">About</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('contact'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Contact</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.shutterstock.com/image-vector/default-avatar-profile-icon-social-600nw-1677509740.jpg" alt="User" width="30" height="30" class="rounded-circle">
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
                <div class="question-container">
                    <h3>Ask a Question</h3>
                    <form action="<?= site_url('submit_question'); ?>" method="post">
                        <div class="mb-3">
                            <label for="questionTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="questionTitle" name="title" placeholder="Enter the title of your question" required>
                        </div>
                        <div class="mb-3">
                            <label for="questionDesc" class="form-label">Description</label>
                            <textarea class="form-control" id="questionDesc" name="description" rows="3" placeholder="Describe your question" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="questionTags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="questionTags" name="tags" placeholder="Add tags (e.g., java, python)">
                        </div>
                        <div class="btn-container">
                            <button type="submit" class="btn btn-primary btn-answer">Submit Question</button>
                        </div>
                    </form>
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
        <div class="text-center p-3">
            © 2024 Copyright:
            <a class="text-body" href="">TechQ&A.com</a>
        </div>
    </footer>
</body>

</html>