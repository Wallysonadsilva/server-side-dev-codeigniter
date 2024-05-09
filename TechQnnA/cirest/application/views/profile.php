<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TechQ&A - Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
            text-decoration: none;
        }

        .sidebar a:hover {
            color: #5D3FD3;
        }

        .profile-container {
            background-color: #f0f0f0;
            padding: 20px;
            margin: 10px auto;
            width: 50%;
            border-radius: 5px;
        }

        .btn {
            background-color: #5D3FD3;
            color: white;
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

        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
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
                            <a href="<?= base_url(''); ?>index.php/homepage" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i>
                                <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(''); ?>index.php/homepage/askquestion" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i>
                                <span class="ms-1 d-none d-sm-inline">Add New Question</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(''); ?>index.php/homepage/about" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-bootstrap"></i>
                                <span class="ms-1 d-none d-sm-inline">About</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.shutterstock.com/image-vector/default-avatar-profile-icon-social-600nw-1677509740.jpg" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1" id="user-name"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="<?= base_url(''); ?>index.php/homepage/profile">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url(''); ?>index.php/auth/logout">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3 min-vh-100">
                <div class="profile-container">
                    <h2>Profile</h2>
                    <p><strong>Username:</strong> <span id="profile-username"></span></p>
                    <p><strong>Email:</strong> <span id="profile-email"></span></p>
                    <p><strong>Bio:</strong> <span id="profile-bio"></span></p>
                    <div class="btn-container">
                        <a href="<?= site_url('homepage/edit_profile'); ?>" class="btn">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "<?= site_url('api/user'); ?>", // Assuming this is your API endpoint
                type: 'GET',
                dataType: 'json',
                success: function(user) {
                    $('#profile-username').text(user.username || 'N/A');
                    $('#profile-email').text(user.email || 'N/A');
                    $('#profile-bio').text(user.bio || 'N/A');
                    $('#user-name').text(user.username || 'User');
                },
                error: function() {
                    alert('Error loading user data');
                }
            });


            // NavBar Search 
            $('#searchForm').submit(function(event) {
                event.preventDefault();

                var query = $('#searchInput').val();


                $.ajax({
                    url: '<?= site_url('api/navbar_search'); ?>',
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