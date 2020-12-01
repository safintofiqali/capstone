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

    <div class="actions">
        <button type="submit" id='reject' class='actions__btn actions__btn--delete'>Delete</button>
    </div>

    <!-- Idea Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Idea ID</th>
                <th>Idea Title</th>
                <th>Idea Date</th>
                <th>Idea Major</th>
                <th>Idea Owner</th>
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
                $result = selectLimitedIdeas($inst_dept, $page_count);
            }
            while ($idea = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><input type="checkbox" name='status' class='checklist' value='<?php echo $idea['idea_id']; ?>'></td>
                    <td><?php echo $idea['idea_id']; ?></td>
                    <td><?php echo $idea['idea_title']; ?></td>
                    <td><?php echo $idea['idea_date']; ?></td>
                    <td><?php echo $idea['idea_major']; ?></td>
                    <td><?php echo $idea['idea_author_email']; ?></td>
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

    document.querySelector("#reject").addEventListener("click", deleteIdea);

    function deleteIdea() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "results.php?deleteIdea=" + values, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                elements.forEach(function(element){
                    element.parentNode.style.display= 'none';
                })
            }
        }
        xhr.send();
    }
</script>


<?php include(SHARED_PATH . '/student_footer.php'); ?>