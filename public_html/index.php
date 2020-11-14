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
                        <a href="<?php echo url_for('/view.php?proj_id=') . $project['proj_id']; ?>">
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

        <script>
                let http = new XMLHttpRequest();
                http.open("GET", "result.php", true);
                http.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        let resp = JSON.parse(this.responseText);
                        console.log(typeof resp);
                        resp.forEach(function(data){
                            console.log(data['dept_id']);
                            console.log(data['dept_name']);
                        });
                    }
                }
                http.send();
        </script>

        <div class="row results">


        </div>

        <!-- <div class="row">
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
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="assets/img/project-11.jpg" alt="" class="card__background">
                        <div class="card__text-box">
                            <h4 class="card__title">Project Name</h4>
                            <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="assets/img/project-12.jpg" alt="" class="card__background">
                        <div class="card__text-box">
                            <h4 class="card__title">Project Name</h4>
                            <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#">
                    <div class="card">
                        <img src="assets/img/project-13.jpg" alt="" class="card__background">
                        <div class="card__text-box">
                            <h4 class="card__title">Project Name</h4>
                            <p class="card__detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa, ad?</p>
                        </div>
                    </div>
                </a>
            </div>
        </div> -->
    </section>

    <!-- Section About -->
    <section class="section-share">
        <div class="u-text-center u-margin-bottom-big">
            <h2 class="heading-primary">Share your ideas</h2>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio aliquid dolor iure aspernatur voluptatem omnis, sequi quos sapiente adipisci fugiat dolore aliquam qui esse ad at ut quaerat exercitationem perspiciatis accusantium! Vel vero esse sit?</p>

        <!-- Share Idea Form -->
        <form name="contact-form" class="idea-form" method="post" action="">
            <ul>
                <li>
                    <label for="contact-name">Name:</label>
                    <input type="text" name="contact-name" id="contact-name" required>
                </li>
                <li>
                    <label for="contact-email">Email:</label>
                    <input type="email" name="contact-email" id="contact-email" required>
                </li>
                <li>
                    <label for="contact-project">Idea:</label>
                    <textarea name="contact-project" id="contact-project" rows="10" required></textarea>
                </li>
            </ul>
            <button id="contact-submit" class="btn center" type="submit" name="contact-submit">Share it</button>
        </form>
        <!-- Share Idea Form / -->
    </section>

    <!-- Section Ideas -->
    <section class="section-ideas">
        <div class="u-text-center u-margin-bottom-big">
            <h2 class="heading-primary">Ideas for your project</h2>
        </div>

        <div class="row">
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
        </div>
    </section>
</main>


<?php include_once(SHARED_PATH . '/home_footer.php'); ?>