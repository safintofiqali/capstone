<?php require_once("../../../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>

<!-- Get Project -->
<?php
    if(isset($_GET['proj_id'])) {
        $id = $_GET['proj_id'];
        $project = selectProjectWithId($conn,$id);
        $student = selectStd($conn,$project['std_id']);
        $photos = selectPhotos($conn,$id);
        $file = selectFile($conn,$id);
    }
?>

<section class="section-demo">
    <?php if( isset($_SESSION['std_id']) && $student['std_id'] == $_SESSION['std_id']) {?>
        <a href="<?php echo url_for('/admin/student/edit.php?proj_id=' . $project['proj_id']); ?>">Edit <i class="fas fa-edit"></i></a>
    <?php } ?>
    <h2 class="section-demo__title"><?php echo $project['proj_title'];?></h2>
    <h4 class="section-demo__author"><i class="fas fa-user-graduate"></i> &nbsp; <?php echo $student['std_fname'] . " " . $student['std_lname'];?></h4>
    <h5 class="section-demo__major"><i class="fas fa-university"></i> &nbsp; <?php echo $project['proj_major'];?></h5>
    <a href="<?php echo url_for('/admin/assets/doc/projects/' . $file['file_name']); ?>" download><i class="fas fa-file-download"></i> &nbsp; Reasearch</a>
    <p class="section-demo__detail"><?php echo $project['proj_brief'];?></p>
    <div class="section-demo__images">
    <?php 
        while($row = mysqli_fetch_assoc($photos)) {
            ?>
                <figure>
                <img src="<?php echo url_for('/admin/assets/img/projects/' . $row['photo_destination']); ?>" alt="" class="section-demo__img">
                </figure>
            <?php
        } ?>
    </div>
</section>

<?php include_once(SHARED_PATH . '/home_footer.php'); ?>