<?php require_once("../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_empty($_POST)) {
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
    } else {
        header("Location:login.php?error=EmptyInputs");
        exit();
    }

    if(isset($_POST['std_login'])) {
        $sql = "SELECT * FROM students WHERE std_username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(!$result) {
                echo mysqli_error($conn);
            }
            $row = mysqli_fetch_assoc($result);
            
            if($row) {
                if(password_verify($password,$row['std_password'])) {
                    $_SESSION['std_id'] = $row['std_id'];
                    $_SESSION['username'] = $row['std_username'];
                    header("Location: index.php?");
                }
            }
        }
    }
    if(isset($_POST['inst_login'])) {
        $sql = "SELECT * from instructors where inst_username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)) {
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if($row) {
                if(password_verify($password,$row['inst_password'])) {
                    $_SESSION['inst_id'] = $row['inst_id'];
                    $_SESSION['username'] = $row['inst_username'];
                    header("Location: index.php?");
                }
            }
        }
    }
}
?>

<form action="login.php" method="post" class="form">
    <div class="form__group">
        <label for="" class="form__label">Enter Username</label>
        <input type="text" name="username" placeholder="Username" class="form__input">
    </div>
    <div class="form__group">
        <label for="" class="form__label">Enter Password</label>
    <input type="password" name="password" placeholder="Password" class="form__input">
    </div>

    <input type="submit" value="Login as Student" name='std_login' class="form__btn">
    <input type="submit" value="Login as Instructor" name='inst_login' class="form__btn">
</form>

<?php include_once(SHARED_PATH . '/home_footer.php'); ?>