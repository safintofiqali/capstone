<?php require_once("../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>
<?php

if(isset($_GET['page'])) {
    $page_num = $_GET['page'];
}
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }
            if ($page == "" || $page == 1) {
                $page_count = 0;
            } else {
                $page_count = ($page * 4) - 4;
            }

            $projects = selectFourProject($conn, $page_count, 4);
            while ($project = mysqli_fetch_assoc($projects)) { ?>
                <div class="col-md-4">
                    <a href="#">
                        <div class="card">
                            <img src="assets/img/project-10.jpg" alt="" class="card__background">
                            <div class="card__text-box">
                                <h4 class="card__title">Project Name</h4>
                                <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <div class="section-user__link-wrapper">
                <?php
                // Makin Pagination
                $rows = numOfRows(selectAllProjects($conn));
                $pages = ceil($rows /4);
                
                for ($i = 1; $i <= $pages; $i++) {
                    echo "<a href='index.php?page=$i' class='pagination__links'>$i</a>";
                }
                ?>