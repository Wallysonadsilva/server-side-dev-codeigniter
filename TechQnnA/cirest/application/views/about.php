<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>About TechQ&A</title>
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
            border-radius: 5px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
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
            max-height: 550px;
            background-color: #FFA500;
            margin: 10px auto;
            padding: 20px;
            width: 25%;
            border-radius: 5px;
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
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('home'); ?>" style="font-weight: bold; color:#5D3FD3;">TechQ&A</a>
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
                            <a href="<?= site_url('homepage/index'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('homepage/askquestion'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Add New Question</span></a>
                        </li>
                        <li>
                            <a href="<?= site_url('homepage/about'); ?>" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">About</span>
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
                <!-- Start of the main content area -->
                <div class="row flex-nowrap">
                    <!-- Computer Science Section -->
                    <div class="question-container">
                        <h2>About</h2>
                        <div class="list-group questions-list">
                            <h1>Welcome to TechQ&A! 🚀</h1>
                            <p>We're thrilled to have you join our dynamic community of computer science enthusiasts. Whether you're looking
                                to solve a tricky coding problem, share your latest tech insights, or explore the cutting-edge trends shaping
                                the industry, you're in the right place.</p>

                            <h3>What's happening at TechQ&A:</h3>
                            <ul>
                                <li><span class="highlight">Explore Insightful Questions & Answers:</span> From Python to quantum computing, browse a diverse range
                                    of topics and find the answers you need.</li>
                                <li><span class="highlight">Connect & Collaborate:</span> Engage with fellow students, developers, and tech enthusiasts to grow
                                    your network and build collaborative projects.</li>
                                <li><span class="highlight">Share Your Expertise:</span> Got a solution or an interesting idea? Share your knowledge to help
                                    others and boost your reputation in the community.</li>
                            </ul>

                            <h3>Getting Started:</h3>
                            <ul>
                                <li><span class="highlight">Search Questions:</span> Start by searching for existing answers or exploring topics that interest you.</li>
                                <li><span class="highlight">Ask Your Own Question:</span> Got a unique challenge? Post your question and tap into the community's collective wisdom.</li>
                                <li><span class="highlight">Provide Answers & Earn Reputation:</span> Share your expertise to earn points and recognition among peers.</li>
                            </ul>

                            <div class="footer">
                                <p>Feel free to reach out if you have any questions or need help navigating the platform. Happy exploring,
                                    connecting, and sharing!</p>
                            </div>
                            <div class="contact-container">
                                <h2>Contact Us 📧</h2>
                                <p>Have a question or need assistance? Send us an email, and our team will get back to you as soon as possible.</p>
                                <p>Email us at: <a class="email" href="mailto:support@techqna.com">support@techqna.com</a></p>
                            </div>
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

    <script>
        $(document).ready(function() {
            // Fetch user info
            $.ajax({
                url: "<?= site_url('account/get_user_info'); ?>",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.username) {
                        $('#user-name').text(response.username);
                    } else {
                        $('#user-name').text('Guest');
                    }
                },
                error: function() {
                    alert('Error loading user data');
                }
            });

            // Search form submission
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var query = $('#searchInput').val(); // Get the search query from the input field

                // Redirect to the homepage with the search query as a query parameter
                window.location.href = '<?= site_url('homepage/index'); ?>?query=' + encodeURIComponent(query);
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