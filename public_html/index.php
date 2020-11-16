<?php require_once("../private/init.php"); ?>
<?php include_once(SHARED_PATH . '/home_header.php'); ?>

<main>
    <!-- Section Showcase -->
    <section class="section-showcase">
        <div class="row">
            <!-- Column One - Slide-Container and Slides -->
            <div class="col-md-2">
                <div class="slide-container">
                    <span class="slide-container__nextBtn"><i class="fas fa-chevron-right"></i></span>
                    <span class="slide-container__prevBtn"><i class="fas fa-chevron-left"></i></span>
                    <?php
                    // Retrieve Projects for Slides
                    $projects = selectRecentProject($conn);
                    while ($project = mysqli_fetch_assoc($projects)) {
                        $photo = selectPhoto($conn, $project['proj_id']);
                    ?>
                        <a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $project['proj_id']); ?>">
                            <div class="slide">
                                <img src="<?php echo url_for('admin/assets/img/projects/') . $photo['photo_destination']; ?>" alt="" class="slide__background">
                                <div class="slide__text-box">
                                    <h3 class="slide__title">
                                        <i class="fas fa-project-diagram"></i>&nbsp;<?php echo $project['proj_title']; ?>
                                    </h3>
                                    <p class="slide__detail"><i class="fas fa-graduation-cap"></i>&nbsp;<?php echo $project['proj_major']; ?></p>
                                </div>
                            </div>
                        </a>
                    <?php  } ?>
                </div>
            </div>

            <!-- Column Two - Recent Project Cards -->
            <div class="col-md-2">
                <div class="row">
                    <?php
                    $projects = selectFourProject($conn, 0, 2);
                    while ($project = mysqli_fetch_assoc($projects)) {
                        $photo = selectPhoto($conn, $project['proj_id']);
                    ?>
                        <div class="col-2">
                            <a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $project['proj_id']); ?>">
                                <div class="recent-card">
                                    <img src="<?php echo url_for('admin/assets/img/projects/') . $photo['photo_destination']; ?>" alt="" class="recent-card__background">
                                    <div class="recent-card__text-box">
                                        <h4 class="recent-card__title"><?php echo $project['proj_title']; ?></h4>
                                        <p class="recent-card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias, voluptates.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <div class="row">
                    <?php
                    $projects = selectFourProject($conn, 2, 2);
                    while ($project = mysqli_fetch_assoc($projects)) {
                        $photo = selectPhoto($conn, $project['proj_id']);
                    ?>
                        <div class="col-2">
                            <div class="recent-card">
                                <img src="<?php echo url_for('admin/assets/img/projects/') . $photo['photo_destination']; ?>" alt="" class="recent-card__background">
                                <div class="recent-card__text-box">
                                    <h4 class="recent-card__title"><?php echo $project['proj_title']; ?></h4>
                                    <p class="recent-card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias, voluptates.</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Section About -->
    <section class="section-about">
        <div class="u-text-center u-margin-bottom-big">
            <h2 class="heading-primary">About</h2>
        </div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem temporibus officia porro voluptatem, necessitatibus corporis autem minus, in iure eius tempore natus quam provident alias est magnam? Eius aliquid non at dolorum veritatis iure cupiditate, ipsum, omnis, magnam accusantium voluptate mollitia pariatur quasi ratione labore! Adipisci, culpa possimus excepturi, provident neque, at numquam consequatur distinctio omnis doloremque ab saepe eos!</p>
    </section>

    <!-- Section Projects -->
    <section class="section-projects">
        <div class="u-text-center u-margin-bottom-big">
            <h2 class="heading-primary">Projects</h2>
        </div>

        <div class="row result">
            <!-- Starting PHP -->
            <?php
            $projects = selectProjects(0);
            while ($project = mysqli_fetch_assoc($projects)) {
                $photo = selectPhoto($conn, $project['proj_id']);
            ?>
                <div class="col-md-4">
                    <a href="<?php echo url_for('/pages/projects/view.php?proj_id=' . $project['proj_id']); ?>">
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
            <!-- Ending PHP -->
        </div>
        <div class="parent">
            <?php pagination('projects'); ?>
        </div>

        <script>
            const parent = document.querySelector(".parent");
            parent.addEventListener("click", output, false);

            function output(e) {
                let limit = e.target.id * 4;
                let xhr = new XMLHttpRequest();
                xhr.open("GET", "result.php?page=" + limit, true);

                let row = document.querySelector(".result");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let result = xhr.responseText;
                        row.style.animation = "move .5s";
                        row.innerHTML = result;
                    }
                }
                row.style.animation = "";
                xhr.send();
            }
        </script>
    </section>

    <!-- Section About -->
    <section class="section-share" id="shareidea">
        <div class="u-text-center u-margin-bottom-big">
            <h2 class="heading-primary">Share your ideas</h2>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio aliquid dolor iure aspernatur voluptatem omnis, sequi quos sapiente adipisci fugiat dolore aliquam qui esse ad at ut quaerat exercitationem perspiciatis accusantium! Vel vero esse sit?</p>

        <!-- Share Idea Form -->
        <form class="idea-form" method="post" action="<?php echo url_for('/formhandler.php'); ?>">
            <div class="idea-form__group">
                <label for="name" class="idea-form__label">Idea Title:</label>
                <input type="text" name="name" id="name" class="idea-form__input">
                <small id="name"></small>
            </div>
            <div class="idea-form__group">
                <label for="email" class="idea-form__label">Author Email Address:</label>
                <input type="email" name="email" id="email" class="idea-form__input">
                <small id="email"></small>
            </div>
            <div class="idea-form__group">
                <label for="idea" class="idea-form__label idea-form__label--textarea">Idea Detail:</label>
                <textarea name="idea" id="idea" class="idea-form__textarea"></textarea>
                <small id="idea"></small>
            </div>
            <div class="idea-form__group">
                <label for="major" class="idea-form__label">The idea is useful for:</label>
                <select name="major" id="major" class="idea-form__select">
                    <?php
                    $depts = selectAllDept($conn);
                    while ($row = mysqli_fetch_assoc($depts)) {
                    ?>
                        <option value="<?php echo $row['dept_name']; ?>"><?php echo $row['dept_name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <small id="idea"></small>
            </div>
            <div class="idea-form__alert">
                <p id="response"></p>
            </div>
            <button class="idea-form__btn" type="submit" name="shareidea">Share it</button>
        </form>
        <!-- Share Idea Form / -->

        <!-- Script for post ajax -->
        <script>
            const form = document.querySelector(".idea-form");
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                let name = document.querySelector("#name").value;
                let email = document.querySelector("#email").value;
                let idea = document.querySelector("#idea").value;
                let major = document.querySelector("#major").value;
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "formhandler.php");
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.querySelector("#response").innerText = xhr.responseText;
                    }
                }
                xhr.send("name=" + name + "&email=" + email + "&idea=" + idea + "&major=" + major);
            });
        </script>
        <!-- Script for post ajax / -->
    </section>

    <!-- Section Ideas -->
    <section class="section-ideas">
        <div class="u-text-center u-margin-bottom-big">
            <h2 class="heading-primary">Ideas for your project</h2>
        </div>

        <div class="row result">
            <!-- Starting PHP -->
            <?php
            $ideas = selectIdeas(0);
            while ($idea = mysqli_fetch_assoc($ideas)) {
            ?>
                <div class="col-md-4">
                    <a href="#" style="text-decoration:none">
                        <div class="idea-card">
                            <h2 class="idea-card__title"><?php echo $idea['idea_title']; ?></h4>
                                <p class="idea-card__detail"><?php echo $idea['idea_detail']; ?></p>
                                <p class="idea-card__major"><?php echo $idea['idea_major']; ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <!-- Ending PHP -->
        </div>

        <div class="parent">
            <?php pagination('ideas'); ?>
        </div>

        <!-- <div class="row">
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="assets/img/project-14.jpg" alt="" class="card__background">
                        <div class="card__text-box">
                            <h4 class="card__title">Idea Name</h4>
                            <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="assets/img/project-15.jpg" alt="" class="card__background">
                        <div class="card__text-box">
                            <h4 class="card__title">Idea Name</h4>
                            <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="assets/img/project-16.jpg" alt="" class="card__background">
                        <div class="card__text-box">
                            <h4 class="card__title">Idea Name</h4>
                            <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="assets/img/project-17.jpg" alt="" class="card__background">
                        <div class="card__text-box">
                            <h4 class="card__title">Idea Name</h4>
                            <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                        </div>
                    </div>
                </a>
            </div>
        </div> -->


    </section>
</main>

<script src="<?php echo url_for("/assets/js/slide.js")?>"></script>

<?php include_once(SHARED_PATH . '/home_footer.php'); ?>