<?php require_once("../../../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>

<!-- Get Project -->
<?php
if (isset($_GET['proj_id'])) {
    $id = $_GET['proj_id'];
    $project = selectProjectWithId($id);
    $student = selectUserWithId('students', $project['std_id']);
    $owner_id = $project['std_id'];
    $photos = selectPhotos($id);
    $file = selectFile($id);
}
if (isset($_GET['recent'])) {
    $sql = "UPDATE projects set recent = 0 where proj_id = $id";
    $query = mysqli_query($conn, $sql);
}
if (isset($_GET['stdRecent'])) {
    $sql = "UPDATE projects SET stdRecent = 0 where proj_id = $id";
    $query = mysqli_query($conn, $sql);
}
if (isset($_GET['comment'])) {
    $com_id = $_GET['comment'];
    $sql = "UPDATE comments SET commentStat = 0 where comment_id = $com_id";
    $query = mysqli_query($conn, $sql);
}
?>

<section class="section-demo">
    <?php if (isset($_SESSION['std_id']) && $student['std_id'] == $_SESSION['std_id']) { ?>
        <a href="<?php echo url_for('/admin/student/edit.php?proj_id=' . $project['proj_id']); ?>">Edit <i class="fas fa-edit"></i></a>
    <?php } ?>
    <h2 class="section-demo__title"><?php echo $project['proj_title']; ?></h2>
    <h4 class="section-demo__author"><i class="fas fa-user-graduate"></i> &nbsp; <?php echo $student['std_fname'] . " " . $student['std_lname']; ?></h4>
    <h5 class="section-demo__major"><i class="fas fa-university"></i> &nbsp; <?php echo $project['proj_major']; ?></h5>
    <a href="<?php echo url_for('/admin/assets/doc/projects/' . $file['file_name']); ?>" download><i class="fas fa-file-download"></i> &nbsp; Reasearch</a>
    <p class="section-demo__detail"><?php echo $project['proj_brief']; ?></p>
    <div class="section-demo__images">
        <?php
        while ($row = mysqli_fetch_assoc($photos)) {
        ?>
            <figure>
                <img src="<?php echo url_for('/admin/assets/img/projects/' . $row['photo_destination']); ?>" alt="" class="section-demo__img">
            </figure>
        <?php
        } ?>
    </div>
</section>

<?php
if (isset($_SESSION['inst_id']) || isset($_SESSION['std_id'])) {

    $user_id = $_SESSION['inst_id']  ?? $_SESSION['std_id'];

    if(isset($_SESSION['inst_id'])) {
        $user_val = "instructors";
    } else if(isset($_SESSION['std_id'])) {
        $user_val = "students";
    }
?>
    <section class="section-comments" id='comments'>
        <h2 class='u-text-center u-margin-top-big u-margin-bottom-big heading-secondary'>Add Your Comment</h2>
        <div class="comment-form">
            <div class="comment__group">
                <textarea type="text" class="comment__content" placeholder="Write Your Comment"></textarea>
                <button type="submit" id='post' class="comment__button">Post</button>
            </div>
        </div>
        
        <div>
            <h2 class='u-text-center u-margin-top-big u-margin-bottom-big heading-secondary'>Comments</h2>
            <div class="comment-box"></div>
        </div>
    </section>
<?php
}
?>

<?php include_once(SHARED_PATH . '/home_footer.php'); ?>


<script>
    const post = document.querySelector("#post");
    post.addEventListener("click",addComment);

    function addComment(e) {
        e.preventDefault();
        let content = document.querySelector(".comment__content").value;
        let user_val = "<?php echo $user_val; ?>";
        let user_id = <?php echo $user_id; ?>;
        let proj_id = <?php echo $_GET['proj_id']; ?>;
        let inputs = "content=" + content + "&user_val=" + user_val + "&user_id=" + user_id + "&proj_id=" + proj_id + "&owner_id=" + <?php echo $owner_id; ?>;
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo url_for('/result.php'); ?>");
        xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                loadComments();
            }
        }
        xhr.send(inputs);
    }

    function loadComments() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "<?php echo url_for('/result.php?comments=' . $id); ?>", true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                let target = document.querySelector(".comment-box");
                target.innerHTML = xhr.responseText;
            }
        }
        xhr.send();
    }
    loadComments();
    setInterval(loadComments,1000);
</script>