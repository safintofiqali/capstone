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
        <div class="admin-info">
            <div class="admin-info__img-box">
                <?php
                    $id = $_SESSION['std_id'];
                    $sql = "select * from photos where std_id = $id and photo_indication = 0";
                    $result = mysqli_query($conn, $sql);
                    $student = selectStd($conn,$id);
                    $name = $student['std_fname'] . ' ' . $student['std_lname'];
               
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $source = $row['photo_destination'];
                ?>
                    <img src="<?php echo url_for('/admin/assets/img/' . $source . "?" . time()); ?>" alt="" class="admin-info__img">
                <?php
                } else {
                ?>
                    <img src="<?php echo url_for('admin/assets/img/default.png'); ?>" alt="" class="admin-info__img">

                <?php
                }
                ?>
            </div>

            <h2 class="admin-info__username"><?php echo $name; ?></h2>
            <a href="<?php echo url_for('/admin/student/setting.php'); ?>">
                <i class="admin-info__icon fas fa-cog"></i>
            </a>

            <div class="admin-info__links">
                <a href="<?php echo url_for('index.php'); ?>" class="admin-info__link">Home Pages</a>
                <a href="<?php echo url_for('/admin/student/index.php'); ?>" class="admin-info__link">Admin Panels</a>
                <a href="<?php echo url_for('/admin/student/add2.php'); ?>" class="admin-info__link">Add Project</a>
                <a href="<?php echo url_for('/admin/student/edit.php'); ?>" class="admin-info__link">Edit Project</a>
                <a href="<?php echo url_for('/logout.php'); ?>" class="admin-info__link">Logout</a>
            </div>
        </div>
    </header>