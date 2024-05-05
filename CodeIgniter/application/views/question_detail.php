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

    <title>TechQ&A - Ask Question</title>
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
                    <div class="list-group">
                        <?php
                        $reactions = $this->Question_model->count_like_dislike($question->id);
                        $likes = $reactions['like'];
                        $dislikes = $reactions['dislike'];

                        // Fetch the user's reaction (if logged in)
                        $user_reaction = null;
                        if ($this->session->userdata('user_id')) {
                            $user_id = $this->session->userdata('user_id');
                            $user_reaction = $this->Question_model->get_user_like_dislike($user_id, $question->id);
                        }

                        // Determine the classes for the like/dislike buttons based on user reaction
                        $like_class = ($user_reaction && $user_reaction['type'] == 'like') ? 'selected' : '';
                        $dislike_class = ($user_reaction && $user_reaction['type'] == 'dislike') ? 'selected' : '';
                        ?>
                        <h2><?= htmlspecialchars($question->title); ?></h2>
                        <p><?= nl2br(htmlspecialchars($question->description)); ?></p>
                        <div class="post-details">
                            <small><?= date('F j, Y', strtotime($question->created_at)); ?></small>
                            <small>Posted by: <?= htmlspecialchars($question->question_username); ?></small>
                            <div class="rating">
                                <div class="like grow <?= $like_class; ?>" data-question-id="<?= htmlspecialchars($question->id); ?>">
                                    <i class="fa fa-thumbs-up fa-lg like-icon" aria-hidden="true"></i> <span id="likes-count"><?= $likes; ?></span>
                                </div>
                                <div class="dislike grow <?= $dislike_class; ?>" data-question-id="<?= htmlspecialchars($question->id); ?>">
                                    <i class="fa fa-thumbs-down fa-lg dislike-icon" aria-hidden="true"></i> <span id="dislikes-count"><?= $dislikes; ?></span>
                                </div>
                            </div>
                        </div>

                        <h3>Answers</h3>
                        <?php foreach ($answers as $answer) : ?>
                            <div class="list-group-item">
                                <p><?= nl2br(htmlspecialchars($answer->content)); ?></p>

                                <div class="text-muted">
                                    Answered by <?= htmlspecialchars($answer->username); ?> on <?= date('F j, Y, g:i a', strtotime($answer->created_at)); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <br>
                        <?php if ($this->session->userdata('user_id')) : ?>
                            <form action="<?= site_url('questions/add_answer/' . $question->id); ?>" method="post">
                                <textarea name="content" class="textarea-answer" required placeholder="Write your answer here..."></textarea>
                                <br>
                                <div class="btn-container">
                                    <button type="submit" class="btn btn-primary btn-answer">Submit Answer</button>
                                </div>
                            </form>

                        <?php else : ?>
                            <p>Please <a href="<?= site_url('login'); ?>">login</a> to submit an answer.</p>
                        <?php endif; ?>
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

        $(document).ready(function() {
            function updateReactionDisplay(likes, dislikes, liked, disliked) {
                $('#likes-count').text(likes);
                $('#dislikes-count').text(dislikes);

                // Reset classes
                $('.like').removeClass('selected');
                $('.dislike').removeClass('selected');

                if (liked) {
                    $('.like').addClass('selected');
                }

                if (disliked) {
                    $('.dislike').addClass('selected');
                }
            }

            $('.like').click(function() {
                var questionId = $(this).data('question-id');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url("questions/like_question"); ?>/' + questionId,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            updateReactionDisplay(data.likes, data.dislikes, true, false);
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('.dislike').click(function() {
                var questionId = $(this).data('question-id');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url("questions/dislike_question"); ?>/' + questionId,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            updateReactionDisplay(data.likes, data.dislikes, false, true);
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
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