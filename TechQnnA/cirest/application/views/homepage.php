<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>TechQ&A - Homepage</title>
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

        .sidebar {
            margin-top: 20px;
            height: auto;
            overflow-y: auto;
            background-color: #FFA500;
            border-radius: 5px;
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
            padding: 20px;
            width: 25%;
            border-radius: 5px;
            overflow-y: auto;
        }

        .questions-list .list-group-item-action:hover {
            background-color: #FFA500;
            color: white;
            opacity: 0.8;
            text-decoration: none;
        }

        .trending-list .list-group-item-action:hover {
            background-color: #5D3FD3;
            color: white;
            opacity: 0.8;
            text-decoration: none;
        }

        .trending-list .list-group-item-action:hover h5 {
            color: white;
        }

        .btn {
            background-color: #5D3FD3;
        }

        .btn:hover {
            background-color: #45a049;
        }

        #user-name {
            font-weight: bold;
            color: #5D3FD3;
        }

        #menulist {
            font-weight: bold;
            color: #5D3FD3;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('homepage'); ?>" style="font-weight: bold; color:#5D3FD3;">TechQ&A</a>
            <form class="d-flex" id="searchForm">
                <input class="form-control me-2" type="search" id="searchInput" placeholder="Search for questions" aria-label="Search">
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
                            <a href="<?= site_url('homepage'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i>
                                <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('homepage/askquestion'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i>
                                <span class="ms-1 d-none d-sm-inline">Add New Question</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('homepage/about'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i>
                                <span class="ms-1 d-none d-sm-inline">About</span>
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
                            <li><a class="dropdown-item" href="<?= site_url('homepage/profile'); ?>">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= site_url('account/logout'); ?>">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3 min-vh-100">
                <div class="row flex-nowrap">
                    <!-- Computer Science Section -->
                    <div class="question-container">
                        <h2>Computer Science</h2>
                        <div class="list-group questions-list" id="questions-list">
                            <!-- Questions will be populated here by JavaScript -->
                        </div>
                    </div>
                    <!-- Trending Questions Section -->
                    <div class="trending-container">
                        <h3>Trending Questions</h3>
                        <div class="list-group trending-list" id="trending-list">
                            <!-- Trending questions will be populated here by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fetch and display user info
            $.ajax({
                url: "<?= site_url('account/get_user_info'); ?>",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.username) {
                        $('#user-name').text(response.username);
                        console.log('Username fetched:', response.username);
                    } else {
                        window.location.href = '<?= site_url('account/login_register'); ?>';
                    }
                },
                error: function() {
                    alert('Error loading user data');
                }
            });

            // Fetch all questions using REST API
            function fetchQuestions() {
                $.ajax({
                    url: "<?= site_url('api/questions'); ?>",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        displayQuestions(response);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        console.log('XHR:', xhr);
                        alert('Error fetching questions');
                    }
                });
            }

            // Display the questions in the list
            function displayQuestions(questions) {
                var html = '';
                questions.forEach(function(question) {
                    html += '<a href="<?= site_url('questions/view_question/'); ?>' + question.id + '" class="list-group-item list-group-item-action">';
                    html += '<div class="d-flex w-100 justify-content-between">';
                    html += '<h5 class="mb-1">' + question.title + '</h5>';
                    html += '<small>' + question.created_at + '</small>';
                    html += '</div>';
                    html += '<p class="mb-1">' + question.description + '</p>';
                    html += '<div class="d-flex w-100 justify-content-between">';
                    html += '<small>' + question.tags + '</small>';
                    html += '<small>' + question.answer_count + ' answers</small>';
                    html += '</div>';
                    html += '</a>';
                    html += '<br>';
                });
                $('#questions-list').html(html);
            }

            // Fetch trending questions using REST API
            function fetchTrendingQuestions() {
                $.ajax({
                    url: "<?= site_url('api/trending_questions'); ?>",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        displayTrendingQuestions(response);
                    },
                    error: function() {
                        alert('Error fetching trending questions');
                    }
                });
            }

            // Display the trending questions in the list
            function displayTrendingQuestions(questions) {
                var html = '';
                questions.forEach(function(question) {
                    html += '<a href="<?= site_url('questions/view_question/'); ?>' + question.id + '" class="list-group-item list-group-item-action">';
                    html += '<h5 class="mb-1">' + question.title + '</h5>';
                    html += '<small class="text-muted">' + question.like_count + ' likes</small>';
                    html += '</a>';
                    html += '<br>';
                });
                $('#trending-list').html(html); // Update the trending questions list
            }

            // Initial data fetching
            fetchQuestions();
            fetchTrendingQuestions();

            // Search form submission
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var query = $('#searchInput').val(); // Get the search query from the input field

                // Send an AJAX request to the server to fetch search results
                $.ajax({
                    url: '<?= site_url('homepage/search'); ?>',
                    type: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(response) {
                        displayQuestions(response);
                    },
                    error: function() {
                        alert('Error fetching search results');
                    }
                });
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