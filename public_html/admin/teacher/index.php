<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Instructor - Admin Area"; ?>
<?php include(SHARED_PATH . '/teacher_header.php'); ?>

<main>
    <section class="section-navcards">
        <h1 class="heading-primary u-text-center">Admin Panel</h1>
        <div class="navcard-container">
            <div class="navcard-row">
                <a href="view.php?users" class="navcard__wrapper-link">
                    <div class="navcard navcard--user">
                        <div class="navcard__icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="navcard__name">Users</h3>
                    </div>
                </a>

                <a href="projects.php" class="navcard__wrapper-link">
                    <div class="navcard navcard--projects">
                        <div class="navcard__icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h3 class="navcard__name">Projects</h3>
                    </div>
                </a>

                <a href="<?php echo url_for('/admin/teacher/ideas.php')?>" class="navcard__wrapper-link">
                    <div class="navcard navcard--ideas">
                        <div class="navcard__icon">
                            <i class="far fa-lightbulb"></i>
                        </div>
                        <h3 class="navcard__name">Ideas</h3>
                    </div>
                </a>

            
            </div>
        </div>
    </section>

</main>

<!-- Notification Script -->
<script>
    function isProjectAdded() {
        let xhr = new XMLHttpRequest();
        let url = "<?php echo url_for("/result.php?newProj"); ?>";
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {

            }
        }
    }
</script>
<!-- Notification Script / -->

<?php include(SHARED_PATH . '/student_footer.php'); ?>