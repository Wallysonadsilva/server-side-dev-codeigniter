<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>TechQ&A - Question Detail</title>
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

        .question-container {
            background-color: #f0f0f0;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .like,
        .dislike {
            cursor: pointer;
            margin-left: 10px;
        }

        .like i,
        .dislike i {
            color: #aaa;
        }

        .like i:hover,
        .dislike i:hover {
            color: gray;
            transform: scale(1.1);
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .selected {
            color: #45a049;
        }

        .like-icon,
        .dislike-icon {
            cursor: pointer;
            color: grey;
            transition: color 0.3s;
        }

        .like.selected .like-icon {
            color: #45a049;
        }

        .dislike.selected .dislike-icon {
            color: red;
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

        .post-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .rating {
            display: flex;
        }

        .list-group-item {
            margin-bottom: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
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
                <div class="question-container">
                    <h2><?= htmlspecialchars($question->title); ?></h2>
                    <p><?= nl2br(htmlspecialchars($question->description)); ?></p>
                    <div class="post-details">
                        <small><?= date('F j, Y', strtotime($question->created_at)); ?></small>
                        <small>Posted by: <?= htmlspecialchars($question->question_username); ?></small>
                        <div class="rating">
                            <div class="like grow <?= isset($user_reaction) && $user_reaction['type'] === 'like' ? 'selected' : ''; ?>" data-question-id="<?= htmlspecialchars($question->id); ?>">
                                <i class="fa fa-thumbs-up fa-lg like-icon" aria-hidden="true"></i> <span id="likes-count"><?= isset($reactions['likes_count']) ? $reactions['likes_count'] : 0; ?></span>
                            </div>
                            <div class="dislike grow <?= isset($user_reaction) && $user_reaction['type'] === 'dislike' ? 'selected' : ''; ?>" data-question-id="<?= htmlspecialchars($question->id); ?>">
                                <i class="fa fa-thumbs-down fa-lg dislike-icon" aria-hidden="true"></i> <span id="dislikes-count"><?= isset($reactions['dislikes_count']) ? $reactions['dislikes_count'] : 0; ?></span>
                            </div>
                        </div>
                    </div>

                    <h3>Answers</h3>
                    <div id="answers-container">
                        <?php foreach ($answers as $answer) : ?>
                            <div class="list-group-item">
                                <p><?= nl2br(htmlspecialchars($answer->content)); ?></p>
                                <div class="text-muted">
                                    Answered by <?= htmlspecialchars($answer->username); ?> on <?= date('F j, Y, g:i a', strtotime($answer->created_at)); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <br>
                    <?php if ($this->session->userdata('user_id')) : ?>
                        <div id="message"></div>
                        <form id="submit-answer-form">
                            <textarea id="answer-content" name="content" class="textarea-answer" required placeholder="Write your answer here..."></textarea>
                            <br>
                            <div class="btn-container">
                                <button type="submit" class="btn btn-primary btn-answer">Submit Answer</button>
                            </div>
                        </form>
                    <?php else : ?>
                        <p>Please <a href="<?= site_url('account/login_register'); ?>">login</a> to submit an answer.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fetch and display username 
            $.ajax({
                url: "<?= site_url('api/user'); ?>",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.username) {
                        $('#user-name').text(response.username);
                    } else {
                        window.location.href = '<?= base_url(''); ?>index.php';
                    }
                },
                error: function() {
                    alert('Error loading user data');
                }
            });

            $('#submit-answer-form').on('submit', function(e) {
                e.preventDefault();
                var formData = {
                    content: $('#answer-content').val()
                };

                $.ajax({
                    url: "<?= site_url('questions/add_answer/' . $question->id); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#answers-container').append(`
                                <div class="list-group-item">
                                    <p>${response.answer_content}</p>
                                    <div class="text-muted">
                                        Answered by ${response.username} on ${response.created_at}
                                    </div>
                                </div>
                            `);
                            $('#answer-content').val('');
                            $('#message').html('<div class="alert alert-success">Answer submitted successfully.</div>');
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#message').html('<div class="alert alert-danger">Failed to submit answer.</div>');
                    }
                });
            });


            $('.like').click(function() {
                var questionId = $(this).data('question-id');
                $.ajax({
                    url: "<?= site_url('questions/like_question/'); ?>" + questionId,
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            updateReactionDisplay(response.likes, response.dislikes, response.user_reaction);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('.dislike').click(function() {
                var questionId = $(this).data('question-id');
                $.ajax({
                    url: "<?= site_url('questions/dislike_question/'); ?>" + questionId,
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            updateReactionDisplay(response.likes, response.dislikes, response.user_reaction);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            function updateReactionDisplay(likes, dislikes, userReaction) {
                $('#likes-count').text(likes);
                $('#dislikes-count').text(dislikes);

                $('.like').removeClass('selected');
                $('.dislike').removeClass('selected');

                if (userReaction === 'like') {
                    $('.like').addClass('selected');
                } else if (userReaction === 'dislike') {
                    $('.dislike').addClass('selected');
                }
            }

            // NavBar search
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

            // Display the questions found from the search using navbar
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
        <div class="text-center p-3">
            © 2024 Copyright:
            <a class="text-body" href="">TechQ&A.com</a>
        </div>
    </footer>
</body>

</html>