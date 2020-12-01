<?php require_once("../../../private/init.php"); ?>
<?php
if (isset($_GET['approve'])) {
    $ids = $_GET['approve'];
    $sql = "UPDATE projects set proj_status = 1 , stdRecent = 1 where proj_id IN ($ids)";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Failed";
    } else {
        echo "Successedd";
    }
}

if (isset($_GET['reject'])) {

    $ids = $_GET['reject'];
    $sql = "UPDATE projects set proj_status = 2, stdRecent = 1 where proj_id IN ($ids)";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "FaIled";
    } else {
        echo "Successedd";
    }
}
?>

<?php
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $inst_id = $_GET['inst_id'];

    // Functions
    /* ---------- */
    function showAll()
    {
        global $inst_id;
        global $conn;
        $sql = "SELECT * FROM projects where inst_id = '" . $inst_id .  "'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            exit("Query Failed");
        } else {
            while ($project = mysqli_fetch_assoc($result)) {
                $proj_status = '';
                if($project['proj_status'] == 0) {
                    $proj_status = 'Waiting';
                } else if($project['proj_status'] == 1) {
                    $proj_status = "Approved";
                } else if($project['proj_status'] == 2) {
                    $proj_status= "Rejected";
                }
?>
                <tr>
                    <td><input type="checkbox" name='status' class='checklist' value='<?php echo $project['proj_id']; ?>'></td>
                    <td><?php echo $project['proj_id']; ?></td>
                    <td><?php echo $project['proj_title']; ?></td>
                    <td><?php echo $project['proj_date']; ?></td>
                    <td><?php echo $project['proj_major']; ?></td>
                    <td><?php
                        $student = selectUserWithId('studnets', $project['std_id']);
                        echo $student['std_fname'] . ' ' . $student['std_lname'];
                        ?></td>
                    <td><?php echo $proj_status; ?></td>
                </tr>
            <?php }
        }
    }

    function showRejected()
    {
        global $inst_id;
        global $conn;
        $sql = "SELECT * FROM projects where inst_id = '" . $inst_id .  "' AND proj_status = 2";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            exit("Query Failed");
        } else {
            while ($project = mysqli_fetch_assoc($result)) {
                $proj_status = '';
                if($project['proj_status'] == 0) {
                    $proj_status = 'Waiting';
                } else if($project['proj_status'] == 1) {
                    $proj_status = "Approved";
                } else if($project['proj_status'] == 2) {
                    $proj_status= "Rejected";
                }
?>
                <tr>
                    <td><input type="checkbox" name='status' class='checklist' value='<?php echo $project['proj_id']; ?>'></td>
                    <td><?php echo $project['proj_id']; ?></td>
                    <td><?php echo $project['proj_title']; ?></td>
                    <td><?php echo $project['proj_date']; ?></td>
                    <td><?php echo $project['proj_major']; ?></td>
                    <td><?php
                        $student = selectUserWithId('studnets', $project['std_id']);
                        echo $student['std_fname'] . ' ' . $student['std_lname'];
                        ?></td>
                    <td><?php echo $proj_status; ?></td>
                </tr>
            <?php }
        }
    }

    // Show Approved
    function showApproved()
    {
        global $inst_id;
        global $conn;
        $sql = "SELECT * FROM projects where proj_status = 1 and inst_id = '$inst_id' ";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            exit("Query Failed");
        } else {
            while ($project = mysqli_fetch_assoc($result)) {
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
                    <td><?php echo $project['proj_status'] ? "Approved" : "Waiting"; ?></td>
                </tr>
            <?php }
        }
    }



    // Show UnApproved
    function showUnapproved()
    {
        global $inst_id;
        global $conn;
        $sql = "SELECT * FROM projects where proj_status = 0 and inst_id = $inst_id";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            exit("Query Failed");
        } else {
            while ($project = mysqli_fetch_assoc($result)) {
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
                    <td id="status"><?php echo $project['proj_status'] ? "Approved" : "Waiting"; ?></td>
                </tr>
<?php
            }
        }
    }

    /* ---------- */

    switch ($status) {
        case 'all':
            showall();
            break;
        case 'approved':
            showApproved();
            break;
        case "unapproved":
            showUnapproved();
            break;
        case "rejected":
            showRejected();
            break;
    }
}
?>


<!-- Notification -->
<?php

if (isset($_GET['notify'])) {
    if (isset($_GET['inst_id'])) {
        $inst_id = $_GET['inst_id'];
        $sql = "SELECT * FROM projects where recent = 1 and inst_id = $inst_id;";
        $projectQuery = mysqli_query($conn, $sql);
        if ($projectQuery) {
            while ($project = mysqli_fetch_assoc($projectQuery)) {
                echo "<a href='" . url_for('/pages/projects/view.php?proj_id=' . $project['proj_id'] . '&recent') . "'><li><span>New Project Added: </span>" . $project['proj_title'] . "</li></a>";
            }
        } else {
            echo "Failed";
        }
    }
}



// Ideas Functions

if (isset($_GET['deleteIdea'])) {
    $ids = $_GET['deleteIdea'];
    $sql = "DELETE FROM ideas where idea_id IN($ids)";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Failed";
    } else {
        echo "Successedd";
    }
}