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
        <nav class="nav">
            <div class="nav__user">
                <?php
                $id = $_SESSION['inst_id'];
                $sql = "SELECT * FROM photos WHERE inst_id = $id AND photo_indication = 0";
                $result = mysqli_query($conn, $sql);
                $inst = selectInst($conn, $id);
                $name = $inst['inst_fname'] . ' ' . $inst['inst_lname'];
                ?>
                <!-- User Image Retrieve -->
                <div class="nav__user-img-box">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $source = $row['photo_destination']; ?>

                        <img src="<?php echo url_for('/admin/assets/img/' . $source . "?" . time()); ?>" alt="" class="nav__user-img">
                    <?php } else { ?>
                        <img src="<?php echo url_for('admin/assets/img/default.png'); ?>" alt="" class="nav__user-img">
                    <?php } ?>
                    <img src="../assets/img/default.png" alt="" class="nav__user-img">
                </div>

                <!-- User Username -->
                <h3 class="nav__username"><?php echo $name; ?></h3>

                <!-- User Setting Icon -->
                <div class="nav__setting">
                    <a href="<?php echo url_for('/admin/teacher/setting.php'); ?>">
                        <i class="nav__user-icon fas fa-cog"></i>
                    </a>
                </div>
            </div>

            <!-- User Navigation Button -->
            <input type="checkbox" class="nav__toggler" id='toggler'>
            <label for="toggler" class='nav__button'>
                <span class="nav__toggler-icon"></span>
            </label>
            <div class="nav__background">&nbsp;</div>

            <!-- User Navigation -->
            <div class="nav__navigation">
                <ul class="nav__list">
                    <li class="nav__item"><a href="<?php echo url_for('/index.php'); ?>" class="nav__link">Home</a></li>
                    <li class="nav__item"><a href="<?php echo url_for('/admin/teacher/index.php'); ?>" class="nav__link">Admin</a></li>
                    <li class="nav__item"><a href="<?php echo url_for('/admin/teacher/add.php'); ?>" class="nav__link">Add Student</a></li>
                    <li class="nav__item"><a href="<?php echo url_for('/admin/teacher/view.php'); ?>" class="nav__link">Edit Student</a></li>
                    <li class="nav__item"><a href="<?php echo url_for('/logout.php'); ?>" class="nav__link">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>