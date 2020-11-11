<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Instructor - View Page"; ?>
<?php include(SHARED_PATH . '/teacher_header.php'); ?>

<section class="section-user" id='users'>
    <h1 class="heading-primary u-text-center">Users</h1>
    <div class="u-text-center u-margin-bottom-medium u-margin-top-medium">
        <a href="<?php echo url_for('admin/teacher/add.php'); ?>" class="btn btn-add--user">Add New Student</a>
    </div>
    <div class="u-text-center u-margin-bottom-big u-margin-top-medium">
        <form action="view.php" method="get" class='search'>
            <input type="text" name="value" placeholder="First Name, Last name, Username, or email" class="search__input">
            <input type="submit" value="Search" name='search' class='search__btn' >
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>User Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Major</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if($page == "" || $page == 1) {
                $page_count = 0;
            } else {
                $page_count = ($page * 10) - 10;
            }

            $inst = selectInst($conn, $_SESSION['inst_id']);
                $inst_dept = $inst['inst_dept'];

            if(isset($_GET['search'])) {
                $search = mysqli_real_escape_string($conn,$_GET['value']);
                $sql = "SELECT * FROM students WHERE std_major='$inst_dept' and std_id = '$search' OR std_fname LIKE '%$search%' OR std_lname LIKE '%$search%' OR std_email LIKE '%$search%';";
                $result = mysqli_query($conn,$sql);
                if(!$result) {
                    echo mysqli_error($conn);
                } else {
                    echo mysqli_num_rows($result);
                }
            } else {
                $result = selectLimitedStudents($conn, $inst_dept,$page_count);
            }
            while ($student = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $student['std_id']; ?></td>
                    <td><?php echo $student['std_fname']; ?></td>
                    <td><?php echo $student['std_lname']; ?></td>
                    <td><?php echo $student['std_username']; ?></td>
                    <td><?php echo $student['std_email']; ?></td>
                    <td><?php echo $student['std_major']; ?></td>
                    <td><a href="edit.php?std_id=<?php echo htmlspecialchars($student['std_id']); ?>">Edit</a></td>
                    <td><a href="delete.php?std_id=<?php echo htmlspecialchars($student['std_id']); ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="section-user__link-wrapper">
        <?php
        // Makin Pagination
        $rows = numOfRows(selectAllStudents($conn,$inst_dept));
        $pages = ceil($rows / 10);
        for ($i = 1; $i <= $pages; $i++) {
            echo "<a href='view.php?users&page=$i' class='pagination__links'>$i</a>";
        }
        ?>
    </div>
</section>



<?php include(SHARED_PATH . '/student_footer.php'); ?>