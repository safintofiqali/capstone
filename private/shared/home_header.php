<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a8b5183a18.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Custome Style -->
    <link rel="stylesheet" href="<?php echo url_for('assets/css/main.css'); ?>">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? "Capstone Project Repository"; ?></title>
</head>

<body>
    <nav class="nav">
        <input type="checkbox" class="nav__input" id="toggler">
        <label for="toggler" class="nav__toggler">
            <span class="nav__icon">&nbsp;</span>
        </label>
        <div class="nav__background"></div>

        <ul class="nav__list">
            <li class="nav__item"><a href="<?php echo url_for('/index.php'); ?>" class="nav__link">Home</a></li>
            <li class="nav__item"><a href="<?php echo url_for('/pages/projects/projects.php'); ?>" class="nav__link">Projects</a></li>
            <li class="nav__item"><a href="#" class="nav__link">Share Idea</a></li>
            <li class="nav__item"><a href="<?php echo url_for('/pages/ideas/ideas.php'); ?>" class="nav__link">Ideas</a></li>
            <?php if (isset($_SESSION['std_id'])) :  ?>
                <li class="nav__item"><a href="<?php echo url_for('/admin/student/index.php') ?>" class="nav__link">Profile</a></li>
                <li class="nav__item"><a href="<?php echo url_for('/logout.php') ?>" class="nav__link">Logout</a></li>
            <?php ; elseif (isset($_SESSION['inst_id'])) : ?>
                <li class="nav__item"><a href="<?php echo url_for('/admin/teacher/index.php') ?>" class="nav__link">Profile</a></li>
                <li class="nav__item"><a href="<?php echo url_for('/logout.php') ?>" class="nav__link">Logout</a></li>
            <?php ; else : ?>
                <li class="nav__item"><a href="<?php echo url_for('/login.php') ?>" class="nav__link">Login</a></li>
            <?php ; endif; ?>
        </ul>
    </nav>

    <header class="header">
        <div class="header__logo-box">
            <h1 class="header__logo">
                <span class="header__logo--main">Capstone</span>
                <span class="header__logo--sub">Project Repository</span>
            </h1>
        </div>
    </header>