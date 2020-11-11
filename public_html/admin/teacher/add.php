<?php require_once("../../../private/init.php"); ?>
<?php include(SHARED_PATH . '/teacher_header.php'); ?>
<!-- Processing Form and Error Handling -->
<?php
if (isset($_POST['addstudent'])) {

    foreach ($_POST as $key => $value) {
        if ($key === 'addstudent') continue;
        $$key = $value;
    }

    // is there value typed in
    if (is_empty($_POST)) {
        header("Location: add.php?err=empty");
        exit();
    }

    // Check Username and Email availability
    if (usernameExists($conn, $username, $email)) {
        header("Location: add.php?err=taken");
        exit();
    }

    // Check Email validity
    if (validEmail($email)) {
        header("Location: add.php?err=invemail");
        exit();
    }

    // Check Username validity
    if (validUsername($username)) {
        header("Location: add.php?err=invusername");
        exit();
    }

    // Check Password Match
    if (pwdMatch($password, $passwordrepeat)) {
        header("Location: add.php?err=pwdnotmatch");
        exit();
    }


    $sql = "INSERT INTO `students` (std_fname,std_lname,std_username,std_email,std_major,std_password,inst_id) values (?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sssssss", $fname, $lname, $username, $email, $major, $hashed, $inst_id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location:add.php");
    } else {
        header("Location:add.php?err=queryFailed");
        exit();
    }
}
?>
<!-- Processing Form and Error Handling  /-->

<!-- Register Form -->



<form autocomplete="off" method="post" action="add.php" class="form">
    <div class="form__header">
    <h2>Add New Student</h2>
    </div>
    <div class="form__group">
        <label for="" class="form__label">
            <span>
                <i aria-hidden="true" class="fa fa-user"></i>
            </span>
            Enter First Name
        </label>
        <input type="text" name="fname" placeholder="First Name" class="form__input" />
    </div>


    <div class="form__group">
        <label for="" class="form__label">
            <span>
                <i aria-hidden="true" class="fa fa-user"></i>
            </span>
            Enter Last Name
        </label>
        <input type="text" name="lname" placeholder="Last Name" class="form__input" />
    </div>

    <div class="form__group">
        <label for="" class="form__label">
            <span>
                <i class="fas fa-user"></i>
            </span>
            Enter Username
        </label>
        <input type="text" name="username" placeholder="Username" class="form__input">
    </div>

    <div class="form__group">
        <label for="" class="form__label">
            <span>
                <i class="fas fa-user-graduate"></i>
            </span>
            Choose Major
        </label>
        <select name="major" id="major" class="form__select">
            <option class="form__option" selected>Select student major</option>
            <?php
            $dept = selectAllDept($conn);
            while ($row = mysqli_fetch_assoc($dept)) :
            ?>
                <option value="<?php echo $row['dept_name']; ?>">
                    <?php echo $row['dept_name']; ?>
                </option>

            <?php ; endwhile; ?>
        </select>
    </div>

    <div class="form__group">
        <label for="" class="form__label">
            <span>
                <i aria-hidden="true" class="fa fa-envelope"></i>
            </span>
            Enter Email Address
        </label>
        <input type="email" name="email" placeholder="Email" class="form__input">
    </div>

    <div class="form__group">
        <label for="" class="form__label">
            <span><i aria-hidden="true" class="fa fa-lock">
                </i>
            </span>
            Enter Password
        </label>
        <input type="password" name="password" placeholder="Password" class="form__input">
    </div>
    <div class="form__group">
        <label for="" class="form__label">
            <span>
                <i aria-hidden="true" class="fa fa-lock"></i>
            </span>
            Enter Password Again
        </label>
        <input type="password" name="passwordrepeat" placeholder="Re-type Password" class="form__input">
    </div>

    <input type="hidden" name="inst_id" value='2'>
    <input id='submit-data' class="form__btn" type="submit" value="Register" name="addstudent" />
</form>



