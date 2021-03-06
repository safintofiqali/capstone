<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Instructor - Settings"; ?>
<?php include(SHARED_PATH . '/student_header.php'); ?>

<?php
if (isset($_POST['submitphoto'])) {
    $file = $_FILES['photo'];
    $id = $_SESSION['std_id'];
    $fileName = mysqli_real_escape_string($conn, $file['name']);
    $tmp = mysqli_real_escape_string($conn, $file['tmp_name']);
    $size = mysqli_real_escape_string($conn, $file['size']);
    $error = mysqli_real_escape_string($conn, $file['error']);
    $fileExt = explode(".", $fileName);
    $fileExtRaw = strtolower(end($fileExt));
    $allowed = ['jpg', 'png', 'jpeg'];

    if (!in_array($fileExtRaw, $allowed)) {
        header("Location:setting.php?err=ext");
        exit();
    } else if ($error != 0) {
        header("Location:setting.php?err=failed");
        exit();
    } else if ($size > 100000000) {
        header("Location:setting.php?err=size");
        exit();
    } else {

        $fileNewName = "profile-" . $id . "." . $fileExtRaw;
        $destination =  "../assets/img/" . $fileNewName;
        $sql = "INSERT INTO `photos` (photo_destination , photo_indication , std_id) VALUES ('$fileNewName',0,'$id');";
        $result = mysqli_query($conn, $sql);
        $photoId = mysqli_insert_id($conn);
        $sqlUpdate = "UPDATE photos set photo_indication = 1 where photo_id <> '$photoId' and std_id = $id";
        $resultUpdate = mysqli_query($conn, $sqlUpdate);
        if (!$resultUpdate) {
            echo "Query Failed  " . mysqli_connect_error();
        } else {
            if ($result) {
                move_uploaded_file($tmp, $destination);
                header("Location:setting.php");
            } else {
                echo "Query Failed: " . mysqli_connect_error();
            }
        }
    }
}

if (isset($_POST['update'])) {
    foreach ($_POST as $key => $value) {
        if ($key === 'update') continue;
        $$key = $value;
    }
    $std_id = $student['std_id'];
    $sql = "UPDATE students SET";
    $sql .= "`std_fname` = ? , ";
    $sql .= "`std_lname` = ? ,";
    $sql .= "`std_username` = ? ,";
    $sql .= "`std_password` = ? ,";
    $sql .= "`std_major` = ? ,";
    $sql .= "`std_email` = ? where std_id = '$std_id'";
    $result = mysqli_query($conn, $sql);

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        $hashed = password_hash($pwd, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssssss", $fname, $lname, $username, $hashed, $major, $email);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location:setting.php?Done");
    } else {
        header("Location:setting.php?err=queryFailed");
        exit();
    }
}
?>

<form action="<?php echo url_for('/admin/student/setting.php'); ?>" method="post" enctype="multipart/form-data" class='form'>
    <div class="form__header">
        <h2>Change Profile Picture</h2>
    </div>

    <div class="form__group">
        <label for="photo" class='form__label'>Choose a profile</label>
        <input type="file" name="photo" id='photo' class="form__input">
    </div>
    <button type="submit" name='submitphoto' class='form__btn'>Upload a profile</button>
</form>


<form action="<?php echo url_for('/admin/student/setting.php'); ?>" method="post" enctype="multipart/form-data" class='form'>
    <div class="form__header">
        <h2>Change User Info</h2>
    </div>
    <div class='form__group'>
        <label for="fname" class="form__label">First Name</label>
        <input class="form__input" type="text" name="fname" value="<?php echo $student['std_fname']; ?>" id='fname'>
    </div>
    <div class="form__group">
        <label for="lname" class="form__label">Last Name</label>
        <input class="form__input" type="text" name="lname" value="<?php echo $student['std_lname']; ?>" id='lname'>
    </div>
    <div class="form__group">
        <label for="username" class="form__label">User Name</label>
        <input class="form__input" type="text" name="username" value="<?php echo $student['std_username']; ?>" id='username'>
    </div>
    <div class="form__group">
        <label for="pwd" class="form__label">Password</label>
        <input class="form__input" type="password" name="pwd" id='pwd'>
    </div>
    <!-- Department Section -->
    <div class="form__group">
        <label for="major" class="form__label">Major</label>
        <select class="form__input" name="major" id="major">
            <option>Select Department</option>
            <?php
            $dept = selectAllDept($conn);
            while ($row = mysqli_fetch_assoc($dept)) :
            ?>
                <option value="<?php echo $row['dept_name']; ?>" <?php if ($student['std_major'] === $row['dept_name']) {
                                                                        echo " selected";
                                                                    } ?>>
                    <?php echo $row['dept_name']; ?>
                </option>

            <?php ; endwhile; ?>
        </select>
    </div>
    <div class="form__group">
        <label for="email" class="form__label">Email</label>
        <input class="form__input" type="text" name="email" value="<?php echo $student['std_email']; ?>" id='email'>
    </div>
    <input type="submit" value="Update" name='update' class="form__btn">
</form>