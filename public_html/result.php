
<?php
require_once("../private/init.php");

if (isset($_GET['page'])) {
    $limit = $_GET['page'];
$projects = selectProjects($limit);
while ($project = mysqli_fetch_assoc($projects)) {
    $photo = selectPhoto($conn, $project['proj_id']);
?>
    <div class="col-md-4">
        <a href="#">
            <div class="card">
                <img src="<?php echo url_for('admin/assets/img/projects/') . $photo['photo_destination']; ?>" alt="" class="card__background">
                <div class="card__text-box">
                    <h4 class="card__title"><?php echo $project['proj_title']; ?></h4>
                    <p class="card__detail"><?php echo $project['proj_brief']; ?></p>
                </div>
            </div>
        </a>
    </div>

<?php } ?>
<?php
}
?>