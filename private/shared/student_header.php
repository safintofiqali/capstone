<?php session_start(); ?>
<?php
$location = redirect_to('/index.php');
if (!isset($_SESSION['std_id'])) : header("Location: $location");
endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a8b5183a18.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo url_for('/admin/assets/css/admin.css') ?>">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? "Student Admin Area"; ?></title>

</head>

<body>
    <header class="header">
        <nav class="nav">
            <div class="nav__user">
                <div class="nav__user-img-box">
                    <img src="../assets/img/default.png" alt="" class="nav__user-img">
                </div>
                <h3 class="nav__username">Username</h3>
                <div class="nav__setting">
                    <i class="nav__user-icon fas fa-cog"></i>
                </div>
            </div>

            <div class="nav__navigation">
                <input type="checkbox" class="nav__toggler" id='toggler'>
                <label for="toggler" class='nav__button'>
                    <span class="nav__toggler-icon"></span>
                </label>
                <div class="nav__background"></div>

                <ul class="nav__list">
                    <li class="nav__item"><a href="#" class="nav__link">Home</a></li>
                    <li class="nav__item"><a href="#" class="nav__link">Admin</a></li>
                    <li class="nav__item"><a href="#" class="nav__link">Add Project</a></li>
                    <li class="nav__item"><a href="#" class="nav__link">Edit Project</a></li>
                    <li class="nav__item"><a href="#" class="nav__link">Comments</a></li>
                </ul>
            </div>
        </nav>
    </header>