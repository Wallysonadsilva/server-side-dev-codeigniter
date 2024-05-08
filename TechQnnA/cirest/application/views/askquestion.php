<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>Ask a Question</title>
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

        .question-container,
        .user-questions {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .question-container form {
            margin-top: 10px;
        }

        .question-container label {
            font-weight: bold;
        }

        .questions-list .list-group-item,
        .user-questions .list-group-item {
            margin-bottom: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            position: relative;
        }

        .questions-list .list-group-item-action,
        .user-questions .list-group-item {
            text-decoration: none;
            color: inherit;
        }

        .questions-list .list-group-item-action:hover,
        .user-questions .list-group-item:hover {
            background-color: #FFA500;
            color: white;
            opacity: 0.8;
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

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            position: absolute;
            right: 10px;
            bottom: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('homepage/index'); ?>" style="font-weight: bold; color:#5D3FD3;">TechQ&A</a>
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
                <div class="question-container">
                    <h3>Ask a Question</h3>
                    <form id="submitQuestionForm">
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
                <div class="user-questions">
                    <h3>Your Questions</h3>
                    <div class="list-group questions-list" id="userQuestionsList"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Custom Script -->
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



            // Fetch user's questions using the REST API
            function loadUserQuestions() {
                $.ajax({
                    url: "<?= site_url('api/user_questions'); ?>",
                    type: 'GET',
                    dataType: 'json',
                    success: function(questions) {
                        const list = $('#userQuestionsList');
                        list.empty();

                        if (questions.length === 0) {
                            list.append('<p class="text-muted">You have not Posted any questions yet.</p>');
                        } else {
                            questions.forEach(function(question) {
                                const questionItem = `
                                    <div class="list-group-item">
                                    <div>
                                        <a href="<?= site_url('questions/view_question/'); ?>${question.id}" class="list-group-item-action">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mb-1">${question.title}</h5>
                                                </a>
                                                <small>${new Date(question.created_at).toLocaleDateString()}</small>
                                            </div>
                                            <p class="mb-1">${question.description}</p>
                                            <div class="d-flex w-100 justify-content-between">
                                                <small>${question.tags}</small>
                                                <button class="btn-delete mt-2" onclick="deleteQuestion(${question.id})">Delete</button>
                                            </div>
                                        
                                        </div>
                                    </div>`;
                                list.append(questionItem);
                            });
                        }
                    },
                    error: function() {
                        alert('Error fetching questions');
                    }
                });
            }

            // Submit question using the REST API
            $('#submitQuestionForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const data = {
                    title: $('#questionTitle').val(),
                    description: $('#questionDesc').val(),
                    tags: $('#questionTags').val()
                };

                $.ajax({
                    url: "<?= site_url('api/add_question'); ?>",
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Question submitted successfully');
                            loadUserQuestions(); // Reload user questions after submitting
                        } else {
                            alert('Failed to submit question: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        try {
                            const res = JSON.parse(xhr.responseText);
                            alert('Error submitting question: ' + (res.message || 'Unknown error'));
                        } catch (e) {
                            alert('Error submitting question: ' + xhr.status + ' - ' + xhr.statusText);
                        }
                    }
                });
            });

            // Delete question using the REST API
            window.deleteQuestion = function(id) {
                if (confirm('Are you sure you want to delete this question?')) {
                    $.ajax({
                        url: "<?= site_url('api/delete_question'); ?>/" + id,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('Question deleted successfully');
                                loadUserQuestions();
                            } else {
                                alert('Failed to delete question: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            try {
                                const res = JSON.parse(xhr.responseText);
                                alert('Error deleting question: ' + (res.message || 'Unknown error'));
                            } catch (e) {
                                alert('Error deleting question: ' + xhr.status + ' - ' + xhr.statusText);
                            }
                        }
                    });
                }
            };

            // Load user's questions on page load
            loadUserQuestions();

            // Search form submission
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var query = $('#searchInput').val(); // Get the search query from the input field

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