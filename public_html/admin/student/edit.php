<?php require_once("../../../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>
<?php

if(!isset($_GET['proj_id'])) {
    header("Location:" . url_for('/index.php'));
} else {
    $project = selectProjectWithId($_GET['proj_id']);
}
?>

<?php
if (isset($_POST['addproject'])) {      
    // Assignin values to variables
    foreach ($_POST as $key => $value) {
        if ($key === 'addproject') continue;
        $$key = $value;
    }
    $student = selectUserWithId('students', $_SESSION['std_id']);
    if (!is_empty($_POST)) {
        $std_id = $student['std_id'];
        $inst_id = $student['inst_id'];
        $sql = "INSERT INTO projects (`proj_title`,`proj_brief`,`proj_date`,`proj_major`,`inst_id`,`std_id`) values(?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        // Providing values to the query
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $date = date("Y-m-d h:i:s");
            mysqli_stmt_bind_param($stmt, "ssssss", $title, $brief, $date, $major, $inst_id, $std_id);
            mysqli_stmt_execute($stmt);
            $proj_id = mysqli_insert_id($conn);
        }
    } else {
        header("Location:add2.php?error=emptyInputs");
        exit();
    }

    // Photo Upload
    if (!empty($_FILES['photos']['name'][0])) {
        $arrayFileName = "photos";
        $files = $_FILES[$arrayFileName];
        $extentions;
        $sizes;
        $tmps;
        $errors;
        $allowed = ['jpg', 'jpeg', 'png'];
        $destination = "../assets/img/projects/";

        // Get Extensions
        foreach ($files['name'] as $value) {
            $images = explode('.', $value);
            $extentions[] = strtolower(end($images));
        }

        // Get Sizes
        foreach ($files['size'] as $value) {
            $sizes[] = $value;
        }
        // Get Temp Loc
        foreach ($files['tmp_name'] as $value) {
            $tmps[] = $value;
        }
        // Get Errors Loc
        foreach ($files['error'] as $value) {
            $errors[] = $value;
        }

        // Going Through each Image and Checking for errors
        for ($i = 0; $i < count($files['name']); $i++) {
            // Check for Format Allowance
            if (!in_array($extentions[$i], $allowed)) {
                header("Location:add2.php?error=Imageextention");
                exit();
            }
            // Check for Size 
            if ($sizes[$i] > 10000000) {
                header("Location:add2.php?error=size");
                exit();
            }
            // Check for Size 
            if ($errors[$i] !== 0) {
                header("Location:add2.php?error=error");
                exit();
            }

            // File name will be
            $random = mt_rand(0, 100000000);
            $fileName = "Project-Photo-" . $proj_id . "-" . $std_id . '-' . $random . '.' . $extentions[$i];
            $sql = "INSERT INTO photos(`photo_destination`,`inst_id`,`std_id`,`proj_id`) values('$fileName','$inst_id','$std_id','$proj_id');";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                header("Location: add2.php?error=QueryFailed");
                exit();
            } else {
                move_uploaded_file($tmps[$i], $destination . $fileName);
            }
        }
    }


    /* ------------------------- */
    // File Upload
    /* ------------------------- */
    if (!empty($_FILES['files']['name'][0])) {
        $name = "files";
        $files = $_FILES[$name];
        $fileExtensions;
        $fileSizes;
        $fileTmps;
        $fileErrors;
        $fileAllowed = ['doc', 'pdf', 'docx'];
        $destination = "../assets/doc/projects/";

        // Get Extensions
        foreach ($files['name'] as $value) {
            $file = explode('.', $value);
            $fileExtensions[] = strtolower(end($file));
        }

        // Get Sizes
        foreach ($files['size'] as $value) {
            $fileSizes[] = $value;
        }
        // Get Temp Loc
        foreach ($files['tmp_name'] as $value) {
            $fileTmps[] = $value;
        }
        // Get Errors Loc
        foreach ($files['error'] as $value) {
            $fileErrors[] = $value;
        }

        // Going Through each Files and Checking for errors
        for ($i = 0; $i < count($files['name']); $i++) {
            // Check for Format Allowance
            if (!in_array($fileExtensions[$i], $fileAllowed)) {
                header("Location:add2.php?error=extention");
                exit();
            }
            // Check for Size 
            if ($fileSizes[$i] > 10000000) {
                header("Location:add2.php?error=size");
                exit();
            }
            // Check for Size 
            if ($fileErrors[$i] !== 0) {
                header("Location:add2.php?error=error");
                exit();
            }

            // File name will be
            $random = mt_rand(0, 100000000);
            $fileName = "Project-doc-" . $proj_id . "-" . $std_id . '-' . $random . '.' . $fileExtensions[$i];
            $sql = "INSERT INTO files(`file_name`,`std_id`,`proj_id`) values('$fileName','$std_id','$proj_id');";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                header("Location: add2.php?error=QueryFailed");
                exit();
            } else {
                move_uploaded_file($fileTmps[$i], $destination . $fileName);
            }
        }
    }
    $loc = '../assets/vendor/autoload.php';
    require_once "$loc" ;
    
    $options = array(
      'cluster' => 'ap2',
      'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
      '1b0c08215023fb129faa',
      '2bc56ffe75c0a75ddecb',
      '1105551',
      $options
    );
    
    $data['message'] = 'hello world';
    $pusher->trigger('my-channel', 'my-event', $data);
}

?>
<form action="edit.php?proj_id=<?php echo $_GET['proj_id']; ?>" class='form' method="post" enctype="multipart/form-data">
    <div class="form__header">
        <h2>Edit Project</h2>
    </div>
    <div class="form__group">
        <label for="" class="form__label">Project Title</label>
        <input type="text" name='title' class="form__input" placeholder="Project Title: " value="<?php echo $project['proj_title']; ?>">
    </div>

    <div class="form__group">
        <label for="" class="form__label">Project Brief</label>
        <textarea name="brief" placeholder="Briefe Explanation" class='form__input'>
        <?php echo $project['proj_brief']; ?>"
        </textarea>

    </div>
    <div class="form__group">
        <label for="" class="form__label">Project Major</label>
        <select name="major" class='form__select'>
            <option value="">Project Major</option>
            <?php
            $dept = selectAllDept();
            while ($row = mysqli_fetch_assoc($dept)) :
            ?>
                <option value="<?php echo $row['dept_name']; ?>" <?php if($row['dept_name'] === $project['proj_major']){ echo " selected"; } ; ?>>
                    <?php echo $row['dept_name']; ?>
                </option>
            <?php ; endwhile; ?>
        </select>
    </div>

    <div class="form__group">
        <label for="photo" class="form__label">Upload Photo(s)</label>
        <input type="file" name="photos[]" multiple id="photo" class="form__input">
    </div>

    <div class="form__group">
        <label for="files" class="form__label">Upload Document(s)</label>
        <input type="file" name="files[]" id="files" multiple class="form__input">
    </div>
   
    <input type="submit" value="Edit Your Project" name='addproject' class='form__btn'>
</form>