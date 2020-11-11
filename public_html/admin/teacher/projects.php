<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Instructor - Projects"; ?>
<?php include(SHARED_PATH . '/teacher_header.php'); ?>

<section class="section-project" id='projects'>
    <h1 class="heading-primary u-text-center">Projects</h1>
    <div class="u-text-center u-margin-bottom-big u-margin-top-medium">
        <form action="view.php" method="get" class='search'>
            <input type="text" name="value" placeholder="Project Title, or Project Owner" class="search__input">
            <input type="submit" value="Search" name='search' class='search__btn' >
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Title</th>
                <th>Project Date</th>
                <th>Project Major</th>
                <th>Project Owner</th>
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
                $sql = "SELECT * FROM projects WHERE proj_major='$inst_dept' and proj_id = '$search' OR proj_title LIKE '%$search%'  OR proj_date LIKE '%$search%';";
                $result = mysqli_query($conn,$sql);
                if(!$result) {
                    echo mysqli_error($conn);
                }
            } else {
                $result = selectLimitedProjects($conn, $inst_dept,$page_count);
            }
            while ($project = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $project['proj_id']; ?></td>
                    <td><?php echo $project['proj_title']; ?></td>
                    <td><?php echo $project['proj_date']; ?></td>
                    <td><?php echo $project['proj_major']; ?></td>
                    <td><?php 
                        $student = selectStd($conn,$project['std_id']);
                        echo $student['std_fname'] . ' ' . $student['std_lname'];
                    ?></td>
                    <td><a href="edit.php?std_id=<?php echo htmlspecialchars($student['std_id']); ?>">Edit</a></td>
                    <td><a href="delete.php?std_id=<?php echo htmlspecialchars($student['std_id']); ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="section-user__link-wrapper">
        <?php
        // Makin Pagination
        $rows = numOfRows(selectAllProjects($conn,$inst_dept));
        $pages = ceil($rows / 10);
        for ($i = 1; $i <= $pages; $i++) {
            echo "<a href='view.php?users&page=$i' class='pagination__links'>$i</a>";
        }
        ?>
    </div>
</section>



<?php include(SHARED_PATH . '/student_footer.php'); ?>