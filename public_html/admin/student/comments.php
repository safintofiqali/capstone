<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Student - Comments"; ?>
<?php include(SHARED_PATH . '/student_header.php'); ?>

<section class="section-project" id='projects'>
    <h1 class="heading-primary u-text-center">Comments</h1>
    <div class="actions">
        <button type="submit" id='delete' class='actions__btn actions__btn--delete'>Delete</button>
    </div>
    <!-- Project Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Comment Author</th>
                <th>Content</th>
                <th>View</th>
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
            
            $project = selectStdProjectWithId($_SESSION['std_id']);
            $proj_id = $project['proj_id'];
            $result = selectLimitedComments($page_count, $proj_id);
            while ($comment = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><input type="checkbox" name='status' class='checklist' value='<?php echo $comment['comment_id']; ?>'></td>
                    <td><?php echo $comment['comment_author']; ?></td>
                    <td><?php echo $comment['comment_content']; ?></td>
                    <td><a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $comment['proj_id'] . '#comments'); ?>">View</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pagination Section -->
    <div class="section-user__link-wrapper">
        <?php
        // Makin Pagination
        $rows = numOfRows(selectInstProjects($proj_id));
        $pages = ceil($rows / 10);
        if (numOfRows($result) > 0) {
            for ($i = 1; $i <= $pages; $i++) {
                echo "<a href='comments.php?page=$i' class='pagination__links'>$i</a>";
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

    document.querySelector("#delete").addEventListener("click", deleteComment);
  
    // Reject Function
    function deleteComment() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", 'results.php?deleteComment=' + values, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                elements.forEach(function(element){
                    element.parentNode.style.display = "none";
                })
            }
        }
        xhr.send();
    }

</script>


<?php include(SHARED_PATH . '/student_footer.php'); ?>