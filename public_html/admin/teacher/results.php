<?php require_once("../../../private/init.php"); ?>
<?php
if (isset($_POST['update'])) {
    $proj_id = $_POST['proj_id'];
    $sql = "UPDATE projects set proj_status = 1 where proj_id = $proj_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        exit("Query Failed");
    } else {
        $sql = "SELECT proj_status FROM projects WHERE proj_id = $proj_id";
        $result = mysqli_query($conn, $sql);
        $status = mysqli_fetch_assoc($result);
        echo $status['proj_status'] ? "Approved" : "Waiting";
    }
}
?>

<?php
if (isset($_GET['status'])) {
    $status = $_GET['status'];

    // Functions
    /* ---------- */
    function showAll() {
        global $conn;
        $sql = "SELECT * FROM projects"; $result = mysqli_query($conn, $sql);
        if (!$result) {
            exit("Query Failed");
        } else {
            while ($project = mysqli_fetch_assoc($result)) {
                $student = selectStd($conn, $project['std_id']);
?>
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
                    <td>
                        <form action="projects.php?proj_id=<?php echo $project['proj_id']; ?>" method='get'>
                            <button type="submit" name="update" class="approve" value="<?php echo $project['proj_id']; ?>">Approve</button>
                        </form>
                    </td>
                </tr>
            <?php } } }

    // Show Approved
    function showApproved() {
        global $conn;
        $sql = "SELECT * FROM projects where proj_status = 1";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            exit("Query Failed");
        } else {
            while ($project = mysqli_fetch_assoc($result)) {
                $student = selectStd($conn, $project['std_id']);
            ?>
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
                    <td>
                        <form action="projects.php?proj_id=<?php echo $project['proj_id']; ?>" method='get'>
                            <button type="submit" name="update" class="approve" value="<?php echo $project['proj_id']; ?>">Approve</button>
                        </form>
                    </td>
                </tr>
            <?php } } }



    // Show UnApproved
    function showUnapproved()
    {
        global $conn;
        $sql = "SELECT * FROM projects where proj_status = 0";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            exit("Query Failed");
        } else {
            while ($project = mysqli_fetch_assoc($result)) {
                $student = selectStd($conn, $project['std_id']);
            ?>
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
                    <td>
                        <form action="projects.php?proj_id=<?php echo $project['proj_id']; ?>" method='get'>
                            <button type="submit" name="update" class="approve" value="<?php echo $project['proj_id']; ?>">Approve</button>
                        </form>
                    </td>
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
    }
} else {
    showAll();
}
?>