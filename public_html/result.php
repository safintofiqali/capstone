<?php
require_once("../private/init.php");

// Project Pagination Handler
if (isset($_GET['page'])) {
    $limit = $_GET['page'];
    $projects = selectProjects($limit);
    while ($project = mysqli_fetch_assoc($projects)) {
        $photo = selectPhoto($project['proj_id']);
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

// Ideas Pagination Handler
if (isset($_GET['ideas'])) {
    $limit = $_GET['ideas'];
    $ideas = selectIdeas($limit);
    while ($idea = mysqli_fetch_assoc($ideas)) {
    ?>
        <div class="col-md-4">
            <a href="<?php echo url_for('/pages/ideas/view.php?idea_id=' . $idea['idea_id']) ?>" style="text-decoration:none">
                <div class="idea-card">
                    <h2 class="idea-card__title"><?php echo $idea['idea_title']; ?></h4>
                        <p class="idea-card__detail"><?php echo $idea['idea_detail']; ?></p>
                        <p class="idea-card__major"><?php echo $idea['idea_major']; ?></p>
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
                $photo = selectPhoto($project['proj_id']);
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
        $projects = selectAllProjects();
        while ($project = mysqli_fetch_assoc($projects)) {
            $photo = selectPhoto($project['proj_id']);
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
            ?>
                <a href="<?php echo url_for('/pages/ideas/view.php?idea_id=' . $idea['idea_id']); ?>" class="project__link">
                    <div class="project">
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
        ?>
            <a href="<?php echo url_for('/pages/ideas/view.php?proj_id=' . $idea['idea_id']); ?>" class="project__link">
                <div class="project">
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


<!-- Comment Ajax -->
<?php
if (isset($_GET['comments'])) {
    $id = $_GET['comments'];
    $sql = "SELECT * FROM comments where proj_id = $id";
    $commentQuery = mysqli_query($conn, $sql);
    while ($comment = mysqli_fetch_assoc($commentQuery)) {
?>
        <div class="comment">
            <p class="comment__author">Comment By: &nbsp; <?php echo $comment['comment_author']; ?> </p>
            <p class="comment__content"><?php echo $comment['comment_content']; ?> </p>
            <p class="comment__date"><?php echo $comment['comment_date']; ?> </p>
        </div>
<?php
    }
}

?>

<?php
if (isset($_POST['content'])) {
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_val = mysqli_real_escape_string($conn, $_POST['user_val']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $proj_id = mysqli_real_escape_string($conn, $_POST['proj_id']);
    $owner_id = mysqli_real_escape_string($conn, $_POST['owner_id']);
    $userFullName = '';


    $user = selectUserWithId($user_val, $user_id);
    if ($user_val == 'instructors') {
        $userFullName = $user['inst_fname'] . ' ' . $user['inst_lname'];
    } else if ($user_val == 'students') {
        $userFullName = $user['std_fname'] . ' ' . $user['std_lname'];
    }
    $sql = "INSERT INTO comments(comment_author,comment_content,comment_date,proj_id,user_id,owner_id,user) VALUES(";
    $sql .= "'" .  $userFullName . "',";
    $sql .= "'" .  $content . "',";
    $sql .= "now(),";
    $sql .= "'" .  $proj_id . "',";
    $sql .= "'" .  $user_id . "',";
    $sql .= "'" .  $owner_id . "',";
    $sql .= "'" .  $user_val . "')";

    $post = mysqli_query($conn, $sql);

    if ($post) {
        echo $userFullName;
    } else {
        echo "Failed";
    }
}

?>