<?php session_start(); ?>
<?php
$location = redirect_to('/index.php');
if (!isset($_SESSION['inst_id'])) : header("Location: $location");
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

    <!-- Notification  -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('1b0c08215023fb129faa', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });
  </script>

</head>

<body>
    <header class="header">
        <div class="admin-info">
            <div class="admin-info__img-box">
                <?php
                    $id = $_SESSION['inst_id'];
                    $sql = "SELECT * FROM photos WHERE inst_id = $id AND photo_indication = 0";
                    $result = mysqli_query($conn, $sql);
                    $inst = selectInst($conn, $id);
                    $name = $inst['inst_fname'] . ' ' . $inst['inst_lname'];
                
               
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
            <a href="<?php echo url_for('/admin/teacher/setting.php'); ?>">
                <i class="admin-info__icon fas fa-cog"></i>
            </a>

            <div class="admin-info__links">
                <a href="<?php echo url_for('index.php'); ?>" class="admin-info__link">Home Pages</a>
                <a href="<?php echo url_for('/admin/teacher/index.php'); ?>" class="admin-info__link">Admin</a>
                <a href="<?php echo url_for('/admin/teacher/view.php'); ?>" class="admin-info__link">Users</a>
                <a href="<?php echo url_for('/admin/teacher/projects.php'); ?>" class="admin-info__link">Projects</a>
                <a href="<?php echo url_for('/logout.php'); ?>" class="admin-info__link">Logout</a>
            </div>
        </div>
    </header>