<?php require_once("../../../private/init.php"); ?>
<?php $page_title = "Notifications - Admin Area"; ?>
<?php include(SHARED_PATH . '/student_header.php'); ?>

<h1 class='u-text-center heading-primary u-margin-bottom-big u-margin-top-big'>Notifications</h1>

<div class="notification">
    <ul class='result'>

    </ul>

    <ul class="comments">
        
    </ul>
</div>

<?php include(SHARED_PATH . '/student_footer.php'); ?>


<script>
    function loadNotifications() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "results.php?stdNotify&std_id=<?php echo $_SESSION['std_id']; ?>", true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                let notifyElement = document.querySelector(".result");
                notifyElement.innerHTML = xhr.responseText;
            }
        }
        xhr.send();
    }
    loadNotifications();
    setInterval(loadNotifications, 1000);
</script>