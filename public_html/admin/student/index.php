<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Students - Admin Area"; ?>
<?php include(SHARED_PATH . '/student_header.php'); ?>
<?php $project = selectStdProjectWithId($_SESSION['std_id']);
        $proj_id = $project['proj_id'];
?>


<main>
    <section class="section-navcards">
        <h1 class="heading-primary u-text-center">Admin Panel</h1>
        <div class="navcard-container">
            <div class="navcard-row">

                <a href="add2.php" class='navcard__wrapper-link'>
                    <div class="navcard navcard--user">
                        <div class="navcard__icon">
                            <i class="fas fa-folder-plus"></i>
                        </div>
                        <h3 class="navcard__name">Add Project</h3>
                    </div>
                </a>              
                <a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $proj_id); ?> " class='navcard__wrapper-link'>
                    <div class="navcard navcard--projects">
                        <div class="navcard__icon">
                        <i class="fas fa-project-diagram"></i>
                        </div>
                        <h3 class="navcard__name">My Project</h3>
                    </div>
                </a>              
                <a href="<?php echo url_for('/admin/student/edit.php?proj_id='.$proj_id);?>" class='navcard__wrapper-link'>
                    <div class="navcard navcard--ideas">
                        <div class="navcard__icon">
                        <i class="fas fa-edit"></i>
                        </div>
                        <h3 class="navcard__name">Edit</h3>
                    </div>
                </a>              
            </div>
        </div>
    </section>
</main>

<?php include(SHARED_PATH . '/student_footer.php'); ?>