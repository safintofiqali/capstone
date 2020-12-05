<?php require_once("../../../private/init.php"); ?>
<?php

if (isset($_GET['stdNotify'])) {
    if (isset($_GET['std_id'])) {
        $std_id = $_GET['std_id'];
        $sql = "SELECT * FROM projects where std_id = $std_id and stdRecent = 1;";
        $projectQuery = mysqli_query($conn, $sql);
        if ($projectQuery) {
            while ($project = mysqli_fetch_assoc($projectQuery)) {
                if ($project['proj_status'] == 1) {
                    echo "<a href='" . url_for('/pages/projects/view.php?proj_id=' . $project['proj_id'] . '&stdRecent') . "'><li><span>Your Project Has Been Accepted: </span>" . $project['proj_title'] . "</li></a>";
                } else if ($project['proj_status'] == 2) {
                    echo "<a href='" . url_for('/pages/projects/view.php?proj_id=' . $project['proj_id'] . '&stdRecent') . "'><li><span>Your Project Has Been Rejected: </span>" . $project['proj_title'] . "</li></a>";
                }
            }
        } else {
            echo "Failed";
        }
        $commentSql = "SELECT * FROM comments WHERE owner_id = '$std_id' and commentStat = 1";
        $comments = mysqli_query($conn, $commentSql);
        if ($comments) {
            while ($comment = mysqli_fetch_assoc($comments)) {
                $proj_id = $comment['proj_id'];
                $project = selectProjectWithId($proj_id);
                echo "<a href='" . url_for('/pages/projects/view.php?proj_id=' . $project['proj_id'] . '&comment=' . $comment['comment_id'] . '#comments') . "'><li><span>" . $comment['comment_author'] . " commented : </span>" . $project['proj_title'] . "</li></a>";
            }
        }
    } else {
        echo "Failed";
    }
}


// Ideas Functions

if (isset($_GET['deleteComment'])) {
    global $conn;
    $ids = $_GET['deleteComment'];
    $sql = "DELETE FROM comments where comment_id IN($ids)";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Failed";
        echo mysqli_error($conn);
    } else {
        echo "Successedd";
    }
}