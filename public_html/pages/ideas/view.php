<?php require_once("../../../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>

<!-- Get Project -->
<?php
    if(isset($_GET['idea_id'])) {
        $id = $_GET['idea_id'];
        $idea = selectIdea($id);
        // $student = selectStd($conn,$project['std_id']);
        // $photos = selectPhotos($conn,$id);
        // $file = selectFile($conn,$id);
    }
?>

<section class="section-demo">
    <h2 class="section-demo__title"><?php echo $idea['idea_title'];?></h2>
    <h5 class="section-demo__major"><i class="fas fa-university"></i> &nbsp; <?php echo $idea['idea_major'];?></h5>
    <p class="section-demo__detail"><?php echo $idea['idea_detail'];?></p>
</section>

<?php include_once(SHARED_PATH . '/home_footer.php'); ?>