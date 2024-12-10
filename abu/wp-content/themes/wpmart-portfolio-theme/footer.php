</div><!-- #content -->

<!-- Modal structure -->
<div id="imageModal" class="wpmart-pt-modal">
    <span class="wpmart-pt-close" onclick="closeModal()">&times;</span>
    <img class="wpmart-pt-modal-content" id="modalImage" alt="">
    <div id="caption"></div>
</div>

<footer id="colophon" class="site-footer">
    <div class="wpmart-pt-footer-main">
        <!-- Social Media Icons -->
        <?php if (get_theme_mod('wpmart_social_activate', true)): ?>
            <div class="wpmart-pt-footer-icon-wrapper">
                <?php if (get_theme_mod('wpmart_social_google')) : ?>
                    <span><a href="<?php echo esc_url(get_theme_mod('wpmart_social_google')); ?>" target="_blank"><i class="fa-brands fa-google"></i></a></span>
                    <span><a href="<?php echo esc_url(get_theme_mod('wpmart_social_pinterest')); ?>" target="_blank"><i class="fa-brands fa-pinterest"></i></a></span>
                    <span><a href="<?php echo esc_url(get_theme_mod('wpmart_social_linkedin')); ?>" target="_blank"><i class="fa-brands fa-linkedin"></i></a></span>
                    <span><a href="<?php echo esc_url(get_theme_mod('wpmart_social_twitter')); ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Footer Text -->
        <div class="wpmart-pt-custom-color-gray footer-font-size">
            <?php echo wp_kses_post(get_theme_mod('wpmart_footer_copyright_text', '&copy; 2023 Betheme by Muffin group | All Rights Reserved | Powered by WordPress')); ?>
        </div>

    </div>

    <!-- Footer Widgets -->
    <div class="footer-widgets">
        <?php if (is_active_sidebar('footer-1')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        <?php endif; ?>

        <?php if (is_active_sidebar('footer-2')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-2'); ?>
            </div>
        <?php endif; ?>

        <?php if (is_active_sidebar('footer-3')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-3'); ?>
            </div>
        <?php endif; ?>
    </div><!-- .footer-widgets -->

</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mobileMenuButton = document.getElementById("mobileMenuButton");
        const mobileMenu = document.getElementById("mobileMenu");
        
        mobileMenuButton.addEventListener("click", function() {
            if (mobileMenu.style.display === "block") {
                mobileMenu.style.display = "none";
            } else {
                mobileMenu.style.display = "block";
            }
        });
    });

    function openModal(imageSrc) {
        var modal = document.getElementById('imageModal');
        var modalImg = document.getElementById('modalImage');

        modalImg.src = imageSrc;
        modal.style.display = "flex";

        // To allow closing by clicking anywhere outside the image
        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        }
    }

    function closeModal() {
        var modal = document.getElementById('imageModal');
        modal.style.display = "none";
    }


</script>

</body>

</html>