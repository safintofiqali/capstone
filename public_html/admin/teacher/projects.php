<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Instructor - Projects"; ?>
<?php include(SHARED_PATH . '/teacher_header.php'); ?>

<section class="section-project" id='projects'>
    <h1 class="heading-primary u-text-center">Projects</h1>
    <div class="u-text-center u-margin-bottom-big u-margin-top-medium">
        <form action="projects.php" method="get" class='search'>
            <input type="text" name="value" placeholder="Project Title, or Project Owner" class="search__input">
            <input type="submit" value="Search" name='search' class='search__btn'>
        </form>
    </div>

    <!-- Project Status Radio Buttons -->
    <div class="checkboxes">
        <div>
            <input type="radio" id="all" name='options'>
            <label for="all">All</label>
        </div>
        <div>
            <input type="radio" id="approved" name='options'>
            <label for="approved">Approved</label>
        </div>
        <div>
            <input type="radio" id="unapproved" name='options'>
            <label for="unapproved">Unapproved</label>
        </div>
        <div>
            <input type="radio" id="rejected" name='options'>
            <label for="rejected">Rejected</label>
        </div>
    </div>
    <div class="actions">
        <button type="submit" id='approve' class='actions__btn actions__btn--approve'>Approve</button>
        <button type="submit" id='reject' class='actions__btn actions__btn--delete'>Reject</button>
    </div>
    <!-- Project Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Project ID</th>
                <th>Project Title</th>
                <th>Project Date</th>
                <th>Project Major</th>
                <th>Project Owner</th>
                <th>Project Status</th>
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

            $inst = selectUserWithId('instructors', $_SESSION['inst_id']);
            $inst_dept = $inst['inst_dept'];
            $inst_id = $_SESSION['inst_id'];
            if (isset($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['value']);
                $sql = "SELECT * FROM projects WHERE inst_id = $inst_id AND proj_title LIKE '%$search%' ;";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo mysqli_error($conn);
                }
            } else {
                $result = selectLimitedProjectsWithId($inst_dept, $page_count, $_SESSION['inst_id']);
            }
            while ($project = mysqli_fetch_assoc($result)) {
                $proj_status = '';
                if ($project['proj_status'] == 0) {
                    $proj_status = 'Waiting';
                } else if ($project['proj_status'] == 1) {
                    $proj_status = "Approved";
                } else if ($project['proj_status'] == 2) {
                    $proj_status = "Rejected";
                }
            ?>
                <tr>
                    <td><input type="checkbox" name='status' class='checklist' value='<?php echo $project['proj_id']; ?>'></td>
                    <td><?php echo $project['proj_id']; ?></td>
                    <td><?php echo $project['proj_title']; ?></td>
                    <td><?php echo $project['proj_date']; ?></td>
                    <td><?php echo $project['proj_major']; ?></td>
                    <td><?php
                        $student = selectUserWithId('students', $project['std_id']);
                        echo $student['std_fname'] . ' ' . $student['std_lname'];
                        ?></td>
                    <td class='status'><?php echo $proj_status ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pagination Section -->
    <div class="section-user__link-wrapper">
        <?php
        // Makin Pagination
        $rows = numOfRows(selectInstProjects($_SESSION['inst_id']));
        $pages = ceil($rows / 10);
        if (numOfRows($result) > 0) {
            for ($i = 1; $i <= $pages; $i++) {
                echo "<a href='projects.php?page=$i' class='pagination__links'>$i</a>";
            }
        }
        ?>
    </div>
</section>


<script>
    const all = document.querySelector("#all");
    const approved = document.querySelector("#approved");
    const unapproved = document.querySelector("#unapproved");
    const rejected = document.querySelector("#rejected");
    const approveBtn = document.querySelector("#approve");

    const checkboxes = document.querySelector(".checkboxes");

    checkboxes.addEventListener("click", () => {
        if (all.checked) {
            load('all')
        } else if (approved.checked) {
            load("approved");
        } else if (unapproved.checked) {
            load("unapproved");
        } else if (rejected.checked) {
            load("rejected");
        } else {
            load("all");
        }
    });








    // Status Selection
    const projRow = document.querySelector(".table");
    projRow.addEventListener('click', select, false);

    var values = [];
    var elements = [];

    function select(e) {
        if (e.target !== e.currentTarget) {
            if (e.target.checked) {
                let clickedItem = e.target.value;
                // console.log(e.target.parentNode.parentNode.lastElementChild);
                elements.push(e.target.parentNode.parentNode.lastElementChild)
                values.push(e.target.value);
            } else if (e.target.checked === false) {
                let index = values.indexOf(e.target.value);
                let elIndex = elements.indexOf(e.target.parentNode.parentNode.lastElementChild);
                values.splice(index, 1);
                elements.splice(elIndex, 1);
            }
        }
        console.log(elements)
    }

    document.querySelector("#reject").addEventListener("click", reject);
    document.querySelector("#approve").addEventListener("click", approve);
    // Approve Function 
    function approve() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", 'results.php?approve=' + values, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                elements.forEach(function(element) {
                    element.innerText = "Approved";
                })
            }
        }
        xhr.send();
    }
    // Reject Function
    function reject() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", 'results.php?reject=' + values, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                elements.forEach(function(element) {
                    element.innerText = "Rejected";
                })
            }
        }
        xhr.send();
    }


    // Retrieve Data Based on status
    function load(arg) {
        let xhr = new XMLHttpRequest();
        let url = "<?php echo url_for('/admin/teacher/results.php?inst_id=' . $_SESSION['inst_id']); ?>&status=" + arg;
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.querySelector(".result").innerHTML = xhr.responseText;
            }
        }
        xhr.send();
    }
</script>


<?php include(SHARED_PATH . '/student_footer.php'); ?>