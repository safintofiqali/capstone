<?php require_once("../private/init.php"); ?>
<?php
$data;
$projects = selectAllDept($conn);
while ($project = mysqli_fetch_assoc($projects)) { 
    $data[] = $project;
}
echo json_encode($data);
?>