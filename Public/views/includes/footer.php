<?php
    use App\Boot\ForumConfiguration;
?>

    <footer>
        <div class="container" center>
            <div class="logo" center>
                <span>Heaven</span>
                <span>Community</span>
                <span center><?php echo ForumConfiguration::$forumTitle ?></span>
            </div>
        </div>
    </footer>
    <script src="assets/js/fontawesome.min.js"></script>
    <script src="assets/js/iziToast.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/default.js?t=<?php echo time() ?>"></script>
    </body>
</html>