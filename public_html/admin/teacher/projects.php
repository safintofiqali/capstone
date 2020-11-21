<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Instructor - Projects"; ?>
<?php include(SHARED_PATH . '/teacher_header.php'); ?>
<?php
if (isset($_GET['update'])) {

    $proj_id = $_GET['update'];
    $sql = "UPDATE projects set proj_status = 1 where proj_id = $proj_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        exit("Query Failed");
    } else {
        header("Location:" . url_for('/admin/teacher/projects.php'));
    }
}
?>
<section class="section-project" id='projects'>
    <h1 class="heading-primary u-text-center">Projects</h1>
    <div class="u-text-center u-margin-bottom-big u-margin-top-medium">
        <form action="view.php" method="get" class='search'>
            <input type="text" name="value" placeholder="Project Title, or Project Owner" class="search__input">
            <input type="submit" value="Search" name='search' class='search__btn'>
        </form>
    </div>

    <div class="checkboxes">
        <div>
            <input type="checkbox" id="all">
            <label for="all">All</label>
        </div>
        <div>
            <input type="checkbox" id="approved">
            <label for="approved">Approved</label>
        </div>
        <div>
            <input type="checkbox" id="unapproved">
            <label for="unapproved">Unapproved</label>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Title</th>
                <th>Project Date</th>
                <th>Project Major</th>
                <th>Project Owner</th>
                <th>Project Status</th>
                <th>Approve</th>
            </tr>
        </thead>
        <tbody class='result'>
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }
            if ($page == "" || $page == 1) {
                $page_count = 0;
            } else {
                $page_count = ($page * 10) - 10;
            }

            $inst = selectInst($conn, $_SESSION['inst_id']);
            $inst_dept = $inst['inst_dept'];

            if (isset($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['value']);
                $sql = "SELECT * FROM projects WHERE proj_major='$inst_dept' and proj_id = '$search' OR proj_title LIKE '%$search%'  OR proj_date LIKE '%$search%';";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo mysqli_error($conn);
                }
            } else {
                $result = selectLimitedProjects($conn, $inst_dept, $page_count);
            }
            while ($project = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $project['proj_id']; ?></td>
                    <td><?php echo $project['proj_title']; ?></td>
                    <td><?php echo $project['proj_date']; ?></td>
                    <td><?php echo $project['proj_major']; ?></td>
                    <td><?php
                        $student = selectStd($conn, $project['std_id']);
                        echo $student['std_fname'] . ' ' . $student['std_lname'];
                        ?></td>
                    <td><?php echo $project['proj_status'] ? "Approved" : "Waiting"; ?></td>
                    <?php if ($project['proj_status'] == 0) {
                    ?>
                        <td>
                            <form action="projects.php?proj_id=<?php echo $project['proj_id']; ?>" method='get'>
                                <button type="submit" name="update" class="approve" value="<?php echo $project['proj_id']; ?>">Approve</button>
                            </form>
                        </td>
                    <?php
                    } else {
                        ?>
                        <td>approved</td>
                        <?php
                    }
                    ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="section-user__link-wrapper">
        <?php
        // Makin Pagination
        $rows = numOfRows(selectAllProjects($conn, $inst_dept));
        $pages = ceil($rows / 10);
        for ($i = 1; $i <= $pages; $i++) {
            echo "<a href='view.php?users&page=$i' class='pagination__links'>$i</a>";
        }
        ?>
    </div>
</section>


<script>
    const all = document.querySelector("#all");
    const approved = document.querySelector("#approved");
    const unapproved = document.querySelector("#unapproved");
    console.log(approved.checked);
    const checkboxes = document.querySelector(".checkboxes");

    checkboxes.addEventListener("click", () => {
        if (all.checked) {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "<?php echo url_for('/admin/teacher/results.php?status=all'); ?>", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector(".result").innerHTML = xhr.responseText;
                }
            }
            xhr.send();
        } else if (approved.checked) {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "<?php echo url_for('/admin/teacher/results.php?status=approved'); ?>", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector(".result").innerHTML = xhr.responseText;
                }
            }
            xhr.send();
        } else if (unapproved.checked) {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "<?php echo url_for('/admin/teacher/results.php?status=unapproved'); ?>", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector(".result").innerHTML = xhr.responseText;
                }
            }
            xhr.send();
        } else {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "<?php echo url_for('/admin/teacher/results.php?status=all'); ?>", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.querySelector(".result").innerHTML = xhr.responseText;
                }
            }
            xhr.send();
        }
    })
</script>


<?php include(SHARED_PATH . '/student_footer.php'); ?>