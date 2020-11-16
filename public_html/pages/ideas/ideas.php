<?php require_once("../../../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>

<main class="main">
    <aside class="aside">
        <h2 class="aside__title"><i class="fas fa-filter"></i> &nbsp; Filter Ideas</h2>

        <h3 class="aside__filter-title">Major</h3>
        <ul class="aside__filter-list" id="majors">
            <?php
            $depts = selectAllDept($conn);
            while ($dept = mysqli_fetch_assoc($depts)) {
            ?>
                <li class="aside__filter-item">
                    <input type="checkbox" id="<?php echo $dept['dept_name'] ?>" class='aside__filter-input major' value="<?php echo $dept['dept_name'] ?>">
                    <label for="<?php echo $dept['dept_name'] ?>" class="aside__filter-label"><?php echo $dept['dept_name'] ?></label>
                </li>
            <?php
            }
            ?>
        </ul>
        <h3 class="aside__filter-title">Year</h3>
        <ul>

            <?php
            $depts = selectAllDept($conn);
            for ($i = 9; $i >= 0; $i--) {
            ?>
                <li class="aside__filter-item">
                    <input type="checkbox" id="<?php echo "201" . $i ?>" class='aside__filter-input'>
                    <label for="<?php echo "201" . $i ?>" class="aside__filter-label"><?php echo "201" . $i ?></label>
                </li>
            <?php
            }
            ?>
        </ul>
    </aside>
    <section class="section-container results">
    <?php
        $ideas = selectAllIdeas();
        while ($idea = mysqli_fetch_assoc($ideas)) {
            // $photo = selectPhoto($conn, $project['proj_id']);
        ?>
            <a href="<?php echo url_for('/pages/ideas/view.php?idea_id=' . $idea['idea_id']); ?>" class="project__link">
                <div class="project">
                    <div class="project__img-box">
                        <!-- <img src="<?php // echo url_for("/admin/assets/img/projects/" . $photo['photo_destination']) ?>" alt="" class="project__img"> -->
                    </div>
                    <div class="project__text">
                        <h3 class="project__title"><i class="fas fa-project-diagram"></i> &nbsp; <?php echo $idea['idea_title'] ?></h3>
                        <h4 class="project__major"><i class="fas fa-university"></i> &nbsp; <?php echo $idea['idea_major'] ?></h4>
                        <p class="project__brief"><?php echo $idea['idea_detail'] ?></p>
                    </div>
                </div>
            </a>
        <?php
        }
        ?>
    </section>
</main>

<!-- Ajax -->

<script>
    let values = [];
    let major = document.querySelector("#majors");
    let checkboxes = document.querySelectorAll(".major");

        checkboxes.forEach(function(check) {
        check.addEventListener("change", function() {
            if (check.checked) {
                values.push(check.value);
                sendData(values);
            } else {
                let index = values.indexOf(check.value);
                values.splice(index,1);
                sendData(values);
            }
        });
    });
    

    function sendData(values) {
        let xhr = new XMLHttpRequest();
        let url = "<?php echo url_for("/result.php?ideamajor="); ?>"
        xhr.open("GET", url + values, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let target = document.querySelector(".results");
                target.innerHTML = xhr.responseText;
                console.log(xhr.responseText);
            }
        }
        xhr.send();
    }
</script>

<?php include_once(SHARED_PATH . '/home_footer.php'); ?>