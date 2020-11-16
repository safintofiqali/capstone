<?php
require_once("../private/init.php");

if (isset($_GET['page'])) {
    $limit = $_GET['page'];
    $projects = selectProjects($limit);
    while ($project = mysqli_fetch_assoc($projects)) {
        $photo = selectPhoto($conn, $project['proj_id']);
?>
        <div class="col-md-4">
            <a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $project['proj_id']); ?>">
                <div class="card">
                    <img src="<?php echo url_for('admin/assets/img/projects/') . $photo['photo_destination']; ?>" alt="" class="card__background">
                    <div class="card__text-box">
                        <h4 class="card__title"><?php echo $project['proj_title']; ?></h4>
                        <p class="card__detail"><?php echo $project['proj_brief']; ?></p>
                    </div>
                </div>
            </a>
        </div>

        <?php }
}


// Projects page Ajax
if (isset($_GET['major'])) {
    $major = $_GET['major'];
    $values = explode(",", $major);
    $value = implode("','", $values);

    if (!empty($value)) {
        $sql = "SELECT * FROM projects where proj_major in('" . $value . "');";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<p>" . $sql . "</p>";
            echo "Query Failed";
        } else {
        ?>
            <?php
            while ($project = mysqli_fetch_assoc($result)) {
                $photo = selectPhoto($conn, $project['proj_id']);
            ?>
                <a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $project['proj_id']); ?>" class="project__link">
                    <div class="project">
                        <div class="project__img-box">
                            <img src="<?php echo url_for("/admin/assets/img/projects/" . $photo['photo_destination']) ?>" alt="" class="project__img">
                        </div>
                        <div class="project__text">
                            <h3 class="project__title"><i class="fas fa-project-diagram"></i> &nbsp; <?php echo $project['proj_title'] ?></h3>
                            <h4 class="project__major"><i class="fas fa-university"></i> &nbsp; <?php echo $project['proj_major'] ?></h4>
                            <p class="project__brief"><?php echo $project['proj_brief'] ?></p>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        <?php
        }
    } else {
        $projects = selectAllProjects($conn);
        while ($project = mysqli_fetch_assoc($projects)) {
            $photo = selectPhoto($conn, $project['proj_id']);
        ?>
            <a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $project['proj_id']); ?>" class="project__link">
                <div class="project">
                    <div class="project__img-box">
                        <img src="<?php echo url_for("/admin/assets/img/projects/" . $photo['photo_destination']) ?>" alt="" class="project__img">
                    </div>
                    <div class="project__text">
                        <h3 class="project__title"><i class="fas fa-project-diagram"></i> &nbsp; <?php echo $project['proj_title'] ?></h3>
                        <h4 class="project__major"><i class="fas fa-university"></i> &nbsp; <?php echo $project['proj_major'] ?></h4>
                        <p class="project__brief"><?php echo $project['proj_brief'] ?></p>
                    </div>
                </div>
            </a>
<?php
        }
    }
}
?>

<?php
// Ideas page Ajax
if (isset($_GET['ideamajor'])) {
    $major = $_GET['ideamajor'];
    $values = explode(",", $major);
    $value = implode("','", $values);

    if (!empty($value)) {
        $sql = "SELECT * FROM ideas where idea_major in('" . $value . "');";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<p>" . $sql . "</p>";
            echo "Query Failed";
        } else {
        ?>
            <?php
            while ($idea = mysqli_fetch_assoc($result)) {
                // $photo = selectPhoto($conn, $project['proj_id']);
            ?>
                <a href="<?php echo url_for('/pages/ideas/view.php?idea_id=' . $idea['idea_id']); ?>" class="project__link">
                    <div class="project">
                        <div class="project__img-box">
                            <!-- <img src="<?php //echo url_for("/admin/assets/img/projects/" . $photo['photo_destination']) ?>" alt="" class="project__img"> -->
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
        <?php
        }
    } else {
        $ideas = selectAllIdeas();
        while ($idea = mysqli_fetch_assoc($ideas)) {
            // $photo = selectPhoto($conn, $project['proj_id']);
        ?>
            <a href="<?php echo url_for('/pages/ideas/view.php?proj_id=' . $idea['idea_id']); ?>" class="project__link">
                <div class="project">
                    <div class="project__img-box">
                        <!-- <img src="<?php //echo url_for("/admin/assets/img/projects/" . $photo['photo_destination']) ?>" alt="" class="project__img"> -->
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
    }
}
?>